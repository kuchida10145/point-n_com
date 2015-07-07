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
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon search"></i><span class="break"></span>内容確認</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form class="form-horizontal" action="?m=confirm&tkn=<?php echo getGet('tkn');?>" method="post">
								<input type="hidden" value="confirm" name="m">
								<div class="box-header" data-original-title="">設定</div><br>
								<div class="control-group">
									<label class="control-label" for="selectError3">公開</label>
									<div class="controls">
										<?php echo getParam(notice_public_kind(), getParam($post, ('public')));?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="typeahead">公開日時</label>
									<div class="controls">表示開始日　　　　　　　　　　　表示終了日</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="typeahead">&nbsp;</label>
									<div class="controls"><?php echo getParam($post, ('public_start_date'));?>　　　　　～　　　　　<?php echo getParam($post, ('public_end_date'));?></div>
								</div>
								<div class="box-header" data-original-title="">
									情報
								</div> <br>
								<div class="control-group">
									<label class="control-label" for="typeahead">日時</label>
									<div class="controls"><?php echo getParam($post, ('display_date'));?></div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectError3">タイトル</label>
									<div class="controls"><?php echo getParam($post, ('title'));?></div>
								</div>
								<div class="control-group">
									<label class="control-label" for="fileInput">画像</label>
									<div class="controls">
										<div class="masonry-gallery">
											<div id="image1" class="masonry-thumb">
												<?php echo create_image_uploaded(getParam($post, 'image1'), 'image1', 'display');?>
											</div>
											<div id="image2" class="masonry-thumb">
												<?php echo create_image_uploaded(getParam($post, 'image2'), 'image2', 'display');?>
											</div>
											<div id="image3" class="masonry-thumb">
												<?php echo create_image_uploaded(getParam($post, 'image3'), 'image3', 'display');?>
											</div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="textarea2">本文</label>
									<div class="controls">
										<?php echo $body;?>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">登録する</button>
									<button type="button" onclick="location.href='?m=edit&tkn=<?php echo getGet('tkn');?>'" class="btn">戻る</button>
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