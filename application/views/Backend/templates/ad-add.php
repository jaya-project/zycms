

<div class="commonform" id="saveAd">
<input type="hidden"/> 
  <div class="formtitle">广告添加</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>广告名称</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="ad.name" ng-model="ad.name" placeholder="广告名称" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>所属广告位</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<select name="" id="" ng-model="ad.pid" ng-options="adPosition.id as adPosition.name for adPosition in adPositions" placeholder="所属广告位">
			<option value="">请选择广告位</option>
		</select>
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	
	 <tr id="thumb">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>广告图</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="width:330px;">
		<input type="text" ng-model="ad.thumb" placeholder="广告图" readonly />
		
		
		<button class="button" ngf-select ng-model="files">上传</button>
	  </td>
      <td><div id="process" style="width:200px; height:12px; border:1px solid #ccc; padding:0; position:relative; display:none;"><span style="width:10%; height:100%; display:inline-block; background:green; margin:0; position:absolute; "></span></div>
		
		<img ng-show="ad.thumb" ng-model="ad.thumb" id="fullPath" src="{{ad.thumb}}"  alt="" width="80" /></td>
    </tr>
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>排序</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="ad.sort" ng-model="ad.sort" placeholder="排序" /></td>
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
