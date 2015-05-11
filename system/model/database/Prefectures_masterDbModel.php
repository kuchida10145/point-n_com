<?php
/**
 * 都道府県マスター
 */
class Prefectures_masterDbModel extends DbModel{

	
	public $primary_key = 'prefectures_id';//プライマリーキー

	public function getField(){
		return array(
			'prefectures_id',
			'region_id',
			'prefectures_name'
		);
	}
}