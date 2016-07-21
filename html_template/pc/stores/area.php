<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>
<?php
	$title = $condition_category_large_name;
	$title .= " ".$condition_redion_name;
	foreach ($condition_category_small_names as $small_name) {
		$title .= " ".$small_name;
	}
	echo $title;
?> エリア選択 | ポイント.com
</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗検索" />
<meta name="description" content="細かい地域の選択をしていただけます。ジャンルも細かく指定できますので、お気に入り店舗が見つかります。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />

<!--<link rel="stylesheet" href="css/jquery.bxslider.css">-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/fixHeight.js" type="text/javascript"></script>

</head>

<body id="genre" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div class="container">
	<div class="mainbodybg01">
		<!--mainbody-->
		<div class="mainbody">
			<form action="<?php echo $action_link; ?>" name="frm" method="post">
			<input type="hidden" name="m" value="search_select"/>
			<input type="hidden" name="category_large_id" id="category_large_id" value="<?php echo getParam($post, 'category_large_id'); ?>"/>
			<input type="hidden" name="region_id" id="region_id" value="<?php echo getParam($post, 'region_id'); ?>"/>
			<input type="hidden" name="category_midium_id" id="category_midium_id" value="<?php echo getParam($post, 'category_midium_id'); ?>"/>
			<input type="hidden" name="category_small_ids" id="category_small_ids" value="<?php echo getParam($post, 'category_small_ids'); ?>"/>
			<div class="contents clearfix">
			<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="done">ジャンルと地域を選ぶ</p>
						<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
						<p>ジャンル詳細を選ぶ</p>
						<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
						<p  class="hear">地域詳細を選ぶ</p>
						<p><img src="/html_template/pc/stores/img/icon_arrow.png" alt=""/></p>
						<p class="will">店舗一覧</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_01">
							<h3 class="clearfix">選んだ条件<span class="fltright"><a href="#">条件変更</a></span></h3>
							<ul class="clearfix">
								<li class="page01_select_girl"><?php echo $condition_category_large_name; ?></li>
								<li class="page01_select_area"><?php echo $condition_redion_name; ?></li>
								<li class="page01_select_area"><?php echo $condition_category_midium_name; ?></li>
								<?php foreach ($condition_category_small_names as $small_name) : ?>
								<li class="page01_select_area"><?php echo $small_name; ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="shiborikomi_genre_02">
							<h3>エリアを探す</h3>
							<?php
									$err_messages = array();
									if (getParam($error, 'area_first') != "") {
										$err_messages[] = getParam($error, 'area_first');
									}
									if (getParam($error, 'area_second') != "") {
										$err_messages[] = getParam($error, 'area_second');
									}
									if (getParam($error, 'area_third') != "") {
										$err_messages[] = getParam($error, 'area_third');
									}
									if (count($err_messages) > 0) {
										// 選択されていません ⇒ 第３階層目が選択されていません
										echo str_replace("選択", "第３階層目が選択", $err_messages[0]);
									}
							?>
							<table class="shiborikomi_area_02">
							<tbody>
								<?php $js_areas = array(); ?>
								<?php if (count($areas) > 0) : ?>
								<tr>
								<?php
									$area_first_id = "";
									$area_second_id = "";
									$area_third_id = "";
									$is_first = true;
									foreach ($areas as $area) {
										// 第１エリア
										if ($area_first_id != $area['area_first_id']) {
											$area_first_id  = $area['area_first_id'];
											$area_second_id = "";
											if ($is_first) {
												$is_first = false;
												echo '</tr>' . "\n";
											}
											$area_first_value = $area_first_id;
											$area_first_tag = 'a' . $area_first_value;
											$checked = _check_checked($area_first_value, $post['area_first_ids']);
											echo '<tr>';
											echo '<th scope="row" colspan="2">';
											echo '<label for="' . $area_first_tag . '">';
											echo '<input type="checkbox" name="area_first[]" value="' . $area_first_value . '" id="' . $area_first_tag. '" ' . $checked . ' onclick="area_check_action(' . "'" . $area_first_tag . "'" . ');" />';
											echo $area['area_first_name'];
											echo '</label>';
											echo '</th>' . "\n";
											echo '<tr>' . "\n";
											$js_areas[$area_first_tag] = array();
										}
										// 第２エリア
										if ($area_second_id != $area['area_second_id']) {
											$area_second_id = $area['area_second_id'];
											$area_third_id  = "";
											$area_second_name = ($area_second_id != 0) ? $area['area_second_name'] : '−';
											$area_second_value = $area_first_id . '-' . $area_second_id;
											$area_second_tag = 'b' . $area_second_value;
											$checked = _check_checked($area_second_value, $post['area_second_ids']);
											echo '<th scope="row"><label for="' . $area_second_tag . '" class="citytitle">';
											echo '<input type="checkbox" name="area_second[]" value="' . $area_second_value . '" id="' . $area_second_tag . '" ' . $checked . ' onclick="area_check_action(' . "'" . $area_second_tag . "'" . ');" />';
											echo $area_second_name;
											echo '</label></th>' . "\n";
											echo '<td>' . "\n";
											echo '<ul>' . "\n";
											$js_areas[$area_first_tag][] = $area_second_tag;
											$js_areas[$area_second_tag]  = array();
										}
										// 第３エリア
										if ($area_third_id != $area['area_third_id']) {
											$area_third_id = $area['area_third_id'];
											$area_third_name = ($area['area_third_id'] != 0) ? $area['area_third_name'] : '−';
											$area_third_value = $area_first_id . '-' . $area_second_id . '-' . $area_third_id;
											$area_third_tag = 'c' . $area_third_value;
											$checked = _check_checked($area_third_value, $post['area_key_ids']);
											echo '<li><label for="' . $area_third_tag . '">';
											echo '<input type="checkbox" name="area_third[]" value="' . $area_third_value . '" id="' . $area_third_tag . '" ' . $checked . ' />';
											echo $area_third_name . '(' . $area['cnt'] . ')';
											echo '</label></li>' . "\n";
											$js_areas[$area_first_tag][]  = $area_third_tag;
											$js_areas[$area_second_tag][] = $area_third_tag;
										}
									}
								?>
								</ul>
								</td>
								</tr>
								<?php else : ?>
								<label>見つかりませんでした</label>
								<?php endif; ?>
							</tbody>
						</table>
				        <p class="clearfix alncenter">
				        	<a href="javascript:void(0);" onclick="document.frm.submit();"><img class="switch" src="/html_template/pc/stores/img/btn_next_stor.png" alt="次へ進む"/></a>
				        </p>
					</div>
				</div>
			</div>
			</div><!--/.contents-->
			</form>
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
<script type="text/javascript">
function area_check_action(check_id) {
	if ($('#' + check_id).prop('checked')) {
		checked = true;
	} else {
		checked = false;
	}

	area_check_list = <?php echo json_encode($js_areas); ?>;
	if (!(check_id in area_check_list)) {
		return;
	}

	list = area_check_list[check_id];
	for (i = 0; i < list.length; i++) {
		$('#' + list[i]).prop('checked', checked);
	}
}
</script>
</body>
</html>
