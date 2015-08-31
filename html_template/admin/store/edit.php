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
							<?php if (getParam($post, 'regist_date') != "") : ?>
							<div class="control-group <?php echo error_class(getParam($error,'status_id'));?>">
								<label class="control-label" for="">WEBサービス</label>
								<div class="controls">
									<input type="hidden" id="cur_status_id" name="cur_status_id" value="<?php echo getParam($post, 'cur_status_id', '');?>">
									<label class="radio">
										<input type="radio" name="status_id" value="2" <?php echo _check_checked(2, getParam($post, 'status_id'));?>><div class="btn btn-success">運営中</div>
									</label>
									<label class="radio">
										<input type="radio" name="status_id" value="1" <?php echo _check_checked(1, getParam($post, 'status_id'));?>><div class="btn btn-warning">準備中</div>
									</label>
									<label class="radio">
										<input type="radio" name="status_id" value="9" <?php echo _check_checked(9, getParam($post, 'status_id'));?>><div class="btn btn-danger">停止中</div>
									</label>
								</div>
							</div>
							<?php else : ?>
							<div class="control-group">
								<label class="control-label" for="">WEBサービス</label>
								<div class="controls">
									<span class="label label-large label-warning">準備中</span>
								</div>
							</div>
							<?php endif; ?>

						<div class="box-header" data-original-title="">
							アカウント管理
						</div>
						<br>

							<div class="control-group">
								<label class="control-label" for="">入会日(登録日)</label>
								<div class="controls"><?php echo getParam($post, 'regist_date', '新規登録時に自動入力');?></div>
								<input type="hidden" id="regist_date" name="regist_date" value="<?php echo getParam($post, 'regist_date', '');?>">
							</div>

							<div class="control-group">
								<label class="control-label" for="">店ID</label>
								<div class="controls"><?php echo getParam($post, 'store_hex_id', '新規登録時に自動入力');?></div>
								<input type="hidden" id="store_hex_id" name="store_hex_id" value="<?php echo getParam($post, 'store_hex_id', '');?>">
							</div>

							<div class="control-group <?php echo error_class(getParam($error,'store_name'));?>">
								<label class="control-label" for="typeahead">店舗名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="store_name" name="store_name" value="<?php echo getParam($post, 'store_name');?>" type="text" class="input-block-level">
									<?php echo getParam($error, 'store_name');?>
									<br>
									<label class="checkbox inline">
										<div id="uniform-inlineCheckbox1" class="checker">
											<span class="checked">
												<input id="new_arrival" name="new_arrival" value="1" type="checkbox" <?php echo _check_checked(1, getParam($post, 'new_arrival'));?>>
											</span>
										</div>
										新着店舗にする
									</label>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'type_of_industry_id'));?>">
								<label class="control-label" for="selectError3">業種 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="type_of_industry_id" name="type_of_industry_id">
										<option value="">選択してください</option>
										<?php foreach(store_type_of_industry() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'type_of_industry_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'type_of_industry_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'contract_zip_code1'));?> <?php echo error_class(getParam($error, 'contract_zip_code2'));?> <?php echo error_class(getParam($error, 'contract_zip_code'));?>">
								<label class="control-label" for="typeahead">事務所郵便番号 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="contract_zip_code1" name="contract_zip_code1" type="text" value="<?php echo getParam($post, 'contract_zip_code1');?>">
									<?php echo getParam($error, 'contract_zip_code1');?>
									-
									<input placeholder="" id="contract_zip_code2" name="contract_zip_code2" type="text" value="<?php echo getParam($post, 'contract_zip_code2');?>">
									<?php echo getParam($error, 'contract_zip_code2');?>
									<?php echo getParam($error, 'contract_zip_code');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'contract_prefectures_id'));?>">
								<label class="control-label" for="selectError3">事務所都道府県 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="contract_prefectures_id" name="contract_prefectures_id">
										<option value="">選択してください</option>
										<?php foreach(prefectures_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'contract_prefectures_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'contract_prefectures_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'contract_address1'));?>">
								<label class="control-label" for="typeahead">事務所市町村番地 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="contract_address1" name="contract_address1" type="text" class="input-block-level" value="<?php echo getParam($post, 'contract_address1');?>">
									<?php echo getParam($error, 'contract_address1');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'contract_address2'));?>">
								<label class="control-label" for="typeahead">事務所マンション/ビル名</label>
								<div class="controls">
									<input placeholder="" id="contract_address2" name="contract_address2" type="text" class="input-block-level" value="<?php echo getParam($post, 'contract_address2');?>">
									<?php echo getParam($error, 'contract_address2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'contract_telephone'));?>">
								<label class="control-label" for="typeahead">事務所電話番号 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="contract_telephone1" name="contract_telephone1" type="text" value="<?php echo getParam($post, 'contract_telephone1');?>">
									<?php //echo getParam($error, 'contract_telephone1');?>
									-
									<input placeholder="" id="contract_telephone2" name="contract_telephone2" type="text" value="<?php echo getParam($post, 'contract_telephone2');?>">
									<?php //echo getParam($error, 'contract_telephone2');?>
									-
									<input placeholder="" id="contract_telephone3" name="contract_telephone3" type="text" value="<?php echo getParam($post, 'contract_telephone3');?>">
									<?php //echo getParam($error, 'contract_telephone3');?>
									<?php echo getParam($error, 'contract_telephone');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'license'));?>">
								<label class="control-label" for="fileInput">許可証の表示 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input type="hidden" id="cur_license" name="cur_license" value="<?php echo getParam($post, 'cur_license', '');?>">
									<div id="license"><?php echo create_file_uploaded(getParam($post,'license'),'license');?></div>
									<?php echo getParam($error,'license');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'account_name'));?>">
								<label class="control-label" for="typeahead">ユーザー名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" name="account_name" value="<?php echo getParam($post, 'account_name');?>" type="text" class="input-block-level">
									<?php echo getParam($error, 'account_name');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'login_id'));?>">
								<label class="control-label" for="typeahead">ログインID <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="6～12文字の半角英数字" id="login_id" name="login_id" value="<?php echo getParam($post, 'login_id');?>" type="text">
									<?php echo getParam($error, 'login_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'login_password'));?>">
								<label class="control-label" for="typeahead">ログインPW <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="4～8文字の半角英数字" id="login_password" name="login_password" value="<?php echo getParam($post, 'login_password');?>" type="text">
									<?php echo getParam($error,'login_password');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'area_first_prefectures_id'));?>">
								<label class="control-label" for="typeahead">第1エリア(都道府県) <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="area_first_prefectures_id" name="area_first_prefectures_id">
										<option value="">選択してください</option>
										<?php foreach(prefectures_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_first_prefectures_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'area_first_prefectures_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'category_large_id'));?>">
								<label class="control-label" for="typeahead">ジャンルマスター <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="category_large_id" name="category_large_id">
										<option value="">選択してください</option>
										<?php foreach(category_large() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_large_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'category_large_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'category_midium_id'));?>">
								<label class="control-label" for="typeahead">中カテゴリー <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="category_midium_id" name="category_midium_id">
										<option value="">選択してください</option>
										<?php foreach(category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), is_delivery(getParam($post, 'type_of_industry_id'))) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_midium_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'category_midium_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'category_small_id'));?>">
								<label class="control-label" for="typeahead">小カテゴリー <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="category_small_id" name="category_small_id">
										<option value="">選択してください</option>
										<?php foreach(category_small(getParam($post, 'category_midium_id')) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_small_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'category_small_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'area_second_id'));?>">
								<label class="control-label" for="typeahead">第2エリア <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="area_second_id" name="area_second_id">
										<option value="">選択してください</option>
										<?php foreach(area_second_to_extend(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), is_delivery(getParam($post, 'type_of_industry_id'))) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_second_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'area_second_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'area_third_id'));?>">
								<label class="control-label" for="typeahead">第3エリア <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="area_third_id" name="area_third_id">
										<option value="">選択してください</option>
										<?php foreach(area_third(getParam($post, 'area_second_id')) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_third_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'area_third_id');?>
								</div>
							</div>

						<div class="box-header" data-original-title="">
							ショップデータ
						</div>
						<br>
							<div class="control-group <?php echo error_class(getParam($error, 'point_limit'));?>">
								<label class="control-label" for="typeahead">残りポイント枠 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input type="text" name="point_limit" value="<?php echo getParam($post,'point_limit',0);?>"><br />
									今月付与・発行できる残りポイント利用枠です。<br />
									基本的に操作する必要はありませんが、何らかの理由で修正する必要が出た場合のみ修正することを推奨します。<br />
									新規作成時・毎月1日になると自動で「月初めポイント付与数」の数値に設定されます。
									<?php echo getParam($error, 'point_limit');?>
								</div>
							</div>
							<div class="control-group <?php echo error_class(getParam($error, 'base_point'));?>">
								<label class="control-label" for="typeahead">月初めポイント付与数 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input type="text" name="base_point" value="<?php echo getParam($post,'base_point',0);?>"><br />
									毎月1日になったら自動で残りポイント枠として付与するポイント数です。
									<?php echo getParam($error, 'base_point');?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="fileInput">画像の登録</label>
								<div class="controls">
									<input type="hidden" id="cur_image1" name="cur_image1" value="<?php echo getParam($post, 'cur_image1', '');?>">
									<div id="image1"><?php echo create_image_uploaded(getParam($post,'image1'),'image1');?></div>
									<?php echo getParam($error,'image1');?>
									<input type="hidden" id="cur_image2" name="cur_image2" value="<?php echo getParam($post, 'cur_image2', '');?>">
									<div id="image2"><?php echo create_image_uploaded(getParam($post,'image2'),'image2');?></div>
									<?php echo getParam($error,'image2');?>
									<input type="hidden" id="cur_image3" name="cur_image3" value="<?php echo getParam($post, 'cur_image3', '');?>">
									<div id="image3"><?php echo create_image_uploaded(getParam($post,'image3'),'image3');?></div>
									<?php echo getParam($error,'image3');?>
									<input type="hidden" id="cur_image4" name="cur_image4" value="<?php echo getParam($post, 'cur_image4', '');?>">
									<div id="image4"><?php echo create_image_uploaded(getParam($post,'image4'),'image4');?></div>
									<?php echo getParam($error,'image4');?>
									<input type="hidden" id="cur_image5" name="cur_image5" value="<?php echo getParam($post, 'cur_image5', '');?>">
									<div id="image5"><?php echo create_image_uploaded(getParam($post,'image5'),'image5');?></div>
									<?php echo getParam($error,'image5');?>
									<input type="hidden" id="cur_image6" name="cur_image6" value="<?php echo getParam($post, 'cur_image6', '');?>">
									<div id="image6"><?php echo create_image_uploaded(getParam($post,'image6'),'image6');?></div>
									<?php echo getParam($error,'image6');?>
									<input type="hidden" id="cur_image7" name="cur_image7" value="<?php echo getParam($post, 'cur_image7', '');?>">
									<div id="image7"><?php echo create_image_uploaded(getParam($post,'image7'),'image7');?></div>
									<?php echo getParam($error,'image7');?>
									<input type="hidden" id="cur_image8" name="cur_image8" value="<?php echo getParam($post, 'cur_image8', '');?>">
									<div id="image8"><?php echo create_image_uploaded(getParam($post,'image8'),'image8');?></div>
									<?php echo getParam($error,'image8');?>
									<input type="hidden" id="cur_image9" name="cur_image9" value="<?php echo getParam($post, 'cur_image9', '');?>">
									<div id="image9"><?php echo create_image_uploaded(getParam($post,'image9'),'image9');?></div>
									<?php echo getParam($error,'image9');?>
								</div>
							</div>

							<div class="control-group hidden-phone <?php echo error_class(getParam($error, 'introduction'));?>">
								<label class="control-label" for="textarea2">お店からのお知らせ</label>
								<div class="controls">
									<textarea class="ckeditor" id="introduction" name="introduction" rows="3"><?php echo getParam($post, 'introduction');?></textarea>
									<?php echo getParam($error, 'introduction');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'latitude'));?> <?php echo error_class(getParam($error, 'longitude'));?>">
								<label class="control-label" for="typeahead">位置情報 <span class="label label-important">必須</span></label>
								<div class="controls">
									緯度<input placeholder="" id="latitude" name="latitude" type="text" value="<?php echo getParam($post, 'latitude');?>">
									<?php echo getParam($error, 'latitude');?>
									経度<input placeholder="" id="longitude" name="longitude" type="text" value="<?php echo getParam($post, 'longitude');?>">
									<?php echo getParam($error, 'longitude');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'zip_code1'));?> <?php echo error_class(getParam($error, 'zip_code2'));?> <?php echo error_class(getParam($error, 'zip_code'));?>">
								<label class="control-label" for="typeahead">店舗または発エリア郵便番号 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="zip_code1" name="zip_code1" type="text" value="<?php echo getParam($post, 'zip_code1');?>">
									<?php echo getParam($error, 'zip_code1');?>
									-
									<input placeholder="" id="zip_code2" name="zip_code2" type="text" value="<?php echo getParam($post, 'zip_code2');?>">
									<?php echo getParam($error, 'zip_code2');?>
									<?php echo getParam($error, 'zip_code');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'prefectures_id'));?>">
								<label class="control-label" for="selectError3">店舗または発エリア都道府県 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="prefectures_id" name="prefectures_id">
										<option value="">選択してください</option>
										<?php foreach(prefectures_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'prefectures_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'prefectures_id');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'address1'));?>">
								<label class="control-label" for="typeahead">店舗または発エリア市町村番地 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="address1" name="address1" type="text" class="input-block-level" value="<?php echo getParam($post, 'address1');?>">
									<?php echo getParam($error, 'address1');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'address2'));?>">
								<label class="control-label" for="typeahead">店舗または発エリアマンション/ビル名</label>
								<div class="controls">
									<input placeholder="" id="address2" name="address2" type="text" class="input-block-level" value="<?php echo getParam($post, 'address2');?>">
									<?php echo getParam($error, 'address2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'business_hours'));?>">
								<label class="control-label" for="typeahead">営業時間 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="business_hours" name="business_hours" type="text" class="input-block-level" value="<?php echo getParam($post, 'business_hours');?>">
									<?php echo getParam($error, 'business_hours');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'holiday'));?>">
								<label class="control-label" for="typeahead">休日 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="holiday" name="holiday" type="text" class="input-block-level" value="<?php echo getParam($post, 'holiday');?>">
									<?php echo getParam($error, 'holiday');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'telephone'));?>">
								<label class="control-label" for="typeahead">店舗または発エリア電話番号 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="telephone1" name="telephone1" type="text" value="<?php echo getParam($post, 'telephone1');?>">
									<?php/* echo getParam($error, 'telephone1');*/?>
									-
									<input placeholder="" id="telephone2" name="telephone2" type="text" value="<?php echo getParam($post, 'telephone2');?>">
									<?php/*  echo getParam($error, 'telephone2');*/?>
									-
									<input placeholder="" id="telephone3" name="telephone3" type="text" value="<?php echo getParam($post, 'telephone3');?>">
									<?php/*  echo getParam($error, 'telephone3');*/?>
									<?php echo getParam($error, 'telephone');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'url_official1'));?>">
								<label class="control-label" for="typeahead">公式サイト1</label>
								<div class="controls">
									<input placeholder="" id="url_official1" name="url_official1" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official1');?>">
									<?php echo getParam($error, 'url_official1');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'url_official2'));?>">
								<label class="control-label" for="typeahead">公式サイト2</label>
								<div class="controls">
									<input placeholder="" id="url_official2" name="url_official2" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official2');?>">
									<?php echo getParam($error, 'url_official2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'url_official3'));?>">
								<label class="control-label" for="typeahead">公式サイト3</label>
								<div class="controls">
									<input placeholder="" id="url_official3" name="url_official3" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official3');?>">
									<?php echo getParam($error, 'url_official3');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'url_official4'));?>">
								<label class="control-label" for="typeahead">公式サイト4</label>
								<div class="controls">
									<input placeholder="" id="url_official4" name="url_official4" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official4');?>">
									<?php echo getParam($error, 'url_official4');?>
								</div>
							</div>

						<?php for ($os_index = 1; $os_index <= 5; $os_index++) : ?>
							<div class="control-group <?php echo error_class(getParam($error, 'url_outside' . $os_index));?>">
								<label class="control-label" for="typeahead">外部サイト<?php echo $os_index; ?></label>
								<div class="controls">
									<input placeholder="" id="url_outside<?php echo $os_index; ?>" name="url_outside<?php echo $os_index; ?>" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_outside' . $os_index);?>">
									<?php echo getParam($error, 'url_outside' . $os_index);?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'link_text_outside' . $os_index));?>">
								<label class="control-label" for="typeahead">外部サイト<?php echo $os_index; ?>リンクテキスト</label>
								<div class="controls">
									<input placeholder="" id="link_text_outside<?php echo $os_index; ?>" name="link_text_outside<?php echo $os_index; ?>" type="text" class="input-block-level" value="<?php echo getParam($post, 'link_text_outside' . $os_index);?>">
									<?php echo getParam($error, 'link_text_outside' . $os_index);?>
								</div>
							</div>
						<?php endfor; ?>

						<div class="box-header" data-original-title="">
							その他
						</div>
						<br>

							<div class="control-group <?php echo error_class(getParam($error, 'representative_sei'));?> <?php echo error_class(getParam($error, 'representative_mei'));?>">
								<label class="control-label" for="typeahead">担当者名 <span class="label label-important">必須</span></label>
								<div class="controls">
									姓<input placeholder="" id="representative_sei" name="representative_sei" type="text" value="<?php echo getParam($post, 'representative_sei');?>">
									<?php echo getParam($error, 'representative_sei');?>
									名<input placeholder="" id="representative_mei" name="representative_mei" type="text" value="<?php echo getParam($post, 'representative_mei');?>">
									<?php echo getParam($error, 'representative_mei');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'representative_email'));?> <?php echo error_class(getParam($error, 'representative_email_confirm'));?> <?php echo error_class(getParam($error, 'representative_email_both'));?>">
								<label class="control-label" for="typeahead">メールアドレス <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="representative_email" name="representative_email" type="text" class="input-block-level" value="<?php echo getParam($post, 'representative_email');?>"><br>
									<?php echo getParam($error, 'representative_email');?>
									確認のためもう一度入力してください。<br>
									<input placeholder="" id="representative_email_confirm" name="representative_email_confirm" type="text" class="input-block-level" value="<?php echo getParam($post, 'representative_email_confirm');?>">
									<?php echo getParam($error, 'representative_email_confirm');?>
									<?php echo getParam($error, 'representative_email_both');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'reserved_email'));?> <?php echo error_class(getParam($error, 'reserved_email_confirm'));?> <?php echo error_class(getParam($error, 'reserved_email_both'));?>">
								<label class="control-label" for="typeahead">予約受信メールアドレス <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="reserved_email" name="reserved_email" type="text" class="input-block-level" value="<?php echo getParam($post, 'reserved_email');?>"><br>
									<?php echo getParam($error, 'reserved_email');?>
									確認のためもう一度入力してください。<br>
									<input placeholder="" id="reserved_email_confirm" name="reserved_email_confirm" type="text" class="input-block-level" value="<?php echo getParam($post, 'reserved_email_confirm');?>">
									<?php echo getParam($error, 'reserved_email_confirm');?>
									<?php echo getParam($error, 'reserved_email_both');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行1</strong></label>
								<div class="controls"></div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_name1'));?>">
								<label class="control-label" for="typeahead">銀行名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="bank_name1" name="bank_name1" type="text" class="input-block-level" value="<?php echo getParam($post, 'bank_name1');?>">
									<?php echo getParam($error, 'bank_name1');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'branch_name1'));?>">
								<label class="control-label" for="typeahead">支店名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="branch_name1" name="branch_name1" type="text" class="input-block-level" value="<?php echo getParam($post, 'branch_name1');?>">
									<?php echo getParam($error, 'branch_name1');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_kind1'));?> <?php echo error_class(getParam($error, 'bank_account_number1'));?>">
								<label class="control-label" for="typeahead">口座番号 <span class="label label-important">必須</span></label>
								<div class="controls">
									<select name="bank_kind1" id="bank_kind1">
										<option value="">選択してください。</option>
										<?php foreach(bank_kind() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'bank_kind1'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'bank_kind1');?>
									<input placeholder="" id="bank_account_number1" name="bank_account_number1" type="text" value="<?php echo getParam($post, 'bank_account_number1');?>">
									<?php echo getParam($error, 'bank_account_number1');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_account_holder1'));?>">
								<label class="control-label" for="typeahead">口座名義人 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="bank_account_holder1" name="bank_account_holder1" type="text" value="<?php echo getParam($post, 'bank_account_holder1');?>">
									<?php echo getParam($error, 'bank_account_holder1');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行2</strong></label>
								<div class="controls"></div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_name2'));?>">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<input placeholder="" id="bank_name2" name="bank_name2" type="text" class="input-block-level" value="<?php echo getParam($post, 'bank_name2');?>">
									<?php echo getParam($error, 'bank_name2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'branch_name2'));?>">
								<label class="control-label" for="typeahead">支店名</label>
								<div class="controls">
									<input placeholder="" id="branch_name2" name="branch_name2" type="text" class="input-block-level" value="<?php echo getParam($post, 'branch_name2');?>">
									<?php echo getParam($error, 'branch_name2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_kind2'));?>">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<select name="bank_kind2" id="bank_kind2">
										<option value="">選択してください。</option>
										<?php foreach(bank_kind() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'bank_kind2'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<input placeholder="" id="bank_account_number2" name="bank_account_number2" type="text" value="<?php echo getParam($post, 'bank_account_number2');?>">
									<?php echo getParam($error, 'bank_kind2');?>
									<?php echo getParam($error, 'bank_account_number2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_account_holder2'));?>">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="bank_account_holder2" name="bank_account_holder2" type="text" value="<?php echo getParam($post, 'bank_account_holder2');?>">
									<?php echo getParam($error, 'bank_account_holder2');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行3</strong></label>
								<div class="controls"></div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_name3'));?>">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<input placeholder="" id="bank_name3" name="bank_name3" type="text" class="input-block-level" value="<?php echo getParam($post, 'bank_name3');?>">
									<?php echo getParam($error, 'bank_name3');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'branch_name3'));?>">
								<label class="control-label" for="typeahead">支店名</label>
								<div class="controls">
									<input placeholder="" id="branch_name3" name="branch_name3" type="text" class="input-block-level" value="<?php echo getParam($post, 'branch_name3');?>">
									<?php echo getParam($error, 'branch_name3');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_kind3'));?>">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<select name="bank_kind3" id="bank_kind3">
										<option value="">選択してください。</option>
										<?php foreach(bank_kind() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'bank_kind3'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'bank_kind3');?>
									<input placeholder="" id="bank_account_number3" name="bank_account_number3" type="text" value="<?php echo getParam($post, 'bank_account_number3');?>">
									<?php echo getParam($error, 'bank_account_number3');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'bank_account_holder3'));?>">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="bank_account_holder3" name="bank_account_holder3" type="text" value="<?php echo getParam($post, 'bank_account_holder3');?>">
									<?php echo getParam($error, 'bank_account_holder3');?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>ゆうちょ銀行</strong></label>
								<div class="controls"></div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'jpbank_symbol1'));?> <?php echo error_class(getParam($error, 'jpbank_symbol2'));?>">
								<label class="control-label" for="typeahead">記号</label>
								<div class="controls">
									<input placeholder="" id="jpbank_symbol1" name="jpbank_symbol1" type="text" value="<?php echo getParam($post, 'jpbank_symbol1');?>">
									<?php echo getParam($error, 'jpbank_symbol1');?>
									-
									<input placeholder="" id="jpbank_symbol2" name="jpbank_symbol2" type="text" value="<?php echo getParam($post, 'jpbank_symbol2');?>">
									<?php echo getParam($error, 'jpbank_symbol2');?>
								</div>
							</div>

							<div class="control-group <?php echo error_class(getParam($error, 'jpbank_account_number'));?>">
								<label class="control-label" for="typeahead">番号</label>
								<div class="controls">
									<input placeholder="" id="jpbank_account_number" name="jpbank_account_number" type="text" value="<?php echo getParam($post, 'jpbank_account_number');?>">
									<?php echo getParam($error, 'jpbank_account_number');?>
								</div>
							</div>

							<div class="control-group" <?php echo error_class(getParam($error, 'jpbank_account_holder'));?>>
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="jpbank_account_holder" name="jpbank_account_holder" type="text" value="<?php echo getParam($post, 'jpbank_account_holder');?>">
									<?php echo getParam($error, 'jpbank_account_holder');?>
								</div>
							</div>

							<div class="form-actions">
								<button class="btn btn-primary" type="submit">確認画面へ</button>
								<button type="button" onclick="location.href='store.php'" class="btn">戻る</button>
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

	<script>
	$(function(){

		$('#license').fileUpload({url:'/admin/store.php?m=file_upload',name:'license'});
		$('#type_of_industry_id').change(function() {
			$('#type_of_industry_id').changeUpperItem({
				url:'/admin/store.php?m=change_upper_item',
				name:'type_of_industry_id'});
		});
		$('#area_first_prefectures_id').change(function() {
			$('#area_first_prefectures_id').changeUpperItem({
				url:'/admin/store.php?m=change_upper_item',
				name:'area_first_prefectures_id'});
		});
		$('#category_large_id').change(function() {
			$('#category_large_id').changeUpperItem({
				url:'/admin/store.php?m=change_upper_item',
				name:'category_large_id'});
		});
		$('#category_midium_id').change(function() {
			$('#category_midium_id').changeCategoryMidium({
				url:'/admin/store.php?m=change_category_midium',
				name:'category_midium_id',
				selected:$(this).val()});
		});
		$('#area_second_id').change(function() {
			$('#area_second_id').changeAreaSecond({
				url:'/admin/store.php?m=change_area_second',
				name:'area_second_id',
				selected:$(this).val()});
		});
		$('#image1').imageUpload({url:'/admin/store.php?m=image_upload',name:'image1'});
		$('#image2').imageUpload({url:'/admin/store.php?m=image_upload',name:'image2'});
		$('#image3').imageUpload({url:'/admin/store.php?m=image_upload',name:'image3'});
		$('#image4').imageUpload({url:'/admin/store.php?m=image_upload',name:'image4'});
		$('#image5').imageUpload({url:'/admin/store.php?m=image_upload',name:'image5'});
		$('#image6').imageUpload({url:'/admin/store.php?m=image_upload',name:'image6'});
		$('#image7').imageUpload({url:'/admin/store.php?m=image_upload',name:'image7'});
		$('#image8').imageUpload({url:'/admin/store.php?m=image_upload',name:'image8'});
		$('#image9').imageUpload({url:'/admin/store.php?m=image_upload',name:'image9'});

	});
	</script>
</body>
</html>
