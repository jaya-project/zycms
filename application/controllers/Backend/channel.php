<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  内容模型控制器
 */
class Channel extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('channel_model'));
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));
		$this->load->dbforge();
		
	}
	
	/**
	 *  获取内容模型
	 */
	public function get_model() 
	{
		$data = $this->channel_model->get_all();
		die(json_encode(array(
							'code' => 200,
							'message' => '获取成功',
							'data' => $data
						)));
						
	}
	
	
	/**
	 *  删除内容模型
	 */
	public function delete_model() 
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (empty($data['channel_id'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '内容模型ID不能为空';
		} else {
			$channel_row = $this->channel_model->get_one($data['channel_id'], 'table_name');
			if ($this->channel_model->delete($data['channel_id'])) {
				if ($this->dbforge->drop_table($channel_row['table_name'])) {
					$response_data['code'] = 200;
					$response_data['message'] = '删除成功';
					$response_data['data'] = $this->channel_model->get_all();
				} else {
					$response_data['code'] = 403;
					$response_data['message'] = '删除失败';
				}				
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '删除失败';
			}
		}
		
		die(json_encode($response_data));
	}
	
	/**
	 *  获取字段类型
	 */
	public function get_channel_type() 
	{
		$this->config->load('backend_options', TRUE);
		$config_item = $this->config->item('backend_options');
		
		die(json_encode(array('data' => $config_item['backend']['channel_model_fields'], 'message' => '获取成功', 'code' => 200)));
	}
	
	/**
	 *  获取指定的模型
	 */
	public function get_specify_model()
	{
		$data = $this->input->stream();
		
		if (empty($data['channel_id'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '需要一个ID参数,没有传过来或ID为空';
		} else {
			if ($data = $this->channel_model->get_one($data['channel_id'])) {
				$data['table_struct'] = unserialize($data['table_struct']);
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '没有查询到相应的内容模型';
			}
		}
		
		die(json_encode($response_data));
		
	}
	
	
	/**
	 *  添加内容模型
	 */
	public function add() 
	{
		
		$err_msg = '';
		$data = $this->input->stream();
		$channel_name = isset($data['channel_name']) ? $data['channel_name'] : '';
		$err_msg .= empty($channel_name) ? '内容模型名称不能为空<br />' : '';
		
		$table_name = isset($data['table_name']) ? $data['table_name'] : '';
		$err_msg .= empty($table_name) ? '表名称不能为空<br />' : '';
		
		
		if ($this->channel_model->is_exists("table_name='$table_name'")) {
			$err_msg .= '该表已经存在, 请换一个模型表名称<br />';
		}
		
		if (!empty($err_msg)) {
			die(json_encode(array(
								'code' => 403,
								'message' => $err_msg
							)));
		}
		
		$table_fields = array(
						'id' => array(
									'type' => 'INT',
									'constraint' => 10,
									'unsigned' => TRUE,
									'comment' => 'ID'
								),
					);
					
		$this->dbforge->add_field($table_fields);
		
		foreach ($data['table_struct'] as $key=>$value) {
			
			$data_fields = $value['fields'];
			$data_channel_type = $value['channel_type'];
			$data_label_fields = $value['label_fields'];
			
			$fields = array();
			switch($data_channel_type) {
				case 'text':
				case 'image':
				case 'checkbox':
				case 'radio':
				case 'select':
				case 'file':
						$fields = " $data_fields VARCHAR(255) CHARSET UTF8  COMMENT '$data_label_fields'";
						break;
				case 'textarea':
				case 'htmltext':
						$fields = " $data_fields TEXT CHARSET UTF8  COMMENT '$data_label_fields'";
						break;
						break;
			}
			
			
			$this->dbforge->add_field($fields);
		}
		
		
		$this->dbforge->add_key('id', TRUE);
		
		$this->dbforge->create_table($table_name, TRUE);
		
		$data = array(
					'table_name' => $table_name,
					'channel_name' => $channel_name,
					'table_struct' => serialize($data['table_struct'])
				);
				
		if ($this->channel_model->insert($data)) {
			die(json_encode(array(
								'code' => 200,
								'message' => '添加成功'
							)));
		} else {
			die(json_encode(array(
								'code' => 403,
								'message' => '添加失败'
							)));
		}
		
		
	}
	
	
}