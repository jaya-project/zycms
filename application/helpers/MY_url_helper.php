<?php


/**
 *  创建静态路径
 */
function build_url($param, $cid, $type=2)
{
	$CI = & get_instance();
	$config = & get_config();
	$CI->load->model(array('rule_model', 'archives_model'));
	$CI->load->library(array( 'Pinyin'));
	$rule = $CI->rule_model->get_where("cid=$cid AND type=$type");


	$rule = array_shift($rule);

	if (ZYCMSHTML == 'open') {
		if ($type == 2) {
			if(1 != $param){
				return '/'.str_replace('page', $param, $rule['destination_rule']);
			} else {
				return shortcut_url('/'.str_replace('page', $param, $rule['destination_rule']));  //第二页不进行截取
			}
		} else if ($type == 3) {

			$article = $CI->archives_model->get_one($param, 'title');
			$pinyin = $CI->pinyin;
		 	$title = $pinyin::getPinyin(substr($article['title'],0,20)).$param;
			return '/'.str_replace('aid', $title, $rule['destination_rule']);
			// return '/'.str_replace('aid', $param, $rule['destination_rule']);
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


function shortcut_url($url) {	return substr($url, 0, strrpos($url, '/')+1);}