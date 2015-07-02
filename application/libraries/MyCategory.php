<?php

/**
 *  树状分类
 */

class MyCategory
{
	private $CI;
	
	private $model;
	
	public function __construct($model='') {
		$this->CI = &get_instance();
		$this->CI->load->database();
		$this->CI->load->helper(array('array'));
		$this->set_model($model);
	}
	
	/**
	 *  设置模型
	 */
	public function set_model($model='') {
		$this->model = $model;
		empty($this->model) || $this->CI->load->model($this->model);
		return $this;
	}
	
	/**
	 *  获取分类树
	 */
	public function get_category_tree() {
		$model = $this->model;
		$categories = $this->CI->$model->get_all();
		$new_categories = array();
		foreach($categories as $key=>$value) {
			$new_categories[$value['id']] = $value;
		}
		$categories = gen_tree($new_categories, 'pid');
		return $categories;
	}
	
	/**
	 *  获取分类hash
	 */
	public function get_category_hash() {
		$categories = $this->get_category_tree();
		return getTreeData($categories);
	}
	
	/**
	 *  获取分类下的子分类
	 */
	public function get_sub_category($pid) {
		$categories = $this->get_category_tree();
		$sub_tree = get_node_children($categories, $pid);
		return $sub_tree;
	}
	

}