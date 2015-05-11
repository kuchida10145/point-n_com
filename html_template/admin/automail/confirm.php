
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $page_title;?> <?php echo $page_type_text;?>|管理システム</title>
<?php include_once dirname(__FILE__).'/../common/head.php';?>
<link rel="stylesheet" media="all" type="text/css" href="js/jquery-ui/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="js/datepicker/jquery-ui-timepicker-addon.css" />
<script src="js/jquery-ui/jquery-ui.min.js"></script>
<script src="js/datepicker/jquery-ui-timepicker-addon.js"></script>
<script src="js/datepicker/jquery.ui.datepicker-ja.js"></script>
<script src="js/datepicker/ja.js"></script>
<script>
$(function(){

	$('#submit').click(function(){
		document.frm.submit();
	});
});
</script>
</head>
<body>
<!-- ヘッダーコンテンツ -->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>

<!-- サイドコンテンツ -->
<?php include_once dirname(__FILE__).'/../common/side_contents.php';?>


<!-- メインコンテンツ -->
<div class="main_contents">




<ol class="breadcrumb">
    <li><a href="index.php">Home</a></li>
    <li><?php echo $page_title;?></li>
</ol>
	<div class="col-xs-12">
	<div class="page-header"><h1><span class="iconbox"><i class="fa fa-info-circle"></i></span> <?php echo $page_title;?> <?php echo $page_type_text;?></h1></div>
	<div class="page-contents">
		<form action="" method="post" name="frm">
		<input type="hidden" value="confirm" name="m" />



		<div class="tablebox">
		<table class="table table-hover">
			<tr>
				<th class="" colspan="2">基本情報</th>
			</tr>
			<tr>
				<td width="250">タイトル <span class="label label-danger">必須</span></td>
				<td><?php echo getParam($post,'title');?></td>
			</tr>
			<tr>
				<td width="250">件名 <span class="label label-danger">必須</span></td>
				<td><?php echo getParam($post,'subject');?></td>
			</tr>
			<tr>
				<td width="250">送信元メールアドレス<span class="label label-danger">必須</span></td>
				<td><?php echo getParam($post,'from_mail');?></td>
			</tr>
			<tr>
				<td width="250">送信者名 <span class="label label-danger">必須</span></td>
				<td><?php echo getParam($post,'from_name');?></td>
			</tr>
			<tr>
				<td width="250">エラー時の送信先メールアドレス <span class="label label-danger">必須</span></td>
				<td><?php echo getParam($post,'return_path');?></td>
			</tr>

			<tr>
				<td width="250">本文 <span class="label label-danger">必須</span></td>
				<td><?php echo str_replace("\r\n","<br />",getParam($post,'body'));?></td>
			</tr>


		</table>
		</div>

	    <div class="mb10">
	<div class="btn-group"><a href="javascript:void(0);" class="btn btn-success" id="submit"><i class="fa "></i>保存</a></div>
	<div class="btn-group"><a href="?m=edit&tkn=<?php echo getGet('tkn');?>" class="btn btn-default"><i class="fa "></i>入力画面に戻る</a></div>

	</div>


	</form>

</div>
</div>



</div>
<!-- /メインコンテンツ -->




<?php include_once dirname(__FILE__).'/../common/modalbox.php';?>
</body>
</html>
