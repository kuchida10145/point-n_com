<?php
/**
 * 管理者ＤＢモデル
 */
class AccountDbModel extends DbModel{



	public function getField(){
		return array(
			'account_id',
			'account_name',
			'login_id',
			'login_password',
			'permission_kind',
			'status_id',
			'regist_date',
			'update_date',
			'latest_login_date',
			'delete_flg'
		);
	}



	/**
	 * ログインIDに該当するデータを取得する
	 *
	 * @param string $login_id
	 * @return array
	 */
	public function findByLoginId($login_id){
		$field = $this->getFieldText();
		$login_id = $this->escape_string($login_id);
		$sql = "SELECT {$field} FROM {$this->table} WHERE login_id = '{$login_id}' LIMIT 0,1";
		return $this->db->getData($sql);
	}



	/**
	 * ＩＤとパスワードが一致するデータを1件取得
	 * 
	 * @param string $login_id ログインID
	 * @param string $login_pw ログインパスワード
	 * @return array
	 */
	public function login($login_id,$login_pw){
		$login_pw = encodePassword($login_pw);

		$login_id = $this->escape_string($login_id);

		$field = $this->getFieldText();

		$sql = "SELECT {$field} FROM {$this->table} WHERE login_id = '{$login_id}' AND login_password = '{$login_pw}'  AND delete_flg = 0";


		return $this->db->getData($sql);


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
	protected function adminSearchWhere($get){
		
		$wheres = array();
		$wheres[] = " delete_flg = 0 ";
		
		
		//名前が設定されている場合
		if(getParam($get,'account_name') != '' && getParam($get,'account_name')){
			$name = $this->escape_string(getParam($get,'account_name'));
			$wheres[] = " account_name LIKE '%{$name}%' ";
		}
		
		$where = " WHERE ".implode(' AND ',$wheres);
		
		return $where;
	}


}