<?php
/**
 * 会員ＤＢモデル
 */
class UserDbModel extends DbModel{



	public function getField(){
		return array(
			'user_id',
			'nickname',
			'email',
			'birthday',
			'gender',
			'prefectures_id',
			'password',
			'point',
			'status_id',
			'latest_login_date',
			'regist_date',
			'update_date',
			'delete_flg'

		);
	}



}