<?php
/**
 * @author church
 * @todo 内容模型表模型
 * 
 */
class Channel_model extends MY_Model
{
	protected $primary_key = 'channel_id';
	
	protected $table_name = 'channel';
    
    public function __construct() {
        parent::__construct();
    }
    

	
}
