<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

//在调用ajax操作后自动输出
$hook['post_controller'] = array(
                                'class'		=> 'Auto_push',
                                'function'	=> 'push',
                                'filename'	=> 'AutoPush.php',
                                'filepath'	=> 'hooks/postController',
                                );
						
$hook['app_post_controller'] = array(
                                'class'		=> 'Auto_p',
                                'function'	=> 'push',
                                'filename'	=> 'AutoP.php',
                                'filepath'	=> 'hooks/postController',
                                );