<?php
/**
 * 利用枠追加テーブル
 */
class BillDbModel extends DbModel{



	public function getField(){
		return array(
			'bill_id',
			'bill_month',
			'store_id',
			'store_name',
			'issue_point',
			'use_point',
			'deposit_price',
			'issue_point_cancel',
			'use_point_cancel',
			'normal_point',
			'event_point',
			'special_point',
			'total_commission',
			'adjust_price',
			'memo',
			'pay_status',
			'regist_date',
			'update_date',
		);
	}
	
	/**
	 * 店舗側の月別請求データ取得
	 * 
	 */
	public function getBillForStore($store_id,$year,$month){
		$bill_month = date('Y-m',strtotime($year.'-'.$month));
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE store_id = '{$store_id}' AND bill_month = '{$bill_month}' LIMIT 0,1";
		
		return $this->db->getData($sql);
		
	}

	/**
	 * 今月の請求一覧を作成（Cronで月初めに実行）
	 */
	public function addThisMonthBillCron(){
		$regist_date = $update_date = date('Y-m-01 H:i:s');
		$this_month = date('Y-m');
		$sql = "INSERT INTO bill (store_id,store_name,bill_month,regist_date,update_date) (SELECT store_id,store_name,'{$this_month}','{$regist_date}','{$update_date}' FROM store WHERE delete_flg = 0 )";
		$this->db->query($sql);
	}
	
	/**
	 * クーポンが発行された場合
	 * @param $point ポイント
	 */
	public function addIssue_point($store_id,$point){
		$this_month = date('Y-m');
		$update_date = date('Y-m-d H:i:s');
		$sql = "UPDATE bill SET issue_point = issue_point+{$point},update_date = '{$update_date}' WHERE store_id = '{$store_id}' AND  bill_month = '{$this_month}' ";
		return $this->db->query($sql);
	}
	
	/**
	 * ポイント利用で予約があった場合
	 * @param $point ポイント
	 */
	public function addUse_point($store_id,$point){
		$this_month = date('Y-m');
		$update_date = date('Y-m-d H:i:s');
		$sql = "UPDATE bill SET use_point = use_point+{$point},update_date = '{$update_date}' WHERE store_id = '{$store_id}' AND  bill_month = '{$this_month}' ";
		return $this->db->query($sql);
	}
	
	/**
	 * 前月以前の予約でキャンセルあった場合
	 * @param $point ポイント
	 */
	public function addBefore_cancel($store_id,$point){
		$this_month = date('Y-m');
		$update_date = date('Y-m-d H:i:s');
		$sql = "UPDATE bill SET before_cancel = before_cancel+{$point},update_date = '{$update_date}' WHERE store_id = '{$store_id}' AND  bill_month = '{$this_month}' ";
		return $this->db->query($sql);
	}
	
	
	public function findByMonthStoreId($year_month,$store_id){
		$field = $this->getFieldText();
		
		$sql = "SELECT {$field} FROM bill WHERE bill_month = '{$year_month}' AND store_id = '{$store_id}' LIMIT 0,1";
		return $this->db->getData($sql);
	}
	
	
	/**
	 * 指定年月の発行料金計
	 */
	public function monthTotalBillByStoreId($year_month,$store_id){
		
		$bill = $this->findByMonthStoreId($year_month,$store_id);
		
		//発行ポイント総数
		$base_sql = "SELECT IFNULL(SUM(total_price), 0) as total_price,IFNULL(sum(use_point), 0) as use_point FROM bill_action WHERE store_id = '{$store_id}' AND ##replace## regist_date LIKE '{$year_month}%' GROUP BY store_id ";
		$sql = str_replace('##replace##', '', $base_sql);
		if(!$total = $this->db->getData($sql)){
			$total = array('total_price' => 0,'use_point' => 0 );
		}
		
		//キャンセル料金
		$sql = str_replace('##replace##', ' data_type = 1 AND ', $base_sql);
		if(!$minus = $this->db->getData($sql)){
			$minus = array('total_price' => 0,'use_point' => 0 );
		}
		
		//通常ポイント総数
		$base_sql ="SELECT IFNULL(SUM(issue_point), 0) as point,IFNULL(SUM(commission), 0) as commission FROM bill_action WHERE store_id = '{$store_id}' AND action_type=##type## AND data_type = 0 AND regist_date LIKE '{$year_month}%' GROUP BY store_id ";
		$sql = str_replace('##type##', '1', $base_sql);
		print $sql;
		if(!$normal = $this->db->getData($sql)){
			$normal = array('point'=>0,'commission'=>0);
		}
		
		//イベントポイント総数
		$sql = str_replace('##type##', '2', $base_sql);
		if(!$event = $this->db->getData($sql)){
			$event = array('point'=>0,'commission'=>0);
		}
		//特別ポイント総数
		$sql = str_replace('##type##', '3', $base_sql);
		if(!$special = $this->db->getData($sql)){
			$special = array('point'=>0,'commission'=>0);
		}
		
		$normal_point  = $normal['point'];
		$event_point   = $event['point'];
		$special_point = $special['point'];
		$commission    = $normal['commission'] + $event['commission'] + $special['commission'];
		
		$param = array(
			'issue_point'        =>$total['total_price']-$minus['total_price'],
			'use_point'          =>$total['use_point']-$minus['use_point'],
			'use_point_cancel'   =>$minus['use_point'],
			'issue_point_cancel' =>$minus['total_price'],
			'normal_point'       => $normal_point,
			'event_point'        => $event_point,
			'special_point'      => $special_point,
			'total_commission'   => $commission,
		);
		
		
		return $this->updateById($bill['bill_id'],$param);
	}
}