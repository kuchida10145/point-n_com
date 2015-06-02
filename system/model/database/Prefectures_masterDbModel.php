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
	 * 都道府県リストを取得する
	 * 
	 * @return array
	 */
	public function prefecturesList() {
		return $this->adminSearch("", "", " ORDER BY prefectures_id ASC ");
	}
	
	/**
	 * 都道府県名をキーとしてレコードを取得する
	 * 
	 * @param string $prefectures_name 都道府県名
	 * @return array
	 */
	public function searchForPrefecturesName($prefectures_name) {
		$wheres = array();
		$wheres[] = "prefectures_name = '" . $prefectures_name . "'";
		return $this->manager->adminSearch($wheres, "", " ORDER BY prefectures_id ASC ");
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