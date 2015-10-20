<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  公共动作控制器
 */
class Common extends Admin_Controller {
	
	
	public function __construct() {
		parent::__construct();
		
		$this->load->library('image_lib');
		
	}

	/**
	 *  上传图片
	 */
	public function upload_image() 
	{
		if (!is_dir('./uploads/'.date('Y').'/'.date('m').'/'.date('d').'/')) {
			@mkdir('./uploads/'.date('Y').'/'.date('m').'/'.date('d').'/', 0777, true);
		}
		
		$config['upload_path'] = './uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
		
		$config['allowed_types'] = 'gif|jpg|png|rar';
		$config['max_size'] = '1024';
		$config['encrypt_name'] = true;
		$config['file_name'] = date('Y').'_'.date('m').'_'.date('d').'_'.time();
		
		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload('file'))
		{
			$data = $this->upload->data();
			
			if (in_array($data['file_ext'], array('.jpg', '.gif', '.png'))) {
				$this->add_water_mark($data['full_path']);
			}
			
			die(json_encode(array('code'=>200, 'data'=>array_merge($data, array('relative_path'=>ltrim($config['upload_path'], '.'))), 'message'=>'上传成功')));
		}	 
		else
		{
			die(json_encode(array('code'=>403, 'message'=>$this->upload->display_errors())));
		}

	}
	
	
	
	public function add_water_mark($image_path)
	{
		$TEXT = '0';
		$IMAGE = '1';
		
		$config = array();
		$water_mark_config = $this->get_water_mark_config();
		
		$config['source_image'] = $image_path;
		$position = explode('_', $water_mark_config['position']);
		$config['wm_vrt_alignment'] = $position[0];
		$config['wm_hor_alignment'] = $position[1];
		
		if ($water_mark_config['is_open']) {
			if ($water_mark_config['type'] == $TEXT) {
				$config['wm_text'] = $water_mark_config['text'];
				$config['wm_type'] = 'text';
				$config['wm_font_path'] = './assets/static/ggbi.ttf';
				$config['wm_font_size'] = $water_mark_config['font_size'];
				$color = substr($water_mark_config['color'], 1);
				$config['wm_font_color'] = $color;

			} else {
				$config['wm_type'] = 'overlay';
				$config['wm_overlay_path'] = '.' . $water_mark_config['thumb'];
				$config['wm_opacity'] = $water_mark_config['opacity'];
				
			}
			
			$this->image_lib->initialize($config); 
			
			$this->image_lib->watermark();
			
		}
	}
	
	/**
	 *  上传图片
	 */
	public function upload_ico() 
	{
		$config['upload_path'] = './';
		
		$config['allowed_types'] = '*';
		$config['max_size'] = '1024';
		$config['overwrite'] = true;
		$config['file_name'] = 'favicon.ico';
		
		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload('file'))
		{
			$data = $this->upload->data();
			
			die(json_encode(array('code'=>200, 'data'=>array_merge($data, array('relative_path'=>ltrim($config['upload_path'], '.'))), 'message'=>'上传成功')));
		}	 
		else
		{
			die(json_encode(array('code'=>403, 'message'=>$this->upload->display_errors())));
		}

	}
	
	private function get_water_mark_config() 
	{
		$this->config->load('water_mark', True);
		$temp = $this->config->item('water_mark');
		return $temp['water_mark'];
		
	}
	
}
