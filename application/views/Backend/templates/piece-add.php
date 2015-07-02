

<div class="commonform" id="savePiece">
<input type="hidden"/> 
  <div class="formtitle">碎片添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>碎片名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="piece.name" ng-model="piece.name" placeholder="碎片名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>碎片内容</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea ck-editor ng-model="piece.content"></textarea>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="isEdit" value="保存" ng-click="addContent();"><input type="button" id="submitform" class="buttons button2" ng-show="isEdit" value="保存" ng-click="modifyContent();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
