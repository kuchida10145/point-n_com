<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>パスワードを忘れた方　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗検索,パスワード" />
<meta name="description" content="パスワードを忘れた方は、こちらからアドレスを入力していただき再設定していただけます。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
		<h2>パスワードを忘れた方</h2>
			<form method="post" action="" name="frm">
				<input type="hidden" name="m" value="send" />
				<p><input type="text" name="email" id="email" style="width:50%;" value="<?php echo getParam($post, 'email');?>" placeholder="メールアドレスをご入力ください。"/>	</p>
				<?php echo getParam($error, 'email'); ?>
				<p>入力したメールアドレスへメールを送信します。<br />
				そこに記載のあるURLをクリックし、PW再設定画面にて2時間以内に新しいPWを再設定してください。</p>
				<p class="btn_next"><a href="javascript:void(0);" onclick="document.frm.submit();" class="">送信する</a></p>
			</form>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
