
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $page_title;?> <?php echo $page_type_text;?>｜Point.com管理画面</title>
	<?php include_once dirname(__FILE__).'/../common/head.php';?>
</head>
<body>
	<!-- start: Header -->
	<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
        <!-- start: Main Menu -->
		<?php include_once dirname(__FILE__).'/../common/main_menu.php';?>	
		<!-- end: Main Menu -->
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<!-- start: Content -->
			<!--********** コンテンツはここから **********-->
			<div id="content" class="span10">
				<ul class="breadcrumb">
					<li>
						<i class="icon-home"></i>
						<a href="index.php">Home</a> 
						<i class="icon-angle-right"></i>
					</li>
					<li><a href="account.php"><?php echo $page_title;?></a><i class="icon-angle-right"></i></li>
					<li><a href="#"><?php echo $page_type_text;?></a></li>
					
					
				</ul>

				
				<h1><?php echo $page_title;?></h1>           
 
  
            
				<div class="row-fluid">
					<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $page_type_text;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
						
					<div class="box-content">
						<form class="form-horizontal" action="?m=confirm&tkn=<?php echo getGet('tkn');?>" method="post">
							<input type="hidden" value="confirm" name="m">
							
   <div class="control-group">
								<label class="control-label" for="selectError3">WEBサービス</label>
								<div class="controls">
								 <button class="btn btn-success">運営中</button>
                                 
                                 <button class="btn btn-warning">準備中</button>
                                 
                                 <button class="btn btn-danger">停止中</button>
                                 
								</div>
							  </div>
                              
         
                   <div class="box-header" data-original-title="">
						アカウント管理
					</div> <br>                 <div class="control-group">
<label for="" class="control-label">入会日(登録日)</label>
                    <div class="controls">2015/1/26</div>
                                </div>                    
                              
                <div class="control-group">
<label for="" class="control-label">店舗名</label>
                <div class="controls">店舗名が入ります<br>
			    新着店舗</div>
                                </div>              
                                
                <div class="control-group">
				<label class="control-label" for="selectError3">業種</label>
				<div class="controls">
                
                店舗型風俗
                
								  
                                 
                                  　　
								</div>
						    </div>                
                    
                                   <div class="control-group">
							  <label class="control-label" for="fileInput">許可証の表示</label>
							 <div class="controls"><img src="img/sample01.jpg" alt=""/></div>
							</div>
                    
                              
                     <div class="control-group">
							  <label class="control-label" for="typeahead">ログインID</label>
							  <div class="controls">asdfgh</div>
							</div>
                              
                              
                            <div class="control-group">
							  <label class="control-label" for="typeahead">ログインPW</label>
							  <div class="controls">
zxcvbnm
</div>
							</div>
                            
                            
                  <div class="box-header" data-original-title="">
						ショップデータ</div> <br>                 


<div class="control-group">
<label class="control-label" for="fileInput">画像の登録</label>
						<div class="controls">
                        
                        <div class="masonry-gallery">
														<div id="image-1" class="masonry-thumb">
								<a style="background:url(img/gallery/photo1.jpg)" title="Sample Image 1" href="img/gallery/photo1.jpg"><img class="grayscale" src="img/gallery/photo1.jpg" alt="Sample Image 1"></a>
							</div>
														<div id="image-2" class="masonry-thumb">
								<a style="background:url(img/gallery/photo2.jpg)" title="Sample Image 2" href="img/gallery/photo2.jpg"><img class="grayscale" src="img/gallery/photo2.jpg" alt="Sample Image 2"></a>
							</div>
														<div id="image-3" class="masonry-thumb">
								<a style="background:url(img/gallery/photo3.jpg)" title="Sample Image 3" href="img/gallery/photo3.jpg"><img class="grayscale" src="img/gallery/photo3.jpg" alt="Sample Image 3"></a>
							</div>
														<div id="image-4" class="masonry-thumb">
								<a style="background:url(img/gallery/photo4.jpg)" title="Sample Image 4" href="img/gallery/photo4.jpg"><img class="grayscale" src="img/gallery/photo4.jpg" alt="Sample Image 4"></a>
							</div>
														<div id="image-5" class="masonry-thumb">
								<a style="background:url(img/gallery/photo5.jpg)" title="Sample Image 5" href="img/gallery/photo5.jpg"><img class="grayscale" src="img/gallery/photo5.jpg" alt="Sample Image 5"></a>
							</div>
														<div id="image-6" class="masonry-thumb">
								<a style="background:url(img/gallery/photo6.jpg)" title="Sample Image 6" href="img/gallery/photo6.jpg"><img class="grayscale" src="img/gallery/photo6.jpg" alt="Sample Image 6"></a>
							</div>
														<div id="image-7" class="masonry-thumb">
								<a style="background:url(img/gallery/photo7.jpg)" title="Sample Image 7" href="img/gallery/photo7.jpg"><img class="grayscale" src="img/gallery/photo7.jpg" alt="Sample Image 7"></a>
							</div>
														<div id="image-8" class="masonry-thumb">
								<a style="background:url(img/gallery/photo8.jpg)" title="Sample Image 8" href="img/gallery/photo8.jpg"><img class="grayscale" src="img/gallery/photo8.jpg" alt="Sample Image 8"></a>
							</div>
														<div id="image-9" class="masonry-thumb">
								<a style="background:url(img/gallery/photo9.jpg)" title="Sample Image 9" href="img/gallery/photo9.jpg"><img class="grayscale" src="img/gallery/photo9.jpg" alt="Sample Image 9"></a>
							</div>
														
													</div>
					</div>
                   </div>
                          
                            <div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">お店からのお知らせ</label>
							  <div class="controls">
								テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。
							  </div>
							</div>
                            
                             <div class="control-group">
							  <label class="control-label" for="typeahead">郵便番号</label>
						     <div class="controls">
