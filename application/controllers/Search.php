<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Search extends FRONT_Controller {



    public function __construct() {

        parent::__construct();

        parent::common(1);

        $this->load->library('session');

        $this->data['nav_flag']="产品中心";

    }



    public function index($cid=1,$page=1,$page_length=12)

    {
        $conditions = $this->input->get();

        if (!$conditions) {

                $conditions = $this->session->userdata('keyword');

        } else {

                $this->session->set_userdata('keyword',$conditions);

        }

        // 获取当前栏目信息

        $column = $this->api->get_column($cid);

        $this->data['cid'] = $column['id'];

        $this->data['flag']  = $column['id'];

        $this->data['bread'] = "产品搜索结果";
        // 当前栏目seo

        $this->data['title'] = '搜索'.$column['seo_title'];

        $this->data['keywords'] = '搜索'.$column['seo_keywords'];

        $this->data['description'] = '搜索'.$column['seo_description'];

        $this->data['column'] = $column;

        //产品列表

        // $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length,$conditions);

        $img_articles = $this->api->get_articles($cid,'',$page,$page_length,$conditions);



        foreach ($img_articles as $key => $value) {

            // $belong_column = $this->api->get_column($value['cid']);

            // 所属栏目

            // $img_articles[$key]['belong_column'] = $belong_column['column_name'];

            $img_articles[$key]['after_title'] = str_replace($conditions['title'], '<span style="font-weight:bold;color:#f00;">'. $conditions['title'].'</span>', $value['title']);

        }

        $this->data['articles'] = $img_articles;

        $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length,$conditions);

        $this->view('search', $this->data);


    }





}