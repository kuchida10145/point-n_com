<?php
/**
 * TOP
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class StaticPage extends Page{




	protected $view = array(
			'about' =>'about',
			'guid' =>'guid',
			'question'=>'question',
			'storeadmin'=>'storeadmin',
			'gaiyou'=>'gaiyou',
			'kitei'=>'kitei',
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