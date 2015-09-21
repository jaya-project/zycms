<script language="Javascript" type="text/javascript" src="/assets/Admin/js/edit_area/edit_area_full.js"></script>
<div class="result" ng-controller="templatesCtrl">
  <div class="formtitle">模板管理</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>


  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">序号</td>
                <td nowrap="nowrap" width="10%">模板描述</td>
                <td nowrap="nowrap" width="10%">模板路径</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ng-bind="$index+1"></td>
              <td ng-bind="d.desc"></td>
              <td ng-bind="d.path"></td>
              <td><a ng-click="deleteTemplate(d.path)" href="javascript:void(0)">删除</a> <a ng-click="showEditorUI(d.path)" href="javascript:void(0)">编辑</a> </td>
            </tr>
  </tbody>
          </table></td>
      </tr>
    </tbody></table>
    <div style="height:10px;"></div>
	
	
  </div>
</div>
<div class="loading2 hidden" id="loading" ng-style="loading"></div>
