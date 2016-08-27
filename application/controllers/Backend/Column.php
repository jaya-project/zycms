<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  内容模型控制器
 */
class Column extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('column_model', 'archives_model', 'channel_model', 'rule_model'));
		$this->load->library(array('session'));
		$this->load->helper(array('array', 'url'));

	}

	public function get_column()
	{
		$data = $this->input->stream();

		$columns = $this->column_model->get_all(array('field'=>'sort', 'way'=>'asc'));

		$new_columns = array();
		foreach($columns as $key=>$value) {
			$new_columns[$value['id']] = $value;
		}
		$columns = getTreeData(gen_tree($new_columns, 'pid'));

		if (isset($data['channelId']) && !empty($data['channelId'])) {
			$columns = array_filter($columns, function($item) use ($data) {
							return $item['channel_id'] == $data['channelId'];
						});
		}

		$columns = array_values($columns);
		die(json_encode(array('code'=>200, 'data'=>$columns, 'message'=>'获取成功')));

	}

	/**
	 *  获取指定的栏目
	 */
	public function get_specify_column()
	{
		$data = $this->input->stream();

		if (isset($data['id'])) {
			if ($data = $this->column_model->get_one($data['id'])) {
				$data['rules'] = $this->rule_model->get_where("cid=$data[id]");
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '获取失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '传过来的ID信息不正确';
		}

		die(json_encode($response_data));
	}

	public function column_save()
	{
		$data = $this->input->stream();


		$response_data = array();

		if (!isset($data['column_name']) || !isset($data['channel_id']) || !isset($data['pid'])) {
			$response_data['code'] = 403;
			$response_data['message'] = '带*号的为必填项';

		} else {
			//设置分类级别
			if ($data['pid'] == 0) {
				$data['level'] = 1;
			} else {
				if ($row = $this->column_model->get_one($data['pid'])) {
					$data['level'] = $row['level'] + 1;
				} else {
					$response_data['code'] = 403;
					$response_data['message'] = '不存在的父栏目';
					die(json_encode($response_data));
				}

			}

			if (empty($data['column_name']) || empty($data['channel_id'])) {
				$response_data['code'] = 403;
				$response_data['message'] = '带*号的为必填项';

			} else {

				if (isset($data['is_edit'])) {
					$this->column_edit($data);
				} else if (isset($data['is_add'])) {

					$this->column_add($data);

				} else {
					$response_data['code'] = 403;
					$response_data['message'] = '非法的动作';
				}
			}
		}

		die(json_encode($response_data));
	}

	/**
	 *  添加栏目
	 */
	public function column_add($data)
	{
		$data = array_diff_key($data, array('is_add'=>1));

		if ( $this->column_model->insert($data)) {
			$this->_build_column_rule($this->column_model->get_insert_id());
			$response_data['code'] = 200;
			$response_data['message'] = '添加成功';

		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '添加失败,请稍候再试';
		}

		die(json_encode($response_data));


	}

	public function column_edit($data)
	{
		$column = $this->column_model->get_one($data['id']);
		if ($this->archives_model->is_exists("cid=$data[id]") && $data['channel_id'] != $column['channel_id']) {
			$response_data['code'] = 403;
			$response_data['message'] = '更改失败, 请先删除该栏目下的文章并清空回收站';
			die(json_encode($response_data));
		}
		//入库之前判断是否更换过图片
		if ($row = $this->column_model->get_one($data['id'])) {
			if ( $row['column_thumb'] != $data['column_thumb']) {
				@unlink('.'.$row['column_thumb']);
			}
		}

		$rules = '';
		if (isset($data['rules'])) {
			$rules = $data['rules'];
		}

		if ($rules && is_array($rules)) {
			$this->rule_model->delete_where("cid=$data[id]");
			$this->rule_model->multiple_insert($rules);
		}

		if (isset($data['cascading']) && !empty($data['cascading'])) {
			$this->_cascading_update_sub_column_rule($data['id']);
		}

		if ($this->column_model->update($data['id'], array_diff_key($data, array('id'=>1, 'is_edit'=>1, 'rules'=>1, 'cascading'=>1)))) {
			$response_data['code'] = 200;
			$response_data['message'] = '编辑成功';

		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '编辑失败,请稍候再试';
		}


		die(json_encode($response_data));
	}



	/**
	 *  栏目删除
	 */
	public function column_delete()
	{
		$data = $this->input->stream();


		if (isset($data['id'])) {
			if ($row = $this->column_model->get_one($data['id'])) {

				@unlink('.'.$row['column_thumb']);

			}
			$this->delete_archives_under_column($data['id'], $row['channel_id']);

			if ($this->column_model->delete($data['id'])) {
				$this->rule_model->delete_where("cid=$data[id]");
				$response_data['code'] = 200;
				$response_data['message'] = '删除成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '删除失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = 'ID不能为空';
		}

		die(json_encode($response_data));
	}

	/**
	 *  删除栏目下的文章
	 */
	private function delete_archives_under_column($column_id, $channel_id)
	{
		$row = $this->channel_model->get_one($channel_id);

		$archives = $this->archives_model->get_where("cid=$column_id");


		$ids = array_column($archives, 'id');

		if (!empty($ids)) {

			$where = join(',', $ids);

			$this->archives_model->delete_where("id in ($where)") && $this->db->where("id in ($where)")->delete($row['table_name']);
		}



	}

	public function modify_sort()
	{
		$data = $this->input->stream();

		$this->load->library('MySort');
		die($this->mysort->set_model('column_model')->modify_sort((int)$data['id'], (int)$data['sort']));
	}

	/**
	 *  生成规则
	 *  如果有父栏目,根据父栏目规则生成规则
	 */
	private function _build_column_rule($columnId)
	{
		$columnRow = $this->column_model->get_one($columnId);

		if ($columnRow['pid'] != 0) {
			$rules = $this->_create_rule_by_parent_column($columnRow);
		} else {
			$this->load->library('Pinyin');
			$channelRow = $this->channel_model->get_one($columnRow['channel_id']);

			$pinyin = $this->pinyin;
			$table_name = $channelRow['table_name'];
			$column_name = $pinyin::getPinyin($columnRow['column_name']);

			$rules[] = array(
								'cid' => $columnId,
								'destination_rule' => $column_name . '.html',
								'source_rule' => $column_name . "/index/$columnId",
								'type' => 1
							);

			$rules[] = array(
							'cid' => $columnId,
							'destination_rule' => $column_name . "/$columnId-page.html",
							'source_rule' => $table_name . "/category/$columnId/page/12",
							'type' => 2
						);

			$rules[] = array(
							'cid' => $columnId,
							'destination_rule' => $column_name . "/aid.html",
							'source_rule' => $table_name . "/detail/aid",
							'type' => 3
						);
		}

		$this->rule_model->multiple_insert($rules);

	}


	/**
	 *  jaya update 20160805
	 *  创建规则
	 *
	 */
	private function _create_rule_by_parent_column($column)
	{


		$this->load->library('Pinyin');
		$pinyin = $this->pinyin;
		$column_name = $pinyin::getPinyin($column['column_name']);

		$new_rules = array();
		$parentColumn = current($this->column_model->get_where("id=$column[pid]"));
		$rules = $this->rule_model->get_where("cid=$parentColumn[id]");

		foreach ($rules as $rule) {
			if ($rule['type'] == 1) {
				$single_source_rule = str_replace(preg_replace('/\D/s', '', $rule['source_rule']), $column['id'], $rule['source_rule']);
				$new_rules[] = array(
										'cid' => $column['id'],
										'destination_rule' => $column_name.'.html',
										'source_rule' => $single_source_rule,
										'type' => 1
									);

			} elseif ($rule['type'] == 2) {
				$temp = explode('/', $rule['destination_rule']);
				$temp[0] = $column_name;
				$temp[1] = "{$column['id']}-page.html";
				$rule['destination_rule'] = join('/', $temp);

				$temp = explode('/', $rule['source_rule']);
				$temp[2] = $column['id'];
				$rule['source_rule'] = join('/', $temp);
				$new_rules[] = array(
										'cid' => $column['id'],
										'destination_rule' => $rule['destination_rule'],
										'source_rule' => $rule['source_rule'],
										'type' => 2
									);
			} elseif ($rule['type'] == 3) {
				$new_rules[] = array(
										'cid' => $column['id'],
										'destination_rule' => $column_name.'/aid.html',
										'source_rule' => $rule['source_rule'],
										'type' => 3
									);
			}
		}
		return $new_rules;
	}

	/**
	 *  级联更改子栏目规则
	 */
	private function _cascading_update_sub_column_rule($id)
	{
		$columns = $this->column_model->get_where("pid=$id");
		if ($columns) {
			foreach ($columns as $column) {
				$rules = $this->_create_rule_by_parent_column($column);
				$this->rule_model->delete_where("cid=$column[id]");
				$this->rule_model->multiple_insert($rules);
			}
		}
	}

}