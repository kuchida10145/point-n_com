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
		
		$sql ="SELECT sum(total_price) as total_price,sum(use_point) as use_point FROM bill_action WHERE store_id = '{$store_id}' AND regist_date LIKE '{$year_month}%' GROUP BY store_id ";
		
		$total = $this->db->getData($sql);
		
		$sql ="SELECT sum(total_price) as total_price,sum(use_point) as use_point FROM bill_action WHERE store_id = '{$store_id}' AND data_type = 1 AND regist_date LIKE '{$year_month}%' GROUP BY store_id ";
		$minus = $this->db->getData($sql);
		
		$param = array(
			'issue_point'     =>$total['total_price']-$minus['total_price'],
			'use_point'       =>$total['use_point']-$minus['use_point'],
			'use_point_cancel'=>$minus['use_point'],
			'issue_point_cancel'   =>$minus['total_price'],
		);
		
		return $this->updateById($bill['bill_id'],$param);
	}
}