

<div class="commonform" id="saveRole">
<input type="hidden"/> 
  <div class="formtitle">角色添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>角色名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="role.name" ng-model="role.name" placeholder="角色名称" /></td>
	  <td><input type="checkbox" ng-click="chk_all($event.target)" /> 全选</td>
      <td>&nbsp;</td>
	  
    </tr>
	
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>权限</td>
      <td>&nbsp;</td>
      <td colspan="2">
		<span ng-repeat="r in rights">
			<input type="checkbox" ng-model="r.is_chk" ng-click="r.is_chk=r.id" ng-false-value="" ng-true-value="{{r.id}}" /> {{r.name}}
			<br ng-if="($index+1) % 3 == 0" />
		</span>
		
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="isEdit" value="保存" ng-click="addContent();"><input type="button" id="submitform" class="buttons button2" ng-show="isEdit" value="保存" ng-click="modifyContent();"><input type="hidden" ng-model="right.id" /></td>
    </tr>
  </tbody>
	</table>
	

</div>
