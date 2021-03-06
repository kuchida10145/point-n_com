<?php
/**
 *
 */
class FrontMsgModel extends MsgModel
{


	public function __construct()
	{
		$message = array(
			'login_error'          => '<div class="alert alert-danger">無効なメールアドレスまたはパスワードです。</div>',
			'edit_error'           => '<div class="alert alert-danger">入力内容に誤りがあります</div>',
			'point_error'          => '<div class="alert alert-danger">保有しているポイント以上を利用しての予約はできません</div>',
			'update_comp'          => '<div class="alert alert-success">更新しました</div>',
		);
		$this->setMessages($message);
	}
}