<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  广告位控制器
 */
class Tools extends Admin_Controller {
	
	const BACK_DIRECTORY = './backup/';
	
	const QRCODE_DIRECTORY = './uploads/qrcode/';
	
	const IMPORTLENGTH = 30;
	
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
		
		$config['allowed_types'] = 'csv|xls|xlsx';
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
			if ($channel_info['table_name'] != $table_name) {
				@unlink($uploaded_file_full_path);
				die(json_encode(array('code'=>403, 'message'=>'错误的表名')));
			}
			
			//To read xls file
			$PHPReader = new PHPExcel_Reader_Excel2007();
			if (!$PHPReader->canRead($uploaded_file_full_path)) {
				$PHPReader = new PHPExcel_Reader_Excel5();
				if (!$PHPReader->canRead($uploaded_file_full_path)) {
					$this->code = self::FAILED;
					$this->message = '程序无法读取该excel文件';
					die;
				}
			}
			$PHPExcel = $PHPReader->load($uploaded_file_full_path);
			$sheetNames = $PHPExcel->getSheetNames();
			
			//count rows and cols, position to a specify sheet
			$name = $sheetNames[0];
			$currentSheet = $PHPExcel->getSheetByName($name);
			$allColumn = $currentSheet->getHighestColumn();
			$allRow = $currentSheet->getHighestRow();
			
			if ($allRow > self::IMPORTLENGTH) {
				$this->import_company_each_time($data['full_path'], 1, self::IMPORTLENGTH, $allRow, $allColumn, $table_name, $cid, $channel_info['table_struct']);
			} else {
				$this->import_company_each_time($data['full_path'], 1, self::IMPORTLENGTH, $allRow, $allColumn, $table_name, $cid, $channel_info['table_struct']);
			}			
			
			
			@unlink($uploaded_file_full_path);
			die(json_encode(array('code'=>200, 'message'=>'批量导入成功')));
		}	 
		else
		{
			die(json_encode(array('code'=>403, 'message'=>$this->upload->display_errors())));
		}
	}
	
	/**
	 *  分批次导入数据
	 */
	public function import_company_each_time($import_file='', $page=1, $length=50, $allRow=50, $allColumn='A', $table_name='', $cid=0, $table_struct='')
	{
		$data = $this->input->stream();
		if (!empty($data)) {
			$import_file 	= 	$data['import_file'];
			$page 			= 	$data['page'];
			$length 		= 	$data['length'];
			$allRow 		= 	$data['allRow'];
			$allColumn 		= 	$data['allColumn'];
			$table_name 	= 	$data['table_name'];
			$cid 			= 	$data['cid'];
			$table_struct 	= 	serialize($data['table_struct']);
		}
		
		$start = (($page - 1) * $length ) + 1;
		$end = $start + $length;
		$message = '';
		
		if ($allRow > $end || ($start < $allRow && $end > $allRow)) {
			
			//To read xls file
			$PHPReader = new PHPExcel_Reader_Excel2007();
			if (!$PHPReader->canRead($import_file)) {
				$PHPReader = new PHPExcel_Reader_Excel5();
				if (!$PHPReader->canRead($import_file)) {
					$this->code = self::FAILED;
					$this->message = '程序无法读取该excel文件';
					die;
				}
			}

			$PHPExcel = $PHPReader->load($import_file);
			$sheetNames = $PHPExcel->getSheetNames();
			
			//count rows and cols, position to a specify sheet
			$name = $sheetNames[0];
			$currentSheet = $PHPExcel->getSheetByName($name);
			
			//read content
			$table_struct = unserialize($table_struct);
			$keys = array_column($table_struct, 'fields');
			array_unshift($keys, 'id');
			$insert_data = array();
			
			for ($currentRow = $start; $currentRow <= $end; $currentRow++) {
				if ($currentRow == 1) {
					continue;
				}
				for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
					if ($currentColumn == 'H') {
						$val = $this->excel_time($currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue());
					} else {
						$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue();
					}
					
					//$objExcel[$name][$currentRow - 1][ord($currentColumn) - 65] = $val;
					$val = empty($val) ? '' : $val;
					$insert_data[$currentRow][] = $val;
				}
				
				$content = $insert_data[$currentRow];
				
				$main_table_data = array(
					'title' => $content[0],
					'create_time' => time(),
					'cid' => $cid,
					'author' => 'admin',
				);
				
				
				
				if ($this->db->insert('archives', $main_table_data)) {
					$id = $this->db->insert_id();
					array_shift($content);
					array_unshift($content, $id);
					$this->db->insert($table_name, array_combine($keys, $content));
				} else {
					$message .= "第 $page 批第 $currentRow 行失败";
				}
				
				
					
			}
			
			$code = 201;
			if ($page == 1) {
				$total = ceil($allRow / self::IMPORTLENGTH);
				$message .= "导入文件较大, 正在分批次导入 <br />";
				$message .= "共 $total 批 <br />";
			}
			$message .= "第 $page 批导入完成, 进行下一批导入 <br />";
			$page++;
			$data = array(
					'import_file' 	=> 	$import_file,
					'page' 			=>	$page,
					'length'		=>	self::IMPORTLENGTH,
					'allRow'		=>	$allRow,
					'allColumn'		=>	$allColumn,
					'table_name'	=> 	$table_name,
					'cid'			=>	$cid,
					'table_struct'	=>	$table_struct
				);
			
		} else {
			$code = 200;
			$message = '导入完成';
			$data = '';
		}
		
		die(json_encode(array('code'=>$code, 'message'=>$message, 'data'=>$data)));
	}
	
	private function excel_time($date, $time = false)
	{
		if (function_exists('GregorianToJD')){
			if (is_numeric( $date )) {
			$jd = GregorianToJD( 1, 1, 1970 );
			$gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );
			$date = explode( '/', $gregorian );
			$date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )
			."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )
			."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )
			. ($time ? " 00:00:00" : '');
			return $date_str;
			}
		} else{
			$date=$date>25568?$date+1:25569;
			/*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
			$ofs=(70 * 365 + 17+2) * 86400;
			$date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : '');
		}
		return $date;
	}
	
}