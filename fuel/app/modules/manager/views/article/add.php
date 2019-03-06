<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/25
 * Time: 16:31
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
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input style="width: 91%;" type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input" id="titleID">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">缩略图：</label>
        <div class="layui-input-block" style="text-align: left;">
            <input type="file" name="file" class="layui-upload-file">
            <label id="fileName"></label>
        </div>
    </div>

    <div class="layui-form-item layui-form" style="width: 190px;">
        <label class="layui-form-label">发布类型</label>
        <div class="layui-input-block">
            <select name="interest" lay-filter="aihao" id="labelID">
                <option value="1" selected>原创</option>
                <option value="2">转载</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <textarea style="width: 91%;" placeholder="请输入内容" class="layui-textarea" id="summaryID"></textarea>
        </div>
    </div>
    <legend>开始</legend>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">主要内容</label>
        <div class="layui-input-block">
            <textarea id="contentID" style="width: 91%;display: none;"><?=isset($article) ? $article->content : '';?></textarea>
        </div>
    </div>
<!--    <div class="layui-field-box" style="width: 600px;margin-left: 40px;">-->
<!--        <textarea id="MainContentID" style="display: none;"></textarea>-->
<!--    </div>-->
    <div class="layui-field-box">
            <button class="layui-btn" style="" type="button" id="submitButtonID">发布</button>
    </div>
</fieldset>
</body>
<!-- layui.js -->
<script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
<!-- 自定义.js -->
<script src="<?php echo Asset::get_file('managers/article/add.js','js'); ?>"></script>
<script>

    var UPLOAD_URl = '<?= \Uri::create('common/upload'); ?>';
    var POST_ARTICLE_URL = '<?= \Uri::create('manager/article'); ?>';
    var PUT_ARTICLE_URL = '<?= \Uri::create('manager/article'); ?>';
    var LOCAL_URL = window.location.href;

    var sourceArticle = null;

    <?php if (isset($article)) :?>
    sourceArticle = {
        title:"<?=$article->title;?>",
        thumbnail_id: "<?=$article->thumbnail_id;?>",
        label_id:"<?=$article->type;?>",
        summary:"<?=$article->summary;?>",
    };

    $('#titleID')[0].value = sourceArticle.title;
    $('#labelID').val(sourceArticle.label_id);
    $('#summaryID')[0].value = sourceArticle.summary;
    <?php endif;?>

    layui.use(['layedit','form','upload','jquery'], function(){
        var form = layui.form();
        var layedit = layui.layedit;
        var article = {
            title:'',
            thumbnail_id: sourceArticle == null ? 0 :sourceArticle.thumbnail_id,
            label_id:0,
            summary:'',
            content:''
        };
        form.render();
        var contentEditIndex = layedit.build('contentID',{
            height:400,
            tool: [
                'strong' //加粗
                ,'italic' //斜体
                ,'underline' //下划线
                ,'del' //删除线

                ,'|' //分割线

                ,'left' //左对齐
                ,'center' //居中对齐
                ,'right' //右对齐
                ,'link' //超链接
                ,'unlink' //清除链接
                ,'face' //表情
            ]
        }); //建立编辑器

        layui.upload({
            url: UPLOAD_URl //上传接口
            ,success: function(res){ //上传成功后的回调
                if ( 'err' == res.status){
                    layer.alert("获取失败",{icon:2});
                    return false;
                } else {
                    // var res = eval('('+res+')');
                    var attachment = res.data[0];
                    article.thumbnail_id = attachment.id;
                    layer.msg("上传成功", {icon: 1,time:1000});
                }
            }
        });

        $('#submitButtonID').click(function (event) {

            article.title = $('#titleID')[0].value;
            article.label_id = $('#labelID').val();
            article.summary = $('#summaryID')[0].value;
            article.content = layedit.getContent(contentEditIndex);

            var data = article;
            var type = 'POST';
            var url = POST_ARTICLE_URL;

            if ( ! check_article(article)  ){
                return false;
            }

            if ( sourceArticle != null ){
                data = check_changed(article, sourceArticle);
                if (0 == data.length){
                    return false;
                }
                type = 'PUT';

                var reg = new RegExp('\\d+');
                var hostUrl = window.location.host;
                LOCAL_URL = LOCAL_URL.replace(hostUrl, '')
                var articleId = reg.exec(LOCAL_URL);
                url = PUT_ARTICLE_URL + "/" + articleId;
            }

            $.ajax({
                url: url,
                data: data,
                type: type,
                success: function (res) {

                    if ('err' == res.status){
                        layer.alert("获取失败",{icon:2});
                        return false;
                    }

                    //当你在iframe页面关闭自身时
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index);
                    },500) //再执行关闭

                    layer.msg("操作成功", {icon: 1,time:1000});
                }
            });
        })
    });
</script>
</html>
