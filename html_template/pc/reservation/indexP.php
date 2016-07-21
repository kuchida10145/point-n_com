<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>予約画面　|　point.com</title>
<meta name="keywords" content="point.com,ポイントドットコム,キャバクラ,風俗,ホスト,ガールズウォーター,ネット予約,全国,店舗一覧" />
<meta name="description" content="店舗検索結果一覧を表示いたします。" />
<link href="../css/layout.css" rel="stylesheet" type="text/css" />

<!--<link rel="stylesheet" href="css/jquery.bxslider.css">-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script src="../js/fixHeight.js" type="text/javascript"></script>

<link rel="stylesheet" href="../css/slick.css" />
<script src="../js/slick.js" type="text/javascript"></script>

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
</head>

<body id="genre" class="top">
<?PHP include( $_SERVER['DOCUMENT_ROOT']."/pc_test_tsunekawa/tpl/header.php");?>
<!--container-->
<div class="container">
<div class="mainbodybg01">
<!--mainbody-->

<div class="mainbody">
<p class="ID_mane">会員NO.123456</p>
<div class="contents clearfix">

<?PHP include( $_SERVER['DOCUMENT_ROOT']."/pc_test_tsunekawa/tpl/side.php");?>

  
  <div class="shiborikomi_page02">
    <div class="shiborikomi_step">
      <p class="heartitle">利用店名:ヘルス　ファッションヘルス　名古屋　熱田堀田</p>
    </div>
    
    <div class="shiborikomi_genre">
<!--    	<div class="shiborikomi_genre_01">
      <h3 class="clearfix">選んだ条件<span class="fltright"><a href="#">条件変更</a></span></h3>
      <ul class="clearfix">
      	<li class="page01_select_girl">キャバクラ</li>
      	<li class="page01_select_area">東海</li>
        <li class="page01_select_genre">キャバクラ</li>
        <li class="page01_select_genre">キャバクラ</li>
      	<li class="page01_select_area">名古屋</li>
      	<li class="page01_select_area">中区</li>
      </ul>
      </div>
