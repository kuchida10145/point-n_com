<?php
/**
 * 店舗共通情報管理
 *
 */

class StoreCommonPage {
	
	/** @var Management */
	protected $manager = null;
	
	/**
	 * コンストラクタ
	 * 
	 * @param Management $manager Management クラスのインスタンス
	 */
	public function __construct($manager = null) {
		$this->setManager($manager);
	}
	
	/**
	 * Management インスタンスの設定
	 * 
	 * @param Management $manager
	 */
	public function setManager($manager) {
		$this->manager = $manager;
	}
	
	/**
	 * ＤＢデータから入力用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @param string $primary_key プライマリーキー
	 * @return array 変換後データ
	 */
	public function dbToInputData($data, $primary_key) {
		// 現在のステータス
		$data['cur_status_id'] = $data['status_id'];
		// 現在の許可証ファイル名
		$data['cur_license'] = $data['license'];
		// パスワードデコード
		$data['login_password'] = decodePassword($data['login_password']);
		// 第1エリア(都道府県)
		$data['area_first_prefectures_id'] = "";
		$area_first_data = $this->manager->db_manager->get('area_first')->findById($data['area_first_id']);
		if ($area_first_data != null) {
			if ($area_first_data['prefectures_id'] > 0) {
				$prefectures_id = $area_first_data['prefectures_id'];
			} else {
				$records = $this->manager->db_manager->get('prefectures_master')->searchForPrefecturesName($area_first_data['area_first_name']);
				$prefectures_id = isset($records[0]['prefectures_id']) ? $records[0]['prefectures_id'] : "";
			}
			$data['area_first_prefectures_id'] = $prefectures_id;
		}
		// 契約郵便番号
		$data['contract_zip_code1'] = (strlen($data['contract_zip_code']) > 0) ? substr($data['contract_zip_code'], 0, 3) : "";
		$data['contract_zip_code2'] = (strlen($data['contract_zip_code']) > 3) ? substr($data['contract_zip_code'], 3)    : "";
		// 契約電話番号
		$telephone = explode("-", $data['contract_telephone']);
		$data['contract_telephone1'] = isset($telephone[0]) ? $telephone[0] : "";
		$data['contract_telephone2'] = isset($telephone[1]) ? $telephone[1] : "";
		$data['contract_telephone3'] = isset($telephone[2]) ? $telephone[2] : "";
		// 現在の画像１〜９
		for ($i = 1; $i <= 9; $i++) {
			$data['cur_image' . $i] = $data['image' . $i];
		}
		// 郵便番号
		$data['zip_code1'] = (strlen($data['zip_code']) > 0) ? substr($data['zip_code'], 0, 3) : "";
		$data['zip_code2'] = (strlen($data['zip_code']) > 3) ? substr($data['zip_code'], 3)    : "";
		// 電話番号
		$telephone = explode("-", $data['telephone']);
		$data['telephone1'] = isset($telephone[0]) ? $telephone[0] : "";
		$data['telephone2'] = isset($telephone[1]) ? $telephone[1] : "";
		$data['telephone3'] = isset($telephone[2]) ? $telephone[2] : "";
		// メールアドレス
		$data['representative_email_confirm'] = $data['representative_email'];
		// 予約受信メールアドレス
		$data['reserved_email_confirm'] = $data['reserved_email'];
		// 銀行
		$bank_data = $this->manager->db_manager->get('bank_account')->searchForStoreId($primary_key);
		$bank_data = ($bank_data != null) ? $bank_data : array();
		for ($i = 1; $i <= 3; $i++) {
			if (!isset($bank_data[$i-1]['bank_account_id'])) {
				continue;
			}
			$data['bank_name' . $i]   = $bank_data[$i-1]['bank_name'];
			$data['branch_name' . $i] = $bank_data[$i-1]['branch_name'];
			$data['bank_kind' . $i]   = $bank_data[$i-1]['bank_kind'];
			$data['bank_account_number' . $i] = $bank_data[$i-1]['bank_account_number'];
			$data['bank_account_holder' . $i] = $bank_data[$i-1]['bank_account_holder'];
		}
		// ゆうちょ銀行
		$bank_data = $this->manager->db_manager->get('jpbank_account')->searchForStoreId($primary_key);
		$bank_data = ($bank_data != null) ? $bank_data : array();
		if (isset($bank_data[0]['bank_account_id'])) {
			$data['jpbank_symbol1'] = $bank_data[0]['jpbank_symbol1'];
			$data['jpbank_symbol2'] = $bank_data[0]['jpbank_symbol2'];
			$data['jpbank_account_number'] = $bank_data[0]['jpbank_account_number'];
			$data['jpbank_account_holder'] = $bank_data[0]['jpbank_account_holder'];
		}
		return $data;
	}
	
