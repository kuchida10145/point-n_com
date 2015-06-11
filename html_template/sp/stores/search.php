<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="gps">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>

<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<!--ヘッダ-->

<div id="headsearch">
<form action="" name="" method="get">
<input type="hidden" name="m" value="search_keyword"/>
<input name="keyword" placeholder="店舗名検索" type="text"> 
<a href="#">検索</a>
</form>

</div>


<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">
<!--コンテンツ-->
<div class="contents">
<div class="selectedterms">
<dl>
<dt>選んだ条件</dt>
<dd><a href="#" class="block alncenter">条件変更</a></dd>
<dd><?php echo $condition_category_large_name; ?></dd>
<dd><?php echo $condition_redion_name; ?></dd>
<dd><?php echo $condition_category_midium_name; ?></dd>
<?php foreach ($condition_category_small_names as $small_name) : ?>
<dd><?php echo $small_name; ?></dd>
<?php endforeach; ?>
</dl>
</div>

<h2><a href="/news/index.php" class="newslistbtn">一覧をみる</a>今日のニュース</h2>
<div class="newslist">
<ul>
<li>
<a href="/news/detail.php?id=">2015/1/1　16:15<br />お宝ザクザク！無料で遊べちゃう！</a>
</li>
<li></li>
</ul>
</div>

<h2>店舗一覧</h2>

<div class="searchsetting clearfix">
<dl>
<dd>
並べ替え：
<select>
<option>通常ポイントが高い順</option>
<option>イベントポイントが高い順</option>
<option>通常ポイント総額料金が高い順</option>
<option>通常ポイント総額料金が低い順</option>
<option>イベントポイント総額料金が高い順</option>
<option>イベントポイント総額料金が低い順</option>
<option>新着店舗</option>
</select>
</dd>
</dl>
</div>

<div class="shoplist">
該当する店舗が見つかりませんでした
</div>

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
<!--/スライド-->

</body>
</html>