999 
-
99999
</div>
							</div>


<div class="control-group">
				<label class="control-label" for="selectError3">都道府県</label>
				<div class="controls">
                
                 愛知県
                
								  
                                 
                                  　　
</div>
						    </div>  
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead">市町村番地</label>
					        <div class="controls">
名古屋市中区
</div>
							</div>
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead">マンション/ビル名</label>
					        <div class="controls">
ああああビル2F
</div>
							</div>
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead">営業時間</label>
					        <div class="controls">
10:00 ～24:00
</div>
							</div>
                              
                            <div class="control-group">
						    <label class="control-label" for="typeahead">電話番号</label>
					        <div class="controls">
052 
-
0000
 -
0000
</div>
</div>   
          
       <div class="control-group">
							  <label class="control-label" for="typeahead">公式サイト1</label>
					        <div class="controls">
http://www.yahoo.co.jp/
</div>
							</div>   
                            
     <div class="control-group">
							  <label class="control-label" for="typeahead">公式サイト2</label>
					        <div class="controls">
http://www.yahoo.co.jp/
</div>
							</div>   
                            
                            
                          <div class="control-group">
							  <label class="control-label" for="typeahead">公式サイト3</label>
					        <div class="controls">
http://www.yahoo.co.jp/
</div>
							</div>   
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead">公式サイト4</label>
					        <div class="controls">
http://www.yahoo.co.jp/
</div>
							</div>   
                            
                            
                            <div class="box-header" data-original-title="">
						その他</div> <br>    <div class="control-group">
					    <label class="control-label" for="typeahead">担当者名</label>
						     <div class="controls">姓
山田
名
太郎
</div>
							</div>             
                              
                            <div class="control-group">
						    <label class="control-label" for="typeahead">メールアドレス</label>
					        <div class="controls">
asdfg@gmail.com
<br></div>
							</div>  
                            
                             <div class="control-group">
							  <label class="control-label" for="typeahead"><strong>銀行1</strong></label>
					        <div class="controls"></div>
							</div>      
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">銀行名</label>
					        <div class="controls">ああああ銀行</div>
							</div>    
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座番号</label>
					        <div class="controls">普通
123456
</div>
							</div>  
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座名義人</label>
					        <div class="controls">山田太郎</div>
							</div> 
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead"><strong>銀行2</strong></label>
					        <div class="controls"></div>
							</div>      
                            
                              <div class="control-group">
						    <label class="control-label" for="typeahead">銀行名</label>
					        <div class="controls">ああああ銀行</div>
							</div>    
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座番号</label>
					        <div class="controls">普通
123456
</div>
							</div>  
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座名義人</label>
					        <div class="controls">山田太郎</div>
							</div> 
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead"><strong>銀行3</strong></label>
					        <div class="controls"></div>
							</div>      
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">銀行名</label>
					        <div class="controls">ああああ銀行</div>
							</div>    
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座番号</label>
					        <div class="controls">普通
123456
</div>
							</div>  
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座名義人</label>
					        <div class="controls">山田太郎</div>
							</div> 
                            
                            <div class="control-group">
							  <label class="control-label" for="typeahead"><strong>ゆうちょ銀行</strong></label>
					        <div class="controls"></div>
							</div>      
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">記号</label>
					        <div class="controls">
12345
-
01
</div>
							</div>    
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">番号</label>
					        <div class="controls">
12345
</div>
							</div>  
                            
                            <div class="control-group">
						    <label class="control-label" for="typeahead">口座名義人</label>
					        <div class="controls">山田太郎</div>
							</div> 
							
							
							
                            <div class="control-group">
							  <label class="control-label" for="typeahead">ユーザー名</label>
								<div class="controls">
									<?php echo getParam($post,'account_name');?>
								</div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="typeahead">ログインID</label>
								<div class="controls">
									<?php echo getParam($post,'login_id');?>
								</div>
							</div>
                                                       
                            <div class="control-group">
								<label class="control-label" for="typeahead">ログインPW</label>
								<div class="controls">
									設定したパスワード
								</div>
							</div>
                                  
							<div class="control-group">
								<label class="control-label">権限</label>
								<div class="controls">
									<?php echo getParam(permission_kind(),$post['permission_kind']);?>
								</div>
							</div>
                            
							<div class="control-group">
							<label class="control-label" for="selectError3">利用</label>
								<div class="controls">
									<?php echo getParam(account_status(),$post['status_id']);?>
								</div>
							</div>
                             
                              
                            <div class="form-actions">
								<button class="btn btn-primary" type="submit">保存</button>
								<button type="button" onclick="location.href='?m=edit&tkn=<?php echo getGet('tkn');?>'" class="btn">戻る</button>
							</div>
						</form>
					</div>
				</div><!--/span-->
				</div><!--/row-->

			</div><!--/.fluid-container-->
			<!-- end: Content -->
			<!--********** コンテンツはここまで **********-->
			
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
		
	<div class="clearfix"></div>
	<footer>
		<p>
			<span style="text-align:left;float:left">Copyright 2015 POINT.COM All Rights Reserved </span>
		</p>
	</footer>
	<!-- start: JavaScript-->
	<?php include_once dirname(__FILE__).'/../common/footer_javascript.php';?>
	<!-- end: JavaScript-->
</body>
</html>