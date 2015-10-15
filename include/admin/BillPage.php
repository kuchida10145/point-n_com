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
		
		$res = array();
		$get = $_GET;

		$year = getGet('year',date('Y'));
		$month = getGet('month',date('m'));

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->adminSearchMaxCnt($get);

		//リスト取得
		if($max_cnt > 0){
			$res  = $this->manager->db_manager->get($this->use_table)->adminSearch($get,"LIMIT 0,{$max_cnt}",$this->order);
		}
		else{
			exit();
		}
		
		
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=data.csv');
		$stream = fopen('php://output', 'w');
		$fields = array();
		$fields[] = '年月';
		$fields[] = '店舗名';
		$fields[] = '支払状況';
		$fields[] = 'ポイント';
		$fields[] = 'ポイント手数料';
		$fields[] = 'ポイント未受理';
		$fields[] = 'ポイント手数料未受理';
		$fields[] = 'イベントポイント';
		$fields[] = 'イベントポイント手数料';
		$fields[] = 'イベントポイント未受理';
		$fields[] = 'イベントポイント手数料未受理';
		$fields[] = '特別ポイント';
		$fields[] = '特別ポイント手数料';
		$fields[] = '使用されたポイント（ポイント）';
		$fields[] = '使用されたポイント（ポイント）未受理';
		$fields[] = '使用されたポイント（イベント）';
		$fields[] = '使用されたポイント（イベント）未受理';
		$fields[] = '使用されたポイント（ポイントのみ）';
		$fields[] = '使用されたポイント（ポイントのみ）未受理';
		$fields[] = 'ポイントキャンセル';
		$fields[] = 'ポイントキャンセル手数料';
		$fields[] = 'イベントポイントキャンセル';
		$fields[] = 'イベントポイントキャンセル手数料';
		$fields[] = '使用されたポイント（ポイント）キャンセル';
		$fields[] = '使用されたポイント（イベント）キャンセル';
		$fields[] = '使用されたポイント（ポイントのみ）キャンセル';
		$fields[] = '前払い';
		$fields[] = '調整費';
		$fields[] = 'メモ';
		$fields[] = '合計';
		$fields[] = '支払い・払い戻し';
		mb_convert_variables("SJIS-win", "utf-8", $fields);
		fputcsv($stream,  $fields);
		foreach ($res as $data){
			
			$fields = array();
			$total = cal_point_total($data)+cal_cancel_total($data);
			if( $total == 0 ){
				$pay_text = "払い戻し・支払い無し";
			}
			else if($total > 0){
				$pay_text = "支払い";
			}
			else{
				$pay_text = "払い戻し";
			}
			
			$fields[] = "{$year}年{$month}";//年月
			$fields[] = $data['store_name'];				//ポイント
			$fields[] = getParam(pay_status(),$data['pay_status']);//支払状況
			$fields[] = $data['n_point'];				//ポイント
			$fields[] = $data['n_point_commission'];		//ポイント手数料
			$fields[] = $data['n_point_n'];				//ポイント未受理
			$fields[] = $data['n_point_n_commission'];	//ポイント手数料未受理
			$fields[] = $data['e_point'];				//イベントポイント
			$fields[] = $data['e_point_commission'];		//イベントポイント手数料
			$fields[] = $data['e_point_n'];				//イベントポイント未受理
			$fields[] = $data['e_point_n_commission'];	//イベントポイント手数料未受理
			$fields[] = $data['sp_point'];				//特別ポイント
			$fields[] = $data['sp_point_commission'];	//特別ポイント手数料
			$fields[] = $data['use_n_point'];			//使用されたポイント（ポイント）
			$fields[] = $data['use_n_point_n'];			//使用されたポイント（ポイント）未受理
			$fields[] = $data['use_e_point'];			//使用されたポイント（イベント）
			$fields[] = $data['use_e_point_n'];			//使用されたポイント（イベント）未受理
			$fields[] = $data['use_point'];				//使用されたポイント（ポイントのみ）
			$fields[] = $data['use_point_n'];			//使用されたポイント（ポイントのみ）未受理
			$fields[] = $data['n_point_cancel'];			//ポイントキャンセル
			$fields[] = $data['n_point_cancel_commission'];	//ポイントキャンセル手数料
			$fields[] = $data['e_point_cancel'];			//イベントポイントキャンセル
			$fields[] = $data['e_point_cancel_commission'];	//イベントポイントキャンセル手数料
			$fields[] = $data['use_n_point_cancel'];	//使用されたポイント（ポイント）キャンセル
			$fields[] = $data['use_e_point_cancel'];	//使用されたポイント（イベント）キャンセル
			$fields[] = $data['use_point_cancel'];		//使用されたポイント（ポイントのみ）キャンセル
			$fields[] = $data['deposit_price'];			//前払い
			$fields[] = $data['adjust_price'];			//調整
			$fields[] = $data['memo'];					//メモ
			$fields[] = $total;	//合計
			$fields[] = $pay_text;
			mb_convert_variables("SJIS-win", "utf-8", $fields);
			
			fputcsv($stream,  $fields);
		}
		
		
	}



	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('adjust_price'    ,'required|digit');
		return $this->manager->validation->run($param);
	}
	/**
	 * tkn生成時にデータをセッションに格納
	 */
	protected function editDefaultParam(){
		$referer = $_SERVER["HTTP_REFERER"];
		$url = parse_url($referer);
		$host = $url['host'];
		
		if($host == $_SERVER['SERVER_NAME']){
			$this->setFormSession('redirect',$referer);
		}
		
		return;
	}
	
	
	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_action($param){
		$result_flg = parent::update_action($param);
		$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
		if($result_flg !== false){
			$redirect = $this->getFormSession('redirect');
			if($redirect!=""){
				$this->unsetFormSession('form');
				redirect($redirect);
			}
		}
		return $flg;
	}
	
	
	/**
	 * 入力画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getEditCommon($data = array()){
		$data = $this->getEditConfirmCommon();
		return $data;
	}


	/**
	 * 確認画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getConfirmCommon($data = array()){
		$data = $this->getEditConfirmCommon();
		return $data;
	}
	
	/**
	 * 入力画面と確認画面で共通のデータ
	 * @param array $data
	 * @return type
	 */
	protected function getEditConfirmCommon($data = array()){
		$bill = $this->manager->db_manager->get('bill')->findById($this->id);
		$bill['issue_point']      = $bill['n_point']+$bill['e_point']+$bill['sp_point'];
		$bill['issue_commission'] = $bill['n_point_commission']+$bill['e_point_commission']+$bill['sp_point_commission'];
		$bill['cancel_point']     = $bill['n_point_cancel']+$bill['e_point_cancel'];
		$bill['cancel_commission']= $bill['n_point_cancel_commission']+$bill['e_point_cancel_commission'];
		$bill['use_total']        = $bill['use_n_point']+$bill['use_e_point']+$bill['use_point'];
		$bill['use_total_cancel'] = $bill['use_n_point_cancel']+$bill['use_e_point_cancel']+$bill['use_point_cancel'];
		$data['bill_data'] = $bill;
		return $data;
	}

}
