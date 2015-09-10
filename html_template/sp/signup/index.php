<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザー新規仮登録｜ポイント.com</title>
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
<h2>ユーザー新規仮登録</h2>
</div>
<!--コンテンツ-->
<div class="contents">
<p>ユーザー利用規約に同意頂き登録するメールアドレスを入力してください。折り返し仮登録完了メールが届きます。仮登録完了メールにあるURLにアクセスしますと、ユーザー登録画面へ進みます。<br /><br />
<span class="clrred">※ドメイン指定受信している方は</span><p><B>point-n.com</B></p><span class="clrred">を指定解除してください。</span></p>
<h3>メールアドレス(半角)</h3>
<form method="post" action="" name="frm">
<input type="hidden" name="m" value="signup" />
<p>
<input type="text" name="email" id="email" style="width:95%;" value="<?php echo getParam($post, 'email');?>" />
<?php echo getParam($error, 'email'); ?>
</p>

<p class="alncenter"><a href="kitei.php">ユーザー利用規約はこちら</a></p>

<p class="alncenter">
<input type="checkbox" name="contract" id="contract"<?php echo getParam($post, 'contract') != '' ? ' checked' : ''; ?> />
<label for="contract">ユーザー利用規約に同意</label>
<?php echo getParam($error, 'contract'); ?>
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
