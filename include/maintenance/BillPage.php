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
		
		$date = getGet('sdate',date('Y-m-d'));
		//$bill = array();
		
		//その日の合計用
		$bill['n_point']            = 0;
		$bill['n_point_commission'] = 0;
		$bill['n_point_n']            = 0;
		$bill['n_point_n_commission'] = 0;
		$bill['n_point_cancel']       = 0;
		$bill['n_point_cancel_commission'] = 0;
		$bill['e_point']            = 0;
		$bill['e_point_commission'] = 0;
		$bill['e_point_n']            = 0;
		$bill['e_point_n_commission'] = 0;
		$bill['e_point_cancel']       = 0;
		$bill['e_point_cancel_commission'] = 0;
		$bill['sp_point']            = 0;
		$bill['sp_point_commission'] = 0;
		
		$bill['use_n_point']   = 0;
		$bill['use_n_point_n'] = 0;
		$bill['use_e_point']   = 0;
		$bill['use_e_point_n'] = 0;
		$bill['use_point']     = 0;
		$bill['use_point_n']   = 0;
		$bill['use_n_point_cancel']   = 0;
		$bill['use_e_point_cancel']   = 0;
		$bill['use_point_cancel']   = 0;
		$bill['adjust_price'] = 0;
		$bill['deposit_price'] = 0;
		
		if($res = $this->manager->db_manager->get('bill_action')->getDateDataByStoreId($bill['store_id'],$date)){
			foreach($res as $val){
				$temp = array();
				$bill =$this->calBill($bill,$val);
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
		$data['bill']           = $bill;
		$data['page_type_text'] =$this->page_type_text;
		$this->loadView('display', $data);
   }
   
   /**
    * 請求の合計値を求める
    * @param type $bill
    * @param type $val
    * @return type
    */
   private function calBill($bill,$val){
		
		
		
		$bill['n_point']            += $val['n_point'];
		$bill['n_point_commission'] += $val['n_point_commission'];
		$bill['n_point_cancel']       += $val['n_point_cancel'];
		$bill['n_point_cancel_commission'] += $val['n_point_cancel_commission'];
		$bill['e_point']            += $val['e_point'];
		$bill['e_point_commission'] += $val['e_point_commission'];
		$bill['e_point_cancel']       += $val['e_point_cancel'];
		$bill['e_point_cancel_commission'] += $val['e_point_cancel_commission'];
		$bill['sp_point']            += $val['sp_point'];
		$bill['sp_point_commission'] += $val['sp_point_commission'];
		$bill['use_n_point']   += $val['use_n_point'];
		$bill['use_e_point']   += $val['use_e_point'];
		$bill['use_point']     += $val['use_point'];
		$bill['use_n_point_cancel']   += $val['use_n_point_cancel'];
		$bill['use_e_point_cancel']   += $val['use_e_point_cancel'];
		$bill['use_point_cancel']     += $val['use_point_cancel'];
		//未受理の場合
		if($val['reserved_status_id'] == RESERVE_ST_YET){
			$bill['n_point_n']            += $val['n_point'];
			$bill['n_point_n_commission'] += $val['n_point_commission'];
			$bill['e_point_n']            += $val['e_point'];
			$bill['e_point_n_commission'] += $val['e_point_commission'];
			$bill['use_n_point_n'] += $val['use_n_point'];
			$bill['use_e_point_n'] += $val['use_e_point'];
			$bill['use_point_n']   += $val['use_point'];
		}
		
		
	   return $bill;
   }

   

   /**
	 * 一覧画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getIndexCommon($data = array()){
		$get =$_GET;
		$get['m']='csv';
		$data['csv_url'] = http_build_query($get);
		return $data;
	}
	
   protected function csvAction(){
		
		$account = $this->getAccount();
		$account_id = getParam($account,'store_id');
		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();


		//limit句生成
		$limit = $this->manager->db_manager->get($this->use_table)->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->maintenanceSearchMaxCnt($account_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->maintenanceSearch($account_id,$get,$limit,$this->order);
		}
		else{
			exit();
		}
		
		$this->manager->setCore('bill');
		$this->manager->bill->createCsv($list,'maintenance');
		
		
	}
}
