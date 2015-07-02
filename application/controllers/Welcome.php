<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		
	}
	
	public function index() {
		
		echo "hello!world";
		
		
		
	}
	
	
}