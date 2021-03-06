<?php
/**
 * コース情報
 */
class CourseDbModel extends DbModel{

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
			'point_only_flg',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

	/**
	 * 店舗IDとポイント種別が一致するデータを全件取得
	 *
	 * @param string $store_id 店舗ID
	 * @param string $point_kind ポイント種別
	 * @return array
	 */
	public function courseList($store_id,$point_only = NULL){
		$store_id = $this->escape_string($store_id);
		$field = $this->getFieldText();

		if($point_only == 1) {
			$sql = "SELECT {$field} FROM course WHERE store_id = '{$store_id}' AND point_only_flg = 1 AND delete_flg = 0";
		} else {
			$sql = "SELECT {$field} FROM course WHERE store_id = '{$store_id}' AND delete_flg = 0";
		}
		return $this->db->getAllData($sql);
	}

}