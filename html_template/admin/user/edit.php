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
						</div>
						<br>
							<div class="control-group">
								<label class="control-label" for="">登録日</label>
								<div class="controls">
									<?php echo isset( $regist_date ) ? $regist_date : '新規登録時に自動入力'; ?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'user_id'));?>">
								<label class="control-label" for="">会員番号</label>
								<div class="controls">
									<?php echo isset( $user_id ) ? $user_id : '新規登録時に自動入力'; ?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'email'));?>">
								<label class="control-label" for="email">メールアドレス<br />（ログインID）<span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="email" name="email" type="email" class="" value="<?php echo getParam($post, 'email');?>">
									<?php echo getParam($error, 'email');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'nickname'));?>">
								<label class="control-label" for="nickname">ニックネーム <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="nickname" name="nickname" type="text" class="" value="<?php echo getParam($post, 'nickname');?>">
									<?php echo getParam($error, 'nickname');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'birthday'));?>">
								<label class="control-label" for="birthday">誕生日 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="birthday" name="birthday" type="text" class="input-xlarge datepicker" value="<?php echo getParam($post, 'birthday');?>">
									<?php echo getParam($error, 'birthday');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'gender'));?>">
								<label class="control-label" for="gender">性別 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="gender" name="gender">
										<option value="">選択してください</option>
										<?php foreach(user_gender() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'gender'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'gender');?>
								</div>
						   </div>

							<div class="control-group <?php echo error_class(getParam($error, 'prefectures_id'));?>">
								<label class="control-label" for="prefectures_id">都道府県 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="prefectures_id" name="prefectures_id">
										<option value="">選択してください</option>
										<?php foreach(prefectures_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'prefectures_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'prefectures_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'password'));?>">
								<label class="control-label" for="password">パスワード <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="4～8文字の半角英数字" id="password" name="password" type="password" class="" value="<?php echo getParam($post, 'password');?>">
									<?php echo getParam($error, 'password');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'status_id'));?>">
								<label class="control-label" for="status_id">ステータス <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="status_id" name="status_id">
										<option value="">選択してください</option>

										<?php foreach(user_status() as $val_key => $val_name) :?>
												<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'status_id'));?>><?php echo $val_name;?></option>
										<?php endforeach; ?>
									</select>
									<?php echo getParam($error, 'status_id');?>
								</div>
							</div>
							
							<div class="form-actions">
								<button class="btn btn-primary" type="submit">確認画面へ</button>
								<button type="button" onclick="location.href='user.php'" class="btn">戻る</button>
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
		
	});
	</script>
</body>
</html>