	/**
	 * 入力値チェック
	 * 
	 * @param array $param
	 * @param boolean $isUpdate
	 * @param boolean $isAdmin
	 */
	public function validation($param, $isUpdate, $isAdmin) {
		if ($isAdmin) {
			// 店舗名
			$this->manager->validation->setRule('store_name',          'required|maxlength:50');
			// 業種
			$this->manager->validation->setRule('type_of_industry_id', 'required');
			// 契約郵便番号
			$this->manager->validation->setRule('contract_zip_code1',        'required|numeric');
			$this->manager->validation->setRule('contract_zip_code2',        'required|numeric');
			$param['contract_zip_code'] = $param['contract_zip_code1'] . $param['contract_zip_code2'];
			$this->manager->validation->setRule('contract_zip_code',         'postcode');
			// 契約都道府県
			$this->manager->validation->setRule('contract_prefectures_id',   'selected');
			// 契約市町村番地
			$this->manager->validation->setRule('contract_address1',         'required|maxlength:100');
			// 契約マンション/ビル名
			$this->manager->validation->setRule('contract_address2',         'maxlength:100');
			// 契約電話番号
			$this->manager->validation->setRule('contract_telephone1',       'required|numeric');
			$this->manager->validation->setRule('contract_telephone2',       'required|numeric');
			$this->manager->validation->setRule('contract_telephone3',       'required|numeric');
			$param['contract_telephone'] = $param['contract_telephone1'] . "-" . $param['contract_telephone2'] . "-" . $param['contract_telephone3'];
			$this->manager->validation->setRule('contract_telephone',        'tel');
			// 許可証の表示
			$this->manager->validation->setRule('license',             'required');
			
			//ポイント関連
			$this->manager->validation->setRule('point_limit','required|zero_moneyChk');
			$this->manager->validation->setRule('base_point','required|plus_moneyChk');
		}
		// ユーザー名
		$this->manager->validation->setRule('account_name',        'required|maxlength:50');
		// ログインID
		$this->manager->validation->setRule('login_id',            'required|password:6:12|duplicate_id');
		// パスワード
		$this->manager->validation->setRule('login_password',  'required|password:4:8');
		if ($isAdmin) {
			// 第1エリア
			$this->manager->validation->setRule('area_first_prefectures_id', 'selected');
			// ジャンルマスター
			$this->manager->validation->setRule('category_large_id',         'selected');
			// 中カテゴリー
			$this->manager->validation->setRule('category_midium_id',        'selected');
			// 小カテゴリー
			$this->manager->validation->setRule('category_small_id',         'selected');
			// 第2エリア
			$this->manager->validation->setRule('area_second_id',            'selected');
			// 第3エリア
			$this->manager->validation->setRule('area_third_id',             'selected');
		}
		// 郵便番号
		$this->manager->validation->setRule('zip_code1',                 'required|numeric');
		$this->manager->validation->setRule('zip_code2',                 'required|numeric');
		$param['zip_code'] = $param['zip_code1'] . $param['zip_code2'];
		$this->manager->validation->setRule('zip_code',                  'postcode');
		// 都道府県
		$this->manager->validation->setRule('prefectures_id',            'selected');
		// 市町村番地
		$this->manager->validation->setRule('address1',                  'required|maxlength:100');
		// マンション/ビル名
		$this->manager->validation->setRule('address2',                  'maxlength:100');
		// 緯度
		$this->manager->validation->setRule('latitude',                  'pdecimal_zero|maxlength:50');
		// 経度
		$this->manager->validation->setRule('longitude',                 'pdecimal_zero|maxlength:50');
		// 営業時間
		$this->manager->validation->setRule('business_hours',            'required');
		// 電話番号
		$this->manager->validation->setRule('telephone1',                'required|numeric');
		$this->manager->validation->setRule('telephone2',                'required|numeric');
		$this->manager->validation->setRule('telephone3',                'required|numeric');
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		$this->manager->validation->setRule('telephone',                 'tel');
		// 休日
		$this->manager->validation->setRule('holiday',                   'required|maxlength:50');
		// 公式サイト1
		$this->manager->validation->setRule('url_official1',             'maxlength:256');
		// 公式サイト2
		$this->manager->validation->setRule('url_official2',             'maxlength:256');
		// 公式サイト3
		$this->manager->validation->setRule('url_official3',             'maxlength:256');
		// 公式サイト4
		$this->manager->validation->setRule('url_official4',             'maxlength:256');
		// 外部サイト用リンクテキスト1
		$this->manager->validation->setRule('link_text_outside1',        'maxlength:100');
		// 外部サイト用リンクテキスト2
		$this->manager->validation->setRule('link_text_outside2',        'maxlength:100');
		// 外部サイト用リンクテキスト3
		$this->manager->validation->setRule('link_text_outside3',        'maxlength:100');
		// 外部サイト用リンクテキスト4
		$this->manager->validation->setRule('link_text_outside4',        'maxlength:100');
		// 外部サイト用リンクテキスト5
		$this->manager->validation->setRule('link_text_outside5',        'maxlength:100');
		// 外部サイト1
		$this->manager->validation->setRule('url_outside1',              'maxlength:256');
		// 外部サイト2
		$this->manager->validation->setRule('url_outside2',              'maxlength:256');
		// 外部サイト3
		$this->manager->validation->setRule('url_outside3',              'maxlength:256');
		// 外部サイト4
		$this->manager->validation->setRule('url_outside4',              'maxlength:256');
		// 外部サイト5
		$this->manager->validation->setRule('url_outside5',              'maxlength:256');
		// 担当者姓
		$this->manager->validation->setRule('representative_sei',        'required|maxlength:30');
		// 担当者名
		$this->manager->validation->setRule('representative_mei',        'required|maxlength:30');
		// メールアドレス
		$this->manager->validation->setRule('representative_email',      'required|email|maxlength:256');
		// 確認用メールアドレス
		$this->manager->validation->setRule('representative_email_confirm', 'required|email|maxlength:256');
		// 入力メールアドレスの同値チェック
		if ($param['representative_email'] != "" && $param['representative_email_confirm'] != "") {
			$param['representative_email_both'] = $param['representative_email'] . ',' . $param['representative_email_confirm'];
			$this->manager->validation->setRule('representative_email_both', 'same_email');
		}
		// 予約受信メールアドレス
		$this->manager->validation->setRule('reserved_email',            'required|email|maxlength:256');
		// 確認用予約受信メールアドレス
		$this->manager->validation->setRule('reserved_email_confirm',    'required|email|maxlength:256');
		// 入力予約受信メールアドレスの同値チェック
		if ($param['reserved_email'] != "" && $param['reserved_email_confirm'] != "") {
			$param['reserved_email_both'] = $param['reserved_email'] . ',' . $param['reserved_email_confirm'];
			$this->manager->validation->setRule('reserved_email_both',       'same_email');
		}
		// 銀行
		for ($i = 1; $i <= 3; $i++) {
			if ($i == 1 || ($param['bank_name'.$i] != "" || $param['branch_name'.$i] != "" || $param['bank_kind'.$i] != "" || $param['bank_account_number'.$i] != "" || $param['bank_account_holder'.$i] != "")) {
				// 銀行名
				$this->manager->validation->setRule('bank_name'.$i,           'required|maxlength:50');
				// 銀行支店名
				$this->manager->validation->setRule('branch_name'.$i,         'required|maxlength:50');
				// 口座種類
				$this->manager->validation->setRule('bank_kind'.$i,           'selected');
				// 口座番号
				$this->manager->validation->setRule('bank_account_number'.$i, 'required|numeric|maxlength:30');
				// 口座名義人
				$this->manager->validation->setRule('bank_account_holder'.$i, 'required|maxlength:50');
			}
		}
		// ゆうちょ銀行
		if ($param['jpbank_symbol1'] != "" || $param['jpbank_symbol2'] != "" || $param['jpbank_account_number'] != "" || $param['jpbank_account_holder'] != "") {
			// 記号１
			$this->manager->validation->setRule('jpbank_symbol1', 'required|alphanumeric|maxlength:20');
			// 記号２
			$this->manager->validation->setRule('jpbank_symbol2', 'required|alphanumeric|maxlength:20');
			// 口座番号
			$this->manager->validation->setRule('jpbank_account_number', 'required|numeric|maxlength:30');
			// 口座名義人
			$this->manager->validation->setRule('jpbank_account_holder', 'required|maxlength:50');
		}
		
		return $this->manager->validation->run($param);
	}
	
