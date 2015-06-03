<?php
/***
 * データ取得ヘルパ
 *
 */


/*-----------------------------------------------------------
 * ステータス関連
 *----------------------------------------------------------*/
/**
 * アカウント（管理者）ステータス
 *
 * @return array
 */
function account_status(){
	return array(
		1=>'可能',
		9=>'不可'
	);
}
/**
 * アカウント（管理者）ステータス ラベル
 *
 * @return array
 */
function account_status_label(){
	return array(
		1=>'<span class="label label-large label-success">可能</span>',
		9=>'<span class="label label-large label-warning">不可</span>',
	);
}


/**
 * 会員ステータス
 *
 * @return array
 */
function user_status(){
	return array(
		1=>'仮登録',
		2=>'有効',
		9=>'無効'
	);
}
/**
 * 会員ステータス ラベル
 *
 * @return array
 */
function user_status_label(){
	return array(
		1=>'<span class="label label-large label-danger">仮登録</span>',
		2=>'<span class="label label-large label-success">有効</span>',
		9=>'<span class="label label-large label-warning">無効</span>',
	);
}

/**
 * 会員性別
 *
 * @return array
 */
function user_gender() {
	return array(
		1=>'男性',
		2=>'女性',
	);
}

/**
 * 店舗ステータス
 *
 * @return array
 */
function store_status() {
	return array(
		1=>'準備中',
		2=>'運営中',
		9=>'停止中',
	);
}
/**
 * 店舗ステータス
 *
 * @return array
 */
function store_status_label() {
	return array(
		1=>'<span class="label label-large label-warning">準備中</span>',
		2=>'<span class="label label-large label-success">運営中</span>',
		9=>'<span class="label label-large label-important">停止中</span>',
	);
}

/**
 * 店舗新着
 *
 * @return array
 */
function store_new_arrival() {
	return array(
		0=>'OFF',
		1=>'ON',
	);
}

/**
 * 店舗業種
 *
 * @return array
 */
function store_type_of_industry() {
	return array(
		1=>'店舗型風俗',
		2=>'無店舗型風俗',
		3=>'ホストその他',
	);
}

/**
 * 店舗業種からデリバリーかどうか判定する
 *
 * @param number $store_type_of_industry
 * @return number
 */
function is_delivery($store_type_of_industry) {
	if ($store_type_of_industry == 2) {
		return 1;
	}

	return 0;
}

/**
 * 大カテゴリー（ジャンルマスター）
 *
 * @return array
 */
function category_large() {
	$list = array();
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('category_large')->categoryList();
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['category_large_id']] = $record['category_large_name'];
	}
	return $list;
}

/**
 * 中カテゴリー
 *
 * @param number $category_large_id
 * @param number $prefectures_id
 * @param number $delivery
 * @return array
 */
function category_midium($category_large_id = 0, $prefectures_id = 0, $delivery = 0) {
	$list = array();
	if ($delivery === "") {
		return $list;
	}
	$manager = Management::getInstance();
	$record  = $manager->db_manager->get('prefectures_master')->findById($prefectures_id);
	if ($record == null) {
		return $list;
	}
	$region_id = $record['region_id'];

	$records = $manager->db_manager->get('category_midium')->categoryList($category_large_id, $region_id, $delivery);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['category_midium_id']] = $record['category_midium_name'];
	}
	return $list;
}

/**
 * 小カテゴリー
 *
 * @param number $category_midium_id
 * @return array
 */
function category_small($category_midium_id) {
	$list = array();
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('category_small')->categoryList($category_midium_id);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['category_small_id']] = $record['category_small_name'];
	}
	if (count($list) == 0 && ($category_midium_id === 0 || $category_midium_id > 0)) {
		$list[0] = non_select_item();
	}
	return $list;
}

/**
 * 地域マスター（エリアマスター）
 *
 * @return array
 */
function region_master() {
	$list = array();
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('region_master')->regionList();
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['region_id']] = $record['region_name'];
	}
	return $list;
}

/**
 * 都道府県マスター
 *
 * @return array
 */
function prefectures_master() {
	$list = array();
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('prefectures_master')->prefecturesList();
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['prefectures_id']] = $record['prefectures_name'];
	}
	return $list;
}

/**
 * 第１エリアマスター
 *
 * @param number $category_large_id
 * @param number $prefectures_id
 * @param number $delivery
 * @return array
 */
function area_first($category_large_id, $prefectures_id, $delivery) {
	$list = array();
	$manager = Management::getInstance();
	$record  = $manager->db_manager->get('prefectures_master')->findById($prefectures_id);
	if ($record == null) {
		return $list;
	}
	$region_id = $record['region_id'];
	$prefectures_name = $record['prefectures_name'];

	$records = $manager->db_manager->get('area_first')->searchForCategoryLargeId(
			$category_large_id, $region_id, $delivery, $prefectures_id, $prefectures_name);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['area_first_id']] = $record['area_first_name'];
	}
	return $list;
}

/**
 * 第２エリアマスター
 *
 * @param unknown $area_first_id
 * @param number $delivery
 * @return array
 */
function area_second($area_first_id, $delivery = 0) {
	$list = array();
	if ($delivery === "") {
		return $list;
	}
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('area_second')->areaList($area_first_id, $delivery);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['area_second_id']] = $record['area_second_name'];
	}
	if (count($list) == 0 && $area_first_id > 0) {
		$list[0] = non_select_item();
	}
	return $list;
}

/**
 * 第２エリアマスター
 *
 * @param number $category_large_id
 * @param number $prefectures_id
 * @param number $delivery
 * @return array
 */
