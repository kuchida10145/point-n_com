<?php
/**
 * デバイス管理クラス
 *
 */
class Base_Device
{


	/**
	 * OSを取得（PCの場合は'pc'が返される）
	 *
	 * @return String OSの種類
	 */
	protected function getOs()
	{
		if(!isset($_SERVER['HTTP_USER_AGENT']))
		{
			return 'pc';
		}
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);

		//iPhoneかどうか
		if(strpos($agent,'iphone') !== false)
		{
			return 'iPhone';
		}
		//iPodかどうか
		if(strpos($agent,'ipod') !== false)
		{
			return 'iPod';
		}
		//アンドロイドかどうか
		if(strpos($agent,'android')!==false)
		{
			return 'Android';
		}
		//携帯かどうか
		if((strpos($agent, 'docomo') !== false) || (strpos($agent, 'kddi') !== false) || (strpos($agent, 'softbank') !== false) || (strpos($agent, 'vodafone') !== false) || (strpos($agent, 'j-phone') !== false))
		{
			return 'mobile';
		}
		return 'pc';
	}


	/**
	 * デバイスの種類が返される
	 *
	 * @retutn String デバイスの種類 pc:PC sp:スマートフォン
	 */
	public function getDevice()
	{
		$os = $this->getOs();
		if($this->getOs() == 'pc')
		{
			return 'pc';
		}
		else if($os == 'mobile')
		{
			return 'mb';
		}
		return 'sp';
	}



	/**
	 * キャリアを取得
	 *
	 * @return string
	 */
	public function getCarrier()
	{
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($agent, 'docomo') !== false)
		{
			return 'docomo';
		}
		else if(strpos($agent, 'kddi') !== false)
		{
			return 'au';
		}
		else if((strpos($agent, 'softbank') !== false) || (strpos($agent, 'vodafone') !== false) || (strpos($agent, 'j-phone') !== false))
		{
			return 'softbank';
		}
		return 'other';
	}
}
?>