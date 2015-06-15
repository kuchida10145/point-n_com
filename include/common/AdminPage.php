<?php
/***
 * WEBサイト管理者用画面ベースクラス
 *
 */
include_once dirname(__FILE__).'/../../system/Management.php';
include_once dirname(__FILE__).'/Page.php';

abstract class AdminPage extends Page{


	protected $id = 0;/* ID */
	protected $use_table   = '';
	protected $session_key = '';
	protected $token     = '';
	protected $use_confirm = true;
	protected $page_title = '';
	protected $page_type_text = '';
	protected $page_cnt = 20;//一ページに表示するデータ数
	protected $account = NULL;
	protected $account_type = 'admin';
	protected $order = ' ';


	/* @var Management */
	protected $manager   = NULL;






	/**
	 * ビューテンプレートの設定
	 *
	 */
	protected function setView(){
		$this->view = array(
				'index'       =>'admin/'.$this->use_table.'/index',
				'edit'        =>'admin/'.$this->use_table.'/edit',
				'confirm'     =>'admin/'.$this->use_table.'/confirm',
				'thanks'      =>'admin/'.$this->use_table.'/thanks',
				'error'       =>'admin/error',
				'token_error' =>'admin/token_error',
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
			redirect('/admin/index.php');
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
		return;
	}

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
		$limit = $this->manager->db_manager->get($this->use_table)->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->adminSearchMaxCnt($get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->adminSearch($get,$limit,$this->order);
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
	 * 入力画面
	 *
	 */
	protected function editAction(){
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
						$result_flg = $this->update_actoin($post);
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

		//表示用データ
		$data = $this->getEditCommon();
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['system_message'] = $system_message;
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;
		$this->loadView('edit', $data);

	}



	/**
	 * ＤＢに保存されているデータを一件取得する
	 * @param int $id ＩＤ
	 * @return array
	 */
	protected function getDbData($id){
		return $this->manager->db_manager->get($this->use_table)->findById($id);
	}


	/**
	 * ＤＢデータから入力用データへ変換
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data){
		return $data;
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


	/**
	 * 入力用データからＤＢデータへ変換
	 * insert_actionやupdate_actionをオーバーライドしparentで呼び出した時、オーバーライド内にも書くと２回実行されるので注意
	 *
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function inputToDbData($data){
		return $data;
	}


	/**
	 * 初期入力データ取得
	 * @return array
	 */
	protected function getDefaultEditData(){
		return array();
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
				$result_flg = $this->update_actoin($post);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
			}

			if($result_flg !== false){
				redirect($this->use_table.'.php');
			}
			$this->unsetSystemMessage();
		}

		//表示用データ
		$data = $this->getConfirmCommon();
		$data['post']  = escapeHtml($post);
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;

		$this->loadView('confirm', $data);
	}



	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		return true;
	}




	/**
	 * 削除
	 *
	 */
	public function deleteAction(){
		$id = getGet('id');
		if($id != ''){
			$this->manager->db_manager->get($this->use_table)->deleteById($id);
		}
		$this->setSystemMessage($this->manager->message->get('system')->getMessage('delete_comp'));
		redirect($this->use_table.'.php');
	}



	/**
	 * 新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function inseart_action($param){
		$param = $this->inputToDbData($param);
		return $this->manager->db_manager->get($this->use_table)->insert($param);

	}


	/**
	 * 更新処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function update_actoin($param){
		$param = $this->inputToDbData($param);
		return $this->manager->db_manager->get($this->use_table)->updateById($this->id,$param);
	}


	/**
	 * テンプレートをロード
	 *
	 * @param string $template テンプレート
	 * @param array $data テンプレートで読みこむデータ
	 */
	protected function loadView($template,$data){
		$data['account'] = escapeHtml($this->getAccount());
		$this->manager->view->loadView($this->view[$template],$data,true);
		exit();
	}

	/**
	 * 一覧画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getIndexCommon($data = array()){
		return $data;
	}

	/**
	 * 入力画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getEditCommon($data = array()){
		return $data;
	}


	/**
	 * 確認画面の共通データを取得
	 *
	 * @param array $data 格納用変数
	 * @return array
	 */
	protected function getConfirmCommon($data = array()){
		return $data;
	}





	/**
	 * ログインされているかチェック
	 *
	 * @return bool
	 */
	protected function checkLogin(){
		$this->autoLogin();
		$account = $this->getAccount();
		if(!$account){
			return false;
		}
		return true;
	}






	/**
	 * エラーが発生した場合の表示画面
	 *
	 */
	protected function errorPage(){
		$this->loadView('error', array());
	}


	/**
	 * トークンエラーが発生した場合の表示画面
	 *
	 */
	protected function tokenErrorPage(){
		$this->loadView('token_error', array());
	}


	/**
	 * エラーメッセージのタグ設定
	 *
	 * @param string $str タグで囲むエラー文字
	 * @return string
	 */
	protected function setErrorTag($str){
		return '<span class="help-inline">'.$str.'</span>';
	}

}