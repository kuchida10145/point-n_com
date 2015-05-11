<?php
/**
 * 自動返信メール管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class AutomailPage extends AdminPage{

	protected $id = 0;/* ID */
	protected $use_table   = 'automail';
	protected $session_key = 'automail';
	protected $use_confirm = true;
	protected $page_title = '自動返信メール管理';




	public function deleteAction(){
		redirect('automail.php');
	}


	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('title'       ,'required');
		$this->manager->validation->setRule('body'        ,'required');
		$this->manager->validation->setRule('from_mail'   ,'required|email');
		$this->manager->validation->setRule('from_name'   ,'required');
		$this->manager->validation->setRule('subject'     ,'required');
		$this->manager->validation->setRule('return_path' ,'required');


		return $this->manager->validation->run($param);
	}

}