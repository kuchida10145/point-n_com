
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
					<li><a href="course.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
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
                            <div class="control-group <?php echo error_class(getParam($error,'status_id'));?>">
								<label class="control-label" for="selectError3">ステータス <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="status_id">
										<?php foreach(course_status_id() as $stat_id => $stat_name):?>
										<option value="<?php echo $stat_id;?>" <?php echo _check_selected($stat_id,getParam($post,'status_id'));?>><?php echo $stat_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>

                            <div class="control-group <?php echo error_class(getParam($error,'course_name'));?>">
								<label class="control-label" for="typeahead">コース名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input class="input-block-level" placeholder="半角100文字以内/全角50文字以内" name="course_name" value="<?php echo getParam($post,'course_name');?>" type="text">
									<?php echo getParam($error,'course_name');?>
								</div>
							</div>

							<?php if(getParam($error,'minutes')!=''):?>
                            <div class="control-group <?php echo error_class(getParam($error,'minutes'));?>">
                            <?php else:?>
                            <div class="control-group <?php echo error_class(getParam($error,'price'));?>">
                            <?php endif;?>
								<label class="control-label" for="typeahead">時間・通常料金 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="minutes" value="<?php echo getParam($post,'minutes');?>" style="width:70px;">分
									<?php echo getParam($error,'minutes');?>
									<input placeholder="" name="price" value="<?php echo getParam($post,'price');?>" style="width:100px;">円
									<?php echo getParam($error,'price');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error,'use_condition'));?>">
								<label class="control-label" for="use_condition">ご利用条件 <span class="label label-important">必須</span></label>
								<div class="controls">
									<textarea class="cleditor" name="use_condition" id="use_condition" rows="3"><?php echo getParam($post,'use_condition');?></textarea>
									<?php echo getParam($error,'use_condition');?>
								</div>
							</div>

                            <div class="form-actions">
								<button class="btn btn-primary" type="submit">確認画面へ</button>
								<button type="button" onclick="location.href='course.php'" class="btn">戻る</button>
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