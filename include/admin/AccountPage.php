<?php
/**
 * 管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class AccountPage extends AdminPage{

	protected $id = 0;/* ID */
	protected $use_table   = 'account';
	protected $session_key = 'account';
	protected $use_confirm = true;
	protected $page_title = 'アカウント管理';





	/**
	 * ＤＢデータから入力用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data){
		//パスワードデコード
		$data['login_password'] = decodePassword($data['login_password']);
		return $data;
	}



	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){

		//更新の場合はＩＤを設定
		if($this->id != 0){
			$param['account_id'] = $this->id;
		}

		$this->manager->validation->setRule('account_name','required');
		$this->manager->validation->setRule('login_id','required|password:6:12|duplicate_id');

		if($this->id == ''){
			$this->manager->validation->setRule('login_password','required|password:4:8');
		}else{
			$this->manager->validation->setRule('login_password','password:4:8');
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
		$param['login_password'] = encodePassword($param['login_password']);
		return $this->manager->db_manager->get($this->use_table)->insert($param);

	}


	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_action($param){
		//パスワード暗号化
		if(getParam($param,'login_password') != ''){
			$param['login_password'] = encodePassword($param['login_password']);
		}
		else{
			unset($param['login_password']);
		}
		$bool = $this->manager->db_manager->get($this->use_table)->updateById($this->id,$param);
		$account = $this->getAccount();
		if($bool && $this->id == $account['account_id']){
			//パスワード自動保存している場合は、変更
			if($this->getIdPw()){
				$this->saveIdPw($param['login_id'],decodePassword($param['login_password']),1);
			}
		}
	}
}


/**
 * ログインID重複チェック
 *
 */
function duplicate_id($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	$login_id =$data[$key];
	$manager = Management::getInstance();
	//ＩＤが存在する場合
	if($res = $manager->db_manager->get('account')->findByLoginId($login_id)){

		//自分自身だった場合
		if($res['account_id'] == getParam($data,'account_id')){
			return true;
		}
		return false;
	}

	return true;
}