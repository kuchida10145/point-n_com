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
	
	/**
	 * エリアIDをキーとして店舗一覧用の情報を取得する
	 * 
	 * @param number $category_large_id
	 * @param number $category_midium_id
	 * @param string $category_small_ids
	 * @param array $area_key_ids
	 * @return array
	 */
	public function shopListByCategoryAndAreaKeyIDs($category_large_id, $category_midium_id, $category_small_ids, $area_key_ids) {
		if (!is_array($area_key_ids)) {
			return null;
		}
		
		$wheres_or = array();
		foreach ($area_key_ids as $key => $value) {
			$area_ids = explode("-", $value);
			if (!is_array($area_ids) || count($area_ids) < 3) {
				continue;
			}
			$where  = "(   store.area_first_id  = {$area_ids[0]} ";
			$where .= "AND store.area_second_id = {$area_ids[1]} ";
			$where .= "AND store.area_third_id  = {$area_ids[2]} ) ";
			$wheres_or[] = $where;
		}
		$wheres = array();
		$wheres[] = "(" . implode(" OR ", $wheres_or) . ")";
		$wheres[] = "store.category_large_id = {$category_large_id}";
		$wheres[] = "store.category_midium_id = {$category_midium_id}";
		$wheres[] = "store.category_small_id IN ({$category_small_ids})";
		$wheres[] = "store.status_id = 2";
		$wheres[] = "store.delete_flg = 0";
		$where = implode(" AND ", $wheres);
		$sql  = $this->shopListSqlBase();
		$sql .= " WHERE {$where} ";
		$sql .= " ORDER BY c1.coupon_id DESC, c2.coupon_id DESC, notice.notice_id DESC ";
		return $this->db->getAllData($sql);
	}
	
	/**
	 * 店舗一覧取得用のベースSQL
	 * 
	 * @return string
	 */
	protected function shopListSqlBase() {
		$sql  = 'SELECT store.store_id, store.store_name, store.new_arrival, store.address1, store.image1';
		$sql .= ', region.region_name';
		$sql .= ', category.category_small_name';
		$sql .= ', c1.point normal_point, c1.status_id normal_point_status';
		$sql .= ', c2.point event_point, c2.status_id event_point_status';
		$sql .= ', notice.title';
		$sql .= ' FROM `store`';
		$sql .= ' LEFT JOIN `area_first` AS area ON area.area_first_id = store.area_first_id';
		$sql .= ' LEFT JOIN `region_master` AS region ON region.region_id = area.region_id';
		$sql .= ' LEFT JOIN `category_small` AS category ON store.category_small_id = category.category_small_id';
		$sql .= ' LEFT JOIN `coupon` AS c1 ON store.store_id = c1.store_id AND c1.status_id = 1 AND c1.point_kind = 1';
		$sql .= ' LEFT JOIN `coupon` AS c2 ON store.store_id = c2.store_id AND c2.status_id = 1 AND c2.point_kind = 2';
		$sql .= ' LEFT JOIN `notice` ON store.store_id = notice.store_id AND notice.public = 1';
		return $sql;
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


	/*==========================================================================================
	 * フロント：お近くのお店検索
	 *
	 *==========================================================================================*/
	/**
	 * 経度と緯度で決まる中心点によって半径○○キロにある店舗を出す
	 * 
	 * @param double $latitude 経度
	 * @param double $longitude 緯度
	 * @param int $radius 検索半径（単位＝キロメートル）
	 * @param int $offset クエリーのoffset
	 * @param int $nbResult クエリー結果数（-1の場合全結果取得）
	 * 
	 * @link https://developers.google.com/maps/articles/phpsqlsearch_v3 クエリー参考 
	 * 
	 * @return array,NULL 実行結果
	 */
	public function findShopsNearby( $latitude, $longitude, $radius, $offset = -1, $nbResult = -1 ) {

		$field 		 = $this->getFieldText();
		$latitude  = $latitude;
		$longitude = $longitude;
		$radius 	 = $radius;
		$offset 	 = $offset;
		$nbResult  = $nbResult;

		$query = "SELECT {$field}, ( 6371 * acos( cos( radians({$latitude}) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians({$longitude}) ) + sin( radians({$latitude}) ) * sin( radians( latitude ) ) ) ) AS distance";
		$query .= " FROM {$this->table} HAVING distance < {$radius} AND status_id = 2 ORDER BY distance";
		
		//結果数を限定する
		if ( $offset > -1 && $nbResult > -1 ) {
			$query .= " LIMIT {$offset}, {$nbResult}";
		}

		$query .= ";";

		return $this->db->getAllData($query);
	}


	/*==========================================================================================
	 * フロント：お近くのお店検索結果一覧
	 *
	 *==========================================================================================*/
	/**
	 * IDsによって検索結果一覧に表示する店舗の情報を出す
	 * 
	 * @param array $ids 店舗のID 
	 * 
	 * @return array,NULL 実行結果
	 */
	public function findShopDataById( $ids ) {

		if ( !is_array( $ids ) || empty( $ids ) ) {
			$result = NULL;
		} else {

			$result = array();
			
			$query  = $this->shopListSqlBase();
			$query .= ' WHERE store.store_id = %d';
			$query .= ' ORDER BY c1.coupon_id DESC, c2.coupon_id DESC, notice.notice_id DESC LIMIT 0,1;';

			foreach ( $ids as $id ) {

				$req = sprintf( $query, $id );

				$res = $this->db->getData($req);

				if ( NULL != $res ) {
					$result[] = $res;
				}
			}
		}
		return $result;
	}	
}
