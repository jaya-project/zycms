
<div class="result" ng-controller="restoreCtrl">
  <div class="formtitle">回收站</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div class="searcharea" style="padding:10px;">
	<select name="" ng-model="search.cid" id="" ng-options="c.id as c.space+c.column_name for c in columns" placeholder="父栏目ID">
		<option value="">请选择栏目</option>
	</select>
	<input type="search" ng-model="search.keyword" placeholder="请输入文章标题" />
	<button ng-click="getAllArticle()">搜索</button>
	
  </div>

  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%"><input type="checkbox" ng-click="chk_all($event.target)" />文章ID</td>
                <td nowrap="nowrap" width="10%">文章标题</td>
                <td nowrap="nowrap" width="10%">所属分类</td>
				<td nowrap="nowrap" width="10%">排序</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ><input type="checkbox" ng-click="d.is_chk=d.id" ng-true-value="{{d.id}}" value="{{d.id}}" ng-model="d.is_chk" /> <span ng-bind="d.id"></span></td>
              <td ng-bind="d.title"></td>
              <td ng-bind="d.column_name"></td>
              <td ng-bind="d.sort"></td>
              <td><a ng-click="restoreDocument(1,d.id)" href="javascript:void(0)">还原</a> <a ng-click="deleteArticle(d.id)" href="javascript:void(0)">彻底删除</a></td>
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
	
	<div>
		<button ng-click="batDelete()">批量删除</button>
		<button ng-click="clean()">清空回收站</button>
		<button ng-click="restoreDocument(2)">还原所选</button>
		<button ng-click="restoreDocument(3)">还原所有</button>
	</div>
	<div class="nav-pages" ng-show="totalPages2>1">
			<a ng-click="getAllArticle(page)" ng-bind="page" ng-class="{true:'current-page'}[page==currentPage]" ng-repeat="page in totalPages"></a>
			
			共 {{totalPages2}} 页 / 第 {{currentPage}} 页
	</div>
	
  </div>
</div>
<div class="loading2 hidden" id="loading" ng-style="loading"></div>