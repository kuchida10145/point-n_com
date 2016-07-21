<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>今日のニュース検索　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,検索,ニュース" />
<meta name="description" content="ポイントドットコムでは、地域ごとの店舗からのお知らせをご覧いただけます。" />
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
						<p class="heartitle">今日のニュース検索</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="">今日のニュース検索</h3>
							<p class="mb10 txt14 weight800">地域を選んでください</p>
							<div class="select4btn">
								<ul class="clearfix fixHeight">
									<?php foreach (region_master() as $val_key => $val_name) : ?>
									<li>
										<input type="radio" id="<?php echo "region_id_" . $val_key; ?>" name="region_id" value="<?php echo $val_key; ?>">
										<label for="<?php echo "region_id_" . $val_key; ?>" class="_area_link" data-id="<?php echo $val_key;?>"><?php echo $val_name; ?></label>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
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
