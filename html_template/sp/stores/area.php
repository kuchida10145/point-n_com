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

<form action="<?php echo $action_link; ?>" name="frm" method="post">
<input type="hidden" name="m" value="search_select"/>
<input type="hidden" name="category_large_id" id="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
<input type="hidden" name="region_id" id="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
<input type="hidden" name="category_small_ids" id="category_small_ids" value="<?php echo getParam($post, 'category_small_ids'); ?>"/>

<div class="seachstorewrap">
<!--コンテンツ-->
<div class="contents">

<h2><span class="icon-shop"></span>店舗を探す</h2>

<div class="selectedterms">
<dl>
<dt>選んだ条件</dt>
<dd><a href="/stores/genre.php<?php echo $action_link; ?>" class="block alncenter">条件変更</a></dd>
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
<h2 style="margin:-10px -10px 0 -10px;">エリアを探す 
<?php 
	$err_messages = array();
	$err_messages[] = getParam($error, 'area_first');
	$err_messages[] = getParam($error, 'area_second');
	$err_messages[] = getParam($error, 'area_third'); 
	if (count($err_messages) > 0) {
		echo $err_messages[0];
	}
?>
</h2>

<div class="arealist">
<?php if (count($areas) > 0) : ?>
<dl>
<?php 
	$area_first_id = "";
	$area_second_id = "";
	$area_third_id = "";
	$is_first = true;
	foreach ($areas as $area) {
		// 第１エリア
		if ($area_first_id != $area['area_first_id']) {
			$area_first_id = $area['area_first_id'];
			if ($is_first) {
				$is_first = false;
				echo '</dd>' . "\n";
			}
			$area_first_value = $area_first_id;
			$area_first_tag = 'a' . $area_first_value;
			$checked = _check_checked($area_first_value, $post['area_first_ids']);
			echo '<dt>';
			echo '<label for="' . $area_first_tag . '">';
			echo '<input type="checkbox" name="area_first[]" value="' . $area_first_value . '" id="' . $area_first_tag. '" ' . $checked . ' />';
			echo $area['area_first_name'];
			echo '</label>';
			echo '</dt>' . "\n";
			echo '<dd>' . "\n";
		}
		// 第２エリア
		if ($area_second_id != $area['area_second_id']) {
			$area_second_id = $area['area_second_id'];
			$area_second_name = ($area_second_id != 0) ? $area['area_second_name'] : '−';
			$area_second_value = $area_first_id . '-' . $area_second_id;
			$area_second_tag = 'b' . $area_second_value;
			$checked = _check_checked($area_second_value, $post['area_second_ids']);
			echo '<label for="' . $area_second_tag . '" class="citytitle">';
			echo '<input type="checkbox" name="area_second[]" value="' . $area_second_value . '" id="' . $area_second_tag . '" ' . $checked . ' />';
			echo $area_second_name;
			echo '</label>' . "\n";
		}
		// 第３エリア
		if ($area_third_id != $area['area_third_id']) {
			$area_third_id = $area['area_third_id'];
			$area_third_name = ($area['area_third_id'] != 0) ? $area['area_third_name'] : '−';
			$area_third_value = $area_first_id . '-' . $area_second_id . '-' . $area_third_id;
			$area_third_tag = 'c' . $area_third_value;
			$checked = _check_checked($area_third_value, $post['area_key_ids']);
			echo '<label for="' . $area_third_tag . '">';
			echo '<input type="checkbox" name="area_third[]" value="' . $area_third_value . '" id="' . $area_third_tag . '" ' . $checked . ' />';
			echo $area_third_name . '(' . $area['cnt'] . ')';
			echo '</label>' . "\n";
		}
	}
?>
</dd>
</dl>
<?php else : ?>
<label>見つかりませんでした</label>
<?php endif; ?>
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

<!--スライド-->
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!--/スライド-->

</body>
</html>
