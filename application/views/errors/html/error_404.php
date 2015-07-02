<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<link rel="stylesheet" type="text/css" href="/assets/static/css/404.css">
<script type="text/javascript" src="/assets/static/jquery-1.10.2.min.js"></script>
<script>
function changetoen(){
	document.getElementById("main").style.display='block';
	$(".zh").hide();
}
function changetozh(){
	$(".zh").show();
	document.getElementById("main").style.display='none';
}
</script>
<style type="text/css">

</style>
</head>
<body>
	
  <!-- zh -->
    <div id="main" class="zh">
    <header id="header">
      <h1><span class="icon">!</span>404<span class="sub">页面未找到</span></h1>
    </header>
    <div id="content">
      <h2><br>您所请求的页面无法找到</h2>
      <p>服务器无法正常提供信息。<br>
      目标页面可能已经被更改、删除或移到其他位置，或您所输入页面地址错误。</p>
    
    </div>
    <div id="footer">
      <ul>
        <li><a href="/welcome/index">主页</a></li>
      </ul>
    </div>
  </div>
</body>
</html>