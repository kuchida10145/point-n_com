<?php
/**
 * アカウント管理
 *
 */
include_once(dirname(__FILE__) . '/../common/MaintenancePage.php');
include_once(dirname(__FILE__) . '/../common/StoreCommonPage.php');

class AccountPage extends MaintenancePage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'store';
	protected $session_key = 'store';
	protected $use_confirm = true;
	protected $page_title = 'アカウント管理';
	
	protected function indexAction() {
		$data = array();
		$post = array();
		$error = array();
		$account = $this->getAccount();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		
		if ($account == NULL) {
			redirect('login.html');
		}
		
		$this->id = $account['store_id'];
		if (getPost('m') == 'account') {
			$post = $_POST;
			if ($this->validation($post)) {
				// 更新対象の項目
				$update_fields = array(
					'account_name', 'login_id', 'login_password',
					'image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9', 
					'introduction', 'latitude', 'longitude', 'zip_code1', 'zip_code2', 'prefectures_id', 
					'address1', 'address2', 'business_hours', 'telephone1', 'telephone2', 'telephone3', 'holiday', 
					'url_outside1', 'url_outside2', 'url_official1', 'url_official2', 'url_official3', 'url_official4',
					'representative_sei', 'representative_mei', 'representative_email', 'reserved_email',
					'bank_name1', 'bank_kind1', 'bank_account_number1', 'bank_account_holder1',
					'bank_name2', 'bank_kind2', 'bank_account_number2', 'bank_account_holder2',
					'bank_name3', 'bank_kind3', 'bank_account_number3', 'bank_account_holder3',
					'jpbank_symbol1', 'jpbank_symbol2', 'jpbank_account_number', 'jpbank_account_holder',
				);
				
				foreach ($update_fields as $field_name) {
					$upd_data[$field_name] = $post[$field_name];
				}
				
				$this->update_actoin($upd_data);
				
				$account = $this->manager->db_manager->get($this->use_table)->findById($account['store_id']);
				$this->setAccount($account);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
				
				redirect('account.php');
			}
			$system_message = $this->manager->message->get('system')->getMessage('edit_error');
			$error = $this->getValidationError();
		} else {
			$post = $this->manager->db_manager->get($this->use_table)->findById($account['store_id']);
			$post = $this->dbToInputData($post);
		}
		
		$data['login_id'] = $account['login_id'];
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['page_title'] = $this->page_title;
		$data['page_type_text'] = '';
		$data['system_message'] = $system_message;
		$this->loadView('edit', $data);
	}
	
	/**
	 * ＤＢデータから入力用データへ変換
	 * 
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data) {
		$store_common = new StoreCommonPage($this->manager);
		return $store_common->dbToInputData($data, $this->id);
	}
	
	/**
	 * 入力チェック
	 * 
	 */
	protected function validation($param) {
		// 更新の場合はＩＤを設定
		$isUpdate = false;
		if ($this->id != 0) {
			$isUpdate = true;
			$param['store_id'] = $this->id;
		}
		
		$store_common = new StoreCommonPage($this->manager);
		return $store_common->validation($param, $isUpdate, false);
	}
	
	/**
	 * 第1エリアマスターの第1エリアIDを導出する
	 * 
	 * @param array $param パラメータ
	 * @return number
	 */
	protected function derive_area_first_id($param) {
		$store_common = new StoreCommonPage($this->manager);
		return $store_common->derive_area_first_id($param);
	}
	
	/**
	 * 更新処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_actoin($param) {
		// DB用データに変換
		$param = $this->inputToDbData($param);
		
		$store_common = new StoreCommonPage($this->manager);
		return $store_common->update_action($param, $this->id, $this->use_table);
	}
	
	/**
	 * 入力用データからＤＢデータへ変換
	 * insert_actionやupdate_actionをオーバーライドしparentで呼び出した時、オーバーライド内にも書くと２回実行されるので注意
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function inputToDbData($data) {
		return $data;
	}
	
	/**
	 * 画像アップロード（AJAX)
	 */
	protected function image_uploadAction(){
		$store_common = new StoreCommonPage($this->manager);
		$store_common->image_uploadAction();
	}
}
