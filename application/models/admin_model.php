<?php
/**
 * @author church
 * @todo 管理员表模型
 * 
 */
class Admin_model extends MY_Model
{

	protected $table_name = 'admin';
    
    public function __construct() {
        parent::__construct();
    }
    
   public function get_all($sort=NULL) {
	   $this->db->select('a.username, a.id, a.rid, r.name role_name');
	   
	   $this->db->from($this->table_name . ' as a');
	   
	   $this->db->join('role as r', 'a.rid=r.id', 'left');
	   
	   if (is_array($sort) && !empty($sort)) {
			$this->db->order_by($sort['field'], $sort['way']);
	   }
	   
	   $this->db->where("a.rid!=0");
	   
	   return $this->db->get()->result_array();
   }

	
}
