<?php
/**
 * 設定ファイル
 *
 */


/*
|--------------------------------------------------------------------------
| データベース設定
|--------------------------------------------------------------------------
 */

define('DB_NAME','point');
define('DB_USER','root');
define('DB_PASS','1966tsuki6');
define('DB_HOST','localhost');
define('DB_CHARSET','utf8');

/*
|--------------------------------------------------------------------------
| 定数宣言
|--------------------------------------------------------------------------
 */

if($_SERVER["SERVER_NAME"] == "point.lo") {
	define('HTTP_HOST','http://point.lo');
} elseif($_SERVER["SERVER_NAME"] == "test.point-n.com") {
	define('HTTP_HOST','http://test.point-n.com');
}

//システムディレクトリ
define('SYSTEM_DIR',dirname(__FILE__)."/");

//テンプレートディレクトリ
define('TEMPLATE_DIR',dirname(__FILE__).'/../html_template/');

//ルートディレクトリ
define('ROOT_DIR',dirname(__FILE__).'/../');

//ルートURL
define('ROOT_URL','/');


//管理者画面ＵＲＬ
define('ADMIN_URL',ROOT_URL.'maintenance/');



//管理者メールアドレス
define('ADMIN_MAIL','takahashi@6web.co.jp');


/*----------------------------
  アップロードディレクトリ
-----------------------------*/
define('UPLOAD_IMG_DIR',ROOT_DIR.'files/images/');//アップロードファイルディレクトリ
define('UPLOAD_IMG_URL',ROOT_URL.'files/images/');//アップローディディレクトリＵＲＬ




/*----------------------------
 * ステータス
*----------------------------*/
define('ST_INV' ,0);//無効
define('ST_ACT' ,1);//有効

/*----------------------------
 * 会員ステータス
 *----------------------------*/
define('USER_ST_REQ' ,1);//仮登録
define('USER_ST_ACT' ,2);//有効
define('USER_ST_STOP',9);//停止

/*----------------------------
 * 予約ステータス
*----------------------------*/
define('RESERVE_ST_INV' ,0);//無効
define('RESERVE_ST_YET' ,1);//未処理
define('RESERVE_ST_FIN' ,2);//処理完了
define('RESERVE_ST_SP'  ,9);//特別ポイント

//暗号化キー
define('PW_KEY',md5('point'));

/*----------------------------
 * 予約情報
*----------------------------*/
define('MAX_PERSON' ,50);//最大来客人数
define('MAX_USE_TIME' ,23);//最大利用時間
define('MAX_USE_MIN',59);//最大利用分
