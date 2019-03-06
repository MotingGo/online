<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/31
 * Time: 23:54
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
                <thead>
                <tr>
                    <th>头像</th>
                    <th>id</th>
                    <th>昵称</th>
                    <th>网络位置</th>
                    <th>上一次访问时间</th>
                    <th>其他</th>
                    <th>令牌有效时间</th>
                    <th>令牌过期时间</th>
                    <th>令牌离过期时间</th>
                    <th>修改</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($guests as $guest):?>
                    <tr>
                        <td>
                            <div style="margin-top: 6px;">
                                <img src="<?=$guest->avatar->url?>" alt="" title="" style="height:35px!important;">
                            </div>
                        </td>
                        <td><?=$guest->id?></td>
                        <td><?=$guest->nickname?></td>
                        <td><?=$guest->address,$guest->net_type?></td>
                        <td><?=$guest->last_login_at?></td>
                        <td></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add' style="width: 70px;">记录</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
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


    layui.config({
        base: '<?php echo \Fuel\Core\Uri::base();?>assets/js/managers/'
    }).use('user');
</script>
</body>
</html>