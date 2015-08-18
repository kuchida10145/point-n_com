
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
					<li><a href="account.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
					<li><a href="#"><?php echo $page_type_text;?></a></li>
					
					
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
						<form class="form-horizontal" action="?m=edit&tkn=<?php echo getGet('tkn');?>" method="post">
							<input type="hidden" value="edit" name="m">
                            <div class="control-group <?php echo error_class(getParam($error,'add_point'));?>">
								<label class="control-label" for="typeahead">金額 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="add_point" value="<?php echo getParam($post,'add_point');?>" type="text" >円
									<?php echo getParam($error,'add_point');?>
								</div>
							</div>
                            
                            <div class="control-group <?php echo error_class(getParam($error,'add_date'));?>">
								<label class="control-label" for="typeahead">入金日 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input type="text" class="input-xlarge datepicker" id="date01" name="add_date" value="<?php echo getParam($post, 'add_date');?>">
									<?php echo getParam($error,'add_date');?>
								</div>
							</div>
                                                       
                            <div class="control-group <?php echo error_class(getParam($error,'add_type'));?>">
								<label class="control-label" for="typeahead">種類 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="add_type">
										<option value="1" <?php echo _check_selected(1,getParam($post,'add_type'));?>>前払い</option>
										<option value="2" <?php echo _check_selected(2,getParam($post,'add_type'));?>>後払い</option>
									</select>
									<?php echo getParam($error,'add_type');?>
								</div>
							</div>
                                  
							<div class="control-group <?php echo error_class(getParam($error,'memo'));?>">
								<label class="control-label" for="selectError3">メモ <span class="label label-important">必須</span></label>
								<div class="controls">
									<textarea name="memo" rows="5" style="width: 90%"><?php echo getParam($post,'memo');?></textarea>
								</div>
							</div>
                            
							<div class="control-group <?php echo error_class(getParam($error,'review_status'));?>">
							<label class="control-label" for="selectError3">利用 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="review_status">
										<option value="0" <?php echo _check_selected(0,getParam($post,'review_status'));?>>未承認</option>
										<option value="1" <?php echo _check_selected(1,getParam($post,'review_status'));?>>承認</option>
									</select>
									<?php echo getParam($error,'add_type');?>
								</div>
							</div>
                             
                              
                            <div class="form-actions">
								<button class="btn btn-primary" type="submit">確認画面へ</button>
								<button type="button" onclick="location.href='account.php'" class="btn">戻る</button>
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