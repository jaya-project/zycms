<style type="text/css">
	.item:hover { background:#ccc;}
</style>

<div class="result" ng-controller="buildHtmlCtrl">
  <div class="formtitle">生成静态</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div>
	<button ng-click="addRule();">添加规则</button>
	<button ng-click="buildRule();">根据栏目一键生成规则</button>
	<button ng-click="buildIndex();">生成首页</button>
  </div>

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="5%">序号</td>
				<td nowrap="nowrap" width="10%">栏目</td>
                <td nowrap="nowrap" width="35%">目标路径规则</td>
                <td nowrap="nowrap" width="40%">源路径规则</td>
				<td nowrap="nowrap" width="5%">类型</td>
                <td nowrap="nowrap" width="5%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data" class="item">
			<td ng-bind="$index+1"></td>
			  <td>
				<select name="" ng-model="d.cid" ng-options="column.id as column.column_name for column in columns" id="">
					<option value="">请选择栏目</option>
				</select>
			  </td>
              <td><input type="text" ng-model="d.destination_rule" ng-change="changeAction()" style="width:400px;" /></td>
              <td><input type="text" ng-model="d.source_rule" ng-change="changeAction()"  style="width:400px;" /></td>
			  <td>
				<select name="" ng-model="d.type" ng-options="type.id as type.name for type in types" id="">
					
				</select>
			  </td>
              <td><a ng-click="deleteContent($index)" href="javascript:void(0)">删除</a> <a ng-click="buildSingleHtml(d.id)" href="javascript:void(0)">生成</a></td>
            </tr>
  </tbody>
            <tfoot id="ResultTfoot" style="">
              <tr>
                <td colspan="8" align="center" id="pagebar">
				<input type="button" id="submitform" class="buttons button2" ng-show="data.length>0" ng-hide="isChanged" value="生成" ng-click="buildHtml();">
				<input type="button" id="submitform" class="buttons button2"  ng-if="isChanged" value="保存" ng-click="saveRule();">
                </td>
              </tr>
            </tfoot>
          </table></td>
      </tr>
    </tbody></table>
    <div style="height:10px;"></div>
	
	
  </div>
</div>