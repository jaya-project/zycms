

<div class="commonform" id="saveForm">
<input type="hidden"/> 
  <div class="formtitle">表单添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>表单名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="form.name" ng-model="form.name" placeholder="表单名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>表名</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="form.table_name" ng-model="form.table_name" placeholder="表名" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	
	<tr>
		<td>&nbsp;</td>
		<td align="right"><span class="red">*</span>表单字段</td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text"  ng-model="form.label_fields" placeholder="模型字段说明"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text"  ng-model="form.fields"  placeholder="模型字段"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text"  ng-model="form.values"  placeholder="字段值"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1">
			<select ng-model="form.form_type"  ng-options="type.name as type.value for type in formType">
				<option value="">请选择字段类型</option>
			</select>
		</td>
		<td>&nbsp;</td>
		<td><a style="display:inline-block; width:30px; height:20px;" ng-click="addTableTr()">+</a></td>
	</tr>
	
	<tr ng-repeat="m in formArray">
		<td>&nbsp;</td>
		<td align="right"><span class="red">*</span>表单字段</td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text" ng-model="m.label_fields" placeholder="模型字段说明"  /> </td>
		<td>&nbsp;</td>                           
		<td class="okinput k1"><input type="text" ng-model="m.fields" placeholder="模型字段"  /> </td>
		<td>&nbsp;</td>                           
		<td class="okinput k1"><input type="text" ng-model="m.values" placeholder="字段值"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1">
			<select ng-model="m.form_type"  ng-options="type.name as type.value for type in formType">
				<option value="">请选择字段类型</option>
			</select>
		</td>
		<td>&nbsp;</td>
		<td><a style="display:inline-block; width:30px; height:20px;" ng-click="deleteTableTr($index)">-</a></td>
	</tr>
	
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>邮箱名</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="form.recevied" ng-model="form.recevied" placeholder="自动发送邮件到该邮箱" /> </td>
      <td>&nbsp;</td>
	  <td>(填写该项,则自动将该表单的内容发送到指定的邮箱内)</td>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="isEdit" value="保存" ng-click="addForm();"><input type="button" id="submitform" class="buttons button2" ng-show="isEdit" value="保存" ng-click="modifyContent();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
