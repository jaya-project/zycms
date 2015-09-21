<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends Admin_Controller {
	
    const PAGELENGTH = 15;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('log_model'));
	}

    public function get_data()
    {
        $data = $this->input->stream();
        $page = isset($data['page']) ? $data['page'] : 1;
        $page--;

        $where = '1=1 AND ';
        if (isset($data['start_time']) && !empty($data['start_time'])) {
            $where .= "opera_time >= ". strtotime($data['start_time']). " AND ";
        }

        if (isset($data['end_time']) && !empty($data['end_time'])) {
            $where .= "opera_time <= ". strtotime($data['end_time']). " AND ";
        }

        if (isset($data['user']) && !empty($data['user'])) {
            $where .= "user like  '%$data[user]%' AND ";
        }

        $where = rtrim($where, 'AND ');
        
        $logs = $this->log_model->get_limit_length($page, self::PAGELENGTH, $where);

        $total_pages = $this->log_model->get_pages($where, self::PAGELENGTH);

        
        if ($logs) {
            array_walk($logs, function(&$item) {
                $item['ip'] = long2ip($item['ip']);
                $item['opera_time'] = date('Y-m-d H:i:s', $item['opera_time']);
            });
        }

        die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>array('data'=>$logs, 'total_pages'=>$total_pages, 'current_page'=>$page+1))));
    }

    public function delete_data()
    {
        $data = $this->input->stream();

        if ($this->log_model->delete($data['id'])) {
            die(json_encode(array('code'=>200, 'message'=>'删除成功')));
        } else {
            die(json_encode(array('code'=>403, 'message'=>'删除失败')));
        }
    }
	

    public function clean()
    {
        if ($this->log_model->delete_where('1=1')) {
            die(json_encode(array('code'=>200, 'message'=>'清空成功')));
        } else {
            die(json_encode(array('code'=>403, 'message'=>'清空失败')));
        }
    }
}
