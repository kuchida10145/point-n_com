<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>キャッチメール　店舗決定画面｜ポイント.com</title>
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
								<h2>キャッチメール　店舗決定画面</h2>
								<p>キャッチメールの利用ありがとうございました。<br />
								以下の条件で決定しました。</p>
								<p>また、利用時刻を過ぎますと予約がキャンセル扱いになってしまいます。ご了承ください。</p>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">予約時刻</th>
										    <td>
												<?php echo getParam($post, 'reserved_date');?> 頃〜
										    </td>
										</tr>
										<tr>
											<th width="35%">来店人数</th>
					    					<td><?php echo getParam($post, 'use_persons');?>人</td>
										</tr>
										<tr>
											<th>ジャンル</th>
					    					<td>
					    					<?php
												$category_large_array = category_large();
												echo $category_large_array[getParam($post, 'category_large_id')];
											?>
					    					</td>
										</tr>
										<tr>
											<th>カテゴリ</th>
						    				<td>
						    				<?php
												$category_midium_array = category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
												echo $category_midium_array[getParam($post, 'category_midium_id')];
											?>
						    				</td>
										</tr>
										<tr>
											<th>店舗名</th>
					    					<td>
					    						<?php echo getParam($post, 'store_name');?>
					    					</td>
										</tr>
										<tr>
											<th>住所</th>
					    					<td>
						    					<?php echo getParam($post, 'address1').getParam($post, 'address2');?>
					    					</td>
										</tr>
										<tr>
											<th>電話番号</th>
					    					<td>
						    					<?php echo getParam($post, 'telephone');?>
					    					</td>
										</tr>
										<tr>
											<th>金額</th>
					    					<td>
					    						<?php echo number_format(getParam($post, 'money'));?>円
					    					</td>
										</tr>
									</tbody>
								</table>
								<br />
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