<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/26
 * Time: 0:09
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
        <div id="NoteIndexTop">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item" style="margin:0;margin-top:15px;">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" autocomplete="off" class="layui-input" value="<?= $keyword?>">
                        </div>
                        <div class="layui-input-inline" style="width:auto">
                            <button class="layui-btn" lay-submit lay-filter="formSearch">搜索</button>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:auto">
                                <a id="addNote" class="layui-btn layui-btn-normal">添加</a>
                            </div>
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
                        <col width="250"/>
                        <col width=""/>
                        <col width="250">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="dataContentBodyId"><?php foreach ($notes as $note):?>
                    <tr class="note-tr">
                        <td>
                            <?= date('Y年m月d日 H:i:s',$note->display_at);?>
                        </td>
                        <td><?= html_entity_decode($note->content);?>
                        </td>
                        <td>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add edit-button' style="width: 70px;" noteId="<?= $note->id;?>">编辑</button>
                            <button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add delete-button' style="width: 70px;" noteId="<?= $note->id;?>">删除</button>
                        </td>
                    </tr>
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
<script src="<?php echo Asset::get_file('managers/note/struct.js','js'); ?>"></script>
<script>
    var URL_ADD = "<?php  echo Uri::create('manager/note/add'); ?>";
    var URL_EDIT = "<?php  echo Uri::create('manager/note/edit'); ?>";
    var URL_GET = "<?php  echo Uri::create('manager/note'); ?>";
    var URL_GET_NEW = "<?php  echo Uri::create('manager/note/new'); ?>";
    var URL_LOCAL = "<?php  echo Uri::create('manager/note'); ?>";
    var URL_DELETE = "<?php  echo Uri::create('manager/note'); ?>";

    var NoteEndDisplayAt = "<?= isset($end_display_at) ? $end_display_at : 0; ?>";

    layui.use(['layer'], function(){
        var layer = layui.layer;

        var currentTr = null;
        var currentConfirmBoxIndex = null;

        $('.edit-button').click(function () {

            var note = NoteTr;

            note.setTrObject($(this.parentNode.parentNode));
            note.id = this.getAttribute('noteId').toString();

            var index = layer.load(1);

            setTimeout(function () {
                layer.close(index);
                layer.open({
                    type: 2,
                    area: ['700px', '400px'], //宽高
                    content: URL_EDIT+"/" + note.id,
                    end:function () {
                        $.ajax({
                            url:URL_GET + "/" + note.id,
                            type:'GET',
                            success:function (res) {
                                if ( ! (res instanceof Object) ){
                                    return false;
                                } else if ('err' == res.status){
                                    return false;
                                }
                                var trueNote = res.data;
                                note.setDisplayAt(trueNote.display_at);
                                note.setContent(trueNote.content);
                                note.setId(trueNote.id);
                            }
                        })
                    }
                });
            }, 500);
        });

        //添加数据
        $('#addNote').click(function () {

            var index = layer.load(1);
            setTimeout(function () {
                layer.close(index);
                layer.open({
                    type: 2,
                    area: ['700px', '400px'], //宽高
                    content: URL_ADD,
                    end:function () {
                        $.ajax({
                            type:'GET',
                            url:URL_GET_NEW + '?display_at=' + NoteEndDisplayAt,
                            success:function (res) {

                                if ( 'err' == res.status){
                                    layer.alert("获取失败",{icon:2});
                                    return false;
                                } else {
                                    create_note(res.data);
                                    layer.msg("創建成功", {icon: 1,time:1000});

                                }
                            }
                        })
                    }
                });
            }, 500);
        });

        // 创建文章记录
        function create_note(data) {
            for (var key in data) {
                var newNote = NoteTr;
                newNote.setTrObject(getNewNoteTr())
                newNote.setContent(data[key].content);
                newNote.setDisplayAt(data[key].display_at);
                newNote.setId(data[key].id);
            }
            if (0 != data.length){
                NoteEndDisplayAt = data[key].display_at;
            }
        }

        // 获取新的文章行
        function getNewNoteTr() {
            // // 添加tr/行
            var dataContent = $('#dataContentBodyId');
            dataContent.prepend($('.note-tr')[0].outerHTML);
            return dataContent.children().first();
        }

        // 定义按钮的点击事件
        $('#searchButtonId').click(function () {
            window.location.href = URL_LOCAL + '?keyword=' + $('#searchKeywordId').val();
        });

        $('.delete-button').click(function () {

            currentTr = $(this).parent().parent();
            var currentNoteId = $(this).attr('noteid');

            currentConfirmBoxIndex = layer.confirm('需要删除？', {
                btn: ['是的','取消'] //按钮
            }, function(){
                $.ajax({
                    url:URL_DELETE,
                    type:'DELETE',
                    data:{
                        id:currentNoteId,
                        is_deleted:1
                    },
                    success:function (res) {
                        if ('succ'!==res.status) {
                            // 请求错误
                            layer.alert("请求错误",{icon:2});
                            return false;
                        }
                        currentTr.remove();
                        layer.close(currentConfirmBoxIndex);
                        layer.msg("操作成功", {icon: 1,time:1000});
                    }
                });
            }, function(){
                layer.close(currentConfirmBoxIndex);
            });
        });


    });
</script>
</html>
