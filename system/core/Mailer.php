<?php
/**
 * メール送信クラス
 */
include_once(dirname(__FILE__).'/../plugin/phpmailer/jphpmailer.php');
class Base_Mailer{


	protected $subject    = '';
	protected $body       = '';
	protected $from       = '';
	protected $to         = '';
	protected $return_path = '';
	protected $mode       = 'text';	//text,html
	protected $from_name   = '';
	protected $charset    = "utf-8";
	protected $qdmail = NULL;


	/**
	 * コンストラクタ
	 */
	function __construct()
	{
		$this->qdmail = new JPHPMailer();
	}

	/**
	 * メールデータを設定する
	 *
	 * @param Array $data 設定する配列
	 */
	public function setMailData($data = array())
	{

		if(isset($data['subject']))     $this->setSubject($data['subject']);
		if(isset($data['body']))        $this->setBody($data['body']);
		if(isset($data['from_mail']))   $this->setFromMail($data['from_mail']);
		if(isset($data['from_name']))   $this->setFromName($data['from_name']);
		if(isset($data['to']))          $this->setTo($data['to']);
		if(isset($data['return_path'])) $this->setReturnPath($data['return_path']);
		if(isset($data['charset']))     $this->setCharSet($data['charset']);
		if(isset($data['mode']))        $this->setMode($data['mode']);
	}





	/**
	 * エラー情報を取得する
	 *
	 * @return string
	 */
	public function getError()
	{
		return $this->qdmail->ErrorInfo;
	}

	/**
	 * メールの送信
	 */
	public function sendMail()
	{
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');

		//$this->qdmail->errorDisplay( false );
		$this->qdmail->addTo($this->to);
		$this->qdmail->setSubject($this->subject);
		$this->qdmail->setBody($this->body);
		$this->qdmail->setFrom($this->from,$this->from_name);

		if($this->mode == 'html')
		{
			$this->qdmail->isHTML(true);
		}


		if($this->return_path != "")
		{
			//$this->qdmail->mtaOption('-f '.$this->return_path);
			$this->qdmail->Sender = $this->return_path;
		}

		//ローカルはログ掃出し
		if(HTTP_HOST == 'http://localhost/sixpence_frame'){
			$log = "to:".$this->to."\r\n";
			$log.= $this->body."\r\n\r\n-------------------\r\n\r\n";


			$handle = fopen( ROOT_DIR."maillog/".date('YmdHis').".txt", 'a');
			fwrite( $handle, $log);
			fclose( $handle );
		}

		if(!$this->qdmail->send())
		{
			//$this->qdmail->reset();
			$this->qdmail->ClearAddresses();
			return false;
		}
		$this->qdmail->ClearAddresses();
		return true;
	}

	/**
	 * 送信モードの設定
	 *
	 * @param String $mode 送信モード
	 */
	public function setMode($mode)
	{
		$this->mode = $mode;
	}


	/**
	 * 文字コードの設定
	 *
	 * @param String $charset 文字コード
	 */
	public function setCharSet($charset)
	{
		$this->charset = $charset;
	}

	/**
	 * 件名の設定
	 * @param String $subject 件名
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	/**
	 * 本文の設定
	 *
	 * @param String $body 本文
	 */
	public function setBody($body)
	{
		$this->body = $body;
	}

	/**
	 * 送信元メールアドレスの設定
	 *
	 * @param String $from 送信元メールアドレス
	 */
	public function setFromMail($from)
	{
		$this->from = $from;
	}

	/**
	 * 送信者名の設定
	 *
	 * @param Sting $from_name 送信者名
	 */
	public function setFromName($from_name)
	{
		$this->from_name = $from_name;
	}

	/**
	 * 送信先メールアドレスの設定
	 *
	 * @param String $to 送信先メールアドレス
	 */
	public function setTo($to)
	{
		$this->to = $to;
	}


	/**
	 * エラーメールの送信先を設定
	 *
	 * @param String $returnPath
	 */
	public function setReturnPath($return_path)
	{
		$this->return_path = $return_path;
	}


}
?>