<?php
/**
 * フロントのエラー（SP用）
 */
class Front_spMsgModel extends MsgModel
{


	public function __construct()
	{
		$message = array(
			'login_error'          => '<div class="alert alert-danger">ログインに失敗しました。</div>',
			'edit_error'           => '<div class="alert alert-danger">入力内容に誤りがあります</div>',
			'update_comp'          => '<div class="alert alert-success">更新しました</div>',
			'point_error'          => '<div class="alert alert-danger">保有しているポイント以上を利用しての予約はできません</div>',
		);
		$this->setMessages($message);
	}
}