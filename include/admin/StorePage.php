<?php
/**
 * 店舗情報管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class StorePage extends AdminPage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'store';
	protected $session_key = 'store';
	protected $use_confirm = true;
	protected $page_title = '店舗情報管理';
	
	/**
	 * ＤＢデータから入力用データへ変換
	 * 
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data) {
		// パスワードデコード
		$data['login_password'] = decodePassword($data['login_password']);
		// 第1エリア(都道府県)
		$data['area_first_prefectures_id'] = "";
		$area_first_data = $this->manager->db_manager->get('area_first')->findById($data['area_first_id']);
		if ($area_first_data != null) {
			if ($area_first_data['prefectures_id'] > 0) {
				$prefectures_id = $area_first_data['prefectures_id'];
			} else {
				$wheres = array();
				$wheres[] = "prefectures_name = '" . $area_first_data['area_first_name'] . "'";
				$records = $this->manager->db_manager->get('prefectures_master')->adminSearch($wheres, "", " ORDER BY prefectures_id ASC ");
				$prefectures_id = isset($records[0]['prefectures_id']) ? $records[0]['prefectures_id'] : "";
			}
			$data['area_first_prefectures_id'] = $prefectures_id;
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
		$where  = ' store_id = ' . $this->id . ' ';
		$where .= ' AND delete_flg = 0 ';
		$order = 'bank_account_id ASC';
		$bank_data = $this->manager->db_manager->get('bank_account')->search($where, '', $order);
		$bank_data = ($bank_data != null) ? $bank_data : array();
		for ($i = 1; $i <= 3; $i++) {
			if (!isset($bank_data[$i-1]['bank_account_id'])) {
				continue;
			}
			$data['bank_name' . $i] = $bank_data[$i-1]['bank_name'];
			$data['bank_kind' . $i] = $bank_data[$i-1]['bank_kind'];
			$data['bank_account_number' . $i] = $bank_data[$i-1]['bank_account_number'];
			$data['bank_account_holder' . $i] = $bank_data[$i-1]['bank_account_holder'];
		}
		// ゆうちょ銀行
		$where  = ' store_id = ' . $this->id . ' ';
		$where .= ' AND delete_flg = 0 ';
		$order = 'bank_account_id ASC';
		$bank_data = $this->manager->db_manager->get('jpbank_account')->search($where, '', $order);
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
	 * 入力チェック
	 * 
	 */
	protected function validation($param) {
		// 更新の場合はＩＤを設定
		if ($this->id != 0) {
			$param['store_id'] = $this->id;
		}
		
		// 店舗名
		$this->manager->validation->setRule('store_name',          'required|maxlength:50');
		// 業種
		$this->manager->validation->setRule('type_of_industry_id', 'required');
		// 許可証の表示
		$this->manager->validation->setRule('license',             'required');
		// ユーザー名
		$this->manager->validation->setRule('account_name',        'required|maxlength:50');
		// ログインID
		$this->manager->validation->setRule('login_id',            'required|password:6:12|duplicate_id');
		// パスワード
		if ($this->id == '') {
			$this->manager->validation->setRule('login_password',  'required|password:4:8');
		} else {
			$this->manager->validation->setRule('login_password',  'password:4:8');
		}
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
		// TODO: 緯度(latitude)
// 		$this->manager->validation->setRule('latitude',                  'required');
		// TODO: 経度(longitude)
// 		$this->manager->validation->setRule('longitude',                 'required');
		// 営業時間
		$this->manager->validation->setRule('business_hours',            'required');
		// 電話番号
		$this->manager->validation->setRule('telephone1',                'required|numeric');
		$this->manager->validation->setRule('telephone2',                'required|numeric');
		$this->manager->validation->setRule('telephone3',                'required|numeric');
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		$this->manager->validation->setRule('telephone',                 'tel');
		// TODO: 休日(holiday)
// 		$this->manager->validation->setRule('holiday',                   'required|maxlength:50');
		// TODO: 公式サイト1(url_official1)
// 		$this->manager->validation->setRule('url_official1',             'url|maxlength:256');
		// TODO: 公式サイト2(url_official2)
// 		$this->manager->validation->setRule('url_official2',             'url|maxlength:256');
		// TODO: 公式サイト3(url_official3)
// 		$this->manager->validation->setRule('url_official3',             'url|maxlength:256');
		// TODO: 公式サイト4(url_official4)
// 		$this->manager->validation->setRule('url_official4',             'url|maxlength:256');
		// TODO: 外部サイト1(url_outside1)
// 		$this->manager->validation->setRule('url_outside1',              'url|maxlength:256');
		// TODO: 外部サイト2(url_outside2)
// 		$this->manager->validation->setRule('url_outside2',              'url|maxlength:256');
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
			if ($i == 1 || ($param['bank_name'.$i] != "" || $param['bank_kind'.$i] != "" || $param['bank_account_number'.$i] != "" || $param['bank_account_holder'.$i] != "")) {
				// 銀行名
				$this->manager->validation->setRule('bank_name'.$i,           'required|maxlength:50');
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
			$this->manager->validation->setRule('bank_account_holder', 'required|maxlength:50');
		}
		
		return $this->manager->validation->run($param);
	}
	
	/**
	 * 第1エリアマスターの第1エリアIDを導出する
	 * 
	 * @param array $param パラメータ
	 * @return number
	 */
	protected function derive_area_first_id($param) {
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
			$wheres = array();
			$wheres[] = 'category_large_id = ' . $category_large_id;
			$wheres[] = 'region_id = ' . $region_id;
//			$wheres[] = "delivery = '" . $is_delivery . "'";
			$wheres[] = "(prefectures_id = " . $prefectures_id . " OR area_first_name = '" . $prefectures_name . "')";
			$records = $this->manager->db_manager->get('area_first')->adminSearch($wheres, "", " ORDER BY area_first_id ASC ");
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
	 * 新規登録処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param) {
		// 新着店舗
		$param['new_arrival'] = isset($param['new_arrival']) ? $param['new_arrival'] : 0;
		// パスワード暗号化
		$param['login_password'] = encodePassword($param['login_password']);
		// 第1エリア(都道府県)
		$param['area_first_id'] = $this->derive_area_first_id($param);
		// 郵便番号
		$param['zip_code'] = $param['zip_code1'] . $param['zip_code2'];
		unset($param['zip_code1']);
		unset($param['zip_code2']);
		// 電話番号
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		unset($param['telephone1']);
		unset($param['telephone2']);
		unset($param['telephone3']);
		
		$id = $this->manager->db_manager->get($this->use_table)->insert($param);
		if ($id === false) {
			return false;
		}
		
		// 銀行
		for ($i = 1; $i <= 3; $i++) {
			if ($param['bank_account_holder' . $i] == "") {
				continue;
			}
			$bank_param = array();
			$bank_param['store_id'] = $id;
			$bank_param['bank_name'] = $param['bank_name' . $i];
			$bank_param['bank_kind'] = $param['bank_kind' . $i];
			$bank_param['bank_account_number'] = $param['bank_account_number' . $i];
			$bank_param['bank_account_holder'] = $param['bank_account_holder' . $i];
			$this->manager->db_manager->get('bank_account')->insert($bank_param);
		}
		
		// ゆうちょ銀行
		if ($param['jpbank_account_holder'] != "") {
			$jpbank_param = array();
			$jpbank_param['store_id'] = $id;
			$jpbank_param['jpbank_symbol1'] = $param['jpbank_symbol1'];
			$jpbank_param['jpbank_symbol2'] = $param['jpbank_symbol2'];
			$jpbank_param['jpbank_account_number'] = $param['jpbank_account_number'];
			$jpbank_param['jpbank_account_holder'] = $param['jpbank_account_holder'];
			$this->manager->db_manager->get('jpbank_account')->insert($jpbank_param);
		}
		
		return $id;
	}
	
	/**
	 * 更新処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_actoin($param){
		// 新着店舗
		$param['new_arrival'] = isset($param['new_arrival']) ? $param['new_arrival'] : 0;
		// パスワード暗号化
		if (getParam($param,'login_password') != '') {
			$param['login_password'] = encodePassword($param['login_password']);
		} else {
			unset($param['login_password']);
		}
		// 第1エリア(都道府県)
		$param['area_first_id'] = $this->derive_area_first_id($param);
		// 郵便番号
		$param['zip_code'] = $param['zip_code1'] . $param['zip_code2'];
		// 電話番号
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		$id = $this->manager->db_manager->get($this->use_table)->updateById($this->id, $param);
		if ($id === false) {
			return false;
		}
		
		// 銀行
		$where  = ' store_id = ' . $this->id . ' ';
		$where .= ' AND delete_flg = 0 ';
		$order = 'bank_account_id ASC';
		$bank_data = $this->manager->db_manager->get('bank_account')->search($where, '', $order);
		for ($i = 1; $i <= 3; $i++) {
			$bank_param = array();
			if ($param['bank_account_holder' . $i] == "") {
				if (isset($bank_data[$i-1]['bank_account_id'])) {
					$bank_param['delete_flg'] = 1;
					$this->manager->db_manager->get('bank_account')->updateById($bank_data[$i-1]['bank_account_id'], $bank_param);
				}
				continue;
			}
			$bank_param['store_id'] = $id;
			$bank_param['bank_name'] = $param['bank_name' . $i];
			$bank_param['bank_kind'] = $param['bank_kind' . $i];
			$bank_param['bank_account_number'] = $param['bank_account_number' . $i];
			$bank_param['bank_account_holder'] = $param['bank_account_holder' . $i];
			if (isset($bank_data[$i-1]['bank_account_id'])) {
				$this->manager->db_manager->get('bank_account')->updateById($bank_data[$i-1]['bank_account_id'], $bank_param);
			} else {
				$this->manager->db_manager->get('bank_account')->insert($bank_param);
			}
		}
		
		// ゆうちょ銀行
		$where  = ' store_id = ' . $this->id . ' ';
		$where .= ' AND delete_flg = 0 ';
		$order = 'bank_account_id ASC';
		$bank_data = $this->manager->db_manager->get('jpbank_account')->search($where, '', $order);
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
	protected function image_uploadAction(){
		$result['result'] = 'false';

		$dir = UPLOAD_IMG_DIR;
		$new_file_name =$this->makeNewImageName($_FILES['file']['tmp_name']);

		if($new_file_name === false){
			$result['result'] = 'mime_error';
		}
		else if($new_file_name !== false && move_uploaded_file($_FILES['file']['tmp_name'], $dir.$new_file_name)){
			$result['result'] = 'result';
			$result['image_name'] = $new_file_name;
			$result['base_dir']   = UPLOAD_IMG_URL;
			
			$this->manager->db_manager->get('temp_image')->insert(array('file_name'=>$new_file_name));
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
	protected function makeNewImageName($file){
		//変なファイルあげられるとexif_imagetypeがエラー吐くので＠をつける。
		if (!(file_exists($file) && ($type=@exif_imagetype($file)))) return false;

		$base_name =md5(uniqid(rand(), true));

		//JPEGの場合
		if($type == IMAGETYPE_JPEG)
		{
			return $base_name.'.jpg';
		}

		switch($type){
			case IMAGETYPE_JPEG:
				return $base_name.'.jpg';
			case IMAGETYPE_GIF:
				return $base_name.'.gif';
			case IMAGETYPE_PNG:
				return $base_name.'.png';
		}
		return false;
	}
	
	/**
	 * 上位項目選択時のリスト取得（AJAX）
	 * - 業種
	 * - 第1エリア(都道府県)
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
			$is_delivery = ($type_of_industry_id != "") ? is_delivery($type_of_industry_id) : "";
			// 中カテゴリー
			$result['category_midium'] = category_midium($category_large_id, $prefectures_id, $is_delivery);
			if (count($result['category_midium']) == 1 && isset($result['category_midium'][0])) {
				// 小カテゴリー
				$result['category_small'] = array(0=>non_select_item());
			}
			// 第２エリア
			$result['area_second'] = area_second_to_extend($category_large_id, $prefectures_id, $is_delivery);
			if (count($result['area_second']) == 1 && isset($result['area_second'][0])) {
				// 第３エリア
				$result['area_third'] = array(0=>non_select_item());
			}
		}
		
		echo json_encode($result);
		exit();
	}
	
	/**
	 * 中カテゴリー選択時のリスト取得（AJAX)
	 */
	protected function change_category_midiumAction(){
		$result['result'] = 'result';
		
		// 小カテゴリー
		$result['category_small'] = category_small($_POST['selected']);
		
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
