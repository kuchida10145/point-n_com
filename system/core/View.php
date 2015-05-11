<?php
/**
* ビュークラス
*
* @package Sixpence
* @author Ippei.Takahashi <takahashi@6web.co.jp>
* @since PHP 4.3.9
* @version 1.1.0
*/
class Base_View{

	/**
	 * コンストラクタ
	 * @version 1.1.0
	 */
	public function __construct(){}


	/**
	 * ビューのロード
	 *
	 * @param string $template テンプレートファイル
	 * @param array $data テンプレート内で使われるデータ
	 * @param boolean $output 画面に出力するか　true:画面に出力 false:変数に格納
	 * @return string HTML
	 * @version 1.1.0
	 */
	public function loadView($template,$data=array(),$output = true)
	{
		$template_file = TEMPLATE_DIR.$template.".php";
		if(!file_exists($template_file))
		{
			$template_file = TEMPLATE_DIR.$template.".html";
			if(!file_exists($template_file)){
				exit("NOT FOUND TEMPLATE:".$template_file);
			}
		}

		if($output === true)
		{

			$this->_output($template_file,$data);
		}
		else
		{
			return $this->_noneoutput($template_file,$data);
		}
	}


	/**
	 * 画面出力
	 *
	 * @param string $template テンプレートファイル
	 * @param array $data テンプレート内で使われるデータ
	 * @version 1.1.0
	 */
	protected function _output($templateFile,$_data=array())
	{
		if(count($_data) != 0)
		{
			extract($_data);
		}

		include($templateFile);
	}

	/**
	 * ロードしたビューを変数に格納
	 *
	 * @param string $template テンプレートファイル
	 * @param array $data テンプレート内で使われるデータ
	 * @return string HTML
	 * @version 1.1.0
	 */
	protected function _noneoutput($templateFile,$_data=array())
	{
		if(count($_data) != 0)
		{
			extract($_data);
		}

		ob_start();
		include($templateFile);
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
?>