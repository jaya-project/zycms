<?php
class MySort {
	
	public $CI;
	
	protected $model;
	
	public function __construct() {
		$this->CI = & get_instance();
	}
	
	public function set_model($model)
	{
		if (empty($model)) {
			throw new Exception('model can\'t be empty');
		}
		
		$this->model = $model;
		
		$this->CI->load->model($model);
		
		return $this;
	}
	
	
	public function modify_sort($primary_key, $sort_value) 
	{
		if (empty($this->model)) {
			throw new Exception('call set_model method first please');
		}
		
		$model = $this->model;
		if (isset($primary_key) && isset($sort_value) && is_int($sort_value) && is_int($primary_key)) {
			if ($this->CI->$model->update($primary_key, array('sort'=>intval($sort_value)))) {
				$response_data['code'] = 200;
				$response_data['message'] = '更新成功';
				
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '更新失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '排序字段值或ID为非数值类型';
		}
		
		return json_encode($response_data);
	}
	
}
