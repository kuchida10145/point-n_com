<?php
/**
 * クーポン管理画面TOP
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class CouponPage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'coupon';
	protected $session_key = 'coupon';
	protected $use_confirm = true;
	protected $page_title = 'クーポン情報登録';


	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('coupon_name','required');
		$this->manager->validation->setRule('point','selected');
		$this->manager->validation->setRule('course_id','selected');
		$this->manager->validation->setRule('minutes','required');
		$this->manager->validation->setRule('price','required');
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
	 * tkn生成時にデータをセッションに格納
	 */
	protected function editDefaultParam(){
		if($this->getFormSession('id') != '') {
			$res = $this->getDbData($this->getFormSession('id'));
			$this->setFormSession('p',$res['point_kind']); //ポイント種別
		} else {
			$this->setFormSession('p',getGet('p')); //ポイント種別
		}
		return;
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
		$normal_list = array();
		$event_list = array();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		$dbFlg = true;

		// クーポン有効処理
		if(!empty($get['job'])){
			if($get['kind']) {
				$dbFlg = $this->manager->db_manager->get($this->use_table)->updateForce($account['store_id'],$get['id'], $get['kind']);
			}

			if(!$dbFlg){
				redirect('index.php');
			}
		}

		//limit句生成
		$limit = $this->manager->db_manager->get($this->use_table)->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->maintenanceSearchMaxCnt($account_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->maintenanceSearch($account_id,$get,$limit,$this->order);
		}

		// リストを出力用のデータに変換
		$list = $this->dbToListData($list);

		// クーポン名プルダウン
		foreach ($list as $key=>$val) {
			$coupon_list[$val['coupon_id']] = $val['coupon_name'];
		}

		//ページャ生成
		$data = $this->getIndexCommon();
		$pager_param['per_cnt'] = $this->page_cnt;
		$pager_param['all_cnt'] = $max_cnt;
		$this->manager->pager->setHtmlType( array() ,'admin');
		$this->manager->pager->initialize($pager_param);
		$pager_html = $this->manager->pager->create();

		$data['list']           = $list;
		$data['coupon_list']    = coupon_list($account_id);
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
	 * 入力画面
	 *
	 */
	public function editAction(){
		$post  = array();
		$data  = array();
		$error = array();
		$system_message = '';

		//POST送信があった場合
		if(getPost('m') == 'edit'){

			$post = $_POST;

			//入力チェックＯＫ時
			if($this->validation($post)){

				//確認画面を使わない場合
				if($this->use_confirm == false){

					if($this->id == 0){
						$result_flg = $this->inseart_action($post);
						$this->setSystemMessage($this->manager->message->get('system')->getMessage('insert_comp'));
					}
					else {
						$result_flg = $this->update_action($post);
						$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
					}

					if($result_flg !== false){
						redirect($this->use_table.'.php');
					}

				}

				//確認画面を利用する場合
				else{
					$this->setFormSession('form',$post);
					redirect('?m=confirm&tkn='.$this->token);
				}
			}
			//入力チェックエラー時
			//エラーメッセージ取得
			$error = $this->getValidationError();

			//エラーシステムメッセージ取得
			$system_message = $this->manager->message->get('system')->getMessage('edit_error');
		}

		//戻るボタンで戻った場合
		else if(is_array($this->getFormSession('form'))){
			$post = $this->getFormSession('form');

		}
		//IDがある場合の初期状態
		else if($this->id != 0){
			//データが無ければエラー扱い
			if(!($res = $this->getDbData($this->id))){
				$this->errorPage();
				exit();
			}

			//DBデータを入力用データに変換
			$post = $this->dbToInputData($res);
		}
		//初期状態
		else{
			$post = $this->getDefaultEditData();
		}

		$data = $this->getEditCommon();
		//表示用データ
		if($this->getFormSession('p') == '1') {
			$data['page_title'] = 'クーポン情報登録';
			$data['claim_msg']	= '※ クーポンが1度使用される毎に、ポイント数+500円の使用料金が発生します。<br/>例) 1,000Pのクーポンを5組が使用した場合、7,500円の使用料金が発生します。';
		} else {
			$data['page_title']     ='イベントクーポン情報登録';
			$data['claim_msg']	= '※ イベントクーポンが1度使用される毎に、ポイント数*2の使用料金が発生します。<br/>例) 1,000Pのイベントクーポンを5組が使用した場合、10,000円の使用料金が発生します。';
		}
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['system_message'] = $system_message;
		$data['page_type_text'] =$this->page_type_text;
		$account = $this->getAccount();
		$data['store_id'] = $account['store_id'];
		$data['course_price'] = course_price($account['store_id']);
		$data['course_minutes'] = course_minutes($account['store_id']);
		$data['p'] = $this->getFormSession('p');

		$this->loadView('edit', $data);
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
			if($this->id == 0){
				$result_flg = $this->inseart_action($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('insert_comp'));
			}
			else {
				$result_flg = $this->update_action($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
			}

			if($result_flg !== false){
				redirect($this->use_table.'.php');
			}
			$this->unsetSystemMessage();
		}

		//表示用データ
		$data = $this->getConfirmCommon();
		$data['use_condition']  = $post['use_condition'];	// HTMLエスケープ前に利用条件を退避する。
		$data['post']  = escapeHtml($post);
		// コース情報を取得する。
		$data['course_name'] = getParam(course_list($post['store_id']),$post['course_id']);

		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;

		$this->loadView('confirm', $data);
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
		$param['point_kind'] = $this->getFormSession('p');
		return $this->manager->db_manager->get($this->use_table)->insert($param);
	}
}