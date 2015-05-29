<?php
/**
 * 自動ログイン管理(店舗用)
 */
class Autologin_storeDbModel extends DbModel{


	public function getField(){
		return array(
			'autologin_store_id',
			'store_id',
			'login_key',
			'limit_date',
			'delete_flg'
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
			$param['autologin_store_id'] =$id;
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
		$sql = "SELECT {$field} FROM {$this->table} WHERE autologin_store_id = '{$id}' AND login_key = '{$login_key}' AND limit_date > '{$limit_date}' LIMIT 0,1";
		return $this->db->getData($sql);
	}
	
	/**
	 * データ削除
	 * 
	 * @param int $id 店舗ID
	 * @return arrray or bool
	 */
	public function deleteAutoLogin($id){
		return $this->delete(" store_id = '{$id}' LIMIT 1 ");
	}
}
