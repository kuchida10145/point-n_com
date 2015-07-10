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
	<input name="keyword" placeholder="店舗名で抽出" type="text" id="near-name" value="<?php echo getGet('keyword'); ?>" /> 
	<a id="near-search" href="<?php echo $_SERVER['REQUEST_URI']; ?>">検索</a>
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
										<?php 
											echo (is_delivery(getParam($data, 'type_of_industry_id'))) ? '発エリア：' : '店舗住所：';
											echo getParam($data, 'address1') . getParam($data, 'address2');
										?>
										<br />
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
//Googleマップ表示するための情報
var gMap = {
    'mapContainer' : 'nearby-map',
    'locations'      : <?php echo isset($gps['nearbyStores']) ? $gps['nearbyStores'] : "''"; ?>,
    'currentLat'     : <?php echo isset($gps['latitude']) ? $gps['latitude'] : "''"; ?>,
    'currentLong'    : <?php echo isset($gps['longitude']) ? $gps['longitude'] : "''"; ?>,
};
google.maps.event.addDomListener(window, 'load', pointcom.initMap);

//無限スクロールなどこのページで使うJS
jQuery(document).ready(pointcom.initStoresNearPage);
</script>

</body>
</html>
