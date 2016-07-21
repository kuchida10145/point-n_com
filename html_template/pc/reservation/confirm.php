<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>予約確認　|　point.com</title>
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
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">予約内容確認</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb30">予約内容確認</h3>
							<form action="confirm.php?m=thanks&tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
							<input type="hidden" name="m" value="thanks" />
								<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03 mb25">
								<tbody>
									<tr>
										<th width="35%">今回獲得PT</th>
										<td><?php echo $get_point;?>PT</td>
									</tr>
									<tr>
										<th>コース名</th>
										<td><?php echo getParam($post, 'course_name');?></td>
									</tr>
									<tr>
										<th>利用店舗名</th>
										<td><?php echo getParam($post, 'store_name');?></td>
									</tr>
								</tbody>
								</table>
								<table border="0" cellpadding="0" cellspacing="0" class="shiborikomi_area_03 mb25">
								<tbody>
									<tr>
										<th width="35%">来店人数</th>
										<td><?php echo getParam($post, 'use_persons');?>　人</td>
									</tr>
									<tr>
										<th>来店日</th>
										<td><?php echo getParam($post, 'use_date');?></td>
									</tr>
									<tr>
										<th>利用時間<br />（到着時間）</th>
										<td><?php echo getParam($post, 'use_time');?>時　<?php echo getParam($post, 'use_min');?>分</td>
									</tr>
									<tr>
										<th>予約名</th>
										<td><?php echo getParam($post, 'reserved_name');?></td>
									</tr>
									<tr>
										<th>予約した<br />電話番号</th>
										<td><?php echo getParam($post, 'telephone1');?>-<?php echo getParam($post, 'telephone2');?>-<?php echo getParam($post, 'telephone3');?></td>
									</tr>
									<tr>
										<th>利用する<br />ポイント</th>
										<td><?php echo number_format(getParam($post, 'use_point'));?>PT</td>
									</tr>
									<tr>
										<th>支払合計</th>
										<td><?php echo number_format($total_price);?> 円</td>
										<input type="hidden" name="total_price" value="<?php echo number_format($total_price);?>" />
									</tr>
								</tbody>
								</table>
								<div class="">
									<p>上記内容を確認して「決定」ボタンを押してください</p>
									<p class="form_confirm_btn clearfix"><a href="index.php?m=index&tkn=<?php echo getGet('tkn');?>" class="linkbtn4 alncenter">戻る</a>
									<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">予約する</a></p>
								</div>
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