	/**
	 * 第1エリアマスターの第1エリアIDを導出する
	 * 
	 * @param array $param パラメータ
	 * @return number
	 */
	public function derive_area_first_id($param) {
		$area_first_id = 0;
		if ($param['area_second_id'] > 0) {
			// 第2エリアマスターのレコードから第1エリアIDを導出する
			$area_second_data = $this->manager->db_manager->get('area_second')->findById($param['area_second_id']);
			$area_first_id = isset($area_second_data['area_first_id']) ? $area_second_data['area_first_id'] : 0;
		} else {
			// 第1エリアマスターテーブルからレコードを引き出す
			$prefectures_data = $this->manager->db_manager->get('prefectures_master')->findById($param['area_first_prefectures_id']);
			$region_id = isset($prefectures_data['region_id']) ? $prefectures_data['region_id'] : 0;
			$prefectures_name = isset($prefectures_data['prefectures_name']) ? $prefectures_data['prefectures_name'] : "";
			$prefectures_id = $param['area_first_prefectures_id'];
			$category_large_id = $param['category_large_id'];
			$is_delivery = is_delivery($param['type_of_industry_id']);
			$records = $this->manager->db_manager->get('area_first')->searchForCategoryLargeId(
					$category_large_id, $region_id, $is_delivery, $prefectures_id, $prefectures_name);
			$records = ($records != null) ? $records : array();
			if (count($records) == 1) {
				$area_first_id = $records[0]['area_first_id'];
			} else if (count($records) > 1) {
				$area_first_id = $records[$is_delivery]['area_first_id'];
			}
		}
		return $area_first_id;
	}
	
