<?php
/**
 * 自動ログイン管理(店舗用)
 */
class Autologin_storeDbModelDbModel extends DbModel{


	public function getField(){
		return array(
			'autologin_store_id',
			'store_id',
			'login_key',
			'limit_date',
			'delete_flg'
		);
	}
}
