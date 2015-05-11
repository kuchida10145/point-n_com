<?php
/**
 * コース情報
 */
class CourceDbModel extends DbModel{

	public $primary_key = 'id';

	public function getField(){
		return array(
			'course_id',
			'store_id',
			'status_id',
			'point_kind',
			'course_name',
			'minutes',
			'price',
			'use_condition',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

}