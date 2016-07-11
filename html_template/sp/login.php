<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ログイン｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/common/header_meta.php';?>
</head>
<body id="register">
<?php include_once dirname(__FILE__).'/common/analyticstracking.php';?>
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/common/header_contents.php';?>
<!--ヘッダ-->
<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">



<div class="titlebox">
<h2>ログイン</h2>
</div>
<!--コンテンツ-->
<div class="contents">

<h3>会員の方</h3>
<?php echo $system_message;?>
<h4>メールアドレス(ユーザーID)</h4>
<form action="/login.php<?php echo $url_param;?>" method="post" name="frm">
<input type="hidden" value="login" name="m">
<p>
<input type="text" name="email" value="<?php echo getParam($post,'email');?>" style="width:95%;" />
</p>
<h4>パスワード</h4>
<p>
	<input type="password" name="password" value="<?php echo getParam($post,'password');?>" style="width:95%;" />
</p>
<p class="alncenter">
	<label>
		<input type="checkbox" type="checkbox" id="remember" value="1" name="auto_login" <?php if($auto_pw != ''):?>checked="checked"<?php endif;?> />
パスワードを保存する</label>
</p>
</form>

<p><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">ログインする</a></p>
<p class="alncenter"><a href="/remind/">パスワードを忘れた方はこちら</a></p>

<h3>新規会員の方</h3>
<p><a href="/signup/" class="linkbtn block alncenter">新規会員登録</a></p>





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
<?php include_once dirname(__FILE__).'/common/slide_contents.php';?>
<!-- /スライド-->


</body>
</html>
