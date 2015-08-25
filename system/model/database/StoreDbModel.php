<?php
/**
 * 店舗情報
 */
class StoreDbModel extends DbModel{

	// 一覧取得用の開始番号(0 origin)
	protected $start_number = -1;
	// 取得件数
	protected $get_count    = 0;
	// ソートID
	protected $sort_id      = 0;

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
			'contract_zip_code',
			'contract_prefectures_id',
			'contract_address1',
			'contract_address2',
			'contract_telephone',
			'link_text_outside1',
			'link_text_outside2',
			'link_text_outside3',
			'link_text_outside4',
			'link_text_outside5',
			'url_outside1',
			'url_outside2',
			'url_outside3',
			'url_outside4',
			'url_outside5',
			'url_official1',
			'url_official2',
			'url_official3',
			'url_official4',
			'representative_sei',
			'representative_mei',
			'representative_email',
			'reserved_email',
			'point_limit',
			'base_point',
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
	 * 指定カテゴリーに属するデータ件数を取得する
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
		$sql .= "     t2.area_first_name, t3.area_second_name, t4.area_third_name ";
		$sql .= "   , t1.area_first_id, t1.area_second_id, t1.area_third_id, t3.delivery ";
		$sql .= "   , count(t1.category_small_id) as cnt ";
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
	 * 一覧取得時のページ送りパラメータを設定する
	 *
	 * @param number $start_number
	 * @param number $get_count
	 */
	public function setNextPage($start_number, $get_count) {
		$this->start_number = $start_number;
		$this->get_count    = $get_count;
	}

	/**
	 * 一覧取得時のソートパラメータを設定する
	 *
	 * @param number $sort_id
	 */
	public function setSortID($sort_id) {
		$this->sort_id = $sort_id;
	}

	/**
	 * エリアIDをキーとして店舗一覧用の件数を取得する
	 *
	 * @param number $category_large_id
	 * @param number $category_midium_id
	 * @param string $category_small_ids
	 * @param array $area_key_ids
	 * @param string $search_keyword
	 * @return array
	 */
	public function shopCountByCategoryAndAreaKeyIDs($category_large_id, $category_midium_id, $category_small_ids, $area_key_ids, $search_keyword) {
		$count = $this->shopCommonByCategoryAndAreaKeyIDs(true, $category_large_id, $category_midium_id, $category_small_ids, $area_key_ids, $search_keyword);
		if ($count == null) {
			return 0;
		}
		return $count['cnt'];
	}

	/**
	 * エリアIDをキーとして店舗一覧用の情報を取得する
	 *
	 * @param number $category_large_id
	 * @param number $category_midium_id
	 * @param string $category_small_ids
	 * @param array $area_key_ids
	 * @param string $search_keyword
	 * @return array
	 */
	public function shopListByCategoryAndAreaKeyIDs($category_large_id, $category_midium_id, $category_small_ids, $area_key_ids, $search_keyword) {
		return $this->shopCommonByCategoryAndAreaKeyIDs(false, $category_large_id, $category_midium_id, $category_small_ids, $area_key_ids, $search_keyword);
	}

