

<div class="commonform" ng-controller="searchEngineCtrl">
<input type="hidden"/> 
  <div class="formtitle">提交到搜索引擎</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
  
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>搜索引擎选择</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:None!important;">
		<input type="checkbox" ng-model="searchengine.baidu" ng-true-value="baidu" /> 百度
		<input type="checkbox" ng-model="searchengine.google" ng-true-value="google" /> 谷歌
		<input type="checkbox" ng-model="searchengine.so" ng-true-value="so" /> 360搜索
		<input type="checkbox" ng-model="searchengine.sogou" ng-true-value="sogou" /> 搜狗
		<input type="checkbox" ng-model="searchengine.soso" ng-true-value="soso" /> 搜搜
		<input type="checkbox" ng-model="searchengine.bing" ng-true-value="bing" /> 必应
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
      <td align="right"><input type="button" id="submitform" class="buttons button2" ng-hide="columnId" value="提交" ng-click="saveContent();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
