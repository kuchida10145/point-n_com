<?php
/**
 *
 */
class ErrorMsgModel extends MsgModel
{


	public function __construct()
	{
		$message = array(
			//ここから下は共通のチェック
			'required'       => '入力されていません',
			'required_file'  => 'ファイルが選択されていません',
			'selected'       => '選択されていません',
			'checked'        => '選択されていません',
			'email'          => 'メールアドレスの形式が正しくありません',
			'email_duble'    => 'メールアドレスが一致しません',
			'dateformat'     => '日付の形式が正しくありません',
			'datetimeformat' => '日付の形式が正しくありません',
			'realdate'       => '日付が正しくありません',
			'katakana'       => '全角カナで入力してください',
			'hirakana'       => 'ひらがなで入力してください',
			'postcode'       => '郵便番号の形式が正しくありません',
			'numeric'        => '半角数字で入力してください',
			'digit'          => '整数で入力してください',
			'pnumeric'       => '正数で入力してください',
			'alphanumeric'   => '半角英数字で入力してください',
			'outstring'      => '機種依存文字が含まれています',
			'range'          => '%s～%s文字%sで入力してください',
			'length'         => '%s字で入力してください',
			'maxlength'      => '%s字以内で入力してください',
			'phonenumber'    => '半角、ハイフン「-」なしの10～11桁で入力してください',
			'olddate'        => '過去の日時は設定できません',


			//ここから下はサイト独自のチェック
			'duplicate_id'   => '既に登録されています',
			'duplicate_email'=> '既に登録されています',
			'lessthan'       => '範囲の設定が正しくありません',
			'is_password'    => 'パスワードが一致しません',
			'pw_conf'        => 'パスワードが一致しません',
			'password'       => '%s～%s文字の半角英数字で入力してください。',
			'select_area'    => '選択されていません',
			'strict_select'  => '不正なデータが選択されています',
		);
		$this->setMessages($message);
	}
}