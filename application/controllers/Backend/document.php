<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  内容模型控制器
 */
class Document extends Admin_Controller {
	
	const PAGE_LENGTH = 15;
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('column_model', 'channel_model', 'archives_model'));
		$this->load->helper(array('array', 'url'));
		$this->load->library(array('MyCategory'));
		
	}
	
	/**
	 *  根据条件筛选文章
	 */
	public function get_article() 
	{
		$data = $this->input->stream();
		
		$page = isset($data['page']) ? $data['page'] : 1;
		$start = ($page - 1) * self::PAGE_LENGTH;
		
		$condition = '';
		
		if (isset($data['cid']) && !empty($data['cid'])) {
			
			$arr_columns = $this->mycategory->set_model('column_model')->get_sub_category($data['cid']);
			$str_cid = implode(',', $arr_columns);
			
			
			$condition = " a.cid in ($str_cid) OR FIND_IN_SET('{$data['cid']}', a.sub_column)";
		}
		
		if (isset($data['keyword'])) {
			$condition = " a.title like '%$data[keyword]%'";
		}
		
		$data = $this->archives_model->get_all_after_search($condition, $start, self::PAGE_LENGTH);
		$count = ceil($this->archives_model->count_all($condition, $start, self::PAGE_LENGTH) / self::PAGE_LENGTH);
		
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = array(
									'data' 			=>	$data,
									'total_pages' 	=>	$count,
									'current_page' 	=>	$page,
								);
		
		
		die(json_encode($response_data));
	}
	
	public function bat_delete()
	{
		$data = $this->input->stream();
		
		foreach ($data['ids'] as $key=>$value) {
			$table_name = $this->get_additional_table($value);
			$this->archives_model->delete($value);
			$this->db->where("id=$value")->delete($table_name);
		}
		
		die(json_encode(array('code' => 200, 'message' => '批量删除成功')));
	}
	
	public function save() 
	{
		$data = $this->input->stream();
		
		$is_edit = False;
		if (isset($data['id'])) {
			$is_edit = True;
		}
		
		
		$err_msg = '';
		if (!isset($data['title']) || empty($data['title'])) {
			$err_msg .= '标题不能为空 <br />';
		}
		
		if (!isset($data['cid']) || empty($data['cid'])) {
			$err_msg .= '请选择栏目<br />';
		}
		
		if (!empty($err_msg)) {
			$response_data['code'] = 403;
			$response_data['message'] = $err_msg;
			die(json_encode($response_data));
		}
		
		
		$archives_data_struct = array(
									'title' 			=> 	$data['title'],
									'sub_title' 		=> 	isset($data['sub_title']) ? $data['sub_title'] : '',
									'tag' 				=> 	isset($data['tag']) ? $data['tag'] : '',
									'thumb' 			=> 	isset($data['thumb']) ? $data['thumb'] : '',
									'seo_title' 		=> 	isset($data['seo_title']) ? $data['seo_title'] : '',
									'seo_keywords'		=> 	isset($data['seo_keywords']) ? $data['seo_keywords'] : '',
									'seo_description'	=> 	isset($data['seo_description']) ? $data['seo_description'] : '',
									'create_time'		=> 	isset($data['create_time']) ?  strtotime($data['create_time']) : time(),
									'author'			=> 	isset($data['author']) ? $data['author'] : '',
									'source'			=>	isset($data['source']) ? $data['source'] : '',
									'sort'				=>	$data['sort'],
									'click_count'		=> 	0,
									'recommend_type'	=>	(isset($data['recommend_type']) && !empty($data['recommend_type'])) ? join(',', $data['recommend_type']) : '',
									'cid'				=>	$data['cid'],
									'sub_column' 		=>	join(',', $data['sub_column'])
									
								);
		
		$sub_archives_data_struct = array_diff_key($data, $archives_data_struct);
		
		foreach ($sub_archives_data_struct as $key=>$value) {
			if (is_array($value)) {
				$sub_archives_data_struct[$key] = join(',', $value);
			}
		}
			
		if ($row = $this->column_model->get_one($data['cid'])) {
			
			$row = $this->channel_model->get_one($row['channel_id']);
			
			$table_name = $row['table_name'];
			
			if ($is_edit) {
				$this->edit($archives_data_struct, $sub_archives_data_struct, $table_name, $data['id']);
			} else {
				$this->add($archives_data_struct, $sub_archives_data_struct, $table_name);
			}
			
			
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的栏目';
			
		}
		
		die(json_encode($response_data));
	}
	
	/**
	 *  编辑动作
	 */
	private function edit($archives_data_struct, $sub_archives_data_struct, $table_name, $id) 
	{
		if ($this->archives_model->update($id, $archives_data_struct) && 
			$this->db->where("id=$id")->update($table_name, $sub_archives_data_struct)) {
			
			$response_data['code'] = 200;
			$response_data['message'] = '更新成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '更新失败';
		}
		die(json_encode($response_data));
	}
	
	/**
	 *  添加动作
	 */
	private function add($archives_data_struct, $sub_archives_data_struct, $table_name) 
	{
		
		if ($this->archives_model->insert($archives_data_struct)) {
			$id = $this->archives_model->get_insert_id();
			
			if ($this->db->insert($table_name, array_merge($sub_archives_data_struct, array('id'=>$id)))) {
				$response_data['code'] = 200;
				$response_data['message'] = '添加成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = "插入 $table_name 表时失败";
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '插入archives表时失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function document_delete() 
	{
		$data = $this->input->stream();
		
		$response_data = array();
		if (!isset($data['id'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '非法的ID';
		}
		
		$sub_archives_table = $this->get_additional_table($data['id']);
		
		if ($this->archives_model->delete($data['id']) && $this->db->where("id=$data[id]")->delete($sub_archives_table)) {
			$response_data['code'] = 200;
			$response_data['message'] = '删除成功';
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '删除失败';
		}
		
		die(json_encode($response_data));
	}
	
	public function get_specify_article()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (!isset($data['id'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '不正确的ID';
			die(json_encode($response_data));
		}
		
		if (($additional = $this->get_additional_table_content($data['id'])) && ($main = $this->archives_model->get_one($data['id']))) {
			if (!empty($main['recommend_type'])) {
				$main['recommend_type'] = explode(',', $main['recommend_type']);
				$main['recommend_type'] = array_combine(array_values($main['recommend_type']), array_values($main['recommend_type']));
			}
			$main['create_time'] = date('Y-m-d H:i:s', $main['create_time']);
			$data = array_merge($additional, $main);
			$response_data['code'] = 200;
			$response_data['message'] = '获取成功';
			$response_data['data'] = $data;
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '获取失败';
			
		}
		
		die(json_encode($response_data));
		
	}
	
	/**
	 *  获取对应内容模型的数据
	 */
	public function get_column_struct() 
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (!isset($data['id'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '获取内容模型结构失败';
		} else {
			if ($data = $this->column_model->get_one($data['id'])) {
				if ($channel = $this->channel_model->get_one($data['channel_id'])) {
					$struct = unserialize($channel['table_struct']);
					
					$sub_columns = $this->column_model->get_where("channel_id={$data['channel_id']} AND id!={$data['id']}");
					
					$html = $this->render($struct, $sub_columns);
					$response_data['code'] = 200;
					$response_data['message'] = '获取成功';
					$response_data['data'] = $html;
					
				} else {
					$response_data['code'] = 403;
					$response_data['message'] = '不存在的内容模型';
				}
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '不存在的栏目';
				
			}
		}
		
		die(json_encode($response_data));
	}
	
	/**
	 *  渲染结构
	 */
	public function render($struct, $sub_columns) 
	{
		$html = array();
		foreach ($struct as $key=>$value) {
			switch($value['channel_type']) {
				case 'text':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = "<input type='text' ng-model='article.$value[fields]' placeholder='$value[label_fields]' />";
					break;
				
				case 'textarea':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = "<textarea ng-model='article.$value[fields]' cols='30' rows='3' placeholder='$value[label_fields]'></textarea>";
					break;
				
				case 'checkbox':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = '';
					$html[$value['fields']]['style'] = 'style="background:none!important;"';
					$arr_value = explode(',', $value['values']);
					foreach ($arr_value as $k => $v) {
						$html[$value['fields']]['html'] .= "<input type='checkbox' ng-model='article.$value[fields].$k' ng-true-value='$v'  /> $v";
					}
					break;
					
				case 'radio':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = '';
					$html[$value['fields']]['style'] = 'style="background:none!important;"';
					$arr_value = explode(',', $value['values']);
					foreach ($arr_value as $k => $v) {
						$html[$value['fields']]['html'] .= "<input type='radio' ng-model='article.$value[fields]' value='$v'  /> $v";
					}
					break;
					
				case 'select':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = '';
					$arr_value = explode(',', $value['values']);
					$html[$value['fields']]['html'] .= "<select ng-model='article.$value[fields]'>";
					$html[$value['fields']]['html'] .= '<option value="">请选择'.$value['label_fields'].'</option>';
					foreach ($arr_value as $k => $v) {
						$html[$value['fields']]['html'] .= "<option value='$v'>$v</option>";
					}
					$html[$value['fields']]['html'] .= '</select>';
					break;
				
				case 'htmltext':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = '';
					// $html[$value['fields']]['html'] .= "<div class='ueditor' ng-model='article.$value[fields]'></div> ";
					$html[$value['fields']]['html'] .= "<textarea ck-editor ng-model='article.$value[fields]'></textarea>";
					break;
				
				case 'file':
				case 'image':
					$html[$value['fields']]['text'] = $value['label_fields'];
					$html[$value['fields']]['html'] = '';
					$html[$value['fields']]['html'] .= "<input type='text' ng-model='article.$value[fields]' placeholder='$value[label_fields]' readonly='' class='ng-pristine ng-valid'><button class='button ng-pristine ng-valid' ngf-select='' ng-model='files'>上传</button>";
					break;
				
				case 'multiple-image':
					break;
			}
		}
		
		$response_html = '';
		
		
		
		$response_html .= <<< SUBCOLUMNHEAD
			<tr class="newItem">
			  <td>&nbsp;</td>
			  <td align="right"><span class="red"></span>副栏目</td>
			  <td>&nbsp;</td>
			  <td class="okinput k1" style="background:none!important;">
					<div style="width:200px; height:200px; overflow:scroll; border:1px solid #ccc;">
SUBCOLUMNHEAD;


		foreach($sub_columns as $column) {
			$response_html .= <<< SUBCOLUMNBODY
				<p><input type="checkbox" ng-model="article.sub_column.$column[id]" value="$column[id]" ng-true-value="$column[id]" />$column[column_name]</p>
SUBCOLUMNBODY;
		}
		
		$response_html .= <<< SUBCOLUMNFOOTER
					</div>
			  </td>
			  <td>&nbsp;</td>
			</tr>
SUBCOLUMNFOOTER;
		
		foreach ($html as $key=>$value) {
			$style = isset($value['style']) ? $value['style'] : '';
			$response_html .= <<< EOF
			<tr class='newItem'>
			  <td>&nbsp;</td>
			  <td align='right'><span class='red'></span>$value[text]</td>
			  <td>&nbsp;</td>
			  <td class='okinput k1' $style>
				$value[html]
			  </td>
			  <td>&nbsp;</td>
			</tr>
EOF;
		}

		return $response_html;
	}
	
	private function get_additional_table_content($article_id)
	{
		
		$table_name = $this->get_additional_table($article_id);
		$response_data = array();
		if ($data = $this->db->where("id = $article_id")->get($table_name)->row_array()) {
			return $data;
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的文档';
			
		}
		
		die(json_encode($response_data));
		
	}
	
	private function get_additional_table($article_id)
	{
		$response_data = array();
		if ($row = $this->archives_model->get_one($article_id)) {
			if ($column = $this->column_model->get_one($row['cid'])) {
				if ($channel = $this->channel_model->get_one($column['channel_id'])) {
					
					$table_name = $channel['table_name'];
					return $table_name;
				
				} else {
					$response_data['code'] = 403;
					$response_data['message'] = '不存在的内容模型';
				}
				
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '不存在的栏目';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的文章';
		}
		die(json_encode($response_data));
	}
	
}