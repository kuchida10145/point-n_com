<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>予約｜ポイント.com</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>

		<!--[if lte IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
		<![endif]-->


		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/obj.js"></script>
		<script type="text/javascript" src="../js/font-size.js"></script>
		<script type="text/javascript" src="../js/smooth.pack.js"></script>
		<script type="text/javascript" src="../js/acc.js"></script>

		<!--スライドメニュー-->
		<script src="../js/sidr/jquery.sidr.min.js"></script>
		<link rel="stylesheet" href="../js/sidr/jquery.sidr.light.css">

		<!--datepicker -->
		<link href="../js/calendar/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		<script src="../js/calendar/jquery-ui.min.js"></script>
		<script src="../js/calendar/jquery.ui.core.min.js"></script>
		<script src="../js/calendar/jquery.ui.datepicker.min.js"></script>
		<script src="../js/calendar/jquery.ui.datepicker-ja.min.js"></script>

		<script type="text/javascript">
		$(function() {
		    $('#date_from').datepicker({
		        dateFormat: 'yy-mm-dd',//年月日の並びを変更
		    });
			$('#date_return').datepicker({
		        dateFormat: 'yy-mm-dd',//年月日の並びを変更
		    });
		});
		$(function() {
		    $('select').change(function(){
		        var cor_price = $(this).find(':selected').data('id');
		        $('#price').html(cor_price);
		    });
		});
		</script>
	</head>
	<body id="register">
	<?php include_once dirname(__FILE__).'/../common/analyticstracking.php';?>
		<!--全体-->
		<div id="wrap">
			<a name="top" id="top"></a>
			<!--ヘッダ-->
			<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
			<?php include_once dirname(__FILE__).'/../common/header_search.php';?>

			<!--ヘッダ-->
				<!--メイン全体-->
				<div id="mainbodywrap">
				<!--ページメイン部分-->
				<div id="mainbody" class="clearfix">
					<!--コンテンツ-->
					<div class="contents">
						<strong class="clrred"><?php echo $system_message;?></strong>
						<h2>予約画面</h2>
						<form method="post" action="" name="frm">
						<input type="hidden" name="m" value="confirm" />
							<h3><span class="clrred">※</span> コース選択</h3>
							<p>
								<label for="store_name">利用店名 <strong><?php echo $store_name;?></strong></label>
							</p>
							<p>
								<select name="course_id">
								<option value="" data-id="">選択してください。</option>
								<?php foreach(course_list($store_id, 1) as $cor_num=>$cor_val):?>
										<option value="<?php echo $cor_num;?>" data-id="<?php echo number_format(getParam($course_price, $cor_num));?>"<?php echo _check_selected($cor_num, getParam($post,'use_persons'));?>><?php echo $cor_val;?></option>
								<?php endforeach;?>
								</select>
							</p>
							<?php echo getParam($error, 'course_id'); ?>

							<h3><span class="clrred">※</span> 来客人数</h3>
								<p>
									<select name="use_persons">
									<?php foreach(reservation_person_cnt() as $per_num=>$per_val):?>
										<option value="<?php echo $per_num;?>" <?php echo _check_selected($per_num, getParam($post,'use_persons'));?>><?php echo $per_val;?></option>
									<?php endforeach;?>
									</select>
									人
									<?php echo getParam($error, 'use_persons'); ?>
								</p>
							<h3><span class="clrred">※</span> 来店日</h3>
								<p>
									<input name="use_date" id="date_from" class="w80p fltleft" value="<?php echo getParam($post, 'use_date');?>" title="来店日" type="text" readonly="readonly"><a class="calenderbox"  onclick="$('#date_from').focus();"><span class="icon-calendar"></span></a>
								<br /><?php echo getParam($error, 'use_date'); ?><br />
							<h3><span class="clrred">※</span> 利用時間（到着時刻）</h3>
								<p>
									<select name="use_time">
									<?php foreach(reservation_list(MAX_USE_TIME) as $time_num=>$time_val):?>
										<option value="<?php echo $time_num;?>" <?php echo _check_selected($time_num, getParam($post,'use_time'));?>><?php echo $time_val;?></option>
									<?php endforeach;?>
									</select>
									時
									<select name="use_min">
									<?php foreach(reservation_list(MAX_USE_MIN) as $min_num=>$min_val):?>
										<option value="<?php echo $min_num;?>" <?php echo _check_selected($min_num, getParam($post,'use_min'));?>><?php echo $min_val;?></option>
									<?php endforeach;?>
									</select>
									分
								</p>
							<h3><span class="clrred">※</span> 予約名</h3>
								<p>
									<input name="reserved_name" type="text" id="reserved_name" size="20" style="width:90%;" value="<?php echo getParam($post, 'reserved_name');?>"/>
									<?php echo getParam($error, 'reserved_name'); ?>
								</p>
							<h3><span class="clrred">※</span> 予約した電話番号</h3>
								<p>
									<input name="telephone1" type="text" id="telephone1" size="5" value="<?php echo getParam($post, 'telephone1');?>"/>
									-
									<input name="telephone2" type="text" id="telephone2" size="5" value="<?php echo getParam($post, 'telephone2');?>"/>
									-
									<input name="telephone3" type="text" id="telephone3" size="5" value="<?php echo getParam($post, 'telephone3');?>"/>
									<?php if(getParam($error, 'telephone1') != ''): ?>
										<?php echo getParam($error, 'telephone1'); ?>
									<?php elseif(getParam($error, 'telephone2') != ''): ?>
										<?php echo getParam($error, 'telephone2'); ?>
									<?php elseif(getParam($error, 'telephone3') != ''): ?>
										<?php echo getParam($error, 'telephone3'); ?>
									<?php endif; ?>
								</p>
							<h3>利用料金</h3>
								<p>
									<span id="price"></span>
								円</p>
							<h3>利用するポイント</h3>
								<p>
									<select name="use_point">
									<?php foreach($point_list as $poi_num=>$poi_val):?>
										<option value="<?php echo $poi_num;?>" <?php echo _check_selected($poi_num, getParam($post,'use_point'));?>><?php echo $poi_val;?></option>
									<?php endforeach;?>
									</select>
									 PT
									<?php echo getParam($error, 'use_point'); ?>
								</p>
							<h3><span class="clrred">※</span> 個人情報取得への同意</h3>
								<p>
									<input type="checkbox" name="contract" id="contract" />
									同意する
									<?php echo getParam($error, 'contract'); ?>
								</p>
							<div align="center">
								<a href="../info/kojin.html">個人情報の取得はこちら</a><br /><br />
								<p>上記の入力内容を確認して「確認画面へ」ボタンを押してください</p>
							</div>
							<p>
								<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a>
							</p>
						</form>
					</div>
					<!--/コンテンツ-->
					<div id="footer">
						<address>
							Copyright 2015 POINT.COM All Rights Reserved
						</address>
					</div>
				</div>
				<!--/ページメイン部分-->
			</div>
			<!--/メイン全体-->
		</div>
		<!--/全体-->
		<!--スライド-->
		<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
		<!-- /スライド-->
	</body>
</html>