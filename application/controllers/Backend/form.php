<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  自定义表单控制器
 */
class Form extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('form_model'));
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));
		$this->load->dbforge();
		
	}
	
	/**
	 *  获取自定义表单
	 */
	public function get_form() 
	{
		$data = $this->form_model->get_all();
		die(json_encode(array(
							'code' => 200,
							'message' => '获取成功',
							'data' => $data
						)));
						
	}
	
	public function build_form($formId)
	{
		$formId = isset($formId) ? $formId : '';
		
		if (empty($formId)) {
			die('不存在的formID');
		}
		
		$data = $this->form_model->get_one($formId);
		
		$table_struct = unserialize($data['table_struct']);
		
		$html = '';
		
		$html .= "<form method='post' enctype='multipart/form-data' action='/form/submit'>";
		
		$html .= "<input type='hidden' name='formId' value='$formId' />";
		
		$html .= "<input type='hidden' name='redirect_uri' value='/' />";
		
		$html .= '<table>';
		
		foreach($table_struct as $key=>$value) {
			$input = '';
			switch($value['form_type']) {
				default:
				case 'text':
					$input = "<input type='text' name='$value[fields]' placeholder='$value[label_fields]' />";
					break;
				case 'textarea':
				case 'htmltext':
					$input = "<textarea name='$value[fields]' placeholder='$value[label_fields]'></textarea>";
					break;
				case 'checkbox':
					$temp_value = explode(',', $value['values']);
					foreach ($temp_value as $k=>$v) {
						$input .= "<input type='checkbox' name='".$value[fields]."[]' value='$v' /> $v ";
					}
					break;
				case 'radio':
					$temp_value = explode(',', $value['values']);
					foreach ($temp_value as $k=>$v) {
						$input .= "<input type='radio' name='$value[fields]' value='$v' /> $v ";
					}
					break;
				case 'select':
					$input .= "<select name='$value[fields]'>";
					$temp_value = explode(',', $value['values']);
					foreach ($temp_value as $k=>$v) {
						$input .= "<option value='$v' />$v</option>";
					}
					$input .= "</select>";
					break;
				case 'image':
					$input = "<input type='file' name='$value[fields]' />";
					break;
				
			}
			$html .= '<tr>';
			$html .= "<td>$value[label_fields]: </td><td>$input</td>";
			$html .= '</tr>';
		}
		
		$html .= '</table>';
		
		$html .= '<input type="submit" value="提交" />';
		
		$html .= '</form>';
		
		echo $html;
	}
	
	/**
	 *  删除自定义表单
	 */
	public function delete_form() 
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (empty($data['form_id'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '自定义表单ID不能为空';
		} else {
			$channel_row = $this->form_model->get_one($data['form_id'], 'table_name');
			if ($this->form_model->delete($data['form_id'])) {
				if ($this->dbforge->drop_table($channel_row['table_name'])) {
					$response_data['code'] = 200;
					$response_data['message'] = '删除成功';
					$response_data['data'] = $this->form_model->get_all();
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
	public function get_form_type() 
	{
		$this->config->load('backend_options', TRUE);
		$config_item = $this->config->item('backend_options');
		
		die(json_encode(array('data' => $config_item['backend']['form_fields'], 'message' => '获取成功', 'code' => 200)));
	}
	

	
	/**
	 *  添加自定义表单
	 */
	public function add() 
	{
		
		$err_msg = '';
		$data = $this->input->stream();
		$name = isset($data['form_name']) ? $data['form_name'] : '';
		$err_msg .= empty($name) ? '自定义表单名称不能为空<br />' : '';
		
		$table_name = isset($data['table_name']) ? $data['table_name'] : '';
		$err_msg .= empty($table_name) ? '表名称不能为空<br />' : '';
		
		
		if ($this->form_model->is_exists("table_name='$table_name'")) {
			$err_msg .= '该表已经存在, 请换一个表名称<br />';
		}
		
		if (!empty($err_msg)) {
			die(json_encode(array(
								'code' => 403,
								'message' => $err_msg
							)));
		}
		
		$recevie_email = (isset($data['recevied']) && !empty($data['recevied'])) ? $data['recevied'] : '';
		
		$table_fields = array(
						'id' => array(
									'type' => 'INT',
									'constraint' => 10,
									'unsigned' => TRUE,
									'comment' => 'ID',
									'auto_increment' => TRUE
								),
					);
					
		$this->dbforge->add_field($table_fields);
		
		foreach ($data['table_struct'] as $key=>$value) {
			
			$data_fields = $value['fields'];
			$data_channel_type = $value['form_type'];
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
					'name' => $name,
					'table_struct' => serialize($data['table_struct']),
					'recevied' => $recevie_email
				);
				
		if ($this->form_model->insert($data)) {
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
	
	public function get_form_content_list()
	{
		$data = $this->input->stream();
		
		if (isset($data['formId'])) {
			$row = $this->form_model->get_one($data['formId']);
			$data = $this->db->get($row['table_name'])->result_array();
			
			die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'不存在的formID')));
		}
	}
	
	public function delete_form_content()
	{
		$data = $this->input->stream();
		
		if (isset($data['formId']) && isset($data['id'])) {
			$row = $this->form_model->get_one($data['formId']);
			
			if ($this->db->where("id=$data[id]")->delete($row['table_name'])) {
				die(json_encode(array('code'=>200, 'message'=>'删除成功')));
			} else {
				die(json_encode(array('code'=>403, 'message'=>'删除失败')));
			}
			
			
		} else {
			die(json_encode(array('code'=>403, 'message'=>'不存在的formID或不存在的内容ID')));
		}
	}
	
	public function show_form_content()
	{
		$data = $this->input->stream();
		
		if (isset($data['formId']) && isset($data['id'])) {
			$row = $this->form_model->get_one($data['formId']);
			
			$table_struct = unserialize($row['table_struct']);
			
			$label_fields = array_column($table_struct, 'label_fields');
			
			
			if ($value = $this->db->where("id=$data[id]")->get($row['table_name'])->row_array()) {
				
				array_shift($value);
				
				$data = array();
				
				while ($item = current($label_fields)) {
					$data[] = array(
									'name' => $item,
									'value' => current($value),
								);
					next($label_fields);
					next($value);
				}
				
				die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
			} else {
				die(json_encode(array('code'=>403, 'message'=>'获取失败')));
			}
			
			
		} else {
			die(json_encode(array('code'=>403, 'message'=>'不存在的formID或不存在的内容ID')));
		}
	}
	
	
}