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
		$data['area_first_prefectures_id'] = $data['area_first_id'];
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
		// 新着店舗
		$param['new_arrival'] = isset($param['new_arrival']) ? $param['new_arrival'] : 0;
		// パスワード暗号化
		$param['login_password'] = encodePassword($param['login_password']);
		// TODO: 第1エリア(都道府県)
		// 郵便番号
		$param['zip_code'] = $param['zip_code1'] . $param['zip_code2'];
		unset($param['zip_code1']);
		unset($param['zip_code2']);
		// 電話番号
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		unset($param['telephone1']);
		unset($param['telephone2']);
		unset($param['telephone3']);
		
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
		// 新着店舗
		$param['new_arrival'] = isset($param['new_arrival']) ? $param['new_arrival'] : 0;
		// パスワード暗号化
		if (getParam($param,'login_password') != '') {
			$param['login_password'] = encodePassword($param['login_password']);
		} else {
			unset($param['login_password']);
		}
		// TODO: 第1エリア(都道府県)
		// 郵便番号
		$param['zip_code'] = $param['zip_code1'] . $param['zip_code2'];
		// 電話番号
		$param['telephone'] = $param['telephone1'] . "-" . $param['telephone2'] . "-" . $param['telephone3'];
		return $this->manager->db_manager->get($this->use_table)->updateById($this->id, $param);
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
