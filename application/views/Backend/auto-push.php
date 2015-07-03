

<div class="commonform" ng-controller="autoPushCtrl">
<input type="hidden"/> 
  <div class="formtitle">百度主动推送</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>网站绝对链接</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><textarea type="text" name="push.links" ng-model="push.links" placeholder="网站绝对链接(一行一个链接)" cols="60" rows="5"></textarea></td>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2"  value="推送到百度" ng-click="autoPush();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
