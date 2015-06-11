<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ポイントコード表示（確認）｜ポイント.com</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<?php include_once dirname(__FILE__).'/../../common/header_meta.php';?>

		<!--[if lte IE 9]>
		<script src="/js/html5.js"></script>
		<script src="/js/css3-mediaqueries.js"></script>
		<![endif]-->


		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/obj.js"></script>
		<script type="text/javascript" src="/js/font-size.js"></script>
		<script type="text/javascript" src="/js/smooth.pack.js"></script>
		<script type="text/javascript" src="/js/acc.js"></script>

		<!--スライドメニュー-->
		<script src="/js/sidr/jquery.sidr.min.js"></script>
		<link rel="stylesheet" href="/js/sidr/jquery.sidr.light.css">
	</head>
	<body id="register">
		<?php include_once dirname(__FILE__).'/../../common/header_contents.php';?>
		
		<!--メイン全体-->
		<div id="mainbodywrap">
			<!--ページメイン部分-->
			<div id="mainbody" class="clearfix">
				<!--コンテンツ-->
				<div class="contents">
					<h2>ポイントコード表示（確認）</h2>
					<div class="pointhistory">
						<?php if(!$point_codes):?>
						データがありませんでした
						<?php else:?>
							<table border="0" cellpadding="0" cellspacing="0" class="table02">
								<tbody>
									<tr>
										<td class="bg12">来店日</td>
										<td class="bg12"> 利用店舗名</td>
										
									</tr>
									<?php foreach($point_codes as $point_code):?>
									<tr>
										<td><?php echo date('Y年m月d日 H:i',strtotime(getParam($point_code,'use_date')));?></td>
										<td><a href="/mypage/point_code/detail.php?id=<?php echo $point_code['reserved_id'];?>"><?php echo getParam($point_code,'store_name');?></a></td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							<p>ポイント履歴で表示される期間は利用した日時より1年間とし、それ以前の履歴は自動削除されますので、予めご了承ください。</p>
							
						<?php endif;?>
							<p class="alncenter"><a href="/" class="linkbtn">トップページに戻る</a></p>
					</div>
				</div>
			</div>
			<!--/コンテンツ-->
			<div id="footer">
				<address>
					Copyright 2015 POINT.COM All Rights Reserved
				</address>
			</div>
		</div>
		<!--/ページメイン部分-->
		<!--スライド-->
		<?php include_once dirname(__FILE__).'/../../common/slide_contents.php';?>
		<!-- /スライド-->
	</body>
</html>