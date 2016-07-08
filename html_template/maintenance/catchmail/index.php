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
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon align-justify"></i><span class="break"></span>キャッチメール一覧</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content">
							<!--
							<p><button class="btn btn-large btn-primary" onClick="location.href='?m=edit'">新規登録</button></p>
							 -->
							<?php if(!$list):?>
							<p>データがありませんでした</p>
							<?php else:?>
							<table class="table table-striped table-bordered table-hover table-condensed">
								<thead>
									<tr>
										<th>ステータス</th>
										<th>返信期限</th>
										<th>選ばれた店舗</th>
										<th>何時から遊びたいか</th>
										<th>来店人数</th>
										<th>予約名</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($list as $data):?>
									<tr>
										<td class="center"><?php echo getParam(course_status_label(),$data['status']);?></td>
										<td class="center"><?php echo $data['dead_time'].'まで';?></td>
										<td class="center"><?php echo $data['decision_store'] == NULL ? 'お客様選択中' : $data['decision_store']; ?></td>
										<td class="center"><?php echo $data['reserved_date'] == 0 ? '' : $data['reserved_date']; ?></td>
										<td><?php echo $data['use_persons'];?></td>
										<td class="center"><?php echo $data['reserved_name'];?></td>
										<td class="center">
											<?php
												$reply_flg = false;
												foreach($reply_id_list as $reply_id=>$reply_store) {
													if($reply_store == $account_id && $reply_id == $data['catchmail_id']) {
														$reply_flg = true;
													}
												}
											?>
											<?php if($reply_flg):?>
											<a class="btn btn-default"></i>返信済み</a>
											<?php elseif($data['decision_store'] != NULL):?>
											<a class="btn btn-default"></i>返信不可</a>
											<?php else:?>
											<a class="btn btn-info" href="?m=edit&id=<?php echo $data['catchmail_id'];?>"><i class="halflings-icon white edit"></i>返信</a>
											<?php endif;?>
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