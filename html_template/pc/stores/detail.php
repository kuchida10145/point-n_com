<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/html_template/pc/css/slick.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/fixHeight.js" type="text/javascript"></script>
<script src="/html_template/pc/js/slick.js" type="text/javascript"></script>
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
						<p class="hear">店舗詳細</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02">
							<h3><?php echo getParam($store,'store_name');?>
								<?php if($favorite):?>
									<span class="fltright"><a href="?favorite=1&id=<?php echo getParam($store,'store_id');?>" class="linkbtn3">お気に入りから外す</a></span>
								<?php else:?>
									<span class="fltright"><a href="?favorite=0&id=<?php echo getParam($store,'store_id');?>" class="linkbtn3">お気に入りに追加</a></span>
								<?php endif;?>
							</h3>
							<?php if($coupon != NULL):?>
							<div class="store_detail_point">
			        			<h4>● ポイント情報</h4>
			        			<?php foreach($coupon as $id=>$data):?>
								<div class="box_point">
									<div class="box_point_info">
										<p class="course_point">
											<?php if(getParam($data,'point_kind') == 1):?>
												ポイント　
											<?php elseif(getParam($data,'point_kind') == 2):?>
												イベント　
											<?php endif;?>
											<span class="clrred"><?php echo number_format(getParam($data,'point'));?>PT</span>
										</p>
										<p>
											総額料金：<?php echo getParam($data,'coupon_minutes');?>分 <?php echo number_format(getParam($data,'coupon_price'));?>円
											<span>
												(通常料金：<?php echo getParam($data,'course_minutes');?>分 <?php echo number_format(getParam($data,'course_price'));?>円)
											</span>
										</p>
									</div>
									<h5><?php echo getParam($data,'coupon_name');?></h5>
									<div class="box_point_info">
										<h6 class="mb05">■ コース基本条件</h6>
										<?php echo getParam($coupon_esc[$id],'course_condition');?>
									</div>
									<div class="box_point_info">
										<h6 class="mb05">■ クーポンご利用条件</h6>
										<?php echo getParam($coupon_esc[$id],'use_condition');?>
									</div>
									<p class="stopr_linkbtn">
										<?php if(getParam($data,'point_kind') == 1):?>
											<a onclick="MoveCheck(<?php echo getParam($data,'coupon_id');?>);">「ポイント」<br />
											を獲得して予約する</a>
										<?php elseif(getParam($data,'point_kind') == 2):?>
											<a onclick="MoveCheck(<?php echo getParam($data,'coupon_id');?>);">「イベントポイント」<br />
											を獲得して予約する</a>
										<?php endif;?>
									</p>
								</div>
								<?php endforeach;?>
								<?php if(count($course)):?>
								<div class="box_point">
									<p>「ポイントのみ」利用しての予約が可能です。<br />
									1,000ポイントから利用が可能です。</p>
									<p class="stopr_linkbtn"><a href="../reservation/index.php?store_id=<?php echo getParam($store,'store_id');?>">「ポイントのみ」を利用して予約する</a></p>
								</div>
								<?php endif;?>
							</div><!--/.store_detail_point-->
							<?php endif;?>
							<div class="store_detail_news">
								<h4>● お店からのお知らせ<span class="fltright"><a href="news.php?sid=<?php echo getParam($store,'store_id');?>">一覧を見る</a></span></h4>
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
								<?php if($image):?>
								<div class="photoslide">
									<?php foreach ($image as $id=>$value):?>
									<div>
										<?php echo create_image_uploaded($value, $value, 'display');?>
									</div>
									<?php endforeach;?>
								</div>
								<?php endif;?>
								<h6><?php echo $store_introduction;?></h6>
							</div>
							<div class="store_detail_outline">
								<h4>● ショップデータ</h4>
								<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03">
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
							</div>
							<div class="store_detail_officialsite">
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
								<h4>● 店舗公式サイト</h4>
									<?php if ($is_plural) : ?>
									<div class="btn2block">
									<p class="newwindow">
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
							</div>
							<div class="store_detail_staff">
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
									<h4>● 女の子の詳細</h4>
									<?php if ($is_plural) : ?>
									<div class="btn2block">
									<p class="newwindow">
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
							</div>
						</div>
					</div>
				</div>
			</div><!--/.contents-->
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
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
</body>
</html>
