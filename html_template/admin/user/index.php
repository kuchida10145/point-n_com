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
							<span class="control-label" for="status_id">ステータス</span>
							<div class="controls">
									<?php foreach(user_status_label() as $val_key => $val_name) :?>
										<label>
											<input type="checkbox" id="" value="true" name="<?php echo $val_key ?>" <?php echo getGet($val_key) ? 'checked' : '' ?>  />
											<?php echo $val_name;?>
										</label>
									<?php endforeach; ?>
								※無効にした場合、このサイトにログインができなくなり、サイトのサービスが利用できなくなります。
							</div>
						</div>
						<div class="control-group">
							<label for="user_id" class="control-label">会員番号</label>
							<div class="controls"><input placeholder="" id="nickname" name="user_id" value="<?php echo getGet('user_id');?>" type="text">※完全一意</div>
						</div>
						<div class="control-group">
							<label for="nickname" class="control-label">ニックネーム名</label>
							<div class="controls"><input placeholder="" id="nickname" name="nickname" value="<?php echo getGet('nickname');?>" type="text"></div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">日付</label>
							<div class="controls">
								<input type="text" class="input-xlarge datepicker" id="from-date" value="<?php echo getGet('from-date');?>" name="from-date">
								～
								<input type="text" class="input-xlarge datepicker" id="to-date" value="<?php echo getGet('to-date');?>" name="to-date">
							</div>
						</div> 
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">検索</button>
							<button type="reset" class="btn" onclick="location.href='user.php'">リセット</button>
						</div>
                        </form>
                    </div>
					</div><!--/span-->
				</div><!--/row-->
				<!-- /検索フォーム -->
				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>会員情報登録一覧</h2>
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
							<th>登録日</th>
							<th>会員番号</th>
							<th>メールアドレース（ID）</th>
							<th>ニックネーム</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($list as $data):?>
						<tr>
							<td><?php echo getParam(user_status_label(), $data['status_id']); ?></td>
							<td style="word-break: break-all;"><?php echo date( 'Y/m/d', strtotime( $data['regist_date'] ) ); ?></td>
							<td style="word-break: break-all;"><?php echo $data['user_id']; ?></td>
							<td style="word-break: break-all;"><?php echo $data['email']; ?></td>
							<td style="word-break: break-all;"><?php echo $data['nickname']; ?></td>
							<td>
								<a class="btn btn-info" href="?m=edit&id=<?php echo $data['user_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $data['user_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
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