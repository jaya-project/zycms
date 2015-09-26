<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  消息控制器
 */
class Message extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('message_model'));
		$this->load->library(array('session', 'MyCategory'));
		$this->load->helper(array('array', 'url'));
		
	}
	
	public function send_message() 
	{
		$data = $this->input->stream();
		
		if (isset($data['pid'])) {
			$row = $this->message_model->get_one($data['pid']);
			$data['level'] = intval($row['level']) + 1;
		}
		
		if (isset($data['title']) && isset($data['content'])) {
			if ($this->message_model->insert(array_merge(array('mid'=>0, 'pid'=>0, 'create_time'=>time(), 'level'=>1), $data))) {
				die(json_encode(array('code'=>200, 'message'=>'发送成功')));
			} else {
				die(json_encode(array('code'=>403, 'message'=>'发送失败')));
			}
		} else {
			die(json_encode(array('code'=>403, 'message'=>'标题和内容不能为空')));
		}
	}
	
	public function get_reply_message() {
		$data = $this->input->stream();
		
		$messages = $this->message_model->get_all_by_condition();
		
		$new_messages = array();
		
		foreach($messages as $key=>$value) {
			$new_messages[$value['id']] = $value;
		}
		
		$messages = gen_tree($new_messages, 'pid');
		
		
		$reply_messages = find_grand_node($messages, $data['id']);
		
		if (is_array($reply_messages) && !empty($reply_messages)) {
			
			if (!empty($reply_messages['children'])) {
				die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$this->render_html($reply_messages['children']))));
			} else {
				die(json_encode(array('code'=>200, 'message'=>'获取成功')));
			}
			
			
			
		} else {
			
			die(json_encode(array('code'=>403, 'message'=>'获取失败')));
			
		}
		
	}
	
	
	private function render_html($messages) {
		$html = '';
		
		foreach ($messages as $k=>$v) {
			$v['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
			$v['username'] = empty($v['mid']) ? '系统' : $v['username'];
			$left = ($v['level'] - 1) * 50 . 'px';
			
			$html .= "<dl style='margin-left:$left;'>";
			$html .= "<dt>标题: <h2>$v[title]</h2> <span>回复人: $v[username]</span> <a href='javascript:void(0)' ng-click='deleteMessage($v[id], ".'$event.target'.")'>删除</a> <a href='javascript:void(0)' ng-click='showReplyUI($v[id])'>回复</a></dt>";
			$html .= "<dd><p>$v[content]</p> 回复时间 : <span>$v[create_time]</span></dd>";
			$html .= "</dl>";
			
			if (isset($v['children']) && !empty($v['children'])) {
				$html .= $this->render_html($v['children']);
			}
		}
		
		return $html;
	}
	
	public function bat_delete() 
	{
		$data = $this->input->stream();
		
		$ids = array();
		
		array_walk($data['ids'], function($item, $index) use (&$ids) {
			
			$arr_message = $this->mycategory->set_model('message_model')->get_sub_category($item);
			
			$ids = array_merge($ids, $arr_message);
		});
		
		$ids = implode(',', $ids);
			
		if ($this->message_model->delete_where("id in ($ids)")) {
			$response_data['code'] = 200;
			$response_data['message'] = '删除成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '删除失败';
		}
		
		die(json_encode($response_data));
		
	}
	
	public function search_message()
	{
		$data = $this->input->stream();
		
		$where = 'm.pid=0';
				
		
		if (isset($data['id'])) {
			
			$where .= " AND m.mid=$data[id]";
			
		}
		
		$messages = $this->message_model->get_all_by_condition($where);
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$messages)));
	}
	
	public function get_all()
	{
		$data = $this->input->stream();
		
		if (isset($data['id'])) {
		
			$messages = $this->message_model->get_all_by_condition("m.pid=$data[id]");
				
			die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$messages)));
			
			
		} else {
			die(json_encode(array('code'=>403, 'message'=>'不正确的ID')));
		}
	}
	
	public function save()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['name']) && isset($data['pid'])) {
			
			if ($data['is_edit']) {
				$this->edit($data);
			} else {
				$this->add($data);
			}
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '广告名称或广告位不能为空';
		}
		
		die(json_encode($response_data));
	}
	
	private function add($data)
	{
		$data = array_diff_key($data, array('is_edit'=>1));
		if ($this->message_model->insert($data)) {
			$response_data['code'] = 200;
			$response_data['message'] = '添加成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '添加失败';
		}
		
		die(json_encode($response_data));
	}

	
	public function get_specify_ad()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['id']) && !empty($data['id'])) {
			if ($data = $this->message_model->get_one($data['id'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '获取失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的ID或ID为空';
		}
		
		die(json_encode($response_data));
		
	}
	
	private function edit($data)
	{
		if ($row = $this->message_model->get_one($data['id'])) {
			if ($row['thumb'] != $data['thumb']) {
				@unlink('.'.$row['thumb']);
			}
		}
		
		if ($this->message_model->update($data['id'], array_diff_key($data, array('is_edit'=>1, 'id'=>1)))) {
			
			$response_data['code'] = 200;
			$response_data['message'] = '更新成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '更新失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function delete()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['id']) && !empty($data['id'])) {
			
			$arr_message = $this->mycategory->set_model('message_model')->get_sub_category($data['id']);
		
			$ids = implode(',', $arr_message);
			
			if ($this->message_model->delete_where("id in ($ids)")) {
				$response_data['code'] = 200;
				$response_data['message'] = '删除成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '删除失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的ID或ID为空';
		}
		
		die(json_encode($response_data));
	}
	
	
}