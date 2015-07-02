

<div class="commonform" ng-controller="waterImageCtrl">
<input type="hidden"/> 
  <div class="formtitle">水印设置</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
  
  <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>是否开启</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:none!important;">
		<input type="radio" value="1" ng-model="water.is_open" /> 开启
		<input type="radio" value="0" ng-model="water.is_open" /> 关闭
	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印类型</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:none!important;">
		<input type="radio" value="0" ng-model="water.type" /> 文字
		<input type="radio" value="1" ng-model="water.type" /> 图片
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	 
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印位置</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:none!important;">
		<p>
		<input type="radio" value="top_left" ng-model="water.position" /> 左上
		<input type="radio" value="top_center" ng-model="water.position" /> 中上
		<input type="radio" value="top_right" ng-model="water.position" /> 右上
		</p>
		<p>
			<input type="radio" value="middle_left" ng-model="water.position" /> 左中
		<input type="radio" value="middle_center" ng-model="water.position" /> 居中
		<input type="radio" value="middle_right" ng-model="water.position" /> 右中
		</p>
		<p>
			<input type="radio" value="bottom_left" ng-model="water.position" /> 左下
		<input type="radio" value="bottom_center" ng-model="water.position" /> 中下
		<input type="radio" value="bottom_right" ng-model="water.position" /> 右下
		</p>
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr ng-if="water.type==0">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印文字</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="水印文字" ng-model="water.text"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr ng-if="water.type==0">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印字体大小</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="水印文字" ng-model="water.font_size"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr ng-if="water.type==0">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印字体颜色</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="color" placeholder="水印文字" ng-model="water.color"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr ng-if="water.type==1">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印透明度</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="background:none!important;">
		<input type="range" placeholder="水印文字" ng-change="setThumbOpacity(water.opacity)" ng-model="water.opacity" min="1" max="100"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr id="thumb" ng-hide="water.type==0">
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>水印图</td>
      <td>&nbsp;</td>
      <td class="okinput k1" style="width:330px;">
		<input type="text" ng-model="water.thumb" placeholder="栏目封面" readonly />
		
		
		<button class="button" ngf-select ng-model="files">上传</button>
	  </td>
      <td><div id="process" style="width:200px; height:12px; border:1px solid #ccc; padding:0; position:relative; display:none;"><span style="width:10%; height:100%; display:inline-block; background:green; margin:0; position:absolute; "></span></div>
		
		<img ng-show="water.thumb" ng-model="water.thumb" style="opacity:{{water.opacity/100}}" id="fullPath" src="{{water.thumb}}"  alt="" width="80" /></td>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2"  value="保存" ng-click="saveContent();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
