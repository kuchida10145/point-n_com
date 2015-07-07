
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
							<div class="control-group <?php echo error_class(getParam($error,'coupon_name'));?>">
								<label for="title" class="control-label">クーポン名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input class="input-block-level" placeholder="" name="coupon_name" value="<?php echo getParam($post,'coupon_name');?>" type="text">
									<?php echo getParam($error,'course_name');?>
									<br>
									店舗様側で管理しやすいクーポン名を入力してください。　例）通常コース60分のクーポン
								</div>
							</div>
							<div class="control-group <?php echo error_class(getParam($error,'point'));?>">
								<label class="control-label" for="selectError3">ポイント数 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="point">
										<?php foreach(point_data() as $point_num=>$point_val):?>
											<option value="<?php echo $point_num;?>" <?php echo _check_selected($point_num, getParam($post,'point'));?>><?php echo $point_val;?></option>
										<?php endforeach;?>
									</select>
									1pt=1円
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="selectError3">発行するコース <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="course_id">
										<?php foreach(course_list($store_id, $p) as $cou_id=>$cou_name):?>
											<option value="<?php echo $cou_id;?>" <?php echo _check_selected($cou_id,getParam($post,'course_id'));?>><?php echo $cou_name;?></option>
										<?php endforeach;?>
									</select>
									<input type="hidden" value="<?php echo $store_id;?>" name="store_id">
									<input type="hidden" value="<?php echo $p;?>" name="p">
									<p>※開始日、終了日は指定できません。</p>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error,'use_condition'));?>">
								<label class="control-label" for="use_condition">ご利用条件 <span class="label label-important">必須</span></label>
								<div class="controls">
									<textarea class="ckeditor" name="use_condition" id="use_condition" rows="3"><?php echo getParam($post,'use_condition');?></textarea>
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