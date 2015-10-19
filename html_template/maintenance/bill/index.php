
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
								
								<div class="control-group">
								<label for="" class="control-label">期間</label>
								<div class="controls">
									<select name="year" class="input-small">
										<option value=""></option>
										<?php for($i = date('Y') ; $i >= 2015; $i--):?>
										<option value="<?php echo $i;?>" <?php echo _check_selected($i,getGet('year'));?>><?php echo $i;?>年</option>
										<?php endfor;?>
									</select>
									<select name="month" class="input-small">
										<option value=""></option>
										<?php for($i = 1 ; $i <= 12; $i++):?>
										<option value="<?php echo sprintf('%02d',$i);?>" <?php echo _check_selected(sprintf('%02d',$i),getGet('month'));?>><?php echo $i;?>月</option>
										<?php endfor;?>
									</select>
								</div>
							</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">検索</button>
									<button type="reset" class="btn" onclick="location.href='?m=index'">リセット</button>
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
						<p><a class="btn btn-info" href="?<?php echo $csv_url;?>"><i class="halflings-icon white edit"></i>CSVダウンロード</a></p>
						<?php foreach($list as $data):?>
						<table class="table table-striped table-bordered table-condensed">
						<thead>
						<tr>
							<th width="150"><?php echo str_replace("-","年",$data['bill_month']);?>月</th>
							<th>ポイント</th>
							<th style="background: #ffe4e1">ポイント<br >手数料</th>
							<th>イベント<br>ポイント</th>
							<th style="background: #ffe4e1">イベント<br>ポイント<br>手数料</th>
							<th>特別<br>ポイント</th>
							<th style="background: #ffe4e1">特別<br>ポイント<br>手数料</th>
							<th style="background: #f0f8ff">使用された<br>ポイント<br>(ポイント)</th>
							<th style="background: #f0f8ff">使用された<br>ポイント<br>(イベント)</th>
							<th style="background: #f0f8ff">使用された<br>ポイント<br>(ポイントのみ)</th>
							<th>前払い</th>
							<th>調整</th>
							<th>処理</th>
							<th>合計&nbsp;
								<a class="btn btn-info" href="?m=display&id=<?php echo $data['bill_id'];?>">詳細</a></th>
						</tr>
						</thead>
						
							<tr>
								<td>&nbsp;</td>
								<td><?php echo minus_tag($data['n_point']);?></td>
								<td style="background: #ffe4e1"><?php echo minus_tag($data['n_point_commission']);?></td>
								<td><?php echo minus_tag($data['e_point']);?></td>
								<td style="background: #ffe4e1"><?php echo minus_tag($data['e_point_commission']);?></td>
								<td><?php echo minus_tag($data['sp_point']);?></td>
								<td style="background: #ffe4e1"><?php echo minus_tag($data['sp_point_commission']);?></td>
								<td style="background: #f0f8ff"><?php echo plus_tag($data['use_n_point']);?></td>
								<td style="background: #f0f8ff"><?php echo plus_tag($data['use_e_point']);?></td>
								<td style="background: #f0f8ff"><?php echo plus_tag($data['use_point']);?></td>
								<td><?php echo plus_tag($data['deposit_price']);?></td>
								<td><?php echo total_tag((0-$data['adjust_price']));?></td>
								<td><?php echo getParam(pay_status(),$data['pay_status']);?></td>
								<td><?php echo total_tag(cal_point_total($data,'maintenance'));?></td>
							</tr>
							<tr>
								<th>キャンセル</th>
								<td><?php echo plus_tag($data['n_point_cancel']);?></td>
								<td style="background: #ffe4e1"><?php echo plus_tag($data['n_point_cancel_commission']);?></td>
								<td><?php echo plus_tag($data['e_point_cancel']);?></td>
								<td style="background: #ffe4e1"><?php echo plus_tag($data['e_point_cancel_commission']);?></td>
								<td>&nbsp;</td>
								<td style="background: #ffe4e1">&nbsp;</td>
								<td style="background: #f0f8ff"><?php echo minus_tag($data['use_n_point_cancel']);?></td>
								<td style="background: #f0f8ff"><?php echo minus_tag($data['use_e_point_cancel']);?></td>
								<td style="background: #f0f8ff"><?php echo minus_tag($data['use_point_cancel']);?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><?php echo total_tag(cal_cancel_total($data,'maintenance'));?></td>
							</tr>
							<tr>
								<th>未受理</th>
								<td><?php echo $data['n_point_n'];?></td>
								<td style="background: #ffe4e1"><?php echo $data['n_point_n_commission'];?></td>
								<td><?php echo $data['e_point_n'];?></td>
								<td style="background: #ffe4e1"><?php echo $data['e_point_n_commission'];?></td>
								<td>&nbsp;</td>
								<td style="background: #ffe4e1">&nbsp;</td>
								<td style="background: #f0f8ff"><?php echo $data['use_n_point_n'];?></td>
								<td style="background: #f0f8ff"><?php echo $data['use_e_point_n'];?></td>
								<td style="background: #f0f8ff"><?php echo $data['use_point_n'];?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><?php echo number_format(cal_none_total($data,'maintenance'));?></td>
							</tr>
						
						</tbody>
						</table>
						<?php endforeach;?>
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