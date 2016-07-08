<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>POINT.COMからのお知らせ｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="register">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<!--ヘッダ-->
<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">

<!--コンテンツ-->
<div class="contents">
	<h2>POINT.COMからのお知らせ</h2>
	<?php if(!$info_list):?>
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
			<input type="hidden" id="load_flg" value="false"></input>
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
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!-- /スライド-->
<script type="text/javascript">

$(function() {
	var page_cnt = 0;
	$(window).scroll(function(ev) {
		var $window = $(ev.currentTarget),
			height = $window.height(),
			scrollTop = $window.scrollTop(),
			documentHeight = $(document).height() - 40;
		if (documentHeight < height + scrollTop && document.getElementById("load_flg").value == "false") {
			document.getElementById("load_flg").value = "true";
			page_cnt = Number(document.getElementById("pagecount").value) + 1;
			$.ajax({
				type: "GET",
				url: "/info/?m=next&next="+page_cnt,
				dataType: "json",
				success: function(res){
					if(res.result=='false'){
						document.getElementById("load_flg").value = "false";
						return;
					} else {
						document.getElementById("loading").style.display = "inline";
						setTimeout(function() {
							var html = "";
							document.getElementById("loading").style.display = "none";
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
