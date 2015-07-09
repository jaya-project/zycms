<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  生成静态控制器
 */
class Build_html extends Admin_Controller {
	
	const SINGLEPAGE = 1;
	const LISTPAGE = 2;
	const DETAILPAGE = 3;
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('column_model', 'rule_model', 'archives_model'));
		$this->load->library(array('session', 'Pinyin', 'MyCategory'));
		$this->load->helper(array('array', 'url', 'file'));
		
	}
	
	public function get_rule()
	{
		$response_data = array();
		$data = $this->rule_model->get_all();
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $data;
		
		die(json_encode($response_data));
		
	}
	
	public function save_rule()
	{
		$data = $this->input->stream();
		
		if ($this->rule_model->delete_where("1=1") && $this->rule_model->multiple_insert($data['rules'])) {
			
			die(json_encode(array('code' => 200, 'message' => '保存成功', 'data' => $this->rule_model->get_all())));
		} else {
			die(json_encode(array('code' => 403, 'message' => '保存失败')));
		}
	}
	
	public function build_html()
	{
		//更新首页
		$this->build(array('destination_rule' => 'index.html', 'source_rule' => 'welcome/index'));
		
		//更新栏目
		$this->db->select('c.id, c.column_name, r.destination_rule, r.source_rule, r.type');
		$this->db->from('column as c');
		$this->db->join('rule as r', 'c.id=r.cid', 'left');
		
		$columns = $this->db->get()->result_array();
		
		foreach ($columns as $k=>$v) {
			if ($v['type'] == self::LISTPAGE) {
				$this->build_list($v);
			} else if ($v['type'] == self::DETAILPAGE) {
				$this->build_detail($v);
			} else {
				$this->build_single($v);
			}
		}
		
		die(json_encode(array('code'=>200, 'message' => '更新成功')));
	}
	
	private function build($v)
	{
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'http') !== FALSE ? 'http://' : 'https://';
		
		$host = $_SERVER['HTTP_HOST'];
		$domain = $protocol . $host . '/';
		
		$content = file_get_contents($domain . $v['source_rule']);
		
		
		$destination = './'.$v['destination_rule'];
		
		$dir = dirname($destination);
		
		@mkdir($dir, 0777, TRUE);
		
		write_file($destination, $content);
		
	}
	
	private function build_list($v)
	{
		$temp = explode('/', $v['source_rule']);
		empty($temp[0]) && array_shift($temp);
		
		$arr_columns = $this->mycategory->set_model('column_model')->get_sub_category($v['id']);
		$str_cid = implode(',', $arr_columns);
		
		$record_count = $this->db->where("cid in ($str_cid)")->get('archives')->num_rows();
		
		$page_count = ceil($record_count / $temp[4]);
		
		$page_count == 0 && $page_count = 1;
		
		for ($i=1; $i <= $page_count; $i++) {
			$temp = $v;
			
			$temp['destination_rule'] = str_replace('page', $i, $temp['destination_rule']);
			$temp['source_rule'] = str_replace('page', $i, $temp['source_rule']);
			
			$this->build($temp);
		}
		
		
		
	}
	
	private function build_single($v)
	{
		$this->build($v);
	}
	
	private function build_detail($v)
	{
		$articles = $this->archives_model->get_where($v['id']);
		
		$ids = array_column($articles, 'id');
		
		foreach ($ids as $id) {
			
			$temp = $v;
			
			$temp['destination_rule'] = str_replace('id', $id, $temp['destination_rule']);
			$temp['source_rule'] = str_replace('id', $id, $temp['source_rule']);
			
			$this->build($temp);
			
		}
		
	}
	
	public function build_rule()
	{
		$pinyin = $this->pinyin;
		
		$columns = $this->column_model->get_all();
		
		$rules = array();
		
		foreach ($columns as $k=>$v) {
			$table_name = $this->get_table_by_column($v['id']);
			
			$column_name = $pinyin::getPinyin($v['column_name']);
			
			$rules[] = array(
							'cid' => $v['id'],
							'destination_rule' => $column_name . '.html',
							'source_rule' => $column_name . '/index',
							'type' => 1
						);
						
			$rules[] = array(
							'cid' => $v['id'],
							'destination_rule' => $table_name . "/category/$v[id]-page.html",
							'source_rule' => $table_name . "/category/$v[id]/page/12",
							'type' => 2
						);
			
			$rules[] = array(
							'cid' => $v['id'],
							'destination_rule' => $table_name . "/detail/aid.html",
							'source_rule' => $table_name . "/detail/aid",
							'type' => 3
						);
						
			
		}
		
		if ($this->rule_model->delete_where("1=1") && $this->rule_model->multiple_insert($rules)) {
			
			die(json_encode(array('code' => 200, 'message' => '生成成功', 'data' => $this->rule_model->get_all())));
		} else {
			die(json_encode(array('code' => 403, 'message' => '生成失败')));
		}
		
		
		
	}
	
	
	
	
	/**
	 *  根据栏目ID获取表名
	 */
	private function get_table_by_column($cid)
	{
		$this->db->select('ch.table_name');
		$this->db->from('column as c');
		$this->db->join('channel as ch', 'c.channel_id=ch.channel_id', 'left');
		$this->db->where("c.id=$cid");
		$row = $this->db->get()->row_array();
		return $row['table_name'];
	}
	
}