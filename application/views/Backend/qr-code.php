
<div class="result" id="qrCodeArea" ng-controller="qrcodeCtrl">
  <div class="formtitle">二维码生成器</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>


  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
             <thead>
              <tr nowrap="nowrap">
                <td nowrap="nowrap" width="20%">序号</td>
                <td nowrap="nowrap" width="10%">二维码文件名</td>
				<td nowrap="nowrap" width="10%">内容</td>
                <td nowrap="nowrap" width="10%">生成时间</td>
                <td nowrap="nowrap" width="10%">操作</td>
                </tr>

              </thead>
            <tbody id="ResultTbody">
			<tr ng-repeat="d in data">
			<td ng-bind="$index+1"></td>
              <td ng-bind="d.filename"></td>
			  <td ng-bind="d.text"></td>
              <td ng-bind="d.create_time"></td>
              <td><a ng-click="deleteQrcode(d.filename)" href="javascript:void(0)">删除</a> <a ng-click="showQrCode(d.filename)" href="javascript:void(0)">查看</a> </td>
            </tr>
  </tbody>
            <tfoot id="ResultTfoot" style="">
              <tr>
                <td colspan="8" align="center" id="pagebar">
					<input type="text" ng-model="qrCode" placeholder="请输入内容" />
					<button ng-click="buildQrcode()">生成</button>
                </td>
				
              </tr>
            </tfoot>
          </table></td>
      </tr>
    </tbody></table>
    <div style="height:10px;"></div>
	
	
  </div>
</div>
<div class="loading2 hidden" id="loading" ng-style="loading"></div>