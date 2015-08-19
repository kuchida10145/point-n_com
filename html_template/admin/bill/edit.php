
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
                           
							<div class="control-group">
								<label class="control-label" for="typeahead">年月</label>
								<div class="controls">
									<?php echo $bill_data['bill_month'];?>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="typeahead">店舗名</label>
								<div class="controls">
									<?php echo $bill_data['store_name'];?>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="typeahead">発行ポイント</label>
								<div class="controls">
									<?php echo number_format($bill_data['issue_point']);?>円分
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">利用ポイント</label>
								<div class="controls">
									<?php echo number_format($bill_data['use_point']);?>円分
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">前月キャンセル</label>
								<div class="controls">
									<?php echo number_format($bill_data['before_cancel']);?>円分
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">前払い</label>
								<div class="controls">
									<?php echo number_format($bill_data['deposit_price']);?>円
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">調整</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="date01" name="adjust_price" value="<?php echo getParam($post, 'adjust_price');?>">円
									<?php echo getParam($error,'adjust_price');?>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="typeahead">合計</label>
								<div class="controls">
									<span id="total_price"></span>
								</div>
							</div>                 
                           
                                  
							<div class="control-group <?php echo error_class(getParam($error,'memo'));?>">
								<label class="control-label" for="selectError3">メモ</label>
								<div class="controls">
									<textarea name="memo" rows="5" style="width: 90%"><?php echo getParam($post,'memo');?></textarea>
								</div>
							</div>
                            
							<div class="control-group <?php echo error_class(getParam($error,'review_status'));?>">
							<label class="control-label" for="selectError3">状況 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="pay_status">
										<option value="0" <?php echo _check_selected(0,getParam($post,'pay_status'));?>>未確定</option>
										<option value="1" <?php echo _check_selected(1,getParam($post,'pay_status'));?>>未入金</option>
										<option value="2" <?php echo _check_selected(2,getParam($post,'pay_status'));?>>入金</option>
									</select>
									<?php echo getParam($error,'pay_status');?>
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
	<script type="text/javascript">
	$(function(){
		var issue_point   = <?php echo $bill_data['issue_point'];?>;
		var use_point     = <?php echo $bill_data['use_point'];?>;
		var before_cancel = <?php echo $bill_data['before_cancel'];?>;
		var deposit_price = <?php echo $bill_data['deposit_price'];?>;
		
		function calculate(){
			var adjust_price = parseInt($('[name=adjust_price]').val());
			//払い戻し合計
			var return_price = use_point+before_cancel+deposit_price;
			var total = issue_point-return_price+adjust_price;
			
			$('#total_price').html(separate(total)+"円");
			
		}
		calculate();
		$('[name=adjust_price]').blur(calculate);
		
		
		// 正規表現でセパレート
		function separate(num){
			return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
		}
	});
	</script>
	<!-- end: JavaScript-->
</body>
</html>