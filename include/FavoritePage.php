<?php
/**
 * お気に入り一覧
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class FavoritePage extends Page{

	protected $id = 0;/* ID */
	protected $use_table   = 'user_favorite_store';
	protected $session_key = 'favorite';
	protected $use_confirm = true;
	protected $page_title = 'お気に入り';
	protected $page_cnt = 10;//一ページに表示するデータ数
	protected $account = NULL;
	protected $order = ' ';
	protected $page_type_text = '';

	protected $view = array(
			'index'    =>'favorite/index',
	);

	/**
	 * お気に入り店舗一覧
	 *
	 */
	public function indexAction(){
		$account = $this->getAccount();
		$user_id = getParam($account,'user_id');
		$get_data = array();

		if (getGet('m') == 'next') {
			$this->nextAjax();
			exit();
		} else if (getGet('m') == 'search_keyword') {
			$post = $_GET;
		} else {
			$post = $get_data;
			$post['user_id']  = getGet('user_id');
			$post['keyword']  = getGet('keyword');
		}

		// リンクパラメータを作成する
		$get_data['user_id']  = $post['user_id'];
		$get_data['keyword']  = $post['keyword'];
		$get_param = createLinkParam($get_data);

		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		$dbFlg = true;

		//limit句生成
		$limit = $this->manager->db_manager->get('reserved')->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->favoriteSearchMaxCnt($user_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->favoriteSearch($user_id,$get,$limit,$this->order);
		}

		//リストを出力用のデータに変換
		$list = $this->dbToListData($list);

		// 該当する条件のお気に入り店舗を取得する
		$favoriteStore = $this->manager->db_manager->get($this->use_table);
		$favoriteStore->setNextPage(0, $this->page_cnt);
		$total = $favoriteStore->favoriteStoreCountByUserID($user_id, $_GET);

		$data['user_id']		= $account['user_id'];
		$data['list']           = $list;
		$data['pager_html']     = $pager_html;
		$data['page_title']     =$this->page_title;

		$data['page_type_text'] =$this->page_type_text;
		$data['system_message'] = $system_message;
		$data['action_link'] = $get_param;
		$data['total'] = $total;
		$data['post'] = $post;

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

			if ($val['image1'] == "") {
				$val['image1'] = '/img/no_image_shop.gif';
			} else {
				$val['image1'] = '/files/images/' . $val['image1'];
			}
			//HTMLエスケープも実行
			$data[$key] = escapeHtml($val);
		}
		return $data;
	}

	/**
	 * 検索結果Ajax
	 *
	 */
	public function nextAjax() {
		$res['result']      = 'false';
		$next               = getGet('next');
		$start              = $next * $this->page_cnt;
		$user_id       		= getGet('user_id');
		$keyword            = getGet('keyword');
		$favoriteStore = $this->manager->db_manager->get($this->use_table);
		$favoriteStore->setNextPage($start, $this->page_cnt);
		$pages = $favoriteStore->favoriteStoreListByUserID($user_id, $_GET);

		if ($pages) {
			$res['result']    = 'true';
			$res['cur_shops'] = $start + count($pages);
		}
		$res['pages'] = $this->changeListData($pages, true);

		echo json_encode($res);
	}

	/**
	 * 一覧用データ変換(HTMLエスケープも実行)
	 *
	 * @param array $datas
	 * @param boolean $is_escape_html
	 * @return NULL|array
	 */
	private function changeListData($datas, $is_escape_html) {
		if (!$datas) {
			return null;
		}

		foreach ($datas as $data_key => $data) {
			if ($data['image1'] == "") {
				$data['image1'] = '/img/no_image_shop.gif';
			} else {
				$data['image1'] = '/files/images/' . $data['image1'];
			}

			if ($is_escape_html) {
				$data = escapeHtml($data);
			}

			$datas[$data_key] = $data;
		}

		return $datas;
	}
}