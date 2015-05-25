<?php
/**
 * 第１エリアマスター
 */
class Area_firstDbModel extends DbModel{


	public function getField(){
		return array(
			'area_first_id',
			'category_large_id',
			'region_id',
			'prefectures_id',
			'area_first_name',
			'delivery',
			'rank',
			'regist_date',
			'update_date',
			'delete_flg',
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