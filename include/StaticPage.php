<?php
/**
 * TOP
 *
 */
include_once dirname(__FILE__).'/Page.php';

class StaticPage extends Page{




	protected $view = array(
			'qa' =>'qa',
			'intro' =>'intro',
			'course' =>'course',
			'access' =>'access',
			'sub' =>'sub',
	);


	/**
	 * 静的ページ
	 *
	 */
	public function staticAction($template = ''){
		$data = array();
		$this->loadView($template, $data);

	}





}