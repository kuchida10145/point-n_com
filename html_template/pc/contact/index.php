<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>お問い合わせ　｜　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,質問,問い合わせ" />
<meta name="description" content="ポイントドットコムに関するご質問、問合せはこちらから。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="index" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div id="" class="container bg_info">
	<div class="mainbodybg01">
		<div class="bg_info_bord">
			<h2>お問い合わせ</h2>
			<form action="/contact/?tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
				<input type="hidden" value="edit" name="m">
				<h3>都道府県</h3>
				<p>
					<select name="pref" id="select" style="width:42%">
						<option value="">選択してください</option>
						<?php foreach(prefectures_master() as $pref_id => $pref_name):?>
						<option value="<?php echo $pref_id;?>" <?php echo _check_selected($pref_id, getParam($post, 'pref'));?>><?php echo $pref_name;?></option>
						<?php endforeach;?>
					</select>
					<?php echo getParam($error,'pref');?>
				</p>
				<h3>メールアドレス</h3>
				<p>
					<input type="text" value="<?php echo getParam($post,'email');?>" name="email" style="width:40%" placeholder="メールアドレスをご入力ください"><?php echo getParam($error,'email');?>
				</p>
				<h3>お問い合わせ内容</h3>
				<p>
					<textarea name="detail" style="width:98%" cols="" rows="5"><?php echo getParam($post,'detail');?></textarea>
				</p>
				<?php echo getParam($error,'detail');?>
			<br>
				<p class="btn_next"><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">確認画面へ</a></p>
			</form>
		</div>
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
</html>
