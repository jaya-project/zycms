﻿

<div class="commonform" ng-controller="columnCtrl">
<input type="hidden"/> 
  <div class="formtitle">栏目添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>栏目名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="column.column_name" ng-model="column.column_name" placeholder="栏目名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>栏目名称(英文)</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="column.english_name" ng-model="column.english_name" placeholder="栏目名称-英文" /></td>
      <td>&nbsp;</td>
    </tr>
	
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>内容模型</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<select name="" id="" ng-model="column.channel_id" ng-options="channel.channel_id as channel.channel_name for channel in channels">
			<option value="">请选择内容模型</option>
		</select>
	  </td>
      <td>&nbsp;</td>
    </tr>
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>父栏目</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<select name="" id="" ng-model="column.pid" ng-options="c.id as c.space+c.column_name for c in columns" placeholder="父栏目ID">
			<option value="">顶级栏目</option>
		</select>
	  </td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>排序</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="排序" ng-model="column.sort"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>栏目封面</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" ng-model="column.column_thumb" placeholder="栏目封面" readonly />
		
		<button class="button" ngf-select ng-model="files">上传</button>
	  </td>
      <td><div id="process" style="width:200px; height:12px; border:1px solid #ccc; padding:0; position:relative; display:none;"><span style="width:10%; height:100%; display:inline-block; background:green; margin:0; position:absolute; "></span></div>
		
		<img ng-show="column.column_thumb" ng-model="column.column_thumb" id="fullPath" src="{{column.column_thumb}}"  alt="" width="80" /></td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>栏目摘要</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea name="" id="" ng-model="column.summary" placeholder="栏目摘要" cols="40" rows="3"></textarea> 
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SEO标题</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" name="" id="" ng-model="column.seo_title" placeholder="seo标题" /> 
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SEO关键词</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" name="" id="" ng-model="column.seo_keywords" placeholder="SEO关键词" /> 
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SEO描述</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea  ng-model="column.seo_description" placeholder="SEO描述" cols="40" rows="3"></textarea> 
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>栏目内容</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea ck-editor ng-model="column.content"></textarea>
	  </td>
      <td>&nbsp;</td>
    </tr>
   
  </table>
  
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:650px;">
    <tbody><tr>
      <td style="width:5px;"></td>
      <td style="width:100px" align="right">&nbsp;</td>
      <td style="width:10px;">&nbsp;</td>
      <td style="width:200px;">&nbsp;</td>
      <td style="width:3px">&nbsp;</td>
      <td style="width:100px" align="right">&nbsp;</td>
      <td style="width:10px">&nbsp;</td>
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="columnId" value="保存" ng-click="addColumn();"><input type="button" id="submitform" class="buttons button2" ng-show="columnId" value="保存" ng-click="updateColumn();"></td>
    </tr>
  </tbody>
	</table>
	

</div>