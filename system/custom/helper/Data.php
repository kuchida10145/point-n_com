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
 * 大カテゴリー（ジャンルマスター）
 * 
 * @return array
 */
function category_large() {
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('category_large')->adminSearch("", "", " ORDER BY rank ASC ");
	$records = ($records != null) ? $records : array();
	$list = array();
	foreach ($records as $record) {
		$list[$record['category_large_id']] = $record['category_large_name'];
	}
	return $list;
}

/**
 * 中カテゴリー
 * 
 * @param number $category_large_id
 * @return array
 */
function category_midium($category_large_id) {
	return array(1=>"ヘルス");
}

/**
 * 小カテゴリー
 * 
 * @param number $category_midium_id
 * @return array
 */
function category_small($category_midium_id) {
	return array(1=>"ファッションヘルス");
}

/**
 * 地域マスター（エリアマスター）
 * 
 * @return array
 */
function region_master() {
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('region_master')->adminSearch("", "", " ORDER BY rank ASC ");
	$records = ($records != null) ? $records : array();
	$list = array();
	foreach ($records as $record) {
		$list[$record['region_id']] = $record['region_name'];
	}
	return $list;
}

/**
 * 第１エリアマスター
 * 
 * @return array
 */
function area_first() {
	$manager = Management::getInstance();
	$records = $manager->db_manager->get('area_first')->adminSearch("", "", " ORDER BY rank ASC ");
	$records = ($records != null) ? $records : array();
	$list = array();
	foreach ($records as $record) {
		$list[$record['area_first_id']] = $record['area_first_name'];
	}
	return $list;
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

