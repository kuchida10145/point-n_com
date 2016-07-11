<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="register">
<?php include_once dirname(__FILE__).'/../common/analyticstracking.php';?>
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>

<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<!--ヘッダ-->




<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">




<div class="titlebox">
<h2>今日のニュース</h2>
</div>

	<div class="contents">
<h3 style="margin-bottom: 0;">地域を選んでください</h3>
</div>
<div class="select4btn">
<div class="selectbtn">
<ul class="clearfix fixHeight" style="padding-left: 3%;">

    <?php foreach (region_master() as $val_key => $val_name) : ?>
    <li>
		<input type="radio" id="<?php echo "region_id_" . $val_key; ?>" name="region_id" value="<?php echo $val_key; ?>">
        <label for="<?php echo "region_id_" . $val_key; ?>" class="_area_link" data-id="<?php echo $val_key;?>"><?php echo $val_name; ?></label>
    </li>
    <?php endforeach; ?>
</ul>
</div>
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

<!--/全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!--/スライド-->
<script type="text/javascript" src="<?php echo HTTP_HOST; ?>/js/pointcom.js"></script>
<script type="text/javascript">
jQuery(document).ready(pointcom.init);
$(function(){
	$('._area_link').click(function(){
		var id = $(this).data('id');

		location.href='/news/index.php?region_id='+id;
	});
});
</script>
</body>
</html>
