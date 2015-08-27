<?php
/**
 * 店舗検索：検索エリア
 *
 */
include_once(dirname(__FILE__) . '/../common/Page.php');

class Store_areaPage extends Page{
	
	protected $id = 0;/* ID */
// 	protected $use_table   = 'reserved';
	protected $session_key = 'store_search';
	protected $use_confirm = false;
	protected $page_title = 'エリアから探す';
	
	protected $view = array(
			'index'     => 'stores/area',
	);
	
	/**
	 * 検索エリア
	 *
	 */
	public function indexAction(){
		$post = array();
		$error = array();
		$get_data = array();
		
		if (getGet('m') == 'search_keyword') {
			$get_data['category_large_id']  = getGet('category_large_id');
			$get_data['region_id']          = getGet('region_id');
			$get_data['keyword']            = getGet('keyword');
			$get_data['category_midium_id'] = getGet('category_midium_id');
			$get_data['category_small_ids'] = getGet('category_small_ids');
			$get_param = createLinkParam($get_data);
			redirect('/stores/search.php' . $get_param);
		} else if (getPost('m') == 'search_select') {
			$post = $_POST;
			$post['area_first_ids']  = is_array(getPost('area_first')) ? getPost('area_first') : array();
			$post['area_second_ids'] = is_array(getPost('area_second')) ? getPost('area_second') : array();
			$post['area_key_ids']    = is_array(getPost('area_third')) ? getPost('area_third') : array();
			// 入力チェック
			if ($this->selectValidation($post)) {
				$get_data['category_large_id']  = getPost('category_large_id');
				$get_data['region_id']          = getPost('region_id');
				$get_data['category_midium_id'] = getPost('category_midium_id');
				$get_data['category_small_ids'] = getPost('category_small_ids');
				$get_data['area_key_ids']       = implode(",", getPost('area_third'));
				$get_param = createLinkParam($get_data);
				redirect('/stores/search.php' . $get_param);
			}
			$error = $this->getValidationError();
		} else {
			$post = $get_data;
			$post['category_large_id']  = getGet('category_large_id');
			$post['region_id']          = getGet('region_id');
			$post['category_midium_id'] = getGet('category_midium_id');
			$post['category_small_ids'] = getGet('category_small_ids');
			$post['area_key_ids']       = getGet('area_key_ids');
		}
		
		// エリアごとの件数を取得する
		$areas = $this->manager->db_manager->get('store')->searchCountByCategory($post['category_large_id'], $post['category_midium_id'], $post['category_small_ids']);
		$areas = ($areas != null) ? $areas : array();
		$delivery = 0;
		if (count($areas) > 0) {
			$delivery = $areas[0]['delivery'];
		}
		
		$category_small_ids = (is_array($post['category_small_ids'])) ? $post['category_small_ids'] : explode(",", $post['category_small_ids']);
		$post['category_small_ids'] = implode(",", $category_small_ids);
		$post['area_key_ids']       = (is_array($post['area_key_ids'])) ? $post['area_key_ids'] : explode(",", $post['area_key_ids']);
		if (!isset($post['area_first_ids']) && !isset($post['area_second_ids'])) {
			// GETリクエストのみの場合
			$area_first_ids = array();
			$area_second_ids = array();
			foreach ($post['area_key_ids'] as $key => $area_third_id) {
				// エリアの第１階層目および第２階層目にチェックを
				// 入れる対象のリストを作成する
				// 例．
				//   第１階層目：11-22-33 ⇒ 11
				//   第２階層目：11-22-33 ⇒ 11-22
				$pieces = explode("-", $area_third_id);
				if (is_array($pieces)) {
					if (count($pieces) >= 2) {
						$area_second_ids[] = $pieces[0] . '-' . $pieces[1];
					}
					if (count($pieces) >= 1) {
						$area_first_ids[] = $pieces[0];
					}
				}
			}
			$post['area_first_ids']  = $area_first_ids;
			$post['area_second_ids'] = $area_second_ids;
		}
		
		$get_data['category_large_id']  = $post['category_large_id'];
		$get_data['region_id']          = $post['region_id'];
		if (!empty($post['category_large_id']) && !empty($post['category_large_id'])) {
			$research_param = createLinkParam($get_data);
		} else {
			$research_param = "";
		}
		$get_data['category_midium_id'] = $post['category_midium_id'];
		$get_data['category_small_ids'] = $post['category_small_ids'];
		$get_data['area_key_ids']       = implode(",", $post['area_key_ids']);
		$get_param = createLinkParam($get_data);
		
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['action_link'] = $get_param;
		$data['research_link'] = $research_param;
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
		$data['areas']    = $areas;
		$data['delivery'] = $delivery;
		$this->loadView('index', $data);
	}

	/**
	 * 入力値チェック
	 * 
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function selectValidation($param){
// 		$this->manager->validation->setRule('area_first', 'checked');
// 		$this->manager->validation->setRule('area_second', 'checked');
		$this->manager->validation->setRule('area_third', 'checked');
		return $this->manager->validation->run($param);
	}
}

