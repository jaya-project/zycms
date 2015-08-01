<?php 


/**
 *  创建静态路径
 */
function build_url($param, $cid, $type=2) 
{
	$CI = & get_instance();
	$config = & get_config();
	$CI->load->model(array('rule_model'));
	$rule = $CI->rule_model->get_where("cid=$cid AND type=$type");
	
	
	$rule = array_shift($rule);
	
	if (ENVIRONMENT == 'production' || ENVIRONMENT == 'testing') {
		if ($type == 2) {
			return '/'.str_replace('page', $param, $rule['destination_rule']);
		} else if ($type == 3) {
			return '/'.str_replace('aid', $param, $rule['destination_rule']);
		} else if ($type == 1) {
			return '/'.$rule['destination_rule'];
		}
	} else {
		
		$base_url = _slash_item('base_url', $config);
		
		if ($type == 2) {
			
			$uri = str_replace('page', $param, $rule['source_rule']);
		} else if ($type == 3) {
			$uri = str_replace('aid', $param, $rule['source_rule']);
		} else if ($type == 1) {
			$uri = $rule['source_rule'];
		}
		
		$suffix = isset($config['url_suffix']) ? $config['url_suffix'] : '';

		if ($suffix !== '')
		{
			if (($offset = strpos($uri, '?')) !== FALSE)
			{
				$uri = substr($uri, 0, $offset).$suffix.substr($uri, $offset);
			}
			else
			{
				$uri .= $suffix;
			}
		}
		
		return $base_url._slash_item('index_page', $config).$uri;
	}
	
}

function _slash_item($item, $config) {
	
	if ( ! isset($config[$item]))
	{
		return NULL;
	}
	elseif (trim($config[$item]) === '')
	{
		return '';
	}

	return rtrim($config[$item], '/').'/';
}
