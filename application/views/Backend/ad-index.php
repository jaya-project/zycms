
<div class="result" ng-controller="adCtrl">
  <div class="formtitle">广告列表</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div class="searcharea" style="padding:10px;">
	<button ng-click="showAddUI()">增加广告</button>
  </div>

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">广告ID</td>
                <td nowrap="nowrap" width="10%">广告名称</td>
                <td nowrap="nowrap" width="10%">所属广告位</td>
				<td nowrap="nowrap" width="10%">排序</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ng-bind="d.id"></td>
              <td ng-bind="d.name"></td>
              <td ng-bind="d.ad_position_name"></td>
              <td ng-bind="d.sort"></td>
              <td><a ng-click="deleteContent(d.id)" href="javascript:void(0)">删除</a> <a ng-click="showModifyUI(d.id)" href="javascript:void(0)">修改</a></td>
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