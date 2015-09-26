
<div class="result" ng-controller="orderCtrl">
  <div class="formtitle">订单列表</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">订单号</td>
                <td nowrap="nowrap" width="10%">下单时间</td>
				<td nowrap="nowrap" width="10%">订单状态</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ng-bind="d.order_number"></td>
              <td ng-bind="d.create_time"></td>
			  <td ng-bind="d.state==0?'未处理':'已处理'"></td>
              <td><a ng-click="deleteContent(d.order_number)" href="javascript:void(0)">删除</a> <a ng-click="showModifyUI(d.order_number)" href="javascript:void(0)">查看详情</a> <a ng-click="setState(d.order_number)" href="javascript:void(0)" ng-show="d.state==0">设为已处理</a> <a ng-click="download(d.order_number)" href="javascript:void(0)">下载订单</a></td>
            </tr>
  </tbody>
            <tfoot id="ResultTfoot" style="">
              <tr>
                <td colspan="8" align="center" id="pagebar">
                </td>
              </tr>
            </tfoot>
          </table></td>
      </tr>
    </tbody></table>
    <div style="height:10px;"></div>
	
	
  </div>
</div>
<div class="loading2 hidden" id="loading" ng-style="loading"></div>