<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title;?>｜ポイント.com</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>

		<!--[if lte IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
		<![endif]-->


		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/obj.js"></script>
		<script type="text/javascript" src="../js/font-size.js"></script>
		<script type="text/javascript" src="../js/smooth.pack.js"></script>
		<script type="text/javascript" src="../js/acc.js"></script>

		<!--スライドメニュー-->
		<script src="../js/sidr/jquery.sidr.min.js"></script>
		<link rel="stylesheet" href="../js/sidr/jquery.sidr.light.css">

		<!--datepicker -->
		<link href="../js/calendar/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		<script src="../js/calendar/jquery-ui.min.js"></script>
		<script src="../js/calendar/jquery.ui.core.min.js"></script>
		<script src="../js/calendar/jquery.ui.datepicker.min.js"></script>
		<script src="../js/calendar/jquery.ui.datepicker-ja.min.js"></script>

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
		<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>

		<div id="headsearch">
			<form action="" name="frm" method="get">
				<input name="keyword" value="<?php echo getGet('keyword');?>" placeholder="店舗名検索" type="text">
				<a href="javascript:void(0);" onclick="document.frm.submit();">検索</a>
			</form>
		</div>
		<!--メイン全体-->
		<div id="mainbodywrap">
			<!--ページメイン部分-->
			<div id="mainbody" class="clearfix">
				<!--コンテンツ-->
				<div class="contents">
					<h2>お気に入り一覧</h2>
					<div class="shoplist">
						<?php if(!$list): ?>
						データがありませんでした
						<?php else: ?>
							<?php foreach($list as $data):?>
							<dl class="clearfix">
								<dt>
									<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
									<img src="<?php echo getParam($data, 'image1'); ?>" alt="" />
									</a>
								</dt>
								<dd>
									<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
									<strong><?php echo getParam($data, 'store_name'); ?></strong>
									</a><br />
									<?php echo getParam($data,'category_small_name');?>/<?php echo getParam($data,'region_name');?>
									<?php if(getParam($data,'normal_point_status') == '1'):?>
										<strong class="pointtag">ポイント</strong>
										<strong class="clrred"><?php echo number_format(getParam($data,'normal_point'));?>PT</strong><br />
									<?php endif;?>
									<?php if(getParam($data,'event_point_status') == '1'):?>
										<strong class="eventtag">イベント</strong><strong class="clrgreen"><?php echo number_format(getParam($data,'event_point'));?>PT</strong><br />
									<?php endif;?>
									<?php echo getParam($data,'title');?><br />
									住所：<?php echo getParam($data,'address1');?><?php echo getParam($data,'address2');?><br />
								</dd>
							</dl>
							<?php endforeach;?>
						<?php endif;?>
					</div>
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
	<!--スライド-->
	<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
	<!-- /スライド-->
	</body>
</html>