<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>予約画面　|　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/fixHeight.js" type="text/javascript"></script>
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
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">利用店名:<?php echo $store_name;?></p>
					</div>
					<div class="shiborikomi_genre">
			    		<div class="shiborikomi_genre_02 reservation_use_point">
			    			<strong class="clrred"><?php echo $system_message;?></strong>
							<h3 class="mb30">予約画面</h3>
							<form method="post" action="" name="frm">
								<input type="hidden" name="m" value="confirm" />
								<div class="mb25">
									<p class="course_point"><label for="get_point">今回の獲得PT　<span class="clrred"><?php echo $get_point;?>PT</span></label></p>
									<p><label for="course_name">コース名 <strong><?php echo $course_name;?></strong></label></p>
									<p><label for="store_name">利用店名 <strong><?php echo $store_name;?></strong></label></p>
								</div>
								<div class="mb25">
									<h4>来客人数<span class="clrred">※</span></h4>
									<p>
										<select name="use_persons">
										<?php foreach(reservation_person_cnt() as $per_num=>$per_val):?>
											<option value="<?php echo $per_num;?>" <?php echo _check_selected($per_num, getParam($post,'use_persons'));?>><?php echo $per_val;?></option>
										<?php endforeach;?>
										</select>
										人
									</p>
								</div>
								<div class="mb25">
									<h4>来店日<span class="clrred">※</span></h4>
									<p>
										<input name="use_date" id="date_from" value="" title="来店日" value="<?php echo getParam($post, 'use_date');?>" type="text" readonly="readonly">
										<a class="calenderbox"  onclick="$('#date_from').focus();">
											<span class="icon-calendar"></span>
										</a>
									</p>
								</div>
								<div class="mb25">
									<h4>利用時間（到着時刻）<span class="clrred">※</span></h4>
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
								</div>
								<div class="mb25">
									<h4>予約名<span class="clrred">※</span></h4>
									<p>
										<input name="reserved_name" type="text" id="reserved_name" size="20" style="width:90%;" value="<?php echo getParam($post, 'reserved_name');?>"/>
										<?php echo getParam($error, 'reserved_name'); ?>
									</p>
								</div>
								<div class="mb25">
									<h4>予約した電話番号<span class="clrred">※</span></h4>
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
								</div>
								<div class="mb25">
									<h4>利用料金</h4>
									<p>
										<span id="price"><?php echo getParam($post, 'price', $price);?></span>円
									</p>
									<input type="hidden" value="<?php echo $price;?>" name="price">
								</div>
								<div class="mb25">
									<h4>利用するポイント</h4>
									<p>
										<select name="use_point">
											<?php foreach($point_list as $poi_num=>$poi_val):?>
												<option value="<?php echo $poi_num;?>" <?php echo _check_selected($poi_num, getParam($post,'use_point'));?>><?php echo $poi_val;?></option>
											<?php endforeach;?>
										</select>
										PT
										<?php echo getParam($error, 'use_point'); ?>
									</p>
								</div>
								<h4> 個人情報取得への同意<span class="clrred">※</span></h4>
								<p class="mb10"><input type="checkbox" name="contract" id="contract" />同意する</p>
								<?php echo getParam($error, 'contract'); ?>
								<p class="txt12"><a href="../info/kojin.html">個人情報の取得はこちら</a><br />※上記の入力内容を確認して「確認画面へ」ボタンを押してください</p>
								<p class="stopr_linkbtn"><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a></p>
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
</html>
