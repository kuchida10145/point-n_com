<?php
/**
 * ゆうちょ銀行口座
 */
class Jpbank_accountDbModel extends DbModel{

	public function getField(){
		return array(
			'bank_account_id',
			'store_id',
			'jpbank_symbol1',
			'jpbank_symbol2',
			'jpbank_account_number',
			'jpbank_account_holder',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

}