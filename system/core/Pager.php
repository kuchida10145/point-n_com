<?php
/**
* ページャークラス
*
*/
class Base_Pager
{
	protected $per_cnt = 0;
	protected $all_cnt = 0;
	protected $page_cnt = 0;
	protected $param = "";
	protected $now_page = 1;
	protected $type = "1"; //1:advance-mode 2:simple-mode
	protected $tagObj = NULL;

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		$this->get = $_GET;
		$this->setHtmlType(array(),'ul');
	}

	public function setGet($get)
	{
		$this->get = $get;
	}

	/**
	 * 生成するＨＴＭＬのタイプ
	 * @param string $type 生成するHTMLのタイプ
	 */
	public function setHtmlType($config,$type='ul')
	{
		$pager_class = "Pager_".$type;
		
		$this->tagObj = new $pager_class($config);
	}

	/**
	 * 設定の有効化
	 *
	 * @param array $config 設定
	 */
	public function initialize($config = NULL,$type=1)
	{
		$params = array();
		if($config !== NULL)
		{
			if(isset($config['per_cnt']))
			{
				$this->per_cnt = $config['per_cnt'];
			}
			if(isset($config['all_cnt']))
			{
				$this->all_cnt = $config['all_cnt'];
			}
			if(isset($config['type']) && ($config['type'] == 1 || $config['type'] == 2))
			{
				$this->type = $config['type'];
			}
		}

		$this->page_cnt = ceil($this->all_cnt / $this->per_cnt);

		foreach($this->get as $key => $val)
		{
			if($key != 'page')
			{
				if(is_array($val))
				{
					foreach($val as $i_key => $i_val)
					{
						$params[] = $key.'[]='.$i_val;
					}

				}
				else
				{
					$params[] = $key.'='.$val;
				}
			}
		}

		$this->param = implode("&",$params);

		//現在のページ設定
		if(isset($this->get['page']) && is_numeric($this->get['page']) && $this->page_cnt >= $this->get['page'] && $this->get['page'] != 0)
		{
			$this->now_page = $this->get['page'];
		}

	}

	/**
	 * ページ送りHTMLの生成
	 *
	 * @return string HTML
	 */
	public function create()
	{
		//advance
		if($this->type == 1)
		{
			$html = $this->_pagerAdvance();
		}
		//simple
		else if($this->type == 2)
		{
			$html = $this->_pagerSimple();
		}
		return $html;
	}

	/**
	 * シンプル生成
	 * 例）10件で1ページというという場合、1000件あれば１～100までのページ送りＨＴＭＬが生成される。
	 *
	 * @return string HTML
	 */
	protected function _pagerSimple()
	{
		$buffer = array();

		$param = '';
		if($this->param != "")
		{
			$param = '&'.$this->param;
		}

		for($i = 1 ; $i <= $this->page_cnt; $i++)
		{
			if($this->get['page'] == $i || (!isset($this->get['page']) && $i == 1))
			{
				$buffer[] = $this->tagObj->create_block($i,true);
				//$buffer[] = $this->tagObj->create_block('<a href="?page='.$i.$param.'">'.$i.'</a>');
			}
			else
			{
				$buffer[] = $this->tagObj->create_block('<a href="?page='.$i.$param.'">'.$i.'</a>');
			}
		}
		$html =  $this->tagObj->create_box(implode(" ",$buffer));
		return $html;
	}


	/**
	 * アドバンス生成
	 * 例）10件で1ページというという場合、1000件あれば１～10までのページ送りＨＴＭＬが生成され、
	 *「最初へ」「最後へ」などが生成される。
	 *
	 * @return string HTML
	 */
	public function _pagerAdvance()
	{
		$buffer = array();
		$p_cnt = 1; //page cnt
		$max = $this->page_cnt;
		$temp = $this->page_cnt - $this->now_page;


		$param = '';
		if($this->param != "")
		{
			$param = '&'.$this->param;
		}

		if($temp > 4 && $this->page_cnt > 10)
		{
			if( $this->now_page > 6 ){
				$max = $this->now_page+4;
			}
			else
			{
				$max = 10;
			}
		}

		if($this->now_page > 6 && $this->page_cnt > 10)
		{
			if($max < $this->page_cnt-4)
			{
				$p_cnt = $this->now_page -5;
			}
			else
			{
				$p_cnt = $this->now_page -(10-($max-$this->now_page)-1);
			}
		}

		if($this->now_page > 1)
		{
			$buffer[] = $this->tagObj->create_block('<a href="?page=1'.$param.'">'.$this->tagObj->first_text.'</a>');
			$buffer[] = $this->tagObj->create_block('<a href="?page='.($this->now_page-1).$param.'">'.$this->tagObj->back_text.'</a>');
			if($p_cnt != 1)
			{
				//$buffer[] = $this->tagObj->create_block('...',true);
			}
		}

		for($i = $p_cnt ; $i <= $max; $i++)
		{
			if($this->now_page == $i)
			{
				//$buffer[] = $this->tagObj->create_block($i,true);
				//$buffer[] = $this->tagObj->create_block('<a href="?page='.$i.$param.'">'.$i.'</a>');

				//bootstrap用
				$buffer[] = $this->tagObj->create_block("<a href=\"#\">{$i}<span class=\"sr-only\">(current)</span></a>",true);
			}
			else
			{
				$buffer[] =  $this->tagObj->create_block('<a href="?page='.$i.$param.'">'.$i.'</a>');
			}
		}

		if($max <  $this->page_cnt)
		{
			//$buffer[] = $this->tagObj->create_block('...',true);
		}

		if($max > $this->now_page)
		{
			$buffer[] = $this->tagObj->create_block('<a href="?page='.($this->now_page+1).$param.'">'.$this->tagObj->next_text.'</a>');
			$buffer[] = $this->tagObj->create_block('<a href="?page='.$this->page_cnt.$param.'">'.$this->tagObj->last_text.'</a>');


		}
		$html =  $this->tagObj->create_box(implode(" ",$buffer));
		return $html;
	}
}


/**
 * ページャーのタグがULの場合のクラス
 */
class Pager_ul
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
		return '<ul class="'.$this->box_class.'">'.$tag.'</ul>';
	}

}

/**
 * ページャーのタグがDivの場合のクラス
 */
class Pager_div
{
	var $box_class    = 'pager';
	var $focus_class = 'focus';
	var $page_class = 'page';
	var $last_text    = '&gt;&gt;|';
	var $first_text   = '|&lt;&lt;';
	var $next_text    = 'Next&gt;&gt;';
	var $back_text = '&lt;&lt;Back';

	public function Pager_div($config=array())
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
		if($focus == false)
		{
			return '<div class="'.$this->page_class.'">'.$str.'</div>'."\r\n";
		}
		else
		{
			return '<div class="'.$this->focus_class.'">'.$str.'</div>'."\r\n";
		}
	}


	public function create_box($tag)
	{
		return $tag;
	}

}

?>