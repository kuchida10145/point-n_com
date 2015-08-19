<?php
/**
 * 利用枠追加テーブル
 */
class Add_limitDbModel extends DbModel{



	public function getField(){
		return array(
			'add_limit_id',
			'store_id',
			'add_date',
			'add_point',
			'add_type',
			'memo',
			'review_status',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}


	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceSearchWhere($id,$get){
		
		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		
		$wheres[] = " store_id = '{$id}' ";
		
		//月が設定されている場合
		if(getParam($get,'month') != '' && getParam($get,'year') != '' ){
			$month = getParam($get,'month');
			$year = getParam($get,'year');
			$month = $this->escape_string($month);
			$year  = $this->escape_string($year);
			$wheres[] = " add_date LIKE '{$year}-{$month}-__' ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		
		return $where;
	}
	
	/*==========================================================================================
	 * 管理者用共通処理
	 *
	 *==========================================================================================*/
	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){
		
		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		
		
		$store_id = getParam($get,'store_id');
		
		$wheres[] = " store_id = '{$store_id}' ";
		
		//月が設定されている場合
		if(getParam($get,'month') != '' && getParam($get,'year') != '' ){
			$month = getParam($get,'month');
			$year = getParam($get,'year');
			$month = $this->escape_string($month);
			$year  = $this->escape_string($year);
			$wheres[] = " add_date LIKE '{$year}-{$month}-__' ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		
		return $where;
	}
	
	
	/**
	 * 入金日最小日付取得
	 * 
	 * @param type $store_id
	 * @return type
	 */
	public function getMinDateByStoreId($store_id){
		$sql = "SELECT add_date FROM {$this->table} WHERE store_id = '{$store_id}' ORDER BY add_date LIMIT 0,1 ";
		if(!$res = $this->db->getData($sql)){
			return NULL;
		}
		return $res['add_date'];
	}
	
	
	/**
	 * 毎月の利用枠分のデータを挿入（CRONで実行)
	 */
	public function addBasePointCron(){
		$regist_date = $update_date = date('Y-m-01 H:i:s');
		$add_date    = date('Y-m-01');
		$memo        = "基本利用枠付与";
		$sql = "INSERT INTO add_limit (store_id,add_date,add_point,review_status,add_type,memo,regist_date,update_date) ";
		$sql.= "(SELECT store_id,'{$add_date}',base_point,'1','2','{$memo}','{$regist_date}','{$update_date}' FROM store WHERE delete_flg = 0 )";
		$this->db->query($sql);
	}

}