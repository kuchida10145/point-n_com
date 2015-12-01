<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>お店からのお知らせ｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../../common/header_meta.php';?>
</head>
<body id="register">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../../common/header_contents.php';?>
<!--ヘッダ-->
<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">

<!--コンテンツ-->
<div class="contents">
	<h2>お店からのお知らせ</h2>
	<?php if(!$notice_list):?>
	<p>現在お知らせはありません</p>
	<?php else:?>
	<div class="shoplist">
		<div class="shoplist_val">
			<?php foreach($info_list as $info_data):?>
				<!--1件-->
				<dl class="clearfix">
					<dt><a href="detail.php?id=<?php echo $info_data['notice_id'];?>"><img src="<?php echo $info_data['image1'];?>" alt="<?php echo $info_data['title'];?>" /></a></dt>
					<dd> <?php echo date('Y/m/d',strtotime($info_data['display_date']));?><br />
					<a href="detail.php?id=<?php echo $info_data['notice_id'];?>"><?php echo $info_data['title'];?></a></dd>
				</dl>
				<!--/1件-->
			<?php endforeach;?>
			<input type="hidden" id="pagecount" value="0"></input>
		</div>
		<div id="loading" style="display:none">
			<dl class="clearfix">
				<dt><img src="/img/loading-icon.gif" alt="loading" /></dt>
				<dd><br />読み込み中</dd>
			</dl>
		</div>
	</div>
	<?php endif;?>

</div>
<!--/コンテンツ-->

<div id="footer">
<address>
Copyright 2015 POINT.COM All Rights Reserved
</address>
</div>

</div>
<!--/ページメイン部分-->
</div>
<!--/メイン全体-->


</div>

<!--/全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/../../common/slide_contents.php';?>
<!-- /スライド-->
<script type="text/javascript">

$(function() {
	var page_cnt = 0;
	$(window).scroll(function(ev) {
		var $window = $(ev.currentTarget),
			height = $window.height(),
			scrollTop = $window.scrollTop(),
			documentHeight = $(document).height() - 50;
		var loading_style = document.getElementById("loading").style.display;
		if (documentHeight < height + scrollTop && loading_style == "none") {
			document.getElementById("loading").style.display = "inline";
			page_cnt = Number(document.getElementById("pagecount").value) + 1;
			$.ajax({
				type: "GET",
				url: "/stores/news.php?m=next&next="+page_cnt+"&sid=<?php echo getGet('sid');?>",
				dataType: "json",
				success: function(res){
					if(res.result=='false'){
						setTimeout(function() {
							document.getElementById("loading").style.display = "none";
						}, 500);
						return;
					}
					setTimeout(function() {
						document.getElementById("loading").style.display = "none";
						var html = "";
						for(var i = 0; i < res.pages.length; i++){
							var page = res.pages[i];
							var notice_id = page.notice_id;
							var image1  = page.image1;
							var title  = page.title;
							var display_date  = page.display_date;
							html+='<dl class="clearfix">';
							html+='	<dt><a href="news_detail.php?id='+notice_id+'"><img src="'+image1+'" alt="'+title+'" /></a></dt>';
							html+='	<dd> '+display_date+'<br />';
							html+='	<a href="news_detail.php?id='+notice_id+'">'+title+'</a></dd>';
							html+='</dl>';
						}
						$('.shoplist_val').append(html);
					}, 1500);
					document.getElementById("pagecount").value = page_cnt;
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
