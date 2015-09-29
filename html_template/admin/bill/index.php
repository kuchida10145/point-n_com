
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
							<h2><i class="halflings-icon search"></i><span class="break"></span>絞込み検索</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
					<div class="box-content">
						<form class="form-horizontal" method="get">
							<input type="hidden" value="<?php echo getGet('store_id');?>" name="store_id">
							<div class="control-group">
								<label for="" class="control-label">期間</label>
								<div class="controls">
									<select name="year" class="input-small">
										<?php for($i = date('Y') ; $i >= 2015; $i--):?>
										<option value="<?php echo $i;?>" <?php echo _check_selected($i,getGet('year',date('Y')));?>><?php echo $i;?>年</option>
										<?php endfor;?>
									</select>
									<select name="month" class="input-small">
										<?php for($i = 1 ; $i <= 12; $i++):?>
										<option value="<?php echo sprintf('%02d',$i);?>" <?php echo _check_selected(sprintf('%02d',$i),getGet('month',date('m')));?>><?php echo $i;?>月</option>
										<?php endfor;?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label for="" class="control-label">店舗名</label>
								<div class="controls">
									<input type="text" name="store_name" value="<?php echo escapeHtml(getGet('store_name'));?>">
								</div>
							</div>
							<div class="control-group">
								<label for="" class="control-label">エリア</label>
								<div class="controls">
									<select id="region_id" name="region_id" class="input-small">
										<option value=""></option>
										<?php foreach(region_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet('region_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label for="" class="control-label">ステータス</label>
								<div class="controls">
									<select id="" name="pay_status">
										<option value=""></option>
										<?php foreach(pay_status() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet('pay_status'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label for="" class="control-label">業種</label>
								<div class="controls">
									<select id="type_of_industry_id" name="type_of_industry_id">
										<option value=""></option>
										<?php foreach(store_type_of_industry() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet('type_of_industry_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">ジャンル</label>
								<div class="controls">
									<select id="category_large_id" name="category_large_id">
										<option value=""></option>
										<?php foreach(category_large() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet( 'category_large_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">検索</button>
							<button type="reset" class="btn" onclick="location.href='bill.php'">リセット</button>
						</div>
                        </form>
                    </div>
					</div><!--/span-->
				</div><!--/row-->
				<!-- /検索フォーム -->
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>請求一覧</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<?php if(!$list):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
						<tr>
							<th>年月</th>
							<th>店舗名</th>
							<th>ポイント発行</th>
							<th>イベントポイント発行</th>
							<th>利用ポイント発行</th>
							<th>特別ポイント発行</th>
							<th>利用手数料</th>
							<th>処理</th>
							<th>合計</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($list as $bill):?>
						<tr>
							<td class="center"><?php echo $bill['bill_month'];?></td>
							<td class="center"><?php echo $bill['store_name'];?></td>
							<td class="center"><?php echo number_format($bill['normal_point']);?></td>
							<td class="center"><?php echo number_format($bill['event_point']);?></td>
							<td class="center"><?php echo number_format($bill['use_point']);?></td>
							<td class="center"><?php echo number_format($bill['special_point']);?></td>
							<td class="center"><?php echo number_format($bill['total_commission']);?></td>
							<td class="center"><?php echo getParam(pay_status(),$bill['pay_status']);?></td>
							<td class="center"><?php echo number_format(calculate_bil($bill));?></td>
							<td class="center">
								<a class="btn btn-info" href="?m=edit&id=<?php echo $bill['bill_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								</td>
						</tr>
						<?php endforeach;?>
						</tbody>
						</table>
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