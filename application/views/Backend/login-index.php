<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>朝阳cms 登录</title>
	<link rel="stylesheet" href="<?=base_url('assets/Admin/css/reset.css')?>" type="text/css" />
	<link rel="stylesheet" href="<?=base_url('assets/Admin/css/style.css')?>" type="text/css" />
	<script type="text/javascript" src="<?=base_url('assets/Admin/js/jquery-1.10.2.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/Admin/js/jquery.noty.packaged.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/Admin/js/common.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/Admin/js/validate.js')?>"></script>
	<style type="text/css">
		#main { width:500px; position:fixed; left:50%; margin-left:-250px; background:#fff; box-shadow:0 0 10px #000; padding:30px; top:30%; }
	</style>
</head>
<body>
	
	<!--[if IE]>
		<div style="font-size:20px; width:400px; position:fixed; left:50%; margin-left:-200px; margin-top:200px;">
			该后台系统不支持IE内核的浏览器, 如果您使用360浏览器, 请切换到极速模式
			请点此下载<a href="http://download.firefox.com.cn/releases/stub/official/zh-CN/Firefox-latest.exe">Firefox 浏览器</a> 或 <a href="http://www.google.cn/chrome/">Chrome 浏览器</a>
		</div>
		
		<style type="text/css">
			#main { display:none; }
			div a {font-size:14px; font-weight:bold; color:#f00;}
		</style>
	<![endif]-->

	<div id="main">
		<h1 class="label-input bold margin-bottom-10 font-size-20">朝阳CMS后台登录</h1>
		<form action="<?=site_url('login/validate')?>" method="post" name="loginForm" >
			<p class=" margin-bottom-10">
				<label for="username" class="label-input margin-right-10">用户名: </label>
				<input type="text" name="username" class="input"  placeholder="用户名" autocomplete="off" />
			</p>
			
			<p class="margin-bottom-10">
				<label for="password" class="label-input margin-right-10">密　码: </label>
				<input type="password" name="password" class="input"  placeholder="密码" autocomplete="off" />
			</p>
			
			<?php if ($error_flag): ?>
			<p class="margin-bottom-10">
				<label for="validate" class="label-input margin-right-10">验证码: </label>
				<input type="text" name="captcha" class="input" style="width:100px;" placeholder="验证码" autocomplete="off" /> <img src="<?=site_url('login/get_code/?_=123456');?>" onclick="this.src+='';" style="cursor:pointer;" title="看不清?点击换下一张" valign="middle" />
			</p>
			<? endif ?>
			
			<p class="margin-bottom-10">
				<label for="submit" class="label-input margin-right-10"></label>
				<input type="submit" class="button" value="登录" />
			</p>
		</form>
	</div>
	
	<script type="text/javascript">
		var validator = new FormValidator('loginForm', [{
			name: 'username',
			display: '用户名不能为空',
			rules: 'required'
		}, {
			name: 'password',
			display: '密码不能为空',
			rules: 'required'
		}], function(errors, event) {
			if (errors.length > 0) {
				generate({'text':'用户名和密码不能为空', 'type':'error'});
				
			}
		});
	</script>
</body>
</html>
