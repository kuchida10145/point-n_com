<?php
/**
 * 会員ＤＢモデル
 */
class UserDbModel extends DbModel{



	public function getField(){
		return array(
			'user_id',
			'nickname',
			'email',
			'birthday',
			'gender',
			'prefectures_id',
			'password',
			'point',
			'status_id',
			'latest_login_date',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
	
	
	
	/**
	 * メールアドレスとパスワードに該当するデータを1件取得する
	 * 
	 * @param string $email メールアドレス
	 * @param string $login_pw パスワード
	 * @return array
	 */
	public function login($email,$login_pw){
		$email = $this->escape_string($email);
		$login_pw = encodePassword($this->escape_string($login_pw));
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE delete_flg = 0 AND email = '{$email}' AND password = '{$login_pw}' LIMIT 0,1 ";
		if($res = $this->db->getData($sql)){
			$this->updateById($res['user_id'],array('latest_login_date'=>date('Y-m-d H:i:s')));
			return $res;
		}
		return NULL;
	}



}