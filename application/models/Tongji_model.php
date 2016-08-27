<?php
/**
 * @author church
 * @todo 广告表模型
 *
 */
class tongji_model extends MY_Model
{
	protected $table_name = 'tongji';

    public function __construct() {
        parent::__construct();
    }

	public function get_browser()
	{
		$this->db->select('user_agent, count(1) count');
		$this->db->from('tongji');
		$this->db->group_by('user_agent');
		return $this->db->get()->result_array();
	}

	public function get_pv()
	{
		$this->db->select('date, count(1) count');
		$this->db->from('tongji');
		$this->db->group_by('date');
		return $this->db->get()->result_array();
	}

	public function get_uv()
	{
		$this->db->select('date, count(distinct ip) count');
		$this->db->from('tongji');
		$this->db->group_by('date');
		return $this->db->get()->result_array();
	}

	public function get_referer()
	{
		$this->db->select('referer, count(1) count');
		$this->db->from('tongji');
		$this->db->group_by('referer');
		return $this->db->get()->result_array();
	}

	public function count_records()
	{
		$this->db->select('1');
		$this->db->from('tongji');
		return $this->db->get()->num_rows();
	}

	public function count_all()
	{
		return $this->db->select('1')->from('tongji')->get()->num_rows();
	}

}
