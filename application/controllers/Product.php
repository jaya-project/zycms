<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {
		
		$data['products'] = $this->api->get_articles(11);
		
		$data['columns'] = $this->api->get_columns(11);
		
		foreach ($data['columns']['children'] as $k=>$v) {
			echo '<a href="'.site_url('product/category/'.$v['id']).'">'.$v['column_name'].'</a>';
		}
		
		
	}
	
	public function category($cid) 
	{
		$data['articles'] = $this->api->get_articles($cid);
		
		print_r($data);
	}
	
	
}