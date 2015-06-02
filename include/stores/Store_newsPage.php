<?php
/**
 * お知らせ
 *
 */
include_once dirname(__FILE__).'/../common/Page.php';

class Store_newsPage extends Page{

	protected $page_cnt = 10;




	protected $view = array(
			'index'    =>'stores/news/index',
			'detail'  =>'stores/news/detail',
	);


	/**
	 * お知らせ一覧
	 *
	 */
	public function indexAction(){
		$data =array();
		$store_id =getGet('sid');
		
		//店舗ＩＤが0の場合はエラー
		if($store_id == '' || $store_id == 0){
			$this->errorPage();
			exit();
		}
		
		if(getGet('m')=='next'){
			$this->nextAjax();
			exit();
		}
		$data['notice_list'] =  $this->changeListData($this->manager->db_manager->get('notice')->getNoticeList($store_id,0,$this->page_cnt));
		$this->loadView('index', $data);
	}

	
	
	/**
	 * お知らせAjax
	 * 
	 */
	public function nextAjax(){
		$next = getGet('next');
		$store_id =getGet('sid');
		$res['result'] = 'false';
		
		if($store_id != 0 && $store_id != ''){
			if($pages = $this->manager->db_manager->get('notice')->getNoticeList($store_id,$next,$this->page_cnt)){
				$res['result'] = 'true';
			}
		}
		$res['pages'] = $this->changeListData($pages);
		echo json_encode($res);		
	}
	
	/**
	 * 一覧用データ変換(HTMLエスケープも実行)
	 */
	private function changeListData($datas){
		
		if(!$datas){
			return NULL;
		}
		
		foreach($datas as $data_key => $data){
			$data['display_date'] = date('Y/m/d',strtotime($data['display_date']));
			//画像周り
			if($data['image1'] == ""){
				$data['image1']       = '/img/no_image_news.gif';
			}else{
				$data['image1']       = '/files/images/'.$data['image1'];
			}
			
			
			$data =escapeHtml($data);
			$datas[$data_key] = $data;
		}
		return $datas;
	}

	/**
	 * お知らせ詳細
	 *
	 */
	public function detailAction(){
		$data =array();
		$id = getGet('id');
		if(!$res = $this->manager->db_manager->get('notice')->getNoticeData($id)){
			$this->errorPage();
			exit();
		}
		//店舗ＩＤが0の場合はエラー
		if($res['store_id'] == '' || $res['store_id'] == 0){
			$this->errorPage();
			exit();
		}
		
		//エスケープ
		$res = escapeHtml($res);
		$res['body'] = decodeHtml($res['body']);
		
		//画像
		$images= array();
		for($i = 1; $i <= 3; $i++){
			if($res['image'.$i]!=''){
				$images[] = $res['image'.$i];
			}
		}
		
		$data['images'] = $images;
		$data['notice_data'] = $res;
		$this->loadView('detail', $data);
	}


	
}

