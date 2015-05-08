/*
===========================================================
フォントサイズ変更スクリプト（タイプC）

Last Updated:09/21/2001

insomnia!Web Labo.
http://www3.airnet.ne.jp/insomnia/
http://www3.airnet.ne.jp/insomnia/labo/fsc/fscC.html
===========================================================
*/

/*
========== ::: 初期設定 ::: ==========
*/

// 値の単位を設定（必ずダブルクオートかクオートで括る）
var fontSizeUnit = "%";

// 一回の操作で変化させる値を設定（ダブルクオートやクオートで括らない）
var perOrder = 10;

// 初期状態の値を設定（ダブルクオートやクオートで括らない）
var defaultSize = 100;

// クッキーの名前（必ずダブルクオートかクオートで括る）
var ckName = "FSC";

// クッキーの有効期限（日）（ダブルクオートやクオートで括らない）
var ckDays = 2;

// クッキーのパス（必ずダブルクオートかクオートで括る。指定が不要の場合は"/"にする）
var ckPath = "/"


/*
========== ::: ページ読み込み時の値を設定 ::: ==========
*/

// クッキー読み出し
var fsCK = GetCookie( ckName );

if ( fsCK == null ){
  var currentSize = defaultSize;          //クッキーが無ければ現在の値を初期状態の値に設定
}
else{
  var currentSize = eval( fsCK );          //クッキーがあれば現在の値をクッキーの値に設定
}


/*
========== ::: head内にstyle要素を出力 ::: ==========
*/
document.writeln( '<style type="text/css">' );
document.write( '#mainbodywrap{font-size:' + currentSize + fontSizeUnit+ '}' );
document.writeln( '</style>' );


/*===================================
  [関数 fsc]
  引数CMDに渡される値に応じて
  変更後の値を算出しクッキーに書き込む。
====================================*/

function fsc( CMD ){

  // 拡大：現時点の値に一回の操作で変化させる値を加えて操作後の値"newSize"に代入
  if ( CMD == "larger" ){
    var newSize = Number( currentSize + perOrder );
    SetCookie( ckName , newSize );          //クッキー書き込み
  }

  // 縮小：現時点の値から一回の操作で変化させる値を引き操作後の値に代入
  // 現時点のサイズの値が一回の操作で変化させる値と同じならそのまま操作後の値に代入
  if ( CMD == "smaller" ){
    if ( currentSize != perOrder ){
      var newSize = Number( currentSize - perOrder );
      SetCookie( ckName , newSize );          //クッキー書き込み
    }
    else{
      var newSize = Number( currentSize );
    }
  }

  // 元に戻す：操作後の値を初期値にする
  if ( CMD == "default" ){
    DeleteCookie( ckName );          //クッキー削除
  }

  // ページの再読み込み
  // 再読み込みをすることで変更後の値を反映したstyle要素が出力される
  location.reload();
}

// _______________________________________ end of function fsc() ___ 


/*===================================
  [関数 SetCookie]
  クッキーに値を書き込む
====================================*/
function SetCookie( name , value ){
  var dobj = new Date();
  dobj.setTime(dobj.getTime() + 24 * 60 * 60 * ckDays * 1000);
  var expiryDate = dobj.toGMTString();
  document.cookie = name + '=' + escape(value) + ';expires=' + expiryDate + ';path=' + ckPath;
}

/*===================================
  [関数 GetCookie]
  クッキーを取得する
====================================*/
function GetCookie (name){
  var arg  = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen){
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg)
    return getCookieVal (j);
    i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0) break;
  }
  return null;
}

/*===================================
  [関数 getCookieVal]
  クッキーの値を抽出する
====================================*/
function getCookieVal (offset){
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
  endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset,endstr));
}

/*===================================
  [関数 DeleteCookie]
  クッキーを削除する
====================================*/
function DeleteCookie(name){
  if (GetCookie(name)){
    document.cookie = name + '=' +
    '; expires=Thu, 01-Jan-70 00:00:01 GMT;path='+ckPath;
  }
}

//EOF