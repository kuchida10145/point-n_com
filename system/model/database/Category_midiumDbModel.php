<?php
/**
 * 中カテゴリーマスター
 */
class Category_midiumDbModel extends DbModel{



	public function getField(){
		return array(
			'category_midium_id',
			'category_large_id',
			'region_id',
			'category_midium_name',
			'delivery',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	/**
	 * 中カテゴリーリストを取得する
	 * 
	 * @param string $category_large_id 大カテゴリーID
	 * @param string $region_id 地域ID
	 * @param string $delivery デリバリー
	 * @return array
	 */
	public function categoryList($category_large_id, $region_id, $delivery = null) {
		$wheres = array();
		$wheres[] = 'category_large_id = ' . $category_large_id;
		$wheres[] = 'region_id = ' . $region_id;
		if ($delivery !== null) {
			$wheres[] = "delivery = '" . $delivery . "'";
		}
		return $this->adminSearch($wheres, "", " ORDER BY rank ASC, category_midium_id ASC ");
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