<?php
/***
 * 店舗管理者用管理画面ベースクラス
 *
 */
include_once dirname(__FILE__).'/../../system/Management.php';
include_once dirname(__FILE__).'/AdminPage.php';

abstract class MaintenancePage extends AdminPage{



	protected $page_cnt = 20;//一ページに表示するデータ数
	protected $account = NULL;
	protected $account_type = 'maintenance';


	/* @var Management */
	protected $manager   = NULL;

	/**
	 * ビューテンプレートの設定
	 *
	 */
	protected function setView(){
		$this->view = array(
				'index'       =>'maintenance/'.$this->use_table.'/index',
				'edit'        =>'maintenance/'.$this->use_table.'/edit',
				'confirm'     =>'maintenance/'.$this->use_table.'/confirm',
				'thanks'      =>'maintenance/'.$this->use_table.'/thanks',
				'error'       =>'maintenance/error',
				'token_error' =>'maintenance/token_error',
		);
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


		//limit句生成
		$limit = $this->manager->db_manager->get($this->use_table)->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->maintenanceSearchMaxCnt($account_id,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->maintenanceSearch($account_id,$get,$limit,$this->order);
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
	 * 削除
	 *
	 */
	public function deleteAction(){
		$id = getGet('id');
		$account = $this->getAccount();
		if($id != '' && ($res = $this->manager->db_manager->get($this->use_table)->findById($id)) && $res['store_id'] == $account['store_id']){
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
		$account = $this->getAccount();
		$param['store_id'] = $account['store_id'];
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
		$account = $this->getAccount();
		$param['store_id'] = $account['store_id'];
		$param = $this->inputToDbData($param);
		return $this->manager->db_manager->get($this->use_table)->updateById($this->id,$param);
	}
}