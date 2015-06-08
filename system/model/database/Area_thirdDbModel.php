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
