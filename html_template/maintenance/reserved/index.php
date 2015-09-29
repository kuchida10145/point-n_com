
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
									<label class="control-label" for="date01">予約日</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date01" name="date_start" value="<?php echo getGet('date_start');?>">
										～
										<input type="text" class="input-xlarge datepicker" id="date02" name="date_end" value="<?php echo getGet('date_end');?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="use_date_start">来店日</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="use_date_start" name="use_date_start" value="<?php echo getGet('use_date_start');?>">
										～
										<input type="text" class="input-xlarge datepicker" id="use_date_end" name="use_date_end" value="<?php echo getGet('use_date_end');?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="r_code">ポイントコード</label>
									<div class="controls"><input placeholder="" id="r_code" name="point_code" value="<?php echo getGet('point_code');?>" type="text">
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
				<!-- 予約一覧画面-->
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>予約リスト一覧</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" method="get">
							<p>
								<button class="btn btn-large btn-warning" type="submit" name="status_id" value="2">予約処理完了</button>
	                   			<button class="btn btn-large btn-success" type="submit" name="status_id" value="1">予約未処理</button>
	                   			<a class="btn btn-large btn-danger" href="?m=indexCancell">予約取消リスト</a>
							</p>
						</form>
						<?php if(!$list):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
							<thead>
								<tr>
									<th>ポイントコード</th>
							        <th>予約処理</th>
							        <th>予約日</th>
							        <th>来店日</th>
							        <th>会員No.</th>
									<th>予約名(ニックネーム名)</th>
							        <th>予約　クーポン名</th>
							        <th>種別</th>
							        <th>ポイント利用</th>
							        <th>ポイント取得</th>
							        <th>予約受理<br>（ポイント処理）</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($list as $reserve_data):?>
								<tr>
									<td class="center"><?php echo $reserve_data['point_code'];?></td>
									<?php if($reserve_data['status_id'] == "1"):?>
										<td class="center"><span class="label label-large label-success">未処理</span></td>
									<?php else:?>
										<td class="center"><span class="label label-large label-warning">完了</span></td>
									<?php endif;?>
									<td class="center"><?php echo $reserve_data['reserved_date'];?></td>
									<td class="center"><?php echo $reserve_data['use_date'];?></td>
									<td><?php echo $reserve_data['user_id'];?></td>
									<td class="center"><strong><?php echo $reserve_data['reserved_name'];?></strong>(<?php echo $reserve_data['nickname'];?>)</td>
									<td class="center"><?php echo $reserve_data['coupon_name'];?></td>
									<?php if($reserve_data['point_kind'] == "1"):?>
										<td class="center">ポイント</td>
									<?php elseif($reserve_data['point_kind'] == "2"):?>
										<td class="center">イベント</td>
									<?php else:?>
										<td class="center">特別</td>
									<?php endif;?>
									<td class="center"><?php echo $reserve_data['use_point'];?></td>
									<td class="center"><?php echo $reserve_data['get_point'];?></td>
									<?php if($reserve_data['status_id'] == "1"):?>
										<td class="center">
											<a class="btn btn-info" href="?m=index&type=accept&reserved_id=<?php echo $reserve_data['reserved_id'];?>">受理</a>
											<a class="btn btn-danger" href="?m=index&type=cancel&reserved_id=<?php echo $reserve_data['reserved_id'];?>">取消</a>
										</td>
									<?php else:?>
										<td class="center">&nbsp;</td>
									<?php endif;?>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<?php echo $pager_html;?>
						<?php endif;?>
					</div>
				</div><!--/span-->
				</div><!--/row-->
				<!-- /予約一覧画面-->
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