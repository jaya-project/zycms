

<div class="commonform" id="saveFlink">
<input type="hidden"/> 
  <div class="formtitle">添加友情链接</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>友情链接名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="flink.name" ng-model="flink.name" placeholder="友情链接名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>友情链接地址</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="flink.url" ng-model="flink.url" placeholder="友情链接名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	 <tr id="thumb">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>LOGO</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="width:330px;">
		<input type="text" ng-model="flink.thumb" placeholder="LOGO" readonly />
		
		
		<button class="button" ngf-select ng-model="files">上传</button>
	  </td>
      <td><div id="process" style="width:200px; height:12px; border:1px solid #ccc; padding:0; position:relative; display:none;"><span style="width:10%; height:100%; display:inline-block; background:green; margin:0; position:absolute; "></span></div>
		
		<img ng-show="flink.thumb" ng-model="flink.thumb" id="fullPath" src="{{flink.thumb}}"  alt="" width="80" /></td>
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
