<?php
/**
 * コース管理画面TOP
 *
 */
include_once dirname(__FILE__).'/../common/MaintenancePage.php';

class CoursePage extends MaintenancePage{

	protected $id = 0;/* ID */
	protected $use_table   = 'course';
	protected $session_key = 'course';
	protected $use_confirm = true;
	protected $page_title = 'コース管理';

}