
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
				
				
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>請求一覧</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<h3>ポイント発行</h3>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="200">日時</th>
								<th>内容</th>
								<th width="100">ポイント</th>
								<th width="100">手数料</th>
								<th width="100">合計</th>
							</tr>
							<?php foreach($n_points as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo reserved_status($point['status_id']);?><?php echo $point['name'];?></td>
								<td><?php echo minus_tag($point['point']);?></td>
								<td><?php echo minus_tag($point['commission']);?></td>
								<td><?php echo minus_tag($point['total']);?></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="4" style="text-align: right">合計</td>
								<td><strong><?php echo minus_tag($n_point_total);?></strong></td>
							</tr>
							<tr>
								<th width="200">キャンセル</th>
								<th>内容</th>
								<th width="100">ポイント</th>
								<th width="100">手数料</th>
								<th width="100">合計</th>
							</tr>
							<?php foreach($n_points_cancel as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo $point['name'];?></td>
								<td><?php echo plus_tag($point['point']);?></span></td>
								<td><?php echo plus_tag($point['commission']);?></span></td>
								<td><?php echo plus_tag($point['total']);?></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="4" style="text-align: right">合計</td>
								<td><strong><?php echo plus_tag($n_point_cancel_total);?></strong></td>
							</tr>
						</table>
						
						
						<h3>イベントポイント発行</h3>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="200">日時</th>
								<th>内容</th>
								<th width="100">ポイント</th>
								<th width="100">手数料</th>
								<th width="100">合計</th>
							</tr>
							<?php foreach($e_points as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo reserved_status($point['status_id']);?><?php echo $point['name'];?></td>
								<td><?php echo minus_tag($point['point']);?></td>
								<td><?php echo minus_tag($point['commission']);?></td>
								<td><?php echo minus_tag($point['total']);?></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="4" style="text-align: right">合計</td>
								<td><strong><?php echo minus_tag($e_point_total);?></strong></td>
							</tr>
							<tr>
								<th width="200">キャンセル</th>
								<th>内容</th>
								<th width="100">ポイント</th>
								<th width="100">手数料</th>
								<th width="100">合計</th>
							</tr>
							<?php foreach($e_points_cancel as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo $point['name'];?></td>
								<td><?php echo plus_tag($point['point']);?></span></td>
								<td><?php echo plus_tag($point['commission']);?></span></td>
								<td><?php echo plus_tag($point['total']);?></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="4" style="text-align: right">合計</td>
								<td><strong><?php echo plus_tag($e_point_cancel_total);?></strong></td>
							</tr>
						</table>
						
						
						<h3>特別ポイント発行</h3>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="200">日時</th>
								<th>対象者</th>
								<th width="100">ポイント</th>
								<th width="100">手数料</th>
								<th width="100">合計</th>
							</tr><?php foreach($sp_points as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo $point['name'];?></td>
								<td><?php echo minus_tag($point['point']);?></span></td>
								<td><?php echo minus_tag($point['commission']);?></span></td>
								<td><?php echo minus_tag($point['total']);?></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="4" style="text-align: right">合計</td>
								<td><strong><?php echo minus_tag($sp_point_total);?></strong></td>
							</tr>
						</table>
						
						
						<h3>使用されたポイント（ポイント）</h3>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="200">日時</th>
								<th>内容</th>
								<th width="100">ポイント</th>
							</tr>
							<?php foreach($use_n_points as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo reserved_status($point['status_id']);?><?php echo $point['name'];?></td>
								<td><?php echo plus_tag($point['point']);?></span></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="2" style="text-align: right">合計</td>
								<td><strong><?php echo plus_tag($use_n_point_total);?></strong></td>
							</tr>
							<tr>
								<th width="200">キャンセル</th>
								<th>内容</th>
								<th width="100">ポイント</th>
							</tr>
							<?php foreach($use_n_points_cancel as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo $point['name'];?></td>
								<td><?php echo minus_tag($point['point']);?></span></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="2" style="text-align: right">合計</td>
								<td><strong><?php echo minus_tag($use_n_point_cancel_total);?></strong></td>
							</tr>
						</table>
						
						
						<h3>使用されたポイント（イベント）</h3>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="200">日時</th>
								<th>内容</th>
								<th width="100">ポイント</th>
							</tr>
							<?php foreach($use_e_points as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo reserved_status($point['status_id']);?><?php echo $point['name'];?></td>
								<td><?php echo plus_tag($point['point']);?></span></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="2" style="text-align: right">合計</td>
								<td><strong><?php echo plus_tag($use_e_point_total);?></strong></td>
							</tr>
							<tr>
								<th width="200">キャンセル</th>
								<th>内容</th>
								<th width="100">ポイント</th>
							</tr>
							<?php foreach($use_e_points_cancel as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo $point['name'];?></td>
								<td><?php echo minus_tag($point['point']);?></span></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="2" style="text-align: right">合計</td>
								<td><strong><?php echo minus_tag($use_e_point_cancel_total);?></strong></td>
							</tr>
						</table>
						
						
						<h3>使用されたポイント（ポイントのみ）</h3>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="200">日時</th>
								<th>内容</th>
								<th width="100">ポイント</th>
							</tr>
							<?php foreach($use_points as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo reserved_status($point['status_id']);?><?php echo $point['name'];?></td>
								<td><?php echo plus_tag($point['point']);?></span></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="2" style="text-align: right">合計</td>
								<td><strong><?php echo plus_tag($use_point_total);?></strong></td>
							</tr>
							<tr>
								<th width="200">キャンセル</th>
								<th>内容</th>
								<th width="100">ポイント</th>
							</tr>
							<?php foreach($use_points_cancel as $point):?>
							<tr>
								<td width="200"><?php echo $point['date'];?></td>
								<td><?php echo $point['name'];?></td>
								<td><?php echo minus_tag($point['point']);?></span></td>
							</tr>
							<?php endforeach;?>
							<tr>
								<td colspan="2" style="text-align: right">合計</td>
								<td><strong><?php echo minus_tag($use_point_cancel_total);?></strong></td>
							</tr>
						</table>
						
						
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