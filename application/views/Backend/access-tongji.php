<style type="text/css">
	#tongjiNoticeBox {
		position: absolute;
		background: #f00;
		width: 100%;
		top: -14px;
		opacity: 0.8;
		color: #fff;
		text-align: center;
		height: 40px;
		line-height: 40px;
	}
</style>
<script type="text/javascript" src="<?=base_url('assets/Admin/js/echarts-all.js')?>"></script>
<div class="commonform" ng-controller="accessCtrl" style="position:relative;">
  <div id="tongjiNoticeBox" ng-if="needClear">
  网站的访问统计数据量过大, 需要清理. <a ng-click="clear()">点击清理</a>
  </div>
  <div class="formtitle">访问统计</div>
  <div class="formtitleline1"></div>
  <div class="formtitleline2"></div>
  <div style="height:20px;"></div>

  
  <div id="main" style="height:300px; width:70%;">暂无任何访问数据</div>
  
  <hr />
  
  <div id="referer" style="height:300px; width:70%;">暂无任何访问数据</div>
  
  <hr />
	

	<div id="pv" style="height:300px; width:70%;">暂无任何访问数据</div>
	
	<hr />
	

	<div id="uv" style="height:300px; width:70%;">暂无任何访问数据</div>
</div>
