<?php
/**
 * 利用可能枠
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class Add_limitPage extends AdminPage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'add_limit';
	protected $session_key = 'add_limit';
	protected $use_confirm = true;
	protected $page_title = '利用枠管理';
	protected $page_cnt = 999;//一ページに表示するデータ数

	
	
	protected  function indexAction() {
		//店舗データ取得
		$store_id = getGet('store_id');
		if(!$res = $this->manager->db_manager->get('store')->findById($store_id)){
			redirect('store.php');exit();
		}
		$this->page_title = $res['store_name']." ".$this->page_title;
		
		//日付初期値
		if(!getGet('year')){
			$_GET['year'] = date('Y');
		}
		if(!getGet('month')){
			$_GET['month'] = date('m');
		}
		
		parent::indexAction();
	}
	
	protected  function editAction() {
		//店舗データ取得
		$store_id = $this->getFormSession('store_id');
		if(!$res = $this->manager->db_manager->get('store')->findById($store_id)){
			redirect('store.php');exit();
		}
		$this->page_title = $res['store_name']." ".$this->page_title;
		
		parent::editAction();
	}
	
	
	/**
	 * 入力確認画面
	 *
	 */
	protected function confirmAction(){
		$post  = $this->getFormSession('form');
		$data  = array();
		//入力チェック
		if(!$this->validation($post)){
			$this->errorPage();
			exit();
		}

		//POST送信があった場合
		if(getPost('m') == 'confirm'){
			if($this->id == 0){
				$result_flg = $this->inseart_action($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('insert_comp'));
			}
			else {
				$result_flg = $this->update_action($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
			}

			if($result_flg !== false){
				$store_id = $this->getFormSession('store_id');
				list($year,$month,$date) = explode('-',date('Y-m-d',strtotime($post['add_date'])));
				redirect($this->use_table.'.php?store_id='.$store_id.'&year='.$year.'&month='.$month);
			}
			$this->unsetSystemMessage();
		}

		//表示用データ
		$data = $this->getConfirmCommon();
		$data['post']  = escapeHtml($post);
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;

		$this->loadView('confirm', $data);
	}
	
	
	
	/**
	 * tkn生成時にデータをセッションに格納
	 */
	protected function editDefaultParam(){
		$store_id = getGet('store_id');
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
	 * ＤＢデータから入力用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data){
		//パスワードデコード
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
		$this->manager->validation->setRule('add_type'     ,'selected');
		$this->manager->validation->setRule('add_date'     ,'required|realdate');
		$this->manager->validation->setRule('review_status','selected');

		return $this->manager->validation->run($param);
	}



	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		$param['store_id'] = $this->getFormSession('store_id');
		$bool = $this->manager->db_manager->get($this->use_table)->insert($param);
		
		//承認の場合
		if($bool !== false && $param['review_status'] == ADD_LIMIT_RST_AGR){
			//前払いの場合
			if($param['add_type'] == ADD_LIMIT_TYPE_BEF){
				$year_month = date('Y-m',strtotime($param['add_date']));
				$bill = $this->manager->db_manager->get('bill')->findByMonthStoreId($year_month,$param['store_id']);
				$deposit_price = $this->manager->db_manager->get('add_limit')->monthDepositPriceStoreId($year_month,$param['store_id']);
				$deposit['deposit_price'] = $deposit_price;
				$this->manager->db_manager->get('bill')->updateById($bill['bill_id'],$deposit);
			}
			
			return $this->manager->db_manager->get('store')->addPointLimit($param['store_id'],$param['add_point']);
		}
		return $bool;
	}


	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_action($param){
		
		$data = $this->manager->db_manager->get($this->use_table)->findById($this->id);
		
		$bool = $this->manager->db_manager->get($this->use_table)->updateById($this->id,$param);
		//承認の場合
		if($bool !== false && $param['review_status'] == ADD_LIMIT_RST_AGR){
			
			//前払いの場合
			if($param['add_type'] == ADD_LIMIT_TYPE_BEF){
				$year_month = date('Y-m',strtotime($param['add_date']));
				$bill = $this->manager->db_manager->get('bill')->findByMonthStoreId($year_month,$data['store_id']);
				$deposit_price = $this->manager->db_manager->get('add_limit')->monthDepositPriceStoreId($year_month,$data['store_id']);
				$deposit['deposit_price'] = $deposit_price;
				$this->manager->db_manager->get('bill')->updateById($bill['bill_id'],$deposit);
			}
			
			return $this->manager->db_manager->get('store')->addPointLimit($data['store_id'],$param['add_point']);
			
		}
		return $bool;
	}

	/**
	 * 入力画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getEditCommon($data = array()){
		
		if($this->id != 0){
			$res = $this->manager->db_manager->get($this->use_table)->findById($this->id);
			
		}
		return $data;
	}

	/**
	 * 確認画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getConfirmCommon($data = array()){

		if($this->id != 0){
			$res = $this->manager->db_manager->get($this->use_table)->findById($this->id);
		}
		return $data;
	}

}
