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
			'rank'
		);
	}
}