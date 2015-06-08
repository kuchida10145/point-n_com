
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
				<!-- 検索フォーム-->
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon search"></i><span class="break"></span>検索条件</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form class="form-horizontal" method="get">
								<div class="control-group">
									<label class="control-label" for="date01">日付</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date01" name="date_start" value="<?php echo getGet('date_start');?>" readonly="readonly">
										～
										<input type="text" class="input-xlarge datepicker" id="date02" name="date_end" value="<?php echo getGet('date_end');?>" readonly="readonly">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="r_code">会員ID</label>
									<div class="controls"><input placeholder="" id="r_code" name="user_id" value="<?php echo getGet('user_id');?>" type="text">
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">検索</button>
									<button type="reset" class="btn" onclick="location.href='?m=index'">リセット</button>
								</div>
                            </form>
						</div>
					</div>
				</div>
				<!-- /検索フォーム -->
				<!-- ユーザ一覧フォーム -->
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>特別ポイント付与履歴</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<p>
							<button class="btn btn-large btn-primary" onClick="location.href='?m=search'">特別ポイント付与</button>
						</p>
						<?php if(!$list):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
							<thead>
								<tr>
									<th>ポイント付与日</th>
									<th>会員番号</th>
									<th>ニックネーム</th>
									<th>付与PT</th>
							  	</tr>
							</thead>
							<tbody>
								<?php foreach($list as $special_point_data):?>
								<tr>
									<td class="center"><?php echo date_format(date_create($special_point_data['reserved_date']), 'Y年 m月 d日');?></td>
									<td><?php echo $special_point_data['user_id'];?></td>
									<td class="center"><?php echo $special_point_data['nickname'];?></td>
									<td class="center"><?php echo number_format($special_point_data['get_point']);?>pt</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<?php echo $pager_html;?>
						<?php endif;?>
					</div>
				</div><!--/span-->
				</div><!--/row-->
				<!-- /ユーザ一覧フォーム -->
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