<?php

class Admin_Controller extends CI_Controller
{

	private $template;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('MyAuth', 'session'));
        $this->write_log();
		$this->myauth->is_logged_in(uri_string());

	}

    private function write_log()
    {
        $this->load->model('log_model');
        $this->load->helper('ip');

        $first_segment = $this->uri->segment(1);
        $second_segment = $this->uri->segment(2);
        $third_segment = $this->uri->segment(3);

        $arr = array();
        $arr['cm'] = '';
        if ($first_segment == 'Backend')  {
            $arr['cm'] = $second_segment . '@' . $third_segment;
        } else {
            $arr['cm'] = $first_segment . '@' . $second_segment;
        }

        $arr['ip'] = ip2long(getIP());
        $arr['opera_time'] = time();
        $admin = $this->session->userdata('admin');
        $arr['user'] = $admin['username'];

        if (!empty($arr['user'])) {
            $this->log_model->insert($arr);
        }

    }

	public function view($view, $vars = array(), $string=false)
	{
		//if there is a template, use it.
		$template	= '';
		if($this->template)
		{
			$template	= $this->template.'_';
		}

		if($string)
		{
			$result	 = $this->load->view(config_item('admin').'/'.$template.'header', $vars, true);
			$result	.= $this->load->view(config_item('admin').'/'.$view, $vars, true);
			$result	.= $this->load->view(config_item('admin').'/'.$template.'footer', $vars, true);

			return $result;
		}
		else
		{
			$this->load->view(config_item('admin').'/'.$template.'header', $vars);
			$this->load->view(config_item('admin').'/'.$view, $vars);
			$this->load->view(config_item('admin').'/'.$template.'footer', $vars);
		}

		//reset $this->template to blank
		$this->template	= false;
	}

	/* Template is a temporary prefix that lasts only for the next call to view */
	public function set_template($template)
	{
		$this->template	= $template;
	}
}

/**
 *
 *  can not access when you are loginning
 *
 */
class LN_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('MyAuth', 'session'));

		if($this->myauth->is_logged_in(false, false)) {
			redirect('admin/index');
		}

	}
}

class FRONT_Controller extends CI_Controller
{

	private $template;

	public $header_template = 'header';

	public $footer_template = 'footer';

	public $twig = null;

	public function __construct()
	{
		parent::__construct();
	}

	public function view($view, $vars = array(), $string=false)
	{

		//if there is a template, use it.
		$template	= '';
		if($this->template)
		{
			$template	= $this->template.'_';
		}

		$result = '';

		if($string)
		{
			if (!empty($this->header_template)) {
				$result	 .= $this->load->view(config_item('front').'/'.$template.$this->header_template, $vars, true);
			}
			$result	.= $this->load->view(config_item('front').'/'.$view, $vars, true);

			if (!empty($this->footer_template)) {
				$result	.= $this->load->view(config_item('front').'/'.$template.$this->footer_template, $vars, true);
			}

			return $result;
		}
		else
		{

			!empty($this->header_template) ? $this->load->view(config_item('front').'/'.$template.$this->header_template, $vars) : '';
			$this->load->view(config_item('front').'/'.$view, $vars);
			!empty($this->footer_template) ? $this->load->view(config_item('front').'/'.$template.$this->footer_template, $vars) : '';
		}

		//reset $this->template to blank
		$this->template	= false;
	}

	/* Template is a temporary prefix that lasts only for the next call to view */
	public function set_template($template)
	{
		$this->template	= $template;
	}
	/**
     * 前台公用模块
     * @author Jaya
     * @param type $cid  栏目id
     * @return type array
     */
    public function common($cid=1){
        $this->load->helper(array('url'));
        $this->load->library('Api');
         // $this->load->library(array('session'));
         //  $this->data['isLogin'] = $this->session->userdata('user');
         // print_r($this->data['isLogin']);

        $this->header_template = 'includes/header';

        $this->footer_template = 'includes/footer';

        //网站配置信息
        $this->data['conf'] = $this ->api ->get_conf();


         //头部导航
        $this->data['head_nav'] = $this->api->get_nav(1);
        // $this->data['footer_nav'] = $this->api->get_nav(2);

         // $this->data['hot_keywords'] = $this->api->get_hot_keywords();    //热搜关键词
         // 友情链接
        // $this->data['links'] = $this->api->get_flink();



        // $this->data['c_pro'] = $this->api->get_articles(1,'c',1,3);
        // $this->data['h_pro'] = $this->api->get_articles(1,'h',1,6);
        // $this->data['kehujianzheng'] = $this->api->get_articles(19,'',1,999);
        // $this->data['jishuguzhang'] = $this->api->get_articles(22,'',1,10);
        // $this->data['corporate'] = $this->api->get_articles(25,'',1,99);

        $search_arr = array();
        $order_arr = array(
                'field' => 'id',
                'way' => 'desc'
                );

        // $this->data['hangyezixun'] = $this->api->get_articles(8,'',1,11,$search_arr,$order_arr);
        // $this->data['dongtai'] = $this->api->get_articles(7,'',1,11,$search_arr,$order_arr);
        // $this->data['faq'] = $this->api->get_articles(9,'',1,3,$search_arr,$order_arr);
        // $this->data['news'] = $this->api->get_articles(2,'',1,10,$search_arr,$order_arr);
        // $this->data['h_pro'] = $this->api->get_articles(1,'h');
        // $this->data['c_pro'] = $this->api->get_articles(1,'c');
        // 左侧联系我们
        // $this->data['contact_content'] = $this->api->get_piece(3);
        $this->data['footer_content'] = $this->api->get_piece(1);
        // print_r($this->data['footer_content']);
      //   $this->data['com_content'] = $this->api->get_piece(4);
        //一级下的栏目集
        // $this->data['all_columns'] = $this->api->get_columns(0);
        $this->data['columns'] = $this->api->get_columns($cid);

        return $this->data;
    }
}

