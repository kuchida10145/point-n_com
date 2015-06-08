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

		if(getParam($get,'update') != ''  && is_string(getParam($get,'update'))){
			// 取消ボタン
			if(getParam($get,'sp') != ''  && is_string(getParam($get,'sp'))){
				$dbFlg = $this->manager->db_manager->get('reserved')->updateStatusid(getParam($get,'update'), RESERVE_ST_INV);
			}
			// 受理ボタン
			else {
				$dbFlg = $this->manager->db_manager->get('reserved')->updateStatusid(getParam($get,'update'), RESERVE_ST_FIN);
				if($dbFlg !== false){
					$dbFlg = $this->user_update_actoin($get);
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
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function user_update_actoin($param){
		$res = $this->manager->db_manager->get('user')->findByNickname($param['name']);
		$user_id = $res['user_id'];
		$param['point'] = $res['point'] + $param['get_p'] - $param['use_p'];				// 保持ポイント計算
		return $this->manager->db_manager->get('user')->updateById($user_id,$param);
	}
}