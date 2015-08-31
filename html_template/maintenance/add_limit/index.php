
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
									<?php for($i = $year ; $i <= date('Y'); $i++):?>
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
							<button type="reset" class="btn" onclick="location.href='account.php'">リセット</button>
						</div>
                        </form>
                    </div>
					</div><!--/span-->
				</div><!--/row-->
				<!-- /検索フォーム -->
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>利用枠一覧</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<p><button class="btn btn-large btn-primary" onClick="location.href='?m=edit&store_id=<?php echo getGet('store_id');?>'">新規追加</button></p>
						<p>現在の利用可能枠は<strong><?php echo number_format($account_data['point_limit']);?></strong>ポイント分です。<br />
						さらに利用枠を広げたい場合は、広げたいポイント数分の金額(1ポイント=1円）を入金後、「新規追加」から申請を行ってください。<br />
						入金確認後に、金額に応じた応募枠を付与いたします。<br />
						また、付与されたポイント枠は翌月に繰り越すことはできません。入金後余ってしまったポイント枠は返金の対象になります。
						</p>
						<?php if(!$list):?>
						
						<p>利用枠追加履歴はありませんでした。</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
						<tr>
							<th>入金日</th>
							<th>金額</th>
							<th>メモ</th>
							<th>種類</th>
							<th>処理</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($list as $add_limit):?>
						<tr>
							<td class="center"><?php echo $add_limit['add_date'];?></td>
							<td class="center"><?php echo number_format($add_limit['add_point']);?>円</td>
							<td class="center"><?php echo str_replace("\r\n","<br >\r\n",$add_limit['memo']);?></td>
							<td class="center"><?php echo getParam(add_limit_type(),$add_limit['add_type']);?></td>
							<td class="center"><?php echo getParam(add_review_status(),$add_limit['review_status']);?></td>
							<td class="center">
								<?php if($add_limit['review_status'] == ADD_LIMIT_RST_REQ): /*申請の場合*/ ?>
								<a class="btn btn-info" href="?m=edit&id=<?php echo $add_limit['add_limit_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $add_limit['add_limit_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
								<?php endif;?>
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