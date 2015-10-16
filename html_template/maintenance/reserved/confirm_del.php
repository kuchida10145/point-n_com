
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

				<div class="row-fluid">
					<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $page_type_text;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form class="form-horizontal">
                            <div class="control-group">
								<label class="control-label" for="typeahead">ポイントコード</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'point_code');?>
								</div>
							</div>

                            <div class="control-group">
								<label class="control-label" for="typeahead">来店日</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'use_date');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead">予約日</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'reserved_date');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead">会員No.</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'user_id');?>
								</div>
							</div>

                            <div class="control-group">
								<label class="control-label" for="typeahead">予約名（ニックネーム）</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'reserved_name').'('.getParam($user,'nickname').')';?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead">予約 クーポン名</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'coupon_name');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead">種別</label>
								<div class="controls">
									<?php if(getParam($reservedInfo,'reserve_kind') == "1"):?>
										ポイント
									<?php elseif(getParam($reservedInfo,'reserve_kind') == "2"):?>
										イベント
									<?php elseif(getParam($reservedInfo,'reserve_kind') == "3"):?>
										ポイントのみ利用
									<?php endif;?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead">ポイント利用</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'use_point');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead">ポイント取得</label>
								<div class="controls">
									<?php echo getParam($reservedInfo,'get_point');?>
								</div>
							</div>

							<div class="form-actions">
								<a class="btn btn-danger" href="?m=index&type=cancel&reserved_id=<?php echo getParam($reservedInfo,'reserved_id');?>">取消</a>
								<a class="btn" href="?m=index">戻る</a>
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