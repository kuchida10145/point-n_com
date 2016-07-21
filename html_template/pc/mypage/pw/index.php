<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>パスワード変更　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,変更,パスワード" />
<meta name="description" content="パスワードの変更ができます。" />
<?PHP include( dirname(__FILE__)."/../../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
			<h2>パスワード変更</h2>
			<form method="post" action="" name="frm">
			<input type="hidden" name="m" value="thanks" />
			<p class="pw_change clearfix mt20">
				<label>現在のPW<input type="password" name="currentPw" value="" /></label>
				<?php echo getParam($error, 'currentPw'); ?>
			</p>
			<p class="pw_change clearfix">
				<label>新しいPW<input type="password" name="newPw" value="<?php echo getParam($post, 'newPw'); ?>" /></label>
				<?php echo getParam($error, 'newPw'); ?>
			</p>
			<p class="pw_change clearfix">
				<label>新しいPW（再入力<input type="password" name="newPwConfirm" value="" /></label>
				<?php echo getParam($error, 'newPwConfirm'); ?>
			</p>
			<p>パスワードは1ヶ月に一度、定期的に変更されることをお勧めします。なお、お客様の過失によるパスワードの漏えいやそれに伴う損害は、当サイトでは一切保障しませんのであらかじめご了承ください。</p>
			<p class="btn_next"><a href="javascript:void(0);" onclick="document.frm.submit();">変更する</a></p>
			</form>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../../tpl/footer.php");?>
</body>
</html>
