<?php
/**
 *  登录控制器
 *  
 */

class CkfinderValidate extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 *  显示登录界面
	 */
	public function index()
	{
		$this->load->library(array('MyAuth', 'session'));
		if ($this->myauth->is_logged_in()) {
			die(json_encode(array(
				'state' => 'success'
			)));
			return;
		} else {
			die(json_encode(array(
				'state' => 'failed'
			)));
			return;
		}
	}
	
	
}
