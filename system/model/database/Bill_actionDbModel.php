<?php
/**
 * 請求アクション
 */
class Bill_actionDbModel extends DbModel{



	public function getField(){
		return array(
			'bill_action_id',
			'store_id',
			'reserved_id',
			'action_name',
			'cancel_flg',
			'reserved_status_id',
			'n_point',
			'n_point_commission',
			'e_point',
			'e_point_commission',
			'sp_point',
			'sp_point_commission',
			'use_n_point',
			'use_e_point',
			'use_point',
			'n_point_cancel',
			'n_point_cancel_commission',
			'e_point_cancel',
			'e_point_cancel_commission',
			'use_n_point_cancel',
			'use_e_point_cancel',
			'use_point_cancel',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	
	public function getMonthDataByStoreId($store_id,$year_month){
		$field = $this->getFieldText();
		
		$sql = "SELECT {$field} FROM {$this->table} WHERE store_id = '{$store_id}' AND regist_date LIKE '{$year_month}-__ __:__:__' ORDER BY regist_date DESC";
		
		return $this->db->getAllData($sql);
	}
	
	/**
	 * 予約データを元にデータ生成
	 * 
	 * @param type $reserved_id
	 */
	public function issueByReservedId($reserved_id){
		$manager = Management::getInstance();
		$reserve = $manager->db_manager->get('reserved')->findById($reserved_id);
		
		
		$action_name = "[ポイントコード:{$reserve['point_code']}]".$reserve['reserved_name'];
		
		//ポイントのみ利用の場合
		if($reserve['coupon_id'] == 0){
			if($reserve['use_point'] == 0){ return NULL;}
			return $this->onlyUsePoint($reserve,$action_name);
		}
		
		$coupon  = $manager->db_manager->get('coupon')->findById($reserve['coupon_id']);
		
		//通常の場合
		if($coupon['point_kind'] == 1){
			return $this->issueNormalPoint($reserve,$action_name);
		}
		//イベントの場合
		elseif($coupon['point_kind'] == 2){
			return $this->issueEventPoint($reserve,$action_name);
		}
	}
	
	/**
	 * 予約ＩＤに該当するデータを元に、キャンセルデータを生成
	 * 
	 * @param type $reserved_id
	 * @param type $reserved_status
	 */
	public function cancelByReservedId($reserved_id,$reserved_status){
		
		if($reserved_id == 0){ return false;}
		if(!$bill_action = $this->getNotAcceptByReservedId($reserved_id)){
			 return false;
		}
		//元データのキャンセルフラグ立てる
		$this->updateById($bill_action['bill_action_id'], array('reserved_status_id'=>$reserved_status));
		
		
		$regist_date = $update_date = date('Y-m-d H:i:s');
		
		unset($bill_action['bill_action_id']);
		
		$bill_action['reserved_status']  = $reserved_status;
		
		$ins_data = array();
		$ins_data['reserved_id'] = $reserved_id;
		$ins_data['regist_date'] = $regist_date;
		$ins_data['update_date'] = $update_date;
		$ins_data['cancel_flg']  = 1;
		$ins_data['store_id']    = $bill_action['store_id'];
		$ins_data['reserved_status_id']    = RESERVE_ST_INV;
		//通常ポイントキャンセル
		if($bill_action['n_point'] != 0){
			$ins_data['action_name']               = $bill_action['action_name'];
			$ins_data['n_point_cancel']            = $bill_action['n_point'];
			$ins_data['n_point_cancel_commission'] = $bill_action['n_point_commission'];
			$ins_data['use_n_point_cancel']        = $bill_action['use_n_point'];
		}
		//イベントポイントキャンセル
		elseif($bill_action['e_point'] != 0){
			$ins_data['action_name']	           = $bill_action['action_name'];
			$ins_data['e_point_cancel']            = $bill_action['e_point'];;
			$ins_data['e_point_cancel_commission'] = $bill_action['e_point_commission'];
			$ins_data['use_e_point_cancel']        = $bill_action['use_e_point'];
		}
		//ポイントのみ利用キャンセル
		elseif($bill_action['use_point'] != 0){
			$ins_data['action_name']      = $bill_action['action_name'];
			$ins_data['use_point_cancel'] = $bill_action['use_point'];
		}
		return $this->insert($ins_data);
	}
	
	/**
	 * イベントポイント発行
	 * 
	 * @param array $reserve 予約情報
	 * @return mixed false もしくは id
	 */
	private function issueEventPoint($reserve,$action_name){
		$store_id    = $reserve['store_id'];
		$reserved_id = $reserve['reserved_id'];
		$event_point = $reserve['get_point'];
		$use_point   = $reserve['use_point'];
		//$action_name = "イベントポイント発行";
		
		$param = array(
			'store_id'    => $store_id,
			'reserved_id' => $reserved_id,
			'action_name' => $action_name,
			'use_e_point' => $use_point,
			'e_point'     => $event_point,
			'e_point_commission' => $event_point,
			'reserved_status_id'=>$reserve['status_id']
		);
		
		return $this->insert($param);
	}
	
	/**
	 * ポイントのみ利用の場合
	 * 
	 * @param array $reserve 予約情報
	 * @return mixed false もしくは id
	 */
	private function onlyUsePoint($reserve,$action_name){
		$store_id    = $reserve['store_id'];
		$reserved_id = $reserve['reserved_id'];
		$use_point   = $reserve['use_point'];
		//$action_name = "ポイントのみ利用";
		
		$param = array(
			'store_id'          => $store_id,
			'reserved_id'       => $reserved_id,
			'action_name'       => $action_name,
			'use_point'         => $use_point,
			'reserved_status_id'=>$reserve['status_id']
		);
		
		return $this->insert($param);
	}
	
	/**
	 * 通常発行
	 * 
	 * @param array $reserve 予約情報
	 * @return mixed false もしくは id
	 */
	private function issueNormalPoint($reserve,$action_name){
		$store_id     = $reserve['store_id'];
		$reserved_id  = $reserve['reserved_id'];
		$normal_point = $reserve['get_point'];
		$use_point    = $reserve['use_point'];
		//$action_name = "通常ポイント発行";
		
		$param = array(
			'store_id'     => $store_id,
			'reserved_id'  => $reserved_id,
			'action_name'  => $action_name,
			'use_n_point'  => $use_point,
			'n_point'      => $normal_point,
			'n_point_commission'   => 500,
			'reserved_status_id'=>$reserve['status_id']
		);
		
		return $this->insert($param);
	}
	
	/**
	 * 特別付与ポイント発行
	 * 
	 * @param int $store_id 店舗ID
	 * @param int $point 発行ポイント
	 * @param string $name アクション名
	 * @return mixed false もしくは id
	 */
	public function issueSpecialPoint($store_id,$point,$name='特別付与ポイント発行'){
		$param = array(
			'store_id'            => $store_id,
			'action_name'         => $name,
			'sp_point'            => $point,
			'sp_point_commission' => $point,
			'reserved_status_id'  => RESERVE_ST_FIN,
		);
		return $this->insert($param);
	}
	
	
	
	/**
	 * 予約IDからデータを取得(未受理のもののみ)
	 */
	public function getNotAcceptByReservedId($reserved_id){
		$status_id = RESERVE_ST_YET;
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE reserved_id = '{$reserved_id}' AND reserved_status_id = '{$status_id}' LIMIT 0,1 ";
		return $this->db->getData($sql);
	}
	
	
	public function findByStoreId_Month($store_id,$month){
		$field = $this->getFieldText();
		
		$sql = "SELECT {$field} FROM {$this->table} WHERE store_id = '{$store_id}' AND regist_date LIKE '{$month}-__ __:__:__' ORDER BY regist_date Desc";
		
		return $this->db->getAllData($sql);
	}
	
	
	
	public function getYearMonthPointSumByStoreId($store_id,$year_month){
		//--下記の項目を取得--
		//ポイント、ポイント手数料、イベントポイント、イベントポイント手数料、特別ポイント、
		//使用されたポイント、使用されたポイント（イベント）、使用されたポイント（ポイントのみ）
		//特別ポイント、特別ポイント手数料
		//ポイントキャンセル、ポイント手数料キャンセル、イベントポイントキャンセル、イベントポイント手数料キャンセル
		//使用されたポイントキャンセル、使用されたポイント（イベント）キャンセル、使用されたポイント（ポイントのみ）キャンセル
		$fields = array(
			'n_point',
			'n_point_commission',
			'e_point',
			'e_point_commission',
			'sp_point',
			'sp_point_commission',
			'use_n_point',
			'use_e_point',
			'use_point',
			'n_point_cancel',
			'n_point_cancel_commission',
			'e_point_cancel',
			'e_point_cancel_commission',
			'use_n_point_cancel',
			'use_e_point_cancel',
			'use_point_cancel',
		);
		$new_fields = array();
		foreach($fields as $f_key => $f_val){
			$new_fields[$f_key] = "SUM({$f_val}) as {$f_val} ";
		}
		$field = implode(',',$new_fields);
		$reserved_status = RESERVE_ST_INV;//未受理を含める
		//$sql = "SELECT {$field} FROM bill_action WHERE store_id = {$store_id} AND reserved_status_id != '{$reserved_status}' AND regist_date LIKE '{$year_month}-__ __:__:__' GROUP BY store_id";
		$sql = "SELECT {$field} FROM bill_action WHERE store_id = {$store_id} AND  regist_date LIKE '{$year_month}-__ __:__:__' GROUP BY store_id";
		
		if($res = $this->db->getData($sql)){
			return $res;
		}
		else{
			$res = array();
			foreach($fields as $val){
				$res[$val] = 0;
			}
			return $res;
		}
	}
	
	
	public function getNoneAcceptYearMonthPointSumByStoreId($store_id,$year_month){
		//--下記の項目を取得--
		//ポイント、ポイント手数料、イベントポイント、イベントポイント手数料、特別ポイント、
		//使用されたポイント、使用されたポイント（イベント）、使用されたポイント（ポイントのみ）
		//特別ポイント、特別ポイント手数料
		//ポイントキャンセル、ポイント手数料キャンセル、イベントポイントキャンセル、イベントポイント手数料キャンセル
		//使用されたポイントキャンセル、使用されたポイント（イベント）キャンセル、使用されたポイント（ポイントのみ）キャンセル
		$fields = array(
			'n_point',
			'n_point_commission',
			'e_point',
			'e_point_commission',
			'use_n_point',
			'use_e_point',
			'use_point',
		);
		$new_fields = array();
		foreach($fields as $f_key => $f_val){
			$new_fields[$f_key] = "SUM({$f_val}) as {$f_val} ";
		}
		$field = implode(',',$new_fields);
		$reserved_status = RESERVE_ST_YET;
		$sql = "SELECT {$field} FROM bill_action WHERE store_id = {$store_id} AND reserved_status_id = '{$reserved_status}' AND regist_date LIKE '{$year_month}-__ __:__:__' GROUP BY store_id";
		
		if($res = $this->db->getData($sql)){
			return $res;
		}
		else{
			$res = array();
			foreach($fields as $val){
				$res[$val] = 0;
			}
			return $res;
		}
	}
}