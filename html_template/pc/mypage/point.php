<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $page_title;?>｜ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,ポイント履歴" />
<meta name="description" content="ポイント履歴を表示いたします。" />
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
						<p class="heartitle">ポイント履歴</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="mb30">ポイント履歴</h3>
							<p>ポイント状況記号：未=未処理 / 済=処理済 / ★=特別PT / キ=キャンセル
							</p>
							<?php if(!$list):?>
							データがありませんでした
							<?php else:?>
							<table class="point_rireki_table mtb10">
								<tbody>
									<tr>
										<th>来店日</th>
										<th> 利用店舗名</th>
										<th>ポイント状況</th>
										<th>ポイント利用</th>
										<th>ポイント取得</th>
									</tr>
									<?php foreach($list as $data):?>
									<tr>
										<td><?php echo getParam($data,'use_date');?></td>
										<td><a href="/mypage/point_code/detail.php?id=<?php echo getParam($data,'reserved_id');?>"><?php echo getParam($data,'store_name');?></a></td>
										<?php if(getParam($data,'status_id') == 1):?>
											<td align="center" style="color:#ff0000;"><?php echo "未";?></td>
										<?php elseif (getParam($data,'status_id') == 2):?>
											<td align="center"><?php echo "済";?></td>
										<?php elseif (getParam($data,'status_id') == 9):?>
											<td align="center"><?php echo "★";?></td>
										<?php elseif (getParam($data,'status_id') == 0):?>
											<td align="center" style="color:#ff0000;"><?php echo "キ";?></td>
										<?php endif;?>
										<td align="center"><?php echo number_format(getParam($data,'use_point'));?>PT</td>
										<td align="center"><?php echo number_format(getParam($data,'get_point'));?>PT</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							<p>ポイント履歴で表示される期間は利用した日時より1年間とし、それ以前の履歴は自動削除されますので、予めご了承ください。</p>
							<?php echo $pager_html;?>
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
