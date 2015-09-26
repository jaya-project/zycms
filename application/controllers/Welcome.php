<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {

		echo "hello!zycms";
		
		echo '<br /><a href="/welcome/test">关键词替换测试</a>';
		
		echo '<br /><a href="/welcome/articles">文章延迟发布测试</a>';
		
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
