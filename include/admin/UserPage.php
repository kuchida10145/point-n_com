<?php
/**
 * 店舗情報管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class UserPage extends AdminPage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'user';
	protected $session_key = 'user';
	protected $use_confirm = true;
	protected $page_title = 'ユーザー管理';


	/**
	 * ＤＢデータから入力用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data){
		//パスワードデコード
		$data['password'] = decodePassword($data['password']);
		return $data;
	}

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){

		//更新の場合はＩＤを設定
		if($this->id != 0){
			$param['user_id'] = $this->id;
		}

		$this->manager->validation->setRule('email','required|email|duplicate_user_email');
		$this->manager->validation->setRule('nickname','required|duplicate_user_nickname');
		$this->manager->validation->setRule('birthday','required');
		$this->manager->validation->setRule('gender','required');
		$this->manager->validation->setRule('prefectures_id','required');
		$this->manager->validation->setRule('status_id','required');

		if($this->id == ''){
			$this->manager->validation->setRule('password','required|password:4:8');
		}else{
			$this->manager->validation->setRule('password','password:4:8');
		}
		return $this->manager->validation->run($param);
	}



	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		//パスワード暗号化
		$param['password'] = encodePassword($param['password']);
		return $this->manager->db_manager->get($this->use_table)->insert($param);

	}


	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_actoin($param){
		//パスワード暗号化
		if(getParam($param,'password') != ''){
			$param['password'] = encodePassword($param['password']);
		}
		else{
			unset($param['password']);
		}
		return $this->manager->db_manager->get($this->use_table)->updateById($this->id,$param);
	}

		/**
	 * 入力画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getEditCommon($data = array()){
		
		if($this->id != 0){
			$res = $this->manager->db_manager->get($this->use_table)->findById($this->id);
			if( $res ) {
				$data['regist_date'] = $res['regist_date'];
				$data['user_id'] = $res['user_id'];
			}
		}
		return $data;
	}

	/**
	 * 確認画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getConfirmCommon($data = array()){

		if($this->id != 0){
			$res = $this->manager->db_manager->get($this->use_table)->findById($this->id);
			if( $res ) {
				$data['regist_date'] = $res['regist_date'];
				$data['user_id'] = $res['user_id'];
			}
		}
		return $data;
	}

}

/**
 * メール重複チェック
 *
 */
function duplicate_user_email($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	$email =$data[$key];
	$manager = Management::getInstance();
	//メールが存在する場合
	if($res = $manager->db_manager->get('user')->findByEmail($email)){

		//自分自身だった場合
		if($res['user_id'] == getParam($data,'user_id')){
			return true;
		}
		return false;
	}

	return true;
}

/**
 * ユーザーニックネーム重複チェック
 *
 */
function duplicate_user_nickname( $key, $data ) {
	
	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	$nickname =$data[$key];
	$manager = Management::getInstance();
	//ニックネームが存在する場合
	if($res = $manager->db_manager->get('user')->findByNickname($nickname)){

		//自分自身だった場合
		if($res['user_id'] == getParam($data,'user_id')){
			return true;
		}
		return false;
	}
	return true;
}