<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>お気に入り一覧　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,お気に入り一覧" />
<meta name="description" content="お気に入り店舗一覧を表示いたします。" />
<?PHP include( dirname(__FILE__)."/../tpl/head.php");?>
</head>
<body id="genre" class="top">
<?PHP include( dirname(__FILE__)."/../tpl/header.php");?>
<!--container-->
<div class="container">
	<div class="mainbodybg01">
	<!--mainbody-->
		<div class="mainbody">
			<div class="contents clearfix">
			<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">お気に入り一覧</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02">
						<h3>お気に入り一覧 <?php echo number_format($total); ?>件中<em id="cur_shops"><?php echo number_format(count($list)); ?></em>件表示</h3>
							<?php if(!$list): ?>
							データがありませんでした
							<?php else: ?>
							<table class="table_list mt25">
							<?php foreach($list as $data):?>
								<tbody>
									<tr>
										<th scope="row">
											<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>"><?php echo getParam($data, 'store_name'); ?><br>
												<img src="<?php echo getParam($data, 'image1'); ?>" alt="" />
											</a>
										</th>
										<td>
											<ul>
												<li><?php echo getParam($data,'category_small_name');?>/<?php echo getParam($data,'region_name');?></li>
												<li>
												<?php if(getParam($data,'normal_point_status') == '1'):?>
													<span class="pint_list">ポイント：<?php echo number_format(getParam($data,'normal_point'));?>PT</span>
												<?php endif;?>
												<?php if(getParam($data,'event_point_status') == '1'):?>
													<span class="eventpint_list">イベント：<?php echo number_format(getParam($data,'event_point'));?>PT</span>
												<?php endif;?>
												</li>
												<li class="txt11">
												<?php
													echo (is_delivery(getParam($data, 'type_of_industry_id'))) ? '発エリア：' : '店舗住所：';
													echo getParam($data, 'address1') . getParam($data, 'address2');
												?>
												</li>
											</ul>
										</td>
									</tr>
								</tbody>
							<?php endforeach;?>
							</table>
							<?php endif;?>
						<p class="btn_page_top"><a href="/pc_test/">TOPページへ戻る</a></p>
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
