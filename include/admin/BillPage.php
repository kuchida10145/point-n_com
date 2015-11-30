<?php
/**
 * 利用可能枠
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class BillPage extends AdminPage {

	protected $id = 0;/* ID */
	protected $use_table   = 'bill';
	protected $session_key = 'bill';
	protected $use_confirm = true;
	protected $page_title = '請求管理';
	protected $page_cnt = 100000;//一ページに表示するデータ数






	/**
	 * 一覧画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getIndexCommon($data = array()){
		$get =$_GET;
		$get['m']='csv';
		$data['csv_url'] = http_build_query($get);
		return $data;
	}

	protected function csvAction(){

		$res = array();
		$get = $_GET;

		$year = getGet('year',date('Y'));
		$month = getGet('month',date('m'));

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->adminSearchMaxCnt($get);

		//リスト取得
		if($max_cnt > 0){
			$res  = $this->manager->db_manager->get($this->use_table)->adminSearch($get,"LIMIT 0,{$max_cnt}",$this->order);
		}
		else{
			exit();
		}

		$this->manager->setCore('bill');
		$this->manager->bill->createCsv($res);


	}



	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('adjust_price'    ,'required|digit');
		return $this->manager->validation->run($param);
	}
	/**
	 * tkn生成時にデータをセッションに格納
	 */
	protected function editDefaultParam(){
		$referer = $_SERVER["HTTP_REFERER"];
		$url = parse_url($referer);
		$host = $url['host'];

		if($host == $_SERVER['SERVER_NAME']){
			$this->setFormSession('redirect',$referer);
		}

		return;
	}


	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_action($param){
		$result_flg = parent::update_action($param);
		$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
		if($result_flg !== false){
			$redirect = $this->getFormSession('redirect');
			if($redirect!=""){
				$this->unsetFormSession('form');
				redirect($redirect);
			}
		}
		return $flg;
	}


	/**
	 * 入力画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getEditCommon($data = array()){
		$data = $this->getEditConfirmCommon();
		return $data;
	}


	/**
	 * 確認画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getConfirmCommon($data = array()){
		$data = $this->getEditConfirmCommon();
		return $data;
	}

	/**
	 * 入力画面と確認画面で共通のデータ
	 * @param array $data
	 * @return type
	 */
	protected function getEditConfirmCommon($data = array()){
		$bill = $this->manager->db_manager->get('bill')->findById($this->id);
		$bill['issue_point']      = $bill['n_point']+$bill['e_point']+$bill['sp_point'];
		$bill['issue_commission'] = $bill['n_point_commission']+$bill['e_point_commission']+$bill['sp_point_commission'];
		$bill['cancel_point']     = $bill['n_point_cancel']+$bill['e_point_cancel'];
		$bill['cancel_commission']= $bill['n_point_cancel_commission']+$bill['e_point_cancel_commission'];
		$bill['use_total']        = $bill['use_n_point']+$bill['use_e_point']+$bill['use_point'];
		$bill['use_total_cancel'] = $bill['use_n_point_cancel']+$bill['use_e_point_cancel']+$bill['use_point_cancel'];
		$data['bill_data'] = $bill;
		return $data;
	}

	/**
	 * 【店舗情報検索】中カテゴリのリスト取得（AJAX）
	 * - 業種（大カテゴリが1の場合：業種は1、2、大カテゴリが2、3の場合：業種は3）
	 * - 大カテゴリー(ジャンルマスター)
	 */
	protected function change_search_upper_itemAction(){
		$result['result'] = 'result';

		// 中カテゴリー
		$result['category_midium'] = array();

		$category_large_id   = $_POST['category_large_id'];
		$prefectures_id      = $_POST['prefectures_id'];
		$is_host = false;
		if ($category_large_id > 1) {
			// 業種およびジャンルマスターが風俗以外の場合
			$is_host = true;
		}
		if ($is_host) {
			$is_delivery = 0;
			// 中カテゴリー
			$result['category_midium'] = category_midium($category_large_id, $prefectures_id, $is_delivery);
		} else {
			// 中カテゴリー
			$array = category_midium_deli_all($category_large_id, $prefectures_id);
			$result['category_midium'] = $array;
		}

		echo json_encode($result);
		exit();
	}
}
