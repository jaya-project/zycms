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
	 *  获取内容模型结构
	 *  
	 */
	public function get_model_struct()
	{
		$data = $this->input->stream();
		
		if (empty($data['channelId'])) {
			die(json_encode(array('code'=>403, 'message'=>'不存在的模型ID')));
		}
		
		$row = $this->channel_model->get_one($data['channelId']);
		$row['table_struct'] = unserialize($row['table_struct']);
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$row)));
	}
	
	/**
	 *  删除内容模型字段
	 *  
	 */
	public function delete_channel_field()
	{
		$data = $this->input->stream();
		//删除结构中的字段
		$channel = $this->channel_model->get_one($data['channel_id']);
		$table_struct = unserialize($channel['table_struct']);
		
		foreach ($table_struct as $key=>$value) {
			if ($value['fields'] == $data['field']) {
				unset($table_struct[$key]);
			}
		}
		
		$table_struct = array_values($table_struct);
		if ($this->channel_model->update($data['channel_id'], array('table_struct'=>serialize($table_struct))) && $this->dbforge->drop_column($channel['table_name'], $data['field'])) {
			die(json_encode(array('code'=>200, 'message'=>'删除字段成功')));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'删除字段失败')));
		}
		
	}
	
	/**
	 *  添加内容模型字段
	 */
	public function add_channel_fields()
	{
		$data = $this->input->stream();
		$channel = $this->channel_model->get_one($data['channel_id']);
		$table_struct = unserialize($channel['table_struct']);
		
		$existed_fields = array_column($table_struct, 'fields');
		$new_fields = array_column($data['new_fields'], 'fields');
		
		//检测添加的字段是否已经存在
		if (array_intersect($existed_fields, $new_fields)) {
			die(json_encode(array('code'=>403, 'message'=>'添加的字段中有已经存在的字段')));
		}
		
		//拼凑添加字段
		$columns = array();
		foreach ($data['new_fields'] as $new_field) {
			$columns[$new_field['fields']] = $this->_get_struct_arr_by_type($new_field['channel_type']);
		}
		
		$table_struct = array_merge($table_struct, $data['new_fields']);
		
		if ($this->channel_model->update($data['channel_id'], array('table_struct'=>serialize($table_struct))) && $this->dbforge->add_column($channel['table_name'], $columns)) {
			die(json_encode(array('code'=>200, 'message'=>'添加字段成功')));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'添加字段失败')));
		}
	}
	
	/**
	 *  修改内容模型字段
	 */
	public function modify_channel_field()
	{
		$data = $this->input->stream();
		$channel = $this->channel_model->get_one($data['channel_id']);
		$table_struct = unserialize($channel['table_struct']);
		
		$existed_fields = array_column($table_struct, 'fields');
		if (in_array($data['old_field']['fields'], 
					array_diff($existed_fields, array($data['be_modified']['fields']))
					)
			) {
			die(json_encode(array('code'=>403, 'message'=>'修改的字段中有已经存在的字段')));
		}
		
		//更新结构
		foreach ($table_struct as $key=>$row) {
			if ($row['fields'] == $data['be_modified']['fields']) {
				$table_struct[$key] = $data['old_field'];
			}
		}
		
		//组装欲更新字段数组
		$columns[$data['be_modified']['fields']] = array_merge(
			array(
				'name' => $data['old_field']['fields'],
				'comment' => $data['old_field']['label_fields']
			),
			$this->_get_struct_arr_by_type($data['old_field']['channel_type'])
		);
		
		if ($this->channel_model->update($data['channel_id'], array('table_struct'=>serialize($table_struct))) && $this->dbforge->modify_column($channel['table_name'], $columns)) {
			die(json_encode(array('code'=>200, 'message'=>'编辑字段成功')));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'编辑字段失败')));
		}
		
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
				case 'multiple_image':
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
	
	private function _get_struct_arr_by_type($type)
	{
		$struct = array();
		switch ($type) {
			case 'text':
			case 'checkbox':
			case 'radio':
			case 'select':
			case 'file':
			case 'image':
			default:
			case 'multiple_image':
				$struct['type'] = 'VARCHAR';
				$struct['constraint'] = '255';
				break;
			case 'textarea':
			case 'htmltext':
				$struct['type'] = 'TEXT';
				break;
		}
		
		return $struct;
	}
	
	
}