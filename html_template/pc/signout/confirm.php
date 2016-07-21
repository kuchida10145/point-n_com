<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>退会申請　確認　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,退会申請" />
<meta name="description" content="ポイントドットコムの退会申請確認ページです。" />
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
				<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<h2 class="heartitle">退会申請　確認</h2>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_01">
							<h3>退会申請　確認</h3>
							<div class="mb25">
								<p>退会するとポイントは入りません。</p>
							</div>
							<form method="post" action="" name="frm">
								<input type="hidden" name="m" value="confirm" />
								<p class="btn_return_confirm clearfix"><a href="/signout/?tkn=<?php echo getGet('tkn');?>">戻る</a>
								<a href="javascript:void(0);" onclick="document.frm.submit();">退会する</a></p>
							</form>
						</div>
					</div>
				</div>
			</div><!--/.contents-->
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( $_SERVER['DOCUMENT_ROOT']."/pc_test/tpl/footer.php");?>
</body>
</html>
