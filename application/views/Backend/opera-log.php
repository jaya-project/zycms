<div class="result" ng-controller="logCtrl">
  <div class="formtitle">日志管理</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div class="searcharea" style="padding:10px;">
	<input type="date" ng-model="queryObj.start_time" />
	<input type="date" ng-model="queryObj.end_time"  />
	<input type="search" ng-model="queryObj.user" placeholder="请输入用户名" />
	<button ng-click="getData()">搜索</button>
  </div>

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">序号</td>
                <td nowrap="nowrap" width="10%">操作用户</td>
                <td nowrap="nowrap" width="10%">IP</td>
                <td nowrap="nowrap" width="10%">操作时间</td>
                <td nowrap="nowrap" width="10%">控制器和方法</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ng-bind="d.id"></td>
              <td ng-bind="d.user"></td>
              <td ng-bind="d.ip"></td>
              <td ng-bind="d.opera_time"></td>
              <td ng-bind="d.cm"></td>
              <td><a ng-click="deleteLog(d.id)" href="javascript:void(0)">删除</a>  </td>
            </tr>
  </tbody>
          </table></td>
      </tr>
    </tbody></table>
    <div style="height:10px;"></div>
   <div style="margin-bottom:10px;"><button ng-click="clean()">一键清空</button></div> 
	<div class="nav-pages">
			<a ng-click="getData(page)" ng-bind="page" ng-class="{true:'current-page'}[page==currentPage]" ng-repeat="page in totalPages"></a>
			
			共 {{totalPages2}} 页 / 第 {{currentPage}} 页
	</div>
	
	
  </div>
</div>
<div class="loading2 hidden" id="loading" ng-style="loading"></div>
