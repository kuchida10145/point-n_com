
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Point.com管理画面</title>
	<?php include_once dirname(__FILE__).'/common/head.php';?>
</head>
<body>
	<!-- start: Header -->
	<?php include_once dirname(__FILE__).'/common/header_contents.php';?>
	<!-- start: Header -->

		<div class="container-fluid-full">
		<div class="row-fluid">
        <!-- start: Main Menu -->
		<?php include_once dirname(__FILE__).'/common/main_menu.php';?>
		<!-- end: Main Menu -->
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<!-- start: Content -->
			<!--********** コンテンツはここから **********-->
			<div id="content" class="span10">
				<ul class="breadcrumb">
					<li>
						<i class="icon-home"></i>
						<a href="index.php">Home</a>
						<i class="icon-angle-right"></i>
					</li>
					<li><a href="#">ダッシュボード</a></li>
				</ul>

				<div class="box-content">
					<a class="quick-button span2" href="notice.php">
						<i class="icon-flag"></i>
						<p>お知らせ情報登録</p>
					</a>
					<a class="quick-button span2" href="course.php">
						<i class="icon-random"></i>
						<p>コース情報登録</p>
					</a>
					<a class="quick-button span2" href="coupon.php">
						<i class="icon-money"></i>
						<p>クーポン発行</p>
					</a>
					<a class="quick-button span2" href="reserve.php">
						<i class="icon-tags"></i>
						<p>予約管理</p>
					</a>
					<a class="quick-button span2" href="special_point.php">
						<i class="icon-bookmark"></i>
						<p>特別ポイント管理</p>
					</a>
					<a class="quick-button span2" href="claim.php">
						<i class="icon-edit"></i>
						<p>請求処理</p>
					</a>
					<div class="clearfix"></div>
				</div>


				 <div class="box-content">
					<a class="quick-button span2" href="account.php">
						<i class="icon-user"></i>
						<p>アカウント設定</p>
					</a>
					 <div class="clearfix"></div>
				</div>

			</div><!--/.fluid-container-->
			<!-- end: Content -->
			<!--********** コンテンツはここまで **********-->

		</div><!--/#content.span10-->
		</div><!--/fluid-row-->



	<div class="clearfix"></div>
	<footer>
		<p>
			<span style="text-align:left;float:left">Copyright 2015 POINT.COM All Rights Reserved </span>
		</p>
	</footer>
	<!-- start: JavaScript-->
	<?php include_once dirname(__FILE__).'/common/footer_javascript.php';?>
	<!-- end: JavaScript-->
</body>
</html>