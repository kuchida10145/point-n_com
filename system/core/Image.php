<?php
/**
* メールクラス
*
* @package Sixpence
* @author Ippei.Takahashi <takahashi@6web.co.jp>
* @since PHP 4.3.9
* @version 1.1.0
*/
class Base_Image
{

	var $newImage;
	var $oldImage;
	var $filePath;	//ファイルパス
	var $savePath;	//ファイル保存用パス
	var $newWidth;
	var $newHeight;

	function Image(){}


	function saveImage($conf)
	{
		$newWidth  = getParam($conf,'width');
		$newHeight = getParam($conf,'height');
		$filePath  = getParam($conf,'file_path');
		$savePath  = getParam($conf,'save_path');
		$position  = getParam($conf,'position');
		$x = 0;
		$y = 0;

		$image = ImageCreateFromJPEG($filePath); //JPEGファイルを読み込む

		// 画像のサイズを取得。

		$width = ImageSX($image); //横幅（ピクセル）
		$height = ImageSY($image); //縦幅（ピクセル）

		//横幅のみ
		if(isset($conf['width']) && (!isset($conf['height']) || $conf['height'] == 0))
		{
			$rate = $newWidth / $width;
			$newHeight = $rate * $height;
		}
		//高さのみ
		if(isset($conf['height']) && (!isset($conf['width']) || $conf['width'] == 0))
		{
			$rate = $newHeight / $height;
			$newWidth = $rate * $width;
		}




		//エラー
		if(!isset($conf['width']) && !isset($conf['height']))
		{
			exit('画像の設定がされていません');
		}
		$new_image = imagecreatetruecolor($newWidth, $newHeight);

		ImageCopyResampled($new_image,$image,0,0,0,0,$newWidth,$newHeight,$width,$height);


		ImageJPEG($new_image, $savePath, 100);


	}



	function saveImage2($conf)
	{
		$newWidth  = getParam($conf,'width',0);
		$newHeight = getParam($conf,'height',0);
		$filePath  = getParam($conf,'file_path');
		$savePath  = getParam($conf,'save_path');
		$resize    = getParam($conf,'resize',true);//リサイズの画像より元画像が小さい場合、リサイズを行うかどうか
		$x = 0;
		$y = 0;

		$image = ImageCreateFromJPEG($filePath); //JPEGファイルを読み込む


		// 画像のサイズを取得。

		$width = ImageSX($image); //横幅（ピクセル）
		$height = ImageSY($image); //縦幅（ピクセル）

		//リサイズを実行するかどうかの判定
		if($resize == false)
		{
			if($newWidth > $width || $newHeight > $height)
			{
				return ;
			}
		}


		//横幅のみ
		if($newWidth > 0 && $newHeight==0)
		{
			$rate = $newWidth / $width;
			$newHeight = $rate * $height;
		}
		//高さのみ
		elseif($newHeight > 0 && $newWidth==0)
		{
			$rate = $newHeight / $height;
			$newWidth = $rate * $width;
		}

		//両方
		elseif(isset($conf['height']) && isset($conf['width']))
		{
			$width_rate = $width / $newWidth;
			$height_rate = $height / $newHeight;


			//元画像縦長の場合
			if($height > $width)
			{
				$use = 1;
				$rate = $newWidth / $width;
				if($height * $rate < $newHeight)
				{
					$use = 2;
				}
			}
			//元画像横長の場合
			else
			{
				$use = 2;
				$rate = $newHeight / $height;
				if($width * $rate < $newWidth)
				{
					$use = 1;
				}
			}



			//縦長の場合
			if($use == 1)
			{
				$rate = $newHeight / $height;
				$y = ceil((($height_rate-$width_rate)*$newHeight)/2);
				$height = $height-$y*2;

			}
			//横長の場合
			else
			{
				$rate = $newWidth / $width;
				$x = ceil((($width_rate-$height_rate)*$newWidth)/2);
				$width = $width-$x*2;
				$y = 0;
			}

		}


		//エラー
		if(!isset($conf['width']) && !isset($conf['height']))
		{
			exit('画像の設定がされていません');
		}
		$new_image = imagecreatetruecolor($newWidth, $newHeight);

		ImageCopyResampled($new_image,$image,0,0,$x,$y,$newWidth,$newHeight,$width,$height);


		ImageJPEG($new_image, $savePath, 100);


	}
}

?>