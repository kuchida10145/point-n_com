<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ユーザー新規仮登録　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,新規,登録" />
<meta name="description" content="ポイントドットコムへの仮登録をしていただけます。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
			<h2>ユーザー新規仮登録</h2>
			<p>ユーザー利用規約に同意頂き登録するメールアドレスを入力してください。折り返し仮登録完了メールが届きます。仮登録完了メールにあるURLにアクセスしますと、ユーザー登録画面へ進みます。<br />
			<h3>メールアドレス(半角)</h3>
			<form method="post" action="" name="frm">
				<input type="hidden" name="m" value="signup" />
				<p>
					<input type="text" name="email" id="email" style="width:50%;" value="<?php echo getParam($post, 'email');?>" placeholder="メールアドレスをご入力ください"/>
					<?php echo getParam($error, 'email'); ?>
				</p>
				<p class="info_p">
					<a href="kitei.php">ユーザー利用規約はこちら</a><br />
					<input type="checkbox" name="contract" id="contract" <?php echo getParam($post, 'contract') != '' ? ' checked' : ''; ?>/>
					<label for="contract" class="clrred">ユーザー利用規約に同意</label>
				</p>
				<p class="btn_next"><a href="javascript:void(0);" onclick="document.frm.submit();">送信する</a></p>
			</form>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
