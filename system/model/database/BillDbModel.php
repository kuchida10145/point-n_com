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
			'issue_point',
			'use_point',
			'deposit_price',
			'adjust_price',
			'pay_status',
			'regist_date',
			'update_date',
		);
	}


	


}