<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/27
 * Time: 0:24
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>昱建个人博客</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo Asset::get_file('home/title_logo.png', 'img'); ?>"/>
    <!-- 本页样式表 -->
    <link href="<?php echo Asset::get_file('home/timeline.css','css'); ?>" rel="stylesheet" />
</head>
<style>
    .layui-flow-more {
        display: none;
    }

</style>
<body>
<!--Layui-->
<link href="<?php echo Asset::get_file('layui/css/layui.css','plugin'); ?>" rel="stylesheet" />
<!--font-awesome-->
<link href="<?php echo Asset::get_file('canvas/style/css/font-awesome.min.css','plugin'); ?>" rel="stylesheet" />
<!-- 动画 -->
<link href="<?php echo Asset::get_file('canvas/style/css/animate.min.css','plugin'); ?>" rel="stylesheet" />
<!--全局样式表-->
<link href="<?php echo Asset::get_file('home/global.css','css'); ?>" rel="stylesheet" />
<!-- 离子特效 -->
<script src="<?php echo Asset::get_file('canvas/style/js/canvas-nest.js','plugin'); ?>"></script>
<!-- 动画 -->
<link rel="stylesheet" href="<?php echo Asset::get_file('canvas/style/css/csshake.min.css','plugin'); ?>">
<!-- layui.js -->
<script src="<?php echo Asset::get_file('layui/layui.js','plugin'); ?>"></script>
<!-- 全局脚本 -->
<script src="<?php echo Asset::get_file('home/global.js','js'); ?>"></script>
<input type="hidden" id="visitor" value="">
<!-- 导航 -->
<nav class="blog-nav layui-header">
    <div class="blog-container">
        <a class="blog-logo" href="<?php echo Uri::create('index'); ?>">
            <img alt="" src="<?php echo Asset::get_file('home/logo.png', 'img'); ?>"/>
        </a>
        <!-- 导航菜单 -->
        <ul class="layui-nav" lay-filter="nav" id="title-nav">
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('index'); ?>" onclick="clickTitle(this)"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('article'); ?>" onclick="clickTitle(this)"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('timeline'); ?>" onclick="clickTitle(this)"><i class="fa fa-hourglass-half fa-fw"></i>&nbsp;时光轴</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('about'); ?>" onclick="clickTitle(this)"><i class="fa fa-info fa-fw"></i>&nbsp;留言墙</a>
            </li>
        </ul>
        <!-- 手机和平板的导航开关 -->
        <a class="blog-navicon" href="javascript:;">
            <i class="fa fa-navicon"></i>
        </a>
    </div>
</nav>
<script>
    layui.use(['element'],function(){
        var element=layui.element;


    });

</script>    <!-- 主体（一般只改变这里的内容） -->
<div class="blog-body">
    <div class="blog-container">
        <div class="blog-main">
            <div class="child-nav shadow">
                <span class="child-nav-btn child-nav-btn-this">点点滴滴</span>
            </div>
            <div class="timeline-box shadow">
                <div class="timeline-main">
                    <h1><i class="fa fa-clock-o"></i>点点滴滴<span> —— 记录网站的大事和小事</span></h1>
                    <div class="timeline-line"></div>
                    <?php $year = "";?>
                    <?php $month = "";?>
                    <?php foreach($notes as $key => $note):?>
                        <?php
                            $temp_year = date('Y', $note->display_at);
                            $temp_month = date('m', $note->display_at);
                            if ( $year != $temp_year ){
                                $year = $temp_year;
                                echo html_entity_decode("<div class=\"timeline-year\"><h2><a class=\"yearToggle\" href=\"javascript:;\">{$year}</a><i class=\"fa fa-caret-down fa-fw\"></i></h2></div>");
                            }
                            if ($month != $temp_month){
                                $month = $temp_month;
                                echo html_entity_decode("<div class=\"timeline-month\"><h3 class=\" animated fadeInLeft\"><a class=\"monthToggle\" href=\"javascript:;\">{$month}月</a><i class=\"fa fa-caret-down fa-fw\"></i></h3></div>");
                            }
                            echo html_entity_decode("<div class=\" \"><div class=\"h4  animated fadeInLeft\" style=\"position: relative;margin-top: 10px;\"><p class=\"date\">".date('m月d日 H:i', $note->display_at)."</p></div><p class=\"dot-circle animated \"><i class=\"fa fa-dot-circle-o\"></i></p><div class=\"content animated fadeInRight\">{$note->content}</div><div class=\"clear\"></div></div>");
                        ?>
                    <?php endforeach;?>
                    <h1 name="endName" style="padding-top:4px;padding-bottom:2px;margin-top:40px;"><i class="fa fa-hourglass-end"></i>THE END</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!--侧边导航-->
<ul class="layui-nav layui-nav-tree layui-nav-side blog-nav-left layui-hide" lay-filter="nav">
    <li class="layui-nav-item layui-this">
        <a href="<?php echo Uri::create('index'); ?>"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
    </li>
    <li class="layui-nav-item">
        <a href="<?php echo Uri::create('article'); ?>"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
    </li>
    <li class="layui-nav-item">
        <a href="<?php echo Uri::create('timeline'); ?>"><i class="fa fa-road fa-fw"></i>&nbsp;点点滴滴</a>
    </li>
    <li class="layui-nav-item">
        <a href="<?php echo Uri::create('about'); ?>"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
    </li>
</ul>
<!--遮罩-->
<div class="blog-mask animated layui-hide"></div></body>
<!-- 本页脚本 -->
<script type="text/javascript">
    layui.use('jquery', function () {
        var $ = layui.jquery;

        $(function () {
            $('.monthToggle').click(function () {
                $(this).parent('h3').siblings('ul').slideToggle('slow');
                $(this).siblings('i').toggleClass('fa-caret-down fa-caret-right');
            });
            $('.yearToggle').click(function () {
                $(this).parent('h2').siblings('.timeline-month').slideToggle('slow');
                $(this).siblings('i').toggleClass('fa-caret-down fa-caret-right');
            });
        });
    });
</script>
<script src="<?php echo Asset::get_file('canvas/style/js/jquery.min.js','plugin'); ?>"></script>
</html>
