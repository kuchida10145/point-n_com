<?php
/**
 * パースワード変更ページ
 * 
 */
include_once dirname(__FILE__) . '/../common/Page.php';

class PasswordPage extends Page {

	protected $session_key = 'pw';

	protected $view = array(
			'index' => 'mypage/pw/index',
			'thanks' => 'mypage/pw/thanks',
	);


	/**
	 * パースワード入力 
	 * 
	 */
	public function indexAction() {

		$user = $this->getAccount();

		//ログインしていないユーザーをリダイレクト
		if ( !( isset($user['user_id']) && !empty($user['user_id']) ) ) {
		
			redirect('/');
			return;
		}

		$data = array();
		$post= array();
		$error = array();


		if ( getPost('m') == 'thanks' ) {

			$post = $_POST;

			//入力情報チェック
			if($this->validation($post)){

				$upd_data['password'] = encodePassword($post['newPw']);

				//DB更新
				$this->manager->db_manager->get('user')->updateById($user['user_id'],$upd_data);
				
				//パスワード完了メール
				$mail_id = 7;
				$mail = $this->manager->db_manager->get('automail')->findById($mail_id);
				//メール用データ
				$mail_data['nickname'] =$user['nickname'];
				$mail = create_mail_data($mail,$mail_data);
				$mail['to'] = $user['email'];
				$this->manager->mailer->setMailData($mail);
				$this->manager->mailer->sendMail();
				
				//古いログインセッションを削除
				$this->unsetAutoLogin($user['user_id']);
				$this->clearAccountSession();
				
				//パスワード自動保存している場合は、変更
				if($this->getIdPw()){
					$this->saveIdPw($user['email'],$post['newPw'],1);
				}

				//完了ページへリダイレクト
				redirect('thanks.php');
			}
			$error = $this->getValidationError();
		}

		//表示用データ設定
		$data['post'] = escapeHtml($post);
		$data['error']= $error;
		$this->loadView('index', $data);

	}

	/**
	 * パースワード入力 
	 * 
	 */
	public function thanksAction() {
		$data = array();
		$this->loadView('thanks', $data);
	}

	/**
	 * パスワード変更入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function validation($param){
		
		$user = $this->getAccount();
		$param['realPassword'] = $user['password'];

		$this->manager->validation->setRule('currentPw','required|password:4:16|wrongPassword');
		$this->manager->validation->setRule('newPw','required|password:4:16|notSamePassword');
		$this->manager->validation->setRule('newPwConfirm','required|password:4:16|notSamePassword');
		return $this->manager->validation->run($param);
	}


}


/**
 * 現在のパスワードが正しいかどうかチェック
 *
 */
function wrongPassword($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	
	$pw_to_test = encodePassword( $data[$key] );
	$real_pw = $data['realPassword'];

	if ( $pw_to_test === $real_pw ) {
		return true;
	} else {
		return false;
	}
	return true;
}


/**
 * 新しいパスワードが同じかどうかチェック
 *
 */
function notSamePassword($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}

	if ( $data['newPw'] == $data['newPwConfirm'] ) {
		return true;
	} else {
		return false;
	}
	return true;
}
