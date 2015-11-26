
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

					<!--<a class="quick-button span2" href="#"> <i class="icon-th-large"></i><p>エリアマスター管理1</p></a>
					<a class="quick-button span2" href="#"> <i class="icon-tasks"></i><p>ジャンルマスター管理</p></a>-->
					<a class="quick-button span2" href="store.php"> <i class="icon-flag"></i><p>店舗情報管理<br />　</p></a>
					<a class="quick-button span2" href="news.php"> <i class="icon-list-alt"></i><p>今日のニュース管理<br />　</p></a>
					<a class="quick-button span2" href="notice.php"> <i class="icon-bullhorn"></i><p>POINT.COMからの<br />お知らせ情報管理</p></a>
					<a class="quick-button span2" href="user.php"> <i class="icon-user"></i><p>ユーザー管理<br />　</p></a>

					<a class="quick-button span2" href="claim.php"> <i class="icon-edit"></i><p>ポイント利用履歴（受理済）<br />　</p></a>
					<a class="quick-button span2" href="bill.php"> <i class="icon-money"></i><p>請求管理<br />　</p></a>

					<div class="clearfix"></div>
				</div>
				<div class="box-content">
					<a class="quick-button span2" href="automail.php"> <i class="icon-envelope"></i><p>自動返信メール管理<br />　</p></a>
					<a class="quick-button span2" href="account.php"> <i class="icon-user"></i><p>アカウント設定<br />　</p></a>
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