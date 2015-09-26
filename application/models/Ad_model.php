<?php
/**
 * @author church
 * @todo 广告表模型
 * 
 */
class ad_model extends MY_Model
{
	protected $table_name = 'ad';
    
    public function __construct() {
        parent::__construct();
    }
    
	
	public function get_all($sort=NULL) 
	{
		$this->db->select('ad.id, ad.name, p.name ad_position_name, ad.sort');
		$this->db->from($this->table_name.' as ad');
		$this->db->join('ad_position as p', 'ad.pid=p.id', 'left');
		return $this->db->get()->result_array();
	}

	
	
}
