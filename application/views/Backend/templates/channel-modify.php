<div class="commonform" id="container">
<input type="hidden"/> 
  <div class="formtitle">内容模型修改</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table ng-hide="addingField==true || modifingField==true" border="1" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
	
	<tr>
		<th style="padding:0 10px;">字段说明</th>
		<th style="padding:0 10px;">字段名</th>
		<th style="padding:0 10px;">字段类型</th>
		<th style="padding:0 10px;">操作</th>
	</tr>
	
	<tr ng-repeat="m in modelArray">
		<td class="okinput" style="font-size:14px; padding:5px;" ng-bind="m.label_fields"></td>
		<td class="okinput" style="font-size:14px; padding:5px;" ng-bind="m.fields"> </td>
		<td class="okinput" style="font-size:14px; padding:5px;" ng-bind="m.channel_type"> </td>
		<td class="okinput" style="font-size:14px; padding:5px;" > <a href="javascript:void(0);" ng-click="deleteFields(channelId, m.fields)">删除</a> <a href="javascript:void(0);" ng-click="showModifyUI($index)">编辑</a></td>
	</tr>
	
	<tr>
		<td colspan="4"><button class="btn" ng-click="showAddUI();">添加字段</button></td>
	</tr>
   
  </table>
  
	<table ng-show="addingField==true">
		<tr ng-repeat="newField in newFields">
			<td>&nbsp;</td>
			<td align="right"><span class="red">*</span>模型字段</td>
			<td>&nbsp;</td>
			<td class="okinput k1"><input type="text" ng-model="newField.label_fields" placeholder="模型字段说明"  /> </td>
			<td>&nbsp;</td>                           
			<td class="okinput k1"><input type="text" ng-model="newField.fields" placeholder="模型字段"  /> </td>
			<td>&nbsp;</td>                           
			<td class="okinput k1"><input type="text" ng-model="newField.values" placeholder="字段值"  /> </td>
			<td>&nbsp;</td>
			<td class="okinput k1">
				<select ng-model="newField.channel_type"  ng-options="type.name as type.value for type in channelType">
					
				</select>
			</td>
			<td>&nbsp;</td>
			<td ng-if="$index==0"><a style="display:inline-block; width:30px; height:20px;" ng-click="addFieldRow()">+</a></td>
			<td ng-if="$index!=0"><a style="display:inline-block; width:30px; height:20px;" ng-click="deleteFieldRow($index)">-</a></td>
		</tr>
		
		<tr>
			<td colspan="12"><input type="button" id="submitform" class="buttons button2" value="保存" ng-click="addField(channelId);"> <input type="button" id="submitform" class="buttons button2" value="返回" ng-click="cancelAdd();"></td>
		</tr>
	</table>
	
	<table ng-show="modifingField==true">
		<tr>
			<td>&nbsp;</td>
			<td align="right"><span class="red">*</span>模型字段</td>
			<td>&nbsp;</td>
			<td class="okinput k1"><input type="text" ng-model="oldField.label_fields" placeholder="模型字段说明"  /> </td>
			<td>&nbsp;</td>                           
			<td class="okinput k1"><input type="text" ng-model="oldField.fields" placeholder="模型字段"  /> </td>
			<td>&nbsp;</td>                           
			<td class="okinput k1"><input type="text" ng-model="oldField.values" placeholder="字段值"  /> </td>
			<td>&nbsp;</td>
			<td class="okinput k1">
				<select ng-model="oldField.channel_type"  ng-options="type.name as type.value for type in channelType">
					
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="11"><input type="button" id="submitform" class="buttons button2" value="修改" ng-click="modifyField(channelId);"> <input type="button" id="submitform" class="buttons button2" value="返回" ng-click="cancelModify();"></td>
		</tr>
	</table>
</div>
