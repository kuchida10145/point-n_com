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
					<li><a href="notice.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
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
							<form class="form-horizontal" action="?m=edit&tkn=<?php echo getGet('tkn');?>" method="post" name="catchmail_form">
								<input type="hidden" value="edit" name="m">
								<div class="box-header" data-original-title="">
									キャッチメール返信内容
								</div> <br>
								<div class="control-group <?php echo error_class(getParam($error, 'display_date'));?>">
									<label class="control-label" for="date03" >何時から遊びたいか </label>
									<div class="controls">
										<?php echo getParam($post, 'reserved_date').'〜';?>
										<input type="hidden" value="<?php echo getParam($post, 'reserved_date');?>" name="reserved_date">
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="typeahead">来店人数 </label>
									<div class="controls">
										<?php echo getParam($post, 'use_persons').'人';?>
										<input type="hidden" value="<?php echo getParam($post, 'use_persons');?>" name="use_persons">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="fileInput">予約名</label>
									<div class="controls" id="images">
										<?php echo getParam($post, 'reserved_name');?>
										<input type="hidden" value="<?php echo getParam($post, 'reserved_name');?>" name="reserved_name">
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="typeahead">金額（円） <span class="label label-important">必須</span></label>
									<div class="controls">
										<input placeholder="" name="money" value="<?php echo getParam($post, 'money');?>" style="width:100px;">円
										<?php echo getParam($error,'money');?>
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="textarea2">アピール 定型文</label>
									<div class="controls">
										<label>１：地域No.１サービス！！ぜひ当店へお越しください。</label>
										</br>
										<label>２：地域最安値！！ぜひ当店へお越しください。</label>
										</br>
										<label>３：ぜひ当店へお越しください。</label>
										</br>
										<label>上記をコピーしてお使いください。</label>
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="textarea2">アピール </label>
									<div class="controls">
										<textarea class="ckeditor" rows="3" name="appeal">
											<?php
												$textarea_val = getParam($post, 'appeal');
												echo $textarea_val;
											?>
										</textarea>
										<?php echo textarea_caution_msg();?>
										<?php echo getParam($error,'appeal');?>
									</div>
								</div>
								<input type="hidden" value="<?php echo getParam($post, 'catchmail_id');?>" name="catchmail_id">
								<div class="control-group">
									<div class="form-actions">
										<button class="btn btn-primary" type="submit">確認画面へ</button>
										<button type="button" onclick="location.href='?m=index&tkn=<?php echo getGet('tkn');?>'" class="btn">戻る</button>
									</div>
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
