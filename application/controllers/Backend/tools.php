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
	
	
}