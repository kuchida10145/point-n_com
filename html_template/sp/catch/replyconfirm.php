<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>キャッチメール　店舗確認画面｜ポイント.com</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>

		<!--[if lte IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
		<![endif]-->


		<script type="text/javascript" src="../../../js/jquery.js"></script>
		<script type="text/javascript" src="../../../js/obj.js"></script>
		<script type="text/javascript" src="../../../js/font-size.js"></script>
		<script type="text/javascript" src="../../../js/smooth.pack.js"></script>
		<script type="text/javascript" src="../../../js/acc.js"></script>

		<!--スライドメニュー-->
		<script src="../../../js/sidr/jquery.sidr.min.js"></script>
		<link rel="stylesheet" href="../js/sidr/jquery.sidr.light.css">

		<!--datepicker -->
		<link href="../../../js/calendar/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		<script src="../../../js/calendar/jquery-ui.min.js"></script>
		<script src="../../../js/calendar/jquery.ui.core.min.js"></script>
		<script src="../../../js/calendar/jquery.ui.datepicker.min.js"></script>
		<script src="../../../js/calendar/jquery.ui.datepicker-ja.min.js"></script>

		<script type="text/javascript">
		$(function() {
		    $('#date_from').datepicker({
		        dateFormat: 'yy-mm-dd',//年月日の並びを変更
		    });
			$('#date_return').datepicker({
		        dateFormat: 'yy-mm-dd',//年月日の並びを変更
		    });
		});
		</script>
	</head>
	<body id="register">
	<?php include_once dirname(__FILE__).'/../common/analyticstracking.php';?>
		<!--全体-->
		<div id="wrap">
			<a name="top" id="top"></a>
			<!--ヘッダ-->
			<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
			<?php include_once dirname(__FILE__).'/../common/header_search.php';?>
			<!--ヘッダ-->
				<!--メイン全体-->
				<div id="mainbodywrap">
				<!--ページメイン部分-->
				<div id="mainbody" class="clearfix">
					<!--コンテンツ-->
					<div class="contents">
						<h2>店舗決定確認画面</h2>
						<form action="replyconfirm.php?m=thanks&tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
							<input type="hidden" name="m" value="thanks" />

							<h3>予約時間</h3>
							<p>
								<?php echo getParam($post, 'reserved_date');?>
							</p>
							<h3>予約人数</h3>
							<p>
								<?php echo getParam($post, 'use_persons');?>人
							</p>
							<h3>ジャンル</h3>
							<p>
								<?php
									$category_large_array = category_large();
									echo $category_large_array[getParam($post, 'category_large_id')];
								?>
							</p>
							<h3>カテゴリ</h3>
							<p>
								<?php
									$category_midium_array = category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
									echo $category_midium_array[getParam($post, 'category_midium_id')];
								?>
							</p>
							<h3>店舗名</h3>
							<p>
								<?php echo getParam($post, 'store_name');?>
							</p>
							<h3>住所</h3>
							<p>
								<?php echo getParam($post, 'address1').getParam($post, 'address2');?>
							</p>
							<h3>電話番号</h3>
							<p>
								<a href="tel:<?php echo getParam($post, 'telephone');?>"><?php echo getParam($post, 'telephone');?></a>
							</p>
							<h3>料金</h3>
							<p>
								<?php echo number_format(getParam($post, 'money'));?>円
							</p>
							<h3><span class="clrred">注意事項</span></h3>
							<p>
								<span class="clrred">必ず決定前に店舗へ電話連絡を行ってください。</span>
							</p>
							<input type="hidden" name="catchmail_id" value="<?php echo getParam($post, 'catchmail_id');?>" />
							<input type="hidden" name="catchmail_return_id" value="<?php echo getParam($post, 'catchmail_return_id');?>" />
							<input type="hidden" name="store_name" value="<?php echo getParam($post, 'store_name');?>" />
							<div align="center">
								<p>上記内容を確認して「決定」ボタンを押してください</p>
							</div>
							<p class="alncenter"><a href="index.php?tkn=<?php echo getGet('tkn');?>" class="linkbtn4 alncenter">戻る</a>
							<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">決定</a></p>
						</form>
					</div>
					<!--/コンテンツ-->
					<div id="footer">
						<address>
							Copyright 2015 POINT.COM All Rights Reserved
						</address>
					</div>
				</div>
				<!--/ページメイン部分-->
			</div>
			<!--/メイン全体-->
		</div>
		<!--/全体-->
		<!--スライド-->
		<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
		<!-- /スライド-->
	</body>
</html>