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
							<form class="form-horizontal" action="?m=edit&tkn=<?php echo getGet('tkn');?>" method="post">
								<input type="hidden" value="edit" name="m">
								<div class="box-header" data-original-title="">
									設定
								</div> <br>
								<div class="control-group">
									<label class="control-label" for="selectError3">公開</label>
									<div class="controls">
										<select name="public" id ="selectError3">
											<?php foreach(notice_public_kind() as $status_id => $status_val):?>
												<option value="<?php echo $status_id;?>" <?php echo _check_selected($status_id,getParam($post, 'public'));?>><?php echo $status_val;?></option>
											<?php endforeach;?>
										</select>
							    	</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="date01">公開期間</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date01" name="public_start_date" value="<?php echo getParam($post, 'public_start_date') != 0 ? date('Y-m-d', strtotime(getParam($post, 'public_start_date'))) : ''; ?>">
										～
										<input type="text" class="input-xlarge datepicker" id="date02" name="public_end_date" value="<?php echo getParam($post, 'public_end_date') != 0 ? date('Y-m-d', strtotime(getParam($post, 'public_end_date'))) : ''; ?>">
										<?php echo getParam($error,'public_start_date');?>
										<?php echo getParam($error,'public_end_date');?>
									</div>
								</div>
								<div class="box-header" data-original-title="">
									情報
								</div> <br>
								<div class="control-group">
									<label class="control-label" for="date03">公開日付</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date03" name="display_date" value="<?php echo getParam($post, 'display_date') != 0 ? getParam($post, 'display_date') : ''; ?>">
										<?php echo getParam($error,'display_date');?>
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="typeahead">タイトル <span class="label label-important">必須</span></label>
									<div class="controls">
										<input placeholder="" id="typeahead" name="title" type="text" class="input-block-level" value="<?php echo getParam($post, 'title');?>">
										<?php echo getParam($error,'title');?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="fileInput">画像の登録</label>
									<div class="controls" id="images">
										<div id="image1"><?php echo create_image_uploaded(getParam($post,'image1'),'image1');?></div>
										<?php echo getParam($error,'image1');?>
										<div id="image2"><?php echo create_image_uploaded(getParam($post,'image2'),'image2');?></div>
										<?php echo getParam($error,'image2');?>
										<div id="image3"><?php echo create_image_uploaded(getParam($post,'image3'),'image3');?></div>
										<?php echo getParam($error,'image3');?>
									</div>
								</div>
								<div class="control-group hidden-phone <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="textarea2">本文 <span class="label label-important">必須</span></label>
									<div class="controls">
										<textarea class="cleditor" id="textarea2" rows="3" name="body"><?php echo getParam($post, 'body');?></textarea>
										<?php echo getParam($error,'body');?>
									</div>
								</div>
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

	<script>
	$(function(){

		$('#image1').imageUpload({url:'/admin/notice.php?m=image_upload',name:'image1'});
		$('#image2').imageUpload({url:'/admin/notice.php?m=image_upload',name:'image2'});
		$('#image3').imageUpload({url:'/admin/notice.php?m=image_upload',name:'image3'});
	});
	</script>
</body>
</html>
