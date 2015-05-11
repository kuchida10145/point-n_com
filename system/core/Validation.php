<?php
/**
* 検証クラス
*
* @package Sixpence
* @author Ippei.Takahashi <takahashi@6web.co.jp>
* 2012.10.16 環境依存文字チェック追加
*/
class Base_Validation
{


	private $errors = array();
	private $rules  = array();


	/**
	 * 検証ルールを設定する
	 *
	 * @param String $key 検証するキー
	 * @param String $rule 検証ルール
	 */
	public function setRule($key,$rule)
	{
		$rules = explode("|",$rule);
		foreach($rules as $r_key => $r_val)
		{
			$this->rules[$key][] = $r_val;
		}
	}

	/**
	 * 検証ルールをリセットする
	 *
	 */
	public function resetRule()
	{
		$this->rules = array();
	}


	/**
	 * エラー配列をリセットする
	 *
	 */
	public function resetError()
	{
		$this->errors = array();
	}

	/**
	 * エラー配列の取得
	 *
	 * @return array エラー配列
	 */
	public function getError()
	{
		return $this->errors;
	}


	/**
	 * エラーを配列に設定する
	 *
	 * @return array エラー配列
	 */
	public function setError($key,$rule)
	{
		$this->errors[$key] = $rule;
	}

	/**
	 * 検証実行
	 *
	 * @param array $data 検証用データ
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function run($data)
	{

		foreach($this->rules as $key => $val)
		{
			$flg = true;


			foreach($this->rules[$key] as $rule_str)
			{

				$rules = explode(':',$rule_str);
				$rule = $rules[0];
				switch($rule)
				{
					//入力・選択チェック
					case 'checked':
					case 'selected':
					case 'required':
						$flg = $this->isRequired($key,$data);
						break;
					//選択データの厳密チェック
					case 'strict_select':
						$flg = $this->isStrictSelect($key,$data);
						break;

					//メールアドレス形式チェック
					case 'email':
						$flg = $this->isEmail($key,$data);
						break;

					//日時型チェック
					case 'datetimeformat':
						$flg = $this->isDatatimeFormat($key,$data);
						break;

					//日付方チェック
					case 'dateformat':
						$flg = $this->isDateFormat($key,$data);
						break;

					//カタカナチェック
					case 'katakana':
						$flg = $this->isKatakana($key,$data);
						break;

					//ひらがなチェック
					case 'hirakana':
						$flg = $this->isKana($key,$data);
						break;

					//郵便番号チェック
					case 'postcode':
						$flg = $this->isPostCode($key,$data);
						break;

					//電話番号チェック
					case 'tel':
						$flg = $this->isTel($key,$data);
						break;

					//日付が存在するかチェック
					case 'realdate':
						$flg = $this->isRealDate($key,$data);
						break;

					//数字チェック
					case 'numeric':
						$flg = $this->isNumeric($key,$data);
						break;
					//整数チェック
					case 'digit':
						$flg = $this->isDigit($key,$data);
						break;
					//正数チェック
					case 'pnumeric':
						$flg = $this->isPnumeric($key,$data);
						break;
					//半角英数字チェック
					case 'alphanumeric':
						$flg = $this->isAlphanumeric($key,$data);
						break;

					//半角英字チェック
					case 'alpha':
						$flg = $this->isAlpha($key,$data);
						break;

					//文字列範囲チェック
					case 'range':
						$flg = $this->isRange($key,$data,$rules[1],$rules[2]);
						break;
					//パスワード
					case 'password':
						$flg = $this->isPassword($key,$data,$rules[1],$rules[2]);
						break;
					//最大文字数チェック
					case 'maxlength':
						$flg = $this->isMaxLength($key,$data,$rules[1]);
						break;





					//独自関数の実行
					default:
						if(function_exists($rule) === TRUE)
						{
							$flg = $rule($key,$data);
						}


				}
				if($flg == false)
				{
					$this->errors[$key] = $rule_str;
					break;
				}
			}


		}
		if(count($this->errors) != 0)
		{
			return false;
		}
		return true;
	}


	/**
	 * エラーメッセージの取得
	 *
	 * @param Array $message エラーメッセージのルールリスト
	 * @return Array エラーメッセージ
	 */
	public function getErrorMessage($msg_rules)
	{
		$message = array();
		foreach($this->errors as $key => $val)
		{
			$rules = explode(':',$val);
			$rule = $rules[0];
			switch($rule)
			{
				case 'range':
					$message[$key] = sprintf($msg_rules[$rule],$rules[1],$rules[2],$rules[3]);
					break;
				case 'password':
					$message[$key] = sprintf($msg_rules[$rule],$rules[1],$rules[2]);
					break;
				case 'maxlength':
				case 'length':
				case 'point_check':
					$message[$key] = sprintf($msg_rules[$rule],$rules[1]);
					break;
				default:
					//print $msg_rules[$rule];
					$message[$key] = $msg_rules[$rule];
			}

		}
		return $message;
	}


