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