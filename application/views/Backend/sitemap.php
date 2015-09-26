
<div class="result" ng-controller="sitemapCtrl">
  <div class="formtitle">网站地图生成</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>


  <div class="content">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="resultborder">
      <tbody><tr>
        <td><table width="100%" class="contenttable" border="0" cellpadding="1" cellspacing="1">
            
            <tfoot id="ResultTfoot" style="">
              <tr>
                <td colspan="8" align="center" id="pagebar">
					<button ng-click="buildMap()">一键生成</button>
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