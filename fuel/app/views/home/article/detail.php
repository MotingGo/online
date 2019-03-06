<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $article->title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo Asset::get_file('home/logo.png', 'img'); ?>" type="image/x-icon">
    <!-- 比较好用的代码着色插件 -->
    <link href="<?php echo Asset::get_file('home/prettify.css','css'); ?>" rel="stylesheet" />
    <!-- 本页样式表 -->
    <link href="<?php echo Asset::get_file('home/article/detail.css','css'); ?>" rel="stylesheet" />
</head>
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
                <a href="<?php echo Uri::create('index'); ?>" onclick="clickTitle(this)">
                    <i class="fa fa-home fa-fw"></i>&nbsp;
                    网站首页</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('article'); ?>" onclick="clickTitle(this)">
                    <i class="fa fa-file-text fa-fw"></i>&nbsp;
                    文章专栏</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('timeline'); ?>" onclick="clickTitle(this)">
                    <i class="fa fa-hourglass-half fa-fw"></i>&nbsp;
                    时光轴
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('about'); ?>" onclick="clickTitle(this)">
                    <i class="fa fa-info fa-fw"></i>&nbsp;
                    留言墙
                </a>
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
        <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
            <a href="<?php echo Uri::create('index'); ?>" title="网站首页">网站首页</a>
            <!-- <a href="article.html" title="文章专栏">文章专栏</a> -->
            <a><cite>深入详解Java中的hashcode()与equals()方法</cite></a>
        </blockquote>
        <div class="blog-main">
            <div class="blog-main-left animated fadeInLeft">
                <!-- 文章内容（使用Kingeditor富文本编辑器发表的） -->
                <div class="article-detail shadow">
                    <div class="article-detail-title">
                        <?= $article->title;?>
                    </div>
                    <div class="article-detail-info">
                        <span>编辑时间：<?= date('Y/m/d H:i:s', $article->display_at);?></span>
                        <span>作者：<?= $article->people->nickname;?></span>
                        <span>浏览量：<?= $article->reader_num;?></span>
                    </div>
                    <?=html_entity_decode($article->content);?>
                </div>
            </div>

            <div class="blog-main-right animated fadeInRight">
                <!--右边悬浮 平板或手机设备显示-->
                <div class="category-toggle"><i class="fa fa-chevron-left"></i></div><!--这个div位置不能改，否则需要添加一个div来代替它或者修改样式表-->
                <div class="blog-module shadow">
                    <div class="blog-module-title">热文排行</div>
                    <ul class="fa-ul blog-module-ul" id="hotArticle">
                        <?php foreach ($hot_articles as $article): ?>
                            <li>
                                <i class="layui-icon" style="color: #FF5722;position: absolute;left: -24px;">
                                    
                                </i>
                                <a href="<?php echo Uri::create('article'); ?>/<?= $article->id ?>">
                                    <?= $article->title; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
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
<script src="<?php echo Asset::get_file('home/article/detail.js','js'); ?>"></script>
</html>