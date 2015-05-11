<?php
/**
 * 管理画面TOP
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class IndexPage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table = 'index';
	protected $token     = '';
	protected $use_confirm = true;
	protected $page_title = '';
	protected $page_type_text = '';
	protected $page_cnt = 20;//一ページに表示するデータ数
	protected $account = NULL;



	/**
	 * ビューテンプレートの設定
	 *
	 */
	protected function setView(){
		$this->view = array(
				'index' =>'maintenance/index',
				'login' =>'maintenance/login',
		);
	}

	/**
	 * ビューテンプレートの設定
	 *
	 */
	public function run(){
		$get = $_GET;
		$mode   = getGet('m','index');
		$method = getGet('m','index').'Action';
		$this->setView();


		//ログインチェック
		if($this->checkLogin() == false){
			//すべてのセッションを削除
			$method = 'loginAction';
		}
		//ログイン済みなのにログイン画面を指定していた時
		else if($this->checkLogin() == true && $method == 'loginAction'){
			redirect('index.php');
		}


		//関数が存在する場合
		if(method_exists($this,$method)){

			switch($mode){
				//一覧画面
				case 'index':
					$this->page_type_text = '';
					break;

					//編集ページの場合
			}
			$this->{$method}();
		}
		else{
			$this->errorPage();
		}

	}



	protected function indexAction(){
		$this->loadView('index', array());
	}



	/**
	 * ログイン画面
	 *
	 */
	protected function loginAction(){
		$system_message = array();
		$error = array();
		if(getPost('m') == 'login'){

			//入力検証
			if($this->loginValidation($_POST)){
				//ログイン処理
				if($res = $this->manager->db_manager->get('store')->login(getPost('login_id'),getPost('login_password'))){
					$this->setAccount($res);
					redirect('index.php');
					exit();
				}
				else{
					$system_message = $this->manager->message->get('system')->getMessage('login_error');
				}
			}else{
				$error = $this->getValidationError();
			}
		}

		$data['system_message'] = $system_message;
		$data['error'] = $error;
		$this->loadView('login', $data);
	}

	/**
	 * ログアウト処理
	 *
	 */
	protected function logoutAction(){
		$this->clearAccountSession();
		redirect('index.php');
	}




	/**
	 * ログインデータ検証
	 *
	 */
	protected function loginValidation($param){
		$this->manager->validation->setRule('login_id', 'required');
		$this->manager->validation->setRule('login_password', 'required');
		return $this->manager->validation->run($param);
	}

}