<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title;?>｜ポイント.com</title>
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
		<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
		<div id="headmenberinfo" class="clearfix">
			<p>会員No.<?php echo getParam($debug_account,'user_id');?> <?php echo getParam($debug_account,'nickname');?></p>
			<ul>
				<li>ポイント数 <strong><?php echo number_format(getParam($debug_account,'point'));?>PT</strong></li>
			</ul>
		</div>
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
						<p class="alnright"><a href="?favorite=1" class="linkbtn3"><span class="icon-star"></span>お気に入りから外す</a></p>
					<?php else:?>
						<p class="alnright"><a href="?favorite=0" class="linkbtn3"><span class="icon-star"></span>お気に入りに追加</a></p>
					<?php endif;?>
					<p>
						<strong class="shopname"><?php echo getParam($store,'store_name');?></strong>
						<?php if(getParam($store,'new_arrival') == 1):?>
							<span class="clrred">新登場!</span>
						<?php endif;?>
					</p>
					<div class="pointinfobox">
						<h3>ポイント情報</h3>
						<?php foreach($coupon as $data):?>
							<div class="box03">
								<p>
									<?php if(getParam($data,'point_kind') == 1):?>
										<strong class="pointtag">ポイント</strong>
									<?php elseif(getParam($data,'point_kind') == 2):?>
										<strong class="eventtag">イベント</strong>
									<?php endif;?>
									<strong class="clrred txt120"><?php echo getParam($data,'point');?>PT</strong><br />
									<strong class="chargetag">総額料金</strong>
									<strong class="txt120"><?php echo getParam($data,'minutes');?>分<?php echo getParam($data,'price');?>円</strong>
								</p>
								<p>
									<strong><?php echo getParam($data,'coupon_name');?></strong>
								</p>
								<h4>ご利用条件</h4>
								<p>
									<strong><?php echo getParam($data,'use_condition');?></strong>
								</p>
								<p>
									<?php if(getParam($data,'point_kind') == 1):?>
										<a class="linkbtn block alncenter" onclick="MoveCheck01(<?php echo getParam($data,'coupon_id');?>);">「通常ポイント」<br />
										を獲得して予約する</a>
									<?php elseif(getParam($data,'point_kind') == 2):?>
										<a class="linkbtn block alncenter" onclick="MoveCheck02(<?php echo getParam($data,'coupon_id');?>);">「イベントポイント」<br />
										を獲得して予約する</a>
									<?php endif;?>
								</p>
							</div>
						<?php endforeach;?>
						<div class="box03">
							<p>「ポイントのみ」利用しての予約が可能です。<br />
							1000ポイントから利用が可能です。</p>
							<p><a href="../reservation/indexP.php?store_id=<?php echo getParam($store,'store_id');?>" class="linkbtn block alncenter">「ポイントのみ」<br />
							を利用して予約する</a></p>
						</div>
					</div>
					<h3><a href="#" class="newslistbtn">一覧をみる</a>お店からのお知らせ</h3>
					<div class="newslist">
						<ul>
							<li><a href="#"><?php echo getParam($notice,'display_date');?><br />
							<?php echo getParam($notice,'title');?></a></li>
							<li></li>
						</ul>
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
						<a href="<?php echo "http://maps.google.com/maps?q=".getParam($store,'latitude').','.getParam($store,'longitude');?>" class="linkbtn2">MAPを表示する</a></td>
					</tr>
					<tr>
						<th>営業時間</th>
						<td><?php echo getParam($store,'business_hours');?></td>
					</tr>
					<tr>
						<th>電話番号</th>
						<td><?php echo getParam($store,'telephone');?></td>
					</tr>
					<tr>
						<th>休日</th>
						<td><?php echo getParam($store,'holiday');?></td>
					</tr>
				</table>
				<h3>女の子の詳細はこちら</h3>
				<p>
					<a href="http://www.cityheaven.net/"><img src="http://img.cityheaven.net/img/linkgist/234_60.gif" alt="風俗 デリヘル ヘルス｜ヘブンネット" width="234" height="60" border="0" style="width:49%;"></a>
					<a href="http://www.yoasobi.co.jp/" target="_blank"><img src="http://www.yoasobi.co.jp/pc/img/234x60_1.gif" border="0" alt="風俗 デリヘル｜夜遊びガイド" style="width:49%;" /></a>
					<script language="JavaScript" type="text/javascript"><!--
						function MoveCheck01(id) {
							var res = confirm("店舗へ予約電話はお済みですか?\n先にお電話で予約をして下さい。");
							if( res == true ) {
								window.location = "../reservation/index.php?coupon_id="+id;
							}
							else {
								window.location = "detail.php";
							}
						}
				// --></script>
					<script language="JavaScript" type="text/javascript"><!--
						function MoveCheck02(id) {
							var res = confirm("店舗へ予約電話はお済みですか?\n先にお電話で予約をして下さい。");
							if( res == true ) {
								window.location = "../reservation/index.php?coupon_id="+id;
							} else {
								window.location = "detail.php";
							}
						}
				// --></script>
				</p>
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