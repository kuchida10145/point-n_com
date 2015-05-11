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