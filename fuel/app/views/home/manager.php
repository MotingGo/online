<?php
/**
 * Created by PhpStorm.
 * User: moting
 * Date: 2017/6/12
 * Time: 15:51
 */?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="utf-8" />
    <title>昱建后台管理系统</title>
    <link rel="shortcut icon" href="<?php echo Asset::get_file('Logo_40.png','img'); ?>" type="image/x-icon">
    <!-- layui.css -->
    <link href="<?php echo Asset::get_file('layui/css/layui.css','plugin'); ?>" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="<?php echo Asset::get_file('managers/index.css','css'); ?>" rel="stylesheet" />
    <style>
        body {
            background-image: url("<?php echo Asset::get_file('background_default.jpg','img'); ?>");
        }
        .custom-title{
            font-size: 84px;
            font-family: 华文隶书;
        }
        .custom-title-small{
            font-size: 30px;
            font-family: 华文隶书;
        }
    </style>
</head>
<body>
<div class="mask"></div>
<div class="main">
    <h1><span class="custom-title">Y</span><span class="custom-title-small">u</span><span class="custom-title">J</span><span class="custom-title-small">ian</span></h1>
    <p id="time"></p>
    <div class="enter">
        Please&nbsp;&nbsp;Click&nbsp;&nbsp;Enter
    </div>
</div>
<!-- layui.js -->
<script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
<!-- layui规范化用法 -->
<script type="text/javascript">
    var LOGIN_URL = "<?php echo Uri::create('manager/index'); ?>";
    var MANAGER_URL = "<?php echo Uri::create('manager/main'); ?>";
    var CHECK_URL = "<?php echo Uri::create('login'); ?>";
    layui.config({
        base: '<?php echo \Fuel\Core\Uri::base();?>assets/js/managers/'
    }).use('index');
</script>
</body>
</html>
