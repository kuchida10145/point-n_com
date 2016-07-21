<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>
<?php
	$title = $condition_category_large_name;
	$title .= " ".$condition_redion_name;
	foreach ($condition_category_small_names as $small_name) {
		$title .= " ".$small_name;
	}
	echo $title;
?> ジャンル選択 | ポイント.com
</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗検索" />
<meta name="description" content="全国の風俗のお店を検索していただけます。ジャンルも細かく指定できますので、お気に入り店舗が見つかります。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />

<!--<link rel="stylesheet" href="css/jquery.bxslider.css">-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/fixHeight.js" type="text/javascript"></script>


</head>

<body id="genre" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div class="container">
<div class="mainbodybg01">

<!--mainbody-->

<div class="mainbody">

<form action="<?php echo $action_link; ?>" name="frm" method="post">
<input type="hidden" name="m" value="search_select"/>
<input type="hidden" name="category_large_id" id="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
<input type="hidden" name="region_id" id="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
<div class="contents clearfix">

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

<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>

<div class="shiborikomi_page02">
	<div class="shiborikomi_step">
		<p class="done">ジャンルと地域を選ぶ</p>
		<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
		<p class="hear">ジャンル詳細を選ぶ</p>
		<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
		<p class="will">地域詳細を選ぶ</p>
		<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
		<p class="will">店舗一覧</p>
	</div>
	<div class="shiborikomi_genre">
		<div class="shiborikomi_genre_01">
			<h3 class="clearfix">選んだ条件<span class="fltright"><a href="#">条件変更</a></span></h3>
			<ul class="clearfix">
				<li class="page01_select_girl"><?php echo $condition_category_large_name; ?></li>
				<li class="page01_select_area"><?php echo $condition_redion_name; ?></li>
			</ul>
		</div>
		<div class="shiborikomi_genre_02">
			<h3>ジャンル詳細を選ぶ</h3>
			<style>
			</style>
			<div class="genrelist mb25">
				<p class="fixHeight" style="width: 100%">
					<?php foreach (category_midium_for_front(getParam($post, 'category_large_id'), getParam($post, 'region_id')) as $val_key => $val_name) : ?>
						<?php 	$active = (getParam($post, 'category_midium_id') == $val_key) ? ' class="active" ' : ''; ?>
						<a href="javascript:void(0);" id="category_midium_id_<?php echo $val_key; ?>" onclick="activeCategoryMidium(<?php echo $val_key; ?>);" <?php echo $active; ?>><?php echo $val_name; ?></a>
					<?php endforeach; ?>
				</p>
			</div>
			<div class="genreselect">
				<div class="selectbtn mb25">
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
			<?php $delivery_style = in_array(getParam($post, 'category_midium_id'), $category_midium_ids_for_delivery) ? ' style="display: inline;" ' : ' style="display: none;" '; ?>
			<p class="clearfix alncenter">
				<a href="javascript:void(0);" onclick="document.frm.submit();"><img class="switch" src="/html_template/pc/stores/img/btn_next_stor.png" alt="次へ進む"/></a>
			</p>
		</div>
	</div>
</div>
</div><!--/.contents-->
</form>
</div><!--/mainbody-->
</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>

</body>
</html>
