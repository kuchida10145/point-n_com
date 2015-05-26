<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザー新規本登録｜ポイント.com</title>
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
<h2>ユーザー新規本登録</h2>
</div>
<!--コンテンツ-->
<div class="contents">
<p>すべての内容を入力してください。<br />
一度入力された情報は変更できません。</p>
<form method="post" action="" name="frm">
<h3>ニックネーム(重複不可)</h3>
<p>
<input type="text" name="nickname" id="nickname" style="width:95%;" value="<?php echo getParam($post, 'nickname');?>" />
<?php echo getParam($error, 'nickname'); ?>
</p>
<h3>メールアドレス(半角)</h3>
<p><?php echo getParam($user, 'email'); ?></p>
<h3> 生年月日</h3>
<input type="hidden" name="m" value="regist_confirm" />
<p>
<input name="birth-year" type="number" id="birth-year" min="1900" max="2015" value="<?php echo getParam($post, 'birth-year');?>" />
年
<input name="birth-month" type="number" id="birth-month" min="01" max="12" value="<?php echo getParam($post, 'birth-month');?>" /> 
月
<input name="birth-day" type="number" id="birth-day" min="01" max="31" value="<?php echo getParam($post, 'birth-day');?>" />
日
<?php echo getParam($error, 'birthday'); ?>
</p>
<h3> 性別</h3>
<p>
<?php foreach(user_gender() as $val_key => $val_name):?>
	<input type="radio" value="<?php echo $val_key;?>" name="gender" id="<?php echo $val_key;?>" <?php echo _check_checked($val_key, getParam($post, 'gender'));?> />
	<label for="<?php echo $val_key;?>"><?php echo $val_name;?></label>
<?php endforeach;?>
<?php echo getParam($error, 'gender'); ?>
</p>
<h3>都道府県</h3>
<p>
<select name="prefectures_id" id="prefectures_id">
<option value="">選択してください</option>
<?php foreach(prefectures_master() as $val_key => $val_name):?>
	<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'prefectures_id'));?>><?php echo $val_name;?></option>
<?php endforeach;?>
</select>
<?php echo getParam($error, 'prefectures_id'); ?>
</p>
<h3>パスワード(半角英数4～16文字)</h3>
<p>
<input type="password" name="password" id="password" style="width:95%;"  value="<?php echo getParam($post, 'password');?>" />
<?php echo getParam($error, 'password'); ?>
</p>
</form>
<p><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a></p>

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
