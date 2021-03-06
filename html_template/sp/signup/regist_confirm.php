<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザー新規本登録 確認｜ポイント.com</title>
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
<h2>ユーザー新規本登録 確認</h2>
</div>
<!--コンテンツ-->
<div class="contents">

ユーザー新規本登録</h2>
</div>
<!--コンテンツ-->
<div class="contents">

<p>以下の内容で登録します。<br />
よろしければ「登録する」ボタンを押してください。</p>
<h3>ニックネーム(重複不可)</h3>
<form method="post" action="" name="frm">
<input type="hidden" name="m" value="thanks" />
<p><?php echo getParam($post, 'nickname');?></p>
<h3>メールアドレス(半角)</h3>
<p><?php echo $email; ?></p>
<h3> 生年月日</h3>
<p><?php echo getParam($post, 'birthday'); ?></p>
<h3> 性別</h3>
<p>
<?php echo getParam(user_gender(), getParam($post, 'gender'))?>
</p>
<h3>都道府県</h3>
<p>
<?php echo getParam(prefectures_master(), getParam($post, 'prefectures_id'));?>
</p>
<h3>パスワード(半角英数4～16文字)</h3>
<p><?php echo getParam($post, 'password'); ?></p>
<br />
</form>
<p class="alncenter"><a href="regist.php?tkn=<?php echo getGet('tkn'); ?>" class="linkbtn4 alncenter">戻る</a> <a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">　　　登録する　　　</a></p>

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
