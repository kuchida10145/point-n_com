<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ポイントコード表示　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,ポイントコード表示" />
<meta name="description" content="ポイントコードを表示いたします。" />
<?PHP include( dirname(__FILE__)."/../../tpl/head.php");?>
</head>
<body id="genre" class="top">
<?PHP include( dirname(__FILE__)."/../../tpl/header.php");?>
<!--container-->
<div class="container">
	<div class="mainbodybg01">
		<!--mainbody-->
		<div class="mainbody">
			<div class="contents clearfix">
				<?PHP include( dirname(__FILE__)."/../../tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">ポイントコード表示</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_01">
						<h3 class="clearfix">ポイントコード</h3>
						<p class="point_code7">
						<?php foreach ($point_code_array as $val):?>
							<?php echo $val;?>
						<?php endforeach;?>
						</p>
						<div class="point_code_info">
						<p><strong>上記7ケタの数字をお店のスタッフにお伝えください。</strong></p>
						<p class="txt11">ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。ポイント発行の説明が入ります。</p>
						</div>
						</div>
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb30">予約完了</h3>
							<div class="mb25">
								<p>ご予約ありがとうございました。下記より予約内容をご確認ください。</p>
								<p>また、利用時刻を過ぎますと予約がキャンセル扱いになってしまいます。ご了承ください。</p>
							</div>
							<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03 mb25">
								<tbody>
									<tr>
										<th width="35%">予約日時</th>
										<td><?php echo $point_code['reserved_date'];?></td>
									</tr>
								</tbody>
							</table>
							<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03 mb25">
								<tbody>
									<tr>
										<th width="35%">今回獲得PT</th>
										<td><?php echo number_format(getParam($point_code, 'get_point'));?>PT</td>
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
							<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03 mb25">
								<tbody>
									<tr>
										<th width="35%">来店人数</th>
										<td><?php echo getParam($point_code, 'use_persons');?>　人</td>
									</tr>
									<tr>
										<th>来店日</th>
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
							<p class="btn_page_top"><a href="/pc_test/">TOPページへ戻る</a></p>
						</div>
					</div>
				</div>
			</div><!--/.contents-->
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../../tpl/footer.php");?>
</body>
</html>
