<?php
/**
 *
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';
include_once(dirname(__FILE__) . '/../common/NewsCommonPage.php');

class NoticePage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'notice';
	protected $session_key = 'notice';
	protected $use_confirm = true;
	protected $page_title = 'お店からのお知らせ管理';
	protected $order = ' ORDER BY public_start_date DESC , regist_date DESC ';

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){

		$this->manager->validation->setRule('title','required|maxlength:50');
 		$this->manager->validation->setRule('display_date','required|dateformat|realdate');
// 		$this->manager->validation->setRule('public_start_date','dateformat|realdate');
// 		$this->manager->validation->setRule('public_end_date','dateformat|realdate');
		$this->manager->validation->setRule('body','required');

		return $this->manager->validation->run($param);
	}

	/**
	 * ＤＢデータから入力用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data) {
		$news_common = new NewsCommonPage();
		return $news_common->dbToInputData($data, $this->id);
	}

	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		$account = $this->getAccount();
		$param['store_id'] = $account['store_id'];
		$param = $this->inputToDbData($param);

		$news_common = new NewsCommonPage();
		return $news_common->insert_action($param, $this->use_table);
	}

	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_action($param){
		$param = $this->inputToDbData($param);

		$news_common = new NewsCommonPage();
		return $news_common->update_action($param, $this->id, $this->use_table);
	}

	/**
	 * 入力用データからＤＢデータへ変換
	 * insert_actionやupdate_actionをオーバーライドしparentで呼び出した時、オーバーライド内にも書くと２回実行されるので注意
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function inputToDbData($data){
		return $data;
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
		$data['body']  = $post['body'];			// HTMLエスケープ前に本文を退避する。
		$data['post']  = escapeHtml($post);
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;

		$this->loadView('confirm', $data);
	}
}