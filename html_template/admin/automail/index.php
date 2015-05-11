
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>管理システム</title>
<?php include_once dirname(__FILE__).'/../common/head.php';?>
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
		<div class="page-header"><h1><span class="iconbox"><i class="fa fa-info-circle"></i></span> <?php echo $page_title;?></h1></div>
		<div class="page-contents">




			<div class="mb10">
				<div class="btn-group"><a href="?m=edit" class="btn btn-success"><i class="fa fa-plus"></i> 新規作成</a></div>
			</div>


			<?php echo $system_message;?>


			<?php if(!$list):?>
			<p>データがありませんでした</p>
			<?php else:?>
			<div class="tablebox">

				<table class="table table-bordered">
				<tr>
					<th align="center" width="100">ID</th>
					<th>タイトル</th>
					<th>件名</th>
					<th width="100"> </th>
				</tr>
				<?php foreach($list as $automail_data):?>
					<tr>
					<td align="center"><?php echo $automail_data['automail_id'];?></td>
					<td><?php echo $automail_data['title'];?></td>
					<td><?php echo $automail_data['subject'];?></td>
					<td align="center">
					<a href="?m=edit&id=<?php echo $automail_data['automail_id'];?>" class="btn btn-xs  btn-warning"><i class="fa fa-edit"></i>&nbsp;編集</a>
					</td>
				</tr>
				<?php endforeach;?>
				</table>
			</div>
			<?php echo $pager_html;?>
			<?php endif;?>

		</div>
	</div>
</div>
<!-- /メインコンテンツ -->




<?php include_once dirname(__FILE__).'/../common/modalbox.php';?>
</body>
</html>
