<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  系统设置控制器
 */
class System extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));
		
		
	}
	
	public function save_base_set()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		$data = '<?php $config["system_set"] = ' .var_export($data, true) . ';';
		
		if (file_put_contents(APPPATH.'/config/system.php', $data)) {
			
			$response_data['code'] = 200;
			$response_data['message'] = '保存成功';
			$response_data['data'] = $this->get_baset_set_config();
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '保存失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function get_base_set()
	{
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $this->get_baset_set_config();
		die(json_encode($response_data));
	}
	
	private function get_baset_set_config() 
	{
		$this->config->load('system', True);
		$temp = $this->config->item('system');
		return $temp['system_set'];
		
	}
	
	public function save_water_set()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		$org_water_config = $this->get_water_set_config();
		
		//删除原来的水印图片
		if ($org_water_config['thumb'] != $data['thumb']) {
			@unlink('.'.$org_water_config['thumb']);
		}
		
		$data = '<?php $config["water_mark"] = ' .var_export($data, true) . ';';
		
		
		
		if (file_put_contents(APPPATH.'/config/water_mark.php', $data)) {
			
			$response_data['code'] = 200;
			$response_data['message'] = '保存成功';
			$response_data['data'] = $this->get_water_set_config();
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '保存失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function get_water_set()
	{
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $this->get_water_set_config();
		die(json_encode($response_data));
	}
	
	private function get_water_set_config() 
	{
		$this->config->load('water_mark', True);
		$temp = $this->config->item('water_mark');
		return $temp['water_mark'];
		
	}
	
	/**
	 *  上传图片
	 *  为避免上传水印图片时添加水印, 不可与公共上传方法共用
	 */
	public function upload_image() 
	{
		if (!is_dir('./uploads/'.date('Y').'/'.date('m').'/'.date('d').'/')) {
			@mkdir('./uploads/'.date('Y').'/'.date('m').'/'.date('d').'/', 777, true);
		}
		
		$config['upload_path'] = './uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
		
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '1024';
		$config['file_name'] = date('Y').'_'.date('m').'_'.date('d').'_'.time();
		
		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload('file'))
		{
			
			die(json_encode(array('code'=>200, 'data'=>array_merge($this->upload->data(), array('relative_path'=>ltrim($config['upload_path'], '.'))), 'message'=>'上传成功')));
		}	 
		else
		{
			die(json_encode(array('code'=>403, 'message'=>$this->upload->display_errors())));
		}

	}
	
	
	
}