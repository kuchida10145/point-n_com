<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>キャッチメール｜ポイント.com</title>
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
								<h2>キャッチメール画面</h2>
								<p>キャッチメールの利用ありがとうございました。<br />
								店舗から連絡が来るまでしばらくお待ちください。</p>
								<p>また、利用時刻を過ぎますと予約がキャンセル扱いになってしまいます。ご了承ください。</p>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%" style="color: red">キャッチメール失効時間</th>
										    <td style="color: red">
											    <?php echo getParam($post, 'dead_time');?>
												まで
										    </td>
										</tr>
										<tr>
											<th width="35%">何時から遊びたいか（希望時刻）</th>
										    <td>
										    	<?php if(getParam($post, 'time_kind') == 0): ?>
													今から
												<?php else: ?>
													<?php echo getParam($post, 'reserved_date');?>
													頃〜
												<?php endif; ?>
										    </td>
										</tr>
									</tbody>
								</table>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">来店人数</th>
					    					<td><?php echo getParam($post, 'use_persons');?>人</td>
										</tr>
										<tr>
											<th>予約名</th>
					    					<td><?php echo getParam($post, 'reserved_name');?></td>
										</tr>
										<tr>
											<th>都道府県</th>
					    					<td>
					    					<?php
												$area_first_array = prefectures_master();
												echo $area_first_array[getParam($post, 'area_first_prefectures_id')];
											?>
					    					</td>
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
											<th>エリア</th>
					    					<td>
					    						<?php
													$area_second_array = area_second_to_extend(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
													echo $area_second_array[getParam($post, 'area_second_id')];
												?>
					    					</td>
										</tr>
										<tr>
											<th>詳細エリア</th>
					    					<td>
					    					<?php
												$area_second_array = area_third(getParam($post, 'area_second_id'));
												echo $area_second_array[getParam($post, 'area_third_id')];
											?>
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