<?php
/**
 * TOP
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class IndexPage extends Page{




	protected $view = array(
			'index' =>'index',
			'login' =>'login'
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
		//if($this->getAccount()){
		//	redirect('/');
		//}
		
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
	 * ログイン用バリデーション
	 */
	private function loginValidation($param){
		$this->manager->validation->setRule('email'         ,'required');
		$this->manager->validation->setRule('password'      ,'required');
		return $this->manager->validation->run($param);
	}


}