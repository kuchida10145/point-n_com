<?php
/**
 * ニュース情報
 */
class NewsDbModel extends DbModel{

	
	public function getField(){
		return array(
			'news_id',
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