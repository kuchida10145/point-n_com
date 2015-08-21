<?php
/**
 * 今日のニュース、お知らせ共通情報管理
 *
 */

class NewsCommonPage {

	/** @var Management */
	protected $manager = null;

	/**
	 * コンストラクタ
	 *
	 * @param Management $manager Management クラスのインスタンス
	 */
	public function __construct() {
		$this->manager = Management::getInstance();
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
	 * @return array 変換後データ
	 */
	public function dbToInputData($data) {
		for ($i = 1; $i <= 3; $i++) {
			$data['cur_image' . $i] = $data['image' . $i];
		}
		return $data;
	}
	
	/**
	 * 新規登録処理
	 * 
	 * @param array $param 更新用パラメータ
	 * @param string $insert_table 挿入テーブル
	 * @return mixed
	 */
	public function insert_action($param, $insert_table) {
		$id = $this->manager->db_manager->get($insert_table)->insert($param);
		if ($id === false) {
			return false;
		}
		
		$use_state = 1;
		if (!empty($param['store_id'])) {
			$store_info = $this->manager->db_manager->get('store')->findById($param['store_id']);
			if ($store_info) {
				// ステータス(1：準備中、2：運営中、9：停止中)
				// ※ステータスが停止中はアップロードしたファイルを「2：使用不可」とする
				$use_state = ($store_info['status_id'] == 9) ? 2 : 1;
			}
		}
		
		// 画像1〜3
		for ($i = 1; $i <= 3; $i++) {
			if (getParam($param,'image' . $i) == '') {
				continue;
			}
			$update_param = array();
			$update_param['use_state'] = $use_state;
			$this->manager->db_manager->get('temp_image')->updateByFileName($param['image' . $i], $update_param);
		}
		
		// .htaccess ファイルを生成してアップロードファイルの使用可否制御
		set_cannot_use_file();
		
		return $id;
	}
	
	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @param string $primary_key プライマリーキー
	 * @param string $update_table 更新テーブル
	 * @return mixed
	 */
	public function update_action($param, $primary_key, $update_table) {
		$id = $this->manager->db_manager->get($update_table)->updateById($primary_key, $param);
		if ($id === false) {
			return false;
		}
		
		$use_state = 1;
		if (!empty($param['store_id'])) {
			$store_info = $this->manager->db_manager->get('store')->findById($param['store_id']);
			if ($store_info) {
				// ステータス(1：準備中、2：運営中、9：停止中)
				// ※ステータスが停止中はアップロードしたファイルを「2：使用不可」とする
				$use_state = ($store_info['status_id'] == 9) ? 2 : 1;
			}
		}
		
		// 画像1〜3
		$images = array();
		for ($i = 1; $i <= 3; $i++) {
			if (getParam($param,'image' . $i) == '') {
				continue;
			}
			$images[] = $param['image' . $i];
			$update_param = array();
			$update_param['use_state'] = $use_state;
			$this->manager->db_manager->get('temp_image')->updateByFileName($param['image' . $i], $update_param);
		}
		for ($i = 1; $i <= 3; $i++) {
			if ($param['cur_image' . $i] == '') {
				continue;
			}
			if (!in_array($param['cur_image' . $i], $images)) {
				delete_file($param['cur_image' . $i]);
			}
		}
		
		// .htaccess ファイルを生成してアップロードファイルの使用可否制御
		set_cannot_use_file();
		
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
