<?php
/**
 * ポイント履歴
 *
 */
include_once dirname(__FILE__).'/common/Page.php';

class PointPage extends Page{

	protected $id = 0;/* ID */
	protected $use_table   = 'reserved';
	protected $session_key = 'point';
	protected $use_confirm = true;
	protected $page_title = 'ポイント履歴';
	protected $page_cnt = 20;//一ページに表示するデータ数
	protected $account = NULL;
	protected $order = ' ';
	protected $page_type_text = '';

	protected $view = array(
			'index'    =>'mypage/point',
	);

	/**
	 * ポイント履歴一覧
	 *
	 */
	public function indexAction(){
		$account = $this->getAccount();
		$user_id = getParam($account,'user_id');
		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		$dbFlg = true;

		//limit句生成
		$limit = $this->manager->db_manager->get('reserved')->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->pointHistorySelectSearchMaxCnt($user_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->pointHistorySelectSearch($user_id,$get,$limit,$this->order);
		}

		//リストを出力用のデータに変換
		$list = $this->dbToListData($list);

		//ページャ生成
		$pager_param['per_cnt'] = $this->page_cnt;
		$pager_param['all_cnt'] = $max_cnt;
		$this->manager->pager->setHtmlType( array() ,'admin');
		$this->manager->pager->initialize($pager_param);
		$pager_html = $this->manager->pager->create();

		$data['debug_account']		= $account;
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