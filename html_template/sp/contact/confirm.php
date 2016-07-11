<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>お問い合わせ 確認｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="register">
<?php include_once dirname(__FILE__).'/../common/analyticstracking.php';?>
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
<h2>お問い合わせ　確認</h2>
</div>
<!--コンテンツ-->
<div class="contents">
	<form action="/contact/confirm.php?tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
		<input type="hidden" value="confirm" name="m">
	<h3>都道府県</h3>
	<p>
	<?php echo getParam($post, 'pref');?>
	</p>
	<h3>メールアドレス</h3>
	<p>
	<?php echo getParam($post, 'email');?>
	</p>
	<h3>お問い合わせ内容</h3>
	<p>
	<?php echo getParam($post, 'detail');?>
	</p>


	<p class="alncenter"><a href="/contact/?tkn=<?php echo getGet('tkn'); ?>" class="linkbtn4 alncenter">戻る</a> <a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">　　　送信する　　　</a></p>
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
