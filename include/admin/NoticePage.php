<?php
/**
 * 今日のニュース管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';
include_once(dirname(__FILE__) . '/../common/NewsCommonPage.php');

class NoticePage extends AdminPage {

	protected $id = 0;/* ID */
	protected $use_table   = 'notice';
	protected $session_key = 'notice';
	protected $use_confirm = true;
	protected $page_title = 'お知らせ情報管理';

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){

		$this->manager->validation->setRule('title','required|maxlength:50');
// 		$this->manager->validation->setRule('display_date','required|dateformat|realdate');
// 		$this->manager->validation->setRule('public_start_date','dateformat|realdate');
// 		$this->manager->validation->setRule('public_end_date','dateformat|realdate');
		$this->manager->validation->setRule('body','required');

		return $this->manager->validation->run($param);
	}

	/**
	 * 画像アップロード（AJAX)
	 */
	protected function image_uploadAction(){
 		$news_common = new NewsCommonPage();
 		$news_common->image_uploadAction();
	}

	/**
	 * 入力確認画面
	 *
	 */
	protected function confirmAction(){
		$post  = $this->getFormSession('form');
		$data  = array();
		//入力チェック
		if(!$this->validation($post)){
			$this->errorPage();
			exit();
		}

		//POST送信があった場合
		if(getPost('m') == 'confirm'){
			if($this->id == 0){
				$result_flg = $this->inseart_action($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('insert_comp'));
			}
			else {
				$result_flg = $this->update_action($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
			}

			if($result_flg !== false){
				redirect($this->use_table.'.php');
			}
			$this->unsetSystemMessage();
		}

		//表示用データ
		$data = $this->getConfirmCommon();
		$data['body']  = $post['body'];			// HTMLエスケープ前に本文を退避する
		$data['post']  = escapeHtml($post);
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;

		$this->loadView('confirm', $data);
	}
}