

<div class="commonform" id="showSendMessage">
<input type="hidden"/> 
  <div class="formtitle">群发消息</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red">*</span>消息标题</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="message.title" ng-model="message.title" placeholder="消息标题" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>消息内容</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><textarea type="text" name="message.content" ng-model="message.content" rows="5" cols="50" placeholder="消息内容" /></textarea>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2"  value="发送" ng-click="sendMessage();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
