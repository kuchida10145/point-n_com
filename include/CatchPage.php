<?php
/**
 * キャッチメール
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class CatchPage extends Page{

	protected $id = 0;/* ID */
	protected $use_table   = 'catchmail';
	protected $session_key = 'catchmail';
	protected $use_confirm = true;
	protected $page_title = 'キャッチメール';

	protected $view = array(
			'index'			=>'catch/index',
			'confirm'		=>'catch/confirm',
			'thanks'		=>'catch/thanks',
			'reply'			=>'catch/reply',
			'replyconfirm'	=>'catch/replyconfirm',
			'replythanks'	=>'catch/replythanks',
	);

	/**
	 * キャッチメール情報入力
	 *
	 */
	public function indexAction(){

		if(isset($_GET['m'])){
			if($_GET['m'] == 'change_upper_item'){
				$this->change_upper_itemAction();
			} elseif($_GET['m'] == 'change_area_second'){
				$this->change_area_secondAction();
			}
		}

		$data = array();
		$post = array();
		$error = array();
		$coupon_id = 0;
		$system_message = '';

		//ログインチェック
		$this->loginCheck();

		//会員データ
		$account = $this->getAccount();

		// キャッチメール情報取得
		$catchmail_data = $this->manager->db_manager->get('catchmail')->getCatchmailDataIsUser_id($account['user_id']);

		if(is_array($catchmail_data)){
			$this->replyAction($catchmail_data['catchmail_id']);
		} else {
			// キャッチメール有効時間を過ぎたものに対して削除フラグを立てる。
			// 店舗が決定しているものは削除フラグを立てない。
				$param = array('delete_flg' => 1);
				$where = "user_id = {$account['user_id']} AND decision_store IS NULL";
				$user_res = $this->manager->db_manager->get('catchmail')->update($param, $where);
		}

		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$this->token = $this->manager->token->createToken($this->session_key);
		}
		//トークン設定
		else{
			$this->token = getGet('tkn');
		}

		//会員データ
		$account = $this->getAccount();

		if(getPost('m') == 'confirm'){

			$post = $_POST;

			//予約日時設定
			if($post['time_kind'] == 0) {
				$reserved_date = date('Y-m-d H:i:s');
				$dead_time = date('Y-m-d H:i:s', strtotime("+ 1 hours"));
			} else {
				if(date('G') > 17 && $post['use_time'] < 7) {
					$reserved_date = date('Y-m-d', strtotime("+ 1 day"));
				} else {
					$reserved_date = date('Y-m-d');
				}
				$reserved_date = $reserved_date." ".$post['use_time'].":".$post['use_min'].":00";
				//失効時間
				//今からを選んだ場合今から１時間後
				//予約日時を指定した場合は予約日時まで
				$dead_time = $reserved_date;
			}

			//入力チェック
			if($this->Validation($post)){
				$form_data = array(
						'user_id'     			=> $account['user_id'],
						'use_time'   			=> $post['use_time'],
						'use_min'   			=> $post['use_min'],
						'use_persons'   		=> $post['use_persons'],
						'area_first_prefectures_id' 		=> $post['area_first_prefectures_id'],
						'area_second_id'		=> $post['area_second_id'],
						'area_third_id' 		=> $post['area_third_id'],
						'category_large_id'     => $post['category_large_id'],
						'category_midium_id' 	=> $post['category_midium_id'],
						'reserved_name'    		=> $post['reserved_name'],
						'reserved_date'    		=> $reserved_date,
						'dead_time'    			=> $dead_time,
						'time_kind'    			=> $post['time_kind'],
				);
				$this->setFormSession('form', $form_data);

				redirect( '/catch/confirm.php?tkn='.$this->token);
			}
			$error = $this->getValidationError();
		} else {
			$post = $this->getFormSession('form');
		}

		//データ格納
		if(!isset($post['reserved_name']) || $post['reserved_name'] == "") {
			$post['reserved_name'] = $account['nickname'];
		}

		if(!isset($post['area_first_prefectures_id']) || $post['area_first_prefectures_id'] == "") {
			$post['area_first_prefectures_id'] = $account['prefectures_id'];
		}

		if(!isset($post['time_kind'])) {
			$post['time_kind'] = 0;
		}
		$data['post']        = escapeHtml($post);
		$data['error']       = $error;
		$data['area_first_prefectures_id']   = $account['prefectures_id'];
		// 利用可能時間リスト
		// 分が15分刻みなので現在時刻が45分超えたら次の時間にする
		$min = (int)date('i');
		$time = ($min > 45) ? (int)date('G') + 1 : (int)date('G');
		$time = ($time == 25) ? 1 : $time;

		$use_time_list = array();
		for($time; $time < date('G') + 7; $time++) {
			if($time >= 24) {
				$set_val = $time - 24;
			} else {
				$set_val = $time;
			}

			$use_time_list[$set_val] = $set_val;
		}
		$data['use_time_list']   = $use_time_list;
		//利用可能分リスト
		$use_min_list = array(
			'00' => '00',
			'15' => '15',
			'30' => '30',
			'45' => '45',
		);

		$data['use_min_list']   = $use_min_list;
		$data['system_message']  = $system_message;

		$this->loadView('index', $data);
	}

	/**
	 * キャッチメール入力情報確認
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

		if(!$form_data || $this->Validation($form_data) == false){
			redirect('index.php');
			exit();
		}

		//予約するボタンが押された場合
		if(getPost('m') == 'thanks'){
			//DB処理
			$catchmail_id = $this->insert_action($form_data);	//キャッチメール情報登録

			//DB更新に失敗した場合
			if(!$catchmail_id){
				$this->unsetFormSession('form');
				redirect('failure.php');
			}

			//メール送付
			$this->sendUserMail($this->getAccount(), USER_MAIL_ID);
			$this->sendStoreMail($form_data['course_id'], STORE_MAIL_ID);

			if($catchmail_id !== false){
				//フォームセッション削除
				$this->unsetFormSession('form');
				$this->setFormSession('catchmail_id', $catchmail_id);
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

		$this->loadView('confirm', $data);
	}

	/**
	 * キャッチメール送信完了
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

		//予約内容
		$catchmail_id = $this->getFormSession('catchmail_id');
		$post = $this->manager->db_manager->get($this->use_table)->findById($catchmail_id);
		$data['post']             = escapeHtml($post);

		$this->loadView('thanks', $data);
	}

	/**
	 * キャッチメール返信画面
	 * @param int $catchmail_id
	 */
	public function replyAction($catchmail_id){
		$data = array();
		$post = array();
		$error = array();
		$reply_shops_data = array();
		$coupon_id = 0;
		$system_message = '';

		//ログインチェック
		$this->loginCheck();

		//トークンが設定されていない場合
		if(getGet('tkn') == ''){
			$this->token = $this->manager->token->createToken($this->session_key);
		}
		//トークン設定
		else{
			$this->token = getGet('tkn');
		}

		//会員データ
		$account = $this->getAccount();

		//キャチメール返信データ取得
		$reply_shops_data = $this->manager->db_manager->get('catchmail_return')->getReplyData($catchmail_id);

		$data['reply_shops_data']	= $reply_shops_data;
		$data['system_message']		= $system_message;
		$data['tkn']				= $this->token;

		$this->loadView('reply', $data);
	}

	/**
	 * キャッチメール店舗決定確認画面
	 * @param int $catchmail_id
	 */
	public function replyconfirmAction(){
		$data = array();
		$post = array();

		//トークンが無い場合エラー
		if(getGet('tkn') == ''){
			$this->errorAction();
		}
		$this->token = getGet('tkn');

		//ログインチェック
		$this->loginCheck();

		//決定ボタンが押された場合
		if(getPost('m') == 'thanks'){
			$post = $_POST;

			//DB処理
			$catchmail_id = $this->update_action($post['catchmail_id'], $post['store_name']);	//キャッチメール店舗決定情報登録

			//DB更新に失敗した場合
			if(!$catchmail_id){
				$this->unsetFormSession('form');
				redirect('failure.php');
			}

			//メール送付
			//$this->sendUserMail($this->getAccount(), USER_MAIL_ID);
			//$this->sendStoreMail($form_data['course_id'], STORE_MAIL_ID);

			if($catchmail_id !== false){
				//フォームセッション削除
				$this->unsetFormSession('form');
				$this->setFormSession('catchmail_return_id', $post['catchmail_return_id']);
				redirect('replythanks.php?tkn='.$this->token);
			}
 		}

 		//キャッチメールが存在しない場合はエラー
 		if(getGet('id') == ''){
 			redirect('index.php');
 			exit();
 		}

		//キャチメール返信データ取得
		$reply_shops_data = $this->manager->db_manager->get('catchmail_return')->getReplyConfirmData(getGet('id'));

		//表示データ
		$data['post']	= $reply_shops_data;
		$account = $this->getAccount();
 		$data['user_id'] = $account['user_id'];
 		$data['nickname'] = $account['nickname'];

		$this->loadView('replyconfirm', $data);
	}

	/**
	 * キャッチメール店舗決定完了
	 *
	 */
	public function replythanksAction(){
		$data = array();
		$post = array();

		//トークンが無い場合エラー
		if(getGet('tkn') == ''){
			$this->errorAction();
		}
		$this->token = getGet('tkn');

		$catchmail_reply_id = $this->getFormSession('catchmail_return_id');

		//予約内容
		$reply_shops_data	= $this->manager->db_manager->get('catchmail_return')->getReplyConfirmData($catchmail_reply_id);
		$data['post']		= escapeHtml($reply_shops_data);

		$this->loadView('replythanks', $data);
	}

	/**
	 * キャッチメール入力確認
	 * @param array $param 検証用配列
	 * @return boolean
	 */
	private function Validation($param){

		$this->manager->validation->setRule('use_person','isPnumeric');
		$this->manager->validation->setRule('reserved_name','required');
		$this->manager->validation->setRule('category_large_id','selected');
		$this->manager->validation->setRule('category_midium_id','selected');
		$this->manager->validation->setRule('area_first_prefectures_id','selected');
		$this->manager->validation->setRule('area_second_id','selected');
		$this->manager->validation->setRule('area_third_id','selected');

		return $this->manager->validation->run($param);
	}

	/**
	 * キャッチメール用新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function insert_action($param){
		//ログインチェック
		if(!$this->checkDBAccount()){
			//フォームセッション削除
			$this->unsetFormSession('form');
			redirect('../login.php');
		}

		$catchmail_id = $this->manager->db_manager->get($this->use_table)->insert($param);

		return $catchmail_id;
	}

	/**
	 * キャッチメール用更新処理
	 *  @param string $catchmail_id
	 *  @param string $store_name
	 * @return mixed
	 */
	protected function update_action($catchmail_id, $store_name){
		//ログインチェック
		if(!$this->checkDBAccount()){
			//フォームセッション削除
			$this->unsetFormSession('form');
			redirect('../login.php');
		}

		$id = $this->manager->db_manager->get('catchmail')->updateDecisionstore($catchmail_id, $store_name);

		return $id;
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

	/**
	 * 【店舗情報検索】中カテゴリのリスト取得（AJAX）
	 * - 業種（大カテゴリが1の場合：業種は1、2、大カテゴリが2、3の場合：業種は3）
	 * - 大カテゴリー(ジャンルマスター)
	 */
	protected function change_upper_itemAction(){
		$result['result'] = 'result';

		// 中カテゴリー
		$result['category_midium'] = array();
		// 小カテゴリー
		$result['category_small'] = array();
		// 第２エリア
		$result['area_second'] = array();
		// 第３エリア
		$result['area_third'] = array();

		$type_of_industry_id = $_POST['type_of_industry_id'];
		$category_large_id   = $_POST['category_large_id'];
		$prefectures_id      = $_POST['prefectures_id'];

		$is_getlist = false;
		if ($type_of_industry_id < 3 && $category_large_id == 1) {
			// 業種およびジャンルマスターが風俗の場合
			$is_getlist = true;
		} else if ($type_of_industry_id == 3 && $category_large_id > 1) {
			// 業種およびジャンルマスターが風俗以外の場合
			$is_getlist = true;
		}
		if ($is_getlist) {
			// 中カテゴリー
			$result['category_midium'] = category_midium($category_large_id, $prefectures_id);
			if (count($result['category_midium']) == 1 && isset($result['category_midium'][0])) {
				// 小カテゴリー
				$result['category_small'] = array(0=>non_select_item());
			}
			// 第２エリア
			$result['area_second'] = area_second_to_extend($category_large_id, $prefectures_id);
			if (count($result['area_second']) == 1 && isset($result['area_second'][0])) {
				// 第３エリア
				$result['area_third'] = array(0=>non_select_item());
			}
		}

		echo json_encode($result);
		exit();
	}

	/**
	 * 第２エリア選択時のリスト取得（AJAX)
	 */
	protected function change_area_secondAction(){
		$result['result'] = 'result';

		// 第３エリア
		$result['area_third'] = area_third($_POST['selected']);

		echo json_encode($result);
		exit();
	}

	/**
	 * 一覧用データ変換(HTMLエスケープも実行)
	 *
	 * @param array $datas
	 * @param boolean $is_escape_html
	 * @return NULL|array
	 */
	private function changeListData($datas, $is_escape_html) {
		if (!$datas) {
			return null;
		}

		foreach ($datas as $data_key => $data) {
			if (isset($data['image1'])) {
				$data['image1'] = '/files/images/' . $data['image1'];
			} else {
				$data['image1'] = '/img/no_image_shop.gif';
			}

			if ($is_escape_html) {
				$data = escapeHtml($data);
			}

			$datas[$data_key] = $data;
		}

		return $datas;
	}
}

