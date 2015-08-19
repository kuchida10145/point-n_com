<?php
#!/bin/usr/php

/* 
 * 毎月1日に実行
 */
include_once(dirname(__FILE__).'/../system/Management.php');

$manager = Management::getInstance();

//請求データを生成
$manager->db_manager->get('bill')->addThisMonthBillCron();

//毎月の利用枠を生成
$manager->db_manager->get('add_limit')->addBasePointCron();

//残り利用ポイントを修正
$manager->db_manager->get('store')->pointLimitThisMonthCron();