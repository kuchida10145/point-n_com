
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
					<li><?php echo $page_title;?></li>
					
					
				</ul>

				
				<h1><?php echo $page_title;?></h1>           
 
				<?php echo $system_message;?>
            
				<div class="row-fluid">
					<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $page_type_text;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
						
					<div class="box-content">
						<form class="form-horizontal" action="" method="post">
							<input type="hidden" value="profile" name="m">
                            <div class="control-group <?php echo error_class(getParam($error,'account_name'));?>">
								<label class="control-label" for="typeahead">ユーザー名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="account_name" value="<?php echo getParam($post,'account_name');?>" type="text" class="input-block-level">
									<?php echo getParam($error,'account_name');?>
								</div>
							</div>
                            
                            <div class="control-group <?php echo error_class(getParam($error,'login_id'));?>">
								<label class="control-label" for="typeahead">ログインID <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="6～12文字の半角英数字" name="login_id" value="<?php echo getParam($post,'login_id');?>" type="text">
									<?php echo getParam($error,'login_id');?>
								</div>
							</div>
                                                       
                            <div class="control-group <?php echo error_class(getParam($error,'login_password'));?>">
								<label class="control-label" for="typeahead">ログインPW <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="4～8文字の半角英数字" name="login_password" value="<?php echo getParam($post,'login_password');?>" type="password">
									<?php echo getParam($error,'login_password');?>
								</div>
							</div>
                                  
							<div class="control-group <?php echo error_class(getParam($error,'permission_kind'));?>">
								<label class="control-label" for="selectError3">権限 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="permission_kind">
										<?php foreach(permission_kind() as $per_id => $per_name):?>
										<option value="<?php echo $per_id;?>" <?php echo _check_selected($per_id,getParam($post,'permission_kind'));?>><?php echo $per_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
                            
							<div class="control-group <?php echo error_class(getParam($error,'status_id'));?>">
							<label class="control-label" for="selectError3">利用 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="status_id">
										<?php foreach(account_status() as $status_id => $status_name):?>
										<option value="<?php echo $status_id;?>" <?php echo _check_selected($status_id,getParam($post,'status_id'));?>><?php echo $status_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
                             
                              
                            <div class="form-actions">
								<button class="btn btn-primary" type="submit">保存</button>
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