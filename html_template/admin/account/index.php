
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
<<<<<<< HEAD

		<div class="container-fluid-full">
		<div class="row-fluid">
        <!-- start: Main Menu -->
		<?php include_once dirname(__FILE__).'/../common/main_menu.php';?>
=======
	
		<div class="container-fluid-full">
		<div class="row-fluid">
        <!-- start: Main Menu -->
		<?php include_once dirname(__FILE__).'/../common/main_menu.php';?>	
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
		<!-- end: Main Menu -->
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
<<<<<<< HEAD

=======
			
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
			<!-- start: Content -->
			<!--********** コンテンツはここから **********-->
			<div id="content" class="span10">
				<ul class="breadcrumb">
					<li>
						<i class="icon-home"></i>
<<<<<<< HEAD
						<a href="index.php">Home</a>
=======
						<a href="index.php">Home</a> 
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
						<i class="icon-angle-right"></i>
					</li>
					<li><a href="#"><?php echo $page_title;?></a></li>
				</ul>

<<<<<<< HEAD

				<h1><?php echo $page_title;?></h1>

				<?php echo $system_message;?>

				<!-- 検索フォーム-->
				<div class="row-fluid">
=======
				
				<h1><?php echo $page_title;?></h1>           
 
				<?php echo $system_message;?>
				
				<!-- 検索フォーム-->
				<div class="row-fluid">	
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
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
							<label for="" class="control-label">ユーザー名</label>
							<div class="controls"><input placeholder="" id="" name="account_name" value="<?php echo getGet('account_name');?>" type="text"></div>
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
<<<<<<< HEAD

				<div class="row-fluid">
=======
	
				<div class="row-fluid">	
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>アカウント一覧</h2>
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
							<th>利用</th>
							<th>更新日時</th>
							<th>ユーザー名</th>
							<th>権限</th>
							<th>&nbsp;</th>
						</tr>
<<<<<<< HEAD
						</thead>
=======
						</thead>   
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
						<tbody>
						<?php foreach($list as $accout_data):?>
						<tr>
							<td class="center"><?php echo getParam(account_status_label(),$accout_data['status_id']);?></td>
							<td class="center"><?php echo $accout_data['update_date'];?></td>
							<td><?php echo $accout_data['account_name'];?></td>
							<td class="center"><?php echo getParam(permission_kind(),$accout_data['permission_kind']);?></td>
							<td class="center">
								<a class="btn btn-info" href="?m=edit&id=<?php echo $accout_data['account_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $accout_data['account_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
							</td>
						</tr>
						<?php endforeach;?>
						</tbody>
						</table>
<<<<<<< HEAD


=======
						
						
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
						<?php echo $pager_html;?>
						<?php endif;?>
					</div>
				</div><!--/span-->
				</div><!--/row-->
<<<<<<< HEAD


=======
				
				
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1

			</div><!--/.fluid-container-->
			<!-- end: Content -->
			<!--********** コンテンツはここまで **********-->
<<<<<<< HEAD

		</div><!--/#content.span10-->
		</div><!--/fluid-row-->



=======
			
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	
	
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1
	<div class="clearfix"></div>
	<footer>
		<p>
			<span style="text-align:left;float:left">Copyright 2015 POINT.COM All Rights Reserved </span>
		</p>
	</footer>
	<!-- start: JavaScript-->
	<?php include_once dirname(__FILE__).'/../common/footer_javascript.php';?>
	<!-- end: JavaScript-->
<<<<<<< HEAD


	<!-- start:一覧画面共通処理 -->
	<?php include_once dirname(__FILE__).'/../common/list_common.php';?>
	<!-- end:一覧画面共通処理 -->
=======
	
	
	<!-- start:一覧画面共通処理 -->
	<?php include_once dirname(__FILE__).'/../common/list_common.php';?>
	<!-- end:一覧画面共通処理
>>>>>>> 8b811614851e122202fd4d35258457ee0babb1f1

</body>
</html>