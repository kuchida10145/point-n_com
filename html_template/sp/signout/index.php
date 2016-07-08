<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>退会申請｜ポイント.com</title>
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
<h2>退会申請</h2>
</div>
<!--コンテンツ-->
<div class="contents">
	<p>退会規約</p>
	<p>ポイントについて</p>
	<ol>
		<li>アカウントは抹消され、現在の所有ポイント、取得予定ポイントは全て無効になります。</li>
	</ol>
	<p>再開したい場合</p>
	<ol>
		<li>アカウント情報は削除されますので、所有ポイントは0からになります。</li>
	</ol>
	<form method="post" action="?tkn=<?php echo getGet('tkn');?>" name="frm">
	<input type="hidden" name="m" value="signout" />
	<p class="alncenter">
	<input type="checkbox" name="contract" id="contract" />
	<label for="contract">上記内容に同意</label>
	<?php echo getParam($error, 'contract'); ?>
	</p>
	</form>

<p class="alncenter"><a href="regist.php?tkn=<?php echo getGet('tkn'); ?>" class="linkbtn4 alncenter">戻る</a> <a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">　　　確認　　　</a></p>




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
