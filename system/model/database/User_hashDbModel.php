<?php
/**
 * 会員ハッシュＤＢモデル
 */
class User_hashDbModel extends DbModel{




	public function getField(){
		return array(
			'user_hash_id',
			'hash',
			'hash_type',
			'user_id',
			'limit_date',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}


	/**
	 * ハッシュに該当するデータを取得する
	 * @param string $hash ハッシュ
	 * @return array
	 */
	public function findByHash($hash){
		$hash =	$this->escape_string($hash);
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE hash = '{$hash}' LIMIT 0,1" ;
		return $this->db->getData($sql);
	}


	/**
	 * 有効なハッシュに該当するデータを取得する
	 * @param string $hash ハッシュ
	 * @return array
	 */
	public function findByActiveHash($hash){
		$hash =	$this->escape_string($hash);
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE hash = '{$hash}' AND delete_flg = 0 LIMIT 0,1" ;
		return $this->db->getData($sql);
	}


	/**
	 * 会員IDに該当する会員登録用ハッシュデータを取得する
	 *
	 * @param int $user_id
	 * @return array
	 */
	public function getSignupByUserId($user_id){
		$field = $this->getFieldText();
		$sql = "SELECT {$field} FROM {$this->table} WHERE user_id = '{$user_id}' AND hash_type = 1 ";
		return $this->db->getData($sql);
	}

	/**
	 * 会員IDに該当すハッシュデータを取得する
	 *
	 * @param int $userId, int $hashType
	 * @return array
	 */
	public function getHashByUserIdAndHashType( $userId, $hashType ) {

		$field = $this->getFieldText();
		$sql 	 = "SELECT {$field} FROM {$this->table} WHERE user_id = '{$userId}' AND hash_type = {$hashType} AND delete_flg = 0 ";
		return $this->db->getData($sql);
	}


	/**
	 * 会員登録用ハッシュ作成
	 *
	 * @param int $user_id 会員ＩＤ
	 * @return array
	 */
	public function createSingup($user_id){

		if($hash = $this->getSignupByUserId($user_id)){
			$this->deleteById($hash['id']);
		}

		date_default_timezone_set('Asia/Tokyo');

		$param = array(
			'user_id'=>$user_id,
			'hash' =>md5(uniqid(rand(), true)),
			'hash_type'=>1,
			'limit_date'=>date('Y-m-d H:i:s',strtotime('+24hour'))
		);

		$id = $this->insert($param );

		return  $this->findById($id);
	}


	/**
	 * パスワードリマインダー用ハッシュ作成
	 *
	 * @param int $user_id 会員ＩＤ
	 * @return array
	 */
	public function reminderHash($user_id){

		//ハッシュがすでに存在すれば削除する（２＝パスワードリマインダー用のハッシュタイプ）
		if( $hash = $this->getHashByUserIdAndHashType($user_id, 2) ){
			$this->deleteById( $hash['user_hash_id'] );
		}

		//新しいハッシュをDBに保存する
		$param = array(
			'user_id'		=> $user_id,
			'hash' 			=> md5( uniqid(rand(), true) ),
			'hash_type'	=> 2,
			'limit_date'=> date( 'Y-m-d H:i:s', strtotime('+2hour') ),
		);

		$id = $this->insert($param);

		return $this->findById($id);
	}	



	
	/**
	 * 会員ＩＤに該当する会員登録用ハッシュを削除する
	 * 
	 * @param int $user_id
	 * @return bool
	 */
	public function deleteSignup($user_id){
		$sql = "DELETE FROM {$this->table} WHERE user_id = '{$user_id}' AND hash_type = 1 LIMIT 2";
		return  $this->db->query($sql);
	}

}