-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015 年 5 朁E10 日 22:36
-- サーバのバージョン： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `point`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'アカウントID',
  `account_name` varchar(50) NOT NULL COMMENT 'アカウント名',
  `login_id` varchar(20) NOT NULL COMMENT 'ログインID',
  `login_password` varchar(20) DEFAULT NULL COMMENT 'ログインパスワード',
  `permission_kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '権限種類',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'ステータス',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `latest_login_date` datetime DEFAULT NULL COMMENT '最終ログイン日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='アカウント情報' AUTO_INCREMENT=3 ;

--
-- テーブルのデータのダンプ `account`
--

INSERT INTO `account` (`account_id`, `account_name`, `login_id`, `login_password`, `permission_kind`, `status_id`, `regist_date`, `update_date`, `latest_login_date`, `delete_flg`) VALUES
(1, '高橋 <br />', 'testadmin', 'REm0ql7HNzY=', 2, 1, '2015-05-09 00:00:00', '2015-05-10 16:53:13', '2015-05-09 00:00:00', 0),
(2, 'テスト太郎', 'testguest', 'REm0ql7HNzY=', 1, 1, '2015-05-10 00:34:02', '2015-05-10 11:40:37', NULL, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `area_first`
--

CREATE TABLE IF NOT EXISTS `area_first` (
  `area_first_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '第１エリアID',
  `category_large_id` tinyint(4) NOT NULL COMMENT '大カテゴリーID',
  `region_id` tinyint(4) NOT NULL COMMENT '地域ID',
  `prefectures_id` tinyint(4) DEFAULT NULL COMMENT '都道府県ID',
  `area_first_name` varchar(50) DEFAULT NULL COMMENT '第１エリア名',
  `rank` smallint(6) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`area_first_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第１エリアマスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `area_second`
--

CREATE TABLE IF NOT EXISTS `area_second` (
  `area_second_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '第２エリアID',
  `area_first_id` smallint(6) NOT NULL COMMENT '第１エリアID',
  `area_second_name` varchar(50) NOT NULL COMMENT '第２エリア名',
  `delivery` char(1) NOT NULL COMMENT 'デリバリー',
  `rank` smallint(6) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`area_second_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第２エリアマスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `area_third`
--

CREATE TABLE IF NOT EXISTS `area_third` (
  `area_third_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '第３エリアID',
  `area_second_id` smallint(6) NOT NULL COMMENT '第２エリアID',
  `area_third_name` varchar(50) NOT NULL COMMENT '第３エリア名',
  `rank` smallint(6) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`area_third_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第３エリアマスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `autologin_account`
--

CREATE TABLE IF NOT EXISTS `autologin_account` (
  `autologin_account_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自動ログイン管理ID',
  `login_key` varchar(256) NOT NULL COMMENT '鍵',
  `account_id` bigint(20) NOT NULL COMMENT 'アカウントID',
  `limit_date` datetime NOT NULL COMMENT '期限日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`autologin_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自動ログイン管理(管理用)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `autologin_store`
--

