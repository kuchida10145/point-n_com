<?php
/**
 * 店舗情報管理
 *
 */
include_once dirname(__FILE__) . '/../common/AdminPage.php';
include_once(dirname(__FILE__) . '/../common/StoreCommonPage.php');

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
			$param['store_id'] = $this->id;
			$isUpdate = true;
		}

		$store_common = new StoreCommonPage($this->manager);
		return $store_common->validation($param, $isUpdate, true);
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
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param) {
		// DB用データに変換
		$param = $this->inputToDbData($param);

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
		
		// 店ID
		$update_param = array();
		$update_param['store_hex_id']  = sprintf("%04X", $id);
		$this->manager->db_manager->get($this->use_table)->updateById($id, $update_param);
		
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
	protected function inputToDbData($data){
		return $data;
	}

	/**
	 * 画像アップロード（AJAX)
	 */
	protected function image_uploadAction(){
		$store_common = new StoreCommonPage($this->manager);
		$store_common->image_uploadAction();
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
