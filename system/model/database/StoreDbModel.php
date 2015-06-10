<?php
/**
 * 店舗情報
 */
class StoreDbModel extends DbModel{


	
	public function getField(){
		return array(
			'store_id',
			'store_hex_id',
			'status_id',
			'store_name',
			'new_arrival',
			'type_of_industry_id',
			'license',
			'account_name',
			'login_id',
			'login_password',
			'category_large_id',
			'category_midium_id',
			'category_small_id',
			'area_first_id',
			'area_second_id',
			'area_third_id',
			'image1',
			'image2',
			'image3',
			'image4',
			'image5',
			'image6',
			'image7',
			'image8',
			'image9',
			'introduction',
			'latitude',
			'longitude',
			'zip_code',
			'prefectures_id',
			'address1',
			'address2',
			'business_hours',
			'telephone',
			'holiday',
			'url_outside1',
			'url_outside2',
			'url_official1',
			'url_official2',
			'url_official3',
			'url_official4',
			'representative_sei',
			'representative_mei',
			'representative_email',
			'reserved_email',
			'latest_login_date',
			'regist_date',
			'update_date',
			'delete_flg',


		);
	}
	
	/**
	 * ログインIDに該当するデータを取得する
	 *
	 * @param string $login_id
	 * @return array
	 */
	public function findByLoginId($login_id){
		$field = $this->getFieldText();
		$login_id = $this->escape_string($login_id);
		$sql = "SELECT {$field} FROM {$this->table} WHERE login_id = '{$login_id}' LIMIT 0,1";
		return $this->db->getData($sql);
	}
	
	/**
	 * ＩＤとパスワードが一致するデータを1件取得
	 * 
	 * @param string $login_id ログインID
	 * @param string $login_pw ログインパスワード
	 * @return array
	 */
	public function login($login_id,$login_pw){
		$login_pw = encodePassword($login_pw);
		$login_id = $this->escape_string($login_id);
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE login_id = '{$login_id}' AND login_password = '{$login_pw}' AND delete_flg = 0";
		return $this->db->getData($sql);
	}
	
	/**
	 * 指定カテゴリーに属するデータを取得する
	 * 
	 * @param number $category_large_id
	 * @param number $category_midium_id
	 * @param number $category_small_ids
	 * @return array
	 */
	public function searchCountByCategory($category_large_id, $category_midium_id, $category_small_ids) {
		$category_large_id = $this->escape_string($category_large_id);
		$category_midium_id = $this->escape_string($category_midium_id);
		if (is_array($category_small_ids)) {
			foreach ($category_small_ids as $key => $value) {
				$category_small_ids[$key] = $this->escape_string($value);
			}
			$category_small_ids = implode(',', $category_small_ids);
		} else {
			$category_small_ids = $this->escape_string($category_small_ids);
		}
		$category_midium_id = ($category_midium_id == "") ? "0" : $category_midium_id;
		$category_small_ids = ($category_small_ids == "") ? "0" : $category_small_ids;
		
		$sql  = " SELECT ";
		$sql .= "   t2.area_first_name, t3.area_second_name, t4.area_third_name, t1.area_first_id, t1.area_second_id, t1.area_third_id, count(t1.category_small_id) as cnt ";
		$sql .= " FROM ";
		$sql .= "     {$this->table} as t1 ";
		$sql .= "   LEFT JOIN area_first  as t2 ON t1.area_first_id  = t2.area_first_id ";
		$sql .= "   LEFT JOIN area_second as t3 ON t1.area_second_id = t3.area_second_id ";
		$sql .= "   LEFT JOIN area_third  as t4 ON t1.area_third_id  = t4.area_third_id ";
		$sql .= " WHERE ";
		$sql .= "       t1.category_large_id = {$category_large_id} ";
		$sql .= "   AND t1.category_midium_id = {$category_midium_id} ";
		$sql .= "   AND t1.category_small_id IN ({$category_small_ids}) ";
		$sql .= "   AND t1.status_id = 2 ";
		$sql .= "   AND t1.delete_flg = 0 ";
		$sql .= " GROUP BY ";
		$sql .= "   t1.area_first_id, t1.area_second_id, t1.area_third_id ";
		$sql .= " ORDER BY ";
		$sql .= "   t1.area_first_id ASC, t1.area_second_id ASC, t1.area_third_id ASC ";
		return $this->db->getAllData($sql);
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
	protected function adminSearchWhere($get) {
		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		
		// WEBサービスが設定されている場合
		if (is_array(getParam($get, 'status_id'))) {
			$status_ids = array();
			foreach (getParam($get, 'status_id') as $val) {
				if (!is_digit($val)) { continue; }
				$status_ids[] = $val;
			}
			if (count($status_ids) > 0) {
				$wheres[] = " status_id IN(" . implode(',', $status_ids) . ") ";
			}
		}
		
		// 店舗名が設定されている場合
		if (getParam($get, 'store_name') != '' && is_string(getParam($get,'store_name'))) {
			$store_name = $this->escape_string(getParam($get, 'store_name'));
			$wheres[] = " store_name LIKE '%{$store_name}%' ";
		}
		
		// 業種が設定されている場合
		if (is_array(getParam($get,'type_of_industry_id'))) {
			$type_of_industry_ids = array();
			foreach (getParam($get,'type_of_industry_id') as $val) {
				if (!is_digit($val)) { continue; }
				$type_of_industry_ids[] = $val;
			}
			if (count($type_of_industry_ids) > 0) {
				$wheres[] = " type_of_industry_id IN(" . implode(',', $type_of_industry_ids) . ") ";
			}
		}
		
		// 新着店舗が設定されている場合
		if (getParam($get, 'new_arrival') != "" && is_digit(getParam($get, 'new_arrival'))) {
			$new_arrival = $this->escape_string(getParam($get, 'new_arrival'));
			if ($new_arrival != 2) {
				$wheres[] = " new_arrival = {$new_arrival} ";
			} else {
				$wheres[] = " new_arrival IN (0, 1) ";
			}
		}
		
		// 入会日の開始が設定されている場合
		if (getParam($get, 'regist_start') != ''  && is_string(getParam($get, 'regist_start'))) {
			$regist_start = $this->escape_string(getParam($get, 'regist_start'));
			$wheres[] = " regist_date >= '{$regist_start}' ";
		}
		
		// 入会日の終了が設定されている場合
		if (getParam($get, 'regist_end') != ''  && is_string(getParam($get,'regist_end'))) {
			$regist_end = $this->escape_string(getParam($get, 'regist_end'));
			$wheres[] = " regist_date <= '{$regist_end} 23:59:59' ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		
		return $where;
	}
}