<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model(array('channel_model', 'column_model'));
		$this->load->library(array('phpexcel', 'mycategory'));
	}
	
	public function download_attendance() {
		
		//数据获取
		$data = func_get_args();
		$query = array();
		foreach($data as $value) {
			$temp_arr = explode('-', $value);
			$query[$temp_arr[0]] = $temp_arr[1];
		}
		
		//筛选条件
		$where = '';
		
		if(isset($query['department_id']) && !empty($query['department_id'])) {
			
			$arr_category = $this->mycategory->set_model('department_model')->get_sub_category($query['department_id']);
			$str_dpid = implode(',', $arr_category);
			
			$where .= " e.dpid in ($str_dpid) AND";
			
		}
		
		if(isset($query['employeeId']) && !empty($query['employeeId'])) {
			$where .= " e.id = $query[employeeId] AND";
		}
		
		if(isset($query['startDate']) && !empty($query['startDate'])) {
			$where .= " a.time >= '$query[startDate]' AND";
		}
		
		if(isset($query['endDate']) && !empty($query['endDate'])) {
			$where .= " a.time <= '$query[endDate]' AND";
		}
		
		
		$where = rtrim($where, ' AND');
		
		
		$data = $this->attendance_model->get_employee_attendance(0, 1000, $where);
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("church")
							 ->setLastModifiedBy("church")
							 ->setTitle("鹤山市政府员工签到明细")
							 ->setSubject("鹤山市政府员工签到明细")
							 ->setDescription("这是鹤山市政府员工签到明细表")
							 ->setKeywords("员工 签到 明细")
							 ->setCategory("签到表");
			
		// Add some data
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '姓名')
					->setCellValue('B1', '部门')
					->setCellValue('C1', '手机号码')
					->setCellValue('D1', '签到内容')
					->setCellValue('E1', '签到地址')
					->setCellValue('F1', '更新时间');
					
		
		$row = current($data);
		$i = 1;
		do {
			if(!empty($row)) {
				$i++;
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("A$i", $row['true_name'])
						->setCellValue("B$i", $row['department_name'])
						->setCellValue("C$i", $row['mobile'])
						->setCellValue("D$i", $row['content'])
						->setCellValue("E$i", $row['addr'])
						->setCellValue("F$i", $row['time']);
			}
		} while($row = next($data));

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('员工签到明细');
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="鹤山市政府员工签到明细.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
		
	}
	
	public function columnTemplate($cid)
	{
		$objPHPExcel = new PHPExcel();
		
		//获取表结构数据
		$this->db->select('ch.table_struct, ch.table_name');
		$this->db->from('column as c');
		$this->db->join('channel as ch', 'ch.channel_id=c.channel_id', 'left');
		$this->db->where("c.id=$cid");
		$row = $this->db->get()->row_array();
		$table_struct_arr = unserialize($row['table_struct']);
		array_unshift($table_struct_arr, array('label_fields'=>'标题'));
		
		$objPHPExcel->getProperties()->setCreator("church")
									 ->setLastModifiedBy("church")
									 ->setTitle('模板')
									 ->setSubject('模板')
									 ->setDescription('模板')
									 ->setKeywords('模板');
		
		$sheetObject = $objPHPExcel->setActiveSheetIndex(0);
		
		//组装数据
		
		$columnChar = ord('A');
		foreach ($table_struct_arr as $value) {
			$sheetObject->setCellValue(chr($columnChar) . 1, $value['label_fields']);
			$columnChar++;
		}
		
        // Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$row['table_name']. '@' . $cid .'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
		
	}
	
	
}