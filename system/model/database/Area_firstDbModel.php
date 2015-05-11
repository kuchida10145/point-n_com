<?php
/**
 * 第１エリアマスター
 */
class Area_firstDbModel extends DbModel{


	public function getField(){
		return array(
			'area_first_id',
			'category_large_id',
			'region_id',
			'prefectures_id',
			'area_first_name',
			'rank'
		);
	}

}