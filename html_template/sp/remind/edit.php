<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>パスワード再設定｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="register">
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
<h2>パスワード再設定</h2>
</div>
<!--コンテンツ-->
<div class="contents">
<?php if ( NULL !== getParam($error, 'timeout') && '' != getParam($error, 'timeout') ) : ?>
	<p>
		<?php echo getParam($error, 'timeout'); ?>
	</p>
	<?php else : ?>

	<form method="post" action="" name="frm">
			<input type="hidden" name="m" value="edit" />
			<p>
				<label>
					新しいPW
					<input type="password" name="newPw" style="float:right;width:65%;" value="<?php echo getParam($post, 'newPw'); ?>" />
				</label>
				<?php echo getParam($error, 'newPw'); ?>
			</p>

			<p></p>

			<p>
				<label>
					新しいPW（再入力）
					<input type="password" name="newPwConfirm" style="float:right;width:65%;" value="" />
				</label>
				<?php echo getParam($error, 'newPwConfirm'); ?>
			</p>		

			<p></p>

			<p>パスワードは1ヶ月に一度、定期的に変更されることをお勧めします。<br />
			なお、お客様の過失によるパスワードの漏えいやそれに伴う損害は、当サイトでは一切保障しませんのであらかじめご了承ください。</p>
	</form>
<?php endif; ?>
<p><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">登録</a></p>

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
