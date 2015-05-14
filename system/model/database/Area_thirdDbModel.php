<?php
/**
 * 第３エリアマスター
 */
class Area_thirdDbModel extends DbModel{


	public function getField(){
		return array(
			'area_third_id',
			'area_second_id',
			'area_third_name',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}
}
