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
<form action="<?php echo $action_link; ?>" name="frmkeyword" method="get">
<input type="hidden" name="m" value="search_keyword"/>
<input type="hidden" name="category_large_id" id="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
<input type="hidden" name="region_id" id="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
<input type="hidden" name="category_small_ids" id="category_small_ids" value="<?php echo getParam($post, 'category_small_ids'); ?>"/>
<input type="hidden" name="area_key_ids" id="area_key_ids" value="<?php echo getParam($post, 'area_key_ids'); ?>"/>
<input type="hidden" name="sort" id="sort" value="<?php echo getParam($post, 'sort'); ?>"/>
<input type="text" name="keyword" id="keyword" placeholder="店舗名検索" value="<?php echo getParam($post, 'keyword'); ?>"/>
<a href="javascript:void(0);" onclick="document.frmkeyword.submit();">検索</a>
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
<dd><a href="<?php echo $back_link; ?><?php echo $get_back_param; ?>" class="block alncenter">条件変更</a></dd>
<dd><?php echo $condition_category_large_name; ?></dd>
<dd><?php echo $condition_redion_name; ?></dd>
<dd><?php echo $condition_category_midium_name; ?></dd>
<?php foreach ($condition_category_small_names as $small_name) : ?>
<dd><?php echo $small_name; ?></dd>
<?php endforeach; ?>
<?php foreach ($area_key_names as $area_name) : ?>
<dd><?php echo $area_name; ?></dd>
<?php endforeach; ?>
</dl>
</div>

<h2><a href="/news/index.php" class="newslistbtn">一覧をみる</a>今日のニュース</h2>
<?php if (count($news_list) <= 0) : ?>
	<p>現在お知らせはありません</p>
<?php else : ?>
	<div class="newslist">
	<ul>
		<li>
			<a href="/news/detail.php?id=<?php echo $news_list[0]['news_id']; ?>">
			<?php echo date('Y/m/d', strtotime($news_list[0]['display_date'])); ?><br />
			<?php echo $news_list[0]['title']; ?>
			</a>
		</li>
		<li></li>
	</ul>
	</div>
<?php endif; ?>

<h2>店舗一覧　<?php echo number_format($total); ?>件中<span id="cur_shops"><?php echo number_format(count($shop_list)); ?></span>件表示</h2>

<div class="searchsetting clearfix">
<dl>
<dd>
並べ替え：
<select id="search_sort_id" name="search_sort_id">
	<?php foreach (search_sortlist() as $val_key => $val_name) : ?>
	<option value="<?php echo $val_key; ?>" <?php echo _check_selected($val_key, getParam($post, 'sort'));?>><?php echo $val_name;?></option>
	<?php endforeach; ?>
</select>
</dd>
</dl>
</div>

<div class="shoplist">
<?php if (isset($shop_list) && !empty($shop_list)) : ?>
	<?php foreach($shop_list as $data) : ?>
	<dl class="clearfix">
		<dt>
			<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
			<img src="<?php echo getParam($data, 'image1'); ?>" alt="" />
			</a>
		</dt>
		<dd>
			<?php $store_name  = ($debug) ? (getParam($data, 'store_id') . ":") : ""; ?>
			<?php $store_name .= getParam($data, 'store_name'); ?>
			<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
			<strong><?php echo $store_name; ?></strong>
			</a><br />
			<?php echo getParam($data, 'category_small_name'); ?>/<?php echo getParam($data, 'region_name'); ?>
			<?php if (getParam($data, 'normal_point_status') == '1') : ?>
				<strong class="pointtag">
					ポイント
				</strong>
				<strong class="clrred">
					<?php echo number_format(getParam($data, 'normal_point')); ?>PT
				</strong><br />
			<?php endif;?>
			<?php if (getParam($data, 'event_point_status') == '1') : ?>
				<strong class="eventtag">
					イベント
				</strong>
				<strong class="clrgreen">
					<?php echo number_format(getParam($data, 'event_point')); ?>PT
				</strong><br />
			<?php endif;?>
			<?php echo getParam($data, 'title'); ?><br />
			住所：<?php echo getParam($data, 'address1'); ?><?php echo getParam($data, 'address2'); ?><br />
		</dd>
	</dl>
	<?php endforeach;?>
