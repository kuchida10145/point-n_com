<?php
/**
 * 予約情報
 */
class ReservedDbModel extends DbModel{



	public function getField(){
		return array(
			'reserved_id',
			'store_id',
			'user_id',
			'coupon_id',
			'course_id',
			'reserve_kind',
			'point_code',
			'status_id',
			'course_name',
			'coupon_name',
			'minutes',
			'price',
			'use_condition',
			'reserved_date',
			'use_persons',
			'use_date',
			'reserved_name',
			'telephone',
			'total_price',
			'use_point',
			'get_point',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}


	/*==========================================================================================
	 * フロント：ポイントコード関連
	 *
	 *==========================================================================================*/
	/**
	 * 対象の会員のポイントコード一覧データを取得
	 * @param int $user_id 会員ID
	 * @return array
	 */
	public function getMyPointCodeList($user_id){
		if(!is_numeric($user_id)){
			return NULL;
		}
		$today = date('Y-m-d 23:59:59',strtotime('+24hour'));//日付をまたぐ可能性もあるので24時間プラス

		$sql = "SELECT store_name,reserved_id,use_date FROM reserved,store WHERE store.store_id = reserved.store_id AND ";
		$sql.= " user_id = {$user_id} AND ";
		$sql.= " reserved.status_id=1";
		$sql.= " ORDER BY reserved.regist_date Desc";
		//$sql.= " reserved.status_id=1 AND  ";
		//$sql.= " use_date <= '{$today}' ";
		//print $sql;
		return $this->db->getAllData($sql);
	}

	/**
	 * 対象の会員のポイントコードデータを取得
	 * @param int $user_id 会員ID
	 * @return array
	 */
	public function getMyPointCode($user_id,$reserve_id){
		if(!is_numeric($user_id)){
			return NULL;
		}
		$today = date('Y-m-d 23:59:59',strtotime('+24hour'));//日付をまたぐ可能性もあるので24時間プラス

		$fields = array();
		foreach($this->getField() as $field_name){
			$fields[] = 'reserved.'.$field_name;
		}
		$fields[] ='store.store_name';

		$field = implode(',',$fields);

		$sql = "SELECT {$field} FROM reserved,store WHERE store.store_id = reserved.store_id AND ";
		$sql.= " reserved.reserved_id = {$reserve_id} AND ";
		$sql.= " reserved.user_id = {$user_id} AND ";
		$sql.= " reserved.status_id=1 ";
		//$sql.= " reserved.status_id=1 AND  ";
		//$sql.= " reserved.use_date <= '{$today}' ";
		return $this->db->getData($sql);
	}

	/**
	 * 対象の店舗のポイントコードデータを取得
	 * @param int $store_id 店舗id
	 * @return array
	 */
	public function getStorePointCode($store_id){
		if(!is_numeric($store_id)){
			return NULL;
		}

		$fields = array();

		$sql = "SELECT point_code FROM reserved WHERE store_id = {$store_id} AND status_id <> ".RESERVE_ST_SP;
		$sql.= " ORDER BY regist_date DESC ";

		return $this->db->getData($sql);
	}



	/*==========================================================================================
	 * 管理者用請求処理
	 *
	 *==========================================================================================*/

	/**
	 * ポイント取得合計
	 * @param array $get
	 * @return int
	 */
	public function adminGetPointCnt($get=array()){
		$sql = $this->adminClaimSearchSqlBase($get);
		$sql = str_replace("##field##",' sum(reserved.get_point) as get_point ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['get_point'];
		}
		return 0;
	}

	/**
	 * ポイント利用合計
	 * @param array $get
	 * @return int
	 */
	public function adminUsePointCnt($get=array()){
		$sql = $this->adminClaimSearchSqlBase($get);
		$sql = str_replace("##field##",' sum(reserved.use_point) as use_point ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['use_point'];
		}
		return 0;
	}


	/**
	 * 検索結果最大取得件数（管理者用）
	 * @param array $get
	 * @return int
	 */
	public function adminClaimSearchMaxCnt($get=array()){
		$sql = $this->adminClaimSearchSqlBase($get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（管理者用）
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function adminClaimSearch($get,$limit,$order){
		$sql = $this->adminClaimSearchSqlBase($get);
		$sql = str_replace("##field##","reserved_id,use_date,store_name,reserved.user_id,user.email,reserved_name,course_name,coupon_name,get_point,use_point", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}


	protected function adminClaimSearchSqlBase($get){
		//フィールドは各メソッド内で変換
		$where = $this->adminClaimSearchWhere($get);
		$sql = "SELECT ##field## FROM {$this->table},store,user {$where}";

		return $sql;
	}


	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminClaimSearchWhere($get){
		$where = ' WHERE delete_flg = 0 ';
		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " reserved.store_id = store.store_id ";
		$wheres[] = " user.user_id = reserved.user_id ";
		$wheres[] = " reserved.status_id = 2 ";

		//店舗名
		if(getParam($get,'store_name') != ''  && is_string(getParam($get,'store_name'))){
			$store_name = $this->escape_string(getParam($get, 'store_name'));
			$wheres[] = " store.store_name LIKE '%{$store_name}%' ";
		}
		//利用開始日
		if(getParam($get,'use_start') != ''  && is_string(getParam($get,'use_start'))){
			$use_start = $this->escape_string(getParam($get,'use_start'));
			$wheres[] = " reserved.use_date > '{$use_start}' ";
		}

		//利用終了日
		if(getParam($get,'use_end') != ''  && is_string(getParam($get,'use_end'))){
			$use_end = $this->escape_string(getParam($get,'use_end'));
			$wheres[] = " reserved.use_date < '{$use_end}' ";
		}


		//業種
		if(is_array(getParam($get,'type_of_industry_id'))){
			$type_of_industry_ids = array();
			foreach(getParam($get,'type_of_industry_id') as $val){
				if(!is_digit($val)){ continue;}
				$type_of_industry_ids[] = $val;
			}
			if(count($type_of_industry_ids) > 0){
				$wheres[] = " store.type_of_industry_id IN(".implode(',',$type_of_industry_ids).") ";
			}
		}

		//クーポン発行
		if(getParam($get,'coupon') == '1'){
			$wheres[] = " reserved.coupon_id != 0 AND reserved.get_point > 0 ";
		}
		//ポイント利用
		else{
			$wheres[] = " reserved.use_point > 0 ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}



	/*==========================================================================================
	 * 店舗用共通処理
	 *
	 *==========================================================================================*/

	/**
	 * ポイント取得合計
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	public function maintenanceGetPointCnt($id,$get=array()){
		$sql = $this->maintenanceClaimSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' sum(reserved.get_point) as get_point ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['get_point'];
		}
		return 0;
	}

	/**
	 * ポイント利用合計
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	public function maintenanceUsePointCnt($id,$get=array()){
		$sql = $this->maintenanceClaimSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' sum(reserved.use_point) as use_point ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['use_point'];
		}
		return 0;
	}

	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	public function maintenanceClaimSearchMaxCnt($id,$get=array()){
		$sql = $this->maintenanceClaimSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function maintenanceClaimSearch($id,$get,$limit,$order){
		$sql = $this->maintenanceClaimSearchSqlBase($id,$get);
		$sql = str_replace("##field##","reserved_id,use_date,store_name,reserved.user_id,user.email,reserved_name,course_name,coupon_name,get_point,use_point", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	protected function maintenanceClaimSearchSqlBase($id,$get){
		//フィールドは各メソッド内で変換
		$where = $this->maintenanceClaimSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM {$this->table},store,user  {$where}";
		return $sql;
	}


	/**
	 * WHERE句生成（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return string
	 */
	protected function maintenanceClaimSearchWhere($id,$get){
		$where = "";

		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " reserved.store_id = '{$id}' ";
		$wheres[] = " reserved.store_id = store.store_id ";
		$wheres[] = " user.user_id = reserved.user_id ";
		$wheres[] = " reserved.status_id = 2 ";

		//利用開始日
		if(getParam($get,'use_start') != ''  && is_string(getParam($get,'use_start'))){
			$use_start = $this->escape_string(getParam($get,'use_start'));
			$wheres[] = " reserved.use_date >= '{$use_start}' ";
		}

		//利用終了日
		if(getParam($get,'use_end') != ''  && is_string(getParam($get,'use_end'))){
			$use_end = $this->escape_string(getParam($get,'use_end'));
			$wheres[] = " reserved.use_date <= '{$use_end}' ";
		}

		//クーポン発行
		if(getParam($get,'coupon') == '1'){
			$wheres[] = " reserved.coupon_id != 0 AND reserved.get_point > 0 ";
		}
		//ポイント利用
		else{
			$wheres[] = " reserved.use_point > 0 ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);
		return $where;
	}

	//------------------------
	//　予約管理用
	//------------------------
	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param int $cancell_flg 取消リストフラグ
	 * @return int
	 */
	public function maintenanceReserveSearchMaxCnt($id,$get=array(),$cancell_flg){
		$sql = $this->maintenanceReserveSearchSqlBase($id,$get,$cancell_flg);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}


	/**
	 * 検索結果一覧（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @param int $cancell_flg 予約取消リストフラグ
	 * @return array:
	 */
	public function maintenanceRserveSearch($id,$get,$limit,$order,$cancell_flg){
		$sql = $this->maintenanceReserveSearchSqlBase($id,$get,$cancell_flg);
		$sql = str_replace("##field##","reserved_id,point_code,reserved.status_id,reserved.reserved_date,use_date,reserved.user_id,user.nickname,reserved.reserved_name,reserved.coupon_name,get_point,use_point,reserved.reserve_kind", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param int $cancell_flg 予約取消リストフラグ
	 * @return array:
	 */
	protected function maintenanceReserveSearchSqlBase($id,$get,$cancell_flg){
		//フィールドは各メソッド内で変換
		$where = $this->maintenanceReserveSearchWhere($id,$get,$cancell_flg);
		$sql = "SELECT ##field## FROM {$this->table},user  {$where}";
		return $sql;
	}


	/**
	 * WHERE句生成（店舗用）
	 * @param int $id user_id
	 * @param array $get
	 * @param int $cancell_flg 予約取消リストフラグ
	 * @return string
	 */
	protected function maintenanceReserveSearchWhere($id,$get,$cancell_flg){
		$where = "";

		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " reserved.store_id = '{$id}' ";
		$wheres[] = " reserved.user_id = user.user_id ";
		if($cancell_flg) {
			$wheres[] = " reserved.status_id = '".RESERVE_ST_INV."'";
		} else {
			$wheres[] = " reserved.status_id IN ('".RESERVE_ST_YET."','".RESERVE_ST_FIN."') ";
		}
		//予約ステータス
		if(getParam($get,'status_id') != ''  && is_string(getParam($get,'status_id'))){
			$status_id = $this->escape_string(getParam($get,'status_id'));
			$wheres[] = " reserved.status_id = '{$status_id}' ";
		}

		//予約日Start
		if(getParam($get,'date_start') != ''  && is_string(getParam($get,'date_start'))){
			$date_start = $this->escape_string(getParam($get,'date_start'));
			$wheres[] = " reserved.reserved_date >= '{$date_start}' ";
		}

		//予約日End
		if(getParam($get,'date_end') != ''  && is_string(getParam($get,'date_end'))){
			$date_end = $this->escape_string(getParam($get,'date_end'));
			$wheres[] = " reserved.reserved_date <= '{$date_end}' ";
		}

		//来店日Start
		if(getParam($get,'use_date_start') != ''  && is_string(getParam($get,'use_date_start'))){
			$date_start = $this->escape_string(getParam($get,'use_date_start'));
			$wheres[] = " reserved.use_date >= '{$date_start}' ";
		}

		//来店日End
		if(getParam($get,'use_date_end') != ''  && is_string(getParam($get,'use_date_end'))){
			$date_end = $this->escape_string(getParam($get,'use_date_end'));
			$wheres[] = " reserved.use_date <= '{$date_end}' ";
		}

		//ポイントコード
		if(getParam($get,'point_code') != ''  && is_string(getParam($get,'point_code'))){
			$point_code = $this->escape_string(getParam($get,'point_code'));
			$wheres[] = " reserved.point_code = '{$point_code}' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);
		return $where;
	}

	/**
	 * 予約ステータス更新
	 *
	 *  @param string $reserved_id
	 *  @return Bool 結果
	 */
	public function updateStatusid($reserved_id, $status_id) {
		$where = " reserved_id = {$reserved_id} ";
		$param = array(
				'status_id'=>$status_id,
		);
		return $this->update($param,$where);
	}

	//------------------------
	//　特別ポイント用(index)
	//------------------------
	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	 public function specialPointSearchMaxCnt($id,$get=array()){
		 $sql = $this->specialPointSearchSqlBase($id,$get);
		 $sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		 if($res = $this->db->getData($sql)){
		 	return $res['cnt'];
		 }
		return 0;
	}


	/**
	* 検索結果一覧（店舗用）
	* @param int $id 店舗ＩＤ
	* @param array $get
	* @param string $limit リミット句
	* @param order $order オーダー句
	* @return array:
	*/
	public function specialPointSearch($id,$get,$limit,$order){
		$sql = $this->specialPointSearchSqlBase($id,$get);
		$sql = str_replace("##field##","reserved_date,reserved.user_id,user.nickname,get_point", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	* ベースSELECT分（店舗用）
	* @param int $id 店舗ＩＤ
	* @param array $get
	* @param string $limit リミット句
	* @param order $order オーダー句
	* @return array:
	*/
	protected function specialPointSearchSqlBase($id,$get){
		//フィールドは各メソッド内で変換
		$where = $this->specialPointSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM {$this->table},user  {$where}";
		return $sql;
	}

	/**
	* WHERE句生成（店舗用）
	* @param int $id user_id
	* @param array $get
	* @return string
	*/
	protected function specialPointSearchWhere($id,$get){
		$where = "";

		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " user.delete_flg = 0 ";
		$wheres[] = " reserved.store_id = '{$id}' ";
		$wheres[] = " reserved.user_id = user.user_id ";
		$wheres[] = " reserved.status_id = '".RESERVE_ST_SP."'";

		//利用開始日
		if(getParam($get,'date_start') != ''  && is_string(getParam($get,'date_start'))){
			$date_start = $this->escape_string(getParam($get,'date_start'));
			$wheres[] = " reserved.use_date >= '{$date_start}' ";
		}

		//利用終了日
		if(getParam($get,'date_end') != ''  && is_string(getParam($get,'date_end'))){
			$date_end = $this->escape_string(getParam($get,'date_end'));
			$wheres[] = " reserved.use_date <= '{$date_end}' ";
		}

		//ポイントコード
		if(getParam($get,'user_id') != ''  && is_string(getParam($get,'user_id'))){
			$user_id = $this->escape_string(getParam($get,'user_id'));
			$wheres[] = " reserved.user_id = '{$user_id}' ";
		}

		$where = " WHERE ".implode(' AND ',$wheres);
		return $where;
	}

	//------------------------
	//　特別ポイント用(searh)
	//------------------------
	/**
	 * 検索結果最大取得件数（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @return int
	 */
	public function specialPointSelectSearchMaxCnt($id,$get=array()){
		$sql = $this->specialPointSelectSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}

	/**
	 * 検索結果一覧（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function specialPointSelectSearch($id,$get,$limit,$order){
		$sql = $this->specialPointSelectSearchSqlBase($id,$get);
		$sql = str_replace("##field##","reserved.user_id,user.nickname", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分（店舗用）
	 * @param int $id 店舗ＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	protected function specialPointSelectSearchSqlBase($id,$get){
		//フィールドは各メソッド内で変換
		$where = $this->specialPointSelectSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM {$this->table},user  {$where}";
		return $sql;
	}

	/**
	 * WHERE句生成（店舗用）
	 * @param int $id user_id
	 * @param array $get
	 * @return string
	 */
	protected function specialPointSelectSearchWhere($id,$get){
		$where = "";

		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " user.delete_flg = 0 ";
		$wheres[] = " reserved.store_id = '{$id}' ";
		$wheres[] = " reserved.user_id = user.user_id ";

		//会員ID
		if(getParam($get,'user_id') != ''  && is_string(getParam($get,'user_id'))){
			$user_id = $this->escape_string(getParam($get,'user_id'));
			$wheres[] = " reserved.user_id = '{$user_id}' ";
		}

		//ニックネーム
		if(getParam($get,'nickname') != ''  && is_string(getParam($get,'nickname'))){
			$nickname = $this->escape_string(getParam($get,'nickname'));
			$wheres[] = " user.nickname LIKE '%{$nickname}%' ";
		}

		//$wheres[] = " reserved.status_id IN ('".RESERVE_ST_YET."','".RESERVE_ST_FIN."') GROUP BY user.user_id";

		$where = " WHERE ".implode(' AND ',$wheres)." GROUP BY user.user_id";
		return $where;
	}

	/*==========================================================================================
	 *　フロント用共通処理
	 *
	 *==========================================================================================*/
	//------------------------
	//　ポイント履歴一覧表示用
	//------------------------
	/**
	 * 検索結果最大取得件数
	 * @param int $id ユーザＩＤ
	 * @param array $get
	 * @return int
	 */
	public function pointHistorySelectSearchMaxCnt($id,$get=array()){
		$sql = $this->pointHistorySelectSearchSqlBase($id,$get);
		$sql = str_replace("##field##",' count('.$this->primary_key.') as cnt ', $sql);
		if($res = $this->db->getData($sql)){
			return $res['cnt'];
		}
		return 0;
	}

	/**
	 * 検索結果一覧
	 * @param int $id ユーザＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	public function pointHistorySelectSearch($id,$get,$limit,$order){
		$sql = $this->pointHistorySelectSearchSqlBase($id,$get);
		$sql = str_replace("##field##","reserved.reserved_id,reserved.status_id,reserved.use_date,reserved.reserved_date,store.store_name,reserved.use_point,reserved.get_point", $sql);
		$sql = $sql." {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * ベースSELECT分
	 * @param int $id ユーザＩＤ
	 * @param array $get
	 * @param string $limit リミット句
	 * @param order $order オーダー句
	 * @return array:
	 */
	protected function pointHistorySelectSearchSqlBase($id,$get){
		//フィールドは各メソッド内で変換
		$where = $this->pointHistorySelectSearchWhere($id,$get);
		$sql = "SELECT ##field## FROM {$this->table},store  {$where}";
		return $sql;
	}

	/**
	 * WHERE句生成
	 * @param int $id user_id
	 * @param array $get
	 * @return string
	 */
	protected function pointHistorySelectSearchWhere($id,$get){
		$where = "";

		$wheres[] = " reserved.delete_flg = 0 ";
		$wheres[] = " store.delete_flg = 0 ";
		$wheres[] = " reserved.user_id = '{$id}' ";
		$wheres[] = " reserved.store_id = store.store_id";
		$wheres[] = " reserved.reserved_date >= (NOW() - INTERVAL 1 YEAR) ORDER BY reserved.reserved_date DESC ";

		$where = " WHERE ".implode(' AND ',$wheres);
		return $where;
	}

}