<?php
/**
 * アカウント管理
 *
 */
include_once(dirname(__FILE__) . '/../common/AdminPage.php');

class ProfilePage extends AdminPage {
	
	protected $id = 0;/* ID */
	protected $use_table   = 'account';
	protected $session_key = 'account';
	protected $use_confirm = false;
	protected $page_title = 'プロフィール';
	
	protected function indexAction() {
		$this->view = array('index'       =>'admin/profile/index');
		$data = array();
		$post = array();
		$error = array();
		$account = $this->getAccount();
		$system_message = $this->getSystemMessage();
		$this->unsetSystemMessage();
		
		if ($account == NULL) {
			redirect('login.html');
		}
		
		$this->id = $account['account_id'];
		if (getPost('m') == 'profile') {
			$post = $_POST;
			if ($this->validation($post)) {
				
				$upd_data['account_name']    = getPost('account_name');
				$upd_data['login_id']        = getPost('login_id');
				$upd_data['login_password']  = encodePassword(getPost('login_password'));
				$upd_data['permission_kind'] = getPost('permission_kind');
				$upd_data['status_id']       = getPost('status_id');
				
				
				$this->update_action($upd_data);
				
				$account = $this->manager->db_manager->get($this->use_table)->findById($account['account_id']);
				$this->setAccount($account);
				$this->setSystemMessage($this->manager->message->get('system')->getMessage('update_comp'));
				
				redirect('profile.php');
			}
			$system_message = $this->manager->message->get('system')->getMessage('edit_error');
			$error = $this->getValidationError();
		} else {
			$post = $this->manager->db_manager->get($this->use_table)->findById($this->id);
			$post = $this->dbToInputData($post);
		}
		
		$data['login_id'] = $account['login_id'];
		$data['post'] = escapeHtml($post);
		$data['error'] = $error;
		$data['page_title'] = $this->page_title;
		$data['page_type_text'] = '';
		$data['system_message'] = $system_message;
		$this->loadView('index', $data);
	}
	
	/**
	 * ＤＢデータから入力用データへ変換
	 * 
	 * @param array $data 変換元データ
	 * @return array 変換後データ
	 */
	protected function dbToInputData($data) {
		$data['login_password'] = decodePassword($data['login_password']);
		return $data;
	}
	
	/**
	 * 入力チェック
	 * 
	 */
	protected function validation($param) {
		$param['account_id'] = $this->id;

		$this->manager->validation->setRule('account_name','required');
		$this->manager->validation->setRule('login_id','required|password:6:12|duplicate_id');

		if($this->id == ''){
			$this->manager->validation->setRule('login_password','required|password:4:8');
		}else{
			$this->manager->validation->setRule('login_password','password:4:8');
		}
		return $this->manager->validation->run($param);
	}
}

/**
 * ログインID重複チェック
 *
 */
function duplicate_id($key,$data){

	if(!isset($data[$key]) || $data[$key] == ''){
		return true;
	}
	$login_id =$data[$key];
	$manager = Management::getInstance();
	//ＩＤが存在する場合
	if($res = $manager->db_manager->get('account')->findByLoginId($login_id)){

		//自分自身だった場合
		if($res['account_id'] == getParam($data,'account_id')){
			return true;
		}
		return false;
	}

	return true;
}