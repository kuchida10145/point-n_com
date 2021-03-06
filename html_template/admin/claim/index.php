
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?>　<?php echo $page_type_text;?>｜Point.com管理画面</title>
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
					<li><a href="#"><?php echo $page_title;?></a></li>
				</ul>
				<h1><?php echo $page_title;?>　<?php echo $page_type_text;?></h1>
				<?php echo $system_message;?>
				<!-- 検索フォーム-->
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon search"></i><span class="break"></span>絞込み検索</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
					<div class="box-content">
						<form class="form-horizontal" method="get">
							<input type="hidden" value="<?php echo getGet('store_id');?>" name="store_id">
							<div class="control-group">
								<label for="" class="control-label">店舗名</label>
								<div class="controls">
									<input type="text" name="store_name" value="<?php echo escapeHtml(getGet('store_name'));?>">
								</div>
							</div>
							<div class="control-group">
								<label for="" class="control-label">店舗名ID</label>
								<div class="controls">
									<input type="text" name="store_hex_id" value="<?php echo escapeHtml(getGet('store_hex_id'));?>">
								</div>
							</div>
							<div class="control-group">
								<label for="" class="control-label">都道府県</label>
								<div class="controls">
									<select id="prefectures_id" name="prefectures_id" class="input-small">
										<option value=""></option>
										<?php foreach(prefectures_master() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet('prefectures_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">ジャンル</label>
								<div class="controls">
									<select id="category_large_id" name="category_large_id">
										<option value=""></option>
										<?php foreach(category_large() as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet( 'category_large_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="typeahead">中カテゴリー</label>
								<div class="controls">
									<select id="category_midium_id" name="category_midium_id">
										<option value=""></option>
										<?php foreach(category_midium_deli_all(getGet('category_large_id'), getGet('prefectures_id')) as $val_key => $val_name):?>
										<option value="<?php echo $val_key;?>" <?php echo _check_selected($val_key, getGet('category_midium_id'));?>><?php echo $val_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<input type="hidden" value="true" name="search">
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">検索</button>
							<button type="reset" class="btn" onclick="location.href='claim.php'">リセット</button>
						</div>
                        </form>
                    </div>
					</div><!--/span-->
				</div><!--/row-->
				<!-- /検索フォーム -->


				<div class="row-fluid">
					<div class="box span12">
						<div class="box-content">
							<div style="clear:both;">
								<div class="span8">
									<p>
										<button class="btn btn-large btn-info" onClick="location.href='claim.php<?php echo $get_query!='' ? '?'.$get_query:'';?>'">ポイント利用</button>
										<button class="btn btn-large btn-warning" onClick="location.href='claim.php?coupon=1<?php echo $get_query!='' ? '&'.$get_query:'';?>'">クーポン発行</button>
									</p>
								</div>
								<div class="span4">　<?php if($list):?><p style="font-size:16px;padding-top:10px;text-align:right;"><strong>csvファイル </strong><a href="claim.php?m=csv&<?php echo $get_query;?>" class="btn btn-large btn-danger">ダウンロード</button></a><?php endif;?></div>
							</div>

							<?php if(!$list):?>
							<div style="clear:both;">データがありませんでした</div>
							<?php else:?>

							<div style="clear:both;">
								<div class="span8"></div>
								<div class="span4"><p style="font-size:16px;text-align:right;">
										<strong><?php if(getGet('coupon') == 1):?>クーポン発行<?php else:?>ポイント利用<?php endif;?> 総合計　<?php echo $point;?>PT</strong>
								</p></div>
							</div>
							<table class="table table-striped table-bordered table-hover table-condensed">
							<thead>
								<tr>
									<th>予約No.</th>
									<th>来店日</th>
									<th>店舗名</th>
									<th>会員番号</th>
									<th>ユーザーID</th>
									<th>ニックネーム名</th>
									<th>クーポン名</th>
									<?php if(getGet('coupon') == 1):?>
									<th style="background-color:#FFC40D">クーポン発行</th>
									<?php else:?>
									<th style="background-color:#5bc0de">ポイント利用</th>
									<?php endif;?>
								</tr>
							</thead>
							<tbody>
							<?php foreach($list as $claim):?>
							<tr>
								<td><?php echo $claim['reserved_id'];?></td>
								<td><?php echo date('Y.m.d',strtotime($claim['use_date']));?></td>
								<td><?php echo $claim['store_name'];?></td>
								<td><?php echo $claim['user_id'];?></td>
								<td><?php echo $claim['email'];?></td>
								<td><?php echo $claim['reserved_name'];?></td>
								<td><?php echo $claim['coupon_name'];?></td>
								<td><?php echo getGet('coupon') == 1 ? $claim['get_point'] :$claim['use_point'] ;?>PT</td>
							</tr>
							<?php endforeach;?>
							</tbody>
							</table>

							<?php echo $pager_html;?>
							<?php endif;?>
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
	<!-- start:一覧画面共通処理 -->
	<?php include_once dirname(__FILE__).'/../common/list_common.php';?>
	<!-- end:一覧画面共通処理 -->

	<script>
	$(function(){
		$('#prefectures_id').change(function() {
			$('#prefectures_id').changeSearchUpperItem({
				url:'/admin/claim.php?m=change_search_upper_item',
				name:'prefectures_id'});
		});
		$('#category_large_id').change(function() {
			$('#category_large_id').changeSearchUpperItem({
				url:'/admin/claim.php?m=change_search_upper_item',
				name:'category_large_id'});
		});
	});
	</script>
</body>
</html>