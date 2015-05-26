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


	/**
	 * メールアドレスに該当するデータを1件取得する
	 * 
	 * @param string $email メールアドレス
	 * @return array
	 */
	public function findByEmail($email){
		$email = $this->escape_string($email);
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE delete_flg = 0 AND email = '{$email}' LIMIT 0,1 ";
		if($res = $this->db->getData($sql)){
			return $res;
		}
		return NULL;
	}

	/*==========================================================================================
	 * 管理者用共通処理
	 *
	 *==========================================================================================*/
	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	/*
	protected function adminSearchWhere($get){
		
//var_dump($get);

		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		
		//ステータスが設定されている場合
		foreach ( user_status_label() as $val_key => $val_name ) {
			
			//var_dump(getParam( $get, $val_name ) );
			//if ( getParam( $get, $val_name ) )
		}
		if(getParam($get,'account_name') != '' && getParam($get,'account_name')){
			$name = $this->escape_string(getParam($get,'account_name'));
			$wheres[] = " account_name LIKE '%{$name}%' ";
		}

		//名前が設定されている場合
		if(getParam($get,'account_name') != '' && getParam($get,'account_name')){
			$name = $this->escape_string(getParam($get,'account_name'));
			$wheres[] = " account_name LIKE '%{$name}%' ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		
		return $where;
	}*/
}