<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title;?>｜ポイント.com</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
	</head>
	<body id="register">
		<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>

		<div id="headsearch">
			<form action="<?php echo $action_link; ?>" name="frm" method="get">
				<input type="hidden" name="m" value="search_keyword"/>
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>"/>
				<input name="keyword" id="keyword" value="<?php echo getParam($post, 'keyword'); ?>" placeholder="店舗名検索" type="text">
				<a href="javascript:void(0);" onclick="document.frm.submit();">検索</a>
			</form>
		</div>

		<!--メイン全体-->
		<div id="mainbodywrap">
			<!--ページメイン部分-->
			<div id="mainbody" class="clearfix">
				<!--コンテンツ-->
				<div class="contents">
					<h2>お気に入り一覧 <?php echo number_format($total); ?>件中<span id="cur_shops"><?php echo number_format(count($list)); ?></span>件表示</h2>
					<div class="shoplist">
						<?php if(!$list): ?>
						データがありませんでした
						<?php else: ?>
							<?php foreach($list as $data):?>
							<dl class="clearfix">
								<dt>
									<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
									<img src="<?php echo getParam($data, 'image1'); ?>" alt="" />
									</a>
								</dt>
								<dd>
									<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
									<strong><?php echo getParam($data, 'store_name'); ?></strong>
									</a><br />
									<?php echo getParam($data,'category_small_name');?>/<?php echo getParam($data,'region_name');?>
									<?php if(getParam($data,'normal_point_status') == '1'):?>
										<strong class="pointtag">ポイント</strong>
										<strong class="clrred"><?php echo number_format(getParam($data,'normal_point'));?>PT</strong><br />
									<?php endif;?>
									<?php if(getParam($data,'event_point_status') == '1'):?>
										<strong class="eventtag">イベント</strong><strong class="clrgreen"><?php echo number_format(getParam($data,'event_point'));?>PT</strong><br />
									<?php endif;?>
									<?php echo getParam($data,'title');?><br />
									住所：<?php echo getParam($data,'address1');?><?php echo getParam($data,'address2');?><br />
								</dd>
							</dl>
							<?php endforeach;?>
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
	<!--スライド-->
	<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
	<!-- /スライド-->
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
					user_id  = $("#user_id").val();
					keyword  = $("#keyword").val();
					get_param  = "&user_id="+user_id;
					get_param += "&keyword="+keyword;
					$.ajax({
						type: "GET",
						url: "/favorite/index.php?m=next&next="+page_cnt+get_param,
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
							alert(errorThrown);
							page_cnt--;
						}
					});
		        }
		    });
		});
	</script>
	</body>
</html>