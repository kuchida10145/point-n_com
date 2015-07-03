<?php
/**
 * 店舗検索：検索ジャンル
 *
 */
include_once(dirname(__FILE__) . '/../common/Page.php');

class Store_genrePage extends Page{

	protected $id = 0;/* ID */
// 	protected $use_table   = 'reserved';
	protected $session_key = 'store_search';
	protected $use_confirm = false;
	protected $page_title = '店舗を探す';

	protected $view = array(
			'index'    => 'stores/genre',
	);

	/**
	 * 検索ジャンル
	 *
	 */
	public function indexAction(){
		$post = array();
		$error = array();
		$get_data = array();
		
		if (getGet('m') == 'search_keyword') {
			$get_data['category_large_id'] = getGet('category_large_id');
			$get_data['region_id']         = getGet('region_id');
			$get_data['keyword']           = getGet('keyword');
			$get_param = createLinkParam($get_data);
			redirect('/stores/search.php' . $get_param);
		} else if (getPost('m') == 'search_select') {
			$post = $_POST;
			$post['area_first_ids']  = is_array(getPost('area_first')) ? getPost('area_first') : array();
			$post['area_second_ids'] = is_array(getPost('area_second')) ? getPost('area_second') : array();
			$post['area_key_ids'] = getGet('area_key_ids');
			// 入力チェック
			if ($this->selectValidation($post)) {
				$get_data['category_large_id']  = getPost('category_large_id');
				$get_data['region_id']          = getPost('region_id');
				$get_data['category_midium_id'] = getPost('category_midium_id');
				$get_data['category_small_ids'] = implode(",", getPost('category_small_ids'));
				$get_data['area_key_ids']       = $post['area_key_ids'];
				$get_param = createLinkParam($get_data);
				redirect('/stores/area.php' . $get_param);
			}
			$error = $this->getValidationError();
		} else {
			$post = $get_data;
			$post['category_large_id']  = getGet('category_large_id');
			$post['region_id']          = getGet('region_id');
			$post['category_midium_id'] = getGet('category_midium_id');
			$post['category_small_ids'] = explode(",", getGet('category_small_ids'));
			$post['area_key_ids']       = getGet('area_key_ids');
		}
		
		$category_midium_ids = array();
		$category_small_ids  = array();
		foreach (category_midium_for_customer($post['category_large_id'], $post['region_id']) as $val_key => $val_name) {
			$category_midium_ids[] = $val_key;
			foreach (category_small_for_customer($val_key) as $val_key2 => $val_name2) {
				$category_small_ids[] = $val_key2;
			}
		}
		$category_midium_ids_for_delivery = array();
		$delivery = 1;
		foreach (category_midium_for_customer($post['category_large_id'], $post['region_id'], $delivery) as $val_key => $val_name) {
			$category_midium_ids_for_delivery[] = $val_key;
		}
		
		$get_data['category_large_id']  = $post['category_large_id'];
		$get_data['region_id']          = $post['region_id'];
		$get_data['category_midium_id'] = $post['category_midium_id'];
		$get_data['category_small_ids'] = is_array(getParam($post,'category_small_ids')) ? implode(",", $post['category_small_ids']) : getParam($post,'category_small_ids');
		$get_data['area_key_ids']       = $post['area_key_ids'];
		$get_param = createLinkParam($get_data);
		
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['action_link'] = $get_param;
		$data['category_midium_ids'] = $category_midium_ids;
		$data['category_small_ids']  = $category_small_ids;
		$data['category_midium_ids_for_delivery'] = $category_midium_ids_for_delivery;
		$data['condition_category_large_name']  = getParam(category_large(), $post['category_large_id']);
		$data['condition_redion_name']          = getParam(region_master(), $post['region_id']);
		$data['condition_category_midium_name'] = "";
		$data['condition_category_small_names'] = array();
		$this->loadView('index', $data);
	}
	
	/**
	 * 入力値チェック
	 * 
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function selectValidation($param) {
		$this->manager->validation->setRule('category_midium_id', 'selected');
		if (isset($param['category_midium_id']) && count(category_small_for_customer($param['category_midium_id'])) > 0) {
			$this->manager->validation->setRule('category_small_ids', 'selected');
		}
		return $this->manager->validation->run($param);
	}
}

