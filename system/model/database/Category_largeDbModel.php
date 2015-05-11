<?php
/**
 * 大カテゴリーマスター
 */
class Category_largeDbModel extends DbModel{



	public function getField(){
		return array(
			'category_large_id',
			'category_large_name',
			'rank'
		);
	}
}