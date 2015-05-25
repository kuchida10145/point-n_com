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
			'prefectures_name',
			'prefectures_code',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}
	
	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){
		$where = parent::adminSearchWhere($get);
		if ($get != null && is_array($get)) {
			$where .= ' AND ' . implode(" AND ", $get);
		}
		return $where;
	}
}