

<div class="commonform" id="saveHotSearch" style="position:relative;">
<input type="hidden"/> 
  <div class="formtitle">添加文章关键词</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>关键词</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="keyword.keywords" ng-change="preview()" ng-model="keyword.keyword" placeholder="关键词" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>关键词地址</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="keyword.url" ng-change="preview()" ng-model="keyword.url" placeholder="关键词地址" /></td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>是否新窗口打开</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:none!important;"><input type="radio" ng-change="preview()" name="keyword.target" ng-model="keyword.target" value="1" /> 是 <input type="radio" name="keyword.target" ng-change="preview()" ng-model="keyword.target" value="0" /> 否</td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>字体大小</td>
      <td>&nbsp;</td>
      <td class="okinput k1" ><input type="number" value="12" ng-change="preview()" name="keyword.style.fontsize" ng-model="keyword.style.fontsize" max="100" min="12" /> {{keyword.style.fontsize + 'px'}}</td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>字体颜色</td>
      <td>&nbsp;</td>
      <td class="okinput k1"  style="background:none!important;"><input type="color" ng-click="preview()" name="keyword.style.color" ng-model="keyword.style.color" /> </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>是否加粗</td>
      <td>&nbsp;</td>
      <td class="okinput k1"  style="background:none!important;"><input type="radio" ng-change="preview()" name="keyword.style.fontweight" ng-model="keyword.style.fontweight" value="1" /> 是 <input type="radio" name="keyword.style.fontweight" ng-change="preview()" ng-model="keyword.style.fontweight" value="0" /> 否</td>
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
	

	<div id="fontPreview" style="position:absolute; top:10px; left:50%;">{{keyword.keyword}}</div>
	
</div>
