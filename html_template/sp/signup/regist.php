<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザー新規本登録｜ポイント.com</title>
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
<h2>ユーザー新規本登録</h2>
</div>
<!--コンテンツ-->
<div class="contents">

<p>すべての内容を入力してください。<br />
一度入力された情報は変更できません。</p>
<h3>ニックネーム(重複不可)</h3>
<p>
<input type="text" name="textfield" id="textfield" style="width:95%;" />
</p>
<h3>メールアドレス(半角)</h3>
<p> ●●●@▲▲▲▲.jp</p>
<h3> 生年月日</h3>
<p>
<input name="textfield2" type="text" id="textfield2" size="4" />
年
<input name="textfield3" type="text" id="textfield3" size="2" /> 
月
<input name="textfield4" type="text" id="textfield4" size="2" />
日</p>
<h3> 性別</h3>
<p>
<select name="select" id="select">
<option>選択してください</option>
<option>男性</option>
<option>女性</option>
</select>
</p>
<h3>都道府県</h3>
<p>
<select name="select2" id="select2">
<option>選択してください</option>

</select>
</p>
<h3>パスワード(半角英数4～16文字)</h3>
<p>
<input type="text" name="textfield5" id="textfield5" style="width:95%;" />
</p>

<p><a href="new_check.html" class="linkbtn block alncenter">確認画面へ</a></p>

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
