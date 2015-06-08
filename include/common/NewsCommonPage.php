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
