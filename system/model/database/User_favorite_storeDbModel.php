<?php
/**
 * ユーザーお気に入り店舗
 */
class User_favorite_storeDbModel extends DbModel{

	public $primary_key = 'favorite_id';//プライマリーキー

	public function getField(){
		return array(
			'favorite_id',
			'user_id',
			'store_id',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

	//------------------------
	//　お気に入り一覧取得用
	//------------------------
	/**
	 * 検索結果最大取得件数（お気に入り一覧用）
	 * @param int $id ユーザーＩＤ
	 * @param array $get
	 * @return int
	 */
	public function favoriteSearchMaxCnt($id,$get=array()){
		$sql = $this->favoriteSearchSqlBase($id,$get);

		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);

		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}

	/**
	 * 検索結果一覧（お気に入り一覧用）
	 * @param int $id ユーザＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function favoriteSearch($id,$get,$limit,$order){

		$order = " ORDER BY user_favorite_store.update_date DESC";
		$sql = $this->favoriteSearchSqlBase($id,$get);
		$sql = str_replace("##field##",
				"store.store_id,
				store.store_name,
				store.new_arrival,
				region_master.region_name,
				store.address1,
				store.address2,
				store.image1,
				category_small.category_small_name,
				c1.point normal_point,
				c1.point_kind normal_point_kind,
				c1.status_id normal_point_status,
				c2.point event_point,
				c2.point_kind event_point_kind,
				c2.status_id event_point_status,
				notice.title"
				, $sql);

		$sql = $sql." GROUP BY store.store_id {$order} {$limit}";

		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（お気に入り一覧用）
	 * @param int $id user_id
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	protected function favoriteSearchSqlBase($id,$get){

		date_default_timezone_set('Asia/Tokyo');
		$todayDate = date( 'Y-m-d H:i:s', time() );

		//フィールドは各メソッド内で変換
		$where = $this->favoriteSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM
			{$this->table},
			store
			LEFT JOIN `area_first` ON area_first.area_first_id = store.area_first_id
			LEFT JOIN `region_master` ON region_master.region_id = area_first.region_id
			LEFT JOIN `category_small` ON store.category_small_id = category_small.category_small_id
			LEFT JOIN ( SELECT * FROM `coupon` WHERE status_id = 1 AND point_kind = 1 ORDER BY point DESC) AS c1 ON store.store_id = c1.store_id
			LEFT JOIN `course` AS cs1 ON c1.course_id = cs1.course_id AND c1.store_id = cs1.store_id
			LEFT JOIN ( SELECT * FROM `coupon` WHERE status_id = 1 AND point_kind = 2 ORDER BY point DESC) AS c2 ON store.store_id = c2.store_id
			 LEFT JOIN `course` AS cs2 ON c2.course_id = cs2.course_id AND c2.store_id = cs2.store_id
			LEFT JOIN ( SELECT * FROM `notice` WHERE public_start_date <= '{$todayDate}' AND public_end_date >= '{$todayDate}' ORDER BY notice_id) AS notice ON store.store_id = notice.store_id AND notice.public = 1
			 {$where}";
		return $sql;
	}


	/**
	 * WHERE句生成（お気に入り一覧用）
	 * @param int $id user_id
	 * @param array $get
	 * @return string
	 */
	protected function favoriteSearchWhere($id,$get){
		$where = "";
		$wheres[] = " user_favorite_store.delete_flg = 0 ";
		$wheres[] = " user_favorite_store.user_id = '{$id}' ";
		$wheres[] = " user_favorite_store.store_id = store.store_id ";
		$wheres[] = " store.area_first_id = area_first.area_first_id ";
		$wheres[] = " area_first.region_id = region_master.region_id ";
		$wheres[] = " store.category_small_id = category_small.category_small_id ";

		//検索キーワード
		if(getParam($get,'keyword') != ''  && is_string(getParam($get,'keyword'))){
			$keyword = $this->escape_string(getParam($get,'keyword'));
			$wheres[] = " store.store_name LIKE '%{$keyword}%' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);
		return $where;
	}

	/**
	 * お気に入りフラグ取得
	 * （store_idとuser_idからお気に入り店舗か否かを返す）
	 * @param int $user_id ユーザID
	 * @param int $store_id 店舗ID
	 * @return boolean:
	 */
	public function getFavoriteFlg($user_id, $store_id){
		$sql = "
			SELECT
				*
			FROM
				`user_favorite_store`
			WHERE
				store_id = '".$store_id."'
				AND user_id = '".$user_id."'
				AND delete_flg = '0'";

		$count = $this->db->getCount($sql);

		if($count == 0) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * お気に入りデータの更新
	 *
	 * @param Array $param 更新するデータ
	 * @param int $user_id ユーザID
	 * @param int $store_id 店舗ID
	 * @return Bool 結果
	 */
	public function favotiteUpdate($param,$user_id,$store_id)
	{
		$where = "user_id = '$user_id' AND store_id = '$store_id'";
		return $this->db->update($this->table,$param,$where);
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
	 * ユーザIDをキーとしてお気に入り店舗一覧用の件数を取得する
	 *
	 * @param number $user_id
	 * @param array $get
	 * @return array
	 */
	public function favoriteStoreCountByUserID($user_id, $get) {
		$count = $this->favoriteStoreCommonByUserID(true, $user_id, $get);

		if ($count == null) {
			return 0;
		}
		return $count;
	}

	/**
	 * ユーザIDをキーとしてお気に入り店舗一覧用の情報を取得する
	 *
	 * @param number $user_id
	 * @param array $get
	 * @return array
	 */
	public function favoriteStoreListByUserID($user_id, $get) {
		return $this->favoriteStoreCommonByUserID(false, $user_id, $get);
	}

	/**
	 * ユーザIDをキーとしてお気に入り店舗一覧用の情報を取得する（件数と情報）
	 *
	 * @param boolean $is_count
	 * @param number $user_id
	 * @param array  $get
	 * @return array
	 */
	private function favoriteStoreCommonByUserID($is_count, $user_id, $get) {
		$user_id  = $this->escape_string($user_id);

		$sql  = $this->favoriteSearchSqlBase($user_id, $get);
		$sql = str_replace("##field##",
				"store.store_id,
				store.store_name,
				store.type_of_industry_id,
				store.new_arrival,
				region_master.region_name,
				store.address1,
				store.address2,
				store.image1,
				category_small.category_small_name,
				c1.point normal_point,
				c1.point_kind normal_point_kind,
				c1.status_id normal_point_status,
				c2.point event_point,
				c2.point_kind event_point_kind,
				c2.status_id event_point_status,
				notice.title"
				, $sql);

		if ($is_count) {
			// 件数取得
			return $this->db->getCount($sql);
		}

		// 複数の結果を防ぐ
		$sql .= ' GROUP BY store.store_id';

		// ORDER BY 句
		$sql .= " ORDER BY user_favorite_store.update_date DESC ";

		// LIMIT 句
		if ($this->start_number >= 0 && $this->get_count > 0) {
			$sql .= " LIMIT {$this->start_number}, {$this->get_count} ";
		}

 		return $this->db->getAllData($sql);
	}
}