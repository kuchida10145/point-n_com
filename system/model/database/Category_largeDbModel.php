<?php
/**
 * 大カテゴリーマスター
 */
class Category_largeDbModel extends DbModel{



	public function getField(){
		return array(
			'category_large_id',
			'category_large_name',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	/**
	 * 大カテゴリーリストを取得する
	 * 
	 * @return array
	 */
	public function categoryList() {
		return $this->adminSearch("", "", " ORDER BY rank ASC ");
	}
}