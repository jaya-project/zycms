

<div class="commonform" ng-controller="systemSetCtrl">
<input type="hidden"/> 
  <div class="formtitle">系统设置</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>
  
  <table border="0" cellpadding="1" cellspacing="1" style="width:auto; margin-left:120px;">
    <tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>网站标题</td>
      <td>&nbsp;</td>
      <td class="okinput k1"><input type="text" name="system.title" ng-model="system.title" placeholder="网站标题" /></td>
      <td>&nbsp;</td>
    </tr>
	
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>网站关键词</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="网站关键词" ng-model="system.keywords"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	 
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>网站描述</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea type="text"  ng-model="system.description" placeholder="网站描述" cols="40" rows="3"></textarea> 
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SMTP服务器</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="SMTP服务器" ng-model="system.smtp_server"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SMTP服务器端口号</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="SMTP服务器端口号" ng-model="system.smtp_port"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SMTP用户邮箱</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="SMTP用户邮箱" ng-model="system.smtp_email"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SMTP用户账号</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="text" placeholder="SMTP用户账号" ng-model="system.smtp_user"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>SMTP用户密码</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<input type="password" placeholder="SMTP用户密码" ng-model="system.smtp_password"  />
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>网站版权信息</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea type="text" placeholder="网站版权信息" ng-model="system.copyright"  cols="40" rows="3"></textarea>
	  </td>
      <td>&nbsp;</td>
    </tr>
	
	<tr>
      <td>&nbsp;</td>
      <td align="right"><span class="red"></span>底部统计或商桥代码</td>
      <td>&nbsp;</td>
      <td class="okinput k1">
		<textarea type="text" placeholder="底部统计代码" ng-model="system.code"  cols="50" rows="5"></textarea>
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
      <td align="right"><input type="button" id="submitform" class="buttons button2"  value="保存" ng-click="saveContent();"></td>
    </tr>
  </tbody>
	</table>
	

</div>
