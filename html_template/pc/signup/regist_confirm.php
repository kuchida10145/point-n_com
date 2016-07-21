<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ユーザー新規登録確認　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,新規,登録,確認" />
<meta name="description" content="ポイントドットコム本登録の内容を確認していただけます。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
			<h2>ユーザー新規仮登録</h2>
			<p>すべての内容を入力してください。<br />
			一度入力された情報は変更できません。</p>
			<form method="post" action="" name="frm">
				<input type="hidden" name="m" value="thanks" />
				<h3>ニックネーム(重複不可)</h3>
				<p><?php echo getParam($post, 'nickname');?></p>
				<h3>メールアドレス(半角)</h3>
				<p><?php echo $email; ?></p>
				<h3> 生年月日</h3>
				<p><?php echo getParam($post, 'birthday'); ?></p>
				<h3> 性別</h3>
				<p><?php echo getParam(user_gender(), getParam($post, 'gender'))?></p>
				<h3>都道府県</h3>
				<p><?php echo getParam(prefectures_master(), getParam($post, 'prefectures_id'));?></p>
				<h3>パスワード(半角英数4～16文字)</h3>
				<p><?php echo getParam($post, 'password'); ?></p>
			</form>
			<p class="alncenter"><a class="btn_back" href="regist.php?tkn=<?php echo getGet('tkn'); ?>">戻る</a> <a href="javascript:void(0);" onclick="document.frm.submit();" class="btn_send">登録する</a></p>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
