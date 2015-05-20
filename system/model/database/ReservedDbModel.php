<?php
/**
 * 予約情報
 */
class ReservedDbModel extends DbModel{


	
	public function getField(){
		return array(
			'reserved_id',
			'store_id',
			'user_id',
			'coupon_id',
			'point_code',
			'status_id',
			'course_name',
			'coupon_name',
			'minutes',
			'price',
			'use_condition',
			'reserved_date',
			'use_persons',
			'use_date',
			'reserved_name',
			'telephone',
			'total_price',
			'use_point',
			'get_point',
			'regist_date',
			'update_date',
			'delete_flg'

		);
	}
	
	
	
	
	/*==========================================================================================
	 * 管理者用請求処理
	 *
	 *==========================================================================================*/


	/**
	 * 検索結果最大取得件数（管理者用）
	 * @param array $get
	 * @return int
	 */
	public function adminClaimSearchMaxCnt($get=array()){
		$sql = $this->adminClaimSearchSqlBase($get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（管理者用）
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function adminClaimSearch($get,$limit,$order){
		$sql = $this->adminClaimSearchSqlBase($get);
		$sql = str_replace("##field##","reserved_id,use_date,store_name,reserved.user_id,user.email,reserved_name,course_name,coupon_name,get_point,use_point", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}


	protected function adminClaimSearchSqlBase($get){
		//フィールドは各メソッド内で変換
		$where = $this->adminClaimSearchWhere($get);
		$sql = "SELECT ##field## FROM {$this->table},store,user {$where}";
		
		return $sql;
	}


	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminClaimSearchWhere($get){
		$where = ' WHERE delete_flg = 0 ';
		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " reserved.store_id = store.store_id ";
		$wheres[] = " user.user_id = reserved.user_id ";
		$wheres[] = " reserved.status_id = 2 ";
		
		//店舗名
		if(getParam($get,'store_name') != ''  && is_string(getParam($get,'store_name'))){
			$store_name = $this->escape_string(getParam($get, 'store_name'));
			$wheres[] = " store.store_name LIKE '%{$store_name}%' ";
		}
		//利用開始日
		if(getParam($get,'use_start') != ''  && is_string(getParam($get,'use_start'))){
			$use_start = $this->escape_string(getParam($get,'use_start'));
			$wheres[] = " reserved.use_date > '{$use_start}' ";
		}
		
		//利用終了日
		if(getParam($get,'use_end') != ''  && is_string(getParam($get,'use_end'))){
			$use_end = $this->escape_string(getParam($get,'use_end'));
			$wheres[] = " reserved.use_date < '{$use_end}' ";
		}
		
		
		//業種
		if(is_array(getParam($get,'type_of_industry_id'))){
			$type_of_industry_ids = array();
			foreach(getParam($get,'type_of_industry_id') as $val){
				if(!is_digit($val)){ continue;}
				$type_of_industry_ids[] = $val;
			}
			if(count($type_of_industry_ids) > 0){
				$wheres[] = " store.type_of_industry_id IN(".implode(',',$type_of_industry_ids).") ";
			}
		}
		
		//クーポン発行
		if(getParam($get,'coupon') == '1'){
			$wheres[] = " reserved.coupon_id != 0 AND reserved.get_point > 0 ";
		}
		//ポイント利用
		else{
			$wheres[] = " reserved.use_point > 0 ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		
		return $where;
	}

	
	
	/*==========================================================================================
	 * 店舗用共通処理
	 *
	 *==========================================================================================*/


	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	public function maintenanceClaimSearchMaxCnt($id,$get=array()){
		$sql = $this->maintenanceClaimSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function maintenanceClaimSearch($id,$get,$limit,$order){
		$sql = $this->maintenanceClaimSearchSqlBase($get);
		$sql = str_replace("##field##",$this->getFieldText(), $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	protected function maintenanceClaimSearchSqlBase($id,$get){
		//フィールドは各メソッド内で変換
		$where = $this->maintenanceClaimSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM {$this->table} {$where}";
		return $sql;
	}


	/**
	 * WHERE句生成（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceClaimSearchWhere($id,$get){
		$where = "";
		
		$wheres[] = " reserved.del_flg = 0 ";
		$wheres[] = " reserved.store_id = '{$id}' ";
		$wheres[] = " reserved.store_id = store.store_id ";
		$wheres[] = " reserved.status_id = 2 ";
		
		//利用開始日
		if(getParam($get,'use_start') != ''  && is_string(getParam($get,'use_start'))){
			$use_start = $this->escape_string(getParam($get,'use_start'));
			$wheres[] = " reserved.use_date >= '{$use_start}' ";
		}
		
		//利用終了日
		if(getParam($get,'use_end') != ''  && is_string(getParam($get,'use_end'))){
			$use_end = $this->escape_string(getParam($get,'use_end'));
			$wheres[] = " reserved.use_date <= '{$use_end}' ";
		}
		
		//クーポン発行
		if(getParam($get,'coupon') == '1'){
			$wheres[] = " reserved.coupon_id != 0 AND reserved.get_point > 0 ";
		}
		//ポイント利用
		else{
			$wheres[] = " reserved.use_point > 0 ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		return $where;
	}
}