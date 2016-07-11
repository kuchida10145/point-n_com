<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>キャッチメール　店舗選択画面｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="gps">
<?php include_once dirname(__FILE__).'/../common/analyticstracking.php';?>
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>

<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<?php include_once dirname(__FILE__).'/../common/header_search.php';?>
<!--ヘッダ-->

<!--メイン全体-->
<div id="mainbodywrap">
	<!--ページメイン部分-->
	<div id="mainbody" class="clearfix">
		<!--コンテンツ-->
		<div class="contents">
			<h2>返信があった店舗一覧</h2>
				<div class="shoplist">
				<?php if (isset($reply_shops_data) && !empty($reply_shops_data)) : ?>
					<?php foreach($reply_shops_data as $data) : ?>
					<div class="arrow_box" style="padding: 10px 10px 10px 10px;">
						<dl class="clearfix" style="padding: 10px 10px 10px 10px; border: none;">
							<dt>
								<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
									<img src="/files/images/<?php echo getParam($data, 'image1'); ?>" alt="" />
								</a>
							</dt>
							<dd>
								<?php $store_name = getParam($data, 'store_name'); ?>
								<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>">
									<strong><?php echo $store_name; ?></strong>
								</a><br />
								返信日時：<?php echo getParam($data, 'mail_regist_date'); ?>
								<br />
								住所：<?php echo getParam($data, 'address1') . getParam($data, 'address2'); ?>
								<br />
							</dd>
						</dl>
						<a class="pointtag" onclick="tellClick(<?php echo getParam($data,'telephone');?>);">TEL</a>
						<a class="eventtag" href="replyconfirm.php?id=<?php echo getParam($data,'catchmail_return_id');?>&tkn=<?php echo $tkn;?>">決定</a>
						<div class="box01">
								金額：<?php echo number_format(getParam($data, 'money')); ?>円<br>
								<br>
								アピール：<?php echo getParam($data, 'appeal'); ?>
						</div>
					</div>
					<?php endforeach;?>
				<?php else : ?>
				店舗からの返信がありません。
				<?php endif;?>
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
function tellClick(telephone) {
	var val = confirm("お店にPoint.comを見ましたと伝えて下さい。");
	if( val == true ) {
		window.location = "tel:"+telephone;
		return;
	}
}
</script>

</body>
</html>
