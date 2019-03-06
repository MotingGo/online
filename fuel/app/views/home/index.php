<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/26
 * Time: 21:45
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>昱建个人博客</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo Asset::get_file('home/title_logo.png', 'img'); ?>"/>
    <!-- 本页样式表 -->
    <link href="<?php echo Asset::get_file('home/home.css', 'css'); ?>" rel="stylesheet"/>
</head>
<body>
<!--Layui-->
<link href="<?php echo Asset::get_file('layui/css/layui.css', 'plugin'); ?>" rel="stylesheet"/>
<!--font-awesome-->
<link href="<?php echo Asset::get_file('canvas/style/css/font-awesome.min.css', 'plugin'); ?>" rel="stylesheet"/>
<!-- 动画 -->
<link href="<?php echo Asset::get_file('canvas/style/css/animate.min.css', 'plugin'); ?>" rel="stylesheet"/>
<!--全局样式表-->
<link href="<?php echo Asset::get_file('home/global.css', 'css'); ?>" rel="stylesheet"/>
<!-- 离子特效 -->
<script src="<?php echo Asset::get_file('canvas/style/js/canvas-nest.js', 'plugin'); ?>"></script>
<!-- 动画 -->
<link rel="stylesheet" href="<?php echo Asset::get_file('canvas/style/css/csshake.min.css', 'plugin'); ?>">
<!-- layui.js -->
<script src="<?php echo Asset::get_file('layui/layui.js', 'plugin'); ?>"></script>
<!-- 全局脚本 -->
<script src="<?php echo Asset::get_file('home/global.js', 'js'); ?>"></script>
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
                <a href="<?php echo Uri::create('index'); ?>" onclick="clickTitle(this)"><i
                            class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('article'); ?>" onclick="clickTitle(this)"><i
                            class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('timeline'); ?>" onclick="clickTitle(this)"><i
                            class="fa fa-hourglass-half fa-fw"></i>&nbsp;时光轴</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo Uri::create('about'); ?>" onclick="clickTitle(this)"><i
                            class="fa fa-info fa-fw"></i>&nbsp;留言墙</a>
            </li>
        </ul>
        <!-- 手机和平板的导航开关 -->
        <a class="blog-navicon" href="javascript:;">
            <i class="fa fa-navicon"></i>
        </a>
    </div>
</nav>
<script>
    layui.use(['element'], function () {
        var element = layui.element;
    });

</script>    <!-- 主体（一般只改变这里的内容） -->
<div class="blog-body">
    <!-- 这个一般才是真正的主体内容 -->
    <div class="blog-container">
        <div class="blog-main">
            <!--左边文章列表-->
            <div class="blog-main-left animated fadeInLeft">
                <!-- 轮播 -->
                <div style="width: 100%;height: 314px;">
                    <div class="layui-carousel" id="carouse_1">
                        <div carousel-item>
                            <div>
                                <img style="width:100%;height:280px" alt=""
                                     src="http://otoy6enr0.bkt.clouddn.com/banner.jpg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="articlelist-title">
                    <h3>最新发布</h3>
                </div>
                <?php foreach ($articles as $article): ?>
                    <div class="article shadow ">
                        <div class="article-left">
                            <img lay-src="<?= $article->thumbnail->url ?>" alt="<?= $article->title ?>"
                                 class="shake shake-slow"/>
                        </div>
                        <div class="article-right">
                            <span class="article-title-left"><?php echo $article->id == 1? '原创' : '转载'; ?></span>
                            <div class="triangle-right"></div>
                            <h2 class="article-title">
                                <a href="<?php echo Uri::create('article'); ?>/<?= $article->id ?>"><?= $article->title ?></a>
                            </h2>
                            <div class="article-footer">
                                <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?= date('Y/m/d H:i:s', $article->display_at) ?></span>
                                <span class="article-author"><i
                                            class="fa fa-user"></i>&nbsp;&nbsp;<?= $article->people->nickname ?></span>
                                <span class="article-viewinfo"><i
                                            class="fa fa-eye"></i>&nbsp;<?= $article->reader_num ?></span>
                            </div>
                            <div class="article-abstract">
                                <?= $article->summary ?>
                            </div>

                        </div>
                        <div class="clear"></div>

                    </div>
                <?php endforeach; ?>
            </div>
            <style>
                .vistor {
                    margin-left: 6px;
                    font-size: 0;
                }

                .vistor dd {
                    position: relative;
                    width: 65px;
                    height: 85px;
                    margin: 10px 10px 0px 0;
                    display: inline-block;
                    vertical-align: top;
                    font-size: 12px;
                }

                .vistor dd a img {
                    width: 65px;
                    height: 65px;
                    border-radius: 2px;
                }

                .vistor dd a cite {
                    position: absolute;
                    bottom: 20px;
                    left: 0;
                    width: 100%;
                    height: 20px;
                    line-height: 20px;
                    text-align: center;
                    background-color: rgba(0, 0, 0, .2);
                    color: #fff;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                .layui-tab-title li {

                }
            </style>
            <!--右边小栏目-->
            <div class="blog-main-right animated fadeInRight">
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
                <div class="blog-module shadow">
                    <div class="blog-module-title">最近分享</div>
                    <ul class="fa-ul blog-module-ul" id="recentShare">
                        <?php foreach ($articles as $article): ?>
                        <li>
                            <i class="fa-li fa fa-hand-o-right">

                            </i>
                            <a href="" target="_blank">
                                <?= $article->title; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="blog-module shadow">
                    <div class="blog-module-title">最近访客</div>
                    <dl class="vistor">
                        <?php foreach ($guests as $guest): ?>
                        <dd>
                            <a href="javasript:;">
                                <img src="<?= $guest->avatar->url;?>"/>
                                <cite><?= $guest->nickname;?></cite>
                            </a>
                        </dd>
                        <?php endforeach; ?>
                    </dl>
                </div>
            </div>
            <div class="clear"></div>
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
<div class="blog-mask animated layui-hide"></div>
</body>
<!-- 本页脚本 -->
<script src="<?php echo Asset::get_file('home/home.js', 'js'); ?>"></script>
</html>
