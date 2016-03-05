﻿
<div class="result" ng-controller="modelCtrl">
  <div class="formtitle">内容模型列表</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

<!-- <div class="content"><a href="#" onclick="return downloadfile(this);"><img src="/images/export_client.png" width="185" height="57" style="border:none 0px;"></a></div>-->

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">模型ID</td>
                <td nowrap="nowrap" width="10%">模型名称</td>
                <td nowrap="nowrap" width="10%">表名</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
              <td ng-bind="d.channel_id"></td>
              <td ng-bind="d.channel_name"></td>
              <td ng-bind="d.table_name"></td>
              <td><a ng-click="modifyModel(d.channel_id)" href="javascript:void(0)">修改</a> <a ng-click="deleteModel(d.channel_id)" href="javascript:void(0)">删除</a></td>
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