	/**
	 * 更新処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @param string $primary_key プライマリーキー
	 * @param string $update_table 更新テーブル
	 * @param boolean $isAdmin
	 * @return mixed
	 */
	public function update_action($param, $primary_key, $update_table, $isAdmin) {
		// パスワード暗号化
		if (getParam($param, 'login_password') != '') {
			$param['login_password'] = encodePassword($param['login_password']);
		} else {
			unset($param['login_password']);
		}
		if ($isAdmin) {
			// 第1エリア(都道府県)
			$param['area_first_id'] = $this->derive_area_first_id($param);
			// 契約郵便番号
			$param['contract_zip_code'] = $param['contract_zip_code1'] . $param['contract_zip_code2'];
			// 契約電話番号
			$param['contract_telephone'] = $param['contract_telephone1'] . "-" . $param['contract_telephone2'] . "-" . $param['contract_telephone3'];
		}
		// 郵便番号
		$param['zip_code'] = $param['zip_code1'] . $param['zip_code2'];
		// 電話番号
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		$id = $this->manager->db_manager->get($update_table)->updateById($primary_key, $param);
		if ($id === false) {
			return false;
		}
		
		// ステータス(1：準備中、2：運営中、9：停止中)
		// ※ステータスが停止中はアップロードしたファイルを「2：使用不可」とする
		$use_state = ($param['status_id'] == 9) ? 2 : 1;
		
		if ($isAdmin) {
			// 許可証
			$update_param = array();
			$update_param['use_state'] = $use_state;
			$this->manager->db_manager->get('temp_image')->updateByFileName($param['license'], $update_param);
			if ($param['cur_license'] != "" && $param['license'] != $param['cur_license']) {
				delete_file($param['cur_license']);
			}
		}
		
		// 画像1〜9
		$images = array();
		for ($i = 1; $i <= 9; $i++) {
			if (getParam($param,'image' . $i) == '') {
				continue;
			}
			$images[] = $param['image' . $i];
			$update_param = array();
			$update_param['use_state'] = $use_state;
			$this->manager->db_manager->get('temp_image')->updateByFileName($param['image' . $i], $update_param);
		}
		for ($i = 1; $i <= 9; $i++) {
			if ($param['cur_image' . $i] == '') {
				continue;
			}
			if (!in_array($param['cur_image' . $i], $images)) {
				delete_file($param['cur_image' . $i]);
			}
		}
		
		// 店舗のお知らせでアップロードしたファイルの使用不可制御
		$notice_list = $this->manager->db_manager->get('notice')->getListByStoreID($primary_key);
		if (is_array($notice_list)) {
			$notice_images = array();
			foreach ($notice_list as $key => $notice) {
				for ($i = 1; $i <= 3; $i++) {
					if (empty($notice['image' . $i])) {
						continue;
					}
					$notice_images[] = $notice['image' . $i];
				}
			}
			foreach ($notice_images as $notice_image) {
				$update_param = array();
				$update_param['use_state'] = $use_state;
				$this->manager->db_manager->get('temp_image')->updateByFileName($notice_image, $update_param);
			}
		}
		
		// .htaccess ファイルを生成してアップロードファイルの使用可否制御
		set_cannot_use_file();
		
		// 銀行
		$bank_data = $this->manager->db_manager->get('bank_account')->searchForStoreId($primary_key);
		for ($i = 1; $i <= 3; $i++) {
			$bank_param = array();
			if ($param['bank_account_holder' . $i] == "") {
				if (isset($bank_data[$i-1]['bank_account_id'])) {
					$bank_param['delete_flg'] = 1;
					$this->manager->db_manager->get('bank_account')->updateById($bank_data[$i-1]['bank_account_id'], $bank_param);
				}
				continue;
			}
			$bank_param['store_id']    = $id;
			$bank_param['bank_name']   = $param['bank_name' . $i];
			$bank_param['branch_name'] = $param['branch_name' . $i];
			$bank_param['bank_kind']   = $param['bank_kind' . $i];
			$bank_param['bank_account_number'] = $param['bank_account_number' . $i];
			$bank_param['bank_account_holder'] = $param['bank_account_holder' . $i];
			if (isset($bank_data[$i-1]['bank_account_id'])) {
				$this->manager->db_manager->get('bank_account')->updateById($bank_data[$i-1]['bank_account_id'], $bank_param);
			} else {
				$this->manager->db_manager->get('bank_account')->insert($bank_param);
			}
		}
		
		// ゆうちょ銀行
		$bank_data = $this->manager->db_manager->get('jpbank_account')->searchForStoreId($primary_key);
		if ($param['jpbank_account_holder'] != "") {
			$jpbank_param = array();
			$jpbank_param['store_id'] = $id;
			$jpbank_param['jpbank_symbol1'] = $param['jpbank_symbol1'];
			$jpbank_param['jpbank_symbol2'] = $param['jpbank_symbol2'];
			$jpbank_param['jpbank_account_number'] = $param['jpbank_account_number'];
			$jpbank_param['jpbank_account_holder'] = $param['jpbank_account_holder'];
			if (isset($bank_data[0]['bank_account_id'])) {
				$this->manager->db_manager->get('jpbank_account')->updateById($bank_data[0]['bank_account_id'], $jpbank_param);
			} else {
				$this->manager->db_manager->get('jpbank_account')->insert($jpbank_param);
			}
		} else {
			if (isset($bank_data[0]['bank_account_id'])) {
				$jpbank_param = array();
				$jpbank_param['delete_flg'] = 1;
				$this->manager->db_manager->get('jpbank_account')->updateById($bank_data[0]['bank_account_id'], $jpbank_param);
			}
		}
		
		return $id;
	}
	
