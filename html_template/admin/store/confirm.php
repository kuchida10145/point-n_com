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
								<label class="control-label" for="selectError3">WEBサービス</label>
								<div class="controls">
									<?php echo getParam(store_status_label(), getParam($post, 'status_id'));?>
								</div>
							</div>
							
						<div class="box-header" data-original-title="">
							アカウント管理
						</div>
						<br>
							
							<div class="control-group">
								<label for="" class="control-label">入会日(登録日)</label>
								<div class="controls"><?php echo getParam($post, 'regist_date', '新規登録時に自動入力');?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="">店ID</label>
								<div class="controls"><?php echo getParam($post, 'store_hex_id', '新規登録時に自動入力');?></div>
							</div>
							
							<div class="control-group">
								<label for="" class="control-label">店舗名</label>
								<div class="controls">
									<?php echo getParam($post,'store_name');?>
									<?php if (getParam($post,'new_arrival') == 1) { echo '<br>新着店舗'; } ?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="selectError3">業種</label>
								<div class="controls">
									<?php echo getParam(store_type_of_industry(), getParam($post, 'type_of_industry_id'));?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="fileInput">許可証の表示</label>
								<div class="controls"><?php echo create_image_uploaded(getParam($post, 'license'), 'license', 'display');?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">ユーザー名</label>
								<div class="controls"><?php echo getParam($post, 'account_name');?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">ログインID</label>
								<div class="controls"><?php echo getParam($post, 'login_id');?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">ログインPW</label>
								<div class="controls">設定したパスワード</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">第1エリア(都道府県)</label>
								<div class="controls"><?php echo getParam(prefectures_master(), getParam($post, 'area_first_prefectures_id'));?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">ジャンルマスター</label>
								<div class="controls"><?php echo getParam(category_large(), getParam($post, 'category_large_id'));?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">中カテゴリー</label>
								<div class="controls"><?php echo getParam(category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id')), getParam($post, 'category_midium_id'));?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">小カテゴリー</label>
								<div class="controls"><?php echo getParam(category_small(getParam($post, 'category_midium_id')), getParam($post, 'category_small_id'));?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">第2エリア</label>
								<div class="controls"><?php echo getParam(area_second_to_extend(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), is_delivery(getParam($post, 'type_of_industry_id'))), getParam($post, 'area_second_id'));?></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">第3エリア</label>
								<div class="controls"><?php echo getParam(area_third(getParam($post, 'area_second_id')), getParam($post, 'area_third_id'));?></div>
							</div>
							
						<div class="box-header" data-original-title="">
							ショップデータ
						</div>
						<br>
							
							<div class="control-group">
								<label class="control-label" for="fileInput">画像の登録</label>
								<div class="controls">
									<div class="masonry-gallery">
										<div id="image1" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image1'), 'image1', 'display');?>
										</div>
										<div id="image2" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image2'), 'image2', 'display');?>
										</div>
										<div id="image3" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image3'), 'image3', 'display');?>
										</div>
										<div id="image4" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image4'), 'image4', 'display');?>
										</div>
										<div id="image5" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image5'), 'image5', 'display');?>
										</div>
										<div id="image6" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image6'), 'image6', 'display');?>
										</div>
										<div id="image7" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image7'), 'image7', 'display');?>
										</div>
										<div id="image8" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image8'), 'image8', 'display');?>
										</div>
										<div id="image9" class="masonry-thumb">
											<?php echo create_image_uploaded(getParam($post, 'image9'), 'image9', 'display');?>
										</div>
									</div>
								</div>
							</div>
							
							<div class="control-group hidden-phone">
								<label class="control-label" for="textarea2">お店からのお知らせ</label>
								<div class="controls">
									<?php echo getParam($post, 'introduction');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">位置情報</label>
								<div class="controls">
									緯度<?php echo getParam($post, 'latitude');?>　
									経度<?php echo getParam($post, 'longitude');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">郵便番号</label>
								<div class="controls">
									<?php echo getParam($post, 'zip_code1');?>
									-
									<?php echo getParam($post, 'zip_code2');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="selectError3">都道府県</label>
								<div class="controls">
									<?php echo getParam(prefectures_master(), getParam($post, 'prefectures_id'));?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">市町村番地</label>
								<div class="controls">
									<?php echo getParam($post, 'address1');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">マンション/ビル名</label>
								<div class="controls">
									<?php echo getParam($post, 'address2');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">営業時間</label>
								<div class="controls">
									<?php echo getParam($post, 'business_hours');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">休日</label>
								<div class="controls">
									<?php echo getParam($post, 'holiday');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">電話番号</label>
								<div class="controls">
									<?php echo getParam($post, 'telephone1');?>
									-
									<?php echo getParam($post, 'telephone2');?>
									-
									<?php echo getParam($post, 'telephone3');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">公式サイト1</label>
								<div class="controls">
									<?php echo getParam($post, 'url_official1');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">公式サイト2</label>
								<div class="controls">
									<?php echo getParam($post, 'url_official2');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">公式サイト3</label>
								<div class="controls">
									<?php echo getParam($post, 'url_official3');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">公式サイト4</label>
								<div class="controls">
									<?php echo getParam($post, 'url_official4');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">外部サイト1</label>
								<div class="controls">
									<?php echo getParam($post, 'url_outside1');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">外部サイト2</label>
								<div class="controls">
									<?php echo getParam($post, 'url_outside2');?>
								</div>
							</div>
							
						<div class="box-header" data-original-title="">
							その他
						</div>
						<br>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">担当者名</label>
								<div class="controls">
									<?php echo getParam($post, 'representative_sei');?>
									<?php echo getParam($post, 'representative_mei');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">メールアドレス</label>
								<div class="controls">
									<?php echo getParam($post, 'representative_email');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">予約受信メールアドレス</label>
								<div class="controls">
									<?php echo getParam($post, 'reserved_email');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行1</strong></label>
								<div class="controls"></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<?php echo getParam($post, 'bank_name1');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<?php echo getParam(bank_kind(), getParam($post, 'bank_kind1'));?>　<?php echo getParam($post, 'bank_account_number1');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<?php echo getParam($post, 'bank_account_holder1');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行2</strong></label>
								<div class="controls"></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<?php echo getParam($post, 'bank_name2');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<?php echo getParam(bank_kind(), getParam($post, 'bank_kind2'));?>　<?php echo getParam($post, 'bank_account_number2');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<?php echo getParam($post, 'bank_account_holder2');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行3</strong></label>
								<div class="controls"></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<?php echo getParam($post, 'bank_name3');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<?php echo getParam(bank_kind(), getParam($post, 'bank_kind3'));?>　<?php echo getParam($post, 'bank_account_number3');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<?php echo getParam($post, 'bank_account_holder3');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>ゆうちょ銀行</strong></label>
								<div class="controls"></div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">記号</label>
								<div class="controls">
								<?php if (getParam($post, 'jpbank_symbol1') != "" || getParam($post, 'jpbank_symbol2')) : ?>
									<?php echo getParam($post, 'jpbank_symbol1');?>
									-
									<?php echo getParam($post, 'jpbank_symbol2');?>
								<?php endif; ?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">番号</label>
								<div class="controls">
									<?php echo getParam($post, 'jpbank_account_number');?>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<?php echo getParam($post, 'jpbank_account_holder');?>
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
	<!-- end: JavaScript-->
</body>
</html>