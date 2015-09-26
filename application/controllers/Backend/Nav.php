<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  内容模型控制器
 */
class Nav extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('nav_model'));
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));
		
	}
	
	public function get_all() 
	{
		$navs = $this->nav_model->get_all("position asc, sort asc");
		
		$new_nav = array();
		foreach($navs as $key=>$value) {
			$new_nav[$value['id']] = $value;
		}
		$navs = getTreeData(gen_tree($new_nav, 'pid'));
		
		die(json_encode(array('code'=>200, 'data'=>$navs, 'message'=>'获取成功')));
		
	}
	
	/**
	 *  获取指定的栏目
	 */
	public function get_specify_nav() 
	{
		$data = $this->input->stream();
		
		if (isset($data['id'])) {
			if ($data = $this->nav_model->get_one($data['id'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '获取失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '传过来的ID信息不正确';
		}
		
		die(json_encode($response_data));
	}
	
	public function save()
	{
		$data = $this->input->stream();
		
		
		$response_data = array();
		
		if (!isset($data['name'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '带*号的为必填项';
			
		} else {
			//设置分类级别
			if ($data['pid'] == 0) {
				$data['level'] = 1;
			} else {
				if ($row = $this->nav_model->get_one($data['pid'])) {
					$data['level'] = $row['level'] + 1;
				} else {
					$response_data['code'] = 403;
					$response_data['message'] = '不存在的父栏目';
					die(json_encode($response_data));
				}
				
			}
			
			if (isset($data['is_edit'])) {
				$this->edit($data);
			} else if (isset($data['is_add'])) {
				
				$this->add($data);
				
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '非法的动作';
			}
			
		}
		
		die(json_encode($response_data));
	}
	
	/**
	 *  添加栏目
	 */
	public function add($data) 
	{
		$data = array_diff_key($data, array('is_add'=>1));
		
		if ( $this->nav_model->insert($data)) {
			$response_data['code'] = 200;
			$response_data['message'] = '添加成功';
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '添加失败,请稍候再试';
		}
			
		
		die(json_encode($response_data));
		
		
	}
	
	public function edit($data) 
	{
		
		if ($this->nav_model->update($data['id'], array_diff_key($data, array('id'=>1, 'is_edit'=>1)))) {
			$response_data['code'] = 200;
			$response_data['message'] = '编辑成功';
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '编辑失败,请稍候再试';
		}
			
		
		die(json_encode($response_data));
	}
	
	
	
	/**
	 *  栏目删除
	 */
	public function delete() 
	{
		$data = $this->input->stream();
		

		if (isset($data['id'])) {
			
			if ($this->nav_model->delete($data['id'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '删除成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '删除失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = 'ID不能为空';
		}
		
		die(json_encode($response_data));
	}
	
	
	public function modify_sort()
	{
		$data = $this->input->stream();
		
		$this->load->library('MySort');
		die($this->mysort->set_model('nav_model')->modify_sort($data['id'], $data['sort']));
	}
	
	
}