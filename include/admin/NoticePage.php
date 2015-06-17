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
}