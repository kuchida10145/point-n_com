
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?> <?php echo $page_type_text;?>｜Point.com管理画面</title>
	<?php include_once dirname(__FILE__).'/../common/head.php';?>
</head>
<body>
	<!-- start: Header -->
	<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
	<!-- start: Header -->

		<div class="container-fluid-full">
		<div class="row-fluid">
        <!-- start: Main Menu -->
		<?php include_once dirname(__FILE__).'/../common/main_menu.php';?>
		<!-- end: Main Menu -->
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<!-- start: Content -->
			<!--********** コンテンツはここから **********-->
			<div id="content" class="span10">
				<ul class="breadcrumb">
					<li>
						<i class="icon-home"></i>
						<a href="index.php">Home</a>
						<i class="icon-angle-right"></i>
					</li>
					<li><a href="account.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
					<li><a href="#"><?php echo $page_type_text;?></a></li>


				</ul>


				<h1><?php echo $page_title;?></h1>

				<?php echo $system_message;?>

				<div class="row-fluid">
					<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $page_type_text;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form class="form-horizontal" action="?m=edit&tkn=<?php echo getGet('tkn');?>" method="post">
							<input type="hidden" value="edit" name="m">
                            <div class="control-group <?php echo error_class(getParam($error,'name'));?>">
								<label class="control-label" for="typeahead">タイトル <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="name" value="<?php echo getParam($post,'name');?>" maxlength="50" size="80" type="text" class="input-block-level">
									<?php echo getParam($error,'name');?>
								</div>
							</div>
							<div class="control-group <?php echo error_class(getParam($error,'subject'));?>">
								<label class="control-label" for="typeahead">件名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="subject" value="<?php echo getParam($post,'subject');?>" maxlength="50" size="80" type="text" class="input-block-level">
									<?php echo getParam($error,'subject');?>
								</div>
							</div>
							<div class="control-group <?php echo error_class(getParam($error,'from_mail'));?>">
								<label class="control-label" for="typeahead">送信元メールアドレス <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="from_mail" value="<?php echo getParam($post,'from_mail');?>" maxlength="50" size="80" type="text" class="input-block-level">
									<?php echo getParam($error,'from_mail');?>
								</div>
							</div>
							<div class="control-group <?php echo error_class(getParam($error,'from_name'));?>">
								<label class="control-label" for="typeahead">送信者名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="from_name" value="<?php echo getParam($post,'from_name');?>" maxlength="50" size="80" type="text" class="input-block-level">
									<?php echo getParam($error,'from_name');?>
								</div>
							</div>
							<div class="control-group <?php echo error_class(getParam($error,'return_path'));?>">
								<label class="control-label" for="typeahead">エラー時の送信先メールアドレス <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="return_path" value="<?php echo getParam($post,'return_path');?>" maxlength="50" size="80" type="text" class="input-block-level">
									<?php echo getParam($error,'return_path');?>
								</div>
							</div>



							<div class="control-group <?php echo error_class(getParam($error,'body'));?>">
								<label class="control-label" for="selectError3">本文 <span class="label label-important">必須</span></label>
								<div class="controls">
									<textarea name="body" rows="20" cols="80" style="width: 50%"><?php echo getParam($post,'body');?></textarea>
									<?php echo getParam($error,'body');?>
								</div>
							</div>




                            <div class="form-actions">
								<button class="btn btn-primary" type="submit">確認画面へ</button>
								<button type="button" onclick="location.href='automail.php'" class="btn">戻る</button>
							</div>
						</form>
					</div>
				</div><!--/span-->
				</div><!--/row-->

			</div><!--/.fluid-container-->
			<!-- end: Content -->
			<!--********** コンテンツはここまで **********-->

		</div><!--/#content.span10-->
		</div><!--/fluid-row-->


	<div class="clearfix"></div>
	<footer>
		<p>
			<span style="text-align:left;float:left">Copyright 2015 POINT.COM All Rights Reserved </span>
		</p>
	</footer>
	<!-- start: JavaScript-->
	<?php include_once dirname(__FILE__).'/../common/footer_javascript.php';?>
	<!-- end: JavaScript-->
</body>
</html>