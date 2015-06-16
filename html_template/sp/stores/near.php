<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title ;?>｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
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
		<input name="keyword" placeholder="店舗名検索" type="text" /> 
		<a href="#">検索</a>
	</form>
</div>


<!--メイン全体-->
<div id="mainbodywrap">
	<!--ページメイン部分-->
	<div id="mainbody" class="clearfix">
		<!--コンテンツ-->
		<div class="seachstorewrap">
			<div class="contents" style="background-color:#fff;">

				<h2>
					<span class="icon-shop"></span><?php echo $page_title; ?>
				</h2>

				<?php if ( isset($gps['error']) && !empty($gps['error']) ) : ?>

					<!-- GPS関連エラー表示　-->

					<p class="clrred">
						<?php echo $gps['error']; ?>
					</p>

					<a href="<?php echo HTTP_HOST; ?>" class="linkbtn block alncenter">トップページ</a>

					<p></p>

				<?php else : ?>

					<p>
						現在地の精度はお使いの機種により異なりますのでご了承ください。
					</p>

					<p id="nearby-map" style="height:300px;"></p>

					<p class="alncenter">
						<br />
						現在地から<strong><?php echo $gps['km']; ?>km以内</strong>のお店を
					</p>

				<?php endif; ?>

					<!-- 近くのお店を探す機能-->
					<form method="post" name="gps" action="<?php echo HTTP_HOST; ?>/stores/near.php">
					    <input type="hidden" name="gps_lat" id="latitude" value=""/>
					    <input type="hidden" name="gps_long" id="longitude" value=""/>
					    <input type="hidden" name="gps_error" id="gps-error" value=""/>
					</form>
					<!-- /近くのお店を探す機能-->
					<a href="javascript:void(0);" onclick="document.gps.submit();" class="linkbtn block alncenter">再検索</a>

					<p></p>

					<?php if ( isset($list) && !empty($list) ): ?>

						<h3>検索結果一覧（全<?php echo $storesTotal; ?>件）</h3>
						<div class="shoplist">

							<?php foreach($list as $data) : ?>

								<!--1件-->	
								<dl class="clearfix">
									<a href="<?php echo HTTP_HOST; ?>/stores/detail.php?id=<?php echo $data['store_id']; ?>"></a>
									<dt>
										<?php if ( '' != getParam($data,'image1') ) : ?>
											<img src="../../../files/images/<?php echo getParam($data,'image1');?>" alt="" />
										<?php endif; ?>
									</dt>
									<dd>
										<strong>
											<?php echo getParam($data,'store_name');?>
										</strong><br />
										<?php echo getParam($data,'category_small_name');?>/<?php echo getParam($data,'region_name');?>

										<?php if(getParam($data,'normal_point_status') == '1'):?>
											<strong class="pointtag">
												ポイント
											</strong>
											<strong class="clrred">
												<?php echo number_format(getParam($data,'normal_point'));?>PT
											</strong>
										<?php endif;?>

										<?php if(getParam($data,'event_point_status') == '1'):?>
											<strong class="eventtag">
												イベント
											</strong>
											<strong class="clrgreen">
												<?php echo number_format(getParam($data,'event_point'));?>PT
											</strong>
										<?php endif;?>

										<br />
										<?php echo (NULL != getParam($data,'title')) ? getParam($data,'title') . '<br />' : ''; ?>
										住所：<?php echo getParam($data,'address1');?><?php echo getParam($data,'address2'); ?><br />
									</dd>
								</dl>
								<!--/1件-->

							<?php endforeach;?>
						</div><!-- /.shoplist -->

						<?php //echo $pager_html; ?>
					<?php endif;?>

			</div>
			<!--/コンテンツ-->

			<div id="footer">
				<address>
				Copyright 2015 POINT.COM All Rights Reserved
				</address>
			</div>
		</div><!-- /.seachstorewrap -->
	</div>
	<!--/ページメイン部分-->
</div>
<!--/メイン全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!--/スライド-->

<script type="text/javascript" src="<?php echo HTTP_HOST; ?>/js/pointcom.js"></script>
<script type="text/javascript">
//検索結果自動ロード
var ajaxUrl = "<?php echo $_SERVER['REQUEST_URI']; ?>";
$(function() {

	var page_cnt = 1; //現在のページ数

  $(window).scroll(function(ev) {

    var $window = $(ev.currentTarget),
    height = $window.height(),
    scrollTop = $window.scrollTop(),
    documentHeight = $(document).height();

    //スクロールがページの最後に着いたらAjaxで次のページの店舗をクエリー
    if (documentHeight === height + scrollTop) {

	    page_cnt++;
			$.ajax({
				type: "GET",
				url: ajaxUrl ,
				data: { 'page' : page_cnt },
				dataType: "json",
				success: function(stores){

					if ( !(null === stores) ) {

						var html = "";

						$.each(stores, function(i,store){

							var storeId = store.store_id;
							var image 	= store.image1;
							var name 		= store.store_name;
							var categ		= store.category_small_name;
							var region	= store.region_name;
							var title 	= store.title;
							var address1 	= store.address1;
							var address2 	= (null === store.address2) ? '' : store.address2;
							var normalPtStatus = store.normal_point_status;
							var normalPtValue  = store.normal_point;
							var eventPtStatus  = store.event_point_status;
							var eventPtValue   = store.event_point;

							html += '<dl class="clearfix">';
							html += '<a href="/stores/detail.php?id=' + storeId + '"></a>';
							html += '<dt>';
							if ( !(null === image) ) {
								html += '<img src="../../../files/images/' + image + '" alt="" />';
							}
							html += '</dt>';
							html += '<dd>';
							html += '<strong>' + name + '</strong><br />';
							html += categ + '/' + region;
							if ( "1" == normalPtStatus ) {
								html += ' <strong class="pointtag">ポイント</strong>';
								html += '<strong class="clrred">' + normalPtValue + 'PT</strong>';
							}
							if ( "1" == eventPtStatus ) {
								html += ' <strong class="eventtag">イベント</strong>';
								html += '<strong class="clrgreen">' + eventPtValue + 'PT</strong>';
							}						
							html += '<br />';
							if ( !(null === title) ) {
								html += title + '<br />';
							}
							html += '住所：' + address1 + address2 + '<br />';
							html += '</dd>';
							html += '</dl>';
						});

						$('.shoplist').append(html);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					page_cnt--;	
				}
			});
    }
  });
});

//Googleマップ表示するための情報
var gMap = {
    'mapContainer' : 'nearby-map',
    'locations'      : <?php echo isset($gps['nearbyStores']) ? $gps['nearbyStores'] : "''"; ?>,
    'currentLat'     : <?php echo isset($gps['latitude']) ? $gps['latitude'] : "''"; ?>,
    'currentLong'    : <?php echo isset($gps['longitude']) ? $gps['longitude'] : "''"; ?>,
};
google.maps.event.addDomListener(window, 'load', pointcom.initMap);
jQuery(document).ready(pointcom.init);
</script>

</body>
</html>
