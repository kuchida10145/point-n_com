<?php
/***
 * ベースページクラス
 *
 */
include_once dirname(__FILE__).'/../../system/Management.php';

abstract class Page{

	/** @var Management */
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
	
	/*アカウントデータ*/
	protected $account_data = NULL;


	public function __construct(){
		/* @var Management */
		$this->manager = Management::getInstance();
		$this->manager->setHelper('data');
		$this->manager->setHelper('validation');
		//$this->device = $this->manager->device->getDevice();
		$this->device = 'sp';
		$this->checkLogin();
	}
	
	public function errorAction(){
		$this->errorPage();
	}

	/**
	 * エラーが発生した場合の表示画面
	 *
	 */
	protected function errorPage(){
		$this->view['error'] = '404';
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
		if($this->account_type == 'user'){
			//ポイントコード処理
			$data['point_code_flg'] = false;
			if($data['account']){
				$point_codes = $this->manager->db_manager->get('reserved')->getMyPointCodeList($data['account']['user_id']);
				if($point_codes){
					$data['point_code_flg']  = true;
				}
				
			}
		}
		
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
		
		if($this->account_data == NULL){
			if(isset($_SESSION[$this->account_type]['_account']) && is_array($_SESSION[$this->account_type]['_account'])){
				
				//会員のデータの場合
				if($this->account_type == 'user'){
					$data = $_SESSION[$this->account_type]['_account'];
					if($user = $this->manager->db_manager->get('user')->getActiveUserById($data['user_id'])){
						$result = array_merge($data, $user);
						$_SESSION[$this->account_type]['_account'] = $result;
					}
					else{
						$this->account_data = NULL;
						unset($_SESSION[$this->account_type]['_account']);
					}
				}
				$this->account_data = $_SESSION[$this->account_type]['_account'];
			}
		}
		
	
		return $this->account_data;
	}

