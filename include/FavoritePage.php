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
	protected $page_cnt = 20;//一ページに表示するデータ数
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
//TODO:デバッグ用--->>>
//		$user_id = getParam($account,'user_id');
		$user_id = "1";
		$account = array(
			'user_id' => '1',
			'nickname' => 'テストちゃん',
			'point' => '1000',
		);
//----------------<<<
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

		//ページャ生成
		$pager_param['per_cnt'] = $this->page_cnt;
		$pager_param['all_cnt'] = $max_cnt;
		$this->manager->pager->setHtmlType( array() ,'admin');
		$this->manager->pager->initialize($pager_param);
		$pager_html = $this->manager->pager->create();

		//TODO:デバッグ用--->>>
		$data['debug_account']		= $account;
		//----------------<<<
		$data['list']           = $list;
		$data['pager_html']     = $pager_html;
		$data['page_title']     =$this->page_title;

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
}