<?php
/**
 * ユーザーお気に入り店舗
 */
class User_favorite_storeDbModel extends DbModel{



	public function getField(){
		return array(
			'favorite_id',
			'user_id',
			'store_id',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}



}