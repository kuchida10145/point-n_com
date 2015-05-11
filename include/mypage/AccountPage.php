<?php
/**
 * アカウント情報編集TOP
 *
 */
include_once dirname(__FILE__).'/../Page.php';

class AccountPage extends Page{




	protected $view = array(
			'index' =>'mypage/account',
	);


	/**
	 * TOPページ
	 *
	 */
	public function indexAction(){
		$data = array();
		$post = array();
		$error = array();
		$account =$this->getAccount();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();

		if($account == NULL){
			redirect('login.html');
		}


		if(getPost('m') == 'account'){
			$post = $_POST;
			if($this->validation($post)){

				$upd_data['name'] = $post['name'];
				if($post['login_pw']){
					$upd_data = encodePassword($post['login_pw']);
				}

				$this->manager->db_manager->get('user')->updateById($account['id'],$upd_data);
				$account = $this->manager->db_manager->get('user')->findById($account['id']);
				$this->setAccount($account);
				$this->setSystemMessage($this->manager->message->get('front')->getMessage('update_comp'));
				redirect('account.html');

			}
			$system_message = $this->manager->message->get('front')->getMessage('edit_error');
			$error = $this->getValidationError();
		}
		else{

			$post = $this->manager->db_manager->get('user')->findById($account['id']);
		}



		$data['email'] = $account['email'];
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['system_message'] = $system_message;
		$this->loadView('index', $data);

	}




	/**
	 * 登録入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function validation($param){
		$this->manager->validation->setRule('name','required');
		$this->manager->validation->setRule('login_pw','password:4:8');
		return $this->manager->validation->run($param);
	}
}