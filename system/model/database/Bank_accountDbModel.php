<?php
/**
 * 銀行口座
 */
class Bank_accountDbModel extends DbModel{



	public function getField(){
		return array(
			'bank_account_id',
			'store_id',
			'bank_name',
			'bank_kind',
			'bank_account_number',
			'bank_account_holder',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
}