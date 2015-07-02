<?php
/**
 * @author church
 * @todo 角色表模型
 * 
 */
class role_model extends MY_Model
{
	protected $table_name = 'role';
    
    public function __construct() {
        parent::__construct();
    }
   

   public function get_one($id, $field ='all')
   {
	   $this->db->select('r.name, r.id, GROUP_CONCAT(re.rid) rid');
	   $this->db->from($this->table_name. ' as r');
	   $this->db->join('relationship as re', 're.roleid=r.id', 'left');
	   $this->db->where('r.id='.$id);
	   $this->db->group_by('r.id');
	   
	   return $this->db->get()->row_array();
   }
	
}
