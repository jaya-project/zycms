<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_template()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (!isset($data['template'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '模板不能为空';
			die(json_encode($response_data));
		}
		
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $this->load->view('Backend/templates/'.$data['template'], '', True);
		
		die(json_encode($response_data));
	}
	
}