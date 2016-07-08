<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>キャッチメール｜ポイント.com</title>
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
		<script type="text/javascript" src="../maintenance/js/category_area.js"></script>

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
		</script>
	</head>
	<body id="register">
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
						<h2>キャッチメール</h2>
						<form method="post" action="" name="frm">
						<input type="hidden" name="m" value="confirm" />
							<h3><span class="clrred">※</span> 何時から遊びたいか（希望時刻）</h3>
							<p>
								<?php foreach(time_kind() as $val_key => $val_name):?>
									<input type="radio" value="<?php echo $val_key;?>" name="time_kind" id="<?php echo $val_key;?>" <?php echo _check_checked($val_key, getParam($post, 'time_kind'));?> onchange="onTime_KindChange();	"/>
									<label for="<?php echo $val_key;?>"><?php echo $val_name;?></label><br>
								<?php endforeach;?>
							</p>
							<p>
								<select id="use_time" name="use_time" disabled>
								<?php foreach($use_time_list as $time_num=>$time_val):?>
									<option value="<?php echo $time_num;?>" <?php echo _check_selected($time_num, getParam($post,'use_time'));?>><?php echo $time_val;?></option>
								<?php endforeach;?>
								</select>
								時
								<select id="use_min" name="use_min" disabled>
								<?php foreach($use_min_list as $min_num=>$min_val):?>
									<option value="<?php echo $min_num;?>" <?php echo _check_selected($min_num, getParam($post,'use_min'));?>><?php echo $min_val;?></option>
								<?php endforeach;?>
								</select>
								分
								頃〜
							</p>
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

							<h3><span class="clrred">※</span> 予約名</h3>
							<p>
								<input name="reserved_name" type="text" id="reserved_name" size="20" style="width:90%;" value="<?php echo getParam($post, 'reserved_name');?>"/>
								<?php echo getParam($error, 'reserved_name'); ?>
							</p>
							<h3><span class="clrred">※</span> 都道府県</h3>
							<p>
								<select id="area_first_prefectures_id" name="area_first_prefectures_id">
									<option value="">選択してください</option>
									<?php foreach(prefectures_master() as $val_key => $val_name):?>
									<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_first_id'));?>><?php echo $val_name;?></option>
									<?php endforeach;?>
								</select>
								<?php echo getParam($error, 'area_first_id');?>
							</p>
							<h3><span class="clrred">※</span> ジャンル</h3>
							<p>
								<select id="category_large_id" name="category_large_id">
									<option value="">選択してください</option>
									<?php foreach(category_large() as $val_key => $val_name):?>
									<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_large_id'));?>><?php echo $val_name;?></option>
									<?php endforeach;?>
								</select>
								<?php echo getParam($error, 'category_large_id');?>
							</p>
							<h3><span class="clrred">※</span> カテゴリ</h3>
							<p>
								<select id="category_midium_id" name="category_midium_id">
									<option value="">選択してください</option>
									<?php foreach(category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_id'), is_delivery(getParam($post, 'type_of_industry_id'))) as $val_key => $val_name):?>
									<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_midium_id'));?>><?php echo $val_name;?></option>
									<?php endforeach;?>
								</select>
								<?php echo getParam($error, 'category_midium_id');?>
							</p>
							<h3><span class="clrred">※</span> エリア</h3>
							<p>
								<select id="area_second_id" name="area_second_id">
									<option value="">選択してください</option>
									<?php foreach(area_second_to_extend(getParam($post, 'category_large_id'), getParam($post, 'area_first_id'), is_delivery(getParam($post, 'type_of_industry_id'))) as $val_key => $val_name):?>
									<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_second_id'));?>><?php echo $val_name;?></option>
									<?php endforeach;?>
								</select>
								<?php echo getParam($error, 'area_second_id');?>
							</p>
							<h3><span class="clrred">※</span> 詳細エリア</h3>
							<p>
								<select id="area_third_id" name="area_third_id">
									<option value="">選択してください</option>
									<?php foreach(area_third(getParam($post, 'area_second_id')) as $val_key => $val_name):?>
									<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_third_id'));?>><?php echo $val_name;?></option>
									<?php endforeach;?>
								</select>
								<?php echo getParam($error, 'area_third_id');?>
							</p>


							<p>
								<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a>
							</p>
							<input type="hidden" id="type_of_industry_id" name="type_of_industry_id" value="0">
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
		<script>
		$(function(){
			window.onload = function() {
				onTime_KindChange();
				$('#area_first_prefectures_id').changeUpperItem({
					url:'/catch/index.php?m=change_upper_item',
					name:'area_first_id'});
			}

//			$('#area_first_id').change(function() {
//				$('#area_first_id').changeUpperItem({
//					url:'/catch/index.php?m=change_upper_item',
//					name:'area_first_id'});
//			});

			$('#category_large_id').change(function() {
				$('#category_large_id').changeUpperItem({
					url:'/catch/index.php?m=change_upper_item',
					name:'category_large_id'});
			});

			$('#area_second_id').change(function() {
				$('#area_second_id').changeAreaSecond({
					url:'/catch/index.php?m=change_area_second',
					name:'area_second_id',
					selected:$(this).val()});
			});
		});

		function onTime_KindChange() {
			radio0 = document.getElementById("0");
			radio1 = document.getElementById("1");

			target_time = document.getElementById("use_time");
			target_min = document.getElementById("use_min");

			if(radio0.checked == true) {
				target_time.disabled = true;
				target_min.disabled = true;
			} else if(radio1.checked == true) {
				target_time.disabled = false;
				target_min.disabled = false;
			}
		}
		</script>
	</body>
</html>