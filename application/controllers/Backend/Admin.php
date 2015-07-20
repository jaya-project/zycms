<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {
	
	private $config_item;
	
	public function __construct() {
		
		parent::__construct();
		$this->config->load('backend_options', TRUE);
		$this->config_item = $this->config->item('backend_options');
		$this->load->library(array('session'));
		$this->load->model(array('right_model'));
		
		if (!$this->has_right()) {
			die('对不起,你没有该权限');
		}
		
	}
	
	public function logout()
	{
		$this->load->library('MyAuth');
		$this->myauth->logout();
		redirect('/login/index');
	}
	
	public function index() {
		
		$this->config->load('backend_options', TRUE);
		$config_item = $this->config->item('backend_options');
		
		$admin = $this->session->userdata('admin');
		
		$own_menus = $this->get_role_menu($admin['rid']);
		
		$own_menus = array_column($own_menus, 'name');
		
		// print_r($own_menus);
		
		$this->load->view('Backend/admin-index', array('menus'=>$config_item['backend']['menus'], 'own_menus'=>$own_menus));
	}
	
	public function welcome() 
	{
		$this->view('welcome-index');
	}
	
	public function channel_list()
	{
		$this->view('channel-index');
	}
	
	public function channel_add($id = '')
	{
		$data = array('channel_model_fields'=>$this->config_item['backend']['channel_model_fields'], 'channel_id'=>$id);
		$this->view('channel-add', $data);
	}
	
	public function channel_edit($id)
	{
		$this->channel_add($id);
	}
	
	public function column_list()
	{
		$this->view('column_index');
	}
	
	public function column_add()
	{
		$this->view('column_add');
	}
	
	public function document_list()
	{
		$this->view('document-index');
	}
	
	public function document_add()
	{
		$data = array('recommend_types'=>$this->config_item['backend']['recommend_types']);
		$this->view('document-add', $data);
	}
	
	public function ad_list()
	{
		$this->view('ad-index');
	}
	
	public function ad_add()
	{
		$this->view('ad-add');
	}
	
	public function ad_position()
	{
		$this->view('ad-position');
	}
	
	public function ad_position_add()
	{
		$this->view('ad-position-add');
	}
	
	public function piece_list()
	{
		$this->view('piece-list');
	}
	
	public function base_set()
	{
		$this->view('base-set');
	}
	
	public function water_image()
	{
		$this->view('water-image');
	}

	public function form_list()
	{
		$this->view('form-list');
	}
	
	public function database_backup()
	{
		$this->view('database-backup');
	}
	
	public function sitemap()
	{
		$this->view('sitemap');
	}
	
	public function qr_code()
	{
		$this->view('qr-code');
	}
	
	public function role_list()
	{
		$this->view('role-list');
	}
	
	public function right_list()
	{
		$this->view('right-list');
	}
	
	public function user_list()
	{
		$this->view('user-list');
	}
	
	public function flink()
	{
		$this->view('flink-list');
	}
	
	public function hot_search()
	{
		$this->view('hot-search');
	}
	
	public function nav_set()
	{
		$this->view('nav-list');
	}
	
	public function build_html()
	{
		$this->view('build-html');
	}
	
	public function form_management()
	{
		$this->view('form-management');
	}
	
	public function member_list()
	{
		$this->view('member-list');
	}
	
	public function order_list()
	{
		$this->view('order-list');
	}
	
	public function message_list()
	{
		$this->view('message-list');
	}
	
	public function auto_push()
	{
		$this->view('auto-push');
	}
	
	public function recycle_bin()
	{
		$this->view('recycle-bin');
	}
	
	
	private function get_role_menu($rid) 
	{
		if (!empty($rid)) {
			$this->db->select('r.name, r.resource');
			$this->db->from('role as ro');
			$this->db->join('relationship as re', 'ro.id=re.roleid', 'left');
			$this->db->join('right as r', 're.rid=r.id', 'left');
			$this->db->where("ro.id=$rid");
			return $this->db->get()->result_array();
		} else {
			return $this->right_model->get_all();
		}
		
	}
	
	private function has_right() 
	{
		$themes = $this->uri->segment(1);
		
		$admin = $this->session->userdata('admin');
		
		$own_resource = array_merge(explode(',', join(',', array_column($this->get_role_menu($admin['rid']), 'resource'))), array('admin@index', 'admin@welcome', 'admin@logout', 'admin@'));
		
		
		
		if (strtolower($themes) != 'backend' || strtolower($themes) != 'frontend') {
			$controller = $themes;
			$method = $this->uri->segment(2);
			
		} else {
			
			$controller = $this->uri->segment(1);
			$method = $this->uri->segment(2);
		}
		
		if (in_array($controller . '@' . $method, $own_resource)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}