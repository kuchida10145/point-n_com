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
				<h1><?php echo $page_title; ?></h1>
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
									<label class="control-label" for="selectError3">公開</label>
									<div class="controls">
										<button class="btn btn-success" type="submit" name="public" value="1">公開</button>
										<button class="btn btn-warning" type="submit" name="public" value="2">非公開</button><br>
										※非公開にした場合、表示開始日や終了日に関係なく、POINT.COMのサイトから一時的にお知らせ情報が表示されなくなりま。
									</div>
								</div>
								<div class="control-group">
									<label for="" class="control-label">タイトル</label>
									<div class="controls">
										<input class="input-block-level" placeholder="" name="title" type="text" value="<?php echo getGet('title');?>">
									</div>
								</div>
								<div class="control-group">
									<label for="" class="control-label">対象エリア</label>
									<div class="controls">
										<select name="region_id">
											<option value=""></option>
											<?php foreach(region_master() as $region_id => $region_name):?>
											<option value="<?php echo $region_id;?>" <?php echo _check_selected($region_id, getGet('region_id'));?>><?php echo $region_name;?></option>
											<?php endforeach;?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="date01" >日付</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="date01" name="display_date_s" value="<?php echo getGet('display_date_s');?>">
										～
										<input type="text" class="input-xlarge datepicker" id="date02" name="display_date_e" value="<?php echo getGet('display_date_e');?>">
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
							<h2><i class="halflings-icon align-justify"></i><span class="break"></span>店舗情報登録一覧</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
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
										<th>日付</th>
										<th>タイトル</th>
										<th>表示開始日</th>
										<th>表示終了日</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($list as $data):?>
									<tr>
										<td class="center"><?php echo getParam(news_status_label(),$data['public']);?></td>
										<td class="center"><?php echo date_format(date_create($data['display_date']), 'Y/m/d');?></td>
										<td><?php echo $data['title'];?></td>
										<td class="center"><?php echo date_format(date_create($data['public_start_date']), 'Y/m/d');?></td>
										<td class="center"><?php echo date_format(date_create($data['public_end_date']), 'Y/m/d');?></td>
										<td class="center">
											<a class="btn btn-info" href="?m=edit&id=<?php echo $data['news_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
											<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $data['news_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
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
	<script type="text/javascript">
		$(function(){$("[name=from-date]").datepicker({"dateFormat":"yy-mm-dd"});});
		$(function(){$("[name=to-date]").datepicker({"dateFormat":"yy-mm-dd"});});
	</script>
	<!-- start: JavaScript-->
	<?php include_once dirname(__FILE__).'/../common/footer_javascript.php';?>
	<!-- end: JavaScript-->
	<!-- start:一覧画面共通処理 -->
	<?php include_once dirname(__FILE__).'/../common/list_common.php';?>
	<!-- end:一覧画面共通処理 -->
</body>
</html>