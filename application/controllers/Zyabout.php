<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Zyabout extends FRONT_Controller {



	public function __construct() {

		parent::__construct();

		parent::common(3);

        $this->data['nav_flag']="关于我们";

	}



   public function index($cid=3,$page=1,$page_length=12){

         // $cid = (17 == $cid ) ? 18 : $cid ;

        $column = $this->api->get_column($cid);

        $column['content'] = $this->api->keywords_replace($column['content']);
        // $this->data['nav_flag'] = $column['column_name'];

        $this->data['cid'] = $column['id'];

        $this->data['flag'] = $column['id'];

        // 当前栏目seo

        $this->data['title'] = $column['seo_title'];

        $this->data['keywords'] = $column['seo_keywords'];

        $this->data['description'] = $column['seo_description'];

        $this->data['column'] = $column;

         // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'list');


        $this->view('about', $this->data);

            return;







    }


    public function category($cid=3,$page=1,$page_length=12){

         // $cid = (17 == $cid ) ? 18 : $cid ;

        $column = $this->api->get_column($cid);

        $column['content'] = $this->api->keywords_replace($column['content']);
        // $this->data['nav_flag'] = $column['column_name'];

        $this->data['cid'] = $column['id'];

        $this->data['flag'] = $column['id'];

        // 当前栏目seo

        $this->data['title'] = $column['seo_title'];

        $this->data['keywords'] = $column['seo_keywords'];

        $this->data['description'] = $column['seo_description'];

        $this->data['column'] = $column;

         // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'list');

        if( 15 == $cid) {
            $this->data['nav_flag'] = '联系建拓';
        }

        if(11 == $cid){

            $this->view('feedback', $this->data);

            return;

        }


        if(21== $cid ||  23== $cid ) {

             $this->data['nav_flag'] = $column['column_name'];
             $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length);

             $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length);

             $this->view('Certificate', $this->data);

            return;

        }

        if(22== $cid  ) {

             $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length);

            $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length);

             $this->view('witness', $this->data);

            return;

        }


        $this->view('about', $this->data);

            return;







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