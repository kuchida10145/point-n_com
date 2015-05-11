<?php
include_once dirname(__FILE__).'/system/Management.php';


$manager = Management::getInstance();

print encodePassword('test');