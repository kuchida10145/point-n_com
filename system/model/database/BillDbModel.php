<?php
/**
 * 利用枠追加テーブル
 */
class BillDbModel extends DbModel{



	public function getField(){
		return array(
			'bill_id',
			'bill_month',
			'store_id',
			'store_name',
			'deposit_price',
			'adjust_price',
			'pay_status',
			'memo',
			'n_point',
			'n_point_commission',
			'n_point_n',
			'n_point_n_commission',
			'e_point',
			'e_point_commission',
			'e_point_n',
			'e_point_n_commission',
			'sp_point',
			'sp_point_commission',
			'use_n_point',
			'use_n_point_n',
			'use_e_point',
			'use_e_point_n',
			'use_point',
			'use_point_n',
			'n_point_cancel',
			'n_point_cancel_commission',
			'e_point_cancel',
			'e_point_cancel_commission',
			'use_n_point_cancel',
			'use_e_point_cancel',
			'use_point_cancel',
			'regist_date',
			'update_date',
			'delete_flg'

		);
	}
	
	
	
	/**
	 * 店舗側の月別請求データ取得
	 * 
	 */
	public function getBillForStore($store_id,$year,$month){
		$bill_month = date('Y-m',strtotime($year.'-'.$month));
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE store_id = '{$store_id}' AND bill_month = '{$bill_month}' LIMIT 0,1";
		return $this->db->getData($sql);
	}

	/**
	 * 今月の請求一覧を作成（Cronで月初めに実行）
	 */
	public function addThisMonthBillCron(){
		$regist_date = $update_date = date('Y-m-01 H:i:s');
		$this_month = date('Y-m');
		$sql = "INSERT INTO bill (store_id,store_name,bill_month,regist_date,update_date) (SELECT store_id,store_name,'{$this_month}','{$regist_date}','{$update_date}' FROM store WHERE delete_flg = 0 )";
		$this->db->query($sql);
	}
	
	/**
	 * クーポンが発行された場合
	 * @param $point ポイント
	 */
	/*
	public function addIssue_point($store_id,$point){
		$this_month = date('Y-m');
		$update_date = date('Y-m-d H:i:s');
		$sql = "UPDATE bill SET issue_point = issue_point+{$point},update_date = '{$update_date}' WHERE store_id = '{$store_id}' AND  bill_month = '{$this_month}' ";
		return $this->db->query($sql);
	}
	*/
	/**
	 * ポイント利用で予約があった場合
	 * @param $point ポイント
	 */
	/*
	public function addUse_point($store_id,$point){
		$this_month = date('Y-m');
		$update_date = date('Y-m-d H:i:s');
		$sql = "UPDATE bill SET use_point = use_point+{$point},update_date = '{$update_date}' WHERE store_id = '{$store_id}' AND  bill_month = '{$this_month}' ";
		return $this->db->query($sql);
	}
	 * 
	 */
	
	/**
	 * 前月以前の予約でキャンセルあった場合
	 * @param $point ポイント
	 */
	/*
	public function addBefore_cancel($store_id,$point){
		$this_month = date('Y-m');
		$update_date = date('Y-m-d H:i:s');
		$sql = "UPDATE bill SET before_cancel = before_cancel+{$point},update_date = '{$update_date}' WHERE store_id = '{$store_id}' AND  bill_month = '{$this_month}' ";
		return $this->db->query($sql);
	}
	
	 * 
	 */
	
	public function findByMonthStoreId($year_month,$store_id){
		$field = $this->getFieldText();
		
		$sql = "SELECT {$field} FROM bill WHERE bill_month = '{$year_month}' AND store_id = '{$store_id}' LIMIT 0,1";
		return $this->db->getData($sql);
	}
	
