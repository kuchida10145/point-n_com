<?php
/**
 * 自動ログイン管理(管理用)
 */
class Autologin_accountDbModel extends DbModel{


	public function getField(){
		return array(
			'autologin_account_id',
			'login_key',
			'account_id',
			'limit_date',
			'delete_flg',
		);
	}
	
	
	
	/**
	 * データ挿入
	 * 
	 * @param array $param パラメータ
	 * @return arrray or bool
	 */
	public function insert($param){
		$param['limit_date'] = date('Y-m-d H:i:s',strtotime('+ 30day'));
		$param['login_key']  = md5(uniqid(rand(), true));
		$param['delete_flg'] = 0;
		if($id = parent::insert($param)){
			$param['autologin_account_id'] =$id;
			return $param;
		}
		return false;
	}
	
	
	/**
	 * データ更新
	 * 
	 * @param int $id 主キー	
	 * @param array $param パラメータ
	 * @return arrray or bool
	 */
	public function updateById($id,$param){
		$param['limit_date'] = date('Y-m-d H:i:s',strtotime('+ 30day'));
		$param['login_key']  = md5(uniqid(rand(), true));
		$param['delete_flg'] = 0;
		if(parent::updateById($id,$param)){
			return $this->findById($id);
		}
		return false;
	}
	
	
	/**
	 * IDとチェックコードに該当する有効期限内のデータを取得
	 * @param int $id 主キー	
	 * @param string $login_key チェックコード
	 */
	public function chek_data($id,$login_key){
		$limit_date = date('Y-m-d H:i:s');
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE autologin_account_id = '{$id}' AND login_key = '{$login_key}' AND limit_date > '{$limit_date}' LIMIT 0,1";
		return $this->db->getData($sql);
	}
	
	
	/**
	 * データ削除
	 * 
	 * @param int $id 管理者ID
	 * @return arrray or bool
	 */
	public function deleteAutoLogin($id){
		return $this->delete(" account_id = '{$id}' LIMIT 1 ");
	}
}