function area_second_to_extend($category_large_id, $prefectures_id, $delivery = 0) {
	$list = array();
	if ($delivery === "") {
		return $list;
	}
	$manager = Management::getInstance();
	$area_first_list = area_first($category_large_id, $prefectures_id, $delivery);
	if (count($area_first_list) <= 0) {
		return $list;
	}
	$area_first_id = array();
	foreach ($area_first_list as $key => $value) {
		$area_first_id[] = $key;
	}

	$records = $manager->db_manager->get('area_second')->areaList($area_first_id, $delivery);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['area_second_id']] = $record['area_second_name'];
	}
	if (count($list) == 0 && $category_large_id > 0 && $prefectures_id > 0) {
		$list[0] = non_select_item();
	}
	return $list;
}

/**
 * 第３エリアマスター
 *
 * @param number $area_second_id
 * @return array
 */
function area_third($area_second_id) {
	$list = array();
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('area_third')->areaList($area_second_id);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['area_third_id']] = $record['area_third_name'];
	}
	if (count($list) == 0 && $area_second_id > 0) {
		$list[0] = non_select_item();
	}
	return $list;
}

function non_select_item() {
	return '選択肢なし';
}

/**
 * 銀行口座種類
 *
 * @return array
 */
function bank_kind() {
	return array(
		1=>"普通",
		2=>"口座",
		3=>"当座",
	);
}

/**
 * コースステータス
 *
 * @return array
 */
function course_status_id(){
	return array(
			1=>'有効にする',
			0=>'有効にしない'
	);
}
/**
 * コースステータス ラベル
 *
 * @return array
 */
function course_status_label(){
	return array(
			0=>'<span class="label label-large label-danger">無効</span>',
			1=>'<span class="label label-large label-success">有効</span>',
	);
}
/**
 * コース一覧取得
 * @param string $store_id
 * @param string $point_kind
 * @return array
 */
function course_list($store_id, $point_kind=NULL){
	$manager = Management::getInstance();
	$returnArray = array();
	//コース一覧取得
	$list = $manager->db_manager->get('course')->courseList($store_id,$point_kind);
	foreach ($list as $key=>$val){
		$returnArray[$val['course_id']] = $val['course_name'];
	}
	return $returnArray;
}
/**
 * コース金額取得
 * @param string $store_id
 * @param string $point_kind
 * @return array
 */
function course_price($store_id, $point_kind=NULL){
	$manager = Management::getInstance();
	$returnArray = array();
	//コース一覧取得
	$list = $manager->db_manager->get('course')->courseList($store_id,$point_kind);
	foreach ($list as $key=>$val){
		$returnArray[$val['course_id']] = $val['price'];
	}
	return $returnArray;
}

/**
 * 今日のニュースステータス ラベル
 *
 * @return array
 */
function news_status_label(){
	return array(
			1=>'<span class="label label-large label-success">公開</span>',
			2=>'<span class="label label-large label-warning">非公開</span>',
	);
}
/**
 * 今日のニュースステータス
 *
 * @return array
 */
function news_status_kind(){
	return array(
			1=>'公開',
			2=>'非公開',
	);
}


/**
 * クーポンステータス ラベル
 *
 * @return array
 */
function coupon_status_label(){
	return array(
			0=>'<span class="label label-large label-danger">無効</span>',
			1=>'<span class="label label-large label-success">有効中</span>',
	);
}

/**
 * ポイント種類
 *
 * @return array
 */
function point_kind(){
	return array(
			1=>'通常',
			2=>'イベント',
	);
}
/**
 * ポイントデータ
 *
 * @return array
 */
function point_data() {
	return array(
			0=>'0',
			1=>'100',
			2=>'200',
			3=>'300',
			4=>'400',
			5=>'500',
			6=>'600',
			7=>'700',
			8=>'800',
			9=>'900',
			10=>'1000',
			11=>'1500',
			12=>'2000',
			13=>'2500',
			14=>'3000',
			15=>'3500',
			16=>'4000',
			17=>'4500',
			18=>'5000',
			19=>'5500',
			20=>'6000',
			21=>'6500',
			22=>'7000',
			23=>'7500',
			24=>'8000',
			25=>'8500',
			26=>'9000',
			27=>'9500',
			28=>'10000',
	);
}
/**
 * 利用ポイントデータ
 *
 * @return array
 */
function use_point_data() {
	return array(
			0=>'選択してください',
			1=>'0',
			2=>'1,000',
			3=>'2,000',
			4=>'3,000',
			5=>'4,000',
			6=>'5,000',
			7=>'6,000',
			8=>'7,000',
			9=>'8,000',
			10=>'9,000',
			11=>'10,000',
			12=>'11,000',
			13=>'12,000',
			14=>'13,000',
			15=>'14,000',
			16=>'15,000',
			17=>'16,000',
			18=>'17,000',
			19=>'18,000',
			20=>'19,000',
			21=>'20,000',
			22=>'25,000',
			23=>'30,000',
			24=>'50,000',
	);
}
/**
 * 特別ポイントデータ
 *
 * @return array
 */
function specialPoint_data() {
	return array(
			0=>'選択してください',
			1=>'100',
			2=>'200',
			3=>'300',
			4=>'400',
			5=>'500',
			6=>'600',
			7=>'700',
			8=>'800',
			9=>'900',
			10=>'1000',
	);
}

/**
 * 予約用プルダウン作成
 *
 * 来客人数、利用時間（時）、利用時間（分）
 *
 * @return array
 */
function reservation_list($max_count) {
	$returnArray = array();

	for($i=0; $i<=$max_count; $i++) {
		$returnArray[$i] = $i;
	}

	return $returnArray;
}

/*-----------------------------------------------------------
 * 権限関連
 *----------------------------------------------------------*/
function permission_kind(){
	return array(
		1=>'WebサイトGuest',
		2=>'Webサイト管理者'
	);
}

