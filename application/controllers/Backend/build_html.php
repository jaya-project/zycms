<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  生成静态控制器
 */
class Build_html extends Admin_Controller {
	
	const SINGLEPAGE = 1;
	const LISTPAGE = 2;
	const DETAILPAGE = 3;
	
	private $columns = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('column_model', 'rule_model', 'archives_model'));
		$this->load->library(array('session', 'Pinyin', 'MyCategory'));
		$this->load->helper(array('array', 'url', 'file'));
		
		$columns = $this->column_model->get_all(array('field'=>'sort', 'way'=>'asc'));
		
		$new_columns = array();
		foreach($columns as $key=>$value) {
			$new_columns[$value['id']] = $value;
		}
		$this->columns = gen_tree($new_columns, 'pid');
		
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
	
	public function build_index_html()
	{
		// Load the routes.php file.
		if (file_exists(APPPATH.'config/routes.php'))
		{
			include(APPPATH.'config/routes.php');
		}

		if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
		}
		
		$index_controller_method = $route['default_controller'] . '/index';
		
		$this->build(array('destination_rule'=>'index.html', 'source_rule'=>$index_controller_method));
		
		if (file_exists('./index.html')) {
			die(json_encode(array('code'=>200, 'message'=>'生成成功')));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'生成失败')));
		}
	}
	
	/**
	 *  生成静态页面
	 */
	public function build_html()
	{
		//生成之前先删除已经生成的html文件
		// $this->_delete_already_exists_static_file();
		
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
	
	/**
	 *  只针对某条规则生成
	 */
	public function build_single_html()
	{
		$data = $this->input->stream();
		
		$this->db->select('c.id, c.column_name, r.destination_rule, r.source_rule, r.type');
		$this->db->from('column as c');
		$this->db->join('rule as r', 'c.id=r.cid', 'left');
		$this->db->where("r.id=$data[id]");
		
		
		$row = $this->db->get()->row_array();
		
		if ($row['type'] == self::LISTPAGE) {
			$this->build_list($row);
		} else if ($row['type'] == self::DETAILPAGE) {
			$this->build_detail($row);
		} else {
			$this->build_single($row);
		}
			
		die(json_encode(array('code'=>200, 'message' => '更新成功')));
	}
	
	/**
	 *  生成某一个页面
	 */
	private function build($v)
	{
		
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'http') !== FALSE ? 'http://' : 'https://';
		
		$host = $_SERVER['HTTP_HOST'];
		$domain = $protocol . $host . '/';
		
		// $content = file_get_contents($domain . $v['source_rule']);
		
		$ch = curl_init();
		
		$options =  array(
			CURLOPT_URL => $domain . $v['source_rule'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => array('Content-Type: text/html'),
		);
		
		curl_setopt_array($ch, $options);
		
		$content = curl_exec($ch);
		
		
		$destination = './'.$v['destination_rule'];
		
		
		$dir = dirname($destination);
		
		
		
		@mkdir($dir, 0777, TRUE);
		
		write_file($destination, $content);
		
	}
	
	/**
	 *  生成某个栏目列表
	 */
	private function build_list($v)
	{
		$temp = explode('/', $v['source_rule']);
		empty($temp[0]) && array_shift($temp);
		
		// $arr_columns = $this->mycategory->set_model('column_model')->get_sub_category($v['id']);
		// $str_cid = implode(',', $arr_columns);
		
		$ids = get_node_children($this->columns, $v['id']);
		
		$str_cid = implode(',', $ids);
		
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
	
	
	/**
	 *  生成某个单页
	 */
	private function build_single($v)
	{
		$this->build($v);
	}
	
	/**
	 *  生成详细页面
	 */
	private function build_detail($v)
	{
		
		$articles = $this->archives_model->get_where("cid=$v[id]");
		
		$ids = array_column($articles, 'id');
		
		
		foreach ($ids as $id) {
			
			$temp = $v;
			
			$temp['destination_rule'] = str_replace('aid', $id, $temp['destination_rule']);
			$temp['source_rule'] = str_replace('aid', $id, $temp['source_rule']);
			
			$this->build($temp);
			
		}
		
	}
	
	public function build_rule()
	{
		$pinyin = $this->pinyin;
		
		$columns = $this->column_model->get_all();
		
		$rules = array();
		
		if (file_exists(APPPATH.'config/routes.php'))
		{
			include(APPPATH.'config/routes.php');
		}

		if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
		}
		
		$index_controller_method = $route['default_controller'] . '/index';
		
		$rules[] = array(
							'cid' => 0,
							'destination_rule' => 'index.html',
							'source_rule' => $index_controller_method,
							'type' => 1
						);
		
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
							'destination_rule' => $column_name . "/$v[id]-page.html",
							'source_rule' => $table_name . "/category/$v[id]/page/12",
							'type' => 2
						);
			
			$rules[] = array(
							'cid' => $v['id'],
							'destination_rule' => $column_name . "/aid.html",
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
	 *  删除已经生成的旧静态文件
	 *  只清除根目录的静态文件
	 */
	private function _delete_already_exists_static_file() 
	{
		$handle = dir('./');
		while(false !== ($entry=$handle->read())) {
			if (!is_dir($entry)) {
				if (($extend = substr($entry, strrpos($entry, '.')+1)) == 'html') {
					@unlink('./'.$entry);
				}
			}
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