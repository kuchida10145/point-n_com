<?php
/**
 * パースワードリマインダーページ
 * 
 */
include_once dirname(__FILE__) . '/../common/Page.php';

class PasswordReminderPage extends Page {

	protected $session_key = 'pw-reminder';

	protected $view = array(
			'index' => 'remind/index',
			'send' => 'remind/send',
			'edit' => 'remind/edit',
			'thanks' => 'remind/thanks',
	);


	/**
	 *  メールアドレス入力
	 * 
	 */
	public function indexAction() {


		$user = $this->getAccount();

		//ログインしている場合はPW変更ページへリダイレクト
		if ( isset( $user ) && !empty( $user ) ) {
		
			redirect('/mypage/pw');
			exit;
		}

		$siteHome = '';
		if ( isset( $_SERVER['HTTP_REFERER'] ) && !empty( $_SERVER['HTTP_REFERER'] ) ) {

			$urlParse = parse_url( $_SERVER['HTTP_REFERER'] );
			$host 	 	= $urlParse['host'];
			$scheme 	= $urlParse['scheme'];
			$siteHome = $scheme . '://' . $host;
		}

		$data = array();
		$post = array();
		$error = array();

		if ( isset($siteHome) && !empty($siteHome) && $siteHome == HTTP_HOST && getPost('m') == 'send' ) {

			$post = $_POST;

			//入力情報チェック
			if($this->emailValidation($post)){

				$userEmail = getPost('email');

				//ハッシュ作成
				$manager 	 = Management::getInstance();
				$userInfos = $manager->db_manager->get('user')->findByEmail($userEmail);
				$userId 	 = $userInfos['user_id'];
				$hash 		 = $this->manager->db_manager->get('user_hash')->reminderHash($userId);

				//メール用のデータを準備
				$mailContent['nickname']  = $userInfos['nickname'];
				$mailContent['renew_url'] = HTTP_HOST . '/remind/edit.php?keycode=' . $hash['hash'];

				//メールテンプレート取得
				$mailTemplateId = 6;
				$mailTemplate 	= $this->manager->db_manager->get('automail')->findById($mailTemplateId);

				//メール内容の準備
				$mail = create_mail_data( $mailTemplate, $mailContent );
				$mail['to'] = $userEmail;

				//メール送信
				$this->manager->mailer->setMailData($mail);
				$this->manager->mailer->sendMail();

				//完了ページへリダイレクト
				redirect('send.php');
			}
			$error = $this->getValidationError();
		}

		//表示用データ設定
		$data['post'] = escapeHtml($post);
		$data['error']= $error;
		$this->loadView('index', $data);
	}

	/**
	 * パスワード再設定URL送信完了
	 * 
	 */
	public function sendAction() {

		//直アクセスを防ぐ
		if ( !isset($_SERVER['HTTP_REFERER']) ) {

			redirect('/remind/');
			exit;
		}

		$data = array();
		$this->loadView('send', $data);
	}	


	/**
	 * パスワード再設定画面
	 * 
	 */
	public function editAction() {

		$data = array();
		$post = array();
		$error = array();


		//パラメーターなしのアクセスをリダイレクト
		if ( '' == getGet('keycode') && '' == getGet('tkn') ) {

			redirect('/remind/');
			exit;
		} elseif ( '' == getGet('tkn') ) {

			//token作成
			//keycodeの情報所得
			$hash = $this->manager->db_manager->get('user_hash')->findByActiveHash( getGet('keycode') );

			if ( isset($hash['user_hash_id']) && !empty($hash['user_hash_id']) ) {

				//keycodeの有効を確認
				if( time() > strtotime($hash['limit_date']) ) {

					$error['timeout'] = 'URLの有効期限を過ぎました。<br />';
					$error['timeout'] .= 'お手数ですが、下のURLよりパスワード再設定手続きを行ってください。<br />';
					$error['timeout'] .= '<a href="' . HTTP_HOST . '/remind/">パスワード再設定ページ</a>';
				} else {

					//更新するユーザー情報をセッションに保存
					$user = $this->manager->db_manager->get('user')->findById($hash['user_id']);
					$this->setFormSession('user_id', $user['user_id']);

					//token作成
					$this->token = $this->manager->token->createToken($this->session_key);
					redirect('edit.php?tkn=' . $this->token);
					exit;
				}
			} else {

				redirect('/remind/');
				exit;				
			}
		} elseif ( '' != getGet('tkn') ) {

			//token有効確認
			$currentToken = getGet('tkn');
			$validTokens  = $_SESSION['csrf'][ $this->session_key ];
			
			$tokenIsValid = false;
			foreach ( $validTokens as $validToken ) {
				if ( $currentToken == $validToken ) {
					$tokenIsValid = true;
				}
			}

			if ( true === $tokenIsValid ) {

				if ( 'edit' == getPost('m') ) {

					$post = $_POST;

					//新しいPWの確認
					if ( $this->passwordValidation($post) ) {

						//更新しようとしているユーザーアカウント情報取得
						$userId = $this->getFormSession('user_id');

						if ( isset($userId) && !empty($userId) ) {

							$user	= $this->manager->db_manager->get('user')->findById( $userId );
							if ( false != $user ) {

								//新しいPWをDBに保存
								$upd_data['password'] = encodePassword( $post['newPw'] );
								$this->manager->db_manager->get('user')->updateById( $user['user_id'], $upd_data );

								//パスワード変更完了メール
								//メールテンプレート取得
								$mailTemplateId = 7;
								$mailTemplate 	= $this->manager->db_manager->get('automail')->findById($mailTemplateId);

								//メール内容の準備
								$mail 			= create_mail_data( $mailTemplate, $mailContent );
								$mail['to'] = $user['email'];

								//メール送信
								$this->manager->mailer->setMailData( $mail );
								$this->manager->mailer->sendMail();

								//ログインページにリダイレクト
								redirect('/remind/thanks.php');
								exit;
							}
						}
					} else {

						//エラーメッセージ取得
						$error = $this->getValidationError();
					}
				}

			} else {

				//無効なtokenはリダイレクト
				$this->unsetFormSession('user_id');
				redirect('/remind/');
				exit;
			}
		}
		
		//表示用データ設定
		$data['post'] = escapeHtml($post);
		$data['error']= $error;
		$this->loadView('edit', $data);
	}	

	/**
	 * パスワード再設定完了画面
	 * 
	 */
	public function thanksAction() {

		//直アクセスを防ぐ
		if( !isset($_SERVER['HTTP_REFERER']) ) {

			redirect('/remind/');
			exit;
		}

		$data = array();
		$this->loadView('thanks', $data);
	}

	/**
	 * メールアドレス入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function emailValidation($param){

		$this->manager->validation->setRule('email','required|email|unvalid_user_email');
		return $this->manager->validation->run($param);
	}

	/**
	 * パスワード変更入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function passwordValidation($param){
		
		$this->manager->validation->setRule('newPw','required|password:4:16|notSamePassword');
		return $this->manager->validation->run($param);
	}

}


/**
 * 現在のパスワードが正しいかどうかチェック
 *
 */
function unvalid_user_email($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}

	$email 	 = $data[$key];
	$manager = Management::getInstance();
	$res 		 = $manager->db_manager->get('user')->findByEmail($email);

	if ( isset($res) && !empty($res) ) {
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

	if( !isset($data[$key]) || $data[$key] == '' ){
		return true;
	}

	if ( $data['newPw'] == $data['newPwConfirm'] ) {
		return true;
	} else {
		return false;
	}
	return true;
}