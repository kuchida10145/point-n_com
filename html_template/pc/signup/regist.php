<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ユーザー新規登録　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,新規,登録" />
<meta name="description" content="ポイントドットコム本登録をしていただけます。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
			<h2>ユーザー新規登録</h2>
			<p>すべての内容を入力してください。<br />
			一度入力された情報は変更できません。</p>
			<form method="post" action="" name="frm">
				<h3>ニックネーム(重複不可)</h3>
				<p>
				<input type="text" name="nickname" id="nickname" style="width:97.5%;" value="<?php echo getParam($post, 'nickname');?>" />
				</p>
				<h3>メールアドレス(半角)</h3>
				<p><?php echo getParam($user, 'email'); ?></p>
				<h3> 生年月日</h3>
				<input type="hidden" name="m" value="regist_confirm" />
				<p>
					<input name="birth-year" type="number" id="birth-year" min="1900" max="2015" placeholder="2015" value="<?php echo getParam($post, 'birth-year');?>" />
					年
					<input name="birth-month" type="number" id="birth-month" min="01" max="12" placeholder="01" value="<?php echo getParam($post, 'birth-month');?>" />
					月
					<input name="birth-day" type="number" id="birth-day" min="01" max="31" placeholder="01" value="<?php echo getParam($post, 'birth-day');?>" />
					日
					<?php echo getParam($error, 'birthday'); ?>
				</p>
				<h3> 性別</h3>
				<p>
					<?php foreach(user_gender() as $val_key => $val_name):?>
						<input type="radio" value="<?php echo $val_key;?>" name="gender" id="<?php echo $val_key;?>" <?php echo _check_checked($val_key, getParam($post, 'gender'));?>  />
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
				<input type="password" name="password" id="password" style="width:30%;"  value="<?php echo getParam($post, 'password');?>" />
				</p>
				<p>パスワードは1ヶ月に一度、定期的に変更されることをお勧めします。<br />
				なお、お客様の過失によるパスワードの漏えいやそれに伴う損害は、当サイトでは一切保障しませんのであらかじめご了承ください。</p>
			</form>
			<p class="btn_next">
				<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">確認画面へ</a>
			</p>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
