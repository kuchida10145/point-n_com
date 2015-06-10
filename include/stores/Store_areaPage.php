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
		$this->token = getGet('tkn');
		
		// トークンが設定されていない場合
		if ($this->token == '') {
			$this->token = $this->manager->token->createToken($this->session_key);
			redirect('/?tkn=' . $this->token);
			exit();
		}
		
		$get_data = array('tkn' => $this->token);
		if (getPost('m') == 'search_select') {
			$post = $_POST;
// echo '<pre>' . "\n";
// var_dump($post);
// echo '</pre>' . "\n";
// exit;
			// 入力チェック
			if ($this->selectValidation($post)) {
				$get_data['category_large_id'] = getPost('category_large_id');
				$get_data['region_id']         = getPost('region_id');
				$get_data['category_midium_id'] = getPost('category_midium_id');
				$get_data['category_small_ids'] = implode(",", getPost('category_small_ids'));
				$get_param = createLinkParam($get_data);
				redirect('/stores/search.php' . $get_param);
			}
			$error = $this->getValidationError();
		} else {
			$post = $get_data;
			$post['category_large_id'] = getGet('category_large_id');
			$post['region_id']         = getGet('region_id');
			$post['category_midium_id'] = getGet('category_midium_id');
			$post['category_small_ids'] = explode(",", getGet('category_small_ids'));
		}
		
		$areas = $this->manager->db_manager->get('store')->searchCountByCategory($post['category_large_id'], $post['category_midium_id'], $post['category_small_ids']);
		$areas = ($areas != null) ? $areas : array();
		
		$get_data['category_large_id']  = $post['category_large_id'];
		$get_data['region_id']          = $post['region_id'];
		$get_data['category_midium_id'] = $post['category_midium_id'];
		$get_data['category_small_ids'] = implode(",", $post['category_small_ids']);
		$get_param = createLinkParam($get_data);
		
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['action_link'] = $get_param;
		$data['condition_category_large_name']  = getParam(category_large(), $post['category_large_id']);
		$data['condition_redion_name']          = getParam(region_master(), $post['region_id']);
		$data['condition_category_midium_name'] = getParam(category_midium_for_customer($post['category_large_id'], $post['region_id']), $post['category_midium_id']);
		$small_names = array();
		foreach ($post['category_small_ids'] as $key => $small_id) {
			$record = $this->manager->db_manager->get('category_small')->findById($small_id);
			if ($record != null) {
				$small_names[] = $record['category_small_name'];
			}
		}
		$data['condition_category_small_names'] = $small_names;
		$data['areas'] = $areas;
		$this->loadView('index', $data);
	}

	/**
	 * 入力値チェック
	 * 
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function selectValidation($param){
// 		$this->manager->validation->setRule('contract', 'checked');
		return $this->manager->validation->run($param);
	}
}

