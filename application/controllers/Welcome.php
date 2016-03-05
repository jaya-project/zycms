<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Gregwar\Captcha\CaptchaBuilder;

class Welcome extends FRONT_Controller {

	public function __construct() {
		parent::__construct();

		parent::common();
	}

	public function index() {
		$srcPath = thumbnail('/uploads/2016/02/24/de47d7a59f2b493663d8c8e0bbeb558b.jpg', 50, 50);
		echo <<< HTML
			<img src="$srcPath" />
			<h1>Welcome to zycms!</h1>
			<h2><a href="/admin">去后台</a></h2>
HTML;

 	  	$this->data['pv'] = $this->api->get_pv();

     	$this->view('index',$this->data);

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
