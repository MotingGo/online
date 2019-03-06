<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/26
 * Time: 0:33
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
        .layui-box{
            margin-top: 50%;
            background-color: rgba(0,0,0,.2);
            color: rgba(255,255,255,1);
        }
        .layui-upload-file{
            z-index: 10;
        }
    </style>
</head>
<body>
<fieldset id="dataConsole" class="layui-elem-field layui-field-title" >
    <div class="layui-field-box">
        <div id="articleIndexTop">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item" style="margin:0;margin-top:15px;">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" autocomplete="off" class="layui-input" value="<?=$keyword;?>">
                        </div>
                        <div class="layui-input-inline" style="width:auto">
                            <button class="layui-btn" lay-submit lay-filter="formSearch">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <fieldset id="dataList" class="layui-elem-field layui-field-title sys-list-field" >
        <legend style="text-align:center;">我的</legend>
        <div class="layui-field-box">
            <div id="dataContent" class="" style="margin-left: 2%">
                <!--内容区域 ajax获取-->
                <table class="layui-table" lay-even style="width: 98%">
                    <colgroup>
                        <col width="200"/>
                        <col width="150"/>
                        <col width=""/>
                        <col width="250">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>作者</th>
                        <th>时间</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($comments as $comment):?>
                    <tr>
                        <td>
                            <div style="text-align: left;">
                                <img src="<?= $comment->guest->avatar->url?>" alt="<?= $comment->guest->nickname?>" style="width: 45px"><span><?= $comment->guest->nickname?></span>
                            </div>
                        </td>
                        <td><?= date('Y年m月d日 H:i:s',$comment->display_at);?>
                        </td>
                        <td><?= html_entity_decode($comment->content)?>
                        </td>
                        <td>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add edit-button' style="width: 70px;" value="<?=$comment->is_display;?>" messageId="<?=$comment->id;?>">
                                <?= $comment->is_display == 1 ? '显示' : '隐藏'?>
                            </button>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add delete-button' style="width: 70px;" messageId="<?=$comment->id;?>">删除</button>
                        </td>
                    </tr>
                    <?php foreach ($comment->comments as $child_comment):?>
                    <tr>
                        <td>
                            <div style="text-align: right;">
                                <img src="<?= $child_comment->guest->avatar->url?>" alt="<?= $child_comment->guest->nickname?>" style="width: 45px" ><span><?= $child_comment->guest->nickname?></span>
                            </div>
                        </td>
                        <td><?= date('Y年m月d日 H:i:s',$child_comment->display_at);?>
                        </td>
                        <td><?= html_entity_decode($child_comment->content)?>
                        </td>
                        <td>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add edit-button' style="width: 70px;" value="<?=$child_comment->is_display;?>" messageId="<?=$child_comment->id;?>">
                                <?= $child_comment->is_display == 1 ? '显示' : '隐藏'?>
                            </button>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add delete-button' style="width: 70px;" messageId="<?=$child_comment->id;?>">删除</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endforeach;?>
                    </tbody>
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
<script>
    var NOTE_PUT_URL = "<?php echo Uri::create('manager/message'); ?>";
    var MESSAGE_DELETE_PUT = "<?php echo Uri::create('manager/message'); ?>";

    layui.use(['layer', 'jquery'], function(){
        var layer = layui.layer;

        var currentTr = null;
        var currentConfirmBoxIndex = null;

        $('.edit-button').click(function () {
            var editButton = this;
            $.ajax({
                url:NOTE_PUT_URL + "/" + $(this).attr('messageId'),
                data:{is_display:this.value==='1'?0:1},
                type:'PUT',
                success:function (res) {
                    if ( ! (res instanceof Object) ){
                        return false;
                    } else if ('err' === res.status){
                        return false;
                    } else {
                        editButton.value = (editButton.value === '0' ? 1 : 0);
                        editButton.innerHTML = (editButton.value === '0' ? '隐藏' : '显示')
                    }
                }
            });
        });

        $('.delete-button').click(function () {
            currentTr = $(this).parent().parent();
            var currentMessageId = $(this).attr('messageId');

            currentConfirmBoxIndex = layer.confirm('需要删除？', {
                btn: ['是的','取消'] //按钮
            }, function(){
                $.ajax({
                    url:MESSAGE_DELETE_PUT,
                    type:'DELETE',
                    data:{
                        id:currentMessageId,
                        is_deleted:1
                    },
                    success:function (res) {
                        if ('succ'!==res.status) {
                            // 请求错误
                            layer.alert("请求错误", {icon:2});
                            return false;
                        }
                        currentTr.remove();
                        layer.close(currentConfirmBoxIndex);
                        layer.msg("已删除", {icon: 1,time:1000});
                    }
                });
            }, function(){
                layer.close(currentConfirmBoxIndex);
            });
        });
    });
</script>
</html>