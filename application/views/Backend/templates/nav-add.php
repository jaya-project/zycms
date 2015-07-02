

<div class="commonform" id="saveNav">
<input type="hidden"/> 
  <div class="formtitle">导航添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>导航名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="nav.name" ng-model="nav.name" placeholder="导航名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	  <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>导航链接</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="nav.url" ng-model="nav.url" placeholder="导航链接" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>父导航</td>
      <td>&nbsp;</td>
      <td class="okinput k1" >
		<select name="" ng-model="nav.pid" ng-options="nav.id as nav.space+(nav.position==1?'顶部 - ':'底部 - ')+nav.name for nav in navs">
			<option value="">一级导航</option>
		</select>
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>所属位置</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:none!important;">
		<input type="radio" ng-model="nav.position" value="1" /> 顶部
		<input type="radio" ng-model="nav.position" value="2" /> 尾部
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>排序</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="nav.sort" ng-model="nav.sort" placeholder="排序" /></td>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="isEdit" value="保存" ng-click="addContent();"><input type="button" id="submitform" class="buttons button2" ng-show="isEdit" value="保存" ng-click="modifyContent();"></td>
    </tr>
  </tbody>
	</table>
	

</div>

