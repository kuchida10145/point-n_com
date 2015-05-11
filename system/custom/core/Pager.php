<?php
/**
* ページャークラス
*
* @package Sixpence
* @author Ippei.Takahashi <takahashi@6web.co.jp>
* @since PHP 4.3.9
* @version 1.1.0
*/
include_once dirname(__FILE__).'/../../core/Pager.php';
class Pager extends Base_Pager
{

}


/**
 * ページャーのタグがULの場合のクラス
 */
class Pager_admin
{
	var $box_class    = 'pagination';
	var $focus_class = 'active';
	var $page_class = '';
	var $last_text    = '»';
	var $first_text   = '«';
	var $next_text    = '>';
	var $back_text = '<';

	public function __construct($config=array())
	{

		foreach($config as $key => $val)
		{
			if($val != '')
			{
				$this->{$key} = $val;
			}
		}
	}
	public function create_block($str,$focus = false)
	{
		
		$str = str_replace('<span class="sr-only">(current)</span>',"", $str);
		if($focus == false)
		{
			return '<li class="'.$this->page_class.'">'.$str.'</li>'."\r\n";
		}
		else
		{
			return '<li class="'.$this->focus_class.'">'.$str.'</li>'."\r\n";
		}
	}


	public function create_box($tag)
	{
		return '<div class="pagination pagination-centered"><ul>'.$tag.'</ul></div>';
	}

}