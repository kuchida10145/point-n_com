<?php
/**
 * ニュース情報
 */
class NewsDbModel extends DbModel{


	public function getField(){
		return array(
			'news_id',
			'public',
			'public_start_date',
			'public_end_date',
			'display_date',
			'region_id',
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
	 * 一覧用データ取得
	 *
	 * @param int $region_id 地域ID
	 * @param int $start_page 開始番号
	 * @param int $get_page 取得する件数
	 * @return array 詳細データ複数件
	 */
	public function getNewsList($region_id,$start_page,$get_page){
		$start_page = $start_page*$get_page;
		$sql = "SELECT news_id,display_date,title,image1,image2,image3 FROM {$this->table} WHERE ";
		$sql.= "delete_flg = 0 AND ";
		$sql.= "public = 1 AND ";
		$sql.= "region_id = '{$region_id}'  AND ";
		$sql.= "public_start_date < NOW() AND ";
		$sql.= "(public_end_date > NOW() OR public_end_date IS NULL OR public_end_date = '0000-00-00 00:00:00') ";
		$sql.= " ORDER BY display_date DESC , public_start_date DESC , regist_date DESC ";
		$sql.= "LIMIT {$start_page},{$get_page}";

		return $this->db->getAllData($sql);
	}



	/**
	 * 詳細データ取得
	 *
	 * @param int $id 主キー
	 * @return array 詳細データ1件
	 */
	public function getNewData($id){

		if(!is_numeric($id)){
			return NULL;
		}

		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE ";
		$sql.= "news_id = '{$id}' AND ";
		$sql.= "delete_flg = 0 AND ";
		$sql.= "public = 1 AND ";
		$sql.= "public_start_date < NOW() AND ";
		$sql.= "(public_end_date > NOW() OR public_end_date IS NULL OR public_end_date = '0000-00-00 00:00:00') ";
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


		//地域で絞込み
		if(getParam($get,'region_id') != '' && is_string(getParam($get,'region_id'))){
			$region_id = $this->escape_string(getParam($get,'region_id'));

			$wheres[] = " region_id = '{$region_id}' ";
		}


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