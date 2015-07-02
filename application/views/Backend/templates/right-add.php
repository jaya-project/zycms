

<div class="commonform" id="saveRight">
<input type="hidden"/> 
  <div class="formtitle">权限添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>权限名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="right.name" ng-model="right.name" placeholder="权限名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>权限资源</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="right.resource" ng-model="right.resource" placeholder="权限资源" /> </td>
	  <td><a href="javascript:void(0)" ng-click="addResource();" style="display:inline-block; width:30px; height:20px;">+</a></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr ng-repeat="r in rights">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>权限资源</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="r.resource" ng-model="r.resource" placeholder="权限资源" /> </td>
	  <td><a href="javascript:void(0)" ng-click="deleteResource($index);" style="display:inline-block; width:30px; height:20px;">-</a></td>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="isEdit" value="保存" ng-click="addContent();"><input type="button" id="submitform" class="buttons button2" ng-show="isEdit" value="保存" ng-click="modifyContent();"><input type="hidden" ng-model="right.id" /></td>
    </tr>
  </tbody>
	</table>
	

</div>
