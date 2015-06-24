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
						<h2>予約画面</h2>
						<form action="confirm.php?m=thanks&tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
							<input type="hidden" name="m" value="thanks" />
							<p>
								<label for="get_point">今回の獲得PT <strong class="clrred"><?php echo number_format(getParam($post, 'get_point'));?>PT</strong></label>
							</p>
							<p>
								<label for="course_name">コース名 <strong><?php echo getParam($post, 'course_name');?></strong></label>
							</p>
							<p>
								<label for="store_name">利用店名 <strong><?php echo getParam($post, 'store_name');?></strong></label>
							</p>
							<h3><span class="clrred">※</span> 来客人数</h3>
								<p>
									<?php echo getParam($post, 'use_persons');?>
									人
								</p>
							<h3><span class="clrred">※</span> 利用日</h3>
								<p>
									<?php echo getParam($post, 'use_date');?>
							<h3><span class="clrred">※</span> 利用時間（到着時刻）</h3>
								<p>
									<?php echo getParam($post, 'use_time');?>
									時
									<?php echo getParam($post, 'use_min');?>
									分
								</p>
							<h3><span class="clrred">※</span> 予約名</h3>
								<p>
									<?php echo getParam($post, 'reserved_name');?>
								</p>
							<h3><span class="clrred">※</span> 予約した電話番号</h3>
								<p>
									<?php echo getParam($post, 'telephone1');?>-<?php echo getParam($post, 'telephone2');?>-<?php echo getParam($post, 'telephone3');?>
								</p>
							<h3>利用するポイント</h3>
								<p>
									<?php echo number_format(getParam($post, 'use_point'));?>
									 PT
								</p>
							<h3>支払合計</h3>
								<p>
									<?php echo number_format($total_price);?>
									 円
									<input type="hidden" name="total_price" value="<?php echo number_format($total_price);?>" />
								</p>
							<div align="center">
								<p>上記内容を確認して「予約する」ボタンを押してください</p>
							</div>
							<p class="alncenter"><a href="index.php?m=index&tkn=<?php echo getGet('tkn');?>" class="linkbtn4 alncenter">戻る</a>
							<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">予約する</a></p>
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