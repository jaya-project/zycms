
<div class="result" ng-controller="exportCtrl">
  <div class="formtitle">批量导入文章</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>

  <div class="searcharea" style="padding:10px;">
	<select name="" ng-model="search.cid" id="" ng-options="c.id as c.space+c.column_name for c in columns" placeholder="父栏目ID">
		<option value="">请选择栏目</option>
	</select>
	
	<button ng-click="downloadTemplate();" ng-show="search.cid">下载模板</button>
	
	
	<span ng-show="search.cid">
		<button  ngf-select ng-model="files">批量导入</button>
	</span>
  </div>

  <div class="content">
   
    <div style="height:10px;"></div>
	
	<ul style="line-height:24px; text-indent:2em;">
		<li>1. 先选择栏目, 下载模板, 模板文件名格式为 表名称_栏目id.csv</li>
		<li>2. 根据模板里的格式填写数据</li>
		<li>3. 上传模板文件</li>
		<li>4. 批量导入成功</li>
		<li style="color:#f00;">请不要调换模板中字段的位置, 也不要更改模板的文件名 </li>
		<li style="color:#f00;">若因为重名问题, 模板被自动命名为 xxx(1).csv 这样的格式, 请手动改成 xxx.csv </li>
		
	</ul>
	
	
  </div>
</div>
<div class="loading2 hidden" id="loading" ng-style="loading"></div>