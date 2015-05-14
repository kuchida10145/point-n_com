<?php
/**
 * 地域マスター
 */
class Region_masterDbModel extends DbModel{


	public $primary_key = 'region_id';//プライマリーキー
	
	public function getField(){
		return array(
			'region_id',
			'region_name',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}
}