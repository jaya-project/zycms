

<div class="commonform" id="saveUser">
<input type="hidden"/> 
  <div class="formtitle">用户添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>用户名</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="user.username" ng-model="user.username" placeholder="用户名" /></td>
      <td>&nbsp;</td>
	  
    </tr>
	
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>密码</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="password" name="user.password" ng-model="user.password" placeholder="密码" /></td>
      <td>&nbsp;</td>
	  
    </tr>
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>角色</td>
      <td>&nbsp;</td>
      <td colspan="2">
		<select name="user.rid" id="" ng-model="user.rid" ng-options="role.id as role.name for role in roles">
			<option value="">请选择角色</option>
		</select>
		
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
