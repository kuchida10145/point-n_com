<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>キャッチメール　|　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/html_template/pc/css/slick.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/fixHeight.js" type="text/javascript"></script>
<script type="text/javascript" src="../maintenance/js/category_area.js"></script>
</head>

<body id="genre" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div class="container">
	<div class="mainbodybg01">
		<!--mainbody-->
		<div class="mainbody">
			<p class="ID_mane">会員NO.123456</p>
			<div class="contents clearfix">
				<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>
				<div class="shiborikomi_page02 reservation_use_point">
					<strong class="clrred"><?php echo $system_message;?></strong>
					<div class="shiborikomi_step">
						<p class="heartitle">キャッチメール登録</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb30">キャッチメール</h3>
							<form method="post" action="" name="frm">
								<input type="hidden" name="m" value="confirm" />
								<div class="mb25">
									<h4>何時から遊びたいか（希望時刻）<span class="clrred">※</span></h4>
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
										分頃〜
									</p>
								</div>
								<div class="mb25">
									<h4>来客人数<span class="clrred">※</span> </h4>
									<p>
										<select name="use_persons">
										<?php foreach(reservation_person_cnt() as $per_num=>$per_val):?>
											<option value="<?php echo $per_num;?>" <?php echo _check_selected($per_num, getParam($post,'use_persons'));?>><?php echo $per_val;?></option>
										<?php endforeach;?>
										</select>
										人
										<?php echo getParam($error, 'use_persons'); ?>
									</p>
								</div>
								<div class="mb25">
									<h4>予約名<span class="clrred">※</span></h4>
									<p>
										<input name="reserved_name" type="text" id="reserved_name" size="20" style="width:90%;" value="<?php echo getParam($post, 'reserved_name');?>"/>
										<?php echo getParam($error, 'reserved_name'); ?>
									</p>
								</div>
								<div class="mb25">
									<h4>都道府県<span class="clrred">※</span> </h4>
									<p>
										<select id="area_first_prefectures_id" name="area_first_prefectures_id">
										<?php foreach(prefectures_master() as $val_key => $val_name):?>
											<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_first_prefectures_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
										</select>
										<?php echo getParam($error, 'category_large_id');?>
									</p>
								</div>
								<div class="mb25">
									<h4>ジャンル<span class="clrred">※</span> </h4>
									<p>
										<select id="category_large_id" name="category_large_id">
											<option value="">選択してください</option>
											<?php foreach(category_large() as $val_key => $val_name):?>
											<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_large_id'));?>><?php echo $val_name;?></option>
											<?php endforeach;?>
										</select>
										<?php echo getParam($error, 'category_large_id');?>
									</p>
								</div>
								<div class="mb25">
									<h4>カテゴリ<span class="clrred">※</span> </h4>
									<p>
										<select id="category_midium_id" name="category_midium_id">
											<option value="">選択してください</option>
											<?php foreach(category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), is_delivery(getParam($post, 'type_of_industry_id'))) as $val_key => $val_name):?>
											<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_midium_id'));?>><?php echo $val_name;?></option>
											<?php endforeach;?>
										</select>
										<?php echo getParam($error, 'category_midium_id');?>
									</p>
								</div>
								<div class="mb25">
									<h4>エリア<span class="clrred">※</span> </h4>
									<p>
										<select id="area_second_id" name="area_second_id">
											<option value="">選択してください</option>
											<?php foreach(area_second_to_extend(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), is_delivery(getParam($post, 'type_of_industry_id'))) as $val_key => $val_name):?>
											<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_second_id'));?>><?php echo $val_name;?></option>
											<?php endforeach;?>
										</select>
										<?php echo getParam($error, 'area_second_id');?>
									</p>
								</div>
								<div class="mb25">
									<h4>詳細エリア<span class="clrred">※</span> </h4>
									<p>
										<select id="area_third_id" name="area_third_id">
											<option value="">選択してください</option>
											<?php foreach(area_third(getParam($post, 'area_second_id')) as $val_key => $val_name):?>
											<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_third_id'));?>><?php echo $val_name;?></option>
											<?php endforeach;?>
										</select>
										<?php echo getParam($error, 'area_third_id');?>
									</p>
								</div>
								<p class="stopr_linkbtn">
									<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a>
								</p>
								<input type="hidden" id="type_of_industry_id" name="type_of_industry_id" value="0">
							</form>
						</div>
					</div>
				</div>
			</div><!--/.contents-->
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
</body>
<script>
$(function(){
	window.onload = function() {
		onTime_KindChange();
		$('#area_first_prefectures_id').changeUpperItem({
			url:'/catch/index.php?m=change_upper_item',
			name:'area_first_id'});
	}

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
</html>
