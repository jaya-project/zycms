<?php
/**
 *  定义了每个模型都有的动作
 *  建议每个自定义的模型都继承该模型
 */
class MY_Model extends CI_Model
{
	protected $table_name = '';
	protected $primary_key = 'id';

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 *  @brief 获取所有记录集
	 */
	public function get_all($sort = null) {
		if (isset($sort)) {
			return $this->db->order_by($sort['field'], $sort['way'])->get($this->table_name)->result('array');
		}
		return $this->db->get($this->table_name)->result('array');
	}

	/**
	 *  @brief 返回一个表所有的记录的条数
	 */
	public function get_all_count() {
		return $this->db->count_all_results($this->table_name);
	}

	/**
	 *  @brief 根据ID获取特定的记录
	 */
	public function get_one($id, $field='all') {

		$field == 'all' ? '' : $this->db->select($field);
		$this->db->where($this->primary_key, $id);
		return $this->db->get($this->table_name)->row_array();
	}

	/**
	 *  @brief 根据键值对数组获取记录集
	 */
	public function get_where($condition) {
		return $this->db->get_where($this->table_name, $condition)->result_array();
	}

	/**
	 *  @brief 获取某个符合where_in 条件的记录集
	 */
	public function get_where_in($arr, $field) {

		$field = isset($field) ? $field : $this->primary_key;
		$this->db->where_in($field, $arr);
		return $this->db->get($this->table_name)->result_array();
	}

	/**
	 *  @brief 根据自定义条件获取记录集
	 */
	public function get_where_customer($condition) {
		$this->db->where($condition);
		return $this->db->get($this->table_name)->result_array();
	}

	/**
	 *  @brief 根据ID更新指定的记录
	 */
	public function update($id, $data) {

		return $this->update_where_customer("$this->primary_key = $id", $data);
	}


	/**
	 *  @brief 批量更新数据
	 */
	public function update_where($field, $arr, $data) {
		$this->db->where_in($field, $arr);
		return $this->db->update($this->table_name, $data);
	}

	/**
	 *  @brief 根据条件更新记录
	 */
	public function update_where_customer($where, $data) {
		$this->db->where($where);
		return $this->db->update($this->table_name, $data);
	}

	/**
	 *  @brief 插入多条数据
	 */
	public function multiple_update($arr_data) {
		$state = True;
		array_walk($arr_data, function($item) {
			$state = self::update_where_customer($item['where'], $item['data']);
		});
		return $state;
	}

	/**
	 *  @brief 如果插入成功,返回新记录的主键. 失败则返回false
	 */
	public function insert($data) {
		return $this->db->insert($this->table_name, $data);
	}


	/**
	 *  @brief 删除指定的记录
	 */
	public function delete($id) {
		return $this->db->where($this->primary_key, $id)->delete($this->table_name);
	}

	/**
	 *  根据自定义条件删除记录集
	 */
	public function delete_where($condition) {
		$this->db->where($condition);
		return $this->db->delete($this->table_name);
	}


	/**
	 *  @brief 根据某个条件判断是否存在此条记录
	 *  @return boolean
	 *
	 */
	public function is_exists($condition) {
		return ($this->db->where($condition)->get($this->table_name)->num_rows() ? True : False);
	}

	/**
	 *  @brief 插入多条数据
	 */
	public function multiple_insert($data) {
		$state = True;

		foreach ($data as $k=>$v) {
			$state = self::insert($v);
		}

		return $state;

	}

	/**
	 *  @brief 获取新增记录ID
	 */
	public function get_insert_id() {
		return $this->db->insert_id();
	}
}
