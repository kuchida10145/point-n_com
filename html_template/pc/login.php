<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ログイン　｜　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗検索,ログイン" />
<meta name="description" content="ログインページです。IDとパスワードを入力してください。全国の風俗のお店を検索していただけます。ジャンルも細かく指定できますので、お気に入り店舗が見つかります。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/jquery.bxslider.min.js" type="text/javascript"></script>
</head>

<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/tpl/header.php");?>
<div id="login" class="mainbody">
	<div class="bg_opacity_white">
	<h3 class="alncenter"><img src="/html_template/pc/img/login_logo.png" alt="ポイントドットコム"/></h3>
	<?php echo $system_message;?>
		<form action="/login.php<?php echo $url_param;?>" method="post" name="frm">
		<input type="hidden" value="login" name="m">
			<dl>
				<dt>ログインID</dt>
				<dd>
					<input type="text" name="email" value="<?php echo getParam($post,'email');?>" />
				</dd>
				<dt>パスワード</dt>
				<dd>
					<input type="password" name="password" value="<?php echo getParam($post,'password');?>"/>
				</dd>
			</dl>
			<p>
				<label>
					<input type="checkbox" type="checkbox" id="remember" value="1" name="auto_login" <?php if($auto_pw != ''):?>checked="checked"<?php endif;?> />
					パスワードを保存する
				</label>
			</p>
			<p class="alncenter">
				<a href="javascript:void(0);" onclick="document.frm.submit();" class="btn_next"><img class="switch" src="/html_template/pc/img/btn_logn.png" alt="ログイン"/></a>
			</p>
		</form>
		<p>
			<a href="/remind/" class="btn_next">※パスワードをお忘れの方</a>
		</p>
	</div>
</div>
<?PHP include( dirname(__FILE__)."/tpl/footer.php");?>
</body>
</html>
