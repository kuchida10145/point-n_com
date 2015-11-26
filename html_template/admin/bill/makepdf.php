<?PHP
//==============================================================================
//  メイン処理
//==============================================================================

// ライブラリ読み込み
require(dirname(__FILE__).'/../../../include/makePdf/tcpdf/tcpdf.php');
require(dirname(__FILE__).'/../../../include/makePdf/fpdi/fpdi.php');

$fpdi = new FPDI();
$fpdi->setPrintHeader( false );    // 余計な横線を消す
$fpdi->setPrintFooter( false );    // 余計な横線を消す
$fpdi->AddPage("L");

$fpdi->setSourceFile(dirname(__FILE__).'/../../../include/makePdf/fpdi/tmp/bill_tmp.pdf');
$iIndex = $fpdi->importPage(1);
$fpdi->useTemplate($iIndex);

$fpdi->SetFont("msgothic003", "B", 24);
$fpdi->Text(5.0,15.0,"請求月：");
$bill_month = $list["bill_month"];
$fpdi->Text(45.0,15.0, $bill_month);
$fpdi->Text(5.0,29.0,"請求店舗：");
$store_name = $list["store_name"];
$fpdi->Text(45.0,29.0, $store_name);

$fpdi->SetFont("msgothic003", "", 16);
// 請求メイン
// 数値固定
$y = 105.0;
$cellX = 18;
$cellY = 5;
$font_size = 16;
// 記号固定
$kigou_y = 100.0;
$cellX = 18;
$cellY = 5;

// ポイント
$x = 27.0;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["n_point"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// ポイント（キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["n_point_cancel"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// ポイント（未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["n_point_n"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// ポイント手数料
$x = $x + $cellX + 3;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["n_point_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// ポイント手数料（キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["n_point_cancel_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// ポイント手数料（未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["n_point_n_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// イベントポイント
$x = $x + $cellX + 2;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["e_point"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// イベントポイント（キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["e_point_cancel"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// イベントポイント手数料（未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["e_point_n"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// イベントポイント手数料
$x = $x + $cellX + 1;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["e_point_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// イベントポイント手数料（キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["e_point_cancel_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// イベントポイント手数料（未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["e_point_n_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// 特別ポイント
$x = $x + $cellX + 1;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["sp_point"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// 特別ポイント手数料
$x = $x + $cellX + 2;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["sp_point_commission"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// 使用されたポイント(ポイント)
$x = $x + $cellX + 3.5;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["use_n_point"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// 使用されたポイント（ポイント_キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["use_n_point_cancel"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// 使用されたポイント（ポイント_未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["use_n_point_n"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// 使用されたポイント(イベント)
$x = $x + $cellX + 4.5;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["use_e_point"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// 使用されたポイント（イベント_キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["use_e_point_cancel"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// 使用されたポイント（イベント_未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["use_e_point_n"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// 使用されたポイント(ポイントのみ)
$x = $x + $cellX + 11;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["use_point"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// 使用されたポイント（ポイントのみ_キャンセル）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($list["use_point_cancel"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, "＋", 0, 0, 'R');

// 使用されたポイント（キャンセル_未受理）
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 34);
$fpdi->Cell($cellX, $cellY, number_format($list["use_point_n"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 34);

if($list["n_point_n"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// 前払い
$x = $x + $cellX;
$fpdi->SetFontSize(15);
$fpdi->SetXY($x, $y + 0.5);
$fpdi->Cell($cellX, $cellY, number_format($list["deposit_price"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, "▲", 0, 0, 'R');

// 調整
$x = $x + $cellX - 1;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($list["adjust_price"]), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);

if($list["adjust_price"] >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// 処理
$x = $x + $cellX - 5;
$fpdi->SetFontSize(10);
$fpdi->SetXY($x, $y + 1);

if($list["pay_status"] == 0) {
	$view_text = "未確定";
} elseif($list["pay_status"] == 1) {
	$view_text = "未入金";
} elseif($list["pay_status"] == 2) {
	$view_text = "入金";
}
$fpdi->Cell($cellX, $cellY, $view_text, 0, 0, 'R');

// 合計メイン
$total_main = 	$list["n_point"] + $list["n_point_commission"]
			+ $list["e_point"] + $list["e_point_commission"] + $list["sp_point"]
			+ $list["sp_point_commission"] - $list["use_n_point"] - $list["use_e_point"] - $list["use_point"]
			- $list["deposit_price"] - $list["adjust_price"];

if($total_main >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$total_view = abs($total_main);
$x = $x + $cellX + 6;
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y);
$fpdi->Cell($cellX, $cellY, number_format($total_view), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y);
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');


// 合計キャンセル
$total_cancel = 	$list["use_point_cancel"] + $list["use_n_point_cancel"] + $list["use_e_point_cancel"]
					- $list["n_point_cancel"] - $list["n_point_cancel_commission"] - $list["e_point_cancel"] - $list["e_point_cancel_commission"];

if($total_cancel >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$total_cancel_view = abs($total_cancel);
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 20);
$fpdi->Cell($cellX, $cellY, number_format($total_cancel_view), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 20);
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// 合計トータル
$total = $total_main + $total_cancel;

if($total >= 0) {
	$kigou_view = "＋";
} else {
	$kigou_view = "▲";
}
$total_view = abs($total);
$fpdi->SetFontSize($font_size);
$fpdi->SetXY($x, $y + 48);
$fpdi->Cell($cellX, $cellY, number_format($total_view), 0, 0, 'R');
$fpdi->SetXY($x, $kigou_y + 48);
$fpdi->Cell($cellX, $cellY, $kigou_view, 0, 0, 'R');

// ダウンロード

$file_name = $bill_month."_ID_".$list["store_id"].".pdf";
$fpdi->Output($file_name, 'D');

return;
