<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>POINT.COMからのお知らせ詳細　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,詳細" />
<meta name="description" content="POINT.COMからのお知らせ詳細を表示いたします。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="genre" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div class="container">
	<div class="mainbodybg01">
		<!--mainbody-->
		<div class="mainbody">
			<div class="contents clearfix">
				<?PHP include( $_SERVER['DOCUMENT_ROOT']."/pc_test/tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">POINT.COMからのお知らせ詳細</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb25"><?php echo $info_data['title'];?></h3>
							<div style="width: 550px;		margin: 0 auto;">
								<?php if($images):?>
								<!-- start:スライド写真-->
								<div class="photoslide_new">
									<?php foreach($images as $img):?>
									<div>
										<p><img src="/files/images/<?php echo $img;?>" alt=""/></p>
									</div>
									<?php endforeach;?>
								</div>
								<!-- end:スライド写真 -->
								<?php endif;?>
							</div>
							<p class="mb25"><?php echo $info_data['body'];?></p>
							<p class="btn_page_top"><a href="/info/">一覧へ戻る</a></p>
						</div>
					</div>
				</div>
			</div><!--/.contents-->
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
