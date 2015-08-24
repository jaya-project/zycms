<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  广告位控制器
 */
class Tools extends Admin_Controller {
	
	const BACK_DIRECTORY = './backup/';
	
	const QRCODE_DIRECTORY = './uploads/qrcode/';
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(array('session', 'MyAuth'));
		$this->load->model(array('column_model', 'channel_model', 'archives_model'));
		$this->load->helper(array('array', 'url', 'file'));
		
	}
	
	public function get_all_tables()
	{
		$tables = $this->db->list_tables();
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$tables)));
	}
	
	
	public function backup_database()
	{
		$this->load->dbutil();
		
		$prefs = array(
                'format'      => 'zip',             // gzip, zip, txt
                'filename'    => 'zycms.sql',    // 文件名 - 如果选择了ZIP压缩,此项就是必需的
                'add_drop'    => TRUE,              // 是否要在备份文件中添加 DROP TABLE 语句
                'add_insert'  => TRUE,              // 是否要在备份文件中添加 INSERT 语句
              );

		$backup = $this->dbutil->backup($prefs); 

		$backup_file_path = self::BACK_DIRECTORY.'zycms'.time().'.zip';
		
		write_file($backup_file_path, $backup); 
		
		if (file_exists($backup_file_path)) {
			die(json_encode(array('code'=>200, 'message'=>'备份成功')));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'备份失败')));
		}
		
	}
	
	public function delete_backup_file()
	{
		$backup_directory = './backup/';
		
		$data = $this->input->stream();
		
		if (isset($data['filename'])) {
			@unlink(self::BACK_DIRECTORY . $data['filename']);
		} else {
			die(jsone_encode(array('code'=>403, 'message'=>'不存在的备份文件')));
		}
		
		die(json_encode(array('code'=>200, 'message'=>'删除成功')));
	}
	
	public function restore_backup_file()
	{
		$data = $this->input->stream();
		
		if (isset($data['filename']) && !empty($data['filename'])) {
			$back_file_path = './backup/'.$data['filename'];
			
			if (file_exists($back_file_path)) {
				
				$archive = new PclZip($back_file_path);
				
				$row = $archive->extract(PCLZIP_OPT_PATH, "./backup/zycms");
				
				
				$row = array_shift($row);
				
				$extract_file_path = './'.$row['filename'];
				
				if (($sql_content = file_get_contents($filename = $extract_file_path)) !== false){
					
					$sql = explode("\n\n", $sql_content);
					
					foreach ($sql as $key => $s) {
						if(trim($s)){
							$result = $this->db->query($s);
						}
					}
					unlink($extract_file_path);
					
					rmdir('./backup/zycms');
					
					die(json_encode(array('code'=>200, 'message'=>'还原成功')));
				} else {
					unlink($extract_file_path);
					rmdir('./backup/zycms');
					die(json_encode(array('code'=>403, 'message'=>'还原失败')));
				}
			}
		}
		
		
		
	}
	
	public function get_backup_file()
	{
		
		$files = array();
		
		if ($handle = opendir(self::BACK_DIRECTORY)) {
			while (FALSE !== ($file = readdir($handle))) {
				
				if ($file != '.' && $file != '..') {
					$files[] = array(
									'filename' => $file,
									'create_time' => date('Y-m-d H:i:s', substr($file, 5, 10))
								);
				}
			}
			
			closedir($handle);
		}
		
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$files)));
	}
	
	
	public function build_sitemap()
	{
		$data = $this->input->stream();
		
		$links = $this->get_links($data['domain']);
		
		
		$this->load->library('Sitemap');
		
		
		$this->sitemap->setPath('./');
		
		$this->sitemap->setFilename('sitemap');
		
		foreach ($links as $key=>$value) {
			$this->sitemap->addItem($value, '1.0', 'daily', 'Today');
		}
		
		
		$this->sitemap->createSitemapIndex($data['domain'].'/sitemap/', 'Today');
		
		if (file_exists('./sitemap.xml')) {
			die(json_encode(array('code'=>200, 'message'=>'生成成功')));
		} else {
			die(json_encode(array('code'=>403, 'message'=>'生成失败')));
		}
	}
	
	public function get_links($url)
	{
		$content = file_get_contents($url);
		preg_match_all('/<a\s*href=[\'|"]?(https?:\/\/[^\'|^"]*?)[\'|"]?\s*>/i', $content, $matches);
		
		return $matches[1];
	}
	
	public function build_qr_code()
	{
		$data = $this->input->stream();
		
		$this->load->library('Ciqrcode');
		
		if (isset($data['text'])) {
			$params['data'] = $data['text'];
			$params['level'] = 'H';
			$params['size'] = 10;
			
			$filename = time().base64_encode($data['text']);
			
			$params['savename'] = './uploads/qrcode/'.$filename.'.png';
			
			$this->ciqrcode->generate($params);
			
			die(json_encode(array('code'=>200, 'message'=>'生成成功', 'data'=>'/uploads/qrcode/'.$filename.'.png')));
			
		} else {
			die(json_encode(array('code'=>403, 'message'=>'没有填写内容')));
		}
		
	}
	
	public function get_qrcode_file()
	{
		
		$files = array();
		
		if ($handle = opendir(self::QRCODE_DIRECTORY)) {
			while (FALSE !== ($file = readdir($handle))) {
				
				if ($file != '.' && $file != '..') {
					$files[] = array(
									'filename' => $file,
									'create_time' => date('Y-m-d H:i:s', substr($file, 0, 10)),
									'text' => base64_decode(substr($file, 10, strrpos($file, '.') - 10))
								);
				}
			}
			
			closedir($handle);
		}
		
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$files)));
	}
	
	public function delete_qrcode_file()
	{
		
		$data = $this->input->stream();
		
		if (isset($data['filename'])) {
			@unlink(self::QRCODE_DIRECTORY . $data['filename']);
		} else {
			die(jsone_encode(array('code'=>403, 'message'=>'不存在的二维码文件')));
		}
		
		die(json_encode(array('code'=>200, 'message'=>'删除成功')));
	}
	
	public function auto_push()
	{
		$data = $this->input->stream();
		
		$urls = explode("\n", $data['links']);
		
		$this->config->load('system', True);
		
		$temp = $this->config->item('system');
		
		$domain = $_SERVER['HTTP_HOST'];
		// $domain = 'www.dgchengfu.com';
		
		$api = 'http://data.zz.baidu.com/urls?site='.$domain.'&token='.$temp['system_set']['token'];
		
		$ch = curl_init();
		
		$options =  array(
			CURLOPT_URL => $api,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => implode("\n", $urls),
			CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		
		curl_setopt_array($ch, $options);
		
		$result = json_decode(curl_exec($ch), true);
		
		if (isset($result['error'])) {
			die(json_encode(array('code'=>403, 'message'=>$result['message'])));
		} else {
			die(json_encode(array('code'=>200, 'message'=>'推送成功', 'data'=>$result)));
		}
	}
	
	public function bat_export()
	{
		if (!is_dir('./uploads/files/')) {
			@mkdir('./uploads/files/', 777, true);
		}
		
		$config['upload_path'] = './uploads/files/';
		
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '10240';
		
		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload('file'))
		{
			//获取上传后的文件信息
			$data = $this->upload->data();
			list($table_name, $cid) = explode('@', $data['raw_name']); 		//文件名作为表名称和栏目ID
			$uploaded_file_full_path = $data['full_path'];		//上传后的文件绝对路径
			
			//栏目名称是否存在
			if (!($column_info = $this->column_model->get_one($cid))) {
				@unlink($uploaded_file_full_path);
				die(json_encode(array('code'=>403, 'message'=>'不存在的栏目,请检查文件名')));
			}
			
			//检查表名称是否被修改
			$channel_info = $this->channel_model->get_one($column_info['channel_id']);
			// $table_struct = unserialize($channel_info['table_struct']);
			// $fields = array('id') + array_column($table_struct, 'fields');
			if ($channel_info['table_name'] != $table_name) {
				@unlink($uploaded_file_full_path);
				die(json_encode(array('code'=>403, 'message'=>'错误的表名')));
			}
			
			//若存在,开始导入
			$table_name = $this->db->dbprefix($table_name);
			$handle = @fopen($uploaded_file_full_path, 'r');
			if ($handle) {
				$i = 0;
				while (($buffer = fgetcsv($handle)) !== false) {
					//不是第一行才导入
					if ($i++ != 0) {
						if (is_array($buffer) && sizeof($buffer) > 0) {
							//插入到主表
							$title = array_shift($buffer);
							$this->archives_model->insert(array('title'=>$title, 'cid'=>$cid, 'create_time'=>time(), 'author'=>'admin', 'source'=>'原创'));
							$id = $this->archives_model->get_insert_id();
							//插入到副表
							$sub_table_values = array('id'=>$id) + $buffer;
							array_walk($sub_table_values, function(&$item) {
								$item = '\'' . trim(iconv('GBK', 'UTF-8//IGNORE', $item)) . '\'';
							});
							$sub_table_values = join(',', $sub_table_values);
							$sql = "INSERT INTO $table_name VALUES($sub_table_values)";
							$this->db->query($sql);
						}
					}
				}
				
				fclose($handle);
			} else {
				@unlink($uploaded_file_full_path);
				die(json_encode(array('code'=>403, 'message'=>'系统暂时无法打开上传文件,请稍后再试')));
			}
			
			
			@unlink($uploaded_file_full_path);
			die(json_encode(array('code'=>200, 'message'=>'批量导入成功')));
		}	 
		else
		{
			die(json_encode(array('code'=>403, 'message'=>$this->upload->display_errors())));
		}
	}
	
}