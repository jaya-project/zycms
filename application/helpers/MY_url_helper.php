<?php 

/**
 *  创建静态路径
 */
function build_url($url) {
	$segments = explode('/', $url);
	empty($segments[0]) && array_shift($segments);
	return join('-', $segments) . '.html';
}