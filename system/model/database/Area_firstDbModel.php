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
			'delivery',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}
	
	/**
	 * 指定したキーのレコードを取得する
	 * 
	 * @param string $category_large_id カテゴリーID
	 * @param string $region_id 地域ID
	 * @param string $is_delivery デリバリー
	 * @param string $prefectures_id 都道府県ID
	 * @param string $prefectures_name 都道府県名
	 * @return array
	 */
	public function searchForCategoryLargeId($category_large_id, $region_id, $is_delivery, $prefectures_id = null, $prefectures_name = null) {
		$wheres = array();
		$wheres[] = 'category_large_id = ' . $category_large_id;
		$wheres[] = 'region_id = ' . $region_id;
		$wheres[] = "delivery = '" . $is_delivery . "'";
		if ($prefectures_id != null && $prefectures_name != null) {
			$wheres[] = "(prefectures_id = " . $prefectures_id . " OR area_first_name = '" . $prefectures_name . "')";
		}
		return $this->adminSearch($wheres, "", " ORDER BY area_first_id ASC ");
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