<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  广告位控制器
 */
class Ad extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('ad_model'));
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));
		
	}
	
	public function save()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['name']) && isset($data['pid'])) {
			
			if ($data['is_edit']) {
				$this->edit($data);
			} else {
				$this->add($data);
			}
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '广告名称或广告位不能为空';
		}
		
		die(json_encode($response_data));
	}
	
	private function add($data)
	{
		$data = array_diff_key($data, array('is_edit'=>1));
		if ($this->ad_model->insert($data)) {
			$response_data['code'] = 200;
			$response_data['message'] = '添加成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '添加失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function get_all()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		$data = $this->ad_model->get_all();
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $data;
		
		
		die(json_encode($response_data));
	}
	
	public function get_specify_ad()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['id']) && !empty($data['id'])) {
			if ($data = $this->ad_model->get_one($data['id'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '获取失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的ID或ID为空';
		}
		
		die(json_encode($response_data));
		
	}
	
	private function edit($data)
	{
		if ($row = $this->ad_model->get_one($data['id'])) {
			if ($row['thumb'] != $data['thumb']) {
				@unlink('.'.$row['thumb']);
			}
		}
		
		if ($this->ad_model->update($data['id'], array_diff_key($data, array('is_edit'=>1, 'id'=>1)))) {
			
			$response_data['code'] = 200;
			$response_data['message'] = '更新成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '更新失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function delete()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['id']) && !empty($data['id'])) {
			
			$row = $this->ad_model->get_one($data['id']);
			@unlink('.'.$row['thumb']);
			
			if ($this->ad_model->delete($data['id'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '删除成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '删除失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的ID或ID为空';
		}
		
		die(json_encode($response_data));
	}
	
	
}