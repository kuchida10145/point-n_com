/**
 * ファイルアップロードライブラリ
 *
 *
 */

/**
 * 画像アップロード
 *
 */
$(function(){

	$.fn.imageUpload = function(option)
	{
		var options = {
			url:'',			//処理するPHPプログラムURL
			name:'',		//結果を出力するタグのＩＤ(#はいらない
			multiple:false,
			max_cnt:1,

			//送信成功時の処理
			success:function(responseText,statusText,xhr,$form){
				//alert(responseText);
				//結果がテキスト形式で来るので、jsonのオブジェクトに変換
				var  res = $.parseJSON(responseText);


				//アップロード失敗
				if(res.result == 'false'){
					alert('ファイルのアップロードに失敗しました');
					$('#'+upload_btn).html(btn_txt);
					$('#'+upload_btn).removeAttr("disabled");
					return false;
				}
				//拡張子エラー
				if(res.result == 'mime_error'){
					alert('JPG、GIF、PNG以外の画像をアップロードすることはできません。');
					$('#'+upload_btn).html(btn_txt);
					$('#'+upload_btn).removeAttr("disabled");
					return false;
				}

				var base_dir   = res.base_dir;
				var image_name = res.image_name;
				//var thum_url   = base_dir+'thum/'+image_name;
				var thum_url = base_dir+res.image_name;
				var image_url  = base_dir+image_name;

				var block_html = '';



				var block = $(create_img_box(image_name,thum_url));



				//複数アップ可能な場合
				if(options.multiple == true){
					$('#'+result_name).append(block);
					//現在のアップロード数取得
					upload_cnt = $('#'+result_name+' .img_capbox').length;
					if(upload_cnt == options.max_cnt){
						$('#'+upload_btn).css('display','none');
					}
					$('#'+upload_btn).html(btn_txt);
					$('#'+upload_btn).removeAttr("disabled");
				}
				//単数のみの場合
				else{
					$('#'+result_name).html(block);
					$('#'+upload_btn).html('変更');
					$('#'+upload_btn).removeAttr("disabled");
				}

			},
			beforeSubmit: function(arr, $form, options){
				$('#'+upload_btn).html('アップロード中');
				$('#'+upload_btn).attr("disabled","disabled");
			},
			error:function(test)
			{
				//checkObject(test);
				alert("アップロードに失敗しました");
			}
		}

		$.extend(options,option);

		var name = option.name;
		var upload_cnt = 0;//アップロード済みのカウント
		var form = $('<form action="" method="post" enctype="multipart/form-data"></form>');

		/*ＩＤ関連*/
		var result_name = 'imgup_result_'+name;
		var upload_btn  = 'imgup_btn_'+name;
		var input_file  = 'imgup_file_'+name;


		/* 初期ボタンテキスト */
		var btn_txt = '追加';
		
		/*既に登録されている写真を取得*/
		var photos_html = $(this).html();
		$(this).html("");

		$(form).append('<input type="file" id="'+input_file+'" name="file" style="display:none" value=""><div ><label id="'+upload_btn+'" for="'+input_file+'" class="btn btn-success">'+btn_txt+'</label></div>');

		$(this).append('<div id="'+result_name+'"></div>');
		$(this).append(form);
		
		//どかしたHTMLを再入力
		$('#'+result_name).html(photos_html);

		//複数アップ可能な場合
		if(options.multiple == true){
			//現在のアップロード数取得
			upload_cnt = $('#'+result_name+' .img_capbox').length;
			if(upload_cnt == options.max_cnt){
				$('#'+upload_btn).css('display','none');
			}
		}

		//送信処理
		$('#'+input_file).change(function(){
			$(form).ajaxSubmit(options);
		});

		/**
         * 削除ボタン
         */
		$(document).on('click','#'+result_name+' .img_capbox .btn-delete',function(e){
			$('#'+$(this).data('id')).remove();
			$('#'+upload_btn).html(btn_txt);
			$('#'+upload_btn).css({'display':''});
			return false;
		 });


		function create_img_box(image_name,thum_url){
			var img_box = 'imgup_capbox_'+name;

			if(options.multiple == true){
				var randam = Math.floor(Math.random()*10000)
				var uni = (new Date().getTime())+randam.toString();
				img_box+=uni;
			}

			var block_html = '';
			block_html = '<div class="img_capbox" id="'+img_box+'" style="margin-bottom:10px;">';
			block_html+= '<div class="img_thumnail">';
			block_html+= '<a href="javascript:void(0);" class="btn-delete" data-id="'+img_box+'"><!-- img_thumnail -->';
			block_html+= '<i class="icon-remove"></i>';
			block_html+= '</a><!-- btn-delete -->';

			if(options.multiple == true){
				block_html+= '<input type="hidden" name="'+name+'['+uni+']" value="'+image_name+'" />';
			}
			else{
				block_html+= '<input type="hidden" name="'+name+'" value="'+image_name+'" />';
			}
			block_html+= '<img src="'+thum_url+'">';
			block_html+= '</div><!-- img_thumnail -->';
			block_html+= '</div><!-- img_capbox -->';



			return block_html;

		}
	}
});




