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
			'action_type',
			'action_name',
			'issue_point',
			'commission',
			'use_point',
			'total_price',
			'cancel_flg',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	
	/**
	 * 予約データを元にデータ生成
	 * 
	 * @param type $reserved_id
	 */
	public function issueByReservedId($reserved_id){
		$manager = Management::getInstance();
		$reserve = $manager->db_manager->get('reserved')->findById($reserved_id);
		$coupon  = $manager->db_manager->get('coupon')->findById($reserve['coupon_id']);
		
		//通常の場合
		if($coupon['point_kind'] == 1){
			return $this->issueNormalPoint($reserve);
		}
		//イベントの場合
		elseif($coupon['point_kind'] == 2){
			return $this->issueEventPoint($reserve);
		}
	}
	
	/**
	 * 予約ＩＤに該当するデータを元に、キャンセルデータを生成
	 * 
	 * @param type $reserved_id
	 */
	public function cancelByReservedId($reserved_id){
		
		if($reserved_id == 0){ return false;}
		if(!$bill_action = $this->getIssueByReservedId($reserved_id)){
			 return false;
		}
		
		$regist_date =$update_date = date('Y-m-d H:i:s');
		
		unset($bill_action['bill_action_id']);
		$bill_action['regist_date'] = $regist_date;
		$bill_action['update_date'] = $update_date;
		$bill_action['cancel_flg']  = 1;
		if($bill_action['action_type'] == 1){
			$bill_action['action_name'] = '通常ポイントキャンセル';
		}else{
			$bill_action['action_name'] = 'イベントポイントキャンセル';
		}
		return $this->insert($bill_action);
	}
	
	/**
	 * イベントポイント発行
	 * 
	 * @param array $reserve 予約情報
	 * @return mixed false もしくは id
	 */
	private function issueEventPoint($reserve){
		$store_id    = $reserve['store_id'];
		$reserved_id = $reserve['reserved_id'];
		$issue_point = $reserve['get_point'];
		$use_point   = $reserve['use_point'];
		$action_name = "イベントポイント発行";
		
		$param = array(
			'store_id'   => $store_id,
			'reserved_id' => $reserved_id,
			'action_name'=> $action_name,
			'action_type'=> 2,
			'issue_point'=> $issue_point,
			'use_point'  => $use_point,
			'commission' => $issue_point,
			'total_price' => $issue_point+$issue_point,
			'cancel_flg'  => 0,
		);
		
		return $this->insert($param);
	}
	
	/**
	 * 通常発行
	 * 
	 * @param array $reserve 予約情報
	 * @return mixed false もしくは id
	 */
	private function issueNormalPoint($reserve){
		$store_id    = $reserve['store_id'];
		$reserved_id  = $reserve['reserved_id'];
		$issue_point = $reserve['get_point'];
		$use_point   = $reserve['use_point'];
		$action_name = "通常ポイント発行";
		
		$param = array(
			'store_id'   => $store_id,
			'reserved_id'=> $reserved_id,
			'action_name'=> $action_name,
			'action_type'=> 1,
			'issue_point'=> $issue_point,
			'use_point'  => $use_point,
			'commission' => 500,
			'total_price'=> $issue_point+500,
			'cancel_flg' => 0,
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
			'store_id'   => $store_id,
			'action_name'=> $name,
			'action_type'=> 3,
			'issue_point'=> $point,
			'use_point'  => 0,
			'commission' => 0,
			'total_price' => $point,
			'cancel_flg'  => 0,
		);
		return $this->insert($param);
	}
	
	
	
	/**
	 * 予約IDからデータを取得
	 */
	public function getIssueByReservedId($reserved_id){
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE reserved_id = '{$reserved_id}' AND cancel_flg = 0 LIMIT 0,1 ";
		
		return $this->db->getData($sql);
	}
	
	
	public function findByStoreId_Month($store_id,$month){
		$field = $this->getFieldText();
		
		$sql = "SELECT {$field} FROM {$this->table} WHERE store_id = '{$store_id}' AND regist_date LIKE '{$month}-__ __:__:__' ORDER BY regist_date Desc";
		
		return $this->db->getAllData($sql);
	}
}