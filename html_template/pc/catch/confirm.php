<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>キャッチメール登録内容確認　|　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/fixHeight.js" type="text/javascript"></script>
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
				<div class="shiborikomi_page02 form_confirm">
					<div class="shiborikomi_step">
						<p class="heartitle">キャッチメール登録内容確認</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb30">キャッチメール登録内容確認</h3>
							<form action="confirm.php?m=thanks&tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
								<input type="hidden" name="m" value="thanks" />
								<div class="mb25">
									<h4>何時から遊びたいか（希望時刻）<span class="clrred">※</span></h4>
									<p>
									<?php if(getParam($post, 'time_kind') == 0): ?>
										今から
									<?php else: ?>
									<?php echo getParam($post, 'use_time');?>
										時
									<?php echo getParam($post, 'use_min');?>
										分頃〜
									<?php endif; ?>
									</p>
								</div>
								<div class="mb25">
									<h4>来客人数<span class="clrred">※</span> </h4>
									<p><?php echo getParam($post, 'use_persons');?>人</p>
								</div>
								<div class="mb25">
									<h4>予約名<span class="clrred">※</span></h4>
									<p><?php echo getParam($post, 'reserved_name');?></p>
								</div>
								<div class="mb25">
									<h4>都道府県<span class="clrred">※</span> </h4>
									<p>
									<?php
										$area_first_array = prefectures_master();
										echo $area_first_array[getParam($post, 'area_first_prefectures_id')];
									?>
									</p>
								</div>
								<div class="mb25">
									<h4>ジャンル</h4>
									<p>
									<?php
										$category_large_array = category_large();
										echo $category_large_array[getParam($post, 'category_large_id')];
									?>
									</p>
								</div>
								<div class="mb25">
									<h4>カテゴリ</h4>
									<p>
									<?php
										$category_midium_array = category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
										echo $category_midium_array[getParam($post, 'category_midium_id')];
									?>
									</p>
								</div>
								<div class="mb25">
									<h4>エリア</h4>
									<p>
									<?php
										$area_second_array = area_second_to_extend(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
										echo $area_second_array[getParam($post, 'area_second_id')];
									?>
									</p>
								</div>
								<div class="mb25">
									<h4>詳細エリア</h4>
									<p>
									<?php
										$area_second_array = area_third(getParam($post, 'area_second_id'));
										echo $area_second_array[getParam($post, 'area_third_id')];
									?>
									</p>
								</div>
								<p class="form_confirm_btn_info txt11">※上記内容を確認して「決定」ボタンを押してください</p>
								<p class="form_confirm_btn clearfix"><a href="index.php?m=confirm&tkn=<?php echo getGet('tkn');?>">戻る</a>
								<a href="javascript:void(0);" onclick="document.frm.submit();">決定</a></p>
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
</html>
