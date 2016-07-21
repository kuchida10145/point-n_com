<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>キャッチメール　店舗決定画面　|　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />
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
			<p class="ID_mane">会員NO.123456</p>
			<div class="contents clearfix">
			<?PHP include( dirname(__FILE__)."/../tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">キャッチメール　店舗決定画面</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb30">キャッチメール　店舗決定画面</h3>
							<div class="mb25">
								<p>キャッチメールの利用ありがとうございました。以下の条件で決定しました。</p>
								<p>また、利用時刻を過ぎますと予約がキャンセル扱いになってしまいます。ご了承ください。</p>
							</div>
							<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03 mb25">
							<tbody>
								<tr>
									<th width="35%">予約時刻</th>
									<td><?php echo getParam($post, 'reserved_date');?> 頃～</td>
								</tr>
								<tr>
									<th width="35%">来店人数</th>
									<td><?php echo getParam($post, 'use_persons');?>人</td>
								</tr>
								<tr>
									<th>ジャンル</th>
									<td>
									<?php
										$category_large_array = category_large();
										echo $category_large_array[getParam($post, 'category_large_id')];
									?>
									</td>
								</tr>
								<tr>
									<th>カテゴリ</th>
									<td>
									<?php
										$category_midium_array = category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
										echo $category_midium_array[getParam($post, 'category_midium_id')];
									?>
									</td>
								</tr>
								<tr>
									<th>店舗名</th>
									<td><?php echo getParam($post, 'store_name');?></td>
								</tr>
								<tr>
									<th>住所</th>
									<td><?php echo getParam($post, 'address1').getParam($post, 'address2');?></td>
								</tr>
								<tr>
									<th>電話番号</th>
									<td><?php echo getParam($post, 'telephone');?></td>
								</tr>
								<tr>
									<th>金額</th>
									<td><?php echo number_format(getParam($post, 'money'));?>円</td>
								</tr>
							</tbody>
							</table>
							<p class="btn_page_top"><a href=""../index.php"">TOPページへ戻る</a></p>
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
