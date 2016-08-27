<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Zycase extends FRONT_Controller {



    public function __construct() {

        parent::__construct();

        parent::common(4);

        $this->data['nav_flag']="成功案例";

    }



    public function index($cid=4)

    {

        die('该路径不存在!');


    }

    public function category($cid=4,$page=1,$page_length=12)

    {

        $column = $this->api->get_column($cid);

        $this->data['flag'] = $column['id'];
        $this->data['cid'] = $column['id'];

        $this->data['title'] = $column['seo_title'];

        $this->data['keywords'] = $column['seo_keywords'];

        $this->data['description'] = $column['seo_description'];

        $this->data['column'] = $column;

        $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length);

        $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length);

        $this->data['bread'] = $this->api->get_bread($cid,'list');

        $this->view('case', $this->data);


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