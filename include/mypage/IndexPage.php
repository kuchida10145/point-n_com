<?php
/**
 * マイページTOP
 *
 */
include_once dirname(__FILE__).'/../Page.php';

class IndexPage extends Page{




	protected $view = array(
			'index' =>'mypage/index',
			'login' =>'mypage/login'
	);


	/**
	 * TOPページ
	 *
	 */
	public function indexAction(){
		if($this->getAccount() == NULL){
			redirect('login.html');
		}

		//既にログイン済みの場合
		if(getGet('m') == 'logout'){
			$this->clearAccountSession();
			redirect('login.html');
		}

		$data = array();
		$this->loadView('index', $data);

	}



	/**
	 * ログインページ
	 *
	 */
	public function loginAction(){

		$error = array();
		$system_message = '';


		//既にログイン済みの場合
		if($this->getAccount() != NULL){
			redirect('index.html');
		}

		//ログイン処理
		if(getPost('m') == 'login'){

			if($this->loginValidation($_POST)){
				if($res = $this->manager->db_manager->get('user')->login(getPost('email'),getPost('login_pw'))){
					$this->setAccount($res);
					$this->setAutoLogin($res['user_id'],getPost('auto_login'));
					redirect('index.html');
				}
				$system_message =$this->manager->message->get('front')->getMessage('edit_error');
			}
			$error = $this->getValidationError();
		}

		$data = array();
		$data['error'] = $error;
		$data['system_message'] = $system_message;
		$this->loadView('login', $data);
	}



	/**
	 * ログイン入力チェック
	 *
	 * @param array $param
	 * @return boolean
	 */
	protected function loginValidation($param){
		$this->manager->validation->setRule('email'    ,'required');
		$this->manager->validation->setRule('login_pw' ,'required');
		return $this->manager->validation->run($param);
	}
}