<?php else : ?>
該当する店舗が見つかりませんでした
<?php endif;?>
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

<script type="text/javascript">

$(function() {
	var page_cnt = 0;
    $(window).scroll(function(ev) {
        var $window = $(ev.currentTarget),
            height = $window.height(),
            scrollTop = $window.scrollTop(),
            documentHeight = $(document).height();
        if (documentHeight === height + scrollTop) {
			page_cnt++;
			category_large_id  = $("#category_large_id").val();
			region_id          = $("#region_id").val();
			category_midium_id = $("#category_midium_id").val();
			category_small_ids = $("#category_small_ids").val();
			area_key_ids       = $("#area_key_ids").val();
			keyword            = $("#keyword").val();
			sort               = $('#search_sort_id').val();
			get_param  = "&category_large_id="+category_large_id;
			get_param += "&region_id="+region_id;
			get_param += "&category_midium_id="+category_midium_id;
			get_param += "&category_small_ids="+category_small_ids;
			get_param += "&area_key_ids="+area_key_ids;
			get_param += "&keyword="+keyword;
			get_param += "&sort="+sort;
			
			$.ajax({
				type: "GET",
				url: "/stores/search.php?m=next&next="+page_cnt+get_param,
				dataType: "json",
				success: function (res) {
					if (res.result == 'false') {
						return;
					}
					var html = "";
					for (var i = 0; i < res.pages.length; i++) {
						var page                = res.pages[i];
						var store_id            = page.store_id;
						var store_name          = page.store_name;
						<?php if ($debug) : ?>
						store_name = store_id + ":" + page.store_name;
						<?php endif; ?>
						var image1              = page.image1;
						var category_small_name = page.category_small_name;
						var region_name         = page.region_name;
						var normal_point_status = page.normal_point_status;
						var normal_point        = page.normal_point;
						var event_point_status  = page.event_point_status;
						var event_point         = page.event_point;
						var title               = page.title;
						var address1            = page.address1;
						var address2            = page.address2;
						html += '<dl class="clearfix">';
						html += '  <dt><a href="/stores/detail.php?id=' + store_id + '"><img src="' + image1 + '" alt="" /></a></dt>';
						html += '  <dd><a href="/stores/detail.php?id=' + store_id + '"><strong>' + store_name + '</strong></a><br />';
						html += category_small_name + '/' + region_name;
						if (normal_point_status == '1') {
							html += '  <strong class="pointtag">ポイント</strong>';
							html += '  <strong class="clrred">' + normal_point + '</strong>';
						}
						if (event_point_status == '1') {
							html += '  <strong class="eventtag">イベント</strong>';
							html += '  <strong class="clrgreen">' + event_point + '</strong>';
						}
						html += title + '<br />';
						html += '  住所：' + address1 + address2 + '<br />';
						html += '  </dd>';
						html += '</dl>';
					}
					
					$('.shoplist').append(html);
					$("#cur_shops").html(res.cur_shops);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					page_cnt--;
				}
			});
        }
    });
    $('#search_sort_id').change(function() {
		category_large_id  = $('#category_large_id').val();
		region_id          = $('#region_id').val();
		category_midium_id = $('#category_midium_id').val();
		category_small_ids = $('#category_small_ids').val();
		area_key_ids       = $('#area_key_ids').val();
		keyword            = $('#keyword').val();
		sort               = $('#search_sort_id').val();
		get_param  = "&category_large_id="+category_large_id;
		get_param += "&region_id="+region_id;
		get_param += "&category_midium_id="+category_midium_id;
		get_param += "&category_small_ids="+category_small_ids;
		get_param += "&area_key_ids="+area_key_ids;
		get_param += "&keyword="+keyword;
		get_param += "&sort="+sort;
		$(location).attr("href", "/stores/search.php?m=search_sort" + get_param);
	});
});

</script>

</body>
</html>
