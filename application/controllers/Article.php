<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
        $this->load->library('unit_test');
		
	}
	
	public function index() {


        echo $this->unit->run('123','is_array', "test");
		
		
		
		
	}
	
	public function category($cid, $page, $page_length) 
	{
		$data['articles'] = $this->api->get_articles($cid, '', $page, $page_length);
		
		print_r($data);
	}
	
	public function detail($aid) {
		echo $aid;
	}
	
}
