

<div class="commonform" ng-controller="icoCtrl">
<input type="hidden"/> 
  <div class="formtitle">网页图标管理</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <ul style="line-height:24px; padding-left:30px;">
  	<li>什么是网页图标?</li>
  	<li><img src="/assets/Admin/images/ico.png" /></li>
  </ul>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    
	
	 <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>栏目封面</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" ng-model="icoPath" placeholder="栏目封面" readonly />
		
		
	  </td>
	  <td>
	  <button class="button" ngf-select ng-model="files">上传</button>
	  </td>
      <td><div id="process" style="width:200px; height:12px; border:1px solid #ccc; padding:0; position:relative; display:none;"><span style="width:10%; height:100%; display:inline-block; background:green; margin:0; position:absolute; "></span></div>
		
		<img ng-show="icoPath" ng-model="icoPath" id="fullPath" src="{{icoPath}}"  alt="" width="32" /></td>
    </tr>
   
  </table>
  
  
	

</div>
