<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/25
 * Time: 17:11
 */?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- layui.css -->
    <link href="<?php echo Asset::get_file('layui-v1.0.9/css/layui.css','plugin'); ?>" rel="stylesheet" />
    <link href="<?php echo Asset::get_file('custom/label.css','css'); ?>" rel="stylesheet" />
    <script src="<?php echo Asset::get_file('jquery-1.8.2.min.js','js'); ?>"></script>
    <title>文档主页</title>
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
            width: 98%;
            height: 270px;
        }
        .layui-custom-table tr td,custom-textbox{
            text-overflow: ellipsis!important;
            overflow: hidden!important;
        }
        /*分页页容量样式END*/
        .layui-custom-btn-add{
            height: 36px;
            margin: 8px 8px;
            width: 90px;
        }
        .custom-upload-div{
            width: 190px;
            height: 270px;
            text-align:center;
            background-image: url('<?php
            if(isset($item['picture_src_path'])){
                echo $item['picture_src_path'];
            }else{
                echo Asset::get_file('default_upload.png','img');
            }?>');
        }
        .custom-td-input-edit{
            padding-bottom: 0!important;
            padding-top: 0!important;
        }
        .custom-upload-div{
            width: 225px;
            height: 150px;
            text-align:center;
        }
        /* 225 150*/
        .layui-box{
            margin-top: 20px;
            background-color: rgba(0,0,0,.2);
        }
        .layui-upload-file{
            z-index: 10;
        }
    </style>
</head>
<body>
<fieldset id="dataConsole" class="layui-elem-field layui-field-title" >
    <legend>文章列表</legend>
    <div class="layui-field-box">
        <div id="articleIndexTop">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item" style="margin:0;margin-top:15px;">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keywords" autocomplete="off" class="layui-input" id="searchKeywordId" value="<?=isset($keyword) ? $keyword: ''?>">
                        </div>
                        <div class="layui-input-inline" style="width:auto">
                            <button class="layui-btn" lay-submit lay-filter="formSearch" type="button" id="searchButtonId">搜索</button>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:auto">
                                <a id="addArticle" class="layui-btn layui-btn-normal">文章添加</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <fieldset id="dataList" class="layui-elem-field layui-field-title sys-list-field" >
        <legend style="text-align:center;">访问列表</legend>
        <div class="layui-field-box">
            <div id="dataContent" class="" style="margin-left: 2%">
                <!--内容区域 后端渲染获取-->
                <table class="layui-table" lay-even style="width: 98%">
                    <colgroup>
                        <col width="250"/>
                        <col width=""/>
                        <col width="250">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>预览图</th>
                        <th>简介</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="dataContentBodyId"><?php foreach ($articles as $article): ?>
                        <tr class="article-tr">
                            <td>
                                <div style="margin-top: 6px;">
                                    <div class="custom-upload-div" style="background-image: url('<?= $article->thumbnail->url;?>');background-repeat: no-repeat;background-size: 100%;">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <table class='layui-custom-table'>
                                    <colgroup><col width='60'/><col width=''/></colgroup>
                                    <tbody>
                                    <tr><td><span>标题</span></td><td><?= $article->title;?></td></tr>
                                    <tr><td><span>简介</span></td><td rowspan="2"><?= $article->summary;?></td></tr>
                                    <tr><td><span style="color: white">简介</span></td></tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add edit-button' style="width: 70px;" articleId="<?= $article->id;?>">编辑</button>
                                <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add delete-button' style="width: 70px;" articleId="<?= $article->id;?>">删除</button>
                            </td>
                        </tr>
                    <?php endforeach;?></tbody>
                </table>
                <div id="pageNav"></div>
            </div>
        </div>
    </fieldset>
</fieldset>
</body>
<!-- layui.js -->
<script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
<!-- 自定义.js -->
<script src="<?php echo Asset::get_file('managers/article/structure.js','js'); ?>"></script>
<script src="<?php echo Asset::get_file('managers/article/index.js','js'); ?>"></script>
<script>
    var URL_ADD = "<?php  echo Uri::create('manager/article/add'); ?>";
    var URL_EDIT = "<?php  echo Uri::create('manager/article/edit'); ?>";
    var URL_GET = "<?php  echo Uri::create('manager/article'); ?>";
    var URL_GET_NEW = "<?php  echo Uri::create('manager/article/new'); ?>";
    var URL_LOCAL = "<?php  echo Uri::create('manager/article'); ?>";
    var URL_DELETE = "<?php  echo Uri::create('manager/article'); ?>";

    var ArticleEndDisplayAt = "<?= isset($end_display_at) ? $end_display_at : 0; ?>";
</script>
</html>