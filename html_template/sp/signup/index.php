<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザー新規仮登録｜ポイント.com</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php include_once dirname(__FILE__).'/../common/header_meta.php';?>
</head>
<body id="register">
<!--全体-->
<div id="wrap">
<a name="top" id="top"></a>


<!--ヘッダ-->
<?php include_once dirname(__FILE__).'/../common/header_contents.php';?>
<!--ヘッダ-->
<!--メイン全体-->
<div id="mainbodywrap">
<!--ページメイン部分-->
<div id="mainbody" class="clearfix">

<div class="titlebox">
<h2>ユーザー新規仮登録</h2>
</div>
<!--コンテンツ-->
<div class="contents">
<p>ユーザー利用規約に同意頂き登録するメールアドレスを入力してください。折り返し仮登録完了メールが届きます。仮登録完了メールにあるURLにアクセスしますと、ユーザー登録画面へ進みます。<br />
<span class="clrred">※ドメイン指定受信している方は【 point-n.com 】を指定解除してください。</span></p>
<h3>メールアドレス(半角)</h3>
<form method="post" action="" name="frm">
<input type="hidden" name="m" value="signup" />
<p>
<input type="text" name="email" id="email" style="width:95%;" value="<?php echo getParam($post, 'email');?>" />
<?php echo getParam($error, 'email'); ?>
</p>

<h2>利用規約</h2>
<h3>第1条（ポイントドットコムに関し）</h3>
<ol>
	<li>本サービスとは、「ポイントドットコム」を通じた、インターネット上の広告情報サービス及び、それに関連するサービスの総称です。</li>
	<li>ユーザーとは、本サービスを利用するすべての方をいいます。</li>
</ol>

<h3>第2条（禁止事項）</h3>
<p>ユーザーは、以下の行為を行うことを禁止します。</p>
<ol>
	<li>18歳未満の者が利用する行為（高校生を含む）</li>
	<li>虚偽の情報を登録する行為</li>
	<li>公序良俗・法令・条例等に反する行為</li>
	<li>社会常識・通念を逸脱した行為</li>
	<li>当社、他のユーザー・店舗・代理店及び第三者の財産権（特許権、商標権、著作権等のあらゆる知的財産権を含む）またはプライバシーに関する権利等、あらゆる法的権利を侵害する行為</li>
	<li>当社、他のユーザー・店舗・代理店及び第三者を誹謗中傷する行為</li>
	<li>来店の意思がないにも関わらずクーポンコードの発行を申請する行為</li>
	<li>本サービスの運営、当社の経営を妨げる恐れのある一切の行為</li>
	<li>本サービスで使用するアカウント及び取得したポイントの売却、賃借、質入れ等の一切の行為</li>
	<li>その他、当社が不適切と判断する一切の行為</li>
</ol>

<h3>第3条（情報の削除）</h3>
<p>当社は、第2条に規定された行為とみなされる情報が登録される又は登録情報を削除する必要があると判断した場合、ユーザーに通知することなく、当該情報を削除することができます。</p>

<h3>第4条（サービスの変更）</h3>
<p>当社は、事前の通知なくユーザー向けサービスを変更または一時的に中断をすることがありますが、ユーザーはそれに対して異議を申し立てないものとします。</p>

<h3>第5条（ポイントの取得・期限)</h3>
<ol>
	<li>ユーザーがポイントを取得するためには原則本サービスを利用し、クーポンを店舗に伝え、店舗が認証した場合に予定ポイントが付与されます。</li>
	<li>ポイントの付与は、店舗がお客様来店後24時間以内に適切に行いますが、なんらかの理由で付与されなくても、当社は一切の責任を負いません。それについて異議申し立てできないものとします。</li>
	<li>ポイントの有効期間は最後の取得日より1年と致します。</li>
	<li>ポイントの失効1ヶ月前に確認メールを送りますが届かなかった場合でもユーザーは失効に対し異議を申し立てないものとします。</li>
	<li>メールアドレスの変更はできませんので、ポイントが残っている場合はポイントを償却後、新しいアカウントの登録を行ってください。残ポイント分の返金やポイントの移行は一切できませんのでご了承下さい。</li>
</ol>

<h3>第6条（情報の公開）</h3>
<ol>
	<li>ユーザー情報は会員番号およびニックネームを省き原則公開は致しません。ただし捜査機関、所轄公官庁の照会、裁判所の令状がある場合を省きます。</li>
	<li>会員番号およびニックネームは公開情報とし、店舗が利用履歴を閲覧する際に見れることとします。</li>
</ol>

<h3>第7条（ポイントの利用）</h3>
<ol>
	<li>1.	ポイントを利用する際は、ポイントドットコムサイト加盟店にて、1Pで1円相当の割引利用とします。</li>
    <li>一度に利用できるポイントの単位は、20,000PTまで原則1,000PT単位とし、上限は50,000PTとします。</li>
</ol>

<h3>第8条（免責）</h3>
<ol>
	<li>本サービスは、情報内容の正確性、有用性等について何らの保証をしないものとします。</li>
	<li>当社は、ユーザーが本サービスを利用することにより発生する一切の損害に対し、何らの責任も負担しないものとします。</li>
	<li>当社は本サービスの中断や停止、内容の変更や追加によってユーザーが受けた損害に関して、何ら責任も負わないものとします。</li>
</ol>

<h3>第9条（規約の変更）</h3>
<p>当社は、ユーザーの承諾を得ることなく、本規約を随時変更することができます。変更の内容は、本サービスに掲載し、その掲載をもって、すべてのユーザーが了承したものとみなします。</p>

<h3>第10条（損害賠償）</h3>
<p>ユーザーが本規約に違反し、当社または第三者に対し損害を与えた場合、ユーザーは、当社または第三者に対し、損害賠償義務を負担します。</p>

<h3>第11条（管轄裁判所）</h3>
<p>本規約に関する紛争については、名古屋地方裁判所を第一審の管轄裁判所とします。</p>

<p align="right">制定日：2015年1月1日</p>

<p class="alncenter">
<input type="checkbox" name="contract" id="contract"<?php echo getParam($post, 'contract') != '' ? ' checked' : ''; ?> />
<label for="contract">ユーザー利用規約に同意</label>
<?php echo getParam($error, 'contract'); ?>
</p>

<p><a href="javascript:void(0);" onclick="document.frm.submit();" class="linkbtn block alncenter">送信する</a></p>
</form>



</div>
<!--/コンテンツ-->

<div id="footer">
<address>
Copyright 2015 POINT.COM All Rights Reserved
</address>
</div>

</div>
<!--/ページメイン部分-->
</div>
<!--/メイン全体-->


</div>

<!--/全体-->

<!--スライド-->
<?php include_once dirname(__FILE__).'/../common/slide_contents.php';?>
<!-- /スライド-->


</body>
</html>
