<div id="header" class="clearfix">
<h1><a href="/">ポイント.com</a></h1>


<!--ヘッドメニュー-->
<div id="headmenu">
<ul>
<?php if($account):?>
<li id="hm1"><a href="/catch/index.php" class="accordion_search"><span class="icon-star"></span>キャッチメール</a></li>
<li id="hm1"><a href="/favorite/" class="accordion_search"><span class="icon-star"></span>お気に入り</a></li>
<li id="hm2"><a href="/mypage/logout.php" class="accordion_btn"><span class="icon-lock-filled"></span>ログアウト</a></li>
<?php else:?>
<li id="hm2"><a href="/login.php" class="accordion_btn"><span class="icon-lock-filled"></span>ログイン</a></li>
<?php endif;?>
<li id="hm2"><a class="right-menu" href="#right-menu"><span class="icon-menu"></span>メニュー</a></li>
</ul>
<hr class="none" />
</div>
<!--/ヘッドメニュー-->

</div>
<?php if($account):?>
<div id="headmenberinfo" class="clearfix">
<p>会員No.<?php echo $account['user_id'];?> <?php echo $account['nickname'];?>さん<br />
<?php if($point_code_flg == true):?><a href="/mypage/point_code/">ポイントコード一覧</a><?php endif;?></p>
<ul>
	<li><span>ポイント数 <strong><?php echo number_format($account['point']);?>T</strong></span></li>

</ul>
</div>
<?php endif;?>