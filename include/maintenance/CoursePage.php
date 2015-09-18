<?php
/**
 * コース管理画面TOP
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class CoursePage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'course';
	protected $session_key = 'course';
	protected $use_confirm = true;
	protected $page_title = 'コース情報管理';

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('course_name','required');
		$this->manager->validation->setRule('minutes','required|numeric|digit|pnumeric|alphanumeric');
		$this->manager->validation->setRule('price','required|numeric|digit|pnumeric|alphanumeric');
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
		$data['page_title'] = 'コース情報登録';
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['system_message'] = $system_message;
		$data['page_type_text'] =$this->page_type_text;
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
		$param['status_id'] = ST_ACT;
		return $this->manager->db_manager->get($this->use_table)->insert($param);

	}
}