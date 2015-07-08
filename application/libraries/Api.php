<?php
/**
 *  前端API
 *  @author church
 *  @date 2015-07-02
 */
 
class Api
{
	//CI实例
	public $CI;
	
	public function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->database();
		$this->CI->load->model(array('column_model', 'flink_model', 'piece_model','archives_model'));
		$this->CI->load->helper(array('array'));
		$this->CI->load->library(array('MyCategory'));
	}
	
	/**
	 *  获取导航信息
	 *  
	 *  @param $position 位置 1:顶部 2:尾部
	 *  
	 *  return array
	 */
	public function get_nav($position)
	{
		$navs = $this->CI->db->where("position=$position")->order_by('sort asc')->get('nav')->result_array();
		
		$new_navs = array();
		
		foreach($navs as $key=>$value) {
			$new_navs[$value['id']] = $value;
		}
		
		$navs = gen_tree($new_navs, 'pid');
		
		return $navs;
	}
	
	/**
	 *  获取系统设置项
	 *  
	 *  return array
	 */
	public function get_conf()
	{
		$this->CI->config->load('system', True);
		$temp = $this->CI->config->item('system');
		return $temp['system_set'];
	}
	
	/**
	 *  获取指定广告位的广告信息
	 *  
	 *  @param $position 广告位ID
	 *  
	 *  return array
	 *  
	 */
	public function get_ad($position)
	{
		
		$ads = $this->CI->db->where("pid=$position")->order_by('sort asc')->get('ad')->result_array();
		
		return $ads;
	}
	
	
	/**
	 *  获取热搜关键词
	 *  
	 *  return array
	 *  
	 */
	public function get_hot_keywords()
	{
		return $this->CI->db->order_by('sort asc')->get('hot_search')->result_array();
	}
	
	
	/**
	 *  获取指定栏目集
	 *  
	 *  @param $pid 父ID
	 *  
	 *  return array
	 */
	public function get_columns($pid=0)
	{
		
		$columns = $this->CI->db->order_by('sort asc')->get('column')->result_array();
		
		$new_columns = array();
		
		foreach($columns as $key=>$value) {
			$new_columns[$value['id']] = $value;
		}
		
		$columns = gen_tree($new_columns, 'pid');
		
		if ($pid == 0) {
			return $columns;
		}
		
		
		return find_grand_node($columns, $pid);
	}
	
	
	/**
	 *  获取指定栏目
	 *  
	 *  @param $id ID
	 *  
	 *  return array
	 */
	public function get_column($id)
	{
		
		return $this->CI->column_model->get_one($id);
	}
	
	
	/**
	 *  获取友情链接
	 *  
	 *  return array
	 */
	public function get_flink()
	{
		return $this->CI->flink_model->get_all();
	}
	
	
	/**
	 *  获取内容碎片
	 *  
	 *  @param $id 内容碎片ID
	 *  
	 *  return array
	 */
	public function get_piece($id)
	{
		return $this->CI->piece_model->get_one($id);
	}
	
	
	
	
	/**
	 *  获取指定栏目下的文章列表
	 *  
	 *  @param $cid 栏目ID
	 *  @param $flag 推荐类型, 如:热门, 最新等 
	 *  @param $page 第$page页
	 *  @param $page_length 页面长度
	 *  
	 *  return array
	 */
	public function get_articles($cid, $flag = '', $page=1, $page_length=12)
	{
		$table_name = $this->get_table_by_column($cid);
		
		$arr_column = $this->CI->mycategory->set_model('column_model')->get_sub_category($cid);
		
		$ids = implode(',', $arr_column);
		
		if (empty($table_name)) {
			return FALSE;
		} else {
			
			$where = '';
			// $where = empty($flag) ? '' : "FIND_IN_SET(ac.recommend_type, '$flag') AND ";
			if (!empty($flag)) {
				$where .= '(';
				foreach(explode(',', $flag) as $k=>$value) {
					$where .= "LOCATE('$value', ac.recommend_type) OR ";
				}
				$where = rtrim($where, 'OR ');
				$where .= ') AND ';
			}
			$where .= "ac.cid in ($ids)";
			
			
			$this->CI->db->select('*');
			$this->CI->db->from('archives as ac');
			$this->CI->db->join($table_name." as a", 'ac.id=a.id', 'left');
			$this->CI->db->order_by('ac.sort asc');
			$this->CI->db->limit($page_length, ($page-1)*$page_length);
			$this->CI->db->where($where);
			
			return $this->CI->db->get()->result_array();
		}
	}
	
	/**
	 *  获取指定栏目下的分页列表
	 *  
	 *  @param $cid 栏目ID
	 *  @param $flag 推荐类型, 如:热门, 最新等 
	 *  @param $page 第$page页
	 *  @param $page_length 页面长度
	 *  
	 *  return array
	 */
	public function get_pages($cid, $flag = '', $page=1, $page_length=12)
	{
		$table_name = $this->get_table_by_column($cid);
		
		$arr_column = $this->CI->mycategory->set_model('column_model')->get_sub_category($cid);
		
		$ids = implode(',', $arr_column);
		
		if (empty($table_name)) {
			return FALSE;
		} else {
			
			$where = '';
			// $where = empty($flag) ? '' : "FIND_IN_SET(ac.recommend_type, '$flag') AND ";
			if (!empty($flag)) {
				$where .= '(';
				foreach(explode(',', $flag) as $k=>$value) {
					$where .= "LOCATE('$value', ac.recommend_type) OR ";
				}
				$where = rtrim($where, 'OR ');
				$where .= ') AND ';
			}
			$where .= "ac.cid in ($ids)";
			
			
			$this->CI->db->select('*');
			$this->CI->db->from('archives as ac');
			$this->CI->db->join($table_name." as a", 'ac.id=a.id', 'left');
			$this->CI->db->order_by('ac.sort asc');
			$this->CI->db->where($where);
			
			$total_count = $this->CI->db->get()->num_rows();
			
			$total_pages = ceil($total_count / $page_length);
			
			return array(
							'pages' => $total_pages,
							'current_page' => $page,
							'prev_page' => ($page > 1 ? $page-1 : 1),
							'next_page' => ($page < $total_pages ? $page+1 : $total_pages),
							'first' => 1,
							'last' => $total_pages,
						);
		}
	}
	
	/**
	 *  获取某篇指定的文章
	 *  
	 *  @param $id 文章ID
	 */
	public function get_article($id) 
	{
		$archive = $this->CI->archives_model->get_one($id);
		
		$table_name = $this->get_table_by_column($archive['cid']);
		
		$row = $this->CI->db->where("id=$id")->get($table_name)->row_array();
		
		return array_merge($archive, $row);
		
	}
	
	/**
	 *  获取某篇文章的上一篇和下一篇
	 *  
	 *  @param $id 文章ID 
	 *  @param $template 模板
	 */
	public function get_prev_next($id, $template=array('prev'=>'<a href="%s" class="prev">上一篇: %s</a>', 'next'=>'<a href="%s" class="next">下一篇: %s</a>'))
	{
		$row = $this->CI->archives_model->get_one($id);
		
		$siblings = $this->CI->db->where("cid={$row['cid']}")->order_by('sort asc')->get('archives')->result_array();
		
		$ids = array_column($siblings, 'id');
		
		
		$current_keys = array_keys($ids, $id);
		
		$current_key = array_shift($current_keys);
		
		$html = array();
		
		if ($current_key == 0) {
			$html['prev'] = array(
									'title' => '没有了',
									'url' => 'javascript:void(0)'
								);
		} else {
			$row = $this->CI->archives_model->get_one($ids[$current_key-1]);
			$html['prev'] = array(
									'title' => $row['title'],
									'url' => build_url($row['id'], $row['cid'], 3)
								);
		}
		
		if ($current_key == sizeof($ids) - 1) {
			$html['next'] = array(
									'title' => '没有了',
									'url' => 'javascript:void(0)'
								);
		} else {
			$row = $this->CI->archives_model->get_one($ids[$current_key+1]);
			$html['next'] = array(
									'title' => $row['title'],
									'url' => build_url($row['id'], $row['cid'], 3)
								);
		}
		
		$html['prev'] = sprintf($template['prev'], $html['prev']['url'], $html['prev']['title']);
		$html['next'] = sprintf($template['next'], $html['next']['url'], $html['next']['title']);
		
		return join(' ', $html);
		
		
	}
	
	
	/**
	 *  获取面包屑导航
	 *  
	 *  @param $id 
	 *  @param $type [list|detail]
	 *  
	 */
	public function get_bread($id, $type, $separator = ' > ') 
	{
		if ($type == 'detail') {
			$row = $this->CI->archives_model->get_one($id);
			$id = $row['cid'];
		}
		
		$bread = array();
		
		$this->build_bread($id, $bread);
		
		array_push($bread, array('title'=>'首页', 'url'=>'/'));
		
		$html = '';
		
		while($arr = array_pop($bread)) {
			$html .= "<a href='{$arr['url']}'>{$arr['title']}</a>  $separator";
		}
		
		return rtrim($html,  $separator);
		
	}
	
	/**
	 *  构造面包屑
	 *  
	 *  递归查找父栏目, 压入栈
	 *  
	 *  @param $id 分类ID
	 *  @param $stack 栈引用
	 */
	private function build_bread($id, &$stack) 
	{
		$row = $this->CI->column_model->get_one($id);
		
		$temp = array(
						'title' => $row['column_name'],
						'url' => build_url(1, $id, 2)
						);
						
		array_push($stack, $temp);
		
		
		if ($row['pid'] == 0) {
			return $stack;
		} else {
			$this->build_bread($row['pid'], $stack);
		}
	}
	
	
	/**
	 *  根据栏目ID获取表名
	 *  
	 *  @param $cid 分类ID
	 */
	private function get_table_by_column($cid)
	{
		$this->CI->db->select('ch.table_name');
		$this->CI->db->from('column as c');
		$this->CI->db->join('channel as ch', 'c.channel_id=ch.channel_id', 'left');
		$this->CI->db->where("c.id=$cid");
		$row = $this->CI->db->get()->row_array();
		return $row['table_name'];
	}
}
