<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends FRONT_Controller {

    public function __construct() {
        parent::__construct();
        parent::common(4);
        $this->data['nav_flag']="经典案例";
    }


    public function category($cid=4,$page=1,$page_length=12)
    {
        // 获取当前栏目信息
        $this->data['column'] = $this->api->get_column($cid);


        $this->data['cid'] = $this->data['column']['id'];

        // 当前栏目seo
        $this->data['title'] = $this->data['column']['seo_title'];
        $this->data['keywords'] = $this->data['column']['seo_keywords'];
        $this->data['description'] = $this->data['column']['seo_description'];
        //产品列表

        $this->data['articles'] = $this->api->get_articles($cid,'',$page,$page_length);
        $this->data['page']  = $this->api->get_pages($cid,'',$page,$page_length);

        // 面包屑
        $this->data['bread'] = $this->api->get_bread($cid,'list');

        $this->view('case', $this->data);



    }

    // 产品详细
    public function detail($cid){

        $this->data['article']= $this->api->get_article($cid);
        $this->data['article']['body'] = $this->api->keywords_replace($this->data['article']['body']);


        // 得到所属栏目
        $this->data['column'] = $this->api->get_column($this->data['article']['cid']);
        $this->data['flag']  = $this->data['article']['cid'];

        // 当前文章seo
        $this->data['title'] = $this->data['article']['seo_title'];
        $this->data['keywords'] = $this->data['article']['seo_keywords'];
        $this->data['description'] = $this->data['article']['seo_description'];
        // 面包屑
        $this->data['bread'] = $this->api->get_bread($cid,'detail');
        // 上下篇
        $this->data['prev_next'] = $this->api->get_prev_next($cid);
        $this->view('case_show', $this->data);

    }




}