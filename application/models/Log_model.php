<?php
/**
 * @author church
 * @todo 操作日志表模型
 * 
 */
class log_model extends MY_Model
{
	protected $table_name = 'opera_log';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_pages($where = '1=1', $length = 15)
    {
        $this->db->select('1');
        $this->db->from($this->table_name);
        $this->db->where($where);
        $count = $this->db->get()->num_rows();
        return ceil($count / $length); 
    }    

    public function get_limit_length($page = 1, $length = 15, $where = '1=1')
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->limit($length, $page*$length);
        return $this->db->get()->result_array();
    }
	
	
}
