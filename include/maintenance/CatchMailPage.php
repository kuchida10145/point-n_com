<?php
/**
 *
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';
include_once(dirname(__FILE__) . '/../common/NewsCommonPage.php');

class CatchMailPage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'catchmail';
	protected $session_key = 'catchmail';
	protected $use_confirm = true;
	protected $page_title = 'キャッチメール管理';
	protected $order = ' ORDER BY reserved_date DESC';

	/**
	 * ビューテンプレートの設定
	 *
	 */
	protected function setView(){
		$this->view = array(
				'index'       =>'maintenance/'.$this->use_table.'/index',
				'indexCancell'=>'maintenance/'.$this->use_table.'/indexCancell',
				'edit'        =>'maintenance/'.$this->use_table.'/edit',
				'confirm'     =>'maintenance/'.$this->use_table.'/confirm',
				'confirm_del' =>'maintenance/'.$this->use_table.'/confirm_del',
				'confirm_remand' =>'maintenance/'.$this->use_table.'/confirm_remand',
				'thanks'      =>'maintenance/'.$this->use_table.'/thanks',
				'error'       =>'maintenance/error',
				'token_error' =>'maintenance/token_error',
		);
	}

	/**
	 * 入力チェック
	 *
	 */
	protected function validation($param){
		$this->manager->validation->setRule('money','required');
		return $this->manager->validation->run($param);
	}

	/**
	 * ＤＢに保存されているデータを一件取得する
	 * @param int $id ＩＤ
	 * @return array
	 */
	protected function getDbData($id){
		$account = $this->getAccount();
		if(($res =$this->manager->db_manager->get($this->use_table)->findById($id))){
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

		// 予約データ取得
		//limit句生成
		$limit = $this->manager->db_manager->get('catchmail')->createLimit(getGet('page'),$this->page_cnt);

		//最大件数取得
		$max_cnt = $this->manager->db_manager->get($this->use_table)->maintenanceReserveSearchMaxCnt($account,$get);

		//リスト取得
		if($max_cnt > 0){
			$list    = $this->manager->db_manager->get($this->use_table)->maintenanceRserveSearch($account,$get,$limit,$this->order);
		}

		//リストを出力用のデータに変換
		$list = $this->dbToListData($list);

		//返信データを取得
		$reply_list = $this->manager->db_manager->get('catchmail_return')->maintenanceSearch($account_id,"","","");
		$reply_id_list = array();
		foreach ($reply_list as $id=>$value) {
			$reply_id_list[$value['catchmail_id']] = $value['store_id'];
		}

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

		$data['page_type_text'] = $this->page_type_text;
		$data['system_message'] = $system_message;

		$data['reply_id_list'] = $reply_id_list;
		$data['account_id'] = $account_id;

		$this->loadView('index', $data);
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
			$result_flg = $this->reply_inseart_action($post);
			$this->setSystemMessage($this->manager->message->get('system')->getMessage('insert_comp'));

			if($result_flg !== false){
				//メール送付(最初の1店舗のみ)
				$catchmail_return_count = $this->manager->db_manager->get('catchmail_return')->getReplyDataCount(getParam($post,'catchmeil_id'));
				if($catchmail_return_count['count'] == 0) {
					$reserved_name = getParam($post,'reserved_name');		//予約名
					$user = $this->manager->db_manager->get('user')->findById(getParam($post,'user_id'));		//ユーザ情報
					$account = $this->getAccount();
					$store_name = getParam($account,'store_name');
					$this->sendUserMail($user, $reserved_name, $store_name, CATCH_MAIL_ID);
				}
				$this->unsetFormSession('form');
				redirect($this->use_table.'.php');
			}
			$this->unsetSystemMessage();
		}

		//表示用データ
		$data = $this->getConfirmCommon();
		$data['appeal']  = $post['appeal'];
		$data['post']  = escapeHtml($post);
		$data['page_title']     =$this->page_title;
		$data['page_type_text'] =$this->page_type_text;

		$this->loadView('confirm', $data);
	}

	/**
	 * 返信メール新規登録処理
	 *
	 * @param array $param 更新用パラメータ
	 * @return mixed
	 */
	protected function reply_inseart_action($param){
		$account = $this->getAccount();
		$param['store_id'] = $account['store_id'];
		$param = $this->inputToDbData($param);
		return $this->manager->db_manager->get('catchmail_return')->insert($param);
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
	 * ユーザへメール送信
	 * @param $userData			ユーザ情報
	 * @param $reserved_name	予約名
	 * @param $store_name		店舗名
	 * @param $mailId			送信するメールID
	 */
	private function sendUserMail($userData, $reserved_name, $store_name, $mailId) {
		$mail = $this->manager->db_manager->get('automail')->findById($mailId);
		//メール用データ
		$mail_data['reserved_name'] = $reserved_name;
		$mail_data['store_name'] = $store_name;
		$mail_data['catchnail_url'] = CATCH_MAIL_URL;
		$mail = create_mail_data($mail,$mail_data);
		$mail['to'] = $userData['email'];
		$this->manager->mailer->setMailData($mail);
		$this->manager->mailer->sendMail();
	}
}