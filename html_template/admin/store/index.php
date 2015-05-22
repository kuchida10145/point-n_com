
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
							<label class="control-label" for="selectError3">WEBサービス</label>
							<div class="controls">
								<button class="btn btn-success">運営中</button>
								<button class="btn btn-warning">準備中</button>
								<button class="btn btn-danger">停止中</button><br>
								※停止にした場合、Point.comのサイトから一時的に該当店舗は検索されなくなります。
							</div>
						</div>
						<div class="control-group">
							<label for="" class="control-label">店舗名</label>
							<div class="controls"><input placeholder="" id="" name="store_name" value="<?php echo getGet('store_name');?>" type="text"></div>
						</div>
						<div class="control-group">
							<label for="" class="control-label">業種</label>
							<div class="controls">
								<label class="checkbox inline">
									<div id="uniform-inlineCheckbox1" class="checker"><span class="checked"><input id="inlineCheckbox1" value="option1" type="checkbox"></span></div> 店舗型風俗
								</label>
								<label class="checkbox inline">
									<div id="uniform-inlineCheckbox2" class="checker"><span class="checked"><input id="inlineCheckbox2" value="option2" type="checkbox"></span></div> 無店舗型風俗
								</label>
								<label class="checkbox inline">
									<div id="uniform-inlineCheckbox3" class="checker"><span class="checked"><input id="inlineCheckbox3" value="option3" type="checkbox"></span></div> ホストその他
								</label>
							</div>
						</div>
						<div class="control-group">
							<label for="" class="control-label">新着店舗</label>
							<div class="controls">
								<label class="checkbox inline">
									<div id="uniform-inlineCheckbox1" class="checker"><span class="checked"><input id="inlineCheckbox1" value="option1" type="checkbox"></span></div> 新着店
								</label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="date01">入会日</label>
							<div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12">
								～
								<input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12">
							</div>
						</div> 
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">検索</button>
							<button type="reset" class="btn" onclick="location.href='store.php'">リセット</button>
						</div>
                        </form>
                    </div>
					</div><!--/span-->
				</div><!--/row-->
				<!-- /検索フォーム -->
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>店舗情報登録一覧</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<p><button class="btn btn-large btn-primary" onClick="location.href='?m=edit'">新規登録</button></p>
						<?php if(!$list):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
						<tr>
							<th>ステータス</th>
							<th>入会日</th>
							<th>店舗名</th>
							<th>新着店</th>
							<th>業種</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($list as $store_data):?>
						<tr>
							<td class="center"><?php echo getParam(store_status_label(), $store_data['status_id']);?></td>
							<td class="center"><?php echo $store_data['regist_date'];?></td>
							<td><?php echo $store_data['store_name'];?></td>
							<td class="center"><?php echo getParam(store_new_arrival(), $store_data['new_arrival']);?></td>
							<td class="center"><?php echo getParam(store_type_of_industry(), $store_data['type_of_industry_id']);?></td>
							<td class="center">
								<a class="btn btn-info" href="?m=edit&id=<?php echo $store_data['store_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $store_data['store_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
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