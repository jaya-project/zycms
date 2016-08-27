<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Zyproducts extends FRONT_Controller {



	public function __construct() {

		parent::__construct();

		parent::common(1);

        $this->data['nav_flag']="产品中心";

    }



    public function index($cid=1,$page=1,$page_length=12)

    {
        die('改路径不存在');

        // 获取当前栏目信息

        $column = $this->api->get_column($cid);

        $this->data['column'] = $column;

        $this->data['flag'] = $column['id'];

        $this->data['cid'] = $column['id'];

        // 当前栏目seo

        $this->data['title'] = $column['seo_title'];

        $this->data['keywords'] = $column['seo_keywords'];

        $this->data['description'] = $column['seo_description'];

        // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'list');

        $this->view('product', $this->data);

    }

    public function category($cid=1,$page=1,$page_length=12)

    {

		// 获取当前栏目信息

		$column = $this->api->get_column($cid);

        $this->data['column'] = $column;


        // if ( 2 == $column['level'] || 1 == $column['level']) {
        //     $this->data['flag'] = $column['id'];
        // }

        // if ( 3 == $column['level']) {
        //     $this->data['flag'] = $column['pid'];
        // }

		$this->data['cid'] = $column['id'];

		// 当前栏目seo

		$this->data['title'] = $column['seo_title'];

        $this->data['keywords'] = $column['seo_keywords'];

        $this->data['description'] = $column['seo_description'];

        //产品列表

        // $pro_columns = $this->api->get_columns(1);

        // $products = array();

        // foreach ($pro_columns['children'] as $key => $value) {

        //     if(!empty($value['id'])){

        //        $product = $this->api->get_articles($value['id'],'',1,6);

        //        if(!empty($product)){

        //             $products[$value['id']] = $product;

        //        }else{

        //             unset($product);

        //        }

        //     }

        // }

        // $this->data['products'] = $products;

        // $this->data['pro_columns'] = $pro_columns;



        $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length);

        $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length);
        // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'list');

        $this->view('product', $this->data);







    }



    // 产品详细

    public function detail($cid){



        $article = $this->api->get_article($cid);

        $article['body'] = $this->api->keywords_replace($article['body']);
         // 多图

        // $images_srt = $article['images'];

        // if(!empty($images_srt)) {

        //     $this->data['images'] = explode(",",$images_srt);

        // }
        // 得到所属栏目

        $column = $this->api->get_column($article['cid']);

        $this->data['column'] = $column;

        $this->data['flag']  = $article['cid'];

        // 当前文章seo

        $this->data['title'] = $article['seo_title'];

        $this->data['keywords'] = $article['seo_keywords'];

        $this->data['description'] = $article['seo_description'];

        $this->data['article'] = $article;

        // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'detail');

        // 上下篇

        $this->data['prev_next'] = $this->api->get_prev_next($cid);

        // $this->data['product_content'] = $this->api->get_piece(3);

        $this->data['cid_product'] = $this->api->get_articles($article['cid'],'',1,4);

        $this->view('product_show', $this->data);



    }




}