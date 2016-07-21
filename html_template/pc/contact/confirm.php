<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>お問い合わせ確認　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,問い合わせ,確認" />
<meta name="description" content="お問い合わせ内容確認画面です。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
		<h2>お問い合わせ</h2>
		<form action="/contact/confirm.php?tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
			<input type="hidden" value="edit" name="m">
			<h3>都道府県</h3>
			<p><?php echo getParam($post, 'pref');?></p>
			<h3>メールアドレス</h3>
			<p><?php echo getParam($post, 'email');?></p>
			<h3>お問い合わせ内容</h3>
			<p><?php echo getParam($post, 'detail');?></p>
			<p class="alncenter">
				<a class="btn_back" href="/contact/?tkn=<?php echo getGet('tkn'); ?>" >戻る</a>
				<a class="btn_send" href="javascript:void(0);" onclick="document.frm.submit();">送信</a>
			</p>
		</form>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
