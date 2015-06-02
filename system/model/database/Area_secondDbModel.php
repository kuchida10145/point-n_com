<?php
/**
 * 第２エリアマスター
 */
class Area_secondDbModel extends DbModel{


	public function getField(){
		return array(
			'area_second_id',
			'area_first_id',
			'area_second_name',
			'delivery',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg',
		);
	}
	
	/**
	 * 第２エリアリストを取得する
	 * 
	 * @param mixed $area_first_id 第１エリアID
	 * @param string $delivery デリバリー
	 * @return array
	 */
	public function areaList($area_first_id, $delivery) {
		$wheres = array();
		if (is_array($area_first_id)) {
			$wheres[] = 'area_first_id IN (' . implode(",", $area_first_id) . ')';
		} else {
			$wheres[] = 'area_first_id = ' . $area_first_id;
		}
		$wheres[] = "delivery = '" . $delivery . "'";
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