<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends FRONT_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('form_model');
		$this->load->helper(['array', 'email']);
		$this->header_template = '';
		$this->footer_template = '';
	}
	
	public function submit()
	{
		$data = $this->input->post();
		
		if (isset($data['formId']) && !empty($data['formId'])) {
			if ($row = $this->form_model->get_one($data['formId'])) {
				
				$table_struct = unserialize($row['table_struct']);
				
				$d_data = [];
				
				$body = '';
				
				foreach ($table_struct as $key=>$value) {
					$d_data[$value['fields']] = isset($data[$value['fields']]) ? $data[$value['fields']] : '';
					$body .= "<p><span>$value[label_fields] : </span> <span>".$data[$value['fields']]."</span></p>";
				}
				
				if ($this->db->insert($row['table_name'], $d_data)) {
					
					if (!empty($row['recevied']) && valid_email($row['recevied'])) {
						$this->sendEmail($row['recevied'], $body);
					}
					
				}
				
				
			} else {
				die('不存在的表单');
			}
		} else {
			die('需要表单ID');
		}
	}
	
	private function sendEmail($recevied, $body)
	{
		//获取配置参数
		$this->config->load('system', True);
		$temp = $this->config->item('system');
		$conf = $temp['system_set'];
		
		//发送邮件
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $conf['smtp_server'];
		$config['smtp_user'] = $conf['smtp_user'];
		$config['smtp_pass'] = $conf['smtp_password'];
		$config['smtp_port'] = $conf['smtp_port'];
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = TRUE;
		
		
		$this->email->initialize($config);
		
		$this->email->from($config['smtp_user'], '朝阳CMS系统');
		$this->email->to($recevied);
		
		$this->email->subject('系统邮件');
		$this->email->message($body);
		
		$this->email->send();
		
		echo $this->email->print_debugger();
		
	}
}