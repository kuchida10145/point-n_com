<?php
/**
 * ポイントコード
 * 
 */
include_once dirname(__FILE__) . '/../common/Page.php';

class Point_codePage extends Page {

	
	protected $view = array(
			'index' => 'mypage/point_code/index',
			'detail' => 'mypage/point_code/detail',
			'none' => 'mypage/point_code/none',
	);


	/**
	 * ポイントコード一覧
	 * 
	 */
	public function indexAction() {

		$user = $this->getAccount();

		//ログインしていないユーザーをリダイレクト
		if ( !( isset($user['user_id']) && !empty($user['user_id']) ) ) {
		
			redirect('/');
			return;
		}

		//コード一覧取得
		$point_codes = $this->manager->db_manager->get('reserved')->getMyPointCodeList($user['user_id']);
		
		//1件の場合は、詳細画面にリダイレクト
		if(count($point_codes) == 1){
			//redirect('/mypage/point_code/detail.php?id='.$point_codes[0]['reserved_id']);
		}
		
		
		$data['point_codes'] = escapeHtml($point_codes);
		$this->loadView('index', $data);
	}
	
	
	/**
	 * ポイントコード詳細
	 * 
	 */
	public function detailAction() {

		$user = $this->getAccount();

		//ログインしていないユーザーをリダイレクト
		if ( !( isset($user['user_id']) && !empty($user['user_id']) ) ) {
		
			redirect('/');
			return;
		}
		
		//予約ID
		$reserve_id = getGet('id');
		if(!is_numeric($reserve_id) || $reserve_id == 0){
			$this->errorPage();
			exit();
		}

		//コード1件取得
		if(!$point_code = $this->manager->db_manager->get('reserved')->getMyPointCode($user['user_id'],$reserve_id)){
			$this->loadView('none', array());
		}
		
		
		$point_code['reserved_date'] = date('Y年m月d日 H:i',strtotime($point_code['reserved_date']));
		$point_code['use_date']      = date('Y年m月d日',strtotime($point_code['use_date']));
		$point_code['use_time']      = date('H時i分',strtotime($point_code['use_date']));
		
		
		
		$data['point_code'] = escapeHtml($point_code);
		$data['point_code_array'] = str_split($point_code['point_code']);
		$this->loadView('detail', $data);
	}
}
