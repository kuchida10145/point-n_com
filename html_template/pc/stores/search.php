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
?> 店舗一覧 | ポイント.com
</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
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
			<div class="contents clearfix">
				<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="done">ジャンルと地域を選ぶ</p>
						<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
						<p>ジャンル詳細を選ぶ</p>
						<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
						<p  class="hear">地域詳細を選ぶ</p>
						<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
						<p class="will">店舗一覧</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_01">
							<h3 class="clearfix">選んだ条件<span class="fltright"><a href="#">条件変更</a></span></h3>
							<ul class="clearfix">
								<li class="page01_select_girl"><?php echo $condition_category_large_name; ?></li>
								<li class="page01_select_area"><?php echo $condition_redion_name; ?></li>
								<li class="page01_select_area"><?php echo $condition_category_midium_name; ?></li>
								<?php foreach ($condition_category_small_names as $small_name) : ?>
								<li class="page01_select_area"><?php echo $small_name; ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="shiborikomi_genre_02">
							<h3>店舗一覧　(<?php echo number_format($total); ?>件中<?php echo number_format(count($shop_list)); ?>件表示)</h3>
							<div class="narabekae clearfix">
								<p>◇ 並べかえ</p>
								<select id="search_sort_id" name="search_sort_id">
									<?php foreach (search_sortlist() as $val_key => $val_name) : ?>
									<option value="<?php echo $val_key; ?>" <?php echo _check_selected($val_key, getParam($post, 'sort'));?>><?php echo $val_name;?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<table class="shiborikomi_shop_01">
								<tbody>
								<?php if (isset($shop_list) && !empty($shop_list)) : ?>
									<?php if ($debug) : ?>
										<span><?php echo $sql; ?></span>
									<?php endif; ?>
									<?php foreach($shop_list as $data) : ?>
									<tr>
										<?php $store_name  = ($debug) ? (getParam($data, 'store_id') . ":") : ""; ?>
										<?php $store_name .= getParam($data, 'store_name'); ?>
										<th scope="row">
											<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>"><?php echo $store_name; ?><br>
												<img src="/html_template/pc/stores/img/pic_stoar.jpg" alt=""/>
											</a>
										</th>
										<td>
											<ul>
												<li><?php echo getParam($data, 'category_small_name'); ?>/<?php echo getParam($data, 'region_name'); ?></li>
												<?php if (getParam($data, 'normal_point_status') == '1' && is_point_selected_sort(getParam($post, 'sort'))) : ?>
													<li><span class="pint_list">ポイント：<?php echo number_format(getParam($data, 'normal_point')); ?>PT</span></li>
												<?php endif;?>
												<?php if (getParam($data, 'event_point_status') == '1' && is_event_selected_sort(getParam($post, 'sort'))) : ?>
													<li><span class="pint_list">イベント：<?php echo number_format(getParam($data, 'event_point')); ?>PT</span></li>
												<?php endif;?>
												<li class="txt11">
													<?php
														echo (is_delivery(getParam($data, 'type_of_industry_id'))) ? '発エリア：' : '店舗住所：';
														echo getParam($data, 'address1') . getParam($data, 'address2');
													?>
												</li>
											</ul>
										</td>
									</tr>
									<?php endforeach;?>
								<?php else : ?>
									<tr>
										該当する店舗が見つかりませんでした
									</tr>
								<?php endif;?>
								</tbody>
							</table>
						</div>
				    </div>
				</div>
			</div>
		</div><!--/.contents-->
	</div><!--/mainbody-->
</div><!--/.mainbodybg01-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
<script type="text/javascript">
$(function() {
	var page_cnt = 0;
    $(window).scroll(function(ev) {
        var $window = $(ev.currentTarget),
            height = $window.height(),
            scrollTop = $window.scrollTop(),
            documentHeight = $(document).height() - 150;
        if (documentHeight < height + scrollTop) {
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
					var is_point_selected_sort = res.is_point_selected_sort;
					var is_event_selected_sort = res.is_event_selected_sort;
					var html = "";
					<?php if ($debug) : ?>
					html += "<span>" + res.sql + "</span>";
					<?php endif; ?>
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
						if (normal_point_status == '1' && is_point_selected_sort) {
							html += '  <br />';
							html += '  <strong class="pointtag">ポイント</strong>';
							html += '  <strong class="clrred">' + normal_point + '</strong>';
						}
						if (event_point_status == '1' && is_event_selected_sort) {
							html += '  <br />';
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
