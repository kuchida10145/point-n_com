<?php
/**
 * 店舗情報
 */
class StoreDbModel extends DbModel{


	
	public function getField(){
		return array(
			'store_id',
			'status_id',
			'store_name',
			'new_arrival',
			'type_of_industry_id',
			'license',
			'account_name',
			'login_id',
			'login_password',
			'category_large_id',
			'category_midium_id',
			'category_small_id',
			'area_first_id',
			'area_second_id',
			'area_third_id',
			'image1',
			'image2',
			'image3',
			'image4',
			'image5',
			'image6',
			'image7',
			'image8',
			'image9',
			'introduction',
			'latitude',
			'longitude',
			'zip_code',
			'prefectures_id',
			'address1',
			'address2',
			'business_hours',
			'telephone',
			'holiday',
			'url_outside1',
			'url_outside2',
			'url_official1',
			'url_official2',
			'url_official3',
			'representative_sei',
			'representative_mei',
			'representative_email',
			'reserved_email',
			'regist_date',
			'update_date',
			'latest_login_date',
			'delete_flg'


		);
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

		$sql = "SELECT {$field} FROM {$this->table} WHERE login_id = '{$login_id}' AND login_password = '{$login_pw}' AND delete_flg = 0";


		return $this->db->getData($sql);


	}
}