	/**
	 * エリアIDをキーとして店舗一覧用の情報を取得する（件数と情報）
	 *
	 * @param boolean $is_count
	 * @param number $category_large_id
	 * @param number $category_midium_id
	 * @param string $category_small_ids
	 * @param array $area_key_ids
	 * @param string $search_keyword
	 * @return array
	 */
	private function shopCommonByCategoryAndAreaKeyIDs($is_count, $category_large_id, $category_midium_id, $category_small_ids, $area_key_ids, $search_keyword) {
		if (!is_array($area_key_ids)) {
			$area_key_ids = array();
		}

		$category_large_id  = $this->escape_string($category_large_id);
		$category_midium_id = $this->escape_string($category_midium_id);
		$category_small_ids = $this->escape_string($category_small_ids);
		$area_key_ids       = $this->escape_string($area_key_ids);
		$search_keyword     = $this->escape_string($search_keyword);

		// WHERE 句
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
		if (count($wheres_or) > 0) {
			$wheres[] = "(" . implode(" OR ", $wheres_or) . ")";
		}
		if ($category_large_id != "") {
			$wheres[] = "store.category_large_id  = {$category_large_id}";
		}
		if ($category_midium_id != "") {
			$wheres[] = "store.category_midium_id = {$category_midium_id}";
		}
		if ($category_small_ids != "") {
			$wheres[] = "store.category_small_id IN ({$category_small_ids})";
		}
		$wheres[] = "store.status_id = 2";
		$wheres[] = "store.delete_flg = 0";
		if ($search_keyword != "") {
			$wheres[] = "store.store_name LIKE '%{$search_keyword}%'";
		}
		$where = implode(" AND ", $wheres);
		$sql  = $this->shopListSqlBase($is_count);
		$sql .= " WHERE {$where} ";

		if ($is_count) {
			// 件数取得
			return $this->db->getData($sql);
		}

		// 複数の結果を防ぐ
		$sql .= ' GROUP BY store.store_id';

		// ORDER BY 句
		$sql .= $this->shopListSqlOrderBy($this->sort_id);

		// LIMIT 句
		if ($this->start_number >= 0 && $this->get_count > 0) {
			$sql .= " LIMIT {$this->start_number}, {$this->get_count} ";
		}

		return $this->db->getAllData($sql);
	}

	/**
	 * 店舗一覧取得用のベースSQL
	 *
	 * @param boolean $is_count
	 * @return string
	 */
	protected function shopListSqlBase($is_count = false) {

 		date_default_timezone_set('Asia/Tokyo');

		$todayDate = date( 'Y-m-d H:i:s', time() );

		if ($is_count) {
			$sql = ' SELECT count(DISTINCT store.store_id) as cnt ';
		} else {
			$sql  = 'SELECT store.store_id, store.store_name, store.new_arrival, store.address1, store.address2, store.image1';
			$sql .= ', store.type_of_industry_id';
			$sql .= ', region.region_name';
			$sql .= ', category.category_small_name';
			$sql .= ', c1.point normal_point, c1.status_id normal_point_status';
			$sql .= ', c2.point event_point, c2.status_id event_point_status';
			$sql .= ', notice.title';
		}
		$sql .= ' FROM `store`';
		$sql .= ' LEFT JOIN `area_first` AS area ON area.area_first_id = store.area_first_id';
		$sql .= ' LEFT JOIN `region_master` AS region ON region.region_id = area.region_id';
		$sql .= ' LEFT JOIN `category_small` AS category ON store.category_small_id = category.category_small_id';
		$sql .= ' LEFT JOIN ( SELECT * FROM `coupon` WHERE status_id = 1 AND point_kind = 1 ORDER BY point DESC) AS c1 ON store.store_id = c1.store_id';
		$sql .= ' LEFT JOIN `course` AS cs1 ON c1.course_id = cs1.course_id AND c1.store_id = cs1.store_id ';
		$sql .= ' LEFT JOIN ( SELECT * FROM `coupon` WHERE status_id = 1 AND point_kind = 2 ORDER BY point DESC) AS c2 ON store.store_id = c2.store_id';
		$sql .= ' LEFT JOIN `course` AS cs2 ON c2.course_id = cs2.course_id AND c2.store_id = cs2.store_id ';
		$sql .= ' LEFT JOIN ( SELECT * FROM `notice` WHERE public_start_date <= "' . $todayDate . '" AND public_end_date >= "' . $todayDate . '" ORDER BY notice_id) AS notice ON store.store_id = notice.store_id AND notice.public = 1';
		return $sql;
	}

