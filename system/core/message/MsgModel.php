<?php
/**
 * メッセージモデル
 */
class MsgModel
{
	var $message = array();
	
	/**
	 * メッセージのリストを取得する
	 *
	 * @return Array メッセージのリスト
	 */
	function getMessages()
	{
		return $this->message;
	}
	
	/**
	 * メッセージを1件取得する
	 * 
	 * @param String $rule キー
	 * @return String メッセージ
	 */
	function getMessage($rule)
	{
		if(isset($this->message[$rule]))
		{
			return $this->message[$rule];
		}
		return '';
	}
	
	
	/**
	 * メッセージにのリストを登録する
	 *
	 * @param Array $param メッセージリスト
	 */
	function setMessages($param)
	{
		if(is_array($param))
		{
			$this->message = $param;
		}
	}
	
	
	/**
	 * メッセージを変更・追加する
	 * 
	 * @param String $rule キー
	 * @param String $message メッセージ
	 */
	function setMessage($rule,$message)
	{
		$this->message[$rule] = $message;
	}
}