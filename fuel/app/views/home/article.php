<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=gb2312">
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>昱建个人博客</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo Asset::get_file('home/title_logo.png', 'img'); ?>"/>
    <!--本页样式表-->
    <link href="<?php echo Asset::get_file('home/article.css','css'); ?>" rel="stylesheet" />
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
        <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
            <a href="/blog/blogIndex.htm" title="网站首页">网站首页</a>
            <a><cite>文章专栏</cite></a>
        </blockquote>
        <div class="blog-main">
            <div class="blog-main-left animated fadeInLeft">
                <?php foreach($articles as $article):?>
                <div class="article shadow">
                    <div class="article-left">
                        <img lay-src="<?=$article->thumbnail->url?>" alt="<?=$article->title?>" class="shake shake-slow"/>
                    </div>
                    <div class="article-right">
                        <span  class="article-title-left"><?=$article->type ? '原创' : '转载';?></span>
                        <div class="triangle-right"></div>
                        <div class="article-title">
                            <a href="<?php echo Uri::create('article'); ?>/<?=$article->id?>"><?=$article->title?></a>
                        </div>
                        <div class="article-footer">
                            <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?=date('Y/m/d H:i:s', $article->display_at)?></span>
                            <span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$article->people->nickname?></span>
                            <span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;<?=$article->reader_num?></span>
                        </div>
                        <div class="article-abstract">
                            <?=$article->summary?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php endforeach;?>
                <div class="layui-flow-more">没有更多了</div>
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
<div class="blog-mask animated layui-hide"></div></body>
<script>

    layui.use(["laypage","jquery","layer",'flow'],
        function(){
            var $=layui.jquery,laypage=layui.laypage,layer=layui.layer,flow=layui.flow;
            //图片懒加载
            flow.lazyimg();
            //分页
            var currentPage = $("#currentPage").val();
            var rows = $("#rows").val();
            laypage.render({
                elem: 'page',
                curr:currentPage,
                count: rows, //数据总数
                jump: function(obj, first){
                    var curr=obj.curr;//得到当前页，以便向服务端请求对应页的数据。
                    var limit=obj.limit;//得到每页显示的条数
                    //首次不执行
                    var typeId=$("#typeId").val();
                    if (!first) {
                        window.location.href = "/blog/blogIndex.htm?currentPage="
                            + curr+"&typeId="+typeId+"&type="+type;
                    }
                }
            });
            //
        });
</script>


</html>