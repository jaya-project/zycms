<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  权限控制器
 */
class Role extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('role_model', 'relation_model'));
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));
		
	}
	
	public function save()
	{
		$data = $this->input->stream();
		
		
		$response_data = array();
		
		if (isset($data['name'])) {
			
			if ($data['is_edit']) {
				$this->edit($data);
			} else {
				$this->add($data);
			}
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '权限资源名称不能为空';
		}
		
		die(json_encode($response_data));
	}
	
	private function add($data)
	{
		
		
		$rids = $data['rid'];
		
		
		$data = array_diff_key($data, array('is_edit'=>1, 'rid'=>1));
		
		if ($this->role_model->insert($data)) {
			$id = $this->role_model->get_insert_id();
			
			$relationship_data = array();
			
			while($rid = current($rids)) {
				$relationship_data[] = array(
											'roleid' => $id,
											'rid' => $rid
										);
				next($rids);
			}
			
			if ($this->relation_model->multiple_insert($relationship_data)) {
				$response_data['code'] = 200;
				$response_data['message'] = '添加成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '添加失败';
			}
			
			
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
		
		$data = $this->role_model->get_all();
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $data;
		
		
		die(json_encode($response_data));
	}
	
	public function get_specify_role()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['id']) && !empty($data['id'])) {
			if ($data = $this->role_model->get_one($data['id'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				$data['rid'] = explode(',', $data['rid']);
				
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
		$rids = $data['rid'];
		$id = $data['id'];
		
		if ($this->role_model->update($data['id'], array_diff_key($data, array('is_edit'=>1, 'id'=>1, 'rid'=>1)))) {
			
			$relationship_data = array();
			
			while($rid = current($rids)) {
				$relationship_data[] = array(
											'roleid' => $id,
											'rid' => $rid
										);
				next($rids);
			}
			
			if ($this->relation_model->delete_where("roleid=$id") && $this->relation_model->multiple_insert($relationship_data)) {
				$response_data['code'] = 200;
				$response_data['message'] = '更新成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '更新失败';
			}
			
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
			
			if ($this->role_model->delete($data['id']) && $this->relation_model->delete_where("roleid=$data[id]")) {
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