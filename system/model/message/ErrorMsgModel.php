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
			'tel'            => '電話番号の形式が正しくありません',

			//ここから下はサイト独自のチェック
			'duplicate_user_nickname' => '既に登録されています',
			'duplicate_user_email' 		=> '既に登録されています',
			'duplicate_email'			=> '既に登録されています',
			'unvalid_user_email'	=> 'このメールアドレスで登録しているユーザーは見つかりませんでした',
			'duplicate_id' 	 => '既に登録されています',
			'wrongPassword'  => 'パスワードが正しくありません',
			'notSamePassword'=> 'パスワードが一致しません',
			'lessthan'       => '範囲の設定が正しくありません',
			'is_password'    => 'パスワードが一致しません',
			'pw_conf'        => 'パスワードが一致しません',
			'password'       => '%s～%s文字の半角英数字で入力してください。',
			'select_area'    => '選択されていません',
			'strict_select'  => '不正なデータが選択されています',
			'same_email'     => '同一のメールアドレスを入力してください',
			'pdecimal_zero'  => '0以上の小数で入力してください', 
			'this_monthChk'  => '今月以外の日付は設定できません',
			'plus_moneyChk'  => '1以上の整数値を設定してください',
			'zero_moneyChk'  => '0以上の整数値を設定してください',
		);
		$this->setMessages($message);
	}
}