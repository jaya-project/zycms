<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dog {
	
	public function checkIP() {
		$black_list = include (APPPATH . '/config/black_list.php') ;
		if (in_array($_SERVER['REMOTE_ADDR'], $black_list)) {
			header('content-type:text/html; charset=utf-8');
			die('您的IP已经被该管理员禁用');
		}
	}
	
	
}
