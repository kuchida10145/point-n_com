<?php
/**
 * TOP
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class IndexPage extends Page{




	protected $view = array(
			'index' =>'index',
			'login' =>'login',
			'logout' =>'mypage/logout',
	);


	/**
	 * TOPページ
	 *
	 */
	public function indexAction() {
		$post = array();
		$error = array();
		$get_data = array();
		
		if (getGet('m') == 'search_keyword') {
			$get_data['keyword'] = getGet('keyword');
			$get_param = createLinkParam($get_data);
			redirect('/stores/search.php' . $get_param);
		} else if (getPost('m') == 'search_select') {
			$post = $_POST;
			// 入力チェック
			if ($this->selectValidation($post)) {
				$get_data['category_large_id']  = getPost('category_large_id');
				$get_data['region_id']          = getPost('region_id');
				$get_data['category_midium_id'] = getPost('category_midium_id');
				$get_data['category_small_ids'] = getPost('category_small_ids');
				$get_data['area_key_ids']       = getPost('area_key_ids');
				$get_param = createLinkParam($get_data);
				redirect('/stores/genre.php' . $get_param);
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
		
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$this->loadView('index', $data);
	}
	
	/**
	 * TOPページ用バリデーション
	 */
	private function selectValidation($param) {
		$this->manager->validation->setRule('category_large_id', 'selected');
		$this->manager->validation->setRule('region_id',         'selected');
		return $this->manager->validation->run($param);
	}
	
	/**
	 * ログイン画面
	 * 
	 */
	public function loginAction(){
		$system_message = '';
		$post  = array();
		$error = array();
		
		
		
		
		//既にログイン済みの場合
		if($this->getAccount()){
			redirect('/');
		}
		
		if(getPost('m') == 'login'){
			$post= $_POST;
			//入力チェック
			if($this->loginValidation($_POST)){
				//データの存在チェック＋ログイン処理
				if($res = $this->manager->db_manager->get('user')->login($post['email'],$post['password'])){
					$this->setAccount($res);
					$this->setAutoLogin($res['user_id'],getPost('auto_login'));
					redirect('/');
				}
			}
			
			//入力チェックエラー時
			//エラーシステムメッセージ取得
			$system_message = $this->manager->message->get('front_'.$this->device)->getMessage('login_error');
		}
		
		$data = array();
		$data['system_message'] = $system_message;
		$data['post'] = escapeHtml($post);
		$this->loadView('login', $data);
	}
	
	
	/**
	 * ログアウト画面
	 * 
	 */
	public function logoutAction(){
		$system_message = '';
		
		//ログインしていない場合
		if(!($account = $this->getAccount())){
			redirect('/login.php');
		}
		
		//ログアウト処理
		$this->unsetAutoLogin($account['user_id']);
		$this->clearAccountSession();
		
		
		$this->loadView('logout', array());
	}

	
	
	/**
	 * ログイン用バリデーション
	 */
	private function loginValidation($param){
		$this->manager->validation->setRule('email'         ,'required');
		$this->manager->validation->setRule('password'      ,'required');
		return $this->manager->validation->run($param);
	}


}