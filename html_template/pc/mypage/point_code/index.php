<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ポイントコード一覧　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,ポイントコード一覧" />
<meta name="description" content="ポイントコード一覧を表示いたします。" />
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
						<p class="heartitle">ポイントコード一覧（確認）</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="">ポイントコード一覧（確認）</h3>
							<?php if(!$point_codes):?>
							データがありませんでした
							<?php else:?>
							<table class="point_rireki_table mb20">
								<tbody>
									<tr>
										<th>来店日</th>
										<th>利用店舗名</th>
										<th>-</th>
									</tr>
									<?php foreach($point_codes as $point_code):?>
									<tr>
										<td><?php echo date('Y年m月d日 H:i',strtotime(getParam($point_code,'use_date')));?></td>
										<td><?php echo getParam($point_code,'store_name');?></td>
										<td><a href="/mypage/point_code/detail.php?id=<?php echo getParam($point_code,'reserved_id');?>">ポイントコード表示</a></td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							<p class="txt12">ポイント履歴で表示される期間は利用した日時より1年間とし、それ以前の履歴は自動削除されますので、予めご了承ください。</p>
							<?php endif;?>
							<p class="btn_page_top"><a href="/pc_test/index.php">TOPページへ戻る</a></p>
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
