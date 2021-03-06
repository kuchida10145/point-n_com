<?php
/**
 * 管理
 *
 */
include_once dirname(__FILE__).'/../common/AdminPage.php';

class ClaimPage extends AdminPage{

	protected $id = 0;/* ID */
	protected $use_table   = 'claim';
	protected $session_key = 'claim';
	protected $use_confirm = true;
	protected $page_title = 'ポイント利用履歴（受理済）';


	/**
	 * 一覧ページ
	 *
	 */
	protected function indexAction(){
		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();


		//limit句生成
		$limit = $this->manager->db_manager->get('reserved')->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get('reserved')->adminClaimSearchMaxCnt($get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get('reserved')->adminClaimSearch($get,$limit,$this->order);
		}


		//リストを出力用のデータに変換
		$list = $this->dbToListData($list);


		//タイトル
		$get_param = $_GET;
		if(getGet('coupon') == 1){
			$this->page_type_text = 'クーポン発行';
			unset($get_param['coupon']);
			$point = $this->manager->db_manager->get('reserved')->adminGetPointCnt($get);
		}
		else{
			$this->page_type_text = 'ポイント利用';
			$point = $this->manager->db_manager->get('reserved')->adminUsePointCnt($get);
		}



		//ページャ生成
		$pager_param['per_cnt'] = $this->page_cnt;
		$pager_param['all_cnt'] = $max_cnt;
		$this->manager->pager->setHtmlType( array() ,'admin');
		$this->manager->pager->initialize($pager_param);
		$pager_html = $this->manager->pager->create();

		$data['list']           = $list;
		$data['pager_html']     = $pager_html;
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;
		$data['system_message'] = $system_message;
		$data['point']          = number_format($point);
		$data['get_query'] = http_build_query($get_param);
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
			$val['use_point'] = number_format($val['use_point']);
			$val['get_point'] = number_format($val['get_point']);
			//HTMLエスケープも実行
			$data[$key] = escapeHtml($val);
		}
		return $data;
	}



	//入力画面は使わせない
	public function editAction() {
		$this->errorPage();
	}
	//削除は使わせない
	public function deleteAction() {
		$this->errorPage();
	}


	/**
	 * CSVダウンロード
	 */
	public function csvAction(){
		$list    = $this->manager->db_manager->get('reserved')->adminClaimSearch($_GET,"",$this->order);

		$fields = array(
			'予約No.',
			'来店日',
			'店舗名',
			'会員番号',
			'ユーザーID',
			'ニックネーム名',
			'クーポン名',
		);

		if(getGet('coupon') == 1){
			$fields[] = 'クーポン発行';
			$key = 'get_point';
		}
		else{
			$fields[] = 'ポイント利用';
			$key = 'use_point';
		}


		//CSV生成
		$fp = fopen('php://temp', 'r+b');
		fputcsv($fp, $fields);

		foreach($list as $val) {
			$claim = array();
			$claim[] = $val['reserved_id'];
			$claim[] = $val['use_date'];
			$claim[] = $val['store_name'];
			$claim[] = $val['user_id'];
			$claim[] = $val['email'];
			$claim[] = $val['reserved_name'];
			$claim[] = $val['coupon_name'];
			$claim[] = $val[$key];
			fputcsv($fp, $claim);
		}
		rewind($fp);
		$tmp = str_replace(PHP_EOL, "\r\n", stream_get_contents($fp));
		$csv= mb_convert_encoding($tmp, 'SJIS-win', 'UTF-8');

		//ダウンロード
		$fileName = "pref_" . date("YmdHis") . ".csv";
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $fileName);
		echo $csv;

	}

	/**
	 * 【店舗情報検索】中カテゴリのリスト取得（AJAX）
	 * - 業種（大カテゴリが1の場合：業種は1、2、大カテゴリが2、3の場合：業種は3）
	 * - 大カテゴリー(ジャンルマスター)
	 */
	protected function change_search_upper_itemAction(){
		$result['result'] = 'result';

		// 中カテゴリー
		$result['category_midium'] = array();

		$category_large_id   = $_POST['category_large_id'];
		$prefectures_id      = $_POST['prefectures_id'];
		$is_host = false;
		if ($category_large_id > 1) {
			// 業種およびジャンルマスターが風俗以外の場合
			$is_host = true;
		}
		if ($is_host) {
			$is_delivery = 0;
			// 中カテゴリー
			$result['category_midium'] = category_midium($category_large_id, $prefectures_id, $is_delivery);
		} else {
			// 中カテゴリー
			$array = category_midium_deli_all($category_large_id, $prefectures_id);
			$result['category_midium'] = $array;
		}

		echo json_encode($result);
		exit();
	}
}