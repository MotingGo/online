<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/6
 * Time: 0:29
 */?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>数据列表页面</title>
    <!-- layui.css -->
    <link href="<?php echo Asset::get_file('layui-v1.0.9/css/layui.css','plugin'); ?>" rel="stylesheet" />
    <link href="<?php echo Asset::get_file('custom/label.css','css'); ?>" rel="stylesheet" />
    <script src="<?php echo Asset::get_file('jquery-1.8.2.min.js','js'); ?>"></script>
    <style>
        .custom_lable{
            margin-left: 10px;
            display: inline-block;
            width: 90px;
            padding: 8px 8px 8px 8px;
            border: 1px solid #e6e6e6;
            border-radius: 2px 0 0 2px;
            text-align: center;
            background-color: #FBFBFB;
            text-overflow: ellipsis;
            box-sizing: border-box!important;
            cursor:pointer;
        }
        .custom_icon_close{
            font-family: layui-icon!important;
            font-size: 16px;
            font-style: normal;
        }
        .custom_icon_close:hover{
            background-color: #ff5722;
        }
        .layui-btn-small {
            margin-top: 15px;
            width: 80px;
            height: 30px;
            line-height: 30px;
            padding: 0 10px;
            font-size: 12px;
        }

        .layui-form-checkbox {
            margin: 0;
        }

        tr td:not(:nth-child(0)),
        tr th:not(:nth-child(0)) {
            text-align: center;
        }

        #dataConsole {
            text-align: center;
        }
        /*分页页容量样式*/
        /*可选*/
        .layui-laypage {
            display: block;
        }

        /*可选*/
        .layui-laypage > * {
            float: left;
        }
        /*可选*/
        .layui-laypage .laypage-extend-pagesize {
            float: right;
        }
        /*可选*/
        .layui-laypage:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }

        /*必须*/
        .layui-laypage .laypage-extend-pagesize {
            height: 30px;
            line-height: 30px;
            margin: 0px;
            border: none;
            font-weight: 400;
        }
        .layui-custom-table{
            table-layout: fixed;
            width: 360px;
            height: 270px;
        }
        .layui-custom-table tr td,custom-textbox{
            text-overflow: ellipsis!important;
            white-space: nowrap!important;
            overflow: hidden!important;
            text-align: left!important;
        }
        /*分页页容量样式END*/
        .layui-custom-btn-add{
            height: 36px;
            margin: 8px 8px;
            width: 90px;
        }
    </style>
</head>
<body>
    <fieldset id="dataConsole" class="layui-elem-field layui-field-title" >
        <legend>控制台</legend>
        <div class="layui-field-box">
            <div id="articleIndexTop">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item" style="margin:0;margin-top:15px;">
                        <div class="layui-inline">
                            <label class="layui-form-label">关键词</label>
                            <div class="layui-input-inline">
                                <input type="text" name="keywords" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-input-inline" style="width:auto">
                                <button class="layui-btn" lay-submit lay-filter="formSearch">搜索</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
    <fieldset id="dataList" class="layui-elem-field layui-field-title sys-list-field" >
        <legend style="text-align:center;">访问列表</legend>
        <div class="layui-field-box">
            <div id="dataContent" class="" style="margin-left: 10%">
                <!--内容区域 ajax获取-->
                <table class="layui-table" lay-even style="width: 90%">
                    <colgroup>
                        <col width="250"/>
                        <col width=""/>
                        <col width="250">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>头像</th>
                            <th>基本信息</th>
                            <th>其他</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div style="margin-top: 6px;">
                                <img src="<?= $user["avatar"];?>" alt="" title="" style="height:190px!important;height:190px;">
                                <div style="margin-top: 15px;">
                                    <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add' style="width: 70px;">下载</button>
                                    <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add' style="width: 70px;">删除</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <table class='layui-custom-table'>
                                <colgroup><col width='150'/><col width=''/></colgroup>
                                <tbody>
                                    <tr><td><span>IP</span></td><td></td></tr>
                                    <tr><td><span>昵称</span></td><td></td></tr>
                                    <tr><td><span>网络位置</span></td><td></td></tr>
                                    <tr><td><span>上一次访问时间</span></td><td></td></tr>
                                    <tr><td><span>令牌有效时间</span></td><td></td></tr>
                                    <tr><td><span>令牌过期时间</span></td><td></td></tr>
                                    <tr><td><span>令牌离过期时间</span></td><td></td></tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add' style="width: 70px;">记录</button>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add' style="width: 70px;">设置</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pageNav"></div>
            </div>
        </div>
    </fieldset>
    <!-- layui.js -->
    <script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
    <!-- layui规范化用法 -->
    <script type="text/javascript">

        var URL_CREATE = "<?php echo Uri::create('manager/create'); ?>";
        var URL_EDIT = "<?php echo Uri::create('manager/edit'); ?>";
        var URL_PAGEDATA = "<?php echo Uri::create('manager/pagedata'); ?>";
        var URL_CURRENT = "<?php echo Uri::current(); ?>";
        var URL_DELETEDATA = "<?php echo Uri::create('manager/delete'); ?>";
        var URL_UPLOADVEDIO = "<?php echo Uri::create('manager/upvideo'); ?>";
        var URL_UPDATEDISPLAY = "<?php  echo Uri::create('manager/display'); ?>";
        var URL_BASE = "<?php  echo \Fuel\Core\Uri::base(); ?>";

        layui.config({
            base: '<?php echo \Fuel\Core\Uri::base();?>assets/js/managers/'
        }).use('user');
    </script>
</body>
</html>