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

	/**
   	 * 添加一个用户,返回新增id(注册时使用)
   	 *
   	 * @param int $username 用户名
   	 *
   	 * @param int $userpass   用户密码
   	 */
	public function add($username, $userpass, $mobile)
	{

	 	$this->insert(array(
			'username' => $username,
			'password' => $userpass,
			'mobile' => $mobile
		), $this->table_name);
        return   $this->db->insert_id();

	}

 	/**
   	 * 查询用户和密码是否已存在,返回执行到列数(注册时使用)
   	 *
   	 * @param int $username 用户名
   	 *
   	 * @param int $userpass   用户密码
   	 */
	public function select($username, $userpass)
	{
		return $this->db->select('id, username')->from($this->table_name)->where(array(
					'username' => $username,
					'password' => $userpass
				))->get()->row_array();

	}

	/**
   	 * 根据session id查询用户信息
   	 *
   	 */
	public function userInfo()
	{
		return $this->db->select('*')->from($this->table_name)->where(array(
					'id' => $this->user['id']
				))->get()->row_array();

	}

	/**
   	 * 根据session id 更新用户信息
   	 *
   	 */
	public function updata($data)
	{
		return $this->db->update($this->table_name, $data ,array('id' => $this->user['id']));

	}


}
