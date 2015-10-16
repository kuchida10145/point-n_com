<?php
/**
 * 特別ポイント管理画面TOP
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class Special_point extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'reserved';
	protected $session_key = 'special_point';
	protected $use_confirm = true;
	protected $page_title = '特別ポイント管理';

	/**
	 * ビューテンプレートの設定
	 *
	 */
	protected function setView(){
		$this->view = array(
				'index'       =>'maintenance/special_point/index',
				'search'      =>'maintenance/special_point/search',
				'edit'        =>'maintenance/special_point/edit',
				'confirm'     =>'maintenance/special_point/confirm',
				'thanks'      =>'maintenance/special_point/thanks',
				'error'       =>'maintenance/error',
				'token_error' =>'maintenance/token_error',
		);
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

				case 'search':
					$this->page_type_text = '一覧';
					break;

					//編集ページの場合
				case 'edit':
					//編集ページはToken必須
					$this->token = getGet('tkn');
					if($this->token==''){

						$this->token = $this->manager->token->createToken($this->account_type.'_'.$this->session_key);
						if(getGet('id')!=''){
							$this->setFormSession('id',getGet('id'));
						}
						$this->editDefaultParam();
						redirect('?m=edit&tkn='.$this->token);
					}

					$id = $this->getFormSession('id');

					$this->page_type_text = '新規作成';
					if($id != NULL){
						$this->id = $id;
						$this->page_type_text = '編集';
					}
					break;


					//確認画面
				case 'confirm':
					//確認画面はToken必須
					$this->token = getGet('tkn');
					$this->page_type_text = '確認';
					if($this->getFormSession('id') != ''){
						$this->id = $this->getFormSession('id');
					}
					break;
			}
			$this->{$method}();
		}
		else{
			$this->errorPage();
		}

	}

	/**
	 * 一覧ページ(特別ポイント付与履歴)
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
		$this->order = "order by reserved.reserved_date desc";

		//limit句生成
		$limit = $this->manager->db_manager->get($this->use_table)->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->specialPointSearchMaxCnt($account_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->specialPointSearch($account_id,$get,$limit,$this->order);
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
	 * 一覧ページ(特別ポイント付与対象ユーザ一覧)
	 *
	 */
	protected function searchAction(){
		$account = $this->getAccount();
		$account_id = getParam($account,'store_id');
		$pager_html = '';
		$get        = $_GET;
		$list       = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();

		//limit句生成
		$limit = $this->manager->db_manager->get('user')->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get('user')->adminSearchMaxCnt($get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get('user')->adminSearch($get,$limit,$this->order);
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
		$data['page_title']     = $this->page_title;

		$data['page_type_text'] =$this->page_type_text;
		$data['system_message'] = $system_message;
		$this->loadView('search', $data);
	}

	/**
	 * 入力確認画面
	 *
	 */
	protected function confirmAction(){
		$post  = $this->getFormSession('form');
		$data  = array();
		//入力チェック
		if(!$this->validation($post)){
			$this->errorPage();
			exit();
		}

		//POST送信があった場合
		if(getPost('m') == 'confirm'){

			$user_name = $post['nickname'];
			$user_id   = $post['user_id'];
			$regist_date = date('Y-m-d H:i:s');
			$post['regist_date'] = $regist_date;
			$year_month = date('Y-m',strtotime($regist_date));

			//請求処理
			$account = $this->getAccount();

			//ポイント枠を消費
			if($this->manager->db_manager->get('store')->usePointLimit($account['store_id'],$post['sp_point']*2) !== false){

				$result_flg = $this->inseart_action($post);		// 予約情報更新
				if($result_flg !== false){
					$result_flg = $this->user_update_action($post);	// ユーザテーブル更新


					$this->manager->db_manager->get('bill_action')->issueSpecialPoint($account['store_id'],$post['sp_point'],"[会員番号:{$user_id}]{$user_name}");
					$this->manager->db_manager->get('bill')->monthTotalBillByStoreId($year_month,$account['store_id']);

					$store = $this->manager->db_manager->get('store')->findById($account['store_id']);

					$this->setAccount($store);
				}

				$this->setSystemMessage($this->manager->message->get('system')->getMessage('insert_comp'));

				if($result_flg !== false){
					redirect('special_point.php');
				}
				$this->unsetSystemMessage();
			} else {
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('point_error'));
				redirect('special_point.php');
			}
		}

		//表示用データ
		$data = $this->getConfirmCommon();
		$data['post']  = escapeHtml($post);
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;
		$data['system_message'] = $this->getSystemMessage();
		$this->loadView('confirm', $data);
	}

	/**
	 * ＤＢに保存されているデータを一件取得する
	 * @param int $id ＩＤ
	 * @return array
	 */
	protected function getDbData($id){
		if(($res =$this->manager->db_manager->get('user')->findById($id))){
			return $res;
		}
		return NULL;
	}

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('sp_point','selected');
		return $this->manager->validation->run($param);
	}

	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		$account = $this->getAccount();
		$param['store_id'] = $account['store_id'];
		$param['status_id'] = RESERVE_ST_SP;
		$param['use_point'] = '0';
		$param['get_point'] = getParam(specialPoint_data(),$param['sp_point']);
		$param['reserved_date'] = date("Y-m-d H:i:s");
		$param['use_date'] = date("Y-m-d H:i:s");
		return $this->manager->db_manager->get($this->use_table)->insert($param);
	}

	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function user_update_action($param){
		$param = $this->inputToDbData($param);
		// 保持ポイント取得
		$res =$this->manager->db_manager->get('user')->findById($param['user_id']);
		$param['point'] = $res['point'] + getParam(specialPoint_data(),$param['sp_point']);
		return $this->manager->db_manager->get('user')->updateById($this->id,$param);
	}
}