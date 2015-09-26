<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {

		echo "<div style='height:1000px;'></div>";
		echo "hello!zycms";
		echo '<style type="text/css">.hover {color:#f00; font-size:14px;}</style>';
		
		echo '<br /><a href="/welcome/test">关键词替换测试</a>';
		
		echo '<br /><a href="/welcome/articles">文章延迟发布测试</a>';
		
		echo '<script type="text/javascript" src="/assets/Front/js/jquery-1.7.2.min.js"></script>';
		echo '<script type="text/javascript" src="/assets/Front/js/util.js"></script>';
		
		echo '<script type="text/javascript">$("a").changeStyle("hover");</script>';
		echo '<button onclick="$.scrollToWhere(1000);">顶部</button>';
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
