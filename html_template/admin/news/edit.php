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
					<li><a href="user.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
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
										<select name="public">
											<?php foreach(news_status_kind() as $status_id => $status_val):?>
												<option value="<?php echo $status_id;?>" <?php echo _check_selected($status_id,getParam($post, 'public'));?>><?php echo $status_val;?></option>
											<?php endforeach;?>
										</select>
							    	</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="date01">公開期間</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date01" name="public_start_date" value="<?php echo getParam($post, 'public_start_date');?>">
										～
										<input type="text" class="input-xlarge datepicker" id="date02" name="public_end_date" value="<?php echo getParam($post, 'public_end_date');?>">
										<?php echo getParam($error,'public_start_date');?>
										<?php echo getParam($error,'public_end_date');?>
									</div>
								</div>
								<div class="box-header" data-original-title="">
									情報
								</div> <br>
								<div class="control-group <?php echo error_class(getParam($error, 'display_date'));?>">
									<label class="control-label" for="date03">表示日付 <span class="label label-important">必須</span></label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date03" name="display_date" value="<?php echo getParam($post, 'display_date');?>">
										</br><?php echo getParam($error,'display_date');?>
										※入力した日付がタイトルと共にwebサイト上に表示されます。
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'region_id'));?>">
									<label class="control-label" for="date03">対象エリア <span class="label label-important">必須</span></label>
									<div class="controls">
										<select name="region_id">
											<option value="">選択してください</option>
											<?php foreach(region_master() as $region_id => $region_name):?>
											<option value="<?php echo $region_id;?>" <?php echo _check_selected($region_id, getParam($post,'region_id'));?>><?php echo $region_name;?></option>
											<?php endforeach;?>
										</select>
										<?php echo getParam($error,'region_id');?>
									</div>
								</div>


								<div class="control-group <?php echo error_class(getParam($error, 'title'));?>">
									<label class="control-label" for="typeahead">タイトル <span class="label label-important">必須</span></label>
									<div class="controls">
										<input placeholder="" id="input" name="title" type="text" class="input-block-level" value="<?php echo getParam($post, 'title');?>">
										<?php echo getParam($error,'title');?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="fileInput">画像の登録</label>
									<div class="controls">
										<input type="hidden" id="cur_image1" name="cur_image1" value="<?php echo getParam($post, 'cur_image1', '');?>">
										<div id="image1"><?php echo create_image_uploaded(getParam($post,'image1'),'image1');?></div>
										<?php echo getParam($error,'image1');?>
										<input type="hidden" id="cur_image2" name="cur_image2" value="<?php echo getParam($post, 'cur_image2', '');?>">
										<div id="image2"><?php echo create_image_uploaded(getParam($post,'image2'),'image2');?></div>
										<?php echo getParam($error,'image2');?>
										<input type="hidden" id="cur_image3" name="cur_image3" value="<?php echo getParam($post, 'cur_image3', '');?>">
										<div id="image3"><?php echo create_image_uploaded(getParam($post,'image3'),'image3');?></div>
										<?php echo getParam($error,'image3');?>
									</div>
								</div>
								<div class="control-group <?php echo error_class(getParam($error, 'body'));?>">
									<label class="control-label" for="textarea2">本文 <span class="label label-important">必須</span></label>
									<div class="controls">
										<textarea class="ckeditor" id="textarea2" rows="3" name="body"><?php echo getParam($post, 'body');?></textarea>
										<?php echo getParam($error,'body');?>
										<?php echo textarea_caution_msg();?>
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

		$('#photos').imageUpload({url:'/admin/store.php?m=image_upload',name:'photos'});
		$('#type_of_industry_id').change(function() {
			$('#type_of_industry_id').changeUpperItem({
				url:'/admin/store.php?m=change_upper_item',
				name:'type_of_industry_id'});
		});
		$('#area_first_prefectures_id').change(function() {
			$('#area_first_prefectures_id').changeUpperItem({
				url:'/admin/store.php?m=change_upper_item',
				name:'area_first_prefectures_id'});
		});
		$('#category_large_id').change(function() {
			$('#category_large_id').changeUpperItem({
				url:'/admin/store.php?m=change_upper_item',
				name:'category_large_id'});
		});
		$('#category_midium_id').change(function() {
			$('#category_midium_id').changeCategoryMidium({
				url:'/admin/store.php?m=change_category_midium',
				name:'category_midium_id',
				selected:$(this).val()});
		});
		$('#area_second_id').change(function() {
			$('#area_second_id').changeAreaSecond({
				url:'/admin/store.php?m=change_area_second',
				name:'area_second_id',
				selected:$(this).val()});
		});
		$('#image1').imageUpload({url:'/admin/news.php?m=image_upload',name:'image1'});
		$('#image2').imageUpload({url:'/admin/news.php?m=image_upload',name:'image2'});
		$('#image3').imageUpload({url:'/admin/news.php?m=image_upload',name:'image3'});
	});
	</script>
</body>
</html>
