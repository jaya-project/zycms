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
}

