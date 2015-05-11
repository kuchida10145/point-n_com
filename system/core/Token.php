<?php
/**
 * トークン管理
 */
class Base_Token
{
	protected $token;

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		if(isset($_SESSION['csrf']))
		{
			$this->token = $_SESSION['csrf'];
		}
	}


	/**
	 * トークンを生成する
	 *
	 * @param String $key トークンのキー
	 */
	public function createToken($key)
	{

		$toekens = array();
		if(isset($_SESSION['csrf'][$key]))
		{
			$tokens = $_SESSION['csrf'][$key];

		}
		$token  = md5(uniqid(rand(), true));

		$tokens[] = $token;


		//一つのキーにつき、トークンは10まで
		if(count($tokens) > 10)
		{
			array_shift($tokens);
		}

		$this->token[$key]      = $tokens;
		$_SESSION['csrf'][$key] = $tokens;

		return $token;
	}

	/**
	 * トークンの整合性チェック
	 *
	 * @param String $key トークンのキー
	 * @param String $value トークン
	 * @return Bool 結果
	 */
	public function checkToken($key,$value)
	{

		if(!isset($this->token[$key]))
		{
			return false;
		}
		$tokens = $this->token[$key];

		if(false === array_search($value,$tokens))
		{
			return false;
		}

		return true;
	}


	public function deleteToken($key,$value)
	{


		if(true == $this->checkToken($key,$value))
		{
			$tokens = $this->token[$key];
			$pos = array_search($value,$tokens);

			unset($tokens[$pos]);

			$this->token[$key]      = $tokens;
			$_SESSION['csrf'][$key] = $tokens;
		}

		return ;
	}
}