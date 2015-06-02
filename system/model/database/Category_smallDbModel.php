<?php
/**
 * 小カテゴリーマスター
 */
class Category_smallDbModel extends DbModel{



	public function getField(){
		return array(
			'category_small_id',
			'category_midium_id',
			'category_small_name',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	/**
	 * 小カテゴリーリストを取得する
	 * 
	 * @param string $category_midium_id 中カテゴリーID
	 * @return array
	 */
	public function categoryList($category_midium_id) {
		$wheres = array();
		$wheres[] = 'category_midium_id = ' . $category_midium_id;
		return $this->adminSearch($wheres, "", " ORDER BY rank ASC ");
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