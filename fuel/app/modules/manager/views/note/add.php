<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/26
 * Time: 0:10
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
        .layui-layedit{
            width: 90%;
        }
    </style>
</head>
<body>
<fieldset id="dataConsole" class="layui-elem-field layui-field-title" >
    <div class="layui-form-item">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea id="contentID" style="width: 91%;display: none;"></textarea>
        </div>
    </div>
    <legend style="margin-bottom: 20px;">开始</legend>
    <div class="layui-field-box">
        <button class="layui-btn" style="" id="submitButtonID">发布</button>
    </div>
</fieldset>
</body>
<!-- layui.js -->
<script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
<!-- 自定义.js -->
<script src="<?php echo Asset::get_file('managers/note/add.js','js'); ?>"></script>
<script>
    var POST_NOTE_URL = '<?= \Uri::create('manager/note'); ?>';
    var PUT_NOTE_URL = '<?= \Uri::create('manager/note'); ?>';
    var LOCAL_URL = window.location.href;

    var sourceNote = null;

    <?php if (isset($note)) :?>
    sourceNote = {
        content:'<?=html_entity_decode($note->content);?>',
    };

    $('#contentID').val(sourceNote.content);
    <?php endif;?>

    layui.use(['layedit','form','jquery'], function(){
        var form = layui.form();
        var layedit = layui.layedit;
        var note = {
            content:''
        };
        form.render();
        var contentEditIndex = layedit.build('contentID',{
            height:200,
            tool: ['|','|','|','|','|','|','|','|','|','|','|','|','|','|','|','|','face']
        }); //建立编辑器

        $('#submitButtonID').click(function () {

            note.content = layedit.getContent(contentEditIndex);

            var data = note;
            var type = 'POST';
            var url = POST_NOTE_URL;

            if ( ! check_article(note)  ){
                return false;
            }

            if ( sourceNote != null ){
                data = check_changed(note, sourceNote);
                if (0 == data.length){
                    return false;
                }
                type = 'PUT';

                var reg = new RegExp('\\d+');
                var hostUrl = window.location.host;
                LOCAL_URL = LOCAL_URL.replace(hostUrl, '')
                var noteId = reg.exec(LOCAL_URL);
                url = PUT_NOTE_URL + "/" + noteId;
            }

            $.ajax({
                url: url,
                data: data,
                type: type,
                success: function (res) {

                    if ('err' == res.status){
                        layer.alert("获取失败", {icon: 1,time:1000});
                        return false;
                    }

                    //当你在iframe页面关闭自身时
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index);
                    },500) //再执行关闭
                }
            });
        })
    });
</script>
</html>
