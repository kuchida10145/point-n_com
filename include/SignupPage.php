<?php
/**
 * 会員情報登録
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class SignupPage extends Page{


	protected $session_key = 'signup';


	protected $view = array(
			'index'           =>'signup/index',
			'send'            =>'signup/send',
			'regist'          =>'signup/regist',
			'regist_confirm'  =>'signup/regist_confirm',
			'thanks'          =>'signup/thanks',
			'timeout'         =>'signup/timeout',
	);


	/**
	 * メールアドレス入力
	 *
	 */
	public function indexAction(){

		$data = array();
		$post = array();
		$error = array();
		if(getPost('m') == 'signup'){
			$post = $_POST;
			//入力チェック
			if($this->signupValidation($post)){
				$ins_data['email'] = $post['email'];
				$ins_data['status_id'] = USER_ST_REQ;
				
				$user_id = false;
				//仮登録済みのものがある場合は、更新処理
				if(($already_user = $this->manager->db_manager->get('user')->findByEmail($ins_data['email'])) && $already_user['status_id'] == USER_ST_REQ){
					if($already_user['status_id'] == USER_ST_REQ){
						$user_id = $already_user['user_id'];
					}
				}
				//新規登録
				else{
					$user_id = $this->manager->db_manager->get('user')->insert($ins_data);
				}
				
				
				
				if($user_id !== false){
					$hash_data = $this->manager->db_manager->get('user_hash')->createSingup($user_id);

					//仮登録
					$mail_id = 1;
					$mail = $this->manager->db_manager->get('automail')->findById($mail_id);
					//メール用データ
					$mail_data['signup_edit_url'] =HTTP_HOST."/signup/regist.php?keycode=".$hash_data['hash'];
					$mail_data['signup_url']      =HTTP_HOST."/signup/";
					$mail_data['email']           =$ins_data['email'];
					$mail = create_mail_data($mail,$mail_data);
					$mail['to'] = $ins_data['email'];
					$this->manager->mailer->setMailData($mail);
					$this->manager->mailer->sendMail();
					redirect( '/signup/send.php');
				}
			}
			$error = $this->getValidationError();
		}



		//表示用データ設定
		$data['post'] = escapeHtml($post);
		$data['error']= $error;
		$this->loadView('index', $data);
	}


	/**
	 * メール送信完了（仮登録完了）
	 *
	 */
	public function sendAction(){
		$data = array();
		$this->loadView('send', $data);
	}


	/**
	 * 会員情報入力
	 *
	 */
	public function registAction(){

		$data = array();
		$post = array();
		$error = array();

		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$hash_code = getGet('keycode');

			$hash_data = $this->manager->db_manager->get('user_hash')->findByHash($hash_code);

			//有効期限切れ
			if(time() > strtotime($hash_data['limit_date'])){
				$this->timeoutAction();
				exit();
			}

			$user = $this->manager->db_manager->get('user')->findById($hash_data['user_id']);

			$this->token = $this->manager->token->createToken($this->session_key);

			$this->setFormSession('user_id', $user['user_id']);

			redirect('regist.php?tkn='.$this->token);
			exit();
		}

		$this->token = getGet('tkn');
		$user_id = $this->getFormSession('user_id');

		if($user_id == '' || !($user = $this->manager->db_manager->get('user')->findById($user_id))){
			$this->errorPage();
			exit();
		}

		//状況が仮登録以外の場合
		if($user['status_id'] != USER_ST_REQ){
			exit('既に登録済みです。');
		}




		if(getPost('m') == 'regist_confirm'){
			$post = $_POST;
			if($this->validation($post)){
				$form_data = array(
					'nickname' => $post['nickname'],
					'birth-year' => $post['birth-year'],
					'birth-month' => $post['birth-month'],
					'birth-day' => $post['birth-day'],
					'birthday' => $post['birth-year'] . '-' . $post['birth-month'] . '-' . $post['birth-day'],
					'gender' => $post['gender'],
					'prefectures_id' => $post['prefectures_id'],
					'password' => $post['password'],
				);

				$this->setFormSession('form', $form_data);
				redirect('regist_confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		}
		else{
			$post = $this->getFormSession('form');
		}



		$data['user'] = $user;
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$this->loadView('regist', $data);
	}


	/**
	 * 会員情報確認
	 *
	 */
	public function regist_confirmAction(){
		$data = array();
		$this->token = getGet('tkn');

	//	$this->loadView('regist_confirm', array());
//		exit();
		
		$user_id = $this->getFormSession('user_id');

		if($user_id == '' || !($user = $this->manager->db_manager->get('user')->findById($user_id))){
			$this->errorPage();
			exit();
		}
		//状況が仮登録以外の場合
		if($user['status_id'] != USER_ST_REQ){
			exit('既に登録済みです。');
		}


		$form_data = $this->getFormSession('form');
		if(!$form_data || $this->validation($form_data) == false){
			$this->errorPage();
			exit();
		}


		//登録ボタンが押された場合
		if(getPost('m') == 'thanks'){

			$upd_data = $form_data;
			$upd_data['password'] = encodePassword($upd_data['password']);
			$upd_data['status_id'] = USER_ST_ACT;

			//更新
			$this->manager->db_manager->get('user')->updateById($user_id,$upd_data);

			//フォームセッション削除
			$this->unsetFormSession('form');
			$this->unsetFormSession('user_id');

			//ハッシュ削除
			$this->manager->db_manager->get('user_hash')->deleteSignup($user_id);

			//登録完了メール
			$mail_id = 2;
			$mail = $this->manager->db_manager->get('automail')->findById($mail_id);
			//メール用データ
			$mail_data['nickname'] =$form_data['nickname'];
			$mail = create_mail_data($mail,$mail_data);
			$mail['to'] = $user['email'];
			$this->manager->mailer->setMailData($mail);
			$this->manager->mailer->sendMail();
			redirect('thanks.php');
		}

		$data['post']  = escapeHtml($form_data);
		$data['email'] = $user['email'];

		$this->loadView('regist_confirm', $data);
	}


	/**
	 * 会員情報完了
	 *
	 */
	public function thanksAction(){
		$data = array();
		$this->loadView('thanks', $data);
	}

	/**
	 * 時間切れ画面
	 *
	 */
	public function timeoutAction(){
		$data = array();
		$this->loadView('timeout', $data);
	}



	/**
	 * 仮登録入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function signupValidation($param){
		$this->manager->validation->setRule('email','required|email|duplicate_email');
		$this->manager->validation->setRule('contract','checked');
		return $this->manager->validation->run($param);
	}


	/**
	 * 登録入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function validation($param){
		
		$param['birthday'] = '';
		$this->manager->validation->setRule('nickname','required|duplicate_user_nickname');
		if ( $param['birth-year'] == '' || $param['birth-month'] == '' || $param['birth-day'] == '' ) {
			$this->manager->validation->setRule('birthday','required');
		} else {
			$param['birthday'] = $param['birth-year'] . '-' . $param['birth-month'] . '-' .  $param['birth-day'];
			$this->manager->validation->setRule('birthday','realdate');
		}
		$this->manager->validation->setRule('gender','selected');
		$this->manager->validation->setRule('prefectures_id','selected');
		$this->manager->validation->setRule('password','required|password:4:16');
		return $this->manager->validation->run($param);
	}

}


/**
 * ログインID重複チェック
 *
 */
function duplicate_email($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	$email =$data[$key];
	$manager = Management::getInstance();
	//ＩＤが存在する場合
	if($res = $manager->db_manager->get('user')->findByEmail($email)){

		//仮登録の場合はtrue
		if($res['status_id'] == USER_ST_REQ){
			return true;
		}
		return false;
	}

	return true;
}

/**
 * ユーザーニックネーム重複チェック
 *
 */
function duplicate_user_nickname( $key, $data ) {
	
	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	$nickname =$data[$key];
	$manager = Management::getInstance();
	//ニックネームが存在する場合
	if($res = $manager->db_manager->get('user')->findByNickname($nickname)){

		//仮登録の場合はtrue
		if($res['status_id'] == USER_ST_REQ){
			return true;
		}
		return false;
	}
	return true;
}