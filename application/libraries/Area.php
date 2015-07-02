<?php

class Area
{
	//CI实例
	public static $CI;
	
	public function __construct() {
		self::$CI = & get_instance();
		self::$CI->load->database();
		self::$CI->load->model(array('province_model', 'city_model', 'area_model'));
	}
	
	/**
	 *  获取省列表
	 */
	public static function get_provinces()
	{
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>self::$CI->province_model->get_all())));
	}
	
	/**
	 *  获取市列表
	 */
	public static function get_cities($province_id)
	{
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>self::$CI->city_model->get_where("provinceid=$province_id"))));
	}
	
	/**
	 *  获取区列表
	 *  
	 */
	public static function get_areas($city_id)
	{
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>self::$CI->area_model->get_where("cityid=$city_id"))));
	}
}
