
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?>｜Point.com管理画面</title>
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
				<h1><?php echo $page_title;?></h1>
				<?php echo $system_message;?>
				<!-- 検索フォーム-->
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon search"></i><span class="break"></span>検索条件</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
					<div class="box-content">
						<form class="form-horizontal" method="get">
						<div class="control-group">
							<label class="control-label" for="selectError3">クーポン種類</label>
							<div class="controls">
								<select name="point_kind">
									<?php foreach(point_kind() as $poi_id => $poi_name):?>
										<option value="<?php echo $poi_id;?>" <?php echo _check_selected($poi_id,getGet('point'));?>><?php echo $poi_name;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label for="" class="control-label">クーポン名</label>
							<div class="controls"><input placeholder="" id="" name="coupon_name" value="<?php echo getGet('coupon_name');?>" type="text"></div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">検索</button>
							<button type="reset" class="btn" onclick="location.href='?m=index'">リセット</button>
						</div>
                        </form>
                    </div>
					</div><!--/span-->
				</div><!--/row-->
				<!-- /検索フォーム -->
				<!-- 発行フォーム -->
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="icon-money"></i><span class="break"></span>発行</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form class="form-horizontal" method="get">
	           					<div class="alert alert-block">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<p>一度に発行できるクーポンは、通常、イベントそれぞれひとつになります。<br>
									有効中のものがほかにある場合は、こちらの操作が有効になります。</p>
								</div>
                            	<div class="control-group">
									<label class="control-label" for="selectError3">通常クーポン</label>
									<div class="controls">
										<select id="normal_course" name="normal_course">
											<option value="">選択してください。</option>
											<?php foreach(course_list($account_id,"1") as $cor_num=>$cor_val):?>
												<option value="<?php echo $cor_num;?>"><?php echo $cor_val;?></option>
											<?php endforeach;?>
										</select>
										<button type="submit" class="btn btn-small btn-success">有効にする</button>
									</div>
							  	</div>
                            	<div class="control-group">
									<label class="control-label" for="selectError3">イベントクーポン</label>
									<div class="controls">
									<select id="event_course" name="event_course">
										<option value="">選択してください。</option>
										<?php foreach(course_list($account_id,"2") as $cor_num=>$cor_val):?>
												<option value="<?php echo $cor_num;?>"><?php echo $cor_val;?></option>
										<?php endforeach;?>
									</select>
									<button type="submit" class="btn btn-small btn-success">有効にする</button></div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /発行フォーム -->

				<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>クーポン情報一覧</h2>
						<div class="box-icon"><a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a></div>
					</div>
					<div class="box-content">
						<p>
							<button class="btn btn-large btn-primary" onClick="location.href='?m=edit&p=1'">新規登録(通常ポイントクープン)</button>
							<button class="btn btn-large btn-danger" onClick="location.href='?m=edit&p=2'">新規登録(イベントポイントクーポン)</button>
						</p>
						<?php if(!$list):?>
						<p>データがありませんでした</p>
						<?php else:?>
						<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
						<tr>
							<th>発行</th>
							<th>クーポン種類</th>
							<th>クーポン名</th>
							<th>ポイント数</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($list as $coupon_data):?>
						<tr>
							<td class="center"><?php echo getParam(coupon_status_label(),$coupon_data['status_id']);?></td>
							<td><?php echo getParam(point_kind(),$coupon_data['point_kind']);?></td>
							<td class="center"><?php echo $coupon_data['coupon_name'];?></td>
							<td class="center"><?php echo getParam(point_data(),$coupon_data['point']);?>pt</td>
							<td class="center">
								<a class="btn btn-info" href="?m=edit&id=<?php echo $coupon_data['coupon_id'];?>"><i class="halflings-icon white edit"></i>編集</a>
								<a class="btn btn-danger" href="#myModal" role="button" class="btn" data-toggle="modal" data-id="<?php echo $coupon_data['coupon_id'];?>"><i class="halflings-icon white trash"></i>削除</a>
							</td>
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
</body>
</html>