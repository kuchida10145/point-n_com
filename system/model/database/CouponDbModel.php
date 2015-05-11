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
}