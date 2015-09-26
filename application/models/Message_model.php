<?php
/**
 * @author church
 * @todo 广告表模型
 * 
 */
class message_model extends MY_Model
{
	protected $table_name = 'message';
    
    public function __construct() {
        parent::__construct();
    }
    
	public function get_all_by_condition($where="1=1")
	{
		$this->db->select('m.id, m.title, m.content, m.mid, m.pid, m.create_time, me.true_name, me.username, m.level');
		$this->db->from($this->table_name." as m");
		$this->db->join('member as me', 'm.mid=me.id', 'left');
		$this->db->where($where);
		return $this->db->get()->result_array();
	}
}
