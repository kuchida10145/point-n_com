<?php
/**
 * 第３エリアマスター
 */
class Area_thirdDbModel extends DbModel{


	public function getField(){
		return array(
			'area_third_id',
			'area_second_id',
			'area_third_name',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}
	
	/**
	 * 第３エリアリストを取得する
	 * 
	 * @param string $area_second_id 第２エリアID
	 * @return array
	 */
	public function areaList($area_second_id) {
		$wheres = array();
		$wheres[] = 'area_second_id = ' . $area_second_id;
		return $this->adminSearch($wheres, "", " ORDER BY rank ASC ");
	}
	
	/**
	 * 第１～３エリアのエリア名を取得する
	 * 
	 * @param number $area_first_id
	 * @param number $area_second_id
	 * @param number $area_third_id
	 * @return array
	 */
	public function area123name($area_first_id, $area_second_id, $area_third_id) {
		$area_first_id  = $this->escape_string($area_first_id);
		$area_second_id = $this->escape_string($area_second_id);
		$area_third_id  = $this->escape_string($area_third_id);
		
		$where = array();
		$where[] = "t1.area_first_id  = {$area_first_id}";
		$where[] = empty($area_second_id) ? "t2.area_second_id is null" : "t2.area_second_id = {$area_second_id}";
		$where[] = empty($area_third_id)  ? "t3.area_third_id  is null" : "t3.area_third_id  = {$area_third_id}";
		$where = implode(" AND ", $where);
		
		$sql  = " SELECT ";
		$sql .= "   t1.area_first_name, t2.area_second_name, t3.area_third_name ";
		$sql .= " FROM ";
		$sql .= "   area_first as t1 ";
		$sql .= "   LEFT JOIN area_second as t2 ON t1.area_first_id  = t2.area_first_id ";
		$sql .= "   LEFT JOIN area_third  as t3 ON t2.area_second_id = t3.area_second_id ";
		$sql .= " WHERE ";
		$sql .= "   {$where} ";
		
		return $this->db->getData($sql);
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
