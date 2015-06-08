<?php
/**
 * クーポン
 */
class CouponDbModel extends DbModel{



	public function getField(){
		return array(
			'coupon_id',
			'course_id',
			'store_id',
			'status_id',
			'point_kind',
			'coupon_name',
			'point',
			'use_condition',
			'public_start_date',
			'public_end_date',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

	/*==========================================================================================
	 * 管理者用共通処理
	*
	*==========================================================================================*/
	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceSearchWhere($id, $get){

		$wheres = array();
		$wheres[] = " delete_flg = 0 ";

		//名前が設定されている場合
		if(getParam($get,'account_name') != '' && getParam($get,'account_name')){
			$name = $this->escape_string(getParam($get,'account_name'));
			$wheres[] = " account_name LIKE '%{$name}%' ";
		}

		//クーポン種別が設定されている場合
		if(getParam($get,'point_kind') != '' && getParam($get,'point_kind')){
			$point_kind = $this->escape_string(getParam($get,'point_kind'));
			$wheres[] = " point_kind = '{$point_kind}' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}

	/**
	 * クーポン有効処理
	 *
	 *  @param string $course_id
	 *  @param string $point_kind
	 *  @return Bool 結果
	 */
	public function updateForce($course_id, $point_kind) {
		$where = " point_kind = {$point_kind} ";
		$param = array(
				'status_id'=>'0',
		);

		if($this->update($param,$where)){
			$where = " course_id = {$course_id} AND point_kind = {$point_kind} AND delete_flg = 0 ";
			$param = array(
					'status_id'=>'1',
			);
			return $this->update($param,$where);
		}
		return FALSE;
	}
}