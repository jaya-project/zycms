<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  会员控制器
 */
class Member extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('member_model'));
		$this->load->library(array('session', 'area'));
		$this->load->helper(array('array', 'url', 'security'));
		
	}
	
	public function save()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		$query = '';
		
		if ($data['is_edit']) {
			$query = "id!=$data[id] AND (username='$data[username]' OR email='$data[email]')";
		} else {
			$query = "username='$data[username]' OR email='$data[email]'";
		}
		
		
		if ($this->member_model->is_exists($query)) {
			$response_data['code'] = 403;
			$response_data['message'] = '已经存在的用户名,请更换一个';
			die(json_encode($response_data));
		}
		
		if (isset($data['username']) && isset($data['email'])) {
			
			if ($data['is_edit']) {
				$this->edit($data);
			} else {
				$this->add($data);
			}
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '用户名不能为空';
		}
		
		die(json_encode($response_data));
	}
	
	private function add($data)
	{
		
		$data['password'] = do_hash($data['password']);
		
		$data = array_diff_key($data, array('is_edit'=>1));
		
		if ($this->member_model->insert($data)) {
			
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
		
		$data = $this->member_model->get_all();
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $data;
		
		
		die(json_encode($response_data));
	}
	
	public function get_specify_member()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['id']) && !empty($data['id'])) {
			if ($data = $this->member_model->get_one($data['id'])) {
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
		if (isset($data['password'])) {
			$data['password'] = do_hash($data['password']);
		}
		
		if ($this->member_model->update($data['id'], array_diff_key($data, array('is_edit'=>1, 'id'=>1)))) {
			
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
			
			if ($this->member_model->delete($data['id'])) {
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
	
	public function get_provinces()
	{
		$area = $this->area;
		$data = $area::get_provinces();
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
	}
	
	public function get_cities()
	{
		$data = $this->input->stream();
		$area = $this->area;
		$data = $area::get_cities($data['id']);
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
	}
	
	public function get_areas()
	{
		$data = $this->input->stream();
		$area = $this->area;
		$data = $area::get_areas($data['id']);
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
	}
	
	
	
}