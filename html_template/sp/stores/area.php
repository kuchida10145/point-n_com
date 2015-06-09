<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<meta name="viewport" content="width=device-width, maximum-scale=1.0">
<!--フォントアイコンの設定-->
<link rel="stylesheet" href="../css/fontello/css/fontello.css">
<link rel="stylesheet" href="../css/fontello/css/animation.css">
<!--[if IE 7]><link rel="stylesheet" href="/css/fontello/css/fontello-ie7.css"><![endif]-->
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans">

<link href="../css/base.css" rel="stylesheet" type="text/css" />
<link href="../css/layout.css" rel="stylesheet" type="text/css" />
<link href="../css/print.css" rel="stylesheet" type="text/css" media="print" />

<!--[if lte IE 9]>
<script src="/js/html5.js"></script>
<script src="/js/css3-mediaqueries.js"></script>
<![endif]-->


<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/obj.js"></script>
<script type="text/javascript" src="../js/font-size.js"></script>
<script type="text/javascript" src="../js/smooth.pack.js"></script>
<script type="text/javascript" src="../js/acc.js"></script>

<!--スライドメニュー-->
<script src="../js/sidr/jquery.sidr.min.js"></script>
<link rel="stylesheet" href="../js/sidr/jquery.sidr.light.css">



</head>
<body id="gps">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<div id="header" class="clearfix">
<h1><a href="../index.html">ポイント.com</a></h1>


<!--ヘッドメニュー-->
<div id="headmenu">
<ul>
<li id="hm1"><a href="/sample/store/favorite.html" class="accordion_search"><span class="icon-star"></span>お気に入り</a></li>
<li id="hm2"><a href="/sample/member/login.html" class="accordion_btn"><span class="icon-lock-filled"></span>ログイン</a></li>
<li id="hm2"><a class="right-menu" href="#right-menu"><span class="icon-menu"></span>メニュー</a></li>
</ul>
<hr class="none" />
</div>
<!--/ヘッドメニュー-->

</div>
<!--ヘッダ-->

<div id="headmenberinfo" class="clearfix">
<p>会員No.1234567 ニックネーム会員さん</p>
<ul>
<li>ポイント数 <strong>10,000PT</strong></li>
</ul>
</div>

<div id="headsearch">
<form action="" name="" method="get">
<input name="keyword" placeholder="店舗名検索" type="text"> 
<a href="#">検索</a>
</form>

</div>


<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">

<form action="<?php echo $action_link; ?>" name="frm" method="post">
<input type="hidden" name="m" value="search_select"/>
<input type="hidden" name="category_large_id" id="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
<input type="hidden" name="region_id" id="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
<input type="hidden" name="category_small_ids" id="category_small_ids" value="<?php echo implode(",", getParam($post, 'category_small_ids')); ?>"/>

<div class="seachstorewrap">
<!--コンテンツ-->
<div class="contents">

<h2><span class="icon-shop"></span>店舗を探す</h2>

<div class="selectedterms">
<dl>
<dt>選んだ条件</dt>
<dd><a href="/<?php echo $action_link; ?>" class="block alncenter">条件変更</a></dd>
<dd><?php echo $condition_category_large_name; ?></dd>
<dd><?php echo $condition_redion_name; ?></dd>
<dd><?php echo $condition_category_midium_name; ?></dd>
<?php foreach ($condition_category_small_names as $small_name) : ?>
<dd><?php echo $small_name; ?></dd>
<?php endforeach; ?>
</dl>
</div>
</div>
</div>
<!--コンテンツ-->

<div class="contents">
<h2 style="margin:-10px -10px 0 -10px;">エリアを探す</h2>

<div class="arealist">
<dl>
<dt>
<label for="a"><input type="checkbox" name="a" value="" id="a" />
愛知県</label></dt>
<dd>
<label for="a2" class="citytitle"><input type="checkbox" name="a2" value="" id="a2" />
名古屋市</label>

<label for="a3"><input type="checkbox" name="a3" value="" id="a3" />
名古屋駅(20)</label>

<label for="a4"><input type="checkbox" name="a4" value="" id="a4" />
納屋橋(20)</label></dd>
</dl>
</div>

</div>

</form>

</div>
<!--/コンテンツ-->

<div class="searchlinkbtn">
	<p><a href="javascript:void(0);" onclick="document.frm.submit();"><span class="searchlinkicon"></span>店舗をみる</a></p>
</div>


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


<div id="sidr-right">
<!-- Your content -->
<a class="right-menu sideclose" href="#right-menu">× 閉じる</a>

<ul>
<li><a href="../member/re_new_pw.html">パスワード変更</a></li>
<li><a href="../info/point_list.html">ポイント利用履歴</a></li>
<li><a href="../info/oshirase_list.html">POINT.COMからのお知らせ</a></li>
<li><a href="../info/site.html">本サイトとは</a></li>
<li><a href="../info/guide.html">利用ガイド</a></li>
<li><a href="../info/question.html">よくある質問</a></li>
<li><a href="../info/inquire.html">お問い合わせ</a></li>
<li><a href="../info/storeadmin.html">店舗運営の方へ</a></li>
<li><a href="../info/gaiyou.html">会社概要</a></li>
<li><a href="../info/kitei.html">ご利用規定</a></li>
<li><a href="../info/taikai.html">退会申請</a></li>
</ul>

</div>


</body>
</html>
