<?php
/**
 * @author church
 * @todo 广告表模型
 * 
 */
class member_model extends MY_Model
{
	protected $table_name = 'member';
    
    public function __construct() {
        parent::__construct();
    }
    
	public function get_one_by_condition($id, $field='all')
	{
		$fields = $field == 'all' ? '*' : $field;
		$this->db->select($fields);
		
		$this->db->from($this->table_name." as m");
		$this->db->join('provinces as p', 'm.province=p.provinceid', 'left');
		$this->db->join('cities as c', 'm.city=c.cityid', 'left');
		$this->db->join('areas as a', 'm.district=a.areaid', 'left');
		$this->db->where("m.id=$id");
		return $this->db->get()->row_array();
	}
	
	
}
