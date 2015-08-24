<?php
/**
 * 利用可能枠
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class BillPage extends AdminPage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'bill';
	protected $session_key = 'bill';
	protected $use_confirm = true;
	protected $page_title = '請求管理';
	protected $page_cnt = 100000;//一ページに表示するデータ数

	
	
	

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('adjust_price'    ,'required|digit');
		return $this->manager->validation->run($param);
	}

	
	
	/**
	 * 入力画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getEditCommon($data = array()){
		$data['bill_data'] = $this->manager->db_manager->get('bill')->findById($this->id);
		return $data;
	}


	/**
	 * 確認画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getConfirmCommon($data = array()){
		$data['bill_data'] = $this->manager->db_manager->get('bill')->findById($this->id);
		return $data;
	}

}
