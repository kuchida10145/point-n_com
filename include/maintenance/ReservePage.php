<?php
/**
 * クーポン管理画面TOP
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class ReservePage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'reserved';
	protected $session_key = 'reserve';
	protected $use_confirm = true;
	protected $page_title = '予約管理';

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('coupon_name','required');
		$this->manager->validation->setRule('course_id','required');
		$this->manager->validation->setRule('use_condition','required');
		return $this->manager->validation->run($param);
	}

	public function run(){
		$get = $_GET;
		$mode   = getGet('m','index');
		$method = getGet('m','index').'Action';
		$this->setView();

		//ログインチェック
		if($this->checkLogin() == false){
			//すべてのセッションを削除

			//TOPページへリダイレクト
			redirect(ADMIN_URL.'index.php');
		}

		//関数が存在する場合
		if(method_exists($this,$method)){

			switch($mode){
				//一覧画面
				case 'index':
					$this->page_type_text = '一覧';
					break;

					//編集ページの場合
				case 'edit':
					break;

					//確認画面
				case 'confirm':
					break;
			}
			$this->{$method}();
		}
		else{
			$this->errorPage();
		}

	}

	/**
	 * ＤＢに保存されているデータを一件取得する
	 * @param int $id ＩＤ
	 * @return array
	 */
	protected function getDbData($id){
		$account = $this->getAccount();
		if(($res =$this->manager->db_manager->get($this->use_table)->findById($id)) && $res['store_id'] == $account['store_id']){
			return $res;
		}
		return NULL;
	}

	/**
	 * 一覧ページ
	 *
	 */
	protected function indexAction(){
		$account = $this->getAccount();
		$account_id = getParam($account,'store_id');
		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		$dbFlg = true;

		if(getParam($get,'reserved_id') != ''  && is_string(getParam($get,'reserved_id'))){
			// 取消ボタン
			if(getParam($get,'type') == 'cancel'  && is_string(getParam($get,'type'))){
				$dbFlg = $this->manager->db_manager->get('reserved')->updateStatusid(getParam($get,'reserved_id'), RESERVE_ST_INV);
				if($dbFlg !== false){
					$dbFlg = $this->user_update_action_cancel(getParam($get,'reserved_id'));
				}
			}
			// 受理ボタン
			elseif(getParam($get,'type') == 'accept'  && is_string(getParam($get,'type'))){
				$dbFlg = $this->manager->db_manager->get('reserved')->updateStatusid(getParam($get,'reserved_id'), RESERVE_ST_FIN);
				if($dbFlg !== false){
					$dbFlg = $this->user_update_action(getParam($get,'reserved_id'));
				}
			}
		}

		if(!$dbFlg){
			redirect('index.php');
		}

		//limit句生成
		$limit = $this->manager->db_manager->get('reserved')->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->maintenanceReserveSearchMaxCnt($account_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->maintenanceRserveSearch($account_id,$get,$limit,$this->order);
		}

		//リストを出力用のデータに変換
		$list = $this->dbToListData($list);

		//システムメッセージ

		//ページャ生成
		$data = $this->getIndexCommon();
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

		$this->loadView('index', $data);
	}

	/**
	 * 一覧画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getIndexCommon($data = array()){
		$account = $this->getAccount();
		$account_id = getParam($account,'store_id');
		$data['account_id'] = $account_id;
		return $data;
	}

	/**
	 * 更新処理（予約受理）
	 *
	 * @param number $reserved_id 予約ID
	 * @return mixed
	 */
	protected function user_update_action($reserved_id){
		//DBデータ取得
		$reservedInfo = $this->manager->db_manager->get('reserved')->findById($reserved_id);	//予約情報
		$res = $this->manager->db_manager->get('user')->findById($reservedInfo['user_id']);		//ユーザ情報

		$updateParam = array(
					'point'=>$res['point'] + $reservedInfo['get_point'],	// 保持ポイント計算
				);
		return $this->manager->db_manager->get('user')->updateById($res['user_id'],$updateParam);
	}

	/**
	 * 更新処理（予約取り消し）
	 *
	 * @param number $reserved_id 予約ID
	 * @return mixed
	 */
	protected function user_update_action_cancel($reserved_id){
		//DBデータ取得
		$reservedInfo = $this->manager->db_manager->get('reserved')->findById($reserved_id);	//予約情報
		$res = $this->manager->db_manager->get('user')->findById($reservedInfo['user_id']);		//ユーザ情報

		$updateParam = array(
				'point'=>$res['point'] + $reservedInfo['use_point'],	// 保持ポイント計算
		);
		$user_res = $this->manager->db_manager->get('user')->updateById($res['user_id'],$updateParam);
		
		$account = $this->getAccount();
		$year_month = date('Y-m');
		
		
		$bill_action = $this->manager->db_manager->get('bill_action')->getIssueByReservedId($reserved_id);
		
		$action_date = date('Y-m-d',strtotime($bill_action['regist_date']));
		$today       = date('Y-m-d');
		
		$bill_action_id = $this->manager->db_manager->get('bill_action')->cancelByReservedId($reserved_id);
		$this->manager->db_manager->get('bill')->monthTotalBillByStoreId($year_month,$account['store_id']);
		
		//年月が同じ場合のみ利用枠を復旧
		if($today == $action_date){
			$this->manager->db_manager->get('store')->addPointLimit($account['store_id'],$bill_action['total_price']);
			$account = $this->manager->db_manager->get('store')->findById($account['store_id']);
			$this->setAccount($account);
		}
		return $user_res;
	}
}