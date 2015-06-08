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

	/**
	 * ニックネームに該当するデータを1件取得する
	 *
	 * @param string $nickname ニックネーム
	 * @return array
	 */
	public function findByNickname($nickname){
		$nickname = $this->escape_string($nickname);
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE delete_flg = 0 AND nickname = '{$nickname}' LIMIT 0,1 ";
		if($res = $this->db->getData($sql)){
			return $res;
		}
		return NULL;
	}


	/**
	 * WHERE句生成（管理者用）
	 *
	 * @param array $get
	 * @return string
	 */
	protected function adminSearchWhere($get){

		$where 			= ' delete_flg = 0 ';
		$status_ids = '';
		$nickname 	= getParam( $get, 'nickname' );
		$from_date 	= getParam( $get, 'from-date' );
		$to_date		= getParam( $get, 'to-date' );

		//ステータスが設定されている場合
		$i = 0;
		foreach ( user_status_label() as $val_key => $val_name ) {

			$status_search = getParam( $get, $val_key );
			if ( 'true' == $status_search ) {
				if ( $i > 0 ) {
					$status_ids .= ',';
				}
				$status_ids .= $val_key;
				$i++;
			}
		}

		if ( $status_ids != '' ) {
			$where .= 'AND `status_id` IN(' . $status_ids . ') ';
			$and = true;
		}

		//ニックネームが設定されている場合
		if ( isset( $nickname ) && !empty( $nickname ) ) {
			$where .= 'AND `nickname` LIKE "%' . $this->escape_string( $nickname ) . '%" ';
			$and = true;
		}

		//日付が設定されている場合
		if ( isset( $from_date ) && !empty( $from_date ) && $this->validateDate( $from_date ) ) {
			$where .= 'AND `regist_date` >= "' . $from_date . '" ';
			$and = true;
		}

		if ( isset( $to_date ) && !empty( $to_date ) && $this->validateDate( $to_date ) ) {
			$where .= 'AND `regist_date` <= "' . $to_date . '" ';
			$and = true;
		}

		$where = 'WHERE' . $where;
		return $where;
	}

	/**
	 * 日付の指定フォーマットと存在を確認する
	 *
	 * @param string $date
	 * @return boolean
	 */
	private function validateDate($date)
	{
	    $d = DateTime::createFromFormat('Y-m-d', $date);
	    return $d && $d->format('Y-m-d') == $date;
	}
}