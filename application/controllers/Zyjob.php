<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Zyjob extends FRONT_Controller {



    public function __construct() {

        parent::__construct();

        parent::common(3);

        $this->data['nav_flag']="job";

    }





    public function index($cid=10,$page=1,$page_length=9999){

        // 获取当前栏目信息

        $this->data['column'] = $this->api->get_column($cid);

        $this->data['nav_flag'] = $this->data['column']['column_name'];



        $this->data['flag'] = $this->data['column']['id'];

        $this->data['cid'] = $this->data['column']['id'];





        // 当前栏目seo

        $this->data['title'] = $this->data['column']['seo_title'];

        $this->data['keywords'] = $this->data['column']['seo_keywords'];

        $this->data['description'] = $this->data['column']['seo_description'];

        //产品列表

        $search_arr = array();

        $order_arr = array(

                'field' => 'id',

                'way' => 'desc'

                );

        $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length,$search_arr,$order_arr);

        $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length,$search_arr,$order_arr);

        // 面包屑

        $this->data['bread'] = $this->api->get_bread($cid,'list');



        $this->view('job', $this->data);





    }





}