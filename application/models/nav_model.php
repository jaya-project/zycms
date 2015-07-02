<?php
/**
 * @author church
 * @todo 导航表模型
 * 
 */
class nav_model extends MY_Model
{
	protected $table_name = 'nav';
    
    public function __construct() {
        parent::__construct();
    }
   
	public function get_all($sort=null) 
	{
		if (isset($sort)) {
			return $this->db->order_by($sort)->get($this->table_name)->result('array');
		}
		return $this->db->get($this->table_name)->result('array');
	}
	
}
