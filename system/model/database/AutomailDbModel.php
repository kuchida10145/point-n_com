<?php
/**
 * 自動返信メールＤＢモデル
 */
class AutomailDbModel extends DbModel{



	public function getField(){
		return array(
			'automail_id',
			'name',
			'subject',
			'from_name',
			'from_mail',
			'return_path',
			'body',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
}