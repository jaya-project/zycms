
<div class="result" ng-controller="databaseCtrl">
  <div class="formtitle">数据备份</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>


  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">序号</td>
                <td nowrap="nowrap" width="10%">备份文件名</td>
                <td nowrap="nowrap" width="10%">备份时间</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ng-bind="$index+1"></td>
              <td ng-bind="d.filename"></td>
              <td ng-bind="d.create_time"></td>
              <td><a ng-click="deleteBackup(d.filename)" href="javascript:void(0)">删除</a> <a ng-click="restoreBackup(d.filename)" href="javascript:void(0)">还原</a> </td>
            </tr>
  </tbody>
            <tfoot id="ResultTfoot" style="">
              <tr>
                <td colspan="8" align="center" id="pagebar">
					<hr />
					<button ng-click="backup()">一键备份</button>
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