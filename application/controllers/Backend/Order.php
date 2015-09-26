<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  订单控制器
 */
class Order extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('order_model', 'order_product_model', 'member_model'));
		$this->load->library(array('session', 'area'));
		$this->load->helper(array('array', 'url', 'security', 'download'));
		
	}
	
	public function download($orderNumber) {
		$data = '';
		
		$row = $this->order_model->get_one($orderNumber);
		
		$create_time = date('Y-m-d H:i:s', $row[0]['create_time']);
		
		$member = $this->member_model->get_one_by_condition($row[0]['mid'], "m.email, m.true_name, m.address, p.province, c.city, a.area area, m.mobile");
		
		$data .= <<< EOF
	<table width="500" border="1" style="font-size:14px;">
    <tr height="50">
        <td colspan="7" style="font-size:22px; font-weight:bold;  text-align:center;">
            订单号 : {$row[0][order_number]}
        </td>
    </tr>
    <tr height="30">
        <td colspan="7" style="text-align:right;">
            下单时间:$create_time
        </td>
    </tr>
    <tr height="30">
        <td colspan="7" style="text-align:left;font-weight:bold;">
            基本信息
        </td>
    </tr>
    <tr height="30">
        <td>
            会员号
        </td>
        <td colspan="6" style="text-align:left;">
            $member[email]
        </td>
    </tr>
    <tr height="30">
        <td>
            收货人名称
        </td>
        <td colspan="6" style="text-align:left;">
            $member[true_name]
        </td>
    </tr>
    <tr height="30">
        <td>
            收货地址
        </td>
        <td colspan="6" style="text-align:left;">
            $member[province] $member[city] $member[area] $member[address]
        </td>
    </tr>
    <tr height="30">
        <td>
            联系方式
        </td>
        <td colspan="6" style="text-align:left;">
            $member[mobile]
        </td>
    </tr>
    <tr height="30">
        <td>
            订单备注
        </td>
        <td colspan="6" style="text-align:left;">
		{$row[0][note]}
        </td>
    </tr>
    <tr height="30">
        <td>
            序号
        </td>
        <td>
            商品名
        </td>
        <td>
            数量
        </td>
        <td>
            单价
        </td>
        <td>
            小计
        </td>
    </tr>
EOF;
	
	$i = 0;
	$total_amount = 0;
	$total_money = 0;
	foreach ($row as $k=>$v) {
		$i++;
		$total = $v['amount'] * $v['price'];
		$total_money += $total;
		$total_amount += $v['amount'];
		$data .= <<< EOF
		 <tr>
			<td>
				$i
			</td>
			<td>
				$v[title]
			</td>
			<td>
				$v[amount]
			</td>
			<td>
				$v[price]
			</td>
			<td>
				$total
			</td>
		</tr>
EOF;
	}
	
   $data .= <<< EOF
    <tr height="30">
        <td colspan="7" style="text-align:right;">
            产品总数: $total_amount , 金额总计: $total_money
        </td>
    </tr>
	
</table>	
EOF;
	
	$name = '订单列表.xls';
	
	force_download($name, $data); 

	
	}
	
	
	public function get_all()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		$data = $this->order_model->get_all();
		
		$data = array_map(function($item) {
					$item['create_time'] = date('Y-m-d H:i:s', $item['create_time']);
					return $item;
				}, $data);
		
		$response_data['code'] = 200;
		$response_data['message'] = '获取成功';
		$response_data['data'] = $data;
		
		
		die(json_encode($response_data));
	}
	
	public function set_state()
	{
		$data = $this->input->stream();
		
		if (isset($data['order_number']) && !empty($data['order_number'])) {
			if ($data = $this->order_model->update($data['order_number'], array("state"=>1))) {
				$response_data['code'] = 200;
				$response_data['message'] = '设置成功';
				
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '设置失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不正确的订单号';
		}
		
		die(json_encode($response_data));
		
	}
	
	public function get_specify_order()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['order_number']) && !empty($data['order_number'])) {
			if ($data = $this->order_model->get_one($data['order_number'])) {
				$response_data['code'] = 200;
				$response_data['message'] = '获取成功';
				
				$response_data['data'] = $data;
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '获取失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的ID或ID为空';
		}
		
		die(json_encode($response_data));
		
	}
	
	
	public function delete()
	{
		$data = $this->input->stream();
		
		$response_data = array();
		
		if (isset($data['order_number']) && !empty($data['order_number'])) {
			
			if ($this->order_model->delete($data['order_number']) && $this->order_product_model->delete_where("order_number=$data[order_number]")) {
				$response_data['code'] = 200;
				$response_data['message'] = '删除成功';
			} else {
				$response_data['code'] = 403;
				$response_data['message'] = '删除失败';
			}
		} else {
			$response_data['code'] = 403;
			$response_data['message'] = '不存在的ID或ID为空';
		}
		
		die(json_encode($response_data));
	}
	
	public function get_provinces()
	{
		$area = $this->area;
		$data = $area::get_provinces();
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
	}
	
	public function get_cities()
	{
		$data = $this->input->stream();
		$area = $this->area;
		$data = $area::get_cities($data['id']);
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
	}
	
	public function get_areas()
	{
		$data = $this->input->stream();
		$area = $this->area;
		$data = $area::get_areas($data['id']);
		
		die(json_encode(array('code'=>200, 'message'=>'获取成功', 'data'=>$data)));
	}
	
	
	
}