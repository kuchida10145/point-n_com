
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
									<option value="<?php echo $i;?>" <?php echo _check_selected($i,getGet('year'));?>><?php echo $i;?>年</option>
									<?php endfor;?>
								</select>
								<select name="month" class="input-small">
									<?php for($i = 1 ; $i <= 12; $i++):?>
									<option value="<?php echo sprintf('%02d',$i);?>" <?php echo _check_selected(sprintf('%02d',$i),getGet('month'));?>><?php echo $i;?>月</option>
									<?php endfor;?>
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
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>請求</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<?php if(!$bill):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th width="150">年月</th>
								<td><?php echo $bill['bill_month'];?></td>
							</tr>
							<tr>
								<th>支払い状況</th>
								<td><?php echo getParam(pay_status(),$bill['pay_status']);?></td>
							</tr>
							<tr>
								<th>請求種別</th>
								<td><?php echo calculate_bil_type_txt($bill);?></td>
							</tr>
							<tr>
								<th>発行ポイント</th>
								<td>￥<span style="color: red">-<?php echo number_format($bill['issue_point']);?></span></td>
							</tr>
							<tr>
								<th>予約時利用ポイント</th>
								<td>￥<span style="color: blue"><?php echo number_format($bill['use_point']);?></span></td>
							</tr>
							<tr>
								<th>キャンセルポイント</th>
								<td>￥<span style="color: blue"><?php echo number_format($bill['before_cancel']);?></span></td>
							</tr>
							<tr>
								<th>前払い増加利用枠</th>
								<td>￥<span style="color: blue"><?php echo number_format($bill['deposit_price']);?></span></td>
							</tr>
							<tr>
								<th>調整金額</th>
								<td>￥<?php echo price_color_label($bill['adjust_price']);?></td>
							</tr>
							<tr>
								<th>メモ・備考</th>
								<td><?php echo str_replace("\r\n","<br />\r\n",$bill['memo']);?></td>
							</tr>
							<tr>
								<th>合計金額</th>
								<td>￥<strong style="font-size:140%"><?php echo price_color_label(calculate_bil($bill));?></strong>（<?php echo calculate_bil_type_txt($bill);?>）</td>
							</tr>
							
						</table>
						<strong>※発行ポイント：</strong>ポイント利用枠を消費して発行されたポイントの金額です。請求の対象になります。<br />
						<strong>※予約時利用ポイント：</strong>お客様がポイントを利用して予約したときに発生する払い戻しの金額です。<br />
						<strong>※キャンセルポイント：</strong>月をまたいで予約を行いキャンセルになった場合に発生する払い戻しの金額です。<br />
						例）10/15に11/02の予約を行い、11/02にキャンセルを行った場合発生。<br />
						<strong>※前払い増加利用枠：</strong>前払いでお支払いいただいたポイント利用枠の金額です。払い戻しの対象になります。<br />
						<strong>※調整金額：</strong>何らかの理由で払い戻し・請求が発生した場合に、御社と弊社の話し合いの元設定されます。<br />
						
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