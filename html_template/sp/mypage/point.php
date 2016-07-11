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
		<!--メイン全体-->
		<div id="mainbodywrap">
			<!--ページメイン部分-->
			<div id="mainbody" class="clearfix">
				<!--コンテンツ-->
				<div class="contents">
					<h2>ポイント履歴</h2>
					<div style="text-align:right;">
						<strong>（ポイント状況記号：未=未処理/済=処理済/★=特別PT/キ=キャンセル）</strong>
					</div>
					<div class="pointhistory">
						<?php if(!$list):?>
						データがありませんでした
						<?php else:?>
							<table border="0" cellpadding="0" cellspacing="0" class="table02">
								<tbody>
									<tr>
										<td class="bg12">来店日</td>
										<td class="bg12"> 利用店舗名</td>
										<td align="center" class="bg12">ポイント状況<br />
										<td align="center" class="bg08">ポイント<br />
										利用</td>
										<td align="center" class="bg18">ポイント<br />
										取得</td>
									</tr>
									<?php foreach($list as $data):?>
									<tr>
										<td><?php echo getParam($data,'use_date');?></td>
										<td><a href="/mypage/point_code/detail.php?id=<?php echo getParam($data,'reserved_id');?>"><?php echo getParam($data,'store_name');?></a></td>
										<?php if(getParam($data,'status_id') == 1):?>
											<td align="center" style="color:#ff0000;"><?php echo "未";?></td>
										<?php elseif (getParam($data,'status_id') == 2):?>
											<td align="center"><?php echo "済";?></td>
										<?php elseif (getParam($data,'status_id') == 9):?>
											<td align="center"><?php echo "★";?></td>
										<?php elseif (getParam($data,'status_id') == 0):?>
											<td align="center" style="color:#ff0000;"><?php echo "キ";?></td>
										<?php endif;?>
										<td align="center"><?php echo number_format(getParam($data,'use_point'));?>PT</td>
										<td align="center"><?php echo number_format(getParam($data,'get_point'));?>PT</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							<p>ポイント履歴で表示される期間は利用した日時より1年間とし、それ以前の履歴は自動削除されますので、予めご了承ください。</p>
							<?php echo $pager_html;?>
						<?php endif;?>
					</div>
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
		<!--スライド-->
		<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
		<!-- /スライド-->
	</body>
</html>