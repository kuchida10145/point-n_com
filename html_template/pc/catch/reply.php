<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>キャッチメール　返信一覧　|　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
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
				<div class="shiborikomi_page02 reservation_use_point">
					<div class="shiborikomi_step">
						<p class="heartitle">キャッチメール　返信一覧</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 form_confirm">
							<h3 class="mb30">キャッチメール　返信一覧</h3>
							<?php if (isset($reply_shops_data) && !empty($reply_shops_data)) : ?>
								<table class="table_list">
								<tbody>
								<?php foreach($reply_shops_data as $data) : ?>
								<tr>
									<?php $store_name = getParam($data, 'store_name'); ?>
									<th scope="row">
										<a href="/stores/detail.php?id=<?php echo getParam($data, 'store_id'); ?>"><?php echo $store_name; ?><br>
										<img src="/files/images/<?php echo getParam($data, 'image1'); ?>" alt="<?php echo $store_name; ?>" /></a>
									</th>
									<td>
										<ul>
											<li>返信日時：<?php echo getParam($data, 'mail_regist_date'); ?></li>
											<li>住所：<?php echo getParam($data, 'address1') . getParam($data, 'address2'); ?></li>
											<li>TEL：<?php echo getParam($data,'telephone');?></li>
											<li>
												<div class="chach_message">
													金額：<?php echo number_format(getParam($data, 'money')); ?>円<br>
													アピール：<?php echo getParam($data, 'appeal'); ?>
												</div>
											</li>
											<li>
												<div class="chach_contact">
													<a class="eventtag" href="replyconfirm.php?id=<?php echo getParam($data,'catchmail_return_id');?>&tkn=<?php echo $tkn;?>">決定</a>
												</div>
											</li>
										</ul>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
							</table>
							<?php else : ?>
							店舗からの返信がありません。
							<?php endif;?>
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
