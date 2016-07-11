<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>予約｜ポイント.com</title>
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
			<!--ヘッダ-->
				<!--メイン全体-->
				<div id="mainbodywrap">
				<!--ページメイン部分-->
				<div id="mainbody" class="clearfix">
					<div class="titlebox">
					<h2>予約失敗</h2>
					</div>


					<!--コンテンツ-->
					<div class="contents">
						<h3>クーポン発行上限に達しました</h3>
						<p>クーポンの発行上限に達したため、予約を行うことができませんでした。</p>
						<p class="alncenter"><a href="../index.php" class="linkbtn">トップページに戻る</a></p>
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