<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>退会申請　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,全国,退会,申請" />
<meta name="description" content="ポイントドットコム退会申請いたします。" />
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
						<h2 class="heartitle">退会申請</h2>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_01">
							<h3>退会規約</h3>
							<div class="mb25">
								<h4>■ ポイントについて</h4>
								<p>アカウントは抹消され、現在の所有ポイント、取得予定ポイントは全て無効になります。</p>
							</div>
							<div class="mb25">
								<h4>■ 再開したい場合</h4>
								<p>アカウント情報は削除されますので、所有ポイントは0からになります。</p>
							</div>
							<form method="post" action="?tkn=748118f4b86aa4f00738fa8aa7fac5d0" name="frm">
								<input type="hidden" name="m" value="signout" />
								<p class="form_confirm_btn_info">
									<input type="checkbox" name="contract" id="contract" />
									<label for="contract">上記内容に同意</label>
								</p>
							</form>
							<p class="btn_return_confirm clearfix"><a href="regist.php?tkn=748118f4b86aa4f00738fa8aa7fac5d0" class="linkbtn4 alncenter">戻る</a> <a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">　　　退会申請へ　　　</a></p>
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