	/**
	 * 必須入力
	 *
	 * @param string $val 検証用データ
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isRequired($key,$data)
	{
		if(!isset($data[$key]) || $data[$key] == '')
		{
			return false;
		}
		return true;
	}

	/**
	 * 選択データの厳密チェック（select,radio,checkbox)
	 *
	 * @param string $val 検証用データ
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isStrictSelect($key,$data)
	{
		if(!isset($data[$key]) || $data[$key] == '')
		{
			return true;
		}

		//選択データが指定されている場合さらにチェック
		if(isset($data['__select'][$key]) && is_array($data['__select'][$key]))
		{
			$check = $data['__select'][$key];

			//データが配列の場合
			if(is_array($data[$key]))
			{
				foreach($data[$key] as $val)
				{
					if(array_key_exists($val,$check) === false)
					{
						return false;
					}
				}
			}
			//データが文字列の場合
			else
			{

				if(array_key_exists($data[$key],$check) === false)
				{
					return false;
				}
			}
		}


		return true;
	}

	/**
	 * メールアドレスチェック入力
	 *
	 * @param string $val メールアドレス
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isEmail($key,$data)
	{
		if(isset($data[$key]) && $data[$key] != '' && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$data[$key]))
		{
			return false;
		}
		return true;
	}


	/**
	 * 日時形式チェック入力
	 *
	 * @param string $val 日時
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isDatatimeFormat($key,$data)
	{
		// yyyy-mm-dd hh:ii:ss
		if (isset($data[$key]) && $data[$key] != '' &&  !preg_match('/^(19|20)[0-9]{2}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/',$data[$key]))
		{
			return false;
		}
		return true;
	}

	/**
	 * 日付形式チェック
	 *
	 * @param string $val 日時
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isDateFormat($key,$data)
	{
		//print $val;
		// yyyy-mm-dd
		if (isset($data[$key]) && $data[$key] != '' && !preg_match('/^(19|20)[0-9]{2}-[0-9]{2}-[0-9]{2}$/',$data[$key]))
		{
			return false;
		}
		return true;
	}


	/**
	 * 全角カタカナチェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isKatakana($key,$data)
	{
		$val = $data[$key];
		$val = str_replace("　","",$val);
		if($val != "" && !preg_match("/^[ァ-ヶー]+$/u",$val)){
			return false;
		}
		return true;
	}


	/**
	 * ひらがなチェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isKana($key,$data)
	{
		$val = $data[$key];
		$val = str_replace("　","",$val);
		if($val != "" && !preg_match("/^[ぁ-ん]+$/u",$val))
		{
			return false;
		}
		return true;

	}

	/**
	 * 半角英数字チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	 public function isAlphanumeric($key,$data)
	 {
	 	$val = $data[$key];
		if($val != "" && !preg_match("/^[0-9A-Za-z]+$/", $val))
		{
			return false;
		}
		return true;
	 }

	/**
	 * 半角英字チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	 public function isAlpha($key,$data)
	 {
	 	$val = $data[$key];
		if($val != "" && !preg_match("/^[A-Za-z]+$/", $val))
		{
			return false;
		}
		return true;
	 }

	/**
	 * 文字列範囲チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @param int $min 最小値
	 * @param int $max 最大値
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	 function isRange($key,$data,$min,$max)
	 {

	 	$val = mb_strlen($data[$key],'utf-8');
		if($data[$key] != '' && ($min > $val || $max < $val) )
		{
			return false;
		}
		return true;
	 }



	/**
	 * パスワードチェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @param int $min 最小値
	 * @param int $max 最大値
	 * @return boolean 検証結果
	 */
	 public function isPassword($key,$data,$min,$max)
	 {
		if($this->isAlphanumeric($key,$data) === false)
		{
			return false;
		}

		return $this->isRange($key,$data,$min,$max);
	 }


	/**
	 * 最大文字数チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @param int $max 最大値
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isMaxLength($key,$data,$max)
	{
		$val =  mb_strlen($data[$key],'utf-8');
		if($data[$key] != '' && $max < $val)
		{
			return false;
		}
		return true;
	}

	/**
	 * 郵便番号チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isPostCode($key,$data)
	{
		$val = $data[$key];
		//xxx-xxxxの形式かどうか
		if ($val != "" && !preg_match("/^\d{7}$/", $val))
		{
			return false;
		}
		return true;
	}

	/**
	 * 電話番号チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isTel($key,$data)
	{
		$val = $data[$key];
		if ($val != "" && !preg_match("/^0\d{1,4}-\d{1,4}-\d{4}$/", $val))
		{
			return false;
		}
		return true;
	}


	/**
	 * 存在する日付かどうかチェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 * 2012.11.05 修正
	 */
	public function isRealDate($key,$data)
	{
		$val = $data[$key];

		if($val != "")
		{
			if(mb_strpos($val, "-") !== FALSE)
			{
				list($yy,$mm,$dd) = explode('-',$val);
			}else{
				list($yy,$mm,$dd) = explode('/',$val);
			}

			if($yy == '' || $mm == '' || $dd == '' || !is_numeric($mm) || !is_numeric($dd) || !is_numeric($yy) || !checkdate(intval($mm),intval($dd),$yy))
			{
				if($yy != '' || $mm != '' || $dd != '')
				{

					return false;
				}

				if(!is_numeric($mm) || !is_numeric($dd) || !is_numeric($yy))
				{
					return false;
				}
			}

			return true;
		}
		return true;
	}

	/**
	 * 数値チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isNumeric($key,$data)
	{

		if(isset($data[$key]) && $data[$key] != "")
		{
			$val = $data[$key];
			if(is_numeric($val) === false)
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * 整数チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isDigit($key,$data)
	{

		if(isset($data[$key]) && $data[$key] != "")
		{
			$val = $data[$key];
			if(is_digit($val) === false)
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * 正数チェック
	 *
	 * @param string $key 添え字
	 * @param string $data データ配列
	 * @return boolean 検証結果
	 * @version 1.1.0
	 */
	public function isPnumeric($key,$data)
	{

		if(isset($data[$key]) && $data[$key] != "" && is_numeric($data[$key]))
		{
			$val = $data[$key];
			if($val < 0)
			{
				return false;
			}
		}
		return true;
	}





}

?>