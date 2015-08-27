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
			'minutes',
			'price',
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
		if(getParam($get,'coupon_id') != '' && getParam($get,'coupon_id')){
			$coupon_id = $this->escape_string(getParam($get,'coupon_id'));
			$wheres[] = " coupon_id = '{$coupon_id}' ";
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

	/**
	 * 店舗IDが一致するデータを全件取得
	 *
	 * @param string $store_id 店舗ID
	 * @return array
	 */
	public function couponList($store_id){
		$store_id = $this->escape_string($store_id);
		$field = $this->getFieldText();

		$sql = "SELECT {$field} FROM coupon WHERE store_id = '{$store_id}' AND delete_flg = 0";

		return $this->db->getAllData($sql);
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
			course.minutes as course_minutes,
			course.price as course_price,
			coupon.minutes as coupon_minutes,
			coupon.price as coupon_price,
			coupon.coupon_name,
			coupon.use_condition,
			coupon.coupon_id
		FROM
			`coupon`,
			`course`
		WHERE
			coupon.store_id = '".$store_id."'
			AND coupon.course_id = course.course_id
			AND coupon.status_id = '".ST_ACT."'
			AND coupon.delete_flg = '0'";
		return $this->db->getAllData($sql);
	}
}