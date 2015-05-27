<?php
/**
 * 退会申請
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class SignoutPage extends Page{

	protected $session_key = 'signout';

	protected $view = array(
			'index'    =>'signout/index',
			'confirm'  =>'signout/confirm',
			'thanks'   =>'signout/thanks',
	);


	/**
	 * 申請画面
	 *
	 */
	public function indexAction(){

		$data = array();
		$post = array();
		$error = array();
		
		//ログインチェック
		$user = $this->getAccount();
		if(!$user){
			redirect('/');
		}
		
		//トークンチェック
		if(getGet('tkn')==''){
			$this->token = $this->manager->token->createToken($this->session_key);
			redirect('?tkn='.$this->token);
		}
		else{
			$this->token = getGet('tkn');
		}
		
		if(getPost('m') == 'signout'){
			$post = $_POST;
			//入力チェック
			if($this->signoutValidation($post)){
				$this->setFormSession('form',1);
				//確認画面へ遷移
				redirect('/signout/confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		}



		//表示用データ設定
		$data['post'] = escapeHtml($post);
		$data['error']= $error;
		$this->loadView('index', $data);
	}


	

	/**
	 * 確認画面
	 *
	 */
	public function confirmAction(){
		$data = array();
		$user = $this->getAccount();
		$this->token = getGet('tkn');
		$form = $this->getFormSession('form');
		if(!$user){
			redirect('/');
		}
		$user_id = $user['user_id'];
		
		
		//セッションチェック
		if($form != 1){
			redirect('/signout/');
		}


		//退会ボタンが押された場合
		if(getPost('m') == 'confirm'){

			//削除
			$this->manager->db_manager->get('user')->deleteById($user_id);

			//フォームセッション削除
			$this->unsetFormSession('form');
			
			//アカウントセッション削除
			$this->clearAccountSession();
			
			//クッキー削除
			$this->unsetAutoLogin($user_id);
			
			//退会完了メール
			$mail_id = 3;
			$mail = $this->manager->db_manager->get('automail')->findById($mail_id);
			//メール用データ
			$mail_data['nickname'] =$user['nickname'];
			$mail = create_mail_data($mail,$mail_data);
			$mail['to'] = $user['email'];
			$this->manager->mailer->setMailData($mail);
			$this->manager->mailer->sendMail();
			redirect('thanks.php');
		}

		$this->loadView('confirm', $data);
	}


	/**
	 * 退会完了
	 *
	 */
	public function thanksAction(){
		$data = array();
		$this->loadView('thanks', $data);
	}
	
	
	/**
	 * 選択チェック
	 * @param array $param 検証データ
	 * @return bool
	 */
	public function signoutValidation($param){
		$this->manager->validation->setRule('contract','selected');
		return $this->manager->validation->run($param);
	}

}

