<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/27
 * Time: 0:56
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
    <link href="<?php echo Asset::get_file('home/about.css','css'); ?>" rel="stylesheet" />
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
        <div class="blog-main">
            <div class="layui-tab layui-tab-brief shadow" lay-filter="tabAbout">
                <ul class="layui-tab-title">
                    <li lay-id="1">！！↓ ！！</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item">
                        <div class="aboutinfo">
                            <div class="aboutinfo-figure">
                                <img src="<?php echo \Asset::get_file('blog_message.jpg', 'img') ?>" alt="留言墙" />
                            </div>
                            <div class="aboutinfo-contact">
                                <p style="font-size:2em;">沟通交流，拉近你我！</p>
                            </div>
                            <fieldset class="layui-elem-field layui-field-title">
                                <legend>Leave a message</legend>
                                <div class="layui-field-box">
                                    <div class="leavemessage" style="text-align:initial">
                                        <form class="layui-form blog-editor" action="">
                                            <div class="layui-form-item">
                                                <textarea name="editorContent" lay-verify="content" id="remarkEditor" placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                            </div>
                                            <div class="layui-form-item">
                                                <button class="layui-btn" lay-submit="formLeaveMessage" lay-filter="formLeaveMessage" id="submitButtonId" type="button">提交留言</button>
                                            </div>
                                        </form>
                                        <ul class="blog-comment" id="commentContentId">
                                            <?php foreach ($comments as $comment): ?>
                                            <li>
                                                <div class="comment-parent">
                                                    <img src="<?=$comment->guest->avatar->url?>" alt="<?=$comment->guest->nickname?>">
                                                    <div class="info">
                                                        <span class="username"><?=$comment->guest->nickname?></span>
                                                    </div>
                                                    <div class="content"><?=html_entity_decode($comment->content)?></div>
                                                    <p class="info info-footer"><span class=\"time\"><?=date('Y/m/d H:i:s', $comment->display_at)?></span>
                                                        <a class="btn-reply replyA" href="javascript:;" value="reply" commentKey="<?=$comment->id?>">回复</a>
                                                    </p></div>
                                                <hr>
                                                <?php foreach ($comment->comments as $child_comment): if($child_comment->is_display == 1) continue; ?>
                                                <hr><div class="comment-child">
                                                    <img src="<?=$child_comment->guest->avatar->url;?>" alt="<?=$child_comment->guest->nickname?>">
                                                    <div class="info">
                                                        <span class="username"><?=$child_comment->guest->nickname?></span>
                                                        <span><?=html_entity_decode($child_comment->content);?>
                                                    </span>
                                                    </div>
                                                    <p class="info">
                                                        <span class="time"><?=date('Y/m/d H:i:s', $comment->display_at)?></span>
                                                    </p>
                                                </div>
                                                <?php endforeach?>
                                            </li>
                                            <?php endforeach?>
                                            <div class="layui-flow-more">没有更多了</div>
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div><!--留言墙End-->
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
<script src="<?php echo Asset::get_file('home/about.js','js'); ?>"></script>
<script>
    var ip="<?=Input::real_ip();?>";
    var UPLOAD_URl = '<?= \Uri::create('common/upload'); ?>';
    var GUEST_REGISTER_URL = '<?= \Uri::create('guest/register'); ?>';
    var GUEST_SEND_URL = '<?= \Uri::create('guest/comment'); ?>';
    var GUEST_REPLY_URL = '<?= \Uri::create('guest/reply'); ?>';
</script>
<from id="registerId" style="display: none;">
    <br>
    <h3 align="center">留下您的名字</h3>
    <br>
    <div class="layui-inline layui-form-item">
        <label class="layui-form-label">用户</label>
        <div class="layui-input-inline">
            <input autocomplete="off" class="layui-input" id="usernameID">
        </div>
    </div>
    <div class="layui-inline layui-form-item">
        <img id="guestAvatarImgId" src="<?php echo Asset::get_file('home/default_avatar.png', 'img');?>" alt="" width="35px" style="padding-left: 70px">
        <button type="button" class="layui-btn" id="test1">上传图片</button>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" type="button" id="registerButtonId">立即提交</button>
            <button type="button" class="layui-btn layui-btn-primary" id="cancelButtonId">取消</button>
        </div>
    </div>
</from>
</html>
