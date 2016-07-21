<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>店舗決定確認画面　|　point.com</title>
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
				<div class="shiborikomi_page02 reservation_use_point">
					<div class="shiborikomi_step">
						<p class="heartitle">店舗決定確認画面</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 form_confirm">
						<h3 class="mb30">店舗決定確認画面</h3>
							<form action="replyconfirm.php?m=thanks&tkn=<?php echo getGet('tkn');?>" method="post" name="frm">
								<input type="hidden" name="m" value="thanks" />
								<div class="mb25">
									<h4>予約時間</h4>
									<p><?php echo getParam($post, 'reserved_date');?></p>
								</div>
								<div class="mb25">
									<h4>予約人数</h4>
									<p><?php echo getParam($post, 'use_persons');?>人</p>
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
									<h4>カテゴリー</h4>
									<p>
									<?php
										$category_midium_array = category_midium(getParam($post, 'category_large_id'), getParam($post, 'area_first_prefectures_id'), 0);
										echo $category_midium_array[getParam($post, 'category_midium_id')];
									?>
									</p>
								</div>
								<div class="mb25">
									<h4>店舗名</h4>
									<p><?php echo getParam($post, 'store_name');?></p>
								</div>
								<div class="mb25">
									<h4>住所</h4>
									<p><?php echo getParam($post, 'address1').getParam($post, 'address2');?></p>
								</div>
								<div class="mb25">
									<h4>電話番号</h4>
									<p><?php echo getParam($post, 'telephone');?></p>
								</div>
								<div class="mb25">
									<h4>料金</h4>
									<p><?php echo number_format(getParam($post, 'money'));?>円</p>
								</div>
								<input type="hidden" name="catchmail_id" value="<?php echo getParam($post, 'catchmail_id');?>" />
								<input type="hidden" name="catchmail_return_id" value="<?php echo getParam($post, 'catchmail_return_id');?>" />
								<input type="hidden" name="store_name" value="<?php echo getParam($post, 'store_name');?>" />
								<div class="mb25">
									<h4>注意事項</h4>
									<p class="clrred">必ず決定前に店舗へ電話連絡を行ってください。</p>
								</div>
								<p class="form_confirm_btn_info txt11">※上記内容を確認して「決定」ボタンを押してください</p>
								<p class="form_confirm_btn clearfix"><a href="index.php?tkn=<?php echo getGet('tkn');?>" class="linkbtn4 alncenter">戻る</a>
								<a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn alncenter">決定</a></p>
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
