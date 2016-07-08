<?php
/**
 * キャッチメール情報
 */
class CatchmailDbModel extends DbModel{


	public function getField(){
		return array(
			'catchmail_id',
			'user_id',
			'reserved_date',
			'dead_time',
			'use_persons',
			'reserved_name',
			'area_first_id',
			'area_second_id',
			'area_third_id',
			'category_large_id',
			'category_midium_id',
			'decision_store',
			'status',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

	/**
	 * 対象の会員のキャッチメールデータを取得
	 * @param int $user_id 会員ID
	 * @return array
	 */
	public function getCatchmailData($user_id){
		if(!is_numeric($user_id)){
			return NULL;
		}
		$today = date('Y-m-d H:i:s');

		$sql = "SELECT catchmail_id FROM catchmail WHERE ";
		$sql.= " user_id = {$user_id} AND ";
		$sql.= " dead_time > '{$today}' AND ";
		$sql.= " delete_flg = 0 ";
		$sql.= " ORDER BY regist_date Desc";

		return $this->db->getData($sql);
	}

	//------------------------
	//　キャッチメール管理用
	//------------------------
	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param array $account 店舗情報
	 * @param array $get
	 * @param int $cancell_flg 取消リストフラグ
	 * @return int
	 */
	public function maintenanceReserveSearchMaxCnt($account,$get=array()){
		$sql = $this->maintenanceReserveSearchSqlBase($account,$get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);

		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（店舗用）
	 * @param array $account 店舗情報
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function maintenanceRserveSearch($account,$get,$limit,$order){
		$sql = $this->maintenanceReserveSearchSqlBase($account,$get);
		$sql = str_replace("##field##","catchmail_id,user_id,reserved_date,dead_time,use_persons,reserved_name,area_first_id,area_second_id,area_third_id,category_large_id,category_midium_id,decision_store,status,regist_date,update_date,delete_flg", $sql);
		$sql = $sql." {$order} {$limit}";

		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（店舗用）
	 * @param array $account 店舗情報
	 * @param array $get
	 * @return array:
	 */
	protected function maintenanceReserveSearchSqlBase($account,$get){
		//フィールドは各メソッド内で変換
		$where = $this->maintenanceReserveSearchWhere($account,$get);
		$sql = "SELECT ##field## FROM {$this->table} {$where}";

		return $sql;
	}


	/**
	 * WHERE句生成（店舗用）
	 * @param array $account 店舗情報
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceReserveSearchWhere($account,$get){
		$where = "";

		$wheres[] = " delete_flg = 0 ";
		$wheres[] = " area_first_id = '{$this->escape_string(getParam($account,'prefectures_id'))}' ";
		$wheres[] = " area_second_id = '{$this->escape_string(getParam($account,'area_second_id'))}' ";
		$wheres[] = " area_third_id = '{$this->escape_string(getParam($account,'area_third_id'))}' ";
		$wheres[] = " category_large_id = '{$this->escape_string(getParam($account,'category_large_id'))}' ";
		$wheres[] = " category_midium_id = '{$this->escape_string(getParam($account,'category_midium_id'))}' ";

		//キャッチメール有効期限チェック
		$now_date = date('Y-m-d H:i:s');
		$wheres[] = " dead_time > '{$now_date}' ";

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}

	/**
	 * キャッチメールデータを取得
	 * @param int $user_id ユーザID
	 * @return array
	 */
	public function getCatchmailDataIsUser_id($user_id){

		$sql = "SELECT
				catchmail_id,
				decision_store
				FROM catchmail WHERE ";
		$sql.= " user_id = '{$user_id}' AND ";
		$sql.= " delete_flg = 0 ";
		$sql.= " ORDER BY regist_date Desc";

		return $this->db->getData($sql);
	}

	/**
	 * キャッチメール店舗更新
	 *  @param string $catchmail_id
	 *  @param string $store_name
	 *  @return Bool 結果
	 */
	public function updateDecisionstore($catchmail_id, $store_name) {
		$where = " catchmail_id = {$catchmail_id} ";
		$param = array(
				'decision_store'=>$store_name,
		);
		return $this->update($param,$where);
	}
}