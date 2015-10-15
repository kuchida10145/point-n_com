
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
									<span style="color:blue"><?php echo number_format($bill_data['issue_point']);?>円分</span>
								</div>
							</div>
							 <div class="control-group">
								<label class="control-label" for="typeahead">発行ポイント手数料</label>
								<div class="controls">
									<span style="color:blue"><?php echo number_format($bill_data['issue_commission']);?>円分</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">利用ポイント</label>
								<div class="controls">
									<span style="color:red"><?php echo number_format($bill_data['use_total']);?>円分</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">発行ポイントキャンセル</label>
								<div class="controls">
									<span style="color:red"><?php echo number_format($bill_data['cancel_point']);?>円分</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">発行ポイント手数料<br />キャンセル</label>
								<div class="controls">
									<span style="color:red"><?php echo number_format($bill_data['cancel_point']);?>円分</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">利用ポイントキャンセル</label>
								<div class="controls">
									<span style="color:blue"><?php echo number_format($bill_data['use_total_cancel']);?>円分</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">前払い</label>
								<div class="controls">
									<span style="color:red"><?php echo number_format($bill_data['deposit_price']);?>円</span>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">調整</label>
								<div class="controls">
									<span style="color:<?php if(getParam($post, 'adjust_price',0) < 0): echo'red'; else: echo 'blue'; endif;?>"><?php echo number_format(getParam($post, 'adjust_price',0));?>円</span>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="typeahead">合計</label>
								<div class="controls">
									<span id="total_price"></span>
								</div>
							</div>                 
                           
                                  
							<div class="control-group">
								<label class="control-label" for="selectError3">メモ</label>
								<div class="controls">
									<?php echo str_replace("\r\n","<br>\r\n",getParam($post,'memo'));?>
								</div>
							</div>
                            
							<div class="control-group">
							<label class="control-label" for="selectError3">状況 <span class="label label-important">必須</span></label>
								<div class="controls"><?php echo getParam(pay_status(),getParam($post,'pay_status'));?>
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
	<script type="text/javascript">
	$(function(){
		var adjust_price = parseInt(<?php echo $post['adjust_price'];?>);
		var issue_point        = <?php echo $bill_data['issue_point'];?>;
		var use_point          = <?php echo $bill_data['use_total'];?>;
		var issue_point_cancel = <?php echo $bill_data['cancel_point'];?>;
		var use_point_cancel = <?php echo $bill_data['use_total_cancel'];?>;
		var deposit_price      = <?php echo $bill_data['deposit_price'];?>;
		var cancel_commission  = <?php echo $bill_data['cancel_commission'];?>;
		var issue_commission   = <?php echo $bill_data['issue_commission'];?>;
		function calculate(){
			
			//払い戻し合計
			var return_price = use_point+issue_point_cancel+deposit_price+cancel_commission;
			var total = issue_commission+issue_point-return_price+adjust_price+use_point_cancel;
			var number_format = separate(total);
			
			if(total < 0){
				number_format = '<span style="color:red">'+number_format+'円</span>';
			}
			else{
				number_format = '<span style="color:blue">'+number_format+'円</span>';
			}
			
			$('#total_price').html(number_format);
			
		}
		calculate();
		
		
		
		// 正規表現でセパレート
		function separate(num){
			return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
		}
	});
	</script>
	<!-- end: JavaScript-->
</body>
</html>