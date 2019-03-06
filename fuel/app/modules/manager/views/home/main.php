<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>昱建后台管理系统</title>
    <link rel="shortcut icon" href="<?php echo Asset::get_file('Logo_40.png','img'); ?>" type="image/x-icon">
    <!-- layui.css -->
    <link href="<?php echo Asset::get_file('layui-v1.0.9/css/layui.css','plugin'); ?>" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="<?php echo Asset::get_file('font-awesome/css/font-awesome.min.css','plugin'); ?>" rel="stylesheet" />
    <!-- animate.css -->
    <link href="<?php echo Asset::get_file('managers/animate.min.css','css'); ?>" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="<?php echo Asset::get_file('managers/main.css','css'); ?>" rel="stylesheet" />
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <!--顶部-->
        <div class="layui-header">
            <div class="ht-console">
                <div class="ht-user">
                    <img src="<?php echo Asset::get_file('Logo_40.png','img'); ?>" />
                    <a class="ht-user-name">超级管理员</a>
                </div>
            </div>
            <span class="sys-title" style="font-family: 华文隶书">YuJian</span>&nbsp;&nbsp;<span class="sys-title">后台管理系统</span>
            <ul class="ht-nav">
                <li class="ht-nav-item">
                    <a target="_blank" href="<?php echo Uri::create('home/index');?>">前台入口</a>
                </li>
                <li class="ht-nav-item">
                    <a href="javascript:;" id="individuation"><i class="fa fa-tasks fa-fw" style="padding-right:5px;"></i>个性化</a>
                </li>
                <li class="ht-nav-item">
                    <a href="javascript:;" id="logoutId"><i class="fa fa-power-off fa-fw"></i>注销</a>
                </li>
            </ul>
        </div>
        <!--侧边导航-->
        <div class="layui-side">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="leftnav">
                    <li class="layui-nav-item layui-this">
                        <a href="javascript:;"><i class="fa fa-home"></i>首页</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="fa fa-file-text"></i>文章管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" data-url="<?php echo Uri::create('manager/article'); ?>" data-id="1">文章列表</a></dd>
                            <dd><a href="javascript:;" data-url="<?php echo Uri::create('manager/note'); ?>" data-id="3">小随记</a></dd>
                            <dd><a href="javascript:;" data-url="<?php echo Uri::create('manager/message'); ?>" data-id="4">留言管理</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <!--收起导航-->
        <div class="layui-side-hide layui-bg-cyan">
            <i class="fa fa-long-arrow-left fa-fw"></i>收起导航
        </div>
        <!--主体内容-->
        <div class="layui-body">
            <div style="margin:0;position:absolute;top:4px;bottom:0px;width:100%;" class="layui-tab layui-tab-brief" lay-filter="tab" lay-allowclose="true">
                <ul class="layui-tab-title">
                    <li lay-id="0" class="layui-this">首页</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <p style="padding: 10px 15px; margin-bottom: 20px; margin-top: 10px; border:1px solid #ddd;display:inline-block;">
                            当前登陆
                            <span style="padding-left:1em;">IP：<?=$real_ip;?></span>
                            <span style="padding-left:1em;">时间：<?=$datetime;?></span>
                        </p>
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>统计信息</legend>
                            <div class="layui-field-box">
                                <div style="display: inline-block; width: 100%;">
                                    <div class="ht-box layui-bg-green">
                                        <p><?=$comment_count;?></p>
                                        <p>总留言数</p>
                                    </div>
                                    <div class="ht-box layui-bg-orange">
                                        <p><?=$article_count;?></p>
                                        <p>文章总数</p>
                                    </div>
                                    <div class="ht-box layui-bg-black">
                                        <p><?=$note_count;?></p>
                                        <p>笔记总数</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <!--底部信息-->
        <div class="layui-footer">
            <p style="line-height:44px;text-align:center;">YuJian后台管理系统</p>
        </div>
        <!--个性化设置-->
        <div class="individuation animated flipOutY layui-hide">
            <ul>
                <li><i class="fa fa-cog" style="padding-right:5px"></i>个性化</li>
            </ul>
            <div class="explain">
                <small>从这里进行系统设置和主题预览</small>
            </div>
            <div class="setting-title">设置</div>
            <div class="setting-item layui-form">
                <span>侧边导航</span>
                <input type="checkbox" lay-skin="switch" lay-filter="sidenav" lay-text="ON|OFF" checked>
            </div>
            <div class="setting-title">主题</div>
            <div class="setting-item skin skin-default" data-skin="skin-default">
                <span>低调优雅</span>
            </div>
            <div class="setting-item skin skin-deepblue" data-skin="skin-deepblue">
                <span>蓝色梦幻</span>
            </div>
            <div class="setting-item skin skin-pink" data-skin="skin-pink">
                <span>姹紫嫣红</span>
            </div>
            <div class="setting-item skin skin-green" data-skin="skin-green">
                <span>一碧千里</span>
            </div>
        </div>
    </div>
    <!-- layui.js -->
    <script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
    <!-- layui规范化用法 -->
    <script type="text/javascript">
        var CHECK_URL = "<?php echo Uri::create('manager/checklogin'); ?>";
        var LOGIN_URL = "<?php echo Uri::create('manager/index'); ?>";
        var LOGOUT_URL = "<?php echo Uri::create('manager/logout'); ?>";
        layui.config({
            base: '<?php echo \Fuel\Core\Uri::base();?>assets/js/managers/'
        }).use('main');
    </script>
</body>
</html>