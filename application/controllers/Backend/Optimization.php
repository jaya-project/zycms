<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  广告位控制器
 */
class Ad extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(['session']);
		$this->load->helper(['array', 'url']);
		
	}
	
	public function submit_to_sg()
	{
		
	}
	
}