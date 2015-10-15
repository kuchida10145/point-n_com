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

	/**
	 * ビューテンプレートの設定
	 *
	 */
	protected function setView(){
		parent::setView();
		$this->view['display'] = 'maintenance/'.$this->use_table.'/display';
	}
	
	
	/*
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
	*/
	
	protected function displayAction(){
		$account = $this->getAccount();
		//請求データがない　OR 店舗IDが一致しないとエラー
		if(!($bill = $this->manager->db_manager->get('bill')->findById(getGet('id'))) || $bill['store_id'] != $account['store_id']){
			$this->errorAction();
		}
	  
		//通常ポイント取得
		$data['n_points']        = array();
		$data['n_points_cancel'] = array();
		$data['n_point_total']        = 0;
		$data['n_point_cancel_total'] = 0;
	  
		//イベントポイント取得
		$data['e_points']        = array();
		$data['e_points_cancel'] = array();
		$data['e_point_total']        = 0;
		$data['e_point_cancel_total'] = 0;
	  
		//特別ポイント取得
		$data['sp_points']        = array();
		$data['sp_point_total']   = 0;
		
	  
		//使用されたポイント取得
		$data['use_n_points']        = array();
		$data['use_n_points_cancel'] = array();
		$data['use_n_point_total']        = 0;
		$data['use_n_point_cancel_total'] = 0;
	  
	  
		//使用されたポイント(イベント)取得
		$data['use_e_points']        = array();
		$data['use_e_points_cancel'] = array();
		$data['use_e_point_total']        = 0;
		$data['use_e_point_cancel_total'] = 0;
	  
		//使用されたポイント(イベント)取得
		$data['use_points']        = array();
		$data['use_points_cancel'] = array();
		$data['use_point_total']        = 0;
		$data['use_point_cancel_total'] = 0;
	   
		if($res = $this->manager->db_manager->get('bill_action')->getMonthDataByStoreId($bill['store_id'],$bill['bill_month'])){
			foreach($res as $val){
				$temp = array();
				//--発行ポイント--
				//通常ポイント
				if($val['n_point'] > 0){
					$temp['name']       = $val['action_name'];
					$temp['point']      = $val['n_point'];
					$temp['commission'] = $val['n_point_commission'];
					$temp['total']      = $temp['point']+$temp['commission'];
					$temp['status_id']  = $val['reserved_status_id'];
					$temp['date']       = $val['regist_date'];
					$data['n_points'][] = $temp;
					$data['n_point_total']+= $temp['total'];
					//ポイントが発生している場合
					if($val['use_n_point'] > 0){
						$temp = array();
						$temp['name']       = $val['action_name'];
						$temp['point']      = $val['use_n_point'];
						$temp['status_id']  = $val['reserved_status_id'];
						$temp['date']       = $val['regist_date'];
						$data['use_n_point_total']+=$temp['point'];
						$data['use_n_points'][] = $temp;
					}
				}
				//通常ポイントキャンセル
				else if($val['n_point_cancel'] > 0){
					$temp['name']       = $val['action_name'];
					$temp['point']      = $val['n_point_cancel'];
					$temp['commission'] = $val['n_point_cancel_commission'];
					$temp['status_id']  = $val['reserved_status_id'];
					$temp['date']       = $val['regist_date'];
					$temp['total']      = $temp['point']+$temp['commission'];
					$data['n_points_cancel'][] = $temp;
					$data['n_point_cancel_total']+= $temp['total'];
					//ポイントが発生している場合
					if($val['use_n_point_cancel'] > 0){
						$temp = array();
						$temp['name']       = $val['action_name'];
						$temp['point']      = $val['use_n_point_cancel'];
						$temp['status_id']  = $val['reserved_status_id'];
						$temp['date']       = $val['regist_date'];
						$data['use_n_point_cancel_total']+=$temp['point'];
						$data['use_n_points_cancel'][] = $temp;
					}
				}
				//イベントポイント
				else if($val['e_point'] > 0){
					$temp['name']       = $val['action_name'];
					$temp['point']      = $val['e_point'];
					$temp['commission'] = $val['e_point_commission'];
					$temp['status_id']  = $val['reserved_status_id'];
					$temp['date']       = $val['regist_date'];
					$temp['total']      = $temp['point']+$temp['commission'];
					$data['e_points'][] = $temp;
					$data['e_point_total']+= $temp['total'];
					//ポイントが発生している場合
					if($val['use_e_point'] > 0){
						$temp = array();
						$temp['name']       = $val['action_name'];
						$temp['point']      = $val['use_e_point'];
						$temp['status_id']  = $val['reserved_status_id'];
						$temp['date']       = $val['regist_date'];
						$data['use_e_point_total']+=$temp['point'];
						$data['use_e_points'][] = $temp;
					}
				}
				//イベントポイントキャンセル
				else if($val['e_point_cancel'] > 0){
					$temp['name']       = $val['action_name'];
					$temp['point']      = $val['e_point_cancel'];
					$temp['commission'] = $val['e_point_cancel_commission'];
					$temp['status_id']  = $val['reserved_status_id'];
					$temp['date']       = $val['regist_date'];
					$temp['total']      = $temp['point']+$temp['commission'];
					$data['e_points_cancel'][] = $temp;
					$data['e_point_cancel_total']+= $temp['total'];
					//ポイントが発生している場合
					if($val['use_e_point_cancel'] > 0){
						$temp = array();
						$temp['name']       = $val['action_name'];
						$temp['point']      = $val['use_e_point_cancel'];
						$temp['status_id']  = $val['reserved_status_id'];
						$temp['date']       = $val['regist_date'];
						$data['use_e_point_cancel_total']+=$temp['point'];
						$data['use_e_points_cancel'][] = $temp;
					}
				}
				//特別ポイント
				else if($val['sp_point'] > 0){
					$temp['point']      = $val['sp_point'];
					$temp['commission'] = $val['sp_point_commission'];
					$temp['total']      = $temp['point']+$temp['commission'];
					$temp['name']       = $val['action_name'];
					$temp['date']       = $val['regist_date'];
					$data['sp_point_total']+=$temp['total'];
					$data['sp_points'][] = $temp;
				}
				
				//使用されたポイント(ポイントのみ）
				else if($val['use_point'] > 0){
					$temp['point']      = $val['use_point'];
					$temp['name']       = $val['action_name'];
					$temp['date']       = $val['regist_date'];
					$temp['status_id']  = $val['reserved_status_id'];
					$data['use_point_total']+=$temp['point'];
					$data['use_points'][] = $temp;
				}
				//使用されたポイント(ポイントのみ）キャンセル
				else if($val['use_point_cancel'] > 0){
					$temp['point']      = $val['use_point_cancel'];
					$temp['name']       = $val['action_name'];
					$temp['date']       = $val['regist_date'];
					$temp['status_id']  = $val['reserved_status_id'];
					$data['use_point_cancel_total']+=$temp['point'];
					$data['use_points_cancel'][] = $temp;
				}
			}
		}
		unset($res);
		
		
	   
		$data['page_title']     =$this->page_title;

		$data['page_type_text'] =$this->page_type_text;
		$this->loadView('display', $data);
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
