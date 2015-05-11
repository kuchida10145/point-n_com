<?php
/**
 * セッション管理クラス
 */
class Base_Session
{
	protected static $sessionStarted = false;

	/**
	 * セッションの開始
	 */
	public function __construct()
	{
		if(!self::$sessionStarted)
		{
			@session_start();
			self::$sessionStarted = true;

		}
	}

	/**
	 * セッションIDの変更
	 */
	public function regenarate()
	{

		//PHP5.1以上
		if(phpversion() >= 5.1)
		{
			session_regenerate_id(true);//セッションIDの再発行

		}
		//PHP5.0以下
		else
		{
			$session_data = session_encode();	//現在のセッションデータを待避
			$_SESSION     = array();			//セッション情報を初期化
			session_regenarate_id();			//セッションIDの再発行
			session_decode($session_data);		//待避させたセッションデータを復元
		}

	}

	/**
	 * セッションに値を格納
	 *
	 * @param String $name セッションキー
	 * @param Mixed $value 格納する値
	 */
	public function set($name,$value)
	{
		$_SESSION[$name] = $value;
	}


	/**
	 * セッションを取得
	 *
	 * @param String $name セッションキー
	 * @param Mixed $default セッションがない場合に返す値
	 * @return Mixed 値
	 */
	public function get($name,$default = null)
	{
		if(isset($_SESSION[$name]))
		{
			return $_SESSION[$name];
		}

		return $default;
	}

	/**
	 * 該当のセッションを破棄
	 *
	 * @param String $name セッションキー
	 */
	public function remove($name)
	{
		unset($_SESSION[$name]);
	}

	/**
	 * セッションを初期化
	 */
	public function clear()
	{
		$_SESSION = array();
	}


}