CREATE TABLE IF NOT EXISTS `autologin_store` (
  `autologin_store_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自動ログインID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `login_key` varchar(256) NOT NULL COMMENT '鍵',
  `limit_date` datetime NOT NULL COMMENT '期限日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`autologin_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自動ログイン管理(店舗用)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `autologin_user`
--

CREATE TABLE IF NOT EXISTS `autologin_user` (
  `autologin_user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自動ログインユーザーID',
  `login_key` varchar(256) NOT NULL COMMENT '鍵',
  `user_id` bigint(20) NOT NULL COMMENT 'ユーザーID',
  `limit_date` datetime NOT NULL COMMENT '期限日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`autologin_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自動ログインユーザー' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `automail`
--

CREATE TABLE IF NOT EXISTS `automail` (
  `automail_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'メールテンプレートID',
  `name` varchar(256) DEFAULT NULL COMMENT 'メールテンプレート名',
  `subject` varchar(256) NOT NULL COMMENT '件名',
  `from_name` varchar(256) NOT NULL COMMENT '送信者名',
  `from_mail` varchar(256) NOT NULL COMMENT '送信元メールアドレス',
  `return_path` varchar(256) NOT NULL COMMENT 'エラー時の返信先メールアドレス',
  `body` text NOT NULL COMMENT '本文',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`automail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='メールテンプレート' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `bank_account`
--

CREATE TABLE IF NOT EXISTS `bank_account` (
  `bank_account_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '銀行口座ID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `bank_name` varchar(50) NOT NULL COMMENT '銀行名',
  `bank_kind` tinyint(4) NOT NULL COMMENT '銀行口座種類',
  `bank_account_number` varchar(30) NOT NULL COMMENT '銀行口座番号',
  `bank_account_holder` varchar(50) NOT NULL COMMENT '銀行口座名義人',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`bank_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='銀行口座' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `category_large`
--

CREATE TABLE IF NOT EXISTS `category_large` (
  `category_large_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '大カテゴリーID',
  `category_large_name` varchar(50) NOT NULL COMMENT '大カテゴリー名',
  `rank` tinyint(4) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`category_large_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大カテゴリーマスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `category_midium`
--

CREATE TABLE IF NOT EXISTS `category_midium` (
  `category_midium_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '中カテゴリーID',
  `category_large_id` tinyint(4) NOT NULL COMMENT '大カテゴリーID',
  `region_id` tinyint(4) NOT NULL COMMENT '地域ID',
  `category_midium_name` varchar(50) NOT NULL COMMENT '中カテゴリー名',
  `delivery` char(1) NOT NULL DEFAULT '0' COMMENT 'デリバリー',
  `rank` smallint(6) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`category_midium_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='中カテゴリーマスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `category_small`
--

CREATE TABLE IF NOT EXISTS `category_small` (
  `category_small_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '小カテゴリーID',
  `category_midium_id` smallint(6) NOT NULL COMMENT '中カテゴリーID',
  `category_small_name` varchar(50) NOT NULL COMMENT '小カテゴリー名',
  `rank` smallint(6) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`category_small_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小カテゴリーマスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '問合せID',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'ユーザーID',
  `prefectures_id` tinyint(4) NOT NULL COMMENT '都道府県ID',
  `contents` text NOT NULL COMMENT '内容',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='問合せ情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
  `coupon_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'クーポンID',
  `course_id` bigint(20) NOT NULL COMMENT 'コースID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `status_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'ステータス',
  `point_kind` tinyint(4) NOT NULL COMMENT 'ポイント種類',
  `coupon_name` varchar(50) NOT NULL COMMENT 'クーポン名',
  `point` int(11) NOT NULL COMMENT 'ポイント',
  `use_condition` text COMMENT '利用条件',
  `public_start_date` datetime DEFAULT NULL COMMENT '表示開始日時',
  `public_end_date` datetime DEFAULT NULL COMMENT '表示終了日時',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='クーポン情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'コースID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'ステータス',
  `point_kind` tinyint(4) NOT NULL COMMENT 'ポイント種類',
  `course_name` varchar(50) NOT NULL COMMENT 'コース名',
  `minutes` smallint(6) NOT NULL COMMENT '分',
  `price` mediumint(9) NOT NULL DEFAULT '0' COMMENT '料金',
  `use_condition` text COMMENT '利用条件',
  `rank` tinyint(4) DEFAULT NULL COMMENT 'ランク順',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='コース情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `jpbank_account`
--

CREATE TABLE IF NOT EXISTS `jpbank_account` (
  `bank_account_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '銀行口座ID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `jpbank_symbol1` varchar(20) NOT NULL COMMENT 'ゆうちょ銀行の記号1',
  `jpbank_symbol2` varchar(20) NOT NULL COMMENT 'ゆうちょ銀行の記号2',
  `jpbank_account_number` varchar(30) NOT NULL COMMENT 'ゆうちょ銀行の口座番号',
  `jpbank_account_holder` varchar(50) NOT NULL COMMENT 'ゆうちょ銀行の名義人',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`bank_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ゆうちょ銀行口座' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ニュースID',
  `public` tinyint(4) NOT NULL DEFAULT '2' COMMENT '公開',
  `public_start_date` datetime DEFAULT NULL COMMENT '表示開始日時',
  `public_end_date` datetime DEFAULT NULL COMMENT '表示終了日時',
  `display_date` date NOT NULL COMMENT '表示日付',
  `title` varchar(100) NOT NULL COMMENT 'タイトル',
  `image1` varchar(20) DEFAULT NULL COMMENT '画像1',
  `image2` varchar(20) DEFAULT NULL COMMENT '画像2',
  `image3` varchar(20) DEFAULT NULL COMMENT '画像3',
  `body` text NOT NULL COMMENT '本文',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ニュース情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `notice_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'お知らせID',
  `store_id` mediumint(9) DEFAULT NULL COMMENT '店舗ID',
  `public` tinyint(4) NOT NULL DEFAULT '2' COMMENT '公開',
  `public_start_date` datetime DEFAULT NULL COMMENT '表示開始日時',
  `public_end_date` datetime DEFAULT NULL COMMENT '表示終了日時',
  `display_date` date NOT NULL COMMENT '表示日付',
  `title` varchar(100) NOT NULL COMMENT 'タイトル',
  `image1` varchar(20) DEFAULT NULL COMMENT '画像1',
  `image2` varchar(20) DEFAULT NULL COMMENT '画像2',
  `image3` varchar(20) DEFAULT NULL COMMENT '画像3',
  `body` text NOT NULL COMMENT '本文',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='お知らせ情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `prefectures_master`
--

CREATE TABLE IF NOT EXISTS `prefectures_master` (
  `prefectures_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '都道府県ID',
  `region_id` tinyint(4) NOT NULL COMMENT '地域ID',
  `prefectures_name` varchar(50) NOT NULL COMMENT '都道府県名',
  PRIMARY KEY (`prefectures_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='都道府県マスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `region_master`
--

CREATE TABLE IF NOT EXISTS `region_master` (
  `region_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '地域ID',
  `region_name` varchar(50) NOT NULL COMMENT '地域名',
  `rank` tinyint(4) DEFAULT NULL COMMENT 'ランク順',
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地域マスター' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `reserved`
--

CREATE TABLE IF NOT EXISTS `reserved` (
  `reserved_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '予約ID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `user_id` bigint(20) NOT NULL COMMENT 'ユーザーID',
  `coupon_id` bigint(20) DEFAULT NULL COMMENT 'クーポンID',
  `point_code` char(6) DEFAULT NULL COMMENT 'ポイントコード(予約No)',
  `status_id` tinyint(4) NOT NULL COMMENT 'ステータス',
  `course_name` varchar(50) DEFAULT NULL COMMENT 'コース名',
  `coupon_name` varchar(50) DEFAULT NULL COMMENT 'クーポン名',
  `minutes` smallint(6) DEFAULT NULL COMMENT '分',
  `price` mediumint(9) DEFAULT NULL COMMENT '料金',
  `use_condition` text COMMENT '利用条件',
  `reserved_date` datetime DEFAULT NULL COMMENT '予約日時',
  `use_persons` tinyint(4) DEFAULT NULL COMMENT '利用人数',
  `use_date` datetime DEFAULT NULL COMMENT '利用日時',
  `reserved_name` varchar(50) DEFAULT NULL COMMENT '予約名',
  `telephone` varchar(15) DEFAULT NULL COMMENT '電話番号',
  `total_price` int(11) DEFAULT NULL COMMENT '支払い合計',
  `use_point` int(11) NOT NULL DEFAULT '0' COMMENT '利用ポイント',
  `get_point` int(11) NOT NULL COMMENT '取得ポイント',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`reserved_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='予約情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `store_id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '店舗ID',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'ステータス',
  `store_name` varchar(50) NOT NULL COMMENT '店舗名',
  `new_arrival` tinyint(4) NOT NULL COMMENT '新着',
  `type_of_industry_id` tinyint(4) NOT NULL COMMENT '業種ID',
  `license` varchar(20) NOT NULL COMMENT '営業許可証',
  `account_name` varchar(50) NOT NULL COMMENT 'アカウント名',
  `login_id` varchar(20) NOT NULL COMMENT 'ログインID',
  `login_password` varchar(20) NOT NULL COMMENT 'ログインパスワード',
  `category_large_id` tinyint(4) NOT NULL COMMENT '大カテゴリーID',
  `category_midium_id` smallint(6) NOT NULL COMMENT '中カテゴリーID',
  `category_small_id` smallint(6) NOT NULL COMMENT '小カテゴリーID',
  `area_first_id` smallint(6) NOT NULL COMMENT '第１エリアID',
  `area_second_id` smallint(6) NOT NULL COMMENT '第２エリアID',
  `area_third_id` smallint(6) NOT NULL COMMENT '第３エリアID',
  `image1` varchar(20) DEFAULT NULL COMMENT '画像1',
  `image2` varchar(20) DEFAULT NULL COMMENT '画像2',
  `image3` varchar(20) DEFAULT NULL COMMENT '画像3',
  `image4` varchar(20) DEFAULT NULL COMMENT '画像4',
  `image5` varchar(20) DEFAULT NULL COMMENT '画像5',
  `image6` varchar(20) DEFAULT NULL COMMENT '画像6',
  `image7` varchar(20) DEFAULT NULL COMMENT '画像7',
  `image8` varchar(20) DEFAULT NULL COMMENT '画像8',
  `image9` varchar(20) DEFAULT NULL COMMENT '画像9',
  `introduction` text COMMENT '紹介文',
  `latitude` double NOT NULL COMMENT '緯度',
  `longitude` double NOT NULL COMMENT '経度',
  `zip_code` varchar(7) NOT NULL COMMENT '郵便番号',
  `prefectures_id` tinyint(4) NOT NULL COMMENT '都道府県ID',
  `address1` varchar(100) NOT NULL COMMENT '市区町村番地',
  `address2` varchar(100) DEFAULT NULL COMMENT 'マンション／ビル名',
  `business_hours` varchar(50) NOT NULL COMMENT '営業時間',
  `telephone` varchar(15) NOT NULL COMMENT '電話番号',
  `holiday` varchar(50) DEFAULT NULL COMMENT '休日',
  `url_outside1` varchar(256) DEFAULT NULL COMMENT '外部サイト1',
  `url_outside2` varchar(256) DEFAULT NULL COMMENT '外部サイト2',
  `url_official1` varchar(256) DEFAULT NULL COMMENT '公式サイト1',
  `url_official2` varchar(256) DEFAULT NULL COMMENT '公式サイト2',
  `url_official3` varchar(256) DEFAULT NULL COMMENT '公式サイト3',
  `representative_sei` varchar(30) NOT NULL COMMENT '担当者の姓',
  `representative_mei` varchar(30) NOT NULL COMMENT '担当者の名',
  `representative_email` varchar(256) NOT NULL COMMENT '担当者メールアドレス',
  `reserved_email` varchar(256) NOT NULL COMMENT '予約受信メールアドレス',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `latest_login_date` datetime DEFAULT NULL COMMENT '最終ログイン日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='店舗情報' AUTO_INCREMENT=2 ;

--
-- テーブルのデータのダンプ `store`
--

INSERT INTO `store` (`store_id`, `status_id`, `store_name`, `new_arrival`, `type_of_industry_id`, `license`, `account_name`, `login_id`, `login_password`, `category_large_id`, `category_midium_id`, `category_small_id`, `area_first_id`, `area_second_id`, `area_third_id`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`, `image7`, `image8`, `image9`, `introduction`, `latitude`, `longitude`, `zip_code`, `prefectures_id`, `address1`, `address2`, `business_hours`, `telephone`, `holiday`, `url_outside1`, `url_outside2`, `url_official1`, `url_official2`, `url_official3`, `representative_sei`, `representative_mei`, `representative_email`, `reserved_email`, `regist_date`, `update_date`, `latest_login_date`, `delete_flg`) VALUES
(1, 1, 'テスト店舗', 0, 0, '', 'テスト店舗', 'teststore', 'REm0ql7HNzY=', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', 0, '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `temp_image`
--

CREATE TABLE IF NOT EXISTS `temp_image` (
  `temp_image_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '一時画像ID',
  `file_name` varchar(20) NOT NULL COMMENT 'ファイル名',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`temp_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='一時画像' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID',
  `nickname` varchar(30) NOT NULL COMMENT 'ニックネーム',
  `email` varchar(256) NOT NULL COMMENT 'メールアドレス',
  `birthday` date NOT NULL COMMENT '生年月日',
  `gender` tinyint(1) NOT NULL COMMENT '性別',
  `prefectures_id` tinyint(4) NOT NULL COMMENT '都道府県ID',
  `password` varchar(20) NOT NULL COMMENT 'パスワード',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '保持ポイント数',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'ステータス',
  `latest_login_date` datetime DEFAULT NULL COMMENT '最終ログイン日時',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ユーザー情報' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_favorite_store`
--

CREATE TABLE IF NOT EXISTS `user_favorite_store` (
  `favorite_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーお気に入りID',
  `user_id` bigint(20) NOT NULL COMMENT 'ユーザーID',
  `store_id` mediumint(9) NOT NULL COMMENT '店舗ID',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`favorite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ユーザーお気に入り店舗' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_hash`
--

CREATE TABLE IF NOT EXISTS `user_hash` (
  `user_hash_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーハッシュID',
  `hash` varchar(256) NOT NULL COMMENT 'ハッシュ',
  `hash_type` tinyint(4) NOT NULL COMMENT 'ハッシュタイプ',
  `user_id` bigint(20) NOT NULL COMMENT 'ユーザーID',
  `limit_date` datetime DEFAULT NULL COMMENT '期限日時',
  `regist_date` datetime NOT NULL COMMENT '登録日時',
  `update_date` datetime NOT NULL COMMENT '変更日時',
  `delete_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`user_hash_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ユーザーハッシュ' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
