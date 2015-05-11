<?php
/**
 * TOP
 *
 */
include_once dirname(__FILE__).'/Page.php';

class InformationPage extends Page{




	protected $view = array(
			'index' =>'information/index',
			'detail' =>'information/detail'
	);


	/**
	 * 一覧
	 *
	 */
	public function indexAction(){

		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();

		$page_cnt = 1;


		//limit句生成
		$limit = $this->manager->db_manager->get('information')->createLimit(getGet('page'),$page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get('information')->infoMaxCnt($get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get('information')->getInfoList($limit);
		}


		//リストを出力用のデータに変換
		$list = escapeHtml($list);


		//システムメッセージ

		//ページャ生成
		$pager_param['per_cnt'] = $page_cnt;
		$pager_param['all_cnt'] = $max_cnt;
		$this->manager->pager->setHtmlType( array() ,'ul');
		$this->manager->pager->initialize($pager_param);
		$pager_html = $this->manager->pager->create();
		$data['informations']           = $list;
		$data['pager_html']     = $pager_html;
		$this->loadView('index', $data);

	}


	/**
	 * 詳細ページ
	 *
	 */
	public function detailAction(){

		$id = getGet('id');

		if($id == '' || !($information = $this->manager->db_manager->get('information')->getDetail($id))){
			$this->errorPage();
		}


		$information = escapeHtml($information);
		$information['body'] = decodeHtml($information['body']);

		$data['information'] = $information;
		$this->loadView('detail', $data);
	}





}