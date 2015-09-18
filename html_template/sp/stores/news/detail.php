<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $notice_data['title'];?>｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../../common/header_meta.php';?>
<!--カルーセル設定-->
<link rel="stylesheet" href="/js/slick/slick.css">
<script src="/js/slick/slick.js"></script>
<script>
 $(function() {
    $('.photoslide').slick({
dots: true,
  infinite: false,
  speed: 300
    });
  });

</script>
</head>
<body id="register">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../../common/header_contents.php';?>
<!--ヘッダ-->
<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">
<!--コンテンツ-->
<div class="contents">
	<h2>お店からのお知らせ</h2>
	<h3><?php echo $notice_data['title'];?></h3>

	<?php if($images):?>
	<!-- start:スライド写真-->
	<div class="photoslide">
		<?php foreach($images as $img):?>
		<div>
		<p><img src="/files/images/<?php echo $img;?>" alt=""/></p>
		</div>
		<?php endforeach;?>
	</div>
	<!-- end:スライド写真 -->
	<?php endif;?>

	<p><?php echo $notice_data['body'];?></p>
	<p><a href="/stores/news.php?sid=<?php echo $notice_data['store_id'];?>" class="linkbtn block alncenter">一覧へ戻る</a></p>

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
<?php include_once dirname(__FILE__).'/../../common/slide_contents.php';?>
<!-- /スライド-->


</body>
</html>
