<?PHP
// 共通設定ファイル
include_once( "../include/define.php");
include_once( "../include/functions.php");
include_once( "../include/db.php");

// 顧客管理クラス
include_once( "../include/class.member.php");

// ログイン管理クラス
include_once( "../include/class.login.php");

// データ消去証明書クラス
include_once( "../include/class.delete_certificate.php");

//==============================================================================
//  前処理
//==============================================================================

// HTTPSリダイレクト
https_redirect();

// Session
session_start();

// 顧客管理
$cls_member = new member;

// ログイン
$login = new Login;

// データ消去証明書
$delete_certificate = new delete_certificate();

//==============================================================================
//  ログイン確認
//==============================================================================

// 管理者である場合は、顧客管理のセッションに関係なく
// データ消去証明書を表示できるようにする
if (!$login->Verified_admin()) {
	// 管理者でない場合

	// セッション確認
	if( !isset($_SESSION[MEMBER]) || $_SESSION[MEMBER]['customer_id'] == ""  ){
		redirect('login');
		exit;
	}

	// セッションのCustomerIdでログイン
	$result = $cls_member->login_auth( $_SESSION[MEMBER]['customer_id'] );
	if( $result == false ){
		redirect('login_error');
		exit;
	}
}

//==============================================================================
//  前処理
//==============================================================================

// 必要なデータが揃っているか
if( !isset($_GET['app_id']) || $_GET['app_id'] == '' ){
	redirect('detail_error');
	exit;
}else{
	$apply_id = sanitize($_GET['app_id']);
}

if( isset($_GET['page']) && is_numeric( $_GET['page'] ) ){
	$page = sanitize($_GET['page']);
}else{
	$page = 1;
}

//==============================================================================
//  メイン処理
//==============================================================================

$data_array = $delete_certificate->getData($apply_id, $page);

if(!is_array($data_array)){
	redirect($data_array);
	exit;
}

// ライブラリ読み込み
require(dirname(__FILE__).'/../include/libs/makePdf/tcpdf/tcpdf.php');
require(dirname(__FILE__).'/../include/libs/makePdf/fpdi/fpdi.php');

$fpdi = new FPDI();
$fpdi->setPrintHeader( false );    // 余計な横線を消す
$fpdi->setPrintFooter( false );    // 余計な横線を消す
$fpdi->AddPage();
$fpdi->setSourceFile(dirname(__FILE__).'/../include/libs/makePdf/fpdi/tmp/delete_tmp.pdf');
$iIndex = $fpdi->importPage(1);
$fpdi->useTemplate($iIndex);

$fpdi->SetFont("msgothic003", "", 13);

// 氏名
$x = 42.0;
$y = 43.2;
$font_size = 16;
$name = $data_array['member_name'];
$text = $name.' 様';

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Write(0, $text);

// 申込ID
$x = (8 * mb_strlen($name,'UTF-8')) + 43;
$y = 45.7;
$font_size = 10;
$text = '（申込ID： R'.$apply_id.'）';

$fpdi->SetTextColor(102, 102, 102);
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Write(0, $text);

/** >>> 年月日3種類 >>> */
//固定値
$y = 73;
$cellX = 39;
$cellY = 7;
$font_size = 11;

// 回収日
$x = 43.5;
$text = $data_array['date_pickup'];

$fpdi->SetTextColor(0, 0, 0);
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'C');

// 工場到着日
$x = 86;
$text = $data_array['date_arrived'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'C');

// 消去作業実施予定日
$x = 128.5;
$text = $data_array['date_processed'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'C');
/** <<< 年月日3種類 <<< */

$fpdi->SetFont("ume-tgc5", "", 13);

// 発行日
$x = 42.0;
$y = 40;
$cellX = 125;
$cellY = 4;
$font_size = 8;
$text = '発行日 '.$data_array['date_issued'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'R');

/** >>> 消去パソコン情報 >>> */
// 固定値
$x = 63;
$cellX = 44;
$cellY = 5;
$font_size = 9;

// パソコン
$y = 89;
$text = $data_array['maker_name'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

// 製品情報
$y = 95;
$text = $data_array['kataban'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

// ドライブモデル
$y = 103;
$text = $data_array['model_name'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

// ドライブシリアル番号
$y = 112;
$text = $data_array['serial_number'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');
/** <<< 消去パソコン情報 <<< */

/** >>> 消去情報 >>> */
// 固定値
$x = 131;
$cellX = 44;
$cellY = 5;
$font_size = 8;

// 消去方式
if($data_array['delete_kind'] == 2) {
	$y = 90;
	$text = "専用機による物理破壊方式";
	$fpdi->SetTextColor(0, 0, 0);
	$fpdi->SetFontSize($font_size);
	$fpdi->SetXY($x, $y);
	$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');
} elseif($data_array['delete_kind'] == 3) {
	$y = 90;
	$text = "米国防衛総省方式";
	$fpdi->SetTextColor(204, 0, 0);
	$fpdi->SetFontSize($font_size);
	$fpdi->SetXY($x, $y);
	$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

	$y = 93.5;
	$text = "(ブランコ社製消去ソフト)";
	$fpdi->SetTextColor(0, 0, 0);
	$fpdi->SetFontSize($font_size);
	$fpdi->SetXY($x, $y);
	$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');
}
// 消去開始日時
$y = 98.5;
$text = $data_array['delete_start_datetime'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

// 消去終了時間
$y = 104.5;
$text = $data_array['delete_end_datetime'];

$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

// 消去結果
$y = 111;
$text = $data_array['delete_result_text'];

$fpdi->SetTextColor(204, 0, 0);
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, $text, 0, 0, 'L');

/** <<< 消去情報 <<< */

// ダウンロード
$file_name = 'R'.$apply_id.'_'.$page.'.pdf';
$fpdi->Output($file_name, 'D');

return;
