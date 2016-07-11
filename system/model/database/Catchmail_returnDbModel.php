<?php
/**
 * キャッチメール返信情報
 */
class Catchmail_returnDbModel extends DbModel{

	public function getField(){
		return array(
			'catchmail_return_id',
			'catchmail_id',
			'store_id',
			'money',
			'appeal',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}

	/**
	 * 会員宛のキャッチメール返信データを取得
	 * @param int $catchmail_id キャッチメールID
	 * @return array
	 */
	public function getReplyData($catchmail_id){

		$sql = "SELECT
				catchmail_return.catchmail_return_id,
				catchmail_return.catchmail_id,
				catchmail_return.money,
				catchmail_return.appeal,
				catchmail_return.regist_date mail_regist_date,
				store.*
				FROM store,catchmail_return WHERE ";
		$sql.= " catchmail_return.store_id = store.store_id AND ";
		$sql.= " catchmail_return.catchmail_id = '{$catchmail_id}' AND ";
		$sql.= " catchmail_return.delete_flg = 0 ";
		$sql.= " ORDER BY catchmail_return.regist_date Desc";

		return $this->db->getAllData($sql);
	}

	/**
	 * キャッチメール返信データ数を取得
	 * @param int $catchmail_id キャッチメールID
	 * @return array
	 */
	public function getReplyDataCount($catchmail_id){

		$sql = "SELECT
				count(catchmail_id) count
				FROM catchmail_return WHERE ";
		$sql.= " catchmail_return.catchmail_id = '{$catchmail_id}' AND ";
		$sql.= " catchmail_return.delete_flg = 0 ";
		$sql.= " ORDER BY catchmail_return.regist_date Desc";

		return $this->db->getData($sql);
	}

	/**
	 * 店舗決定確認画面用データを取得
	 * @param int $catchmail_reply_id キャッチメール返信ID
	 * @return array
	 */
	public function getReplyConfirmData($catchmail_reply_id){

		$sql = "SELECT
				catchmail_return.catchmail_return_id,
				catchmail_return.catchmail_id,
				catchmail_return.money,
				catchmail_return.appeal,
				catchmail_return.regist_date mail_regist_date,
				store.store_id,
				store.store_name,
				store.address1,
				store.address2,
				store.telephone,
				catchmail.reserved_date,
				catchmail.use_persons,
				catchmail.category_large_id,
				catchmail.category_midium_id,
				catchmail.area_first_prefectures_id
				FROM store,catchmail_return,catchmail WHERE ";
		$sql.= " catchmail_return.store_id = store.store_id AND ";
		$sql.= " catchmail_return.catchmail_id = catchmail.catchmail_id AND ";
		$sql.= " catchmail_return.catchmail_return_id = '{$catchmail_reply_id}' AND ";
		$sql.= " catchmail_return.delete_flg = 0 ";
		$sql.= " ORDER BY catchmail_return.regist_date Desc";

		return $this->db->getData($sql);
	}
}