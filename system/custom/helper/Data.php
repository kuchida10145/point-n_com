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
		2=>'可能',
		9=>'不可'
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
		2=>'<span class="label label-large label-success">可能</span>',
		9=>'<span class="label label-large label-warning">不可</span>',
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
	$records = $manager->db_manager->get('category_large')->adminSearch("", "", " ORDER BY rank ASC ");
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

	$wheres = array();
	$wheres[] = 'category_large_id = ' . $category_large_id;
	$wheres[] = 'region_id = ' . $region_id;
	$wheres[] = "delivery = '" . $delivery . "'";
	$records = $manager->db_manager->get('category_midium')->adminSearch($wheres, "", " ORDER BY rank ASC ");
	$records = ($records != null) ? $records : array();
	foreach ($records as $record) {
		$list[$record['category_midium_id']] = $record['category_midium_name'];
	}
// 	if (count($list) == 0 && $category_large_id > 0) {
// 		$list[0] = non_select_item();
// 	}
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
	$wheres = array();
	$wheres[] = 'category_midium_id = ' . $category_midium_id;
	$records = $manager->db_manager->get('category_small')->adminSearch($wheres, "", " ORDER BY rank ASC ");
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
	$records = $manager->db_manager->get('region_master')->adminSearch("", "", " ORDER BY rank ASC ");
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
	$records = $manager->db_manager->get('prefectures_master')->adminSearch("", "", " ORDER BY prefectures_id ASC ");
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
 * @return array
 */
function area_first($category_large_id, $prefectures_id) {
	$list = array();
	$manager = Management::getInstance();
	$record  = $manager->db_manager->get('prefectures_master')->findById($prefectures_id);
	if ($record == null) {
		return $list;
	}
	$region_id = $record['region_id'];
	$prefectures_name = $record['prefectures_name'];

	$wheres = array();
	$wheres[] = 'category_large_id = ' . $category_large_id;
	$wheres[] = 'region_id = ' . $region_id;
	$wheres[] = "(prefectures_id = " . $prefectures_id . " OR area_first_name = '" . $prefectures_name . "')";
	$records = $manager->db_manager->get('area_first')->adminSearch($wheres, "", " ORDER BY rank ASC ");
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
	$wheres = array();
	$wheres[] = 'area_first_id = ' . $area_first_id;
	$wheres[] = "delivery = '" . $delivery . "'";
	$records = $manager->db_manager->get('area_second')->adminSearch($wheres, "", " ORDER BY rank ASC ");
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
	$area_first_list = area_first($category_large_id, $prefectures_id);
	if (count($area_first_list) <= 0) {
		return $list;
	}
	$area_first_id = array();
	foreach ($area_first_list as $key => $value) {
		$area_first_id[] = $key;
	}

	$wheres = array();
	$wheres[] = 'area_first_id IN (' . implode(",", $area_first_id) . ')';
	$wheres[] = "delivery = '" . $delivery . "'";
	$records = $manager->db_manager->get('area_second')->adminSearch($wheres, "", " ORDER BY rank ASC ");
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
	$wheres = array();
	$wheres[] = 'area_second_id = ' . $area_second_id;
	$records = $manager->db_manager->get('area_third')->adminSearch($wheres, "", " ORDER BY rank ASC ");
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
 * ポイント種類
 *
 * @return array
 */
function point_kind(){
	return array(
			1=>'通常',
			2=>'イベント',
			3=>'特別',
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

