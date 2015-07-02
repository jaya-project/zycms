

<div class="commonform" id="saveHotSearch">
<input type="hidden"/> 
  <div class="formtitle">添加热门搜索</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>热搜关键词</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="hotsearch.keywords" ng-model="hotsearch.keywords" placeholder="热搜关键词" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>关键词地址</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="hotsearch.url" ng-model="hotsearch.url" placeholder="关键词地址" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>排序</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="hotsearch.sort" ng-model="hotsearch.sort" placeholder="排序" /></td>
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
