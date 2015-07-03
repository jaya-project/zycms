<?php 


/**
 *  创建静态路径
 */
function build_url($param, $cid, $type=2) 
{
	$CI = & get_instance();
	$CI->load->model(array('rule_model'));
	$rule = $CI->rule_model->get_where("cid=$cid AND type=$type");
	
	$rule = array_shift($rule);
	
	if ($type == 2) {
		return '/'.str_replace('page', $param, $rule['destination_rule']);
	} else if ($type == 3) {
		return '/'.str_replace('aid', $param, $rule['destination_rule']);
	} else if ($type == 1) {
		return $rule['destination_rule'];
	}
}