	/**
	 * 指定の店舗の指定年月の料金計算
	 */
	public function monthTotalBillByStoreId($year_month,$store_id){
		
		//請求データ取得
		$bill = $this->findByMonthStoreId($year_month,$store_id);
		
		$manager = Management::getInstance();
		$bill_action  = $manager->db_manager->get('bill_action')->getYearMonthPointSumByStoreId($store_id,$year_month);
		$none_accept  = $manager->db_manager->get('bill_action')->getNoneAcceptYearMonthPointSumByStoreId($store_id,$year_month);
		
		$bill_action['n_point_n']            = $none_accept['n_point'];
		$bill_action['n_point_n_commission'] = $none_accept['n_point_commission'];
		$bill_action['e_point_n']            = $none_accept['e_point'];
		$bill_action['e_point_n_commission'] = $none_accept['e_point_commission'];
		$bill_action['use_n_point_n']        = $none_accept['use_n_point'];
		$bill_action['use_e_point_n']        = $none_accept['use_e_point'];
		$bill_action['use_point_n']          = $none_accept['use_point'];
		
		return $this->updateById($bill['bill_id'], $bill_action);
		
	}
	
	
	/**
	 * 指定年月の発行料金計
	 */
	public function monthTotalBillByStoreId_dummy($year_month,$store_id){
		
		$bill = $this->findByMonthStoreId($year_month,$store_id);
		
		//発行ポイント総数
		$base_sql = "SELECT IFNULL(SUM(total_price), 0) as total_price,IFNULL(sum(use_point), 0) as use_point FROM bill_action WHERE store_id = '{$store_id}' AND ##replace## regist_date LIKE '{$year_month}%' GROUP BY store_id ";
		$sql = str_replace('##replace##', '', $base_sql);
		if(!$total = $this->db->getData($sql)){
			$total = array('total_price' => 0,'use_point' => 0 );
		}
		
		//キャンセル料金
		$sql = str_replace('##replace##', ' data_type = 1 AND ', $base_sql);
		if(!$minus = $this->db->getData($sql)){
			$minus = array('total_price' => 0,'use_point' => 0 );
		}
		
		//通常ポイント総数
		$base_sql ="SELECT IFNULL(SUM(issue_point), 0) as point,IFNULL(SUM(commission), 0) as commission FROM bill_action WHERE store_id = '{$store_id}' AND action_type=##type## AND data_type = 0 AND regist_date LIKE '{$year_month}%' GROUP BY store_id ";
		$sql = str_replace('##type##', '1', $base_sql);
		print $sql;
		if(!$normal = $this->db->getData($sql)){
			$normal = array('point'=>0,'commission'=>0);
		}
		
		//イベントポイント総数
		$sql = str_replace('##type##', '2', $base_sql);
		if(!$event = $this->db->getData($sql)){
			$event = array('point'=>0,'commission'=>0);
		}
		//特別ポイント総数
		$sql = str_replace('##type##', '3', $base_sql);
		if(!$special = $this->db->getData($sql)){
			$special = array('point'=>0,'commission'=>0);
		}
		
		$normal_point  = $normal['point'];
		$event_point   = $event['point'];
		$special_point = $special['point'];
		$commission    = $normal['commission'] + $event['commission'] + $special['commission'];
		
		$param = array(
			'issue_point'        =>$total['total_price']-$minus['total_price'],
			'use_point'          =>$total['use_point']-$minus['use_point'],
			'use_point_cancel'   =>$minus['use_point'],
			'issue_point_cancel' =>$minus['total_price'],
			'normal_point'       => $normal_point,
			'event_point'        => $event_point,
			'special_point'      => $special_point,
			'total_commission'   => $commission,
		);
		
		
		return $this->updateById($bill['bill_id'],$param);
	}
	
	
	
	
	
	/**
	 * 検索結果最大取得件数（管理者用）
	 * @param array $get
	 * @return int
	 */
	public function adminSearchMaxCnt($get=array()){
		if(getParam($get,'search') != true){
			return 0;
		}
		$sql = $this->adminSearchSqlBase($get);
		$sql = str_replace("##field##",' count(bill.'.$this->primary_key.') as cnt ', $sql);
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
	public function adminSearch($get,$limit,$order){
		$sql = $this->adminSearchSqlBase($get);
		
		$field = "bill.".implode(',bill.',$this->getField()).",store.store_name";
		$field = str_replace("bill.store_name,","",$field);
		
		$sql = str_replace("##field##",$field, $sql);
		$sql = $sql." {$order} {$limit}";

		return $this->db->getAllData($sql);
	}


	protected function adminSearchSqlBase($get){

		//フィールドは各メソッド内で変換
		$where = $this->adminSearchWhere($get);
		$sql = "SELECT ##field## FROM {$this->table},store {$where}";

		return $sql;
	}
	
	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){

		$wheres = array();
		$wheres[] = " bill.store_id = store.store_id ";
		//支払いステータス
		if(getParam($get,'pay_status') != ''){
			$pay_status = $this->escape_string(getParam($get,'pay_status'));
			$wheres[] = " bill.pay_status = '{$pay_status}' ";
		}

		//業種（大カテゴリ
		
		if(getParam($get,'category_large_id') != ''  && is_string(getParam($get,'category_large_id'))){
			$category_large_id = $this->escape_string(getParam($get,'category_large_id'));
			$wheres[] = " store.category_large_id = '{$category_large_id}' ";
		}
		//業種（中カテゴリ
		if(getParam($get,'type_of_industry_id') != ''  && is_string(getParam($get,'type_of_industry_id'))){
			$type_of_industry_id = $this->escape_string(getParam($get,'type_of_industry_id'));
			$wheres[] = " store.type_of_industry_id = '{$type_of_industry_id}' ";
		}
		
		//エリア
		if(getParam($get,'region_id') != ''  && is_string(getParam($get,'region_id'))){
			$region_id         = getParam($get,'region_id');
			$category_large_id = getParam($get,'category_large_id');
			$manager = Management::getInstance();
			$area_first_ids = $manager->db_manager->get('area_first')->areaFirstForBillSearchByRegionId($region_id,$category_large_id);
			
			if(!$area_first_ids){
				$wheres[] = " store.area_fist = '9999' ";
			}
			else{
				//１件のみの場合
				if(count($area_first_ids) == 1){
					$wheres[] = " store.area_first_id = '{$area_first_ids[0]}' ";
				}
				else{
					$ids_str = implode(',',$area_first_ids);
					$wheres[] = " store.area_first_id IN ({$ids_str} ) ";
				}
			}
			
			
		}
		
		//店舗名
		if(getParam($get,'store_name') != '' && getParam($get,'store_name')){
			$store_name = $this->escape_string(getParam($get,'store_name'));
			$wheres[] = " store.store_name LIKE '%{$store_name}%' ";
		}
		
		//期間
		$date = getParam($get,'year',date('Y'))."-".getParam($get, 'month',date('m'));
		
		$wheres[] = " bill.bill_month = '$date' ";
		
		
		//検索条件が指定されていない場合
		if(getParam($get,'store_name') == '' && getParam($get,'region_id') == '' && getParam($get,'pay_status') == '' && getParam($get,'category_large_id') == '' && getParam($get,'type_of_industry_id') == ''){
			$wheres[] = "bill.bill_id = '-1' ";
		}

		

		$where = " WHERE ".implode(' AND ',$wheres);

		return $where;
	}
}