<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>今日のニュース一覧　|　ポイント.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,お知らせ, ニュース" />
<meta name="description" content="選択された地域の店舗からのお知らせ一覧をご覧いただけます。" />
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
			<?PHP include( $_SERVER['DOCUMENT_ROOT']."/pc_test/tpl/side.php");?>
				<div class="shiborikomi_page02">
					<div class="shiborikomi_step">
						<p class="heartitle">今日のニュース一覧</p>
					</div>
					<div class="shiborikomi_genre">
						<div class="shiborikomi_genre_02 reservation_use_point">
							<h3 class="">今日のニュース一覧</h3>
							<?php if(!$news_list):?>
							<p>現在お知らせはありません</p>
							<?php else:?>
							<table class="table_list">
								<tbody>
									<?php foreach($news_list as $info_data):?>
									<!--1件-->
									<tr>
										<th scope="row"><a href="detail.php?id=<?php echo $info_data['notice_id'];?>"><img src="<?php echo $info_data['image1'];?>" alt="<?php echo $info_data['title'];?>" /></a></th>
										<td> <?php echo date('Y/m/d',strtotime($info_data['display_date']));?><br />
										<a href="detail.php?id=<?php echo $info_data['notice_id'];?>"><?php echo $info_data['title'];?></a></td>
									</tr>
									<!--/1件-->
									<?php endforeach;?>
								</tbody>
							</table>
							<input type="hidden" id="pagecount" value="0"></input>
							<input type="hidden" id="load_flg" value="false"></input>
							<div id="loading" style="display:none">
								<dl class="clearfix">
									<dt><img src="/img/loading-icon.gif" alt="loading" /></dt>
									<dd><br />読み込み中</dd>
								</dl>
							</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div><!--/.contents-->
		</div><!--/mainbody-->
	</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( dirname(__FILE__)."/../tpl/footer.php");?>
<script type="text/javascript">
$(function() {
	var page_cnt = 0;
	var region_id = <?php echo getGet('region_id');?>;
	$(window).scroll(function(ev) {
		var $window = $(ev.currentTarget),
			height = $window.height(),
			scrollTop = $window.scrollTop(),
			documentHeight = $(document).height() - 50;
		if (documentHeight < height + scrollTop  && document.getElementById("load_flg").value == "false") {
			document.getElementById("load_flg").value = "true";
			page_cnt = Number(document.getElementById("pagecount").value) + 1;
			$.ajax({
				type: "GET",
				url: "/news/?m=next&region_id="+region_id+"&next="+page_cnt,
				dataType: "json",
				success: function(res){
					if(res.result=='false'){
						document.getElementById("load_flg").value = "false";
						return;
					} else {
						document.getElementById("loading").style.display = "inline";
						setTimeout(function() {
							document.getElementById("loading").style.display = "none";
							var html = "";
							for(var i = 0; i < res.pages.length; i++){
								var page = res.pages[i];
								var news_id = page.news_id;
								var image1  = page.image1;
								var title  = page.title;
								var display_date  = page.display_date;
								html+='<dl class="clearfix">';
								html+='	<dt><a href="detail.php?id='+news_id+'"><img src="'+image1+'" alt="'+title+'" /></a></dt>';
								html+='	<dd> '+display_date+'<br />';
								html+='	<a href="detail.php?id='+news_id+'">'+title+'</a></dd>';
								html+='</dl>';
							}
							$('.shoplist_val').append(html);
							document.getElementById("pagecount").value = page_cnt;
							document.getElementById("load_flg").value = "false";
						}, 1500);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					page_cnt--;
				}
			});
        }
    });
});
</script>
</body>
</html>
