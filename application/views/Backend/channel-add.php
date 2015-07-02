<div class="commonform" ng-controller="modelCtrl">
<input type="hidden"/> 
  <div class="formtitle">内容模型添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>内容模型名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="channel_name" ng-model="channel.channel_name" placeholder="内容模型名称" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>内容模型副表</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="table_name" ng-model="channel.table_name"  placeholder="article1"  /></td>
      <td>&nbsp;</td>
    </tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right"><span class="red">*</span>模型字段</td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text"  ng-model="channel.label_fields" placeholder="模型字段说明"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text"  ng-model="channel.fields"  placeholder="模型字段"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text"  ng-model="channel.values"  placeholder="字段值"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1">
			<select ng-model="channel.channel_type"  ng-options="type.name as type.value for type in channelType">
				
			</select>
		</td>
		<td>&nbsp;</td>
		<td><a style="display:inline-block; width:30px; height:20px;" ng-click="addTableTr()">+</a></td>
	</tr>
	
	<tr ng-repeat="m in modelArray">
		<td>&nbsp;</td>
		<td align="right"><span class="red">*</span>模型字段</td>
		<td>&nbsp;</td>
		<td class="okinput k1"><input type="text" ng-model="m.label_fields" placeholder="模型字段说明"  /> </td>
		<td>&nbsp;</td>                           
		<td class="okinput k1"><input type="text" ng-model="m.fields" placeholder="模型字段"  /> </td>
		<td>&nbsp;</td>                           
		<td class="okinput k1"><input type="text" ng-model="m.values" placeholder="字段值"  /> </td>
		<td>&nbsp;</td>
		<td class="okinput k1">
			<select ng-model="m.channel_type"  ng-options="type.name as type.value for type in channelType">
				
			</select>
		</td>
		<td>&nbsp;</td>
		<td><a style="display:inline-block; width:30px; height:20px;" ng-click="deleteTableTr($index)">-</a></td>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" value="保存" ng-click="addModel();"></td>
    </tr>
  </tbody>
	</table>
	
	<?php if (!empty($channel_id)) : ?>
		<input type="hidden" name="channel_id" id="channelId" value="<?=$channel_id?>" />
	<?php endif ?>

</div>