	/**
	 * DBアカウント情報を確認
	 *
	 * @return array $account
	 */
	protected function checkDBAccount(){
		return true;
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




	protected function getAccountTable(){
		switch($this->account_type){
			case 'user':
				$account_table = 'user';
				break ;
			case 'admin':
				$account_table = 'account';
				break ;
			case 'maintenance':
				$account_table = 'store';
				break ;
		}
		
		return $account_table;
	}
	
	
	
	
	
	
	

	/**
	 * 自動ログイン処理
	 * @return boolean
	 */
	protected function autoLogin(){
		if($account = $this->getAccount()){
			return true;
		}

		$account_table = $this->getAccountTable();
		//自動ログイン用テーブル
		$auto_table = "autologin_{$account_table}";
		//プライマリーキー取得
		$primary_key = $primary_key = $this->manager->db_manager->get($account_table)->primary_key;

		//クッキー処理
		$this->manager->setCore('cookie');
		$cookie = $this->manager->cookie->get($auto_table);
		if(!$cookie){
			return false;
		}
		$cookies = explode(':',$cookie);

		//自動ログインテーブル検索
		if(!($auto_res = $this->manager->db_manager->get($auto_table)->chek_data($cookies[0],$cookies[1]))){
			//クッキー削除
			$this->manager->cookie->delete($auto_table);
			return false;
		}

		//対象のアカウントテーブル検索
		if(!($account_res = $this->manager->db_manager->get($account_table)->findById($auto_res[$primary_key]))){
			return false;
		}


		//セッションに保存
		$this->setAccount($account_res);

		//自動ログイン更新
		if(!($new_auto = $this->manager->db_manager->get($auto_table)->updateById($auto_res[$auto_table."_id"],array()))){
			return false;
		}

		//クッキーに保存
		$new_cookie = $new_auto[$auto_table."_id"].":".$new_auto['login_key'];
		$this->manager->cookie->set($auto_table,$new_cookie,time()+(3600*24*30));

		return true;
	}
	
	
	
	protected function saveIdPw($id,$pw,$auto_flg){
		$account_table = $this->getAccountTable();
		
		//自動ログイン用テーブル
		$auto_table = "idpw_{$account_table}";
		
		//クッキー処理
		$this->manager->setCore('cookie');
		if($auto_flg != 1){
			$this->manager->cookie->delete($auto_table);
			return true;
		}
		
		$id = encodePassword($id);
		$pw = encodePassword($pw);

		
		//クッキーに保存
		//$new_cookie = $id.":".$pw;//print $new_cookie;
		
		$new_cookie=json_encode(array('id'=>$id,'pw'=>$pw));
		$this->manager->cookie->set($auto_table,$new_cookie,time()+(3600*24*30));
		//print_r($_COOKIE);
		return true;
	}
	
	protected function getIdPw(){
		$account_table = $this->getAccountTable();
		
		//自動ログイン用テーブル
		$auto_table = "idpw_{$account_table}";
		
		//クッキー処理
		$this->manager->setCore('cookie');
		
		$data = $this->manager->cookie->get($auto_table);
		if(!$data){
			return array();
		}
		$data = json_decode($data,true);
		$data['id'] = decodePassword($data['id']);
		$data['pw'] = decodePassword($data['pw']);
		return $data;
	}


	/**
	 * 自動ログイン設定
	 *
	 * @param int $pw パスワード
	 * @param int $auto_flg 自動ログインフラグ 0:しない 1:する
	 * @return boolean
	 */
	protected function setPassword($pw,$auto_flg){
		

		$account_table = $this->getAccountTable();
		
		//自動ログイン用テーブル
		$auto_table = "pw_{$account_table}";
		
		//クッキー処理
		$this->manager->setCore('cookie');
		if($auto_flg != 1){
			$this->manager->cookie->delete($auto_table);
			return true;
		}
		
		
		
		

		
		
		//クッキーに保存
		$new_cookie = $pw;
		$this->manager->cookie->set($auto_table,$new_cookie,time()+(3600*24*30));
		return true;
	}
	
	
	/**
	 * 自動ログイン設定
	 *
	 * @param int $id 主キー
	 * @param int $auto_flg 自動ログインフラグ 0:しない 1:する
	 * @return boolean
	 */
	protected function setAutoLogin($id,$auto_flg){

		if($auto_flg != 1){
			return true;
		}

		$account_table = $this->getAccountTable();
		
		//自動ログイン用テーブル
		$auto_table = "autologin_{$account_table}";
		//プライマリーキー取得
		$primary_key = $primary_key = $this->manager->db_manager->get($account_table)->primary_key;

		//クッキー処理
		$this->manager->setCore('cookie');


		//自動ログイン挿入
		$new_auto = $this->manager->db_manager->get($auto_table)->insert(array($primary_key=>$id));

		//クッキーに保存
		$new_cookie = $new_auto[$auto_table."_id"].":".$new_auto['login_key'];
		$this->manager->cookie->set($auto_table,$new_cookie,time()+(3600*24*30));
		return true;
	}

	
	/**
	 * 自動ログイン削除
	 * 
	 * @param int $id 主キー
	 * @return boolean
	 */
	protected function unsetAutoLogin($id){
		
		
		$account_table = $this->getAccountTable();
		
		
		//クッキー処理
		$this->manager->setCore('cookie');
		
		//自動ログイン用テーブル
		$auto_table = "autologin_{$account_table}";
		
		
		//自動ログイン削除
		$this->manager->db_manager->get($auto_table)->deleteAutoLogin($id);
		
		//クッキーを削除
		$this->manager->cookie->delete($auto_table);
		return true;
	}
	
	
	/**
	 * ログインされているかチェック
	 *
	 * @return bool
	 */
	protected function checkLogin(){
		//$this->autoLogin();
		$account = $this->getAccount();
		if(!$account){
			return false;
		}
		return true;
	}
}