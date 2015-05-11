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
}