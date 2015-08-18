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
		3=>'ホスト・ガールズウォーター',
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
 * 中カテゴリー（カスタマー用）
 *
 * @param number $category_large_id
 * @param number $region_id
 * @param number $delivery
 * @return array
 */
function category_midium_for_customer($category_large_id, $region_id, $delivery = null) {
	$list = array();
	$manager = Management::getInstance();
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
 * 小カテゴリー（カスタマー用）
 *
 * @param number $category_midium_id
 * @return array
 */
function category_small_for_customer($category_midium_id) {
	$list = array();
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('category_small')->categoryListCustomer($category_midium_id);
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['category_small_id']] = $record['category_small_name'];
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
 * お知らせステータス（WEBサイト管理･店舗管理共通）
 *
 * @return array
 */
function notice_public_kind(){
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
			1=>'クーポン',
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
			100=>'100',
			200=>'200',
			300=>'300',
			400=>'400',
			500=>'500',
			600=>'600',
			700=>'700',
			800=>'800',
			900=>'900',
			1000=>'1000',
			1500=>'1500',
			2000=>'2000',
			2500=>'2500',
			3000=>'3000',
			3500=>'3500',
			4000=>'4000',
			4500=>'4500',
			5000=>'5000',
			5500=>'5500',
			6000=>'6000',
			6500=>'6500',
			7000=>'7000',
			7500=>'7500',
			8000=>'8000',
			8500=>'8500',
			9000=>'9000',
			9500=>'9500',
			10000=>'10000',
	);
}
/**
 * 利用ポイントデータ
 *
 * @return array
 */
function use_point_data() {
	return array(
			1=>'0',
			1000=>'1,000',
			2000=>'2,000',
			3000=>'3,000',
			4000=>'4,000',
			5000=>'5,000',
			6000=>'6,000',
			7000=>'7,000',
			8000=>'8,000',
			9000=>'9,000',
			10000=>'10,000',
			11000=>'11,000',
			12000=>'12,000',
			13000=>'13,000',
			14000=>'14,000',
			15000=>'15,000',
			16000=>'16,000',
			17000=>'17,000',
			18000=>'18,000',
			19000=>'19,000',
			20000=>'20,000',
			25000=>'25,000',
			30000=>'30,000',
			50000=>'50,000',
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
			100=>'100',
			200=>'200',
			300=>'300',
			400=>'400',
			500=>'500',
			600=>'600',
			700=>'700',
			800=>'800',
			900=>'900',
			1000=>'1000',
	);
}


/**
 * 予約人数プルダウン
 */
function reservation_person_cnt(){
	$returnArray = array();

	for($i=1; $i<=MAX_PERSON; $i++) {
		$returnArray[$i] = $i;
	}

	return $returnArray;
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

/**
 * 店舗検索結果一覧の並べ替えリスト
 *
 * @return array
 */
function search_sortlist() {
	return array(
		1=>'ポイントが高い順',
		2=>'イベントポイントが高い順',
		3=>'ポイント総額料金が高い順',
		4=>'ポイント総額料金が低い順',
		5=>'イベントポイント総額料金が高い順',
		6=>'イベントポイント総額料金が低い順',
		7=>'新着店舗',
	);
}

/**
 * 利用枠追加種類(支払い方法)
 */
function add_limit_type(){
	return array(
		1=>'前払い',
		2=>'後払い'
	);
}

/**
 * 利用枠承認状況
 */
function add_review_status(){
	return array(
		0=>'未承認',
		1=>'承認'
	);
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

