<?php
/**
 * 店舗検索：検索結果
 *
 */
include_once(dirname(__FILE__) . '/../common/Page.php');

class Store_searchPage extends Page{
	
	protected $id = 0;/* ID */
// 	protected $use_table   = 'reserved';
	protected $session_key = 'store_search';
	protected $use_confirm = false;
	protected $page_title = 'エリアから探す';
	
	protected $view = array(
			'index'     => 'stores/search',
	);
	
	/**
	 * 検索結果
	 *
	 */
	public function indexAction(){
		$post = array();
		$error = array();
		$get_data = array();
		
		if (getGet('m') == 'search_keyword') {
			$post = $_GET;
		} else {
			$post = $get_data;
			$post['category_large_id']  = getGet('category_large_id');
			$post['region_id']          = getGet('region_id');
			$post['category_midium_id'] = getGet('category_midium_id');
			$post['category_small_ids'] = getGet('category_small_ids');
			$post['area_key_ids']       = getGet('area_key_ids');
			$post['keyword']            = getGet('keyword');
		}
		
		$category_small_ids = (is_array($post['category_small_ids'])) ? $post['category_small_ids'] : explode(",", $post['category_small_ids']);
		$post['category_small_ids'] = implode(",", $category_small_ids);
		$area_key_ids               = (is_array($post['area_key_ids'])) ? $post['area_key_ids'] : explode(",", $post['area_key_ids']);
		$post['area_key_ids']       = implode(",", $area_key_ids);
		
		// 該当する条件の店舗を取得する
		$shops = $this->manager->db_manager->get('store')->shopListByCategoryAndAreaKeyIDs($post['category_large_id'], $post['category_midium_id'], $post['category_small_ids'], $area_key_ids, $post['keyword']);
		$shops = ($shops != null) ? $shops : array();
		
		// リンクパラメータを作成する
		$get_data['category_large_id']  = $post['category_large_id'];
		$get_data['region_id']          = $post['region_id'];
		$get_data['category_midium_id'] = $post['category_midium_id'];
		$get_data['category_small_ids'] = $post['category_small_ids'];
		$get_data['area_key_ids']       = $post['area_key_ids'];
		$get_back_param = createLinkParam($get_data);
		$get_data['keyword']            = $post['keyword'];
		$get_param = createLinkParam($get_data);
		
		// 条件変更のリンク先を決定する
		if ($get_data['region_id'] == "" || $get_data['category_large_id'] == "") {
			$back_link = '/';
		} else if ($get_data['category_small_ids'] == "" || $get_data['category_midium_id'] == "") {
			$back_link = '/stores/genre.php';
		} else if ($get_data['area_key_ids'] == "") {
			$back_link = '/stores/area.php';
		} else {
			$back_link = '/stores/area.php';
		}
		
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['action_link'] = $get_param;
		$data['get_back_param'] = $get_back_param;
		$data['condition_category_large_name']  = getParam(category_large(), $post['category_large_id']);
		$data['condition_redion_name']          = getParam(region_master(), $post['region_id']);
		$data['condition_category_midium_name'] = getParam(category_midium_for_customer($post['category_large_id'], $post['region_id']), $post['category_midium_id']);
		$small_names = array();
		foreach ($category_small_ids as $key => $small_id) {
			$record = $this->manager->db_manager->get('category_small')->findById($small_id);
			if ($record != null) {
				$small_names[] = $record['category_small_name'];
			}
		}
		$data['condition_category_small_names'] = $small_names;
		$area_key_names = array();
		foreach ($area_key_ids as $key => $area_key_id) {
			// 第３階層から第１階層の順で有効なエリア名を取得する
			$pieces = explode("-", $area_key_id);
			$area_first_id  = (isset($pieces[0])) ? $pieces[0] : "0";
			$area_second_id = (isset($pieces[1])) ? $pieces[1] : "0";
			$area_third_id  = (isset($pieces[2])) ? $pieces[2] : "0";
			$area123name = $this->manager->db_manager->get('area_third')->area123name($area_first_id, $area_second_id, $area_third_id);
			if (isset($area123name['area_third_name']) && $area123name['area_third_name'] != "") {
				$area_key_names[] = $area123name['area_third_name'];
			} else if (isset($area123name['area_second_name']) && $area123name['area_second_name'] != "") {
				$area_key_names[] = $area123name['area_second_name'];
			} else if (isset($area123name['area_first_name']) && $area123name['area_first_name'] != "") {
				$area_key_names[] = $area123name['area_first_name'];
			}
		}
		$data['area_key_names'] = $area_key_names;
		$data['area_names']     = $small_names;
		$data['back_link']      = $back_link;
		$data['list']           = $shops;
		$this->loadView('index', $data);
	}

	/**
	 * 予約情報入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function selectValidation($param){
// 		$this->manager->validation->setRule('contract', 'checked');
		return $this->manager->validation->run($param);
	}
}

