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
		$coupon_id = 0;

		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$this->token = $this->manager->token->createToken($this->session_key);

			//クーポンIDが設定されている場合
			if(getGet('coupon_id') != ''){
				$this->setFormSession('coupon_id', getGet('coupon_id'));
				redirect('?tkn='.$this->token);
			}
			//店舗IDが設定されている場合
			else if(getGet('store_id') != ''){
				$this->setFormSession('store_id', getGet('store_id'));
				redirect('?tkn='.$this->token);
			}
			else{
				$this->errorAction();
			}
		}
		//トークン設定
		else{
			$this->token = getGet('tkn');
		}

		$this->loginCheck();

		//店舗IDがある場合
		if($this->getFormSession('store_id') != ''){
			$this->indexPointOnlyAction();
			exit();
		}


		//クーポンID設定
		$coupon_id = $this->getFormSession('coupon_id');

		//会員データ
		$account = $this->getAccount();

		// クーポン情報取得
 		if(!$couponData = $this->manager->db_manager->get('coupon')->findById($coupon_id)){
			$this->errorAction();
		}
		// 店舗情報取得
		if(!$storeData = $this->manager->db_manager->get('store')->findById($couponData['store_id'])){
			$this->errorAction();
		}
		// コース情報取得
		if(!$courseData = $this->manager->db_manager->get('course')->findById($couponData['course_id'])){
			$this->errorAction();
		}


		if(getPost('m') == 'confirm'){
			$post = $_POST;
			//入力チェック
			if($this->Validation($post)){
				$form_data = array(
						'coupon_id'     => $coupon_id,
						'get_point'     => $couponData['point'],
						'course_id'     => $courseData['course_id'],
						'course_name'   => $courseData['course_name'],
						'store_name'    => $storeData['store_name'],
						'use_persons'   => $post['use_persons'],
						'use_date'      => $post['use_date'],
						'use_time'      => $post['use_time'],
						'use_min'       => $post['use_min'],
						'reserved_name' => $post['reserved_name'],
						'telephone1'    => $post['telephone1'],
						'telephone2'    => $post['telephone2'],
						'telephone3'    => $post['telephone3'],
						'price'         => str_replace(',', '', $post['price']),
						'use_point'     => str_replace(',', '', getParam(use_point_data(), $post['use_point'])),
						'contract'      => $post['contract'],
						'status_id'     => RESERVE_ST_YET,
				);
				$this->setFormSession('form', $form_data);
				redirect( '/reservation/confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		} else {
			$post = $this->getFormSession('form');
		}




		//データ格納
		$data['post']        = escapeHtml($post);
		$data['error']       = $error;
		$data['get_point']   = number_format($couponData['point']);
		$data['course_id']   = $courseData['course_id'];
		$data['course_name'] = escapeHtml($courseData['course_name']);
		$data['store_name']  = escapeHtml($storeData['store_name']);
		$data['price']       = number_format($courseData['price']);
		$data['point_list']  = $this->getUsePoint($account['point']);

		$this->loadView('index', $data);
	}

	/**
	 * 予約情報入力(ポイントのみ利用)
	 *
	 */
	private function indexPointOnlyAction(){
		$data = array();
		$post = array();
		$error = array();

		//店舗ID設定
		$store_id = $this->getFormSession('store_id');

		//会員データ
		$account = $this->getAccount();


		// 店舗情報取得
		if(!$storeData = $this->manager->db_manager->get('store')->findById($store_id)){
			$this->errorAction();
		}


		if(getPost('m') == 'confirm'){
			$post = $_POST;
			//入力チェック
			if($this->Validation($post)){
				// コース情報取得
				if(!$courseData = $this->manager->db_manager->get('course')->findById($post['course_id'])){
					$this->errorAction();
				}


				$form_data = array(
						'get_point'     => '0',
						'course_id'     => $post['course_id'],
						'course_name'   => $courseData['course_name'],
						'store_name'    => $storeData['store_name'],
						'use_persons'   => $post['use_persons'],
						'use_date'      => $post['use_date'],
						'use_time'      => $post['use_time'],
						'use_min'       => $post['use_min'],
						'reserved_name' => $post['reserved_name'],
						'telephone1'    => $post['telephone1'],
						'telephone2'    => $post['telephone2'],
						'telephone3'    => $post['telephone3'],
						'price'         => $courseData['price'],
						'use_point'     => str_replace(',', '', getParam(use_point_data(), $post['use_point'])),
						'contract'      => $post['contract'],
						'status_id'     => RESERVE_ST_YET,
				);
				$this->setFormSession('form', $form_data);
				redirect( '/reservation/confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		} else {
			$post = $this->getFormSession('form');
		}

		$data['post']         = escapeHtml($post);
		$data['error']        = $error;
		$data['store_id']     = $storeData['store_id'];
		$data['store_name']   = $storeData['store_name'];
		$data['course_price'] = course_price($storeData['store_id']);
		$data['point_list']  = $this->getUsePoint($account['point']);

		$this->loadView('indexP', $data);
	}


	/**
	 * 予約情報確認
	 *
	 */
	public function confirmAction(){
		$data = array();
		$post = array();

		//トークンが無い場合エラー
		if(getGet('tkn') == ''){
			$this->errorAction();
		}
		$this->token = getGet('tkn');


		//ログインチェック
		$this->loginCheck();

		$form_data = $this->getFormSession('form');

 		if(!$form_data || $this->validation($form_data) == false){
 			redirect('index.php');
 			exit();
 		}

		//予約するボタンが押された場合
		if(getPost('m') == 'thanks'){
			//登録処理
			$resrved_id = $this->inseart_action($form_data);
			//メール送付
			$this->sendUserMail($this->getAccount(), USER_MAIL_ID);
			$this->sendStoreMail($form_data['course_id'], STORE_MAIL_ID);

			if($resrved_id !== false){
				//フォームセッション削除
				$this->unsetFormSession('form');
				$this->setFormSession('resrved_id', $resrved_id);
				redirect('thanks.php?tkn='.$this->token);
			}

 		} else{
			$post = $this->getFormSession('form');
		}

		$data['post'] = escapeHtml($post);
		//表示データ
		$account = $this->getAccount();
 		$data['user_id'] = $account['user_id'];
 		$data['nickname'] = $account['nickname'];
		// 支払合計金額計算
		$data['total_price'] = $post['price'] - $post['use_point'];

		//獲得PT
		$data['get_point']   = number_format($post['get_point']);

		$this->loadView('confirm', $data);
	}


	/**
	 * 会員情報完了
	 *
	 */
	public function thanksAction(){
		$data = array();
		$post = array();

		//トークンが無い場合エラー
		if(getGet('tkn') == ''){
			$this->errorAction();
		}
		$this->token = getGet('tkn');

		//予約ID
		$resrved_id = $this->getFormSession('resrved_id');

		//予約内容
		$post = $this->manager->db_manager->get($this->use_table)->findById($resrved_id);

		//会員データ
		$account = $this->getAccount();

		//予約日
		$reserved_date = new DateTime($post['reserved_date']);

		//利用日
		$date = new DateTime($post['use_date']);


		// 店舗情報取得
		$storeData = $this->manager->db_manager->get('store')->findById($post['store_id']);

		$data['post']             = escapeHtml($post);
 		//$data['user_id']          = $account['user_id'];
 		//$data['nickname']         = $account['nickname'];
 		//$data['user_point']       = $account['user_point'];
		$data['point_code_array'] = str_split($post['point_code']);
		$data['reserved_date']    = $reserved_date->format('Y年 m月 d日  H:i');
		$data['use_date']         = $date->format('Y年 m月 d日');
		$data['use_time']         = $date->format('H');
		$data['use_min']          = $date->format('i');
		$data['store_name']       = $storeData['store_name'];

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

		$account = $this->getAccount();
		// コース情報取得
		$courseData = $this->manager->db_manager->get('course')->findById($param['course_id']);
		$param['store_id'] = $courseData['store_id'];
		$param['user_id'] = $account['user_id'];
		$param['point_code'] = $this->makePointCode($param['store_id']);
		$param['minutes'] = $courseData['minutes'];
		$param['telephone'] = $param['telephone1'].'-'.$param['telephone2'].'-'.$param['telephone3'];
		$param['total_price'] = $param['price'] - $param['use_point'];
		// 予約日時
		$date = new DateTime($param['use_date'].' '.$param['use_time'].':'.$param['use_min'].':00');
		$param['use_date'] = $date->format('Y-m-d H:i:s');
		$param['reserved_date'] = date('Y-m-d H:i:s');

		return $this->manager->db_manager->get($this->use_table)->insert($param);
	}



	/**
	 * ログインチェック
	 *
	 */
	private function loginCheck(){
		$account = $this->getAccount();
		if(!$account){
			redirect('/login.php?back=reserve&tkn='.getGet('tkn'));
		}
		else{
			//DBにデータが無い場合はセッションごと削除
			$user_id = $account['user_id'];
			if(!$account = $this->manager->db_manager->get('user')->getActiveUserById($user_id)){
				$this->clearAccountSession();
				redirect('/login.php');
			}

			$this->setAccount($account);
		}
	}

	/**
	 * 利用ポイントデータ取得
	 *
	 */
	private function getUsePoint($userPoint) {
		$pointArray = array();
		foreach (use_point_data() as $point=>$value) {
			if($userPoint >= $point || $point == 1) {
				$pointArray[$point] = $value;
			}
		}
		return $pointArray;
	}

	/**
	 * ポイントコード生成
	 * @param $store_id		店舗id
	 * @return $point_code	ポイントコード
	 */
	private function makePointCode($store_id) {
		$storeData = $this->manager->db_manager->get('store')->findById($store_id);
		$reservedData = $this->manager->db_manager->get('reserved')->getStorePointCode($store_id);
		$pointCode_3 = substr($reservedData['point_code'], POINT_CODE_FOR_NUM);
		$pointCode_3 = $pointCode_3 + 1;
		if($pointCode_3 === POINT_CODE_NUM_MAX) {
			$pointCode_3 = POINT_CODE_NUM_MIN;
		}
		$point_code = $storeData['store_hex_id'].sprintf('%03d', $pointCode_3);

		return $point_code;
	}

	/**
	 * ユーザへメール送信
	 * @param $userData	ユーザデータ
	 * @param $mailId	送信するメールID
	 */
	private function sendUserMail($userData, $mailId) {
		$mail = $this->manager->db_manager->get('automail')->findById($mailId);
		//メール用データ
		$mail_data['nickname'] = $userData['nickname'];
		$mail = create_mail_data($mail,$mail_data);
		$mail['to'] = $userData['email'];
		$this->manager->mailer->setMailData($mail);
		$this->manager->mailer->sendMail();
	}

	/**
	 * 店舗へメール送信
	 * @param $courseID	コースID
	 * @param $mailId	送信するメールID
	 */
	private function sendStoreMail($courseID, $mailId) {
		//店舗データ取得
		$courseData = $this->manager->db_manager->get('course')->findById($courseID);
		$storeData = $this->manager->db_manager->get('store')->findById($courseData['store_id']);
		$mail = $this->manager->db_manager->get('automail')->findById($mailId);
		//メール用データ
		$mail_data['store_name'] = $storeData['store_name'];
		$mail = create_mail_data($mail,$mail_data);
		$mail['to'] = $storeData['reserved_email'];
		$this->manager->mailer->setMailData($mail);
		$this->manager->mailer->sendMail();
	}
}

