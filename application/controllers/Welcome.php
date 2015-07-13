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
		
		$this->load->library('Api');
		
		$result = $this->api->get_bread(7, 'single');

		
		print_r($result);
		
		$this->view('welcome-index', array('test'=>1));
		
		
		
	}
	
	
}