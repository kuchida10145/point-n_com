<?php
/**
 * 店舗詳細
 *
 */
include_once dirname(__FILE__).'/../common/Page.php';

class Store_detailPage extends Page{

	protected $id = 0;/* ID */
	protected $use_table   = 'store';
	protected $session_key = 'Storedeatail';
	protected $use_confirm = true;
	protected $page_title = '店舗詳細';
	protected $page_cnt = 20;//一ページに表示するデータ数
	protected $account = NULL;
	protected $order = ' ';
	protected $page_type_text = '';

	protected $view = array(
			'index'    =>'stores/detail',
	);

	/**
	 * 店舗詳細データ
	 *
	 */
	public function indexAction(){
		$account = $this->getAccount();
		$user_id = getParam($account,'user_id');
		$pager_html = '';
		$get        = $_GET;
		$store_id = getParam($get,'id');

		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		$dbFlg = true;
		$image		= array();
		$image_count = 1;

		//お気に入りボタン対応
		if(isset($get['favorite']) && $get['favorite'] != ''){
			if($get['favorite'] == 0) {
				if(!$this->inseart_favorite_action($user_id,$store_id)){
					redirect('detail.php?id='.$store_id);
				}
			} elseif($get['favorite'] == 1) {
				if(!$this->update_favorite_actoin($get,$user_id,$store_id)){
					redirect('detail.php?id='.$store_id);
				}
			}
		}

		$list    = $this->manager->db_manager->get($this->use_table)->findStoreDetailById($store_id);

		if(!$list) {
			$this->errorAction();
		}

		//クーポンデータ取得
		$coupon = $this->manager->db_manager->get('coupon')->storeCouponDetailSearch($store_id);
		//お知らせ取得(1件のみ)
		$notice = $this->manager->db_manager->get('notice')->getNoticeList($store_id, 0, 1);
		//お気に入り
		$favorite = $this->manager->db_manager->get('user_favorite_store')->getFavoriteFlg($user_id, $store_id);

		//各データを出力用のデータに変換
		$data['store_introduction']	= $list['introduction'];	// HTMLエスケープ前に紹介文は退避
		$data['coupon_esc']	= $coupon;							// HTMLエスケープ前にクーポン情報を退避
		$list = $this->dbToListData($list);
		if($coupon != NULL) {
			$coupon = $this->dbToListData($coupon);
		}

		if($notice != NULL) {
			$notice = $this->dbToListData($notice);
		}

		$data['debug_account']	= $account;
		$data['store']          = $list;
		//写真データ
		foreach ($data['store'] as $id=>$value) {
			if($id == "image".$image_count) {
				if(!empty($value)) {
					$image[] = $value;
				}
				$image_count++;
			}
		}
		$image = $this->dbToListData($image);
		$data['image']    		= $image;
		$data['coupon']         = $coupon;
		$data['notice']         = $notice['0'];
		$data['favorite']       = $favorite;
		$data['pager_html']     = $pager_html;
		$data['page_title']     = $this->page_title;

		$data['page_type_text'] =$this->page_type_text;
		$data['system_message'] = $system_message;

		$this->loadView('index', $data);
	}

	/**
	 * ＤＢデータから一覧用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToListData($data){
		foreach($data as $key => $val){
			//HTMLエスケープも実行
			$data[$key] = escapeHtml($val);
		}
		return $data;
	}

	/**
	 * お気に入り更新処理
	 *
	 * @param array $get 更新用パラメータ
	 * @param int $user_id ユーザID
	 * @param int $store_id 店舗ID
	 * @return mixed
	 */
	protected function update_favorite_actoin($get,$user_id,$store_id){
		$param = array(
			'delete_flg'=>$get['favorite'],
		);
		return $this->manager->db_manager->get('user_favorite_store')->favotiteUpdate($param,$user_id,$store_id);
	}

	/**
	 * お気に入り新規登録処理
	 *
	 * @param int $user_id ユーザID
	 * @param int $store_id 店舗ID
	 * @return mixed
	 */
	protected function inseart_favorite_action($user_id, $store_id){
		$param = array(
			'user_id'=>$user_id,
			'store_id'=>$store_id,
		);
		return $this->manager->db_manager->get('user_favorite_store')->insert($param);

	}
}