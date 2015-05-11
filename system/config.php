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

define('HTTP_HOST','http://point.lo');

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
 * 会員ステータス
 *----------------------------*/
define('USER_ST_REQ' ,1);//仮登録
define('USER_ST_ACT' ,2);//有効
define('USER_ST_STOP',9);//停止

//暗号化キー
define('PW_KEY',md5('point'));