-->      
    	<div class="shiborikomi_genre_02 reservation_use_point">
        <h3 class="mb30">予約画面</h3>

        <form method="post" action="" name="frm">
        <input type="hidden" name="m" value="confirm" />
        <div class="mb25">
          <h4> コース選択<span class="clrred">※</span></h4>
          <p class="mb10">
          <label for="store_name">利用店名：ヘルス　ファッションヘルス　名古屋　熱田堀田</label>
          </p>
          <p>
          <select name="course_id">
          <option value="" data-id="">選択してください。</option>
          <option value="63" data-id="100,000">クーポン利用のみのコース①</option>
          <option value="64" data-id="20,000">クーポン利用のみのコース②</option>
          <option value="65" data-id="30,000">クーポン利用のみのコース③</option>
          <option value="66" data-id="40,000">クーポン利用のみのコース④</option>
          </select>
          </p>
        </div>
        
        <div class="mb25">
          <h4>来客人数<span class="clrred">※</span></h4>
          <p>
          <select name="use_persons">
          <option value="1" >1</option>
          <option value="2" >2</option>
          <option value="3" >3</option>
          <option value="4" >4</option>
          <option value="5" >5</option>
          <option value="6" >6</option>
          <option value="7" >7</option>
          <option value="8" >8</option>
          <option value="9" >9</option>
          <option value="10" >10</option>
          <option value="11" >11</option>
          <option value="12" >12</option>
          <option value="13" >13</option>
          <option value="14" >14</option>
          <option value="15" >15</option>
          <option value="16" >16</option>
          <option value="17" >17</option>
          <option value="18" >18</option>
          <option value="19" >19</option>
          <option value="20" >20</option>
          <option value="21" >21</option>
          <option value="22" >22</option>
          <option value="23" >23</option>
          <option value="24" >24</option>
          <option value="25" >25</option>
          <option value="26" >26</option>
          <option value="27" >27</option>
          <option value="28" >28</option>
          <option value="29" >29</option>
          <option value="30" >30</option>
          <option value="31" >31</option>
          <option value="32" >32</option>
          <option value="33" >33</option>
          <option value="34" >34</option>
          <option value="35" >35</option>
          <option value="36" >36</option>
          <option value="37" >37</option>
          <option value="38" >38</option>
          <option value="39" >39</option>
          <option value="40" >40</option>
          <option value="41" >41</option>
          <option value="42" >42</option>
          <option value="43" >43</option>
          <option value="44" >44</option>
          <option value="45" >45</option>
          <option value="46" >46</option>
          <option value="47" >47</option>
          <option value="48" >48</option>
          <option value="49" >49</option>
          <option value="50" >50</option>
          </select>
          人
          </p>
        </div>
        
        <div class="mb25">
          <h4>来店日<span class="clrred">※</span></h4>
          <p>
          <input name="use_date" id="date_from" value="" title="来店日" type="text" readonly><a class="calenderbox"  onclick="$('#date_from').focus();"><span class="icon-calendar"></span></a></p>
        </div>
        
        <div class="mb25">
          <h4>利用時間（到着時刻）<span class="clrred">※</span></h4>
          <p>
          <select name="use_time">
          <option value="0" >0</option>
          <option value="1" >1</option>
          <option value="2" >2</option>
          <option value="3" >3</option>
          <option value="4" >4</option>
          <option value="5" >5</option>
          <option value="6" >6</option>
          <option value="7" >7</option>
          <option value="8" >8</option>
          <option value="9" >9</option>
          <option value="10" >10</option>
          <option value="11" >11</option>
          <option value="12" >12</option>
          <option value="13" >13</option>
          <option value="14" >14</option>
          <option value="15" >15</option>
          <option value="16" >16</option>
          <option value="17" >17</option>
          <option value="18" >18</option>
          <option value="19" >19</option>
          <option value="20" >20</option>
          <option value="21" >21</option>
          <option value="22" >22</option>
          <option value="23" >23</option>
          </select>
          時
          <select name="use_min">
          <option value="0" >0</option>
          <option value="1" >1</option>
          <option value="2" >2</option>
          <option value="3" >3</option>
          <option value="4" >4</option>
          <option value="5" >5</option>
          <option value="6" >6</option>
          <option value="7" >7</option>
          <option value="8" >8</option>
          <option value="9" >9</option>
          <option value="10" >10</option>
          <option value="11" >11</option>
          <option value="12" >12</option>
          <option value="13" >13</option>
          <option value="14" >14</option>
          <option value="15" >15</option>
          <option value="16" >16</option>
          <option value="17" >17</option>
          <option value="18" >18</option>
          <option value="19" >19</option>
          <option value="20" >20</option>
          <option value="21" >21</option>
          <option value="22" >22</option>
          <option value="23" >23</option>
          <option value="24" >24</option>
          <option value="25" >25</option>
          <option value="26" >26</option>
          <option value="27" >27</option>
          <option value="28" >28</option>
          <option value="29" >29</option>
          <option value="30" >30</option>
          <option value="31" >31</option>
          <option value="32" >32</option>
          <option value="33" >33</option>
          <option value="34" >34</option>
          <option value="35" >35</option>
          <option value="36" >36</option>
          <option value="37" >37</option>
          <option value="38" >38</option>
          <option value="39" >39</option>
          <option value="40" >40</option>
          <option value="41" >41</option>
          <option value="42" >42</option>
          <option value="43" >43</option>
          <option value="44" >44</option>
          <option value="45" >45</option>
          <option value="46" >46</option>
          <option value="47" >47</option>
          <option value="48" >48</option>
          <option value="49" >49</option>
          <option value="50" >50</option>
          <option value="51" >51</option>
          <option value="52" >52</option>
          <option value="53" >53</option>
          <option value="54" >54</option>
          <option value="55" >55</option>
          <option value="56" >56</option>
          <option value="57" >57</option>
          <option value="58" >58</option>
          <option value="59" >59</option>
          </select>
          分
          </p>
        </div>
        
        <div class="mb25">
          <h4>予約名<span class="clrred">※</span></h4>
          <p>
          <input name="reserved_name" type="text" id="reserved_name" size="20" style="width:90%;" value=""/>
          </p>
        </div>
        
        <div class="mb25">
          <h4>予約した電話番号<span class="clrred">※</span></h4>
          <p>
          <input name="telephone1" type="text" id="telephone1" size="5" value=""/>
          -
          <input name="telephone2" type="text" id="telephone2" size="5" value=""/>
          -
          <input name="telephone3" type="text" id="telephone3" size="5" value=""/>
          </p>
        </div>
        
        <div class="mb25">
          <h4>利用料金</h4>
          <p>
          <span id="price">10,000</span>
          円</p>
        </div>
        
        <div class="mb25">
          <h4>利用するポイント</h4>
          <p>
          <select name="use_point">
          <option value="" selected="selected">選択してください。</option>
          </select>
          PT
          </p>
        </div>
        
        <h4> 個人情報取得への同意<span class="clrred">※</span></h4>
        <p class="mb10"><input type="checkbox" name="contract" id="contract" />
        同意する</p>
        <p class="txt12"><a href="../info/kojin.html">個人情報の取得はこちら</a><br />※上記の入力内容を確認して「確認画面へ」ボタンを押してください</p>
        <p class="stopr_linkbtn"><a href="reservation_thanks.html" onclick="document.frm.submit();" class="linkbtn block alncenter">確認画面へ</a></p>
        
        </form>

      </div>
    </div>
  </div>
</div><!--/.contents-->
</div><!--/mainbody-->

</div><!--/.mainbodybg01-->
</div><!--/.container-->
<?PHP include( $_SERVER['DOCUMENT_ROOT']."/pc_test_tsunekawa/tpl/footer.php");?>
</body>
</html>
