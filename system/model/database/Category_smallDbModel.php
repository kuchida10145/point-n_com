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
}