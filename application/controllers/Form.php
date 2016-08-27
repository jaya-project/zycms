<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Form extends FRONT_Controller {



	public function __construct() {

		parent::__construct();

		$this->load->database();

		$this->load->model('form_model');

		$this->load->library(array('MyCaptcha', 'session'));

		$this->load->helper(array('array', 'email'));

		$this->header_template = '';

		$this->footer_template = '';

	}



	public function get_code()

	{



		  $code = $this->mycaptcha->getCaptcha();

		  $this->session->set_userdata('code', $code);

		  $this->mycaptcha->showImg();



	}



	public function submit()

	{

		$data = $this->input->post();



		if (empty($data['validate']) || strtolower($data['validate']) != strtolower($this->session->userdata('code'))) {

			echo '<script type="text/javascript">alert("不正确的验证码"); window.history.back();</script>';

			die;

		}



		if (isset($data['formId']) && !empty($data['formId'])) {

			if ($row = $this->form_model->get_one($data['formId'])) {



				$table_struct = unserialize($row['table_struct']);



				$d_data = array();



				$body = '';



				foreach ($table_struct as $key=>$value) {

					$d_data[$value['fields']] = isset($data[$value['fields']]) ? $data[$value['fields']] : '';

					$body .= "<p><span>$value[label_fields] : </span> <span>".$data[$value['fields']]."</span></p>";

				}



				if ($this->db->insert($row['table_name'], $d_data)) {



					if (!empty($row['recevied']) && valid_email($row['recevied'])) {

						$this->sendEmail($row['recevied'], $body);

					}



					$redirect_uri = isset($data['redirect_uri']) ? $data['redirect_uri'] : '/welcome/index';



					echo '<script type="text/javascript">alert("提交成功"); window.location.href=\''.$redirect_uri.'\';</script>';

					die;



				} else {

					echo '<script type="text/javascript">alert("提交失败"); window.history.back();</script>';

					die;

				}





			} else {

				echo '<script type="text/javascript">alert("不存在的表单"); window.history.back();</script>';

				die;

			}

		} else {

			echo '<script type="text/javascript">alert(“需要表单ID"); window.history.back();</script>';

			die;

		}

	}



	// private function sendEmail($recevied, $body)

	// {

	// 	//获取配置参数

	// 	$this->config->load('system', True);

	// 	$temp = $this->config->item('system');

	// 	$conf = $temp['system_set'];



	// 	//发送邮件

	// 	$this->load->library('email');

	// 	$config['protocol'] = 'smtp';

	// 	$config['smtp_host'] = $conf['smtp_server'];

	// 	$config['smtp_user'] = $conf['smtp_user'];

	// 	$config['smtp_pass'] = $conf['smtp_password'];

	// 	$config['smtp_port'] = $conf['smtp_port'];

	// 	$config['mailtype'] = 'html';

	// 	$config['charset'] = 'utf-8';

	// 	$config['validate'] = TRUE;





	// 	$this->email->initialize($config);



	// 	$this->email->from($config['smtp_user'], '朝阳CMS系统');

	// 	$this->email->to($recevied);



	// 	$this->email->subject('系统邮件');

	// 	$this->email->message($body);



	// 	$this->email->send();



	// 	echo $this->email->print_debugger();



	// }
	//
	//https://github.com/PHPMailer/PHPMailer
	//use  :  composer require phpmailer/phpmailer
	//
	private function sendEmail($recevied, $body)

    {

        //获取配置参数

        $this->config->load('system', True);

        $temp = $this->config->item('system');

        $conf = $temp['system_set'];




        $mail = new PHPMailer();

        // $mail->SMTPDebug = 4;
        $mail->isSMTP();
        $mail->Host = $conf['smtp_server'];
        $mail->SMTPAuth = true;
        $mail->Username = $conf['smtp_user'];
        $mail->Password = $conf['smtp_password'];
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->Port = $conf['smtp_port'];
        $mail->setFrom($conf['smtp_user'], '朝阳cms');
        $mail->addAddress($recevied, 'xxx');
        $mail->Subject = '这是来xxx网站上的留言';
        $mail->Body    = $body;

        $mail->send();
       if(!$mail->send()) {
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo '提示:';
        }

    }

        private function send114Email($recevied, $body)

    {

        //获取配置参数
        // 'smtp_server' => 'mail.114my.cn',
        // 'smtp_port' => '',
        // 'smtp_email' => 'sendsmtp@114my.cn',
        // 'smtp_user' => 'sendsmtp@114my.cn',
        // 'smtp_password' => 'abctu22020336',

        $this->config->load('system', True);

        $temp = $this->config->item('system');

        $conf = $temp['system_set'];

        $mail = new PHPMailer();

        // $mail->SMTPDebug = 4;
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        $mail->Host = $conf['smtp_server'];
        $mail->SMTPAuth = true;
        $mail->Username = $conf['smtp_user'];
        $mail->Password = $conf['smtp_password'];
        // $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        // $mail->Port = $conf['smtp_port'];
        $mail->setFrom($conf['smtp_user'], '朝阳cms');
        $mail->addAddress($recevied, 'xxx网站');
        $mail->Subject = '这是来南城直递兼职表内容的提交';
        $mail->Body    = $body;

       if(!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }

    }


}