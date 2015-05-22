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
		
		$this->manager->validation->setRule('store_name',          'required');
		$this->manager->validation->setRule('type_of_industry_id', 'required');
		$this->manager->validation->setRule('account_name',        'required');
		$this->manager->validation->setRule('login_id',            'required|password:6:12|duplicate_id');
		if ($this->id == '') {
			$this->manager->validation->setRule('login_password',  'required|password:4:8');
		} else {
			$this->manager->validation->setRule('login_password',  'password:4:8');
		}
		
		return $this->manager->validation->run($param);
	}
	
	/**
	 * 新規登録処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param) {
		$param['new_arrival'] = isset($param['new_arrival']) ? $param['new_arrival'] : 0;
		// パスワード暗号化
		$param['login_password'] = encodePassword($param['login_password']);
		$param['regist_date']    = 'NOW()';
		$param['update_date']    = 'NOW()';
		return $this->manager->db_manager->get($this->use_table)->insert($param);
	}
	
	/**
	 * 更新処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_actoin($param){
		// パスワード暗号化
		if (getParam($param,'login_password') != '') {
			$param['login_password'] = encodePassword($param['login_password']);
		} else {
			unset($param['login_password']);
		}
		return $this->manager->db_manager->get($this->use_table)->updateById($this->id, $param);
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
