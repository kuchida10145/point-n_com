<?php
/**
 * 店舗検索：検索ジャンル
 *
 */
include_once(dirname(__FILE__) . '/../common/Page.php');

class Store_nearPage extends Page{
	
	protected $session_key = 'store_near';
	protected $page_title  = '近くの店舗を探す';
	protected $gpsRadius 	 = 2; //近くのお店を探す機能の検索範囲半径
	protected $storeByPage = 20; //近くのお店を探す結果ページに表示される店舗数 
	
	protected $view = array(
			'near'     => 'stores/near',
	);
	
	/**
	 * 近くの店舗を探すページ
	 *
	 */
	public function indexAction(){

		$gpsError 			  = ''; //現在地を取得するときに発生するエラーメッセージ
		$nearbyStoresData	= array(); //検索結果一覧を表示する店舗関連情報が入る
		//$pagerHtml 				= ''; //ページャ
		$storesCount 			= 0; //近くのお店検索結果数

		$post = $_POST;

		if ( '' != getPost('gps_error') ) {

			//現在地が取得できない場合そのエラーメッセージを出す
			$gpsError = getPost('gps_error');
		} elseif ( '' != getPost('gps_lat') && '' != getPost('gps_long') ) {

			//GET urlを作成
			redirect( '?lat=' . getPost('gps_lat') . '&long=' . getPost('gps_long') );
			exit;			
		} elseif ( '' != getGet('lat') && '' != getGet('long') ) {

			$keyword   = '';
			$latitude  = floatval( getGet('lat') );
			$longitude = floatval( getGet('long') );
			$mapStores = array();

			//店舗名で抽出検索
			if ( '' != getGet('keyword') ) {

				$keyword = urldecode( getGet('keyword') );
			}

			//近くの店舗を検索
			$stores = $this->manager->db_manager->get('store')->findShopsNearby( $latitude, $longitude, $this->gpsRadius, $keyword );

			if ( NULL == $stores || empty($stores) ) {
				
				//加盟店舗が見つからなかったエラーメッセージ
				$gpsError = '現在地より' . $this->gpsRadius . 'km以内';

				if ( '' != getGet('keyword') ) {
					$gpsError .= '「' . getGet('keyword') . '」という';
				} else {
					$gpsError .= 'の';
				}

				$gpsError .= 'お店は見つかりませんでした。<br><br>';
			} else {

				//ページャ用：近くのお店の結果数を計算
				$storesCount = count($stores);

				//マップに表示する店舗データの整理
				foreach ( $stores as $store ) {
					
					$mapStores[] = array(
							'name' 		  => $store['store_name'],
							'latitude'  => $store['latitude'], 
							'longitude' => $store['longitude'], 
					);
				}

				//結果一覧に表示する店舗のIDをキープ
				$storesId = array();

				$firstStore = 0;
				if ( '' != getGet('page') && getGet('page') > 1 ) {

					$firstStore = ( getGet('page') - 1 ) * $this->storeByPage; 
				}

				$lastStore = $firstStore + $this->storeByPage - 1;
				if ( $lastStore >= $storesCount ) {
					$lastStore = $storesCount - 1;
				}

				if ( $firstStore < $storesCount ) {

					for ( $i = $firstStore;  $i <= $lastStore; $i++ ) { 
						
						$storesId[] = $stores[$i]['store_id'];
					}
				}

				//検索結果一覧に表示する近くのお店の情報を取得
				$nearbyStoresData = $this->manager->db_manager->get('store')->findShopDataById( $storesId );
				
				//Ajaxクエリーの場合
				//GETでページ数が入っていると$firstStore > 0 == true
				if ( $firstStore > 0 ) {

					echo json_encode($nearbyStoresData);
					exit;
				}

				/*
				//ページャ(HTML)生成
				$pagerParam['per_cnt'] = $this->storeByPage;
				$pagerParam['all_cnt'] = $storesCount;

				$this->manager->pager->setHtmlType(array(), 'admin');
				$this->manager->pager->initialize( $pagerParam );

				$pagerHtml = $this->manager->pager->create();
				*/

				//ビューで使うデータの準備
				$data['storesTotal'] = $storesCount;
				$data['storeStart']  = $firstStore + 1;
				$data['storeEnd']  = $lastStore + 1;
 			}	

			//ビューで使うデータの準備
			$data['gps']['latitude']  	 = $latitude;
			$data['gps']['longitude'] 	 = $longitude;
			$data['gps']['nearbyStores'] = json_encode($mapStores);


		} else {

			//経度や緯度のデータがない場合もエラーを出す
			$gpsError = 'エラーが発生しました。';
		}
		
		$data['gps']['error'] = $gpsError;
		$data['gps']['km'] 	= $this->gpsRadius;
		$data['page_title'] = $this->page_title;
		//$data['pager_html']	= $pagerHtml;
		$data['list'] 		  = $nearbyStoresData;		
 		$this->loadView('near', $data);
	}
}

