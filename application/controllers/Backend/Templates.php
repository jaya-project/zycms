<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 通用模板控制器 
 */
class Templates extends Admin_Controller {
	
	const TEMPLATE_DIRECTORY = './application/views/Frontend/includes/';
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(array('session', 'MyAuth'));
		$this->load->helper(array('array', 'url', 'file'));
		
	}
	
	
	public function delete_templates()
	{
		$data = $this->input->stream();
		
		if (isset($data['filename'])) {
			@unlink(self::TEMPLATE_DIRECTORY. $data['filename']);
		} else {
			die(jsone_encode(array('code'=>403, 'message'=>'不存在的备份文件')));
		}
		
		die(json_encode(array('code'=>200, 'message'=>'删除成功')));
	}

    public function get_template_content()
    {
        $data = $this->input->stream();

        die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>file_get_contents(self::TEMPLATE_DIRECTORY . $data['filename']))));
    }
	
    public function save_template()
    {
        $data = $this->input->stream();
        @copy(self::TEMPLATE_DIRECTORY . $data['filename'], self::TEMPLATE_DIRECTORY . $data['filename'].'.bak');
        file_put_contents(self::TEMPLATE_DIRECTORY . $data['filename'], $data['content']);
        die(json_encode(array('code'=>200, 'message'=>'更新成功')));
    }
					
	
	public function get_templates()
	{
		
		$files = array();
		
		if ($handle = opendir(self::TEMPLATE_DIRECTORY)) {
			while (FALSE !== ($file = readdir($handle))) {
				
				if ($file != '.' && $file != '..' && !preg_match('/\.bak$/', $file)) {
                    $content = file_get_contents(self::TEMPLATE_DIRECTORY . '/'. $file);
                    preg_match('/<!--(.*?)-->/', $content, $matches);
                    $desc = isset($matches[1]) ? $matches[1] : '暂无描述';
					$files[] = array(
                                    'desc' => $desc,
									'path' => $file,
								);
				}
			}
			
			closedir($handle);
		}
		
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$files)));
	}
	
	
	
}
