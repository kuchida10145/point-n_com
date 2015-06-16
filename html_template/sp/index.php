<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/common/header_meta.php';?>
</head>
<body id="index">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>

<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/common/header_contents.php';?>
<!--ヘッダ-->

<div id="headsearch">
<form action="" name="frmkeyword" method="get">
<input type="hidden" name="m" value="search_keyword"/>
<input type="text" name="keyword" placeholder="店舗名検索" value="<?php echo getParam($post, 'keyword'); ?>"/>
<a href="javascript:void(0);" onclick="document.frmkeyword.submit();">検索</a>
</form>

</div>

<div id="demo"></div>


<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">

<form action="?m=search_select&tkn=<?php echo getGet('tkn');?>" name="frm" method="post">
<input type="hidden" name="m" value="search_select"/>
<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
<input type="hidden" name="category_small_ids" id="category_small_ids" value="<?php echo getParam($post, 'category_small_ids'); ?>"/>
<input type="hidden" name="area_key_ids" id="area_key_ids" value="<?php echo getParam($post, 'area_key_ids'); ?>"/>


<div class="genreselect">
<h2><span class="icon-shop"></span>ジャンルを選ぶ<?php echo getParam($error, 'category_large_id'); ?></h2>
<div class="selectbtn">
<ul class="clearfix">
	<?php foreach (category_large() as $val_key => $val_name) : ?>
    <li style="width:33%;">
            <input type="radio" id="<?php echo "category_large_id_" . $val_key; ?>" name="category_large_id" value="<?php echo $val_key; ?>" <?php echo _check_checked($val_key, getParam($post, 'category_large_id'));?>/>
            <label for="<?php echo "category_large_id_" . $val_key; ?>"><?php echo $val_name; ?></label>
    </li>
	<?php endforeach; ?>
</ul>
</div>
</div>

<h2><span class="icon-area"></span>地域を選ぶ	<?php echo getParam($error, 'region_id'); ?></h2>
<div class="select4btn">
<div class="selectbtn">
<ul class="clearfix fixHeight">
	<li class="gpsbtn">
      <label for="a"><a href="javascript:void(0);" onclick="document.gps.submit();">現在地<br />から探す</a></label>
    </li>
    <?php foreach (region_master() as $val_key => $val_name) : ?>
    <li>
            <input type="radio" id="<?php echo "region_id_" . $val_key; ?>" name="region_id" value="<?php echo $val_key; ?>" <?php echo _check_checked($val_key, getParam($post, 'region_id'));?>>
            <label for="<?php echo "region_id_" . $val_key; ?>"><?php echo $val_name; ?></label>
    </li>
    <?php endforeach; ?>
</ul>
</div>
</div>

<div class="searchlinkbtn">
	<p><a href="javascript:void(0);" onclick="document.frm.submit();"><span class="searchlinkicon"></span>「店舗」を検索</a></p>
</div>
</form>

<!-- 近くのお店を探す機能-->
<form method="post" name="gps" action="<?php echo HTTP_HOST; ?>/stores/near.php">
    <input type="hidden" name="gps_lat" id="latitude" value=""/>
    <input type="hidden" name="gps_long" id="longitude" value=""/>
    <input type="hidden" name="gps_error" id="gps-error" value=""/>
</form>
<!-- /近くのお店を探す機能-->

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

<!--/全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/common/slide_contents.php';?>
<!--/スライド-->
<script type="text/javascript" src="<?php echo HTTP_HOST; ?>/js/pointcom.js"></script>
<script type="text/javascript">
jQuery(document).ready(pointcom.init);
</script>
</body>
</html>
