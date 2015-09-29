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
		$year_month = getGet('year')."-".sprintf('%02d',getGet('month'));
		
		
		$data['bill']         = $this->manager->db_manager->get('bill')->getBillForStore($account['store_id'],getGet('year'),getGet('month'));
		$data['bill_actions'] = $this->manager->db_manager->get('bill_action')->findByStoreId_Month($account['store_id'],$year_month);
		$data['total'] = calculate_bil_store($data['bill']);
		$data['page_title']     =$this->page_title;

		$data['page_type_text'] =$this->page_type_text;
		$this->loadView('index', $data);
	}
	
	protected function csvAction(){
		//日付初期値
		if(!getGet('year')){
			$_GET['year'] = date('Y');
		}
		if(!getGet('month')){
			$_GET['month'] = date('m');
		}
		
		$account = $this->getAccount();
		$year_month = getGet('year')."-".sprintf('%02d',getGet('month'));
		
		
		$bill         = $this->manager->db_manager->get('bill')->getBillForStore($account['store_id'],getGet('year'),getGet('month'));
		
		if(!$bill){
			$this->errorPage();
		}
		
		$bill_actions = $this->manager->db_manager->get('bill_action')->findByStoreId_Month($account['store_id'],$year_month);
		$total = calculate_bil_store($bill);
		
		$csv[] = array('年月','支払い状況','請求種別','発行ポイント','予約時利用ポイント','発行ポイントキャンセル','予約時利用ポイントキャンセル','前払い増加利用枠','調整金額','メモ','金額');
		$csv[] = array(
			str_replace('-','年',$bill['bill_month'])."月",
			getParam(pay_status(),$bill['pay_status']),
			calculate_bil_type_txt($total),
			"-".number_format($bill['issue_point']),
			number_format($bill['use_point']),
			number_format($bill['issue_point_cancel']),
			number_format($bill['use_point_cancel']),
			number_format($bill['deposit_price']),
			$bill['adjust_price'],
			$bill['memo'],
			$total,
		);
		
		
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$year_month.'.csv');

		$stream = fopen('php://output', 'w');

		foreach($csv as $row){
			mb_convert_variables('SJIS-win', 'UTF-8', $row);
			fputcsv($stream, $row);
		}
	}
}
