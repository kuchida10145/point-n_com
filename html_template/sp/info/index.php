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
		<?php foreach($info_list as $info_data):?>
		<!--1件-->
		<dl class="clearfix">
			<dt><a href="detail.php?id=<?php echo $info_data['notice_id'];?>"><img src="<?php echo $info_data['image1'];?>" alt="<?php echo $info_data['title'];?>" /></a></dt>
			<dd> <?php echo date('Y/m/d',strtotime($info_data['display_date']));?><br />
			<a href="detail.php?id=<?php echo $info_data['notice_id'];?>"><?php echo $info_data['title'];?></a></dd>
		</dl>
		<!--/1件-->
		<?php endforeach;?>
		<input type="hidden" id="infocount" value="<?php echo $page_cnt;?>"></input>
		<input type="hidden" id="pagecount" value="<?php echo $page_cnt;?>"></input>
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
    $(window).scroll(function(ev) {
        var $window = $(ev.currentTarget),
            height = $window.height(),
            scrollTop = $window.scrollTop(),
            documentHeight = $(document).height() - 150;
        var infocount = document.getElementById("infocount").value;

        if (documentHeight < height + scrollTop) {

            //page++;
			$.ajax({
				type: "GET",
				url: "/info/?m=next&next="+infocount,
				dataType: "json",
				success: function(res){
					if(res.result=='false'){
						return;
					}

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
					var pagecount = document.getElementById("pagecount").value;
					infocount =  parseInt(infocount) + parseInt(pagecount);
					document.getElementById("infocount").value = infocount;
					$('.shoplist').append(html);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					//page--;

				}
			});

        }
    });
});
</script>

</body>
</html>
