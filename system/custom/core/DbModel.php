<?php
/**
 * プロジェクト独自のDbModelクラス
 *
 * Dbモデルに関数を加える場合はこのクラスに追加すること。
 *
 */
class DbModel extends Base_DbModel{


	/**
	 * IDに該当するデータを取得
	 * 削除フラグの関係でオーバーライド
	 *
	 * @param int $id
	 * @return array
	 */
	public function findById($id) {
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE {$this->primary_key} = '{$id}' AND delete_flg = 0 LIMIT 0,1";
		return $this->db->getData($sql);
	}

	/**
	 * IDに該当するデータを取得
	 * 削除フラグに関係なく取得できる
	 *
	 * @param type $id
	 * @return array
	 */
	public function findDataById($id){
		parent::findById($id);
	}


	/**
	 * IDに該当するデータを削除（削除フラグを立てる）
	 * 削除フラグの関係でオーバーライド
	 *
	 * @param int $id
	 * @return bool
	 */
	public function deleteById($id){
		return $this->updateById($id, array('delete_flg'=>'1'));
	}

	/**
	 *  IDに該当するデータを削除（完全削除）
	 *
	 * @param int $id
	 * @return bood
	 */
	public function deleteCompById($id){
		return parent::deleteById($id);
	}

	/*==========================================================================================
	 * 管理者用共通処理
	 *
	 *==========================================================================================*/


	/**
	 * 検索結果最大取得件数（管理者用）
	 * @param array $get
	 * @return int
	 */
	public function adminSearchMaxCnt($get=array()){
		$sql = $this->adminSearchSqlBase($get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);



		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（管理者用）
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function adminSearch($get,$limit,$order){
		$sql = $this->adminSearchSqlBase($get);
		$sql = str_replace("##field##",$this->getFieldText(), $sql);
		$sql = $sql." {$order} {$limit}";

		return $this->db->getAllData($sql);
	}


	protected function adminSearchSqlBase($get){

		//フィールドは各メソッド内で変換
		$where = $this->adminSearchWhere($get);
		$sql = "SELECT ##field## FROM {$this->table} {$where}";

		return $sql;
	}


	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){
		$where = ' WHERE delete_flg = 0 ';
		return $where;
	}



	/*==========================================================================================
	 * 店舗用共通処理
	 *
	 *==========================================================================================*/


	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	public function maintenanceSearchMaxCnt($id,$get=array()){
		$sql = $this->maintenanceSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function maintenanceSearch($id,$get,$limit,$order){
		$sql = $this->maintenanceSearchSqlBase($id,$get);
		$sql = str_replace("##field##",$this->getFieldText(), $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	protected function maintenanceSearchSqlBase($id,$get){
		//フィールドは各メソッド内で変換
		$where = $this->maintenanceSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM {$this->table} {$where}";
		return $sql;
	}


	/**
	 * WHERE句生成（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceSearchWhere($id,$get){
		$where = " WHERE store_id = '{$id}' AND delete_flg = 0 ";
		return $where;
	}



}