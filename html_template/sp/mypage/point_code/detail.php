<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ポイントコード表示（確認）｜ポイント.com</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php include_once dirname(__FILE__).'/../../common/header_meta.php';?>

		<!--[if lte IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
		<![endif]-->


		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/obj.js"></script>
		<script type="text/javascript" src="/js/font-size.js"></script>
		<script type="text/javascript" src="/js/smooth.pack.js"></script>
		<script type="text/javascript" src="/js/acc.js"></script>

		<!--スライドメニュー-->
		<script src="/js/sidr/jquery.sidr.min.js"></script>
		<link rel="stylesheet" href="../js/sidr/jquery.sidr.light.css">

	</head>
	<body id="register">
		<!--全体-->
		<div id="wrap">
			<a name="top" id="top"></a>
			<!--ヘッダ-->
			<?php include_once dirname(__FILE__).'/../../common/header_contents.php';?>

			<!--ヘッダ-->
				<!--メイン全体-->
					<div id="mainbodywrap">
						<!--ページメイン部分-->
						<div id="mainbody" class="clearfix">
						<!--コンテンツ-->
							<div class="contents">
								<h2>ポイントコード表示（確認）</h2>
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
										    <td><?php echo $point_code['reserved_date'];?></td>
										</tr>
									</tbody>
								</table>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">今回獲得PT</th>
					    					<td><?php echo number_format(getParam($point_code, 'get_point'));?>pt</td>
										</tr>
										<tr>
											<th>コース名</th>
					    					<td><?php echo getParam($point_code, 'course_name');?></td>
										</tr>
										<tr>
											<th>利用店舗名</th>
					    					<td><?php echo $point_code['store_name'];?></td>
										</tr>
									</tbody>
								</table>
								<table border="0" cellpadding="0" cellspacing="0" class="table02">
									<tbody>
										<tr>
											<th width="35%">来店人数</th>
					    					<td><?php echo getParam($point_code, 'use_persons');?>　人</td>
										</tr>
										<tr>
											<th>利用日</th>
					    					<td><?php echo $point_code['use_date'];?></td>
										</tr>
										<tr>
											<th>利用時間<br />（到着時間）</th>
					    					<td><?php echo $point_code['use_time'];?></td>
										</tr>
										<tr>
											<th>予約名</th>
					    					<td><?php echo getParam($point_code, 'reserved_name');?></td>
										</tr>
										<tr>
											<th>予約した<br />電話番号</th>
						    				<td><?php echo getParam($point_code, 'telephone');?></td>
										</tr>
										<tr>
											<th>利用する<br />ポイント</th>
					    					<td><?php echo number_format(getParam($point_code, 'use_point'));?>PT</td>
										</tr>
										<tr>
											<th>支払合計</th>
					    					<td><?php echo number_format(getParam($point_code, 'total_price'));?> 円</td>
										</tr>
									</tbody>
								</table>
								<br />
							<p class="alncenter"><a href="../../index.php" class="linkbtn">トップページに戻る</a></p>
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
			<?php include_once dirname(__FILE__).'/../../common/slide_contents.php';?>
			<!-- /スライド-->
		</body>
</html>