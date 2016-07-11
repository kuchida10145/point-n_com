<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
		<?php
			$area_first = area_first(getParam($store, 'category_large_id'), getParam($store, 'prefectures_id'), is_delivery(getParam($store, 'type_of_industry_id')));
			$area_third = area_third(getParam($store, 'area_second_id'));
			$category_midium = category_midium(getParam($store, 'category_large_id'), getParam($store, 'prefectures_id'), is_delivery(getParam($store, 'type_of_industry_id')));

			$title = getParam($area_first, getParam($store, "area_first_id"));
			$title .= " ".getParam($area_third, getParam($store, 'area_third_id'));
			$title .= " ".getParam($category_midium, getParam($store, 'category_midium_id'));
			$title .= " ".getParam($store,'store_name');
			echo $title;
		?> | ポイント.com
		</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />

		<meta name="viewport" content="width=device-width, maximum-scale=1.0">
		<!--フォントアイコンの設定-->
		<link rel="stylesheet" href="../css/fontello/css/fontello.css">
		<link rel="stylesheet" href="../css/fontello/css/animation.css">
		<!--[if IE 7]><link rel="stylesheet" href="/css/fontello/css/fontello-ie7.css"><![endif]-->
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans">
		<link href="../css/base.css" rel="stylesheet" type="text/css" />
		<link href="../css/layout.css" rel="stylesheet" type="text/css" />
		<link href="../css/print.css" rel="stylesheet" type="text/css" media="print" />

		<!--[if lte IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
		<![endif]-->

		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/obj.js"></script>
		<script type="text/javascript" src="../js/font-size.js"></script>
		<script type="text/javascript" src="../js/smooth.pack.js"></script>
		<script type="text/javascript" src="../js/acc.js"></script>

		<!-- スライドメニュ ー-->
		<script src="../js/sidr/jquery.sidr.min.js"></script>
		<link rel="stylesheet" href="../js/sidr/jquery.sidr.light.css">

		<!--カルーセル設定-->
		<link rel="stylesheet" href="../js/slick/slick.css">
		<script src="../js/slick/slick.js"></script>

		<script>
			 $(function() {
			    $('.photoslide').slick({
			dots: true,
			  infinite: false,
			  speed: 300 ,
			    slidesToShow: 3,
			  slidesToScroll: 3
			    });
			  });
 		</script>
	</head>
	<body id="register">
		<?php include_once dirname(__FILE__).'/../common/analyticstracking.php';?>
		<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>

		<div id="headsearch">
			<form action="" name="frm" method="get">
				<input name="keyword" value="<?php echo getGet('keyword');?>" placeholder="店舗名検索" type="text">
				<a href="javascript:void(0);" onclick="document.frm.submit();">検索</a>
			</form>
		</div>
		<!--メイン全体-->
		<div id="mainbodywrap">
			<!--ページメイン部分-->
			<div id="mainbody" class="clearfix">
				<!--コンテンツ-->
				<div class="contents">
					<h2>店舗詳細</h2>
					<?php if($favorite):?>
						<p class="alnright"><a href="?favorite=1&id=<?php echo getParam($store,'store_id');?>" class="linkbtn3"><span class="icon-star"></span>お気に入りから外す</a></p>
					<?php else:?>
						<p class="alnright"><a href="?favorite=0&id=<?php echo getParam($store,'store_id');?>" class="linkbtn3"><span class="icon-star"></span>お気に入りに追加</a></p>
					<?php endif;?>
					<p>
						<strong class="shopname"><?php echo getParam($store,'store_name');?></strong>
						<?php if(getParam($store,'new_arrival') == 1):?>
							<span class="clrred">新登場!</span>
						<?php endif;?>
					</p>
					<?php if($coupon != NULL):?>
					<div class="pointinfobox">
						<h3>ポイント情報</h3>
							<?php foreach($coupon as $id=>$data):?>
								<div class="box03">
									<p>
										<?php if(getParam($data,'point_kind') == 1):?>
											<strong class="pointtag">ポイント</strong>
										<?php elseif(getParam($data,'point_kind') == 2):?>
											<strong class="eventtag">イベント</strong>
										<?php endif;?>
										<strong class="clrred txt120"><?php echo number_format(getParam($data,'point'));?>PT</strong><br />
										<strong class="chargetag">総額料金</strong>
										<strong class="txt120">
											<?php echo getParam($data,'coupon_minutes');?>分 <?php echo number_format(getParam($data,'coupon_price'));?>円
										</strong>
											(通常料金：<?php echo getParam($data,'course_minutes');?>分 <?php echo number_format(getParam($data,'course_price'));?>円)
									</p>
									<p>
										<strong><?php echo getParam($data,'coupon_name');?></strong>
									</p>
									<h4>コース基本条件</h4>
									<p>
										<strong><?php echo getParam($coupon_esc[$id],'course_condition');?></strong>
									</p>
									<h4>クーポンご利用条件</h4>
									<p>
										<strong><?php echo getParam($coupon_esc[$id],'use_condition');?></strong>
									</p>
									<p>
										<?php if(getParam($data,'point_kind') == 1):?>
											<a class="linkbtn block alncenter" onclick="MoveCheck(<?php echo getParam($data,'coupon_id');?>);">「ポイント」<br />
											を獲得して予約する</a>
										<?php elseif(getParam($data,'point_kind') == 2):?>
											<a class="linkbtn block alncenter" onclick="MoveCheck(<?php echo getParam($data,'coupon_id');?>);">「イベントポイント」<br />
											を獲得して予約する</a>
										<?php endif;?>
									</p>
								</div>
							<?php endforeach;?>
							<?php if(count($course)):?>
								<div class="box03">
									<p>「ポイントのみ」利用しての予約が可能です。<br />
									1,000ポイントから利用が可能です。</p>
									<p><a href="../reservation/index.php?store_id=<?php echo getParam($store,'store_id');?>" class="linkbtn block alncenter">「ポイントのみ」<br />
									を利用して予約する</a></p>
								</div>
							<?php endif;?>
						</div>
					<?php endif;?>
					<h3><a href="news.php?sid=<?php echo getParam($store,'store_id');?>" class="newslistbtn">一覧をみる</a>お店からのお知らせ</h3>
					<div class="newslist">
						<?php if($notice):?>
						<ul>
							<li><a href="news_detail.php?id=<?php echo getParam($notice,'notice_id');?>"><?php echo getParam($notice,'display_date');?><br />
							<?php echo getParam($notice,'title');?></a></li>
							<li></li>
						</ul>
						<?php else:?>
						<ul>
							<li>　現在お知らせはありません</li>
						</ul>
						<?php endif;?>
					</div>
					<?php if($image):?>
						<div class="photoslide">
							<?php foreach ($image as $id=>$value):?>
								<div><?php echo create_image_uploaded($value, $value, 'display');?></div>
							<?php endforeach;?>
						</div>
					<?php endif;?>
					<p><?php echo $store_introduction;?></p>
					<h3>ショップデータ</h3>
					<table border="0" cellpadding="0" cellspacing="0" class="table01">
						<tr>
							<th>住所</th>
							<td><?php echo getParam($store,'address1');?><?php echo getParam($store,'address2');?><br />
							<a href="<?php echo "http://maps.google.com/maps?q=".getParam($store,'latitude').','.getParam($store,'longitude');?>" class="linkbtn" style="font-size: 90%;padding:5px 31px 5px 31px;">MAPを表示する</a></td>
						</tr>
						<tr>
							<th>営業時間</th>
							<td><?php echo getParam($store,'business_hours');?></td>
						</tr>
						<tr>
							<th>電話番号</th>
							<td>
								<p><button class="linkbtn block alncenter" style="font-size: 90%;padding:5px 5px 5px 5px;width: 150px;" onclick="tellCheck(<?php echo getParam($store,'telephone');?>);">お店に電話する<br />
								<span style="font-size: 1.4em; color: #000280;"><?php echo getParam($store,'telephone');?></span></button></p>
							</td>
						</tr>
						<tr>
							<th>休日</th>
							<td><?php echo getParam($store,'holiday');?></td>
						</tr>
					</table>
				<?php
					$official_urls = array();
					for ($i = 1; $i <= 4; $i++) {
						if (getParam($store, 'url_official' . $i)!= '') {
							$link_text = getParam($store, 'store_name') . '公式サイト：' . $i;
							$official_urls[] = array(
								'url'       => getParam($store, 'url_outside' . $i),
								'link_text' => $link_text
							);
						}
					}
					$is_plural = count($official_urls) > 1 ? true : false;
				?>
				<?php if (count($official_urls) > 0) :?>
					<h3>店舗公式サイト</h3>
					<?php if ($is_plural) : ?>
					<div class="btn2block">
					<p class="fixHeight clearfix">
					<?php else : ?>
					<p>
					<?php endif; ?>
				<?php endif; ?>
				<?php foreach ($official_urls as $official_url) : ?>
					<a href="<?php echo $official_url['url']; ?>" class="linkbtn5 block alncenter" target="_blank"><?php echo $official_url['link_text']; ?></a>
				<?php endforeach; ?>
				<?php if (count($official_urls) > 0) :?>
					</p>
					<?php if ($is_plural) : ?>
					</div>
					<?php endif; ?>
				<?php endif; ?>
				<?php
					$outside_urls = array();
					for ($i = 1; $i <= 5; $i++) {
						if (getParam($store, 'url_outside' . $i)!= '') {
							$link_text = getParam($store, 'link_text_outside' . $i);
							$link_text = ($link_text != '') ? $link_text : '外部サイトへ';
							$outside_urls[] = array(
								'url'       => getParam($store, 'url_outside' . $i),
								'link_text' => $link_text
							);
						}
					}
					$is_plural = count($outside_urls) > 1 ? true : false;
				?>
				<?php if (count($outside_urls) > 0) :?>
					<h3>女の子の詳細はこちら</h3>
					<?php if ($is_plural) : ?>
					<div class="btn2block">
					<p class="fixHeight clearfix">
					<?php else : ?>
					<p>
					<?php endif; ?>
				<?php endif; ?>
				<?php foreach ($outside_urls as $outside_url) : ?>
					<a href="<?php echo $outside_url['url']; ?>" class="linkbtn5 block alncenter" target="_blank"><?php echo $outside_url['link_text']; ?></a>
				<?php endforeach; ?>
				<?php if (count($outside_urls) > 0) :?>
					</p>
					<?php if ($is_plural) : ?>
					</div>
					<?php endif; ?>
				<?php endif; ?>

					<script type="text/javascript">
						function MoveCheck(id) {
							//page++;
							$.ajax({
								type: 'GET',
								url: '/stores/detail.php?m=pcheck&cid='+ id,
								dataType: 'json',
								success: function(res){
									if(res=='true'){
										var val = confirm("店舗へ予約電話はお済みですか?\n先にお電話で予約をして下さい。");
										if( val == true ) {
											window.location = "../reservation/index.php?coupon_id="+id;
										}
									} else {
										confirm("クーポンの発行上限に達したため、\n予約を行うことができません。");
									}
								},
								error: function(XMLHttpRequest, textStatus, errorThrown) {
									confirm(XMLHttpRequest);
								}
							});
						}

						function tellCheck(telephone) {
							var val = confirm("お店にPoint.comを見ましたと伝えて下さい。");
							if( val == true ) {
								window.location = "tel:"+telephone;
								return;
							}
						}
					</script>
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
	</body>
</html>