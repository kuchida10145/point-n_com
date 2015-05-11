<?php
/**
 * お知らせ情報
 */
class TeacherDbModel extends DbModel{


	public function getField(){
		return array(
			'notice_id',
			'store_id',
			'public',
			'public_start_date',
			'public_end_date',
			'display_date',
			'title',
			'image1',
			'image2',
			'image3',
			'body',
			'regist_date',
			'update_date',
			'delete_flg'
		);
	}
}