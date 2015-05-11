<?php
/**
 * 第２エリアマスター
 */
class Area_secondDbModel extends DbModel{


	public function getField(){
		return array(
			'area_second_id',
			'area_first_id',
			'area_second_name',
			'delivery',
			'rank'
		);
	}

}