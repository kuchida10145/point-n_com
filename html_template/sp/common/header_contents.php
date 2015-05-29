<div id="header" class="clearfix">
<h1><a href="/">ポイント.com</a></h1>


<!--ヘッドメニュー-->
<div id="headmenu">
<ul>
<?php if($account):?><li id="hm1"><a href="/store/favorite.html" class="accordion_search"><span class="icon-star"></span>お気に入り</a></li>
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