	/**
	 * 店舗一覧取得用のソート条件を取得する
	 *
	 * @param number $sort_id
	 * @return string
	 */
	protected function shopListSqlOrderBy($sort_id) {
		$orderby = array(
			// 1：通常ポイントが高い順（デフォルト）
			1=>" ORDER BY c1.point DESC, c2.point DESC ",
			// 2：イベントポイントが高い順
			2=>" ORDER BY c2.point DESC, c1.point DESC ",
			// 3：通常ポイント総額料金が高い順
			3=>" ORDER BY cs1.price DESC, cs2.price DESC ",
			// 4：通常ポイント総額料金が低い順
			4=>" ORDER BY cs1.price ASC, cs2.price ASC ",
			// 5：イベントポイント総額料金が高い順
			5=>" ORDER BY cs2.price DESC, cs1.price DESC ",
			// 6：イベントポイント総額料金が低い順
			6=>" ORDER BY cs2.price ASC, cs1.price ASC ",
			// 7：新着店舗
			7=>" ORDER BY store.new_arrival DESC, store.regist_date DESC ",
		);
		if (isset($orderby[$sort_id])) {
			return $orderby[$sort_id];
		} else {
			return $orderby[1];
		}
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
	 * @param string $keyword WHERE部分の条件(店舗名で検索)
	 * @param int $offset クエリーのoffset
	 * @param int $nbResult クエリー結果数（-1の場合全結果取得）
	 *
	 * @link https://developers.google.com/maps/articles/phpsqlsearch_v3 クエリー参考
	 *
	 * @return array,NULL 実行結果
	 */
	public function findShopsNearby( $latitude, $longitude, $radius, $keyword = '', $offset = -1, $nbResult = -1 ) {

		$field 		 = $this->getFieldText();
		$latitude  = $latitude;
		$longitude = $longitude;
		$radius 	 = $radius;
		$offset 	 = $offset;
		$nbResult  = $nbResult;

		$query = "SELECT {$field}, ( 6371 * acos( cos( radians({$latitude}) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians({$longitude}) ) + sin( radians({$latitude}) ) * sin( radians( latitude ) ) ) ) AS distance";
		$query .= " FROM {$this->table}";

		//WHERE
		if ( isset($keyword) && !empty($keyword) ) {

			$keyword = $this->escape_string( $keyword );
			$where = " WHERE `store_name` LIKE '%%%s%%'";
			$query .= sprintf( $where, $keyword );
			//$query .= $where;
		}

		$query .= " HAVING distance < {$radius} AND status_id = 2 ORDER BY distance";

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

	/*==========================================================================================
	 * フロント：店舗詳細用、店舗1件取得
	*
	*==========================================================================================*/
	/**
	 * 店舗IDから店舗詳細情報を取得する
	 *
	 * @param int $id 店舗ID
	 * @return array,NULL 実行結果
	 */
	public function findStoreDetailById( $id ) {
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE {$this->primary_key} = '{$id}' AND delete_flg = 0 AND status_id = 2 LIMIT 0,1";
		return $this->db->getData($sql);
	}
	
	
	
	/*==========================================================================================
	* CRON：毎月１日に実行
	*
	*==========================================================================================*/
	/**
	 * ポイント利用枠を、月初めに付与するポイント枠（base_point)と同じ数値にする
	 * 
	 */
	public function pointLimitThisMonthCron(){
		$sql = "UPDATE {$this->table} SET point_limit = base_point ";
		return $this->db->query($sql);
	}
	
	
	/*==========================================================================================
	* ポイント枠周り
	*
	*==========================================================================================*/

	/**
	 * ポイント利用枠追加
	 * @param int $store_id 店舗ID
	 * @param int $point ポイント
	 */
	public function addPointLimit($store_id,$point){
		$sql = "UPDATE {$this->table} SET point_limit = point_limit+{$point} WHERE store_id = '{$store_id}' ";
		return $this->db->query($sql);
	}
	
	/**
	 * ポイント利用枠減少
	 * @param int $store_id 店舗ID
	 * @param int $point ポイント
	 */
	public function usePointLimit($store_id,$point){
		$sql = "UPDATE {$this->table} SET point_limit = point_limit-{$point} WHERE store_id = '{$store_id}' ";
		return $this->db->query($sql);
	}
}
