<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thumbnail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function build($path = '', $width = 100, $height = 100)
	{
		if (strpos($path, '@_@') !== false) {
			
			$path = str_replace('@_@', '/', $path);
			$dir = './thumbs' . substr($path, 0, strrpos($path, '/') + 1);
			$file = substr($path, strrpos($path, '/') + 1);
			$extend = substr($file, strrpos($file, '.') + 1);

			if (!file_exists($dir) || !is_dir($dir)) {
				mkdir($dir, 0777, true);
			}
			
			$save_file_path = $dir . '/' . $width . '_' . $height . '_' . $file;
			
			if (file_exists($save_file_path)) {
				switch($extend) {
					case 'jpg':
					case 'jpeg':
					default:
						$content_type = 'image/jpg';
						break;
					case 'png':
						$content_type = 'image/png';
						break;
					case 'gif':
						$content_type = 'image/gif';
						break;
				}
				header('Content-type: ' . $content_type);
				echo file_get_contents($save_file_path);
			} else {
				$thumb = new PHPThumb\GD('.' . $path);
				$thumb->resize($width, $height);
				$thumb->save($save_file_path);
				$thumb->show();
			}
			
		
		} else {
			return '';
		}
	}
}
