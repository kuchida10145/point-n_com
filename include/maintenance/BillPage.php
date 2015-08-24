<?php
/**
 * 請求
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class BillPage extends MaintenancePage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'bill';
	protected $session_key = 'bill';
	protected $use_confirm = true;
	protected $page_title = '請求管理';
	protected $page_cnt = 999;//一ページに表示するデータ数

	
	
	protected  function indexAction() {
		//日付初期値
		if(!getGet('year')){
			$_GET['year'] = date('Y');
		}
		if(!getGet('month')){
			$_GET['month'] = date('m');
		}
		
		$account = $this->getAccount();
		
		
		$data['bill'] = $this->manager->db_manager->get('bill')->getBillForStore($account['store_id'],getGet('year'),getGet('month'));
		$data['total'] = calculate_bil_store($data['bill']);
		$data['page_title']     =$this->page_title;

		$data['page_type_text'] =$this->page_type_text;
		$this->loadView('index', $data);
	}
}
