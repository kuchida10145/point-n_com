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
								<p>ご予約ありがとうございました。<br />
								下記より予約内容をご確認ください。</p>
								<p>また、利用時刻を過ぎますと予約がキャンセル扱いになってしまいます。ご了承ください。</p>
								<div class="box01">
									<h3>ポイントコード</h3>
									<div class="pointcode">
										<p>
											<?php foreach ($point_code_array as $val):?>
												<strong><?php echo $val;?></strong>
											<?php endforeach;?>
										</p>
									</div>
								</div>
								<div class="box02">
									<h3>上記6ケタの数字をお店のスタッフにお伝えください。</h3>
									<p>ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。</p>
								</div>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">予約日時</th>
										    <td><?php echo $reserved_date;?></td>
										</tr>
									</tbody>
								</table>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">今回獲得PT</th>
					    					<td><?php echo number_format(getParam($post, 'get_point'));?>pt</td>
										</tr>
										<tr>
											<th>コース名</th>
					    					<td><?php echo getParam($post, 'course_name');?></td>
										</tr>
										<tr>
											<th>利用店舗名</th>
					    					<td><?php echo $store_name;?></td>
										</tr>
									</tbody>
								</table>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">来店人数</th>
					    					<td><?php echo getParam($post, 'use_persons');?>　人</td>
										</tr>
										<tr>
											<th>利用日</th>
					    					<td><?php echo $use_date;?></td>
										</tr>
										<tr>
											<th>利用時間<br />（到着時間）</th>
					    					<td><?php echo $use_time;?>時　<?php echo $use_min;?>分</td>
										</tr>
										<tr>
											<th>予約名</th>
					    					<td><?php echo getParam($post, 'reserved_name');?></td>
										</tr>
										<tr>
											<th>予約した<br />電話番号</th>
						    				<td><?php echo getParam($post, 'telephone');?></td>
										</tr>
										<tr>
											<th>利用する<br />ポイント</th>
					    					<td><?php echo number_format(getParam($post, 'use_point'));?>PT</td>
										</tr>
										<tr>
											<th>支払合計</th>
					    					<td><?php echo number_format(getParam($post, 'total_price'));?> 円</td>
										</tr>
									</tbody>
								</table>
								<br />
							<h3>ポイント発行規約</h3>
							<p><a href="../info/point_kiyaku.html">こちら</a>をご覧ください。<br /></p>
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