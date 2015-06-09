<?php
/**
 * 店舗検索：検索ジャンル
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
	 * 検索ジャンル
	 *
	 */
	public function indexAction(){
		$post = array();
		$error = array();
		$this->token = getGet('tkn');
		
		// トークンが設定されていない場合
		if ($this->token == '') {
			$this->token = $this->manager->token->createToken($this->session_key);
			redirect('?tkn=' . $this->token);
			exit();
		}
		
		$get_data = array('tkn' => $this->token);
/*
		if (getPost('m') == 'search_select') {
			$post = $_POST;
			// 入力チェック
			if ($this->selectValidation($post)) {
				$get_data['category_large_id'] = getPost('category_large_id');
				$get_data['region_id'] = getPost('region_id');
				$get_param = createLinkParam($get_data);
				redirect('/stores/search.php' . $get_param);
			}
			$error = $this->getValidationError();
		} else {
			$post = $get_data;
			$post['category_large_id'] = getGet('category_large_id');
			$post['region_id']         = getGet('region_id');
		}
//*/
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
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

