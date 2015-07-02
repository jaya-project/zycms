
<div class="result" ng-controller="messageCtrl">
  <div class="formtitle">消息列表</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div class="searcharea" style="padding:10px;">
	<select name="" ng-options="member.id as member.username + ' | ' + member.true_name for member in members" ng-model="memberId" id="">
		<option value="">请选择会员</option>
	</select>
	
	<button ng-click="searchMessage()">搜索</button>
	
	<button ng-click="batDelete()">删除所选消息</button>
  </div>

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%"><input type="checkbox" ng-click="chk_all($event.target);" />消息ID</td>
				<td nowrap="nowrap" width="10%">消息标题</td>
                <td nowrap="nowrap" width="10%">消息发出者</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ><input type="checkbox" ng-model="d.is_chk" ng-click="d.is_chk=d.id" ng-true-value="{{d.id}}" ng-false-value="" />{{d.id}}</td>
			<td ng-bind="d.title"></td>
              <td ng-bind="d.mid == 0 ? '系统' : d.username"></td>
              <td><a ng-click="deleteMessage(d.id)" href="javascript:void(0)">删除</a> <a ng-click="showMessageList(d.id)" href="javascript:void(0)">查看回复</a> <a ng-click="showReplyUI(d.id)" href="javascript:void(0)">回复</a></td>
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