<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class User extends FRONT_Controller {



    public function __construct() {

        parent::__construct();



        $this->load->model('member_model');

        parent::common();



    }



    public function registered()

    {

        if ($this->data['isLogin']) {

            // $this->api->echo_message('你已经登录了,请先退出再注册');

            return;

        }

        $this->data['title'] = '顶盛注册';

        $this->data['keywords'] = '顶盛注册';

        $this->data['description'] = '顶盛注册';

        $registered = $this->input->post('operating');

        if (!empty($registered) && 'registered' == $registered) {

            $username = htmlentities(trim($this->input->post('username')));

            $userpass = htmlentities(trim($this->input->post('userpass')));

            $userpass2 = htmlentities(trim($this->input->post('userpass2')));

             $mobile = htmlentities(trim($this->input->post('mobile')));

            $validate = $this->input->post('validate');

            if (empty($username)|| empty($userpass)) {

                $this->api->echo_message('用户名或密码不能为空, 请重新输入');
                return;

            }

            if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$this->input->post('username'))){ //不允许特殊字符
                $this->api->echo_message('用户名不能包含特殊字符, 请重新输入');
                return;
            }

            if (strlen($username)< 5 || strlen($username)< 5) {

                $this->api->echo_message('用户名或密码不能小于5位, 请重新输入');
                return;

            }

            if ($userpass != $userpass2) {

                $this->api->echo_message('两次密码输入不一致, 请重新输入');
                return;

            }

            if (!empty($username)) {

                $query = $this->db->query("SELECT username FROM zycms_member WHERE username='$username'");

                if ($query->num_rows() > 0) {

                    $this->api->echo_message('该用户已存在, 请重新输入');
                    return;

                }

            }

            if (strtolower($this->session->userdata('code')) == strtolower($validate)) {

                $userpass = hash('sha1', $userpass);



                $userid = $this->member_model->add($username, $userpass, $mobile);

                if (!empty($userid)) {

                    $userdata = array(

                       'username' => $username,

                       'id'   => $userid

                    );

                    $this->session->set_userdata('user', $userdata);


                    echo "<script> alert('注册成功'); </script>";
                    echo "<meta http-equiv='Refresh' content='0;URL=/'>";

                }

            } else {

                $this->api->echo_message('验证码错误, 请重新输入');

                return;

            }

        }else{

            $this->view('registered',$this->data);

        }



        return;



    }



    public function login()

    {

        if ($this->data['isLogin']) {

            // $this->api->echo_message('你已经登录了,无需再次登录');

            return;

        }

        $this->data['title'] = '顶盛登录';

        $this->data['keywords'] = '顶盛登录';

        $this->data['description'] = '顶盛登录';

        $registered = $this->input->post('operating');

        if (!empty($registered) && 'login' == $registered) {

            $username = htmlentities(trim($this->input->post('username')));

            $userpass = htmlentities(trim($this->input->post('userpass')));

            $validate = $this->input->post('validate');

            if (empty($username)|| empty($userpass)) {

                $this->api->echo_message('用户名或密码不能为空, 请重新输入');
                return;

            }

            if (strlen($username)<5 || strlen($username)<5) {

                $this->api->echo_message('用户名或密码不能小于5位, 请重新输入');
                return;

            }



            if (strtolower($this->session->userdata('code')) == strtolower($validate)) {

                $userpass = hash('sha1', $userpass);

                $data = $this->member_model->select($username, $userpass);



                if (!empty($data)) {

                    $userdata = array(



                       'username' => $data['username'],

                       'id'   => $data['id']



                    );

                    $this->session->set_userdata('user', $userdata);


                     echo "<script> alert('登录成功'); </script>";
                    echo "<meta http-equiv='Refresh' content='0;URL=/'>";



                } else {

                    $this->api->echo_message('用户名或密码错误, 请重新输入');
                    return;

                }

            } else {

                $this->api->echo_message('验证码错误, 请重新输入');
                return;

            }

        } else {

            $this->view('login',$this->data);

        }



        return;



    }



    public function logout()

    {



        $this->session->unset_userdata('user');

        $this->api->echo_message('退出成功');

        return;

    }



}

