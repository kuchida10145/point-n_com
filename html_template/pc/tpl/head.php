<link href="/html_template/pc/css/layout.css" rel="stylesheet" type="text/css" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="/html_template/pc/js/jquery.bxslider.min.js" type="text/javascript"></script>
<script>
$(function(){
$('.bxslider').bxSlider({
	auto: true,
	slideWidth: 640,
	minSlides: 3
});
</script>

<!--トップページ　メイン画像スライド　設定-->
<script type="text/javascript">
$(function() {
	$('.top_slider').bxSlider({
	auto: true,
	slideWidth: 1500,
	pager: false,
	hideControlOnEnd: true
});
});
</script>

<!--店舗詳細　カルーセル設定-->
<link rel="stylesheet" href="/js/slick/slick.css">
<script src="/js/slick/slick.js"></script>

<script>
   $(function() {
      $('.photoslide').slick({
  dots: true,
    infinite: false,
    speed: 300 ,
      slidesToShow: 3,
    slidesToScroll: 3
      });
    });
</script>

<!--今日のお知らせ・ポイントドットコムからのお知らせ　カルーセル設定ー-->
<script>
 $(function() {
    $('.photoslide_new').slick({
dots: true,
  infinite: false,
  speed: 300
    });
  });
</script>
