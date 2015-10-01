
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?> <?php echo $page_type_text;?>｜Point.com管理画面</title>
	<?php include_once dirname(__FILE__).'/../common/head.php';?>

	<script type="text/javascript" src="../../../js/jquery.js"></script>

	<script type="text/javascript">
		$(function() {
		    $('select').change(function(){
		        var cor_price = $(this).find(':selected').data('price');
		        var cor_minutes = $(this).find(':selected').data('minutes');
		        $('#course_price').html(cor_price);
		        $('#course_minutes').html(cor_minutes);
		        document.getElementById("hidden_minutes").value = cor_minutes;
		        document.getElementById("hidden_price").value = cor_price;
		    });
		});
	</script>
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
					<li><a href="coupon.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
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
							<div class="control-group <?php echo error_class(getParam($error,'coupon_name'));?>">
								<label for="title" class="control-label">クーポン名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input class="input-block-level" placeholder="" name="coupon_name" value="<?php echo getParam($post,'coupon_name');?>" type="text">
									<?php echo getParam($error,'coupon_name');?>
									<br>
									店舗様側で管理しやすいクーポン名を入力してください。　例）通常コース60分のクーポン
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error,'point'));?>">
								<label class="control-label" for="control-label">ポイント数 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="point">
										<?php foreach(point_data() as $point_num=>$point_val):?>
											<option value="<?php echo $point_num;?>" <?php echo _check_selected($point_num, getParam($post,'point'));?>><?php echo $point_val;?></option>
										<?php endforeach;?>
									</select>
									1pt=1円
									<br>
									<?php echo $claim_msg;?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error,'course_id'));?>">
								<label class="control-label" for="control-label">発行するコース <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="course_id">
										<option value="" data-price="-" data-minutes="-">選択してください。</option>
										<?php foreach(course_list($store_id) as $cou_id=>$cou_name):?>
											<option value="<?php echo $cou_id;?>"
											data-price="<?php echo number_format(getParam($course_price, $cou_id));?>"
											data-minutes="<?php echo number_format(getParam($course_minutes, $cou_id));?>"
											<?php echo _check_selected($cou_id, getParam($post,'course_id'));?>>
												<?php echo $cou_name;?>
											</option>
										<?php endforeach;?>
									</select>
									<br>
									<?php echo getParam($error,'course_id');?>
									<input type="hidden" value="<?php echo $store_id;?>" name="store_id">
									<input type="hidden" value="<?php echo $p;?>" name="p">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="control-label">コース基本情報</label>
								<div class="controls">
									利用時間 <span id="course_minutes"><?php echo getParam($post,'course_minutes');?></span> 分
									<input type="hidden" id="hidden_minutes" value="" name="course_minutes">
								</div>
								<div class="controls">
									利用料金 <span id="course_price"><?php echo getParam($post,'course_price');?></span> 円
									<input type="hidden" id="hidden_price" value="" name="course_price">
								</div>
							</div>

							<?php if(getParam($error,'minutes')!=''):?>
                            <div class="control-group <?php echo error_class(getParam($error,'price'));?>">
                            <?php elseif(getParam($error,'price')!=''):?>
                            <div class="control-group <?php echo error_class(getParam($error,'price'));?>">
                            <?php else:?>
                            <div class="control-group">
                            <?php endif;?>
								<label class="control-label" for="control-label">クーポンを使用した場合の時間・料金 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="minutes" value="<?php echo getParam($post,'minutes');?>" style="width:70px;">分
									<input placeholder="" name="price" value="<?php echo getParam($post,'price');?>" style="width:100px;">円
									<br>
									<?php if (getParam($error,'minutes')):?>
										<?php echo getParam($error,'minutes');?>
									<?php elseif (getParam($error,'price')):?>
										<?php echo getParam($error,'price');?>
									<?php endif;?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error,'use_condition'));?>">
								<label class="control-label" for="use_condition">ご利用条件 <span class="label label-important">必須</span></label>
								<div class="controls">
									<textarea class="ckeditor" name="use_condition" id="use_condition" rows="3"><?php echo getParam($post,'use_condition');?></textarea>
									<?php echo textarea_caution_msg();?>
									<?php echo getParam($error,'use_condition');?>
								</div>
							</div>

                            <div class="form-actions">
								<button class="btn btn-primary" type="submit">確認画面へ</button>
								<button type="button" onclick="location.href='coupon.php'" class="btn">戻る</button>
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