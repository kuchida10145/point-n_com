<?php
/**
 * お問い合わせ
 *
 */
include_once dirname(__FILE__).'/Page.php';

class ContactPage extends Page{


	protected $session_key = 'signup';


	protected $view = array(
			'index'    =>'contact/index',
			'confirm'  =>'contact/confirm',
			'thanks'   =>'contact/thanks',
	);




	/**
	 * 会員情報入力
	 *
	 */
	public function indexAction(){
		$data = array();
		$post = array();
		$error = array();



		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$this->token = $this->manager->token->createToken($this->session_key);
			redirect('?tkn='.$this->token);
			exit();
		}

		$this->token = getGet('tkn');

		if(getPost('m') == 'edit'){
			$post = $_POST;
			if($this->validation($post)){
				$form_data = array(
					'title'     => getPost('title'),
					'name'      => getPost('name'),
					'tel'       => getPost('tel'),
					'email'     => getPost('email'),
					'category'  => getPost('category'),
					'body'      => getPost('body'),
				);

				$this->setFormSession('form', $form_data);
				redirect('confirm.html?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		}
		else{
			$post = $this->getFormSession('form');
		}



		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$this->loadView('index', $data);
	}


	/**
	 * 会員情報確認
	 *
	 */
	public function confirmAction(){
		$data = array();
		$this->token = getGet('tkn');

		$form_data = $this->getFormSession('form');
		if(!$form_data || $this->validation($form_data) == false){
			redirect('index.html');
			exit();
		}

		//登録ボタンが押された場合
		if(getPost('m') == 'confirm'){

			//フォームセッション削除
			$this->unsetFormSession('form');


			$mail_data = $form_data;
			$mail_data['category'] = getParam(contact_category(),$form_data['category']);

			//送信完了メール（ユーザ側）
			if($form_data['email'] != ''){
				$mail_id = 3;
				$mail = $this->manager->db_manager->get('automail')->findById($mail_id);
				//メール用データ
				$mail = create_mail_data($mail,$mail_data);
				$mail['to'] = $form_data['email'];
				$this->manager->mailer->setMailData($mail);
				$this->manager->mailer->sendMail();
			}

			//管理者へメール
			$mail_id = 4;
			$mail = $this->manager->db_manager->get('automail')->findById($mail_id);
			//メール用データ
			$mail = create_mail_data($mail,$mail_data);
			$mail['to'] = ADMIN_MAIL;
			$this->manager->mailer->setMailData($mail);
			$this->manager->mailer->sendMail();

			redirect('thanks.html');
		}

		$form_data = escapeHtml($form_data);
		$form_data['category'] = getParam(contact_category(),$form_data['category']);
		$form_data['body']     = str_replace("\r\n",'<br />',$form_data['body']);

		//表示データ
		$data['post']  = $form_data;
		$this->loadView('confirm', $data);
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
	 * 登録入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function validation($param){
		$this->manager->validation->setRule('name' ,'required');
		$this->manager->validation->setRule('email','required|email');
		$this->manager->validation->setRule('category','required');
		$this->manager->validation->setRule('body','required');
		return $this->manager->validation->run($param);
	}
}

