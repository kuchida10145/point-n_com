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
	public function indexAction(){
		if(!$informations = $this->manager->db_manager->get('information')->getTopInformation()){
			$informations = array();
		}
		$data = array();
		$data['informations'] = escapeHtml($informations);
		$this->loadView('index', $data);
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