<?php
/**
 * 自動ログイン管理(管理用)
 */
class Autologin_accountDbModel extends DbModel{


	public function getField(){
		return array(
			'autologin_account_id',
			'login_key',
			'account_id',
			'limit_date',
			'delete_flg',
		);
	}
}
