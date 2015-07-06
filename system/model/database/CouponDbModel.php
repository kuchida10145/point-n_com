<?php
/**
 * クーポン
 */
class CouponDbModel extends DbModel{



	public function getField(){
		return array(
			'coupon_id',
			'course_id',
			'store_id',
			'status_id',
			'point_kind',
			'coupon_name',
			'point',
			'use_condition',
			'public_start_date',
			'public_end_date',
			'regist_date',
			'update_date',
			'delete_flg'
		);
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
	protected function maintenanceSearchWhere($id, $get){

		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		$wheres[] = " store_id = '{$id}'";
		//名前が設定されている場合
		if(getParam($get,'account_name') != '' && getParam($get,'account_name')){
			$name = $this->escape_string(getParam($get,'account_name'));
			$wheres[] = " account_name LIKE '%{$name}%' ";
		}

		//クーポン種別が設定されている場合
		if(getParam($get,'point_kind') != '' && getParam($get,'point_kind')){
			$point_kind = $this->escape_string(getParam($get,'point_kind'));
			$wheres[] = " point_kind = '{$point_kind}' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}

	/**
	 * クーポン有効処理
	 *
	 *  @param int $store_id
	 *  @param string $coupon_id
	 *  @param string $point_kind
	 *  @return Bool 結果
	 */
	public function updateForce($store_id,$coupon_id, $point_kind) {
		$where = " store_id = '{$store_id}' AND status_id = ".ST_ACT." AND point_kind = ".$point_kind;
		$param = array(
				'status_id'=>'0',
		);

		if($this->update($param,$where)){
			$param = array(
					'status_id'=>'1',
			);
			return $this->updateById($coupon_id, $param);
		}
		return FALSE;
	}

	/*==========================================================================================
	 * フロント共通処理
	 *
	 *==========================================================================================*/
	/**
	 * store_idから有効なクーポン情報を取得する
	 * @param int $store_id 店舗id
	 * @return array:
	 */
	public function storeCouponDetailSearch($store_id){
		$sql = "
		SELECT
			coupon.point,
			coupon.point_kind,
			course.minutes,
			course.price,
			coupon.coupon_name,
			coupon.use_condition,
			coupon.coupon_id
		FROM
			`coupon`,
			`course`
		WHERE
			coupon.store_id = '".$store_id."'
			AND coupon.course_id = course.course_id
			AND coupon.status_id = '".ST_ACT."'";
		return $this->db->getAllData($sql);
	}
}