
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
							<div class="control-group">
								<label class="control-label" for="">WEBサービス</label>
								<div class="controls">
									<button class="btn btn-success">運営中</button>
									<button class="btn btn-warning">準備中</button>
									<button class="btn btn-danger">停止中</button>
								</div>
							</div>
							
						<div class="box-header" data-original-title="">
							アカウント管理
						</div>
						<br>
							
							<div class="control-group">
								<label class="control-label" for="">入会日(登録日)</label>
								<div class="controls">新規登録時に自動入力</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error,'store_name'));?>">
								<label class="control-label" for="typeahead">店舗名 <span class="label label-important">必須</span></label>
								<div class="controls">
									<input placeholder="" id="store_name" name="store_name" value="<?php echo getParam($post,'store_name');?>" type="text" class="input-block-level">
									<?php echo getParam($error, 'store_name');?>
									<br>
									<label class="checkbox inline">
										<div id="uniform-inlineCheckbox1" class="checker">
											<span class="checked">
												<input id="new_arrival" name="new_arrival" value="1" type="checkbox" <?php echo _check_checked(1, $post['new_arrival']);?>>
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
						    
							<div class="control-group">
								<label class="control-label" for="fileInput">許可証の表示</label>
								<div class="controls">
									<input class="input-file uniform_on" id="fileInput" type="file">
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
									<input placeholder="4～8文字の半角英数字" id="login_password" name="login_password" value="<?php echo getParam($post, 'login_password');?>" type="password">
									<?php echo getParam($error,'login_password');?>
								</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'category_large'));?>">
								<label class="control-label" for="typeahead">ジャンルマスター <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="category_large" name="category_large">
										<option value="">選択してください</option>
										<?php foreach(category_large() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_large'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'category_large');?>
								</div>
							</div>
                            
							<div class="control-group <?php echo error_class(getParam($error, 'category_midium'));?>">
								<label class="control-label" for="typeahead">中カテゴリー <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="category_midium" name="category_midium">
										<option value="">選択してください</option>
										<?php foreach(category_midium(getParam($post, 'category_large')) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_midium'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'category_midium');?>
								</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'category_small'));?>">
								<label class="control-label" for="typeahead">小カテゴリー <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="category_small" name="category_small">
										<option value="">選択してください</option>
										<?php foreach(category_small(getParam($post, 'category_midium')) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'category_small'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'category_small');?>
								</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'category_small'));?>">
								<label class="control-label" for="typeahead">エリアマスター <span class="label label-important">必須</span><br>(第1選択ボタン)　　</label>
								<div class="controls">
									<select id="region_master" name="region_master">
										<option value="">選択してください</option>
										<?php foreach(region_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'region_master'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'region_master');?>
								</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'area_first'));?>">
								<label class="control-label" for="typeahead">第1エリア(都道府県) <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="area_first" name="area_first">
										<option value="">選択してください</option>
										<?php foreach(area_first() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getParam($post, 'area_first'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
									<?php echo getParam($error, 'area_first');?>
								</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'area_second'));?>">
								<label class="control-label" for="typeahead">第2エリア <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="area_second" name="area_second">
										<option value="">選択してください</option>
										<option value="2">仙台エリア</option>
									</select>
									<?php echo getParam($error, 'area_second');?>
								</div>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'area_third'));?>">
								<label class="control-label" for="typeahead">第3エリア <span class="label label-important">必須</span></label>
								<div class="controls">
									<select id="area_third" name="area_third">
										<option value="">選択してください</option>
										<option value="3">仙台市</option>
									</select>
									<?php echo getParam($error, 'area_third');?>
								</div>
							</div>
							
						<div class="box-header" data-original-title="">
							ショップデータ
						</div>
						<br>
							
							<div class="control-group">
								<label class="control-label" for="fileInput">画像の登録</label>
								<div class="controls">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file">
									<input class="input-file uniform_on" id="fileInput" type="file"> 
								</div>
							</div>
							
							<div class="control-group hidden-phone <?php echo error_class(getParam($error, 'introduction'));?>">
								<label class="control-label" for="textarea2">お店からのお知らせ</label>
								<div class="controls">
									<textarea class="cleditor" id="introduction" name="introduction" rows="3"><?php echo getParam($post, 'introduction');?></textarea>
								</div>
								<?php echo getParam($error, 'introduction');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'zip_code1'));?> <?php echo error_class(getParam($error, 'zip_code2'));?>">
								<label class="control-label" for="typeahead">郵便番号</label>
								<div class="controls">
									<input placeholder="" id="zip_code1" name="zip_code1" type="text" value="<?php echo getParam($post, 'zip_code1');?>"> 
									-
									<input placeholder="" id="zip_code2" name="zip_code2" type="text" value="<?php echo getParam($post, 'zip_code2');?>">
								</div>
								<?php echo getParam($error, 'zip_code1');?>
								<?php echo getParam($error, 'zip_code2');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'prefectures_id'));?>">
								<label class="control-label" for="selectError3">都道府県</label>
								<div class="controls">
									<select id="prefectures_id">
										<option value="">選択してください</option>
									</select>
								</div>
								<?php echo getParam($error, 'prefectures_id');?>
							</div>  
							
							<div class="control-group <?php echo error_class(getParam($error, 'address1'));?>">
								<label class="control-label" for="typeahead">市町村番地</label>
								<div class="controls">
									<input placeholder="" id="address1" name="address1" type="text" class="input-block-level" value="<?php echo getParam($post, 'address1');?>">
								</div>
								<?php echo getParam($error, 'address1');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'address2'));?>">
								<label class="control-label" for="typeahead">マンション/ビル名</label>
								<div class="controls">
									<input placeholder="" id="address2" name="address2" type="text" class="input-block-level" value="<?php echo getParam($post, 'address2');?>">
								</div>
								<?php echo getParam($error, 'address2');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'business_hours'));?>">
								<label class="control-label" for="typeahead">営業時間</label>
								<div class="controls">
									<input placeholder="" id="business_hours" name="business_hours" type="text" class="input-block-level" value="<?php echo getParam($post, 'business_hours');?>">
								</div>
								<?php echo getParam($error, 'business_hours');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'telephone1'));?> <?php echo error_class(getParam($error, 'telephone2'));?> <?php echo error_class(getParam($error, 'telephone3'));?>">
								<label class="control-label" for="typeahead">電話番号</label>
								<div class="controls">
									<input placeholder="" id="input" type="text" value="<?php echo getParam($post, 'telephone1');?>">
									-
									<input placeholder="" id="input2" type="text" value="<?php echo getParam($post, 'telephone2');?>">
									-
									<input placeholder="" id="input3" type="text" value="<?php echo getParam($post, 'telephone3');?>">
								</div>
								<?php echo getParam($error, 'telephone1');?>
								<?php echo getParam($error, 'telephone2');?>
								<?php echo getParam($error, 'telephone3');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'url_official1'));?>">
								<label class="control-label" for="typeahead">公式サイト1</label>
								<div class="controls">
									<input placeholder="" id="url_official1" name="url_official1" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official1');?>">
								</div>
								<?php echo getParam($error, 'url_official1');?>
							</div>   
							
							<div class="control-group <?php echo error_class(getParam($error, 'url_official2'));?>">
								<label class="control-label" for="typeahead">公式サイト2</label>
								<div class="controls">
									<input placeholder="" id="url_official2" name="url_official2" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official2');?>">
								</div>
								<?php echo getParam($error, 'url_official2');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'url_official3'));?>">
								<label class="control-label" for="typeahead">公式サイト3</label>
								<div class="controls">
									<input placeholder="" id="url_official3" name="url_official4" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official3');?>">
								</div>
								<?php echo getParam($error, 'url_official3');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'url_official4'));?>">
								<label class="control-label" for="typeahead">公式サイト4</label>
								<div class="controls">
									<input placeholder="" id="url_official4" name="url_official4" type="text" class="input-block-level" value="<?php echo getParam($post, 'url_official4');?>">
								</div>
								<?php echo getParam($error, 'url_official4');?>
							</div>
							
						<div class="box-header" data-original-title="">
						その他
						</div>
						<br>
							
							<div class="control-group <?php echo error_class(getParam($error, 'representative_sei'));?> <?php echo error_class(getParam($error, 'representative_mei'));?>">
								<label class="control-label" for="typeahead">担当者名</label>
								<div class="controls">
									姓<input placeholder="" id="representative_sei" name="representative_sei" type="text" value="<?php echo getParam($post, 'representative_sei');?>">
									名<input placeholder="" id="representative_mei" name="representative_mei" type="text" value="<?php echo getParam($post, 'representative_mei');?>">
								</div>
								<?php echo getParam($error, 'representative_sei');?>
								<?php echo getParam($error, 'representative_mei');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'representative_email'));?>">
								<label class="control-label" for="typeahead">メールアドレス</label>
								<div class="controls">
									<input placeholder="" id="representative_email" name="representative_email" type="text" class="input-block-level" value="<?php echo getParam($post, 'representative_email');?>"><br>
									確認のためもう一度入力してください。<br>
									<input placeholder="" id="representative_email_confirm" name="representative_email_confirm" type="text" class="input-block-level" value="<?php echo getParam($post, 'representative_email_confirm');?>">
								</div>
								<?php echo getParam($error, 'representative_email');?>
								<?php echo getParam($error, 'representative_email_confirm');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'reserved_email'));?> <?php echo error_class(getParam($error, 'reserved_email_confirm'));?>">
								<label class="control-label" for="typeahead">予約受信メールアドレス</label>
								<div class="controls">
									<input placeholder="" id="reserved_email" name="reserved_email" type="text" class="input-block-level" value="<?php echo getParam($post, 'reserved_email');?>"><br>
									確認のためもう一度入力してください。<br>
									<input placeholder="" id="reserved_email_confirm" name="reserved_email_confirm" type="text" class="input-block-level" value="<?php echo getParam($post, 'reserved_email_confirm');?>">
								</div>
								<?php echo getParam($error, 'reserved_email');?>
								<?php echo getParam($error, 'reserved_email_confirm');?>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行1</strong></label>
								<div class="controls"></div>
							</div>      
							
							<div class="control-group <?php echo error_class(getParam($error, 'bank_name'));?>">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<input placeholder="" id="bank_name" name="bank_name" type="text" class="input-block-level" value="<?php echo getParam($post, 'bank_name');?>">
								</div>
								<?php echo getParam($error, 'bank_name');?>
							</div>
							
							<div class="control-group <?php echo error_class(getParam($error, 'bank_kind'));?>">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<select name="bank_kind" id="selectError">
										<option value="">選択してください。</option>
										<option value="1">普通</option>
										<option value="2">口座</option>
										<option value="3">貯蓄</option>
									</select>
									<input placeholder="" id="bank_account_number" name="bank_account_number" type="text">
								</div>
							</div>  
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="input" type="text">
								</div>
							</div> 
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行2</strong></label>
								<div class="controls"></div>
							</div>      
							
							<div class="control-group">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<input placeholder="" id="input" type="text" class="input-block-level">
								</div>
							</div>    
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<select name="selectError" id="selectError">
										<option>普通</option>
										<option>口座</option>
										<option>貯蓄</option>
									</select>
									<input placeholder="" id="input" type="text">
								</div>
							</div>  
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="input" type="text">
								</div>
							</div> 
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>銀行3</strong></label>
								<div class="controls"></div>
							</div>      
							
							<div class="control-group">
								<label class="control-label" for="typeahead">銀行名</label>
								<div class="controls">
									<input placeholder="" id="input" type="text" class="input-block-level">
								</div>
							</div>    
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座番号</label>
								<div class="controls">
									<select name="selectError" id="selectError">
										<option>普通</option>
										<option>口座</option>
										<option>貯蓄</option>
									</select>
									<input placeholder="" id="input" type="text">
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="input" type="text">
								</div>
							</div>   
							
							<div class="control-group">
								<label class="control-label" for="typeahead"><strong>ゆうちょ銀行</strong></label>
								<div class="controls"></div>
							</div>      
							
							<div class="control-group">
								<label class="control-label" for="typeahead">記号</label>
								<div class="controls">
									<input placeholder="" id="input5" type="text">
									-
									<input placeholder="" id="input6" type="text">
								</div>
							</div>    
							
							<div class="control-group">
								<label class="control-label" for="typeahead">番号</label>
								<div class="controls">
									<input placeholder="" id="input4" type="text">
								</div>
							</div>  
							
							<div class="control-group">
								<label class="control-label" for="typeahead">口座名義人</label>
								<div class="controls">
									<input placeholder="" id="input" type="text">
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
</body>
</html>