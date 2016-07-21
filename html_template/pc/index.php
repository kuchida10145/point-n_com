<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国" />
<meta name="description" content="point.com（ポイントドットコム）では、風俗、キャバクラ、ホストのお店を検索できます。また、会員登録をして、ポイントとためいただくと、お得になります。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />

<!--<link rel="stylesheet" href="css/jquery.bxslider.css">-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/jquery.bxslider.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
$('.bxslider').bxSlider({
	auto: true,
	slideWidth: 640,
	minSlides: 3
});
});
</script>

<script type="text/javascript">
$(function() {
	$('.top_slider').bxSlider({
	auto: true,
	slideWidth: 1500,
	pager: false,
	hideControlOnEnd: true
});
});
</script>

</head>

<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/tpl/header.php");?>
<div class="main_img">
<ul class="top_slider">
  <li><img src="/html_template/pc/img/main_fuzoku_wi.jpg" alt="風俗"></li>
  <li><img src="/html_template/pc/img/main_fuzoku.jpg" alt="風俗"></li>
  <li><img src="/html_template/pc/img/main_chabakura.jpg" alt="キャバクラ"></li>
  <li><img src="/html_template/pc/img/main_hosuto.jpg" alt="ホスト"></li>
</ul>
</div>

<!--container-->
<div class="container">
<div class="mainbodybg01">

<!--mainvisual-->
<div class="mainvisual">
<h2 class="alncenter"><img src="/html_template/pc/img/title_point_h2.png" alt="他社風俗サイトの割引から、さらにポイント還元"/></h2>
<ul class="top_features">
	<li><img src="/html_template/pc/img/pic_point_wari.png" alt="ポイントで現金割引"/></li>
	<li><img src="/html_template/pc/img/pic_point_dokodemo.png" alt="全国どこでも現金として使用"/></li>
	<li><img src="/html_template/pc/img/pic_point_card.png" alt="ポイントカード不要"/></li>
</ul>
</div>
<!--/mainvisual-->

<!--mainbody-->
<form action="?m=search_select&tkn=<?php echo getGet('tkn');?>" name="frm" method="post">
<input type="hidden" name="m" value="search_select"/>
<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
<input type="hidden" name="category_small_ids" id="category_small_ids" value="<?php echo getParam($post, 'category_small_ids'); ?>"/>
<input type="hidden" name="area_key_ids" id="area_key_ids" value="<?php echo getParam($post, 'area_key_ids'); ?>"/>
<div class="mainbody">
<div class="contents">
  <div class="choice_genre">
  <h3><img src="/html_template/pc/img/title_top_genre.png" alt="まずは、ジャンルを選択"/><?php echo getParam($error, 'category_large_id'); ?></h3>
<ul class="choice_genre_ul">
	<?php foreach (category_large() as $val_key => $val_name) : ?>
    <li>
		<?php $class_name = ($val_key == getParam($post, 'category_large_id')) ? "on_genre" : ""; ?>
		<a href="#" name="<?php echo "category_large_" . $val_key; ?>" class="<?php echo $class_name; ?>" onclick="genreClick(this, <?php echo $val_key; ?>); return false;"><img class="on_genre_check" src="/html_template/pc/img/btn_on.png" alt="選択"/><img src="/html_template/pc/img/btn_top_<?php echo $val_name; ?>.png" alt="<?php echo $val_name; ?>"/>
    </li>
	<?php endforeach; ?>
</ul>
  </div>

<div class="choice_area">
	<h3><img src="/html_template/pc/img/title_top_area.png" alt="エリアを選択"/><?php echo getParam($error, 'region_id'); ?></h3>
	<ul class="choice_area_ul">
		<li><a href="#"><img class="on_genre_check" src="/html_template/pc/img/btn_on_1.png" alt="選択"/><img src="/html_template/pc/img/btn_genchi.png" alt="現地から探す"/></a></li>
		<?php foreach (region_master() as $val_key => $val_name) : ?>
    			<?php $region_class_name = ($val_key == getParam($post, 'region_id')) ? "on_area" : ""; ?>
    			<li><a href="#" name="<?php echo "region_" . $val_key; ?>" class="<?php echo $region_class_name; ?>" onclick="regionClick(this, <?php echo $val_key; ?>); return false;"><img class="on_genre_check" src="/html_template/pc/img/btn_on_1.png" alt="選択"/><img src="/html_template/pc/img/btn_<?php echo $val_name; ?>.png" alt="<?php echo $val_name; ?>"/></a></li>
    		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
	<input type="hidden" name="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
	<p><a href="javascript:void(0);" onclick="document.frm.submit();"><img src="/html_template/pc/img/btn_search.png" alt="検索"/></a></p>
</div>
</div><!--/.contents-->
</div><!--/mainbody-->
</form>

</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/tpl/footer.php");?>
<script type="text/javascript">
function genreClick(obj, genre_id){
	//チェック削除
	var del_class_obj = document.getElementsByClassName("on_genre");
	if(del_class_obj.length > 0) {
		del_class_obj[0].className = "";
	}
	//チェック追加
	obj.className = "on_genre";
	//ジャンルIDセット
	var elements = document.getElementsByName("category_large_id") ;
	elements[0].value = genre_id;
}

function regionClick(obj, region_id){
	//チェック削除
	var del_class_obj = document.getElementsByClassName("on_area");
	if(del_class_obj.length > 0) {
		del_class_obj[0].className = "";
	}
	//チェック追加
	obj.className = "on_area";
	//エリアIDセット
	var elements = document.getElementsByName("region_id") ;
	elements[0].value = region_id;
}

</script>
</body>
</html>
