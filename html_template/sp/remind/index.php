<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>パスワードを忘れた方｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="register">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<!--ヘッダ-->
<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">

<div class="titlebox">
<h2>パスワードを忘れた方</h2>
</div>
<!--コンテンツ-->
<div class="contents">
<h3>メールアドレス(半角)</h3>
<form method="post" action="" name="frm">
<input type="hidden" name="m" value="send" />
<p>
<input type="text" name="email" id="email" style="width:95%;" value="<?php echo getParam($post, 'email');?>" />
<?php echo getParam($error, 'email'); ?>
</p>

<p>入力したメールアドレスへメールを送信します。<br />
そこに記載のあるURLをクリックし、PW再設定画面にて2時間以内に新しいPWを再設定してください。
</p>

<p><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">送信する</a></p>
</form>



</div>
<!--/コンテンツ-->

<div id="footer">
<address>
Copyright 2015 POINT.COM All Rights Reserved
</address>
</div>

</div>
<!--/ページメイン部分-->
</div>
<!--/メイン全体-->


</div>

<!--/全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!-- /スライド-->


</body>
</html>
