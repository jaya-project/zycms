<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>zycms安装文件</title>
	<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>
<body>
<?php
	if (file_exists('./install_lock')) {
		header('location: /');
	}
	//判断服务器
	$web_server = $_SERVER['SERVER_SOFTWARE'];
	$env = array();
	if (stripos($web_server, 'apache') !== false) {
		$env['web_server'] = 'apache';
	}
	
	if (stripos($web_server, 'BWS') !== false) {
		$env['web_server'] = '百度WEB服务器';
	}

    $apache_modules = apache_get_modules();    

    if (isset($_GET['act']) && $_GET['act'] == 'connect_database') {
        $conn = mysqli_connect($_GET['host'].':'.$_GET['port'], $_GET['username'], $_GET['password']);
        if (!$conn) {
            echo 'error database setting';
            die;
        } else {
            mysqli_select_db($conn, $_GET['name']) or die('incorrect database name');
            set_config($_GET);
            echo '正在还原数据库...', '<br />';
            restore_database($conn);
            echo '还原成功...', '<br />';
            echo '安装成功', '<br />';
            echo '<a href="/">前台</a>', '<br />';
            echo '<a href="/admin">后台</a>', '<br />';
            touch('./install_lock');
            die;
        }
    }

    function set_config($info) {
        $str = file_get_contents('../application/config/database.php');
        $str = preg_replace("/'hostname'\s+=>\s+'[^']+'/", "'hostname' => '".$info['host']."'", $str);
        $str = preg_replace("/'username'\s+=>\s+'[^']+'/", "'username' => '".$info['username']."'", $str);
        $str = preg_replace("/'password'\s+=>\s+'[^']+'/", "'password' => '".$info['password']."'", $str);
        $str = preg_replace("/'database'\s+=>\s+'[^']+'/", "'database' => '".$info['name']."'", $str);
        $str = preg_replace("/'port'\s+=>\s+'[^']+'/", "'port' => '".$info['port']."'", $str);
        file_put_contents('../application/config/database.php', $str);
    }

    function restore_database($conn) {
        $str = file_get_contents('./zycms.sql');
        $sqls = explode(';', $str);
        foreach ($sqls as $sql) {
            mysqli_query($conn, $sql);
        }
    }
?>
    <h1>安装环境检测</h1>
    <h2>服务器: <?php echo apache_get_version(); ?></h2>
	<div id="step1">
        <table>
            <tr>
                <th>安装所需环境</th>
                <th>是否支持</th>
            </tr>
            <tr>
                <td>php版本 > 5.3</td>
                <td>
                    <?php if (version_compare('5.3', PHP_VERSION) <= 0) : ?>
                        <img src="assets/images/sign-check-icon.png" width="18" />
                    <?php else: ?>
                        <img src="assets/images/sign-error-icon.png" width="18" />
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>php短标记是否开启</td>
                <td>
                    <?php if (ini_get('short_open_tag')) : ?>
                        <img src="assets/images/sign-check-icon.png" width="18" />
                    <?php else: ?>
                        <img src="assets/images/sign-error-icon.png" width="18" />
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>curl扩展是否开启</td>
                <td>
                    <?php if (extension_loaded('curl')) : ?>
                        <img src="assets/images/sign-check-icon.png" width="18" />
                    <?php else: ?>
                        <img src="assets/images/sign-error-icon.png" width="18" />
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>gd库扩展是否开启</td>
                <td>
                    <?php if (extension_loaded('gd')) : ?>
                        <img src="assets/images/sign-check-icon.png" width="18" />
                    <?php else: ?>
                        <img src="assets/images/sign-error-icon.png" width="18" />
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>mysqli扩展是否开启</td>
                <td>
                    <?php if (extension_loaded('mysqli')) : ?>
                        <img src="assets/images/sign-check-icon.png" width="18" />
                    <?php else: ?>
                        <img src="assets/images/sign-error-icon.png" width="18" />
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>rewriter模块是否开启(如果主机不是apache, 则忽略此项检测)</td>
                <td>
                    <?php if (in_array('mod_rewrite', $apache_modules)) : ?>
                        <img src="assets/images/sign-check-icon.png" width="18" />
                    <?php else: ?>
                        <img src="assets/images/sign-error-icon.png" width="18" />
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        
        <button onclick="$('#step1').hide(); $('#step2').show();" class="btn">下一步</button>
	</div>
	
	<div id="step2">
        <form action="?">
            <p>主机: <input type="text" placeholder="主机名" name="host" required="required" value="localhost" /></p>
            <p>账号: <input type="text" placeholder="账号" name="username" required="required" value="root"  /></p>
            <p>密码: <input type="text" placeholder="密码" name="password" required="required" value="123456"  /></p>
            <p>库名称: <input type="text" placeholder="库名称" name="name" required="required"  /></p>
            <p>端口号: <input type="text" placeholder="端口号" name="port" value="3306" required="required"  /></p>
        
            <input type="hidden" name="act" value="connect_database">
            <button onclick="$('#step1').show(); $('#step2').hide();">上一步</button>
            <input type="submit" value="下一步" />
        </form>
        
	</div>

    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/common.js"></script>
</body>
</html>
