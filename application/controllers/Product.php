<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {
		$this->load->helper('url');
		
		$data['products'] = $this->api->get_articles(1);
		
		
		foreach ($data['products'] as $k=>$v) {
			echo '<a href="'.build_url($v['id'], $v['cid'], 3).'">'.$v['title'].'</a>';
		}
		
		
	}
	
	public function category($cid) 
	{
		$data['articles'] = $this->api->get_articles($cid);
		
		print_r($data);
	}
	
	
}