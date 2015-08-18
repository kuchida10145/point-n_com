<?php
/**
 * 入力チェック関連
 */


/**
 * データがある場合cssのerrorクラス取得
 * @param string $str データ
 * @return string
 */
function error_class($str){
	if($str != ''){
		return 'error';
	}
	return '';
}


/**
 * 金額チェック(0以下は認めない）
 */
function plus_moneyChk($key,$data){
	$money = getParam($data,$key);
	
	if(is_digit($money) && $money > 0){
		return true;
	}
	return false;
}

/**
 * 今月かどうかチェック(日付が今月の場合のみtrue）事前にrealdateでチェックしておくこと
 */
function this_monthChk($key,$data){
	$date = getParam($data,$key);
	
	$date = date('Y-m',strtotime($date));
	$today = date('Y-m');
	
	if($today == $date){
		return true;
	}
	return false;
}