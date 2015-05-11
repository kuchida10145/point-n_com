<?php
/**
 * クッキー管理クラス
 *
 */
class Base_Cookie
{


	/**
	 * クッキーのセット
	 *
	 * @param Sting $name クッキー名
	 * @param String $val 値
	 * @param Int $limit 有効期限
	 * @param String $path パス
	 */
	public function set($name,$val,$limit=0,$path='/')
	{
		setcookie($name,$val,$limit,$path);
	}


	/**
	 * クッキーの削除
	 *
	 * @param String $name クッキー名
	 * @param String $path パス
	 */
	public function delete($name,$path='/')
	{
		unset($_COOKIE[$name]);
		setcookie($name,'',time()-3600,$path);
	}


	/**
	 * クッキーの取得
	 *
	 * @param String $name クッキー名
	 * @param Multi $default クッキーが存在しない場合の返り値
	 * @return Multi
	 */
	 public function get($name,$default=NULL)
	 {
		 if(isset($_COOKIE[$name]))
		 {
			 return $_COOKIE[$name];
		 }
		 return $default;
	 }

}