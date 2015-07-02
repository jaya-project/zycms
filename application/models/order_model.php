<?php
/**
 * @author church
 * @todo 订单表模型
 * 
 */
class order_model extends MY_Model
{
	protected $table_name = 'order';
	
	protected $primary_key = "order_number";
    
    public function __construct() {
        parent::__construct();
    }
    
	
	public function get_one($id, $field='all')
	{
		$fields = $field == 'all' ? '*' : $field;
		$this->db->select($fields);
		$this->db->from($this->table_name." as o");
		$this->db->join('order_product as op', 'o.order_number=op.order_number', 'left');
		$this->db->join('archives as a', 'a.id=op.product_id', 'left');
		$this->db->where("o.order_number=$id");
		return $this->db->get()->result_array();
	}
	
}
