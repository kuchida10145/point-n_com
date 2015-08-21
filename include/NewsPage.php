<?php
/**
 * 今日のニュース
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class NewsPage extends Page{

	protected $page_cnt = 10;




	protected $view = array(
			'index'    =>'news/index',
			'area'    =>'news/area',
			'detail'  =>'news/detail',
	);


	/**
	 * 今日のニュース一覧
	 *
	 */
	public function indexAction(){
		$data =array();
		
		if(getGet('m')=='next'){
			$this->nextAjax();
			exit();
		}
		$region_id = getGet('region_id');
		$data['news_list'] =  $this->changeListData($this->manager->db_manager->get('news')->getNewsList($region_id,0,$this->page_cnt));
		$this->loadView('index', $data);
	}

	
	/**
	 * 今日のニュースのエリア
	 */
	public function areaAction(){
		$data = array();
		$this->loadView('area', $data);
	}
	
	/**
	 * お知らせAjax
	 * 
	 */
	public function nextAjax(){
		$next = getGet('next');
		$res['result'] = 'false';
		$region_id = getGet('region_id');
		if($pages = $this->manager->db_manager->get('news')->getNewsList($region_id,$next,$this->page_cnt)){
			$res['result'] = 'true';
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
		if(!$res = $this->manager->db_manager->get('news')->getNewData($id)){
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
		$data['news_data'] = $res;
		$this->loadView('detail', $data);
	}


	
}

