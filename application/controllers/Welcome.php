<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {

		$this->load->library('api');
		$condition['test'] = $this->api->get_channel_field_default_value(1, 'test');
		
		print_r($condition);
	}
	
	public function test() {
		$this->load->library('api');
		$article = $this->api->get_article(1);
		print_r($this->api->keywords_replace($article['body']));
	}
	
	public function articles()
	{
		$articles = $this->api->get_articles(19);
		$pages = $this->api->get_pages(19);
		print_r($pages);
		print_r($articles);
	}
}
