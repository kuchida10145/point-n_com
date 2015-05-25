<?php
/**
 * 一時画像
 */
class Temp_imageDbModel extends DbModel{



	
	public function getField(){
		return array(
			'temp_image_id',
			'use_state',
			'dir_path',
			'file_name',
			'regist_date',
			'update_date',
			'delete_flg'

		);
	}



}