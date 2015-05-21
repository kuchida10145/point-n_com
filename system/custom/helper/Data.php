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

