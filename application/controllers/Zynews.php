<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Zynews extends FRONT_Controller {



	public function __construct() {

		parent::__construct();

		parent::common(2);

        $this->data['nav_flag']="新闻资讯";

	}





	public function category($cid=2,$page=1,$page_length=12){

    	// 获取当前栏目信息

    	$column = $this->api->get_column($cid);

        $this->data['column'] = $column;

    	$this->data['flag'] = $column['id'];

    	$this->data['cid'] = $column['id'];


    	// 当前栏目seo

    	$this->data['title'] = $column['seo_title'];

        $this->data['keywords'] = $column['seo_keywords'];

        $this->data['description'] = $column['seo_description'];

        //产品列表

        $search_arr = array();

        $order_arr = array(

                'field' => 'id',

                'way' => 'desc'

                );

        $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length,$search_arr,$order_arr);

        // print_r($this->data['articles']);

        $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length,$search_arr,$order_arr);

        // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'list');

        // if (16 == $cid) {

        // 	$this->view('solution', $this->data);

        // 	return;

        // }

        $this->view('news', $this->data);







	}




   public function detail($cid){

        $article= $this->api->get_article($cid);

        $article['body'] = $this->api->keywords_replace($article['body']);

        $this->data['column'] = $this->api->get_column($article['cid']);

        $this->data['flag']  = $article['cid'];

        $this->data['title'] = $article['seo_title'];

        $this->data['keywords'] = $article['seo_keywords'];

        $this->data['description'] = $article['seo_description'];

        $this->data['article'] = $article;

        $search_arr = array();

        $order_arr = array(

                'field' => 'id',

                'way' => 'desc'

                );

        $this->data['cid_news'] = $this->api->get_articles($article['cid'],'',1,10,$search_arr,$order_arr);

        $this->data['bread'] = $this->api->get_bread($cid,'detail');

        $this->data['prev_next'] = $this->api->get_prev_next($cid);

        $this->view('news_show', $this->data);



    }




}