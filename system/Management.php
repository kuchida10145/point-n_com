<?php
/**
 * マネージメントクラス
 */
register_shutdown_function( 'my_shutdown_handler' );
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/core/DatabaseManager.php');
require_once(dirname(__FILE__).'/custom/core/Message.php');
require_once(dirname(__FILE__).'/custom/core/Validation.php');
require_once(dirname(__FILE__).'/custom/core/Device.php');
require_once(dirname(__FILE__).'/custom/core/Session.php');
require_once(dirname(__FILE__).'/custom/core/Image.php');
require_once(dirname(__FILE__).'/custom/core/View.php');
require_once(dirname(__FILE__).'/custom/core/Pager.php');
require_once(dirname(__FILE__).'/custom/core/Token.php');
require_once(dirname(__FILE__).'/custom/core/Mailer.php');
require_once(dirname(__FILE__).'/custom/core/Router.php');
require_once(dirname(__FILE__).'/helper/Util.php');
require_once(dirname(__FILE__).'/helper/Form.php');

class Management
{
	/** @var DatabaseManager */
	public $db_manager;
	/** @var Validation */
	public $validation;
	/** @var Session */
	public $session;
	/** @var Device */
	public $device;
	/** @var View */
	public $view;
	/** @var Message */
	public $message;
	/** @var Mailer */
	public $mailer;
	/** @var Pager */
	public $pager;
	/** @var Token */
	public $token;
	/** @var Image */
	public $image;
	/** @var Router */
	public $router;


	/**
	 * コンストラクタ(プライベート)
	 */
	private function __construct()
	{
		$this->db_manager = new DatabaseManager();
		$this->validation = new Validation();
		$this->session    = new Session();
		$this->device     = new Device();
		$this->view       = new View();
		$this->message    = new Message();
		$this->mailer     = new Mailer();
		$this->pager      = new Pager();
		$this->token      = new Token();
		$this->image      = new Image();
		$this->router     = new Router();
	}

	/**
	 * Singleton化
	 *
	 * @return Management マネジャー
	 */
	public static function getInstance()
	{
		static $_instance;
		if($_instance === NULL)
		{
			$_instance = new Management();
		}

		return $_instance;
	}


	/**
	 * Helperディレクトリのヘルパーを追加
	 *
	 * @param mixed $helper 追加するクラスの名前
	 */
	public function setHelper($helper=array())
	{

		if(is_array($helper))
		{
			foreach($helper as $help)
			{
				$this->_loadHelper($help);
			}
		}
		else
		{
			$this->_loadHelper($helper);
		}
	}

	/**
	 * ヘルパーを読み込み
	 *
	 * @param String $helper 読み込むヘルパー名
	 */
	private function _loadHelper($helper)
	{
		$helper      = ucwords($helper);
		$helper_file = dirname(__FILE__).'/custom/helper/'.$helper.'.php';

		if(file_exists($helper_file))
		{
			require_once($helper_file);
		}
		else
		{
			exit('Helper:'.$helper.' file is not exists!');
		}

		return true;
	}

	/**
	 * Coreディレクトリのクラスを追加
	 *
	 * @param mixed $core 追加するクラスの名前
	 */
	public function setCore($core = array())
	{
		if(is_array($core))
		{
			foreach($core as $c)
			{
				$this->_loadCore($c);
			}
		}
		else
		{
			$this->_loadCore($core);
		}

	}

	/**
	 * クラスのロード
	 *
	 * @param String $core 追加するクラスの名前
	 */
	private function _loadCore($core)
	{
		$core_name = ucwords($core);
		$core_file= dirname(__FILE__).'/custom/core/'.$core_name.'.php';


		if(!isset($this->{$core}))
		{
			if(file_exists($core_file))
			{
				require_once($core_file);
				$this->{$core} = new $core_name();
			}
			else
			{
				exit('Core:'.$core.' file is not exits!');
			}
		}
		return true;
	}
}



function my_shutdown_handler(){
    $obj = Management::getInstance();
	$obj->db_manager->db->endTran(false);//開
}