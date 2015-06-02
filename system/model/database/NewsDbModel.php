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
	 * @param int $start_page 開始番号
	 * @param int $get_page 取得する件数
	 * @return array 詳細データ複数件
	 */
	public function getNewsList($start_page,$get_page){
		$sql = "SELECT news_id,display_date,title,image1,image2,image3 FROM {$this->table} WHERE ";
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
		$sql.= "(public_end_date > NOW() OR public_end_date IS NULL) ";
		return $this->db->getData($sql);
	}
}