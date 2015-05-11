<?php
/**
 * TOP
 *
 */
include_once dirname(__FILE__).'/Page.php';

class IndexPage extends Page{




	protected $view = array(
			'index' =>'index'
	);


	/**
	 * TOPページ
	 *
	 */
	public function IndexAction(){


		if(!$informations = $this->manager->db_manager->get('information')->getTopInformation()){
			$informations = array();
		}



		$data = array();
		$data['informations'] = escapeHtml($informations);
		$this->loadView('index', $data);

	}





}