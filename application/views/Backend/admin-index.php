<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base target="content" />
<title>朝阳CMS管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?=base_url('assets/Admin/js/jquery-1.10.2.min.js')?>" ></script>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache,no-store, must-revalidate">
<meta http-equiv="Expires" content="0">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/Admin/css/common.css')?>"/>
<style type="text/css" media="all">
* {
	margin: 0;
	padding: 0;
	font-size: 100%;
}
html, body {
	height: 100%;
}
html {
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	padding: 0px;
	margin: 0px;
	overflow: hidden;
}
body {
	color: #333;
	font: 12px/1.5 verdana;
	background-color: #EEE;
}
.models {
	cursor: pointer;
}
li {
	list-style: none;
	list-style-type: none;
}
.header {
	z-index: 2;
	position: relative;
	background-color: #393836;
	height: 58px;
	min-width: 650px;
}
.blackBorder{ border:4px dashed #000000;}
.blueBorder{border:4px dashed #f00;}
.notice_panel{height:25px; width:500px;overflow:hidden; text-align:left;position:absolute; top:10px;}
.notice_wrapper{ width:500px; overflow:hidden;}
.notice_wrapper ul{ float:left;}
.notice_wrapper ul li{float:left; padding:0;}
</style>
</head>
<body>
	

<div class="topbar topbar_client">
  <!--<div class="left logoyoulink"></div>-->
  <div class="left logoyoulinktext">朝阳CMS</div>
  <div class="right inline" style="height:23px;margin:0 auto; margin-top:8px; margin-right:35px; position:relative; width:640px;">
    <div class="notice_panel">
              <div class="notice_wrapper" id="notice_bar"><ul id="notice_con"><li></li></ul></div>
     </div>
    <ul style="float:right;">
      <li><span class="homepage"><a href="<?=site_url('/')?>" title="首页">&nbsp;</a></span></li>
      <li><span class="back"><a href="<?=site_url('admin/logout')?>" target="_top" title="退出">&nbsp;</a></span></li>
    </ul>
  </div>
</div>
<div class="portalmain">
  <div style="height:100%;" class="portalmain_left" id="portalsidebar">
    <div class="leftmenubar_top" style="display:none"></div>
    <div class="leftmenubar client" style="-moz-user-select: none;" onselectstart="return false;">
      <ul>
      	
		<?php foreach($menus as $key=>$value) : ?>
			<?php if (in_array($value['title'], $own_menus)) : ?>
				<li><a href="#" class="models models_close"><?=$value['title']?></a>
				  <ul class="childrenmenu" style="display:none">
					<?php foreach($value['sub_menu'] as $k=>$v) : ?>
						<li><a href="<?=$k?>">- <?=$v?></a>
						  <div class="line"></div>
						</li>
					<?php endforeach ?>
				  </ul>
				</li>
			<?php endif ?>
		<?php endforeach ?>
       
        
      </ul>
    </div>
     <div onClick="return hidesidebar();" class="portalmain_switch"><div style="position:absolute;left:0px;top:50%; margin-top:-39px;" class="portalmain_switch_ctrl" id="portalmain_switch_ctrl"></div></div>
  </div>
  <div class="portalmain_right" id="rightbar" style="height:100%">
    <iframe class="content" frameborder="0" name="content" id="content" src="<?=site_url('admin/welcome')?>"></iframe>
  </div>
</div>
</body>
<script type="text/javascript">
function hidesidebar() {
	with ($('#portalsidebar')) {
		hd = (offset().left==0);
		css("left",hd?-200:0);
		$('#rightbar').css("left", hd?10:210);
		$('#portalmain_switch_ctrl').toggleClass("portalmain_switch_close", hd)
	}
}
var childrenmenus=$('.childrenmenu li>a');
var allmodels=$('.models');
$(function() {
	allmodels.click(function(e) {
		var ulstate = $(this).next('ul').is(":hidden");
		//$('.childrenmenu:not(:hidden)').hide();
		//$('.models_open').removeClass("models_open");
		$(this).toggleClass("models_open", ulstate).next('ul').toggle(
				ulstate);
		return false;
	});
	childrenmenus.click(function(e) {
		childrenmenus.filter(".actived").removeClass('actived');
		$(this).addClass("actived");
	});
	$('.childrenmenu').each(function(index, element) {
		if ($(this).children("li").length == 0) {
			$(this).parent().hide();
		}
	});
});

</script>
</html>
