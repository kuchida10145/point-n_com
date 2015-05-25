<?php
/**
 * ゆうちょ銀行口座
 */
class Jpbank_accountDbModel extends DbModel{

	public $primary_key = 'bank_account_id';//プライマリーキー
	
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
	
	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){
		$where = parent::adminSearchWhere($get);
		if ($get != null && is_array($get)) {
			$where .= ' AND ' . implode(" AND ", $get);
		}
		return $where;
	}
}