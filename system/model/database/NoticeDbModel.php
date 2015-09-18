<?php
/**
 * お知らせ情報
 */
class NoticeDbModel extends DbModel{


	public function getField(){
		return array(
			'notice_id',
			'store_id',
			'public',
			'public_start_date',
			'public_end_date',
			'display_date',
			'title',
			'image1',
			'image2',
			'image3',
			'body',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	/**
	 * 店舗IDに対応するお知らせ一覧を取得する
	 * 
	 * @param int $store_id 店舗ID
	 * @return array
	 */
	public function getListByStoreID($store_id) {
		if ($store_id != null) {
			$store_id = $this->escape_string($store_id);
		}
		$fields = $this->getFieldText();
		$sql  = " SELECT {$fields} ";
		$sql .= " FROM {$this->table} ";
		$sql .= " WHERE ";
		if ($store_id != null) {
			$sql .= "       store_id = '{$store_id}' ";
		} else {
			$sql .= "       store_id IS NULL ";
		}
		$sql .= "   AND delete_flg = 0 ";
		return $this->db->getAllData($sql);
	}
	
	/**
	 * 一覧用データ取得
	 *
	 * @param int $store_id	 店舗ID
	 * @param int $start_page 開始番号
	 * @param int $get_page 取得する件数
	 * @return array 詳細データ複数件
	 */
	public function getNoticeList($store_id,$start_page,$get_page){
		$store_id = $this->escape_string($store_id);
		$sql = "SELECT notice_id,display_date,title,image1,image2,image3 FROM {$this->table} WHERE ";
		if($store_id == 0){
			$sql.= "(store_id IS NULL OR store_id = '{$store_id}') AND ";
		}
		else{
			$sql.= "store_id = '{$store_id}' AND ";
		}
		$sql.= "delete_flg = 0 AND ";
		$sql.= "public = 1 AND ";
		$sql.= "public_start_date < NOW() AND ";
		$sql.= "(public_end_date > NOW() OR public_end_date IS NULL) ";
		$sql.= " ORDER BY public_start_date DESC ";
		$sql.= "LIMIT {$start_page},{$get_page}";
		return $this->db->getAllData($sql);
	}

	/**
	 * 詳細データ取得
	 *
	 * @param int $id 主キー
	 * @return array 詳細データ1件
	 */
	public function getNoticeData($id){

		if(!is_numeric($id)){
			return NULL;
		}

		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE ";
		$sql.= "notice_id = '{$id}' AND ";
		$sql.= "delete_flg = 0 AND ";
		$sql.= "public = 1 AND ";
		$sql.= "public_start_date < NOW() AND ";
		$sql.= "(public_end_date > NOW() OR public_end_date IS NULL) ";
		return $this->db->getData($sql);
	}


	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){

		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		$wheres[] = " store_id IS NULL or store_id = 0 ";

		//公開、非公開ボタン
		if(getParam($get,'public') != '' && getParam($get,'public')){
			$public = $this->escape_string(getParam($get,'public'));
			$wheres[] = " public = '{$public}' ";
		}

		//タイトルで絞り込み
		if(getParam($get,'title') != '' && getParam($get,'title')){
			$title = $this->escape_string(getParam($get,'title'));
			$wheres[] = " title LIKE '%{$title}%' ";
		}

		//日付で絞り込み
		if(getParam($get,'display_date_s') != ''  && is_string(getParam($get,'display_date_s'))){
			$display_date_s = $this->escape_string(getParam($get,'display_date_s'));
			$wheres[] = " display_date >= '{$display_date_s}' ";
		}

		if(getParam($get,'display_date_e') != ''  && is_string(getParam($get,'display_date_e'))){
			$display_date_e = $this->escape_string(getParam($get,'display_date_e'));
			$wheres[] = " display_date <= '{$display_date_e}' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}

	/**
	 * WHERE句生成（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceSearchWhere($id,$get){

		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		$wheres[] = " store_id = '{$id}' ";

		//公開、非公開ボタン
		if(getParam($get,'public') != '' && getParam($get,'public')){
			$public = $this->escape_string(getParam($get,'public'));
			$wheres[] = " public = '{$public}' ";
		}

		//タイトルで絞り込み
		if(getParam($get,'title') != '' && getParam($get,'title')){
			$title = $this->escape_string(getParam($get,'title'));
			$wheres[] = " title LIKE '%{$title}%' ";
		}

		//日付で絞り込み
		if(getParam($get,'display_date_s') != ''  && is_string(getParam($get,'display_date_s'))){
			$display_date_s = $this->escape_string(getParam($get,'display_date_s'));
			$wheres[] = " display_date >= '{$display_date_s}' ";
		}

		if(getParam($get,'display_date_e') != ''  && is_string(getParam($get,'display_date_e'))){
			$display_date_e = $this->escape_string(getParam($get,'display_date_e'));
			$wheres[] = " display_date <= '{$display_date_e}' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}

}