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
			'branch_name',
			'bank_kind',
			'bank_account_number',
			'bank_account_holder',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	/**
	 * 店舗IDをキーとしてレコードを取得する
	 * 
	 * @param string $store_id 店舗ID
	 * @return array
	 */
	public function searchForStoreId($store_id) {
		$where  = ' store_id = ' . $store_id . ' ';
		$where .= ' AND delete_flg = 0 ';
		$order = 'bank_account_id ASC';
		return $this->search($where, '', $order);
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