<?php
/**
 * 利用可能枠
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class Add_limitPage extends MaintenancePage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'add_limit';
	protected $session_key = 'add_limit';
	protected $use_confirm = true;
	protected $page_title = '利用枠管理';
	protected $page_cnt = 999;//一ページに表示するデータ数

	
	
	protected  function indexAction() {
		//日付初期値
		if(!getGet('year')){
			$_GET['year'] = date('Y');
		}
		if(!getGet('month')){
			$_GET['month'] = date('m');
		}
		
		parent::indexAction();
	}
	
	/**
	 * tkn生成時にデータをセッションに格納
	 */
	protected function editDefaultParam(){
		$account = $this->getAccount();
		$store_id = $account['store_id'];
		if(getGet('id')!=''){
			$res = $this->manager->db_manager->get($this->use_table)->findById(getGet('id'));
			$store_id = getParam($res,'store_id');
		}
		$this->setFormSession('store_id',$store_id); //店舗ID
		return;
	}
	
	/**
	 * 一覧画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getIndexCommon($data = array()){
		$store_id = getGet('store_id');
		
		//最小日付取得
		$year  = date('Y');
		
		if($res = $this->manager->db_manager->get('add_limit')->getMinDateByStoreId($store_id)){
			list($year,$month,$date) = explode('-',$res);
		}
		
		$data['year'] = $year;
		
		
		return $data;
	}

	

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){

		//更新の場合はＩＤを設定
		if($this->id != 0){
			$param['user_id'] = $this->id;
		}

		$this->manager->validation->setRule('add_point'    ,'required|digit|plus_moneyChk');
		$this->manager->validation->setRule('add_date'     ,'required|realdate|this_monthChk');

		return $this->manager->validation->run($param);
	}



	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		$account = $this->getAccount();
		$store_id = $account['store_id'];
		$param['store_id'] = $store_id;
		$param['review_status']  = ADD_LIMIT_RST_REQ;//申請
		$param['add_type']       = ADD_LIMIT_TYPE_BEF;//前払い
		return $this->manager->db_manager->get($this->use_table)->insert($param);

	}
}
