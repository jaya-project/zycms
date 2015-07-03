<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		
	}
	
	public function index() {
		
		$this->header_template = '';
		
		$this->footer_template = '';
		
		
		
		print_r($this->api->get_prev_next(4));
		
		echo $this->api->get_bread(6, 'detail', ' >> ');die;
		
		$this->view('welcome-index');
		
		
		
	}
	
	
}