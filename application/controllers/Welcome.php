<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Welcome extends FRONT_Controller {



	public function __construct()

    {
		parent::__construct();

		parent::common(1);

	   $this->data['nav_flag'] = "网站首页";


	}



    public function index()

    {
        echo "zycms";exit;

        $this->data['adimg']  = $this->api->get_ad(2);

        // $this->data['hot_keywords'] = $this->api->get_hot_keywords();    //热搜关键词

        // $this->data['project_column'] = $this->api->get_columns(5);

        // $this->data['pv'] = $this->api->get_pv();

        // print_r($this->data['pv']);

        $search_arr = array();

        $order_arr = array(

                'field' => 'id',

                'way' => 'desc'

                );

        // $this->data['index_pro'] = $this->api->get_articles(1, 'c', 1, 11);
        // $this->data['index_case24'] = $this->api->get_articles(24, '', 1, 5);
        // $this->data['index_case25'] = $this->api->get_articles(25, '', 1, 5);
        // $this->data['index_case26'] = $this->api->get_articles(26, '', 1, 5);
        // $this->data['index_khjz'] = $this->api->get_articles(22,'',1, 4);

        // $this->data['about_content'] = $this->api->get_piece(2);

        // $this->data['index_qyxx'] = $this->api->get_articles(21);
        // $this->data['index_hzkh'] = $this->api->get_articles(19,'',1, 6);

        // $this->data['dongtai'] = $this->api->get_articles(7,'',1,10,$search_arr,$order_arr);
        // $this->data['zixun'] = $this->api->get_articles(8,'',1,10,$search_arr,$order_arr);
        // $this->data['faq'] = $this->api->get_articles(9,'',1,7,$search_arr,$order_arr);



        // $this->data['links'] = $this->api->get_flink();

        // 首页seo标题

        $this->data['title'] = $this->data['conf']['title'];

        $this->data['keywords'] = $this->data['conf']['keywords'];

        $this->data['description'] = $this->data['conf']['description'];

        $this->view('welcome_index',$this->data);

        return;





	}





}

