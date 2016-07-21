<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>今日のニュース詳細　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ニュース,詳細" />
<meta name="description" content="今日のニュース詳細を表示いたします。" />
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
						<p class="heartitle">今日のニュース詳細</p>
					</div>

					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb25"><?php echo $news_data['title'];?></h3>
							<div style="width: 550px;		margin: 0 auto;">
								<!-- start:スライド写真-->
								<div class="photoslide_new">
								<?php if($images):?>
									<div>
										<p><img src="/files/images/<?php echo $img;?>" alt=""/></p>
									</div>
								<?php endif;?>
								</div>
								<!-- end:スライド写真 -->
							</div>
							<p class="mb25"><?php echo $news_data['body'];?></p>
							<p class="btn_page_top"><a href="/news/index.php?region_id=<?php echo $news_data['region_id'];?>">一覧へ戻る</a></p>
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
