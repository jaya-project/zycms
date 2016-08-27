<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Sitemap extends FRONT_Controller {



	public function __construct() {

		parent::__construct();

		parent::common();

        $this->data['nav_flag']="网站地图";

	}





    public function index( ){


        // 当前栏目seo

        $this->data['title'] = '网站地图'.$this->data['conf']['title'];

        $this->data['keywords'] = '网站地图'.$this->data['conf']['keywords'];

        $this->data['description'] = '网站地图'.$this->data['conf']['description'];
         $this->data['all_columns'] = $this->api->get_columns(0);


         // 面包屑

        $this->data['bread'] = '网站地图';





        $this->view('sitemap', $this->data);






    }


}