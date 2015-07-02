

<div id="showFormContent" class="commonform">
<input type="hidden"/> 
  <div class="formtitle">表单内容</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
  
    <tr ng-repeat="field in fields">
      <td>&nbsp;</td>
      <td align="right" ng-bind="field.name"></td>
      <td>&nbsp;</td>
      <td class="okinput k1" ng-bind="field.value"></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
  </table>
  
  
	

</div>
