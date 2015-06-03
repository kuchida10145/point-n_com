<?php
/**
 * 今日のニュース管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';
include_once(dirname(__FILE__) . '/../common/NewsCommonPage.php');

class NewsPage extends AdminPage {

	protected $id = 0;/* ID */
	protected $use_table   = 'news';
	protected $session_key = 'news';
	protected $use_confirm = true;
	protected $page_title = '今日のニュース';

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