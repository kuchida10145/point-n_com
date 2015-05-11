<?php
/***
 * ベースページクラス
 *
 */
include_once dirname(__FILE__).'/../../system/Management.php';

abstract class Page{

	/* @var Management */
	protected $manager   = NULL;

	/* デバイス pc,sp*/
	protected $device = '';

	/* トークン（フォームセッションに利用） */
	protected $token = '';

	/* セッションキー（フォームセッションに利用） */
	protected $session_key = '';

	/*フォームトークン*/
	protected $form_tokens = array();


	protected  $account_type = 'user';


	public function __construct(){
		/* @var Management */
		$this->manager = Management::getInstance();
		$this->manager->setHelper('data');
		$this->manager->setHelper('validation');
		$this->device = $this->manager->device->getDevice();

	}

	/**
	 * エラーが発生した場合の表示画面
	 *
	 */
	protected function errorPage(){
		$this->view['error'] = 'error';
		$this->loadView('error', array());
	}



	/**
	 * テンプレートをロード
	 *
	 * @param string $template テンプレート
	 * @param array $data テンプレートで読みこむデータ
	 */
	protected function loadView($template,$data){
		$data['account'] = $this->getAccount();
		$this->manager->view->loadView($this->device.'/'.$this->view[$template],$data,true);
		exit();
	}


	/**
	 * トークンエラーが発生した場合の表示画面
	 *
	 */
	protected function tokenErrorPage(){
		$this->loadView('token_error', array());
	}

	/**
	 * 入力チェックエラーのデータを取得
	 *
	 * @return array
	 */
	protected function getValidationError(){
		$this->manager->validation->getError();
		$message = $this->manager->message->get('error')->getMessages();
		$error   = $this->manager->validation->getErrorMessage($message);

		foreach($error as $key => $val){
			$error[$key] = $this->setErrorTag($val);
		}
		return $error;
	}


	/**
	 * エラーメッセージのタグ設定
	 *
	 * @param string $str タグで囲むエラー文字
	 * @return string
	 */
	protected function setErrorTag($str){
		return '<br /><span class="clrred">'.$str.'</span>';
	}




	/**
	 * フォームセッションにデータを保存
	 *
	 * @param string $key 保存するデータのキー
	 * @param mixed $param 保存するデータ
	 */
	protected function setFormSession($key,$param){
		if($this->session_key == ''){
			exit('$this->session_keyを設定してください');
		}
		$_SESSION[$this->account_type][$this->session_key][$this->token][$key] = $param;
	}



	/**
	 * 保存されたフォームセッションのデータを取得
	 *
	 * @param string $key 保存されているデータのキー
	 * @return mixed
	 */
	protected function getFormSession($key){
		if($this->session_key == ''){
			exit('$this->session_keyを設定してください');
		}
		if(isset($_SESSION[$this->account_type][$this->session_key][$this->token][$key])){
			return $_SESSION[$this->account_type][$this->session_key][$this->token][$key];
		}
		return NULL;
	}


	/**
	 * 保存されたフォームセッションのデータを削除
	 *
	 * @param string $key 保存されているデータのキー
	 * @return mixed
	 */
	protected function unsetFormSession($key){
		if($this->session_key == ''){
			exit('$this->session_keyを設定してください');
		}
		if(isset($_SESSION[$this->account_type][$this->session_key][$this->token][$key])){
			unset($_SESSION[$this->account_type][$this->session_key][$this->token][$key]);
		}
	}


	/**
	 * アカウント情報を設定
	 *
	 * @param array $account
	 */
	protected function setAccount($account){
		$_SESSION[$this->account_type]['_account'] = $account;
	}

	/**
	 * アカウント情報を取得
	 *
	 * @return array $account
	 */
	protected function getAccount(){
		if(isset($_SESSION[$this->account_type]['_account']) && is_array($_SESSION[$this->account_type]['_account'])){
			return $_SESSION[$this->account_type]['_account'];
		}
		return NULL;
	}


	/**
	 * アカウントのすべてのセッションデータを削除
	 *
	 */
	protected function clearAccountSession(){

		//フォームセッションを削除
		if(isset($_SESSION['csrf'])){
			foreach($_SESSION['csrf'] as $csrf_key => $val){
				if(strpos($csrf_key, $this->account_type.'_')===0){
					unset($_SESSION['csrf'][$csrf_key]);
				}
			}
		}

		//セッション
		unset($_SESSION[$this->account_type]);


	}


	/**
	 * システムメッセージ取得
	 *
	 * @return string
	 */
	protected function getSystemMessage(){
		if(isset($_SESSION[$this->account_type]['system_message'])){
			return $_SESSION[$this->account_type]['system_message'];
		}
		return '';
	}

	/**
	 * システムメッセージ設定
	 *
	 * @param string $message メッセージ
	 */
	protected function setSystemMessage($message){
		$_SESSION[$this->account_type]['system_message'] = $message;
	}

	/**
	 * システムメッセージ削除
	 *
	 */
	protected function unsetSystemMessage(){
		if(isset($_SESSION[$this->account_type]['system_message'])){
			unset($_SESSION[$this->account_type]['system_message']);
		}
	}


	/**
	 * フォームトークン生成（追加
	 *
	 * @return string 生成したトークン
	 */
	protected function createFormToken(){
		$this->token = $this->manager->token->createToken($this->account_type.'_'.$this->session_key);


		return $this->token;
	}
}