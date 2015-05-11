<?php
/**
 *
 */
class SystemMsgModel extends MsgModel
{


	public function __construct()
	{
		$message = array(
			'edit_error'           => '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><i class="halflings-icon info-sign"></i> 入力内容に誤りがあります。</div>',
			'update_comp'          => '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button><i class="halflings-icon info-sign"></i> 更新が完了いたしました。</div>',
			'insert_comp'          => '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button><i class="halflings-icon info-sign"></i> 登録が完了いたしました。</div>',
			'delete_comp'          => '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button><i class="halflings-icon info-sign"></i> 削除が完了いたしました。</div>',
			'login_error'          => '<div class="alert alert-danger">ログインに失敗しました。</div>',
		);
		$this->setMessages($message);
	}
}