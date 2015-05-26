<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?> <?php echo $page_type_text;?>｜Point.com管理画面</title>
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
					<li><a href="user.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
					<li><a href="#"><?php echo $page_type_text;?></a></li>
					
					
				</ul>
				
				<h1><?php echo $page_title;?></h1>
				
				<div class="row-fluid">
					<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $page_type_text;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
						
					<div class="box-content">
						<form class="form-horizontal" action="?m=confirm&tkn=<?php echo getGet('tkn');?>" method="post">
							<input type="hidden" value="confirm" name="m">
							

							<div class="control-group">
								<label for="" class="control-label">登録日</label>
								<div class="controls">
									<?php echo isset( $regist_date ) ? $regist_date : '新規登録時に自動入力'; ?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="">会員番号</label>
								<div class="controls">
									<?php echo isset( $user_id ) ? $user_id : '新規登録時に自動入力'; ?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="">メールアドレス<br />（ログインID）</label>
								<div class="controls">
									<?php echo getParam($post, 'email');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="">ニックネーム</label>
								<div class="controls">
									<?php echo getParam($post, 'nickname');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="">誕生日</label>
								<div class="controls">
									<?php echo getParam($post, 'birthday');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="gender">性別</label>
								<div class="controls">
									<?php echo getParam(user_gender(), getParam($post, 'gender'))?>
								</div>
						  </div>

							<div class="control-group">
								<label class="control-label" for="">都道府県</label>
								<div class="controls">
									<?php echo getParam(prefectures_master(), getParam($post, 'prefectures_id'));?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="">パスワード</label>
								<div class="controls">設定したパスワード</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="">ステータス</label>
								<div class="controls">
									<?php echo getParam(user_status(), getParam($post, 'status_id'));?>
								</div>
							</div>		
							
							<div class="form-actions">
								<button class="btn btn-primary" type="submit">保存</button>
								<button type="button" onclick="location.href='?m=edit&tkn=<?php echo getGet('tkn');?>'" class="btn">戻る</button>
							</div>
						</form>
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
</body>
</html>