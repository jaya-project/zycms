<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  内容模型控制器
 */
class Ueditor extends Admin_Controller {
	
	private $action;
	
	public function __construct() {
		parent::__construct();
		
		$this->action = $this->input->get('action');
		
		$this->load->helper(['ueditor']);
	}

	public function upload() 
	{
		
		$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(realpath("./data/config.json"))), true);
		
		switch ($this->action) {
			case 'config':
				$result =  json_encode($CONFIG);
				break;

			/* 上传图片 */
			case 'uploadimage':
			/* 上传涂鸦 */
			case 'uploadscrawl':
			/* 上传视频 */
			case 'uploadvideo':
			/* 上传文件 */
			case 'uploadfile':
				$result = action_upload($CONFIG);
				break;

			/* 列出图片 */
			case 'listimage':
				$result = action_list($CONFIG);
				break;
			/* 列出文件 */
			case 'listfile':
				$result = action_list($CONFIG);
				break;

			/* 抓取远程文件 */
			case 'catchimage':
				$result = action_crawler($CONFIG);
				break;

			default:
				$result = json_encode(array(
					'state'=> '请求地址出错'
				));
				break;
		}

		/* 输出结果 */
		if (isset($_GET["callback"])) {
			if (preg_match("/^[\w_]+$/", $this->input->get("callback"))) {
				echo htmlspecialchars($this->input->get("callback")) . '(' . $result . ')';
			} else {
				echo json_encode(array(
					'state'=> 'callback参数不合法'
				));
			}
		} else {
			echo $result;
		}
	}
	
	
}