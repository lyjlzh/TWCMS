<?php
// +------------------------------------------------------------------------------
// | Copyright (C) 2013 wuzhaohuan <kongphp@gmail.com> All rights reserved.
// +------------------------------------------------------------------------------

class log {
	/**
	 * 写入日志
	 * @param string $s 写入字符串
	 * @param string $file 保存文件名
	 * @return boot
	 */
	public static function write($s, $file = 'php_error.php') {
		$time = date('Y-m-d H:i:s');
		$ip = $_SERVER['_ip'];
		$url = self::to_str($_SERVER['REQUEST_URI']);
		$s = self::to_str($s);
		self::write_log('<?php exit;?>'."	$time	$ip	$url	$s	\r\n", $file);
		return TRUE;
	}

	/**
	 * 清理空白字符
	 * @param string $s 字符串
	 * @return string
	 */
	public static function to_str($s) {
		return str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $s);
	}

	/**
	 * 文件末尾写入日志
	 * @param string $s 写入字符串
	 * @param string $file 保存文件名
	 * @return boot
	 */
	public static function write_log($s, $file) {
		$logfile = RUNTIME_PATH.'logs/'.$file;
		try{
			$fp = fopen($logfile, 'ab+');
			if(!$fp) {
				throw new Exception('写入日志失败，可能文件'.$logfile.'不可写或磁盘已满。');
			}
			fwrite($fp, $s);
			fclose($fp);
		}catch(Exception $e) {}
		return TRUE;
	}

	/**
	 * 跟踪调试
	 * @param string $s 描述
	 * @return void
	 */
	public static function trace($s) {
		if(!DEBUG) return;
		empty($_SERVER['_trace']) && $_SERVER['_trace'] = '';
		$_SERVER['_trace'] .= $s.' - '.number_format(microtime(1) - $_SERVER['_start_time'], 4)."\r\n";
	}

	/**
	 * 保存 trace
	 * @param string $file 保存文件名
	 * @return void
	 */
	public static function trace_save($file = 'php_trace.php') {
		if(empty($_SERVER['_trace'])) return;
		$s = "\r\n\r\n<?php exit;?>\r\n========================================================================\r\n";
		$s .= $_SERVER['REQUEST_URI']."\r\nPOST:".print_r($_POST, 1)."\r\nSQL:".print_r($_SERVER['_sqls'], 1)."\r\n";
		$s .= $_SERVER['_trace'];
		self::write_log($s, $file);
	}
}
?>