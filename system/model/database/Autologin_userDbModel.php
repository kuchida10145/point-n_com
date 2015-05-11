<?php
/**
 * 自動ログインユーザー
 */
class Autologin_userDbModel extends DbModel{


	public function getField(){
		return array(
			'autologin_user_id',
			'login_key',
			'user_id',
			'limit_date',
			'delete_flg'
		);
	}
}
