<?php
/**
 * 店舗検索：検索結果一覧
 *
 */
include_once(dirname(__FILE__) . '/../common/Page.php');

class Store_searchPage extends Page {

	protected $id = 0;/* ID */
	protected $session_key = 'store_search';
	protected $use_confirm = false;
	protected $page_title = '検索結果一覧';
	protected $page_cnt = 10;
	protected $debug = false;

	protected $view = array(
			'index'     => 'stores/search',
	);

	/**
	 * 検索結果一覧
	 *
	 */
	public function indexAction(){
		$post = array();
		$error = array();
		$get_data = array();

		if (getGet('m') == 'next') {
			$this->nextAjax();
			exit();
		} else if (getGet('m') == 'search_keyword') {
			$post = $_GET;
		} else if (getGet('m') == 'search_sort') {
			$post = $_GET;
		} else {
			$post = $get_data;
			$post['category_large_id']  = getGet('category_large_id');
			$post['region_id']          = getGet('region_id');
			$post['category_midium_id'] = getGet('category_midium_id');
			$post['category_small_ids'] = getGet('category_small_ids');
			$post['area_key_ids']       = getGet('area_key_ids');
			$post['keyword']            = getGet('keyword');
			$post['sort']               = getGet('sort');
		}

		$category_small_ids = (is_array($post['category_small_ids'])) ? $post['category_small_ids'] : explode(",", $post['category_small_ids']);
		$post['category_small_ids'] = implode(",", $category_small_ids);
		$area_key_ids               = (is_array($post['area_key_ids'])) ? $post['area_key_ids'] : explode(",", $post['area_key_ids']);
		$post['area_key_ids']       = implode(",", $area_key_ids);

		// 今日のニュースを１件取得する
		$region_id = getGet('region_id');
		$news = $this->manager->db_manager->get('news')->getNewsList($region_id,0, 1);
		$news = ($news != null) ? $news : array();

		// 該当する条件の店舗を取得する
		$post['sort'] = (!empty($post['sort'])) ? $post['sort'] : 7;
		$store = $this->manager->db_manager->get('store');
		$store->setNextPage(0, $this->page_cnt);
		$store->setSortID($post['sort']);
		$total = $store->shopCountByCategoryAndAreaKeyIDs($post['category_large_id'], $post['category_midium_id'], $post['category_small_ids'], $area_key_ids, $post['keyword']);
		$shops = $store->shopListByCategoryAndAreaKeyIDs($post['category_large_id'], $post['category_midium_id'], $post['category_small_ids'], $area_key_ids, $post['keyword']);
		if ($this->debug) {
			$data['sql'] = $store->getLastQuerySQL();
		}
		$shops = ($shops != null) ? $shops : array();
		$shops = $this->changeListData($shops, true);

		// リンクパラメータを作成する
		$get_data['category_large_id']  = $post['category_large_id'];
		$get_data['region_id']          = $post['region_id'];
		if (!empty($post['category_large_id']) && !empty($post['category_large_id'])) {
			$research_param = createLinkParam($get_data);
		} else {
			$research_param = "";
		}
		$get_data['category_midium_id'] = $post['category_midium_id'];
		$get_data['category_small_ids'] = $post['category_small_ids'];
		$get_data['area_key_ids']       = $post['area_key_ids'];
		$get_back_param = createLinkParam($get_data);
		$get_data['keyword']            = $post['keyword'];
		$get_param = createLinkParam($get_data);

		// 条件変更のリンク先を決定する
		if ($get_data['region_id'] == "" || $get_data['category_large_id'] == "") {
			$back_link = '/';
		} else if ($get_data['category_small_ids'] == "" || $get_data['category_midium_id'] == "") {
			$back_link = '/stores/genre.php';
		} else if ($get_data['area_key_ids'] == "") {
			$back_link = '/stores/area.php';
		} else {
			$back_link = '/stores/area.php';
		}

		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['action_link'] = $get_param;
		$data['research_link'] = $research_param;
		$data['get_back_param'] = $get_back_param;
		$data['condition_category_large_name']  = getParam(category_large(), $post['category_large_id']);
		$data['condition_redion_name']          = getParam(region_master(), $post['region_id']);
		$data['condition_category_midium_name'] = getParam(category_midium_for_customer($post['category_large_id'], $post['region_id']), $post['category_midium_id']);
		$small_names = array();
		foreach ($category_small_ids as $key => $small_id) {
			$record = $this->manager->db_manager->get('category_small')->findById($small_id);
			if ($record != null) {
				$small_names[] = $record['category_small_name'];
			}
		}
		$data['condition_category_small_names'] = $small_names;
		$area_key_names = array();
		foreach ($area_key_ids as $key => $area_key_id) {
			// 第３階層から第１階層の順で有効なエリア名を取得する
			$pieces = explode("-", $area_key_id);
			$area_first_id  = (isset($pieces[0])) ? $pieces[0] : "0";
			$area_second_id = (isset($pieces[1])) ? $pieces[1] : "0";
			$area_third_id  = (isset($pieces[2])) ? $pieces[2] : "0";
			$area123name = $this->manager->db_manager->get('area_third')->area123name($area_first_id, $area_second_id, $area_third_id);
			if (isset($area123name['area_third_name']) && $area123name['area_third_name'] != "") {
				$area_key_names[] = $area123name['area_third_name'];
			} else if (isset($area123name['area_second_name']) && $area123name['area_second_name'] != "") {
				$area_key_names[] = $area123name['area_second_name'];
			} else if (isset($area123name['area_first_name']) && $area123name['area_first_name'] != "") {
				$area_key_names[] = $area123name['area_first_name'];
			}
		}
		$data['area_key_names'] = $area_key_names;
		$data['area_names']     = $small_names;
		$data['back_link']      = $back_link;
		$data['news_list']      = escapeHtml($news);
		$data['shop_list']      = $shops;
		$data['total']          = $total;
		$data['debug']          = $this->debug;

		$this->loadView('index', $data);
	}

	/**
	 * 検索結果Ajax
	 *
	 */
	public function nextAjax() {
		$res['result']      = 'false';
		$next               = getGet('next');
		$start              = $next * $this->page_cnt;
		$category_large_id  = getGet('category_large_id');
		$category_midium_id = getGet('category_midium_id');
		$category_small_ids = getGet('category_small_ids');
		$area_key_ids       = getGet('area_key_ids');
		$keyword            = getGet('keyword');
		$sort               = getGet('sort');
		$store = $this->manager->db_manager->get('store');
		$store->setNextPage($start, $this->page_cnt);
		$store->setSortID($sort);
		$pages = $store->shopListByCategoryAndAreaKeyIDs($category_large_id, $category_midium_id, $category_small_ids, $area_key_ids, $keyword);
		if ($pages) {
			$res['result']    = 'true';
			$res['cur_shops'] = $start + count($pages);
			$res['is_point_selected_sort'] = is_point_selected_sort($sort);
			$res['is_event_selected_sort'] = is_event_selected_sort($sort);
		}
		$res['pages'] = $this->changeListData($pages, true);
		if ($this->debug) {
			$res['sql'] = $store->getLastQuerySQL();
		}
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
