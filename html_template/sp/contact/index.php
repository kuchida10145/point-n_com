<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>お問い合わせ｜ポイント.com</title>
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
<h2>お問い合わせ</h2>
</div>
<!--コンテンツ-->
<div class="contents">
	<form action="/contact/?tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
		<input type="hidden" value="edit" name="m">
	<h3>都道府県</h3>
	<p>
	<select name="pref" id="select">
	<option value="">選択してください</option>
	<?php foreach(prefectures_master() as $pref_id => $pref_name):?>
	<option value="<?php echo $pref_id;?>" <?php echo _check_selected($pref_id, getParam($post, 'pref'));?>><?php echo $pref_name;?></option>
	<?php endforeach;?>
	</select>
		<?php echo getParam($error,'pref');?>
	</p>
	<h3>メールアドレス</h3>
	<p><input type="text" value="<?php echo getParam($post,'email');?>" name="email"><?php echo getParam($error,'email');?></p>

	</p>
	<h3>お問い合わせ内容</h3>
	<p><textarea name="detail" style="width:90%" cols="" rows="5"><?php echo getParam($post,'detail');?></textarea>
		<?php echo getParam($error,'detail');?>
	</p>


	<p><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a></p>
	</form>



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
<!-- /スライド-->


</body>
</html>
