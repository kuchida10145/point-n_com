<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="gps">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>

<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<!--ヘッダ-->

<div id="headsearch">
<form action="" name="" method="get">
<input type="hidden" name="m" value="search_keyword"/>
<input name="keyword" placeholder="店舗名検索" type="text"> 
<a href="#">検索</a>
</form>

</div>


<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">
<!--コンテンツ-->
<div class="contents">
<div class="selectedterms">
<dl>
<dt>選んだ条件</dt>
<dd><a href="#" class="block alncenter">条件変更</a></dd>
<dd><?php echo $condition_category_large_name; ?></dd>
<dd><?php echo $condition_redion_name; ?></dd>
<dd><?php echo $condition_category_midium_name; ?></dd>
<?php foreach ($condition_category_small_names as $small_name) : ?>
<dd><?php echo $small_name; ?></dd>
<?php endforeach; ?>
<?php foreach ($area_key_names as $area_name) : ?>
<dd><?php echo $area_name; ?></dd>
<?php endforeach; ?>
</dl>
</div>

<h2><a href="/news/index.php" class="newslistbtn">一覧をみる</a>今日のニュース</h2>
<div class="newslist">
<ul>
<li>
<a href="/news/detail.php?id=">2015/1/1　16:15<br />お宝ザクザク！無料で遊べちゃう！</a>
</li>
<li></li>
</ul>
</div>

<h2>店舗一覧　<?php echo $storeStart; ?>件～<?php echo $storeEnd; ?>件（全<?php echo $storesTotal; ?>件）</h2>

<div class="searchsetting clearfix">
<dl>
<dd>
並べ替え：
<select>
<option>通常ポイントが高い順</option>
<option>イベントポイントが高い順</option>
<option>通常ポイント総額料金が高い順</option>
<option>通常ポイント総額料金が低い順</option>
<option>イベントポイント総額料金が高い順</option>
<option>イベントポイント総額料金が低い順</option>
<option>新着店舗</option>
</select>
</dd>
</dl>
</div>

<div class="shoplist">
<?php if (isset($list) && !empty($list)) : ?>
	<?php foreach($list as $data) : ?>
		<dl class="clearfix">
			<a href="<?php echo HTTP_HOST; ?>/stores/detail.php?id=<?php echo $data['store_id']; ?>"></a>
			<dt>
				<?php if ( '' != getParam($data,'image1') ) : ?>
					<img src="../../../files/images/<?php echo getParam($data,'image1');?>" alt="" />
				<?php endif; ?>
			</dt>
			<dd>
				<strong>
					<?php echo getParam($data,'store_name');?>
				</strong><br />
				<?php echo getParam($data,'category_small_name');?>/<?php echo getParam($data,'region_name');?>

				<?php if(getParam($data,'normal_point_status') == '1'):?>
					<strong class="pointtag">
						ポイント
					</strong>
					<strong class="clrred">
						<?php echo number_format(getParam($data,'normal_point'));?>PT
					</strong>
				<?php endif;?>

				<?php if(getParam($data,'event_point_status') == '1'):?>
					<strong class="eventtag">
						イベント
					</strong>
					<strong class="clrgreen">
						<?php echo number_format(getParam($data,'event_point'));?>PT
					</strong>
				<?php endif;?>

				<?php echo getParam($data,'title');?><br />
				住所：<?php echo getParam($data,'address1');?><?php echo getParam($data,'address2');?><br />
			</dd>
		</dl>
	<?php endforeach;?>
	<?php echo $pager_html; ?>
<?php else : ?>
該当する店舗が見つかりませんでした
<?php endif;?>
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
</div>
<!--/メイン全体-->

</div>

<!--/全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!--/スライド-->

</body>
</html>
