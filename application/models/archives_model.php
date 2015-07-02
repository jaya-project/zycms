<?php
/**
 * @author church
 * @todo 文章表模型
 * 
 */
class Archives_model extends MY_Model
{
	protected $table_name = 'archives';
    
    public function __construct() {
        parent::__construct();
    }
	
	public function count_all($condition = '', $start = 0, $length = 10)
	{
		$this->db->select('1');
		
		$this->db->from($this->table_name . ' as a');
		
		$this->db->join('column as c', ' a.cid=c.id', 'left');
		
		empty($condition) ? '' : $this->db->where($condition);
		
		return $this->db->get()->num_rows();
	}
    

	public function get_all_after_search($condition = '', $start = 0, $length = 10)
	{
		$this->db->select('a.id, a.title, a.sort, c.column_name');
		
		$this->db->from($this->table_name . ' as a');
		
		$this->db->join('column as c', ' a.cid=c.id', 'left');
		
		empty($condition) ? '' : $this->db->where($condition);
		
		$this->db->limit($length, $start);
		
		return $this->db->get()->result_array();
		
		
	}
	
}