/**
 * ファイルアップロード
 *
 */
$(function(){

	$.fn.fileUpload = function(option)
	{
		var options = {
			url:'',			//処理するPHPプログラムURL
			name:'',		//結果を出力するタグのＩＤ(#はいらない
			

			//送信成功時の処理
			success:function(responseText,statusText,xhr,$form){
				
				//alert(responseText);
				//結果がテキスト形式で来るので、jsonのオブジェクトに変換
				var  res = $.parseJSON(responseText);


				//アップロード失敗
				if(res.result == 'false'){
					alert('ファイルのアップロードに失敗しました');
					$('#'+upload_btn).html(btn_txt);
					$('#'+upload_btn).removeAttr("disabled");
					return false;
				}
				//拡張子エラー
				if(res.result == 'mime_error'){
					alert('指定のファイルはアップロードできません');
					$('#'+upload_btn).html(btn_txt);
					$('#'+upload_btn).removeAttr("disabled");
					return false;
				}

				var base_dir   = res.base_dir;
				var file_name = res.file_name;
				var file_url = base_dir+res.file_name;

				var block = $(create_file_box(file_name,file_url));



				$('#'+result_name).html(block);
				$('#'+upload_btn).html('変更');
				$('#'+upload_btn).removeAttr("disabled");

			},
			beforeSubmit: function(arr, $form, options){
				$('#'+upload_btn).html('アップロード中');
				$('#'+upload_btn).attr("disabled","disabled");
			},
			error:function(test)
			{
				//checkObject(test);
				alert("アップロードに失敗しました");
			}
		}

		$.extend(options,option);

		var name = option.name;
		var form = $('<form action="" method="post" enctype="multipart/form-data"></form>');

		/*ＩＤ関連*/
		var result_name = 'fileup_result_'+name;
		var upload_btn  = 'fileup_btn_'+name;
		var input_file  = 'fileup_file_'+name;


		/* 初期ボタンテキスト */
		var btn_txt = '追加';
		
		/*既に登録されている写真を取得*/
		var photos_html = $(this).html();
		$(this).html("");

		$(form).append('<input type="file" id="'+input_file+'" name="file" style="display:none" value=""><div ><label id="'+upload_btn+'" for="'+input_file+'" class="btn btn-success">'+btn_txt+'</label></div>');

		$(this).append('<div id="'+result_name+'"></div>');
		$(this).append(form);
		
		//どかしたHTMLを再入力
		$('#'+result_name).html(photos_html);

		//送信処理
		$('#'+input_file).change(function(){
			$(form).ajaxSubmit(options);
		});

		/**
         * 削除ボタン
         */
		$(document).on('click','#'+result_name+' .file_capbox .btn-delete',function(e){
			alert($(this).data('id'));
			$('#'+$(this).data('id')).remove();
			$('#'+upload_btn).html(btn_txt);
			$('#'+upload_btn).css({'display':''});
			return false;
		 });


		function create_file_box(file_name,file_url){
			var file_box = 'fileup_capbox_'+name;

		

			var block_html = '';
			block_html = '<div class="file_capbox" id="'+file_box+'" style="margin-bottom:10px;">';
			block_html+= '<input type="hidden" name="'+name+'" value="'+file_name+'" />';
			block_html+= '<a href="javascript:void(0);" class="btn-delete" data-id="'+file_box+'"><!-- img_thumnail -->';
			block_html+= '<i class="fa fa-times"></i>';
			block_html+= '</a><!-- btn-delete -->　';
			block_html+= '<a href="'+file_url+'" target="_blank">'+file_name+'</a>';
			block_html+= '</div><!-- file_capbox -->';



			return block_html;

		}
	}
});