	/**
	 * 画像アップロード（AJAX)
	 */
	public function image_uploadAction() {
		$result['result'] = 'false';

		$dir = UPLOAD_IMG_DIR;
		$new_file_name = $this->makeNewImageName($_FILES['file']['tmp_name']);

		if ($new_file_name === false) {
			$result['result'] = 'mime_error';
		} else if ($new_file_name !== false && move_uploaded_file($_FILES['file']['tmp_name'], $dir . $new_file_name)) {
			$result['result'] = 'result';
			$result['image_name'] = $new_file_name;
			$result['base_dir']   = UPLOAD_IMG_URL;
			
			$this->manager->db_manager->get('temp_image')->insert(array('dir_path'=>$dir, 'file_name'=>$new_file_name));
		}
		echo json_encode($result);
		exit();
	}

	/***
	 * アップロードする画像の新しい名前を設定
	 * JPG、GIF、PNG以外はfalseを返す
	 *
	 * @param string $file $_FILE[x][tmp_name]データ
	 * @return mixed
	 */
	protected function makeNewImageName($file) {
		//変なファイルあげられるとexif_imagetypeがエラー吐くので＠をつける。
		if (!(file_exists($file) && ($type=@exif_imagetype($file)))) return false;

		$base_name = md5(uniqid(rand(), true));

		//JPEGの場合
		if($type == IMAGETYPE_JPEG) {
			return $base_name . '.jpg';
		}

		switch ($type) {
		case IMAGETYPE_JPEG:
			return $base_name.'.jpg';
		case IMAGETYPE_GIF:
			return $base_name.'.gif';
		case IMAGETYPE_PNG:
			return $base_name.'.png';
		}
		return false;
	}
}

/**
 * ログインID重複チェック
 *
 */
function duplicate_id($key, $data) {
	if (!isset($data[$key]) || $data[$key] == '') {
		return true;
	}
	$login_id = $data[$key];
	$manager = Management::getInstance();
	$res = $manager->db_manager->get('store')->findByLoginId($login_id);
	// ＩＤが存在する場合
	if ($res) {
		// 自分自身だった場合
		if ($res['store_id'] == getParam($data, 'store_id')) {
			return true;
		}
		return false;
	}

	return true;
}

/**
 * 同一メールアドレスチェック
 *
 */
function same_email($key, $data) {
	$emails = explode(',', $data[$key]);
	if (count($emails) != 2) {
		return false;
	}
	if ($emails[0] === $emails[1]) {
		return true;
	}
	return false;
}

/**
 * 0以上の小数であるか確認する
 *
 */
function pdecimal_zero($key, $data) {
	if (!isset($data[$key]) || $data[$key] == '') {
		return true;
	}

	// 数値チェック
	if (!is_numeric($data[$key])) {
		return false;
	}

	// 0以上の小数チェック
	if (!preg_match("/^(([1-9]\d*|0)(\.\d+)|0)$/", $data[$key])) {
		return false;
	}

	return true;
}
