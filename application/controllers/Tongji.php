<?php


defined('BASEPATH') OR exit('No direct script access allowed');





class Tongji extends CI_Controller {





    public function __construct() {


        parent::__construct();





    }








    public function index()


    {


        $this->load->helper('ip');


        $this->load->model('tongji_model');


        $referer = '';


        if (preg_match('/'.str_replace('.', '\.', $_SERVER['HTTP_HOST']).'/i', $_SERVER['HTTP_REFERER'])) {


            $referer = '直接访问';


        } elseif (preg_match('/baidu\.com/i', $_SERVER['HTTP_REFERER'])) {


            $referer = '百度';


        } elseif (preg_match('/google\.\w+/i', $_SERVER['HTTP_REFERER'])) {


            $referer = '谷歌';


        } elseif (preg_match('/so\.com/i', $_SERVER['HTTP_REFERER'])) {


            $referer = '360搜索';


        } elseif (preg_match('/sogou\.com/i', $_SERVER['HTTP_REFERER'])) {


            $referer = '搜狗';


        } else {
            $referer = 'NULL';
        }


        $user_agent = $_GET['userAgent'];
        if(empty($user_agent)){
            $user_agent = 'NULL';
        }


        $this->tongji_model->insert(array(


            'ip' => ip2long(getIp()),


            'date' => date('Y-m-d', time()),


            'user_agent' => $user_agent,


            'referer' => $referer


        ));





        die(json_encode(array('code'=>200, 'message'=>'成功')));


    }





}


