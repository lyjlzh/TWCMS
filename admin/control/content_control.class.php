<?php
/**
 * (C)2012-2013 twcms.cn TongWang Inc.
 * Author: wuzhaohuan <kongphp@gmail.com>
 */

defined('TWCMS_PATH') or exit;

class content_control extends admin_control {
	// 内容管理
	public function index() {
		// hook admin_content_control_index_end.php
		$this->display();
	}

	//hook admin_content_control_after.php
}
