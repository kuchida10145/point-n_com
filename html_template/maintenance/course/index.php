
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?>｜Point.com管理画面</title>
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
					<li><a href="#"><?php echo $page_title;?></a></li>
				</ul>
				<h1><?php echo $page_title;?></h1>
				<?php echo $system_message;?>

				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>コース情報一覧</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<p>
							<button class="btn btn-large btn-primary" onClick="location.href='?m=edit'">新規登録</button>
						</p>
						<?php if(!$list):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
						<tr>
							<th>コース名</th>
							<th>利用時間（分）</th>
							<th>利用料金（円）</th>
							<th>ポイントのみ利用</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($list as $course_data):?>
						<tr>
							<td class="center"><?php echo $course_data['course_name'];?></td>
							<td class="center"><?php echo $course_data['minutes'];?></td>
							<td class="center"><?php echo number_format($course_data['price']);?></td>
							<td class="center">
								<?php
									echo ($course_data['point_only_flg'] ? '◯' : '×');
								?>
							</td>
							<td class="center">
								<a class="btn btn-info" href="?m=edit&id=<?php echo $course_data['course_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $course_data['course_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
							</td>
						</tr>
						<?php endforeach;?>
						</tbody>
						</table>
						<?php echo $pager_html;?>
						<?php endif;?>
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
	<!-- start:一覧画面共通処理 -->
	<?php include_once dirname(__FILE__).'/../common/list_common.php';?>
	<!-- end:一覧画面共通処理 -->
</body>
</html>