<?php
/**
 * 予約
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class ReservationPage extends Page{

	protected $id = 0;/* ID */
	protected $use_table   = 'reserved';
	protected $session_key = 'reservation';
	protected $use_confirm = true;
	protected $page_title = '予約';

	protected $view = array(
			'index'    =>'reservation/index',
			'indexP'   =>'reservation/indexP',
			'confirm'  =>'reservation/confirm',
			'thanks'   =>'reservation/thanks',
	);

	/**
	 * 予約情報入力
	 *
	 */
	public function indexAction(){
		$data = array();
		$post = array();
		$error = array();

		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$this->token = $this->manager->token->createToken($this->session_key);
			if(getGet('coupon_id') == ''){
				redirect('?tkn='.$this->token);
			} else {
				redirect('?tkn='.$this->token.'&coupon_id='.getGet('coupon_id'));
			}
			exit();
		}

		if(getPost('m') == 'confirm'){
			$post = $_POST;
			//入力チェック
			if($this->Validation($post)){
				$form_data = array(
						'get_point' => str_replace(',', '', $post['get_point']),
						'course_id' => $post['course_id'],
						'course_name' => $post['course_name'],
						'store_name' => $post['store_name'],
						'use_persons' => $post['use_persons'],
						'use_date' => $post['use_date'],
						'use_time' => $post['use_time'],
						'use_min' => $post['use_min'],
						'reserved_name' => $post['reserved_name'],
						'telephone1' => $post['telephone1'],
						'telephone2' => $post['telephone2'],
						'telephone3' => $post['telephone3'],
						'price' => str_replace(',', '', $post['price']),
						'use_point' => str_replace(',', '', getParam(use_point_data(), $post['use_point'])),
						'contract' => $post['contract'],
				);
				$this->setFormSession('form', $form_data);
				redirect( '/reservation/confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		} else {
			$post = $this->getFormSession('form');
		}

		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$account = $this->getAccount();
 		$data['user_id'] = $account['user_id'];
 		$data['nickname'] = $account['nickname'];
 		$data['user_point'] = $account['user_point'];
		// クーポン情報取得
 		$couponData = $this->manager->db_manager->get('coupon')->findById(getGet('coupon_id'));
		// 店舗情報取得
		$storeData = $this->manager->db_manager->get('store')->findById($couponData['store_id']);
		// コース情報取得
		$courseData = $this->manager->db_manager->get('course')->findById($couponData['course_id']);
		$data['get_point'] = number_format($couponData['point']);
		$data['course_id'] = $courseData['course_id'];
		$data['course_name'] = $courseData['course_name'];
		$data['store_name'] = $storeData['store_name'];
		$data['price'] = number_format($courseData['price']);

		$this->loadView('index', $data);
	}

	/**
	 * 予約情報入力(ポイントのみ利用)
	 *
	 */
	public function indexPointOnlyAction(){
		$data = array();
		$post = array();
		$error = array();

		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$this->token = $this->manager->token->createToken($this->session_key);
			if(getGet('store_id') == ''){
				redirect('?tkn='.$this->token);
			} else {
				redirect('?tkn='.$this->token.'&store_id='.getGet('store_id'));
			}
			exit();
		}

		if(getPost('m') == 'confirm'){
			$post = $_POST;
			//入力チェック
			if($this->Validation($post)){
				// コース情報取得
				$courseData = $this->manager->db_manager->get('course')->findById($post['course_id']);
				$form_data = array(
						'get_point' => '0',
						'course_id' => $post['course_id'],
						'course_name' => $courseData['course_name'],
						'store_name' => $post['store_name'],
						'use_persons' => $post['use_persons'],
						'use_date' => $post['use_date'],
						'use_time' => $post['use_time'],
						'use_min' => $post['use_min'],
						'reserved_name' => $post['reserved_name'],
						'telephone1' => $post['telephone1'],
						'telephone2' => $post['telephone2'],
						'telephone3' => $post['telephone3'],
						'price' => $courseData['price'],
						'use_point' => str_replace(',', '', getParam(use_point_data(), $post['use_point'])),
						'contract' => $post['contract'],
				);
				$this->setFormSession('form', $form_data);
				redirect( '/reservation/confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		} else {
			$post = $this->getFormSession('form');
		}

		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$account = $this->getAccount();
		$data['user_id'] = $account['user_id'];
		$data['nickname'] = $account['nickname'];
		$data['user_point'] = $account['user_point'];
		// 店舗情報取得
		$storeData = $this->manager->db_manager->get('store')->findById(getGet('store_id'));
		$data['store_id'] = $storeData['store_id'];
		$data['store_name'] = $storeData['store_name'];
		$data['course_price'] = course_price($storeData['store_id']);

		$this->loadView('indexP', $data);
	}


	/**
	 * 予約情報確認
	 *
	 */
	public function confirmAction(){
		$data = array();
		$post = array();

		$form_data = $this->getFormSession('form');

 		if(!$form_data || $this->validation($form_data) == false){
 			redirect('index.php');
 			exit();
 		}

		//予約するボタンが押された場合
		if(getPost('m') == 'thanks'){
			//登録処理
			$resrved_id = $this->inseart_action($form_data);

			if($resrved_id !== false){
				//フォームセッション削除
				$this->unsetFormSession('form');
				$this->setFormSession('resrved_id', $resrved_id);
				redirect('thanks.php');
			}

 		} else{
			$post = $this->getFormSession('form');
		}

		$data['post'] = escapeHtml($post);
		//表示データ
		$account = $this->getAccount();
 		$data['user_id'] = $account['user_id'];
 		$data['nickname'] = $account['nickname'];
 		$data['user_point'] = $account['user_point'];
		// 支払合計金額計算
		$data['total_price'] = $post['price']
				 - $post['use_point'];

		$this->loadView('confirm', $data);
	}


	/**
	 * 会員情報完了
	 *
	 */
	public function thanksAction(){
		$data = array();
		$post = array();

		$resrved_id = $this->getFormSession('resrved_id');
		$post = $this->manager->db_manager->get($this->use_table)->findById($resrved_id);
		$data['post'] = escapeHtml($post);
		$account = $this->getAccount();
 		$data['user_id'] = $account['user_id'];
 		$data['nickname'] = $account['nickname'];
 		$data['user_point'] = $account['user_point'];
		$data['point_code_array'] = str_split($post['point_code']);
		$reserved_date = new DateTime($post['reserved_date']);
		$data['reserved_date'] = $reserved_date->format('Y年 m月 d日  H:i');
		$date = new DateTime($post['use_date']);
		$data['use_date'] = $date->format('Y年 m月 d日');
		$data['use_time'] = $date->format('H');
		$data['use_min'] = $date->format('i');
		// 店舗情報取得
		$storeData = $this->manager->db_manager->get('store')->findById($post['store_id']);
		$data['store_name'] = $storeData['store_name'];

		$this->loadView('thanks', $data);
	}

	/**
	 * 予約情報入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function Validation($param){
		$this->manager->validation->setRule('use_person','isPnumeric');
		$this->manager->validation->setRule('use_date','required');
		$this->manager->validation->setRule('reserved_name','required');
		$this->manager->validation->setRule('telephone1','required|numeric|digit|pnumeric');
		$this->manager->validation->setRule('telephone2','required|numeric|digit|pnumeric');
		$this->manager->validation->setRule('telephone3','required|numeric|digit|pnumeric');
		$this->manager->validation->setRule('use_point','isPnumeric');
		$this->manager->validation->setRule('contract','checked');
		return $this->manager->validation->run($param);
	}

	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		//ログインチェック
		if(!$this->checkDBAccount()){
			//フォームセッション削除
			$this->unsetFormSession('form');
			redirect('../login.php');
		}

		if($param['get_point'] != '0') {
			$couponData = $this->manager->db_manager->get('coupon')->findById($this->getFormSession('coupon_id'));
			$param['coupon_id'] = $couponData['coupon_id'];
			$param['coupon_name'] = $couponData['coupon_name'];
			$param['use_condition'] = $couponData['use_condition'];
		}

		// コース情報取得
		$courseData = $this->manager->db_manager->get('course')->findById($param['course_id']);
		$param['store_id'] = $courseData['store_id'];
// 		$data['user_id'] = $this->getFormSession('user_id');
		$param['user_id'] = "1";
		$param['status_id'] = '1';
		$param['point_code'] = '1234567';
		$param['status_id'] = '0';
		$param['minutes'] = $courseData['minutes'];
		$param['telephone'] = $param['telephone1'].'-'.$param['telephone2'].'-'.$param['telephone3'];
		$param['total_price'] = $param['price'] - $param['use_point'];
		// 予約日時
		$date = new DateTime($param['use_date'].' '.$param['use_time'].':'.$param['use_min'].':00');
		$param['use_date'] = $date->format('Y-m-d H:i:s');
		$param['reserved_date'] = date('Y-m-d H:i:s');

		return $this->manager->db_manager->get($this->use_table)->insert($param);
	}
}

