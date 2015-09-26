<?php

$config['backend'] = array(
					'channel_model_fields' => array(
												'text' => '普通文本类型',
												'textarea' => '文本域类型',
												'checkbox' => '复选类型',
												'radio' => '单选类型',
												'select' => '下拉类型',
												'image' => '单图类型',
												'multiple_image' => '多图类型',
												'file' => '单文件类型',
												'htmltext' => '富文本类型'
											),
					
					'form_fields' => array(
										'text' => '普通文本类型',
										'textarea' => '文本域类型',
										'checkbox' => '复选类型',
										'radio' => '单选类型',
										'select' => '下拉类型',
										'image' => '单图类型',
										'htmltext' => '富文本类型'
									),
											
					'recommend_types' => array(
												'c' => '推荐',
												'h' => '热门',
												'n' => '最新'
											),
					'menus' => array(
									array(
										'title' => '模型管理',
										'sub_menu' => array(
															'/admin/channel_list' => '内容模型管理',
															'/admin/channel_add'  => '内容模型添加'
														),
									),
									array(
										'title' => '栏目管理',
										'sub_menu' => array(
															'/admin/column_list' => '栏目列表',
															'/admin/column_add'  => '栏目添加'
														),
									),
									array(
										'title' => '文档管理',
										'sub_menu' => array(
															'/admin/document_list' => '文档列表',
															'/admin/document_add'  => '文档添加'
														),
									),
									array(
										'title' => '回收站',
										'sub_menu' => array(
															'/admin/recycle_bin' => '回收站',
														),
									),
									array(
										'title' => '广告管理',
										'sub_menu' => array(
															'/admin/ad_position' => '广告位管理',
															'/admin/ad_list'  => '广告管理'
														),
									),
									array(
										'title' => '内容碎片管理',
										'sub_menu' => array(
															'/admin/piece_list' => '内容碎片管理',
														),
									),
									array(
										'title' => '自定义表单',
										'sub_menu' => array(
															'/admin/form_list' => '表单管理',
															'/admin/form_management' => '表单内容管理',
														),
									),
									array(
										'title' => '用户管理',
										'sub_menu' => array(
															'/admin/right_list' => '权限管理',
															'/admin/role_list' => '角色管理',
															'/admin/user_list' => '用户管理',
														),
									),
									
									array(
										'title' => '系统设置管理',
										'sub_menu' => array(
															'/admin/base_set' => '基本设置',
															'/admin/nav_set' => '导航设置',
															'/admin/water_image' => '水印设置',
														),
									),
									array(
										'title' => '友情链接',
										'sub_menu' => array(
															'/admin/flink' => '友情链接管理',
														),
									),
									array(
										'title' => '关键词管理',
										'sub_menu' => array(
															'/admin/hot_search' => '热门搜索关键词',
															'/admin/keywords' => '文章关键词管理',
														),
									),
									
									array(
										'title' => '工具',
										'sub_menu' => array(
															'/admin/database_backup' => '数据库备份',
															'/admin/sitemap' => '网站地图生成',
															'/admin/qr_code' => '二维码生成器',
															'/admin/auto_push' => '百度主动推送',
															'/admin/bat_export' => '文章批量导入',
															'/admin/black_list' => '黑名单设置',
                                                            '/admin/opera_log' => '操作日志'
														),
									),
									
									array(
										'title' => '生成静态',
										'sub_menu' => array(
															'/admin/build_html' => '生成静态'
														),
									),

                                    array(
                                        'title' => '通用模板管理',
                                        'sub_menu' => array(
                                                            '/admin/templates' => '模板管理'
                                                        ),
                                    ),
									
									/*
									array(
										'title' => '会员管理',
										'sub_menu' => array(
															'/admin/member_list' => '会员列表',
															'/admin/order_list'  => '订单列表',
															'/admin/message_list' => '消息列表'
														),
									),
									*/
								),
					);
