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
<?php include_once dirname(__FILE__) . '/../common/header_contents.php';?>
<!--ヘッダ-->

<div id="headsearch">
<form action="" name="frmkeyword" method="get">
<input type="hidden" name="m" value="search_keyword"/>
<input type="hidden" name="category_large_id" id="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
<input type="hidden" name="region_id" id="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
<input type="text" name="keyword" placeholder="店舗名検索" value="<?php echo getParam($post, 'keyword'); ?>"/>
<a href="javascript:void(0);" onclick="document.frmkeyword.submit();">検索</a>
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

<div class="seachstorewrap">
<!--コンテンツ-->
<div class="contents">

<script type="text/javascript">
	function allNonCheckCategorySmall() {
<?php 
		echo "var small_ids = [" . implode(",", $category_small_ids) . "];";
?>
		for (i = 0; i < small_ids.length; i++) {
			$("#category_small_id_" + small_ids[i]).prop("checked", false);
		}
	}
	function allHideCategorySmall() {
<?php 
		echo "var midium_ids = [" . implode(",", $category_midium_ids) . "];";
?>
		for (i = 0; i < midium_ids.length; i++) {
			$("#category_small_list_id_" + midium_ids[i]).hide();
		}
	}
	function showCategorySmall(category_small_id) {
		allHideCategorySmall();
		$("#category_small_list_id_" + category_small_id).show();
	}
	function allInactiveCategoryMidium() {
<?php 
		echo "var midium_ids = [" . implode(",", $category_midium_ids) . "];";
?>
		for (i = 0; i < midium_ids.length; i++) {
			$("#category_midium_id_" + midium_ids[i]).removeClass("active");
		}
	}
	function activeCategoryMidium(category_midium_id) {
		allHideCategorySmall();
		allNonCheckCategorySmall();
		allInactiveCategoryMidium();
		$("#category_midium_id_" + category_midium_id).addClass("active");
		$("#category_midium_id").val(category_midium_id);
		$("#delivery").hide();
<?php 
		echo "var midium_ids_for_delivery = [" . implode(",", $category_midium_ids_for_delivery) . "];";
?>
		for (i = 0; i < midium_ids_for_delivery.length; i++) {
			if (midium_ids_for_delivery[i] == category_midium_id) {
				$("#delivery").show();
				break;
			}
		}
		showCategorySmall(category_midium_id);
	}
</script>

<h2><span class="icon-shop"></span>店舗を探す<?php echo getParam($error, 'category_midium_id'); ?></h2>

<div class="selectedterms">
<dl>
<dt>選んだ条件</dt>
<dd><a href="/index.php<?php echo $action_link; ?>" class="block alncenter">条件変更</a></dd>
<dd><?php echo $condition_category_large_name; ?></dd>
<dd><?php echo $condition_redion_name; ?></dd>
<dd><?php echo $condition_category_midium_name; ?></dd>
<?php foreach ($condition_category_small_names as $small_name) : ?>
<dd><?php echo $small_name; ?></dd>
<?php endforeach; ?>
</dl>
</div>

<?php // 中カテゴリー ?>
<div class="genrelist">
	<p class="fixHeight" style="width: 100%">
		<?php foreach (category_midium_for_customer(getParam($post, 'category_large_id'), getParam($post, 'region_id')) as $val_key => $val_name) : ?>
		<?php 	$active = (getParam($post, 'category_midium_id') == $val_key) ? ' class="active" ' : ''; ?>
		<a href="javascript:void(0);" id="category_midium_id_<?php echo $val_key; ?>" onclick="activeCategoryMidium(<?php echo $val_key; ?>);" <?php echo $active; ?>><?php echo $val_name; ?></a>
		<?php endforeach; ?>
	</p>
</div>

<?php // 小カテゴリー ?>
<div class="genreselect">
	<div class="select2btn">
	<div class="selectbtn">
		<?php echo getParam($error, 'category_small_ids'); ?>
		<ul class="clearfix fixHeight pl10">
		<?php foreach ($category_midium_ids as $category_midium_id) : ?>
			<?php $small_list_style = (getParam($post, 'category_midium_id') == $category_midium_id) ? ' style="display: inline;" ' : ' style="display: none;" '; ?>
			<span id="category_small_list_id_<?php echo $category_midium_id; ?>"<?php echo $small_list_style; ?>>
			<?php if(!$category_small_for_customer = category_small_for_customer($category_midium_id)):?>
				<p class="alncenter">現在登録されている店舗はありません。</p>
			<?php else:?>
			<?php foreach (category_small_for_customer($category_midium_id) as $val_key => $val_name) : ?>
			<li>
				<input type="checkbox" name="category_small_ids[]" value="<?php echo $val_key; ?>" id="category_small_id_<?php echo $val_key; ?>" <?php echo _check_checked($val_key, getParam($post, 'category_small_ids')); ?>>
				<label for="category_small_id_<?php echo $val_key; ?>"><?php echo $val_name; ?></label>
			</li>
			<?php endforeach; ?>
			<?php endif;?>
			</span>
		<?php endforeach; ?>
		</ul>
	</div>
	</div>
</div>

</div>

</form>

</div>
<!--/コンテンツ-->

<div class="searchlinkbtn">
	<?php $delivery_style = in_array(getParam($post, 'category_midium_id'), $category_midium_ids_for_delivery) ? ' style="display: inline;" ' : ' style="display: none;" '; ?>
	<p><a href="javascript:void(0);" onclick="document.frm.submit();"><span class="searchlinkicon"></span><span id="delivery"<?php echo $delivery_style; ?>>発</span>エリアから探す</a></p>
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
