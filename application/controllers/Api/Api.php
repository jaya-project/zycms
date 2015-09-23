<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  http://domain.net/Api
 *  post {service:"login", "time":"1442916092", "sign":"2831137eac84bd9720c2b2e92f742a5"}
 *  return {return_code:[success|failed], result_code:[success|failed], "msg":"错误或正确信息", "return_time":"2015-09-12"}
 *  说明: return_code 是请求的状态
 *        result_code 是请求结果的状态
 *  对外暴露接口
 *  @author church 
 */
class Api extends CI_Controller {
	
    //访问令牌
    const ACCESSTOKEN = '2831137eac84bd9720c2b2e92f742a51';

	public function __construct() {
		parent::__construct();
        $this->load->library('session');
	}

    /**
     * 授权登录方法
     *
     */
    public function login()
    {
        $data = $this->input->post();
        $data = json_decode($data['data'], true);
        if ($this->__validate_sign($data)) {
            $this->session->set_userdata('admin', array(
                'id'    =>  0,
                'rid'   =>  0,
                'username' => ''
            ));

            $this->__send_message_to_client(array(
                'return_code' => 'success',
                'result_code' => 'success',
                'msg'         => '登录成功',
                'return_time' => date('Y-m-d H:i:s', time())
            ));
        } else {
            $this->__send_message_to_client(array(
                'return_code' => 'success',
                'result_code' => 'failed',
                'msg'         => '不正确的签名',
                'return_time' => date('Y-m-d H:i:s', time())
            ));
        }
    }


    /**
     * 发送反馈信息
     * @param array $response_data
     * @return string [json format message]
     *
     */
    private function __send_message_to_client($response_data)
    {
        die(json_encode($response_data));
    }

    /**
     * 验证签名
     * @param array $request_data
     * @return boolean [签名是否正确]
     *
     */
    private function __validate_sign($request_data)
    {
        $sign = $request_data['sign'];
        unset($request_data['sign']);
        ksort($request_data);
        $request_data['access_token'] = self::ACCESSTOKEN;
        if (md5(http_build_query($request_data)) == $sign) {
            return true;
        } else {
            return false;
        }
    }
	
	
}
