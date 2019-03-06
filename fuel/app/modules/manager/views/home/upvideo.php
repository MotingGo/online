<?php
/**
 * Created by PhpStorm.
 * User: moting
 * Date: 2017/6/19
 * Time: 14:08
 */?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?php echo Asset::get_file('layui-v1.0.9/css/layui.css','plugin'); ?>" rel="stylesheet" />
    <script src="<?php echo Asset::get_file('jquery-1.8.2.min.js','js'); ?>"></script>
    <style type="text/css">
        .custom-table{
            width: 300px;
        }
        .custom-table tbody tr td{
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<table class="custom-table">
    <tbody>
    <tr>
        <td>
            <input type="file" name="file2" lay-type="video" class="layui-upload-file" ><input type="hidden" id="formVideoUrl" value="">
        </td>
        <td>
            <label class="layui-form-label" style="width: 30px">标签</label><input id="formActorName" type="text" class="layui-input" value="" autocomplete="on" placeholder="比如:高清中文/第一集/。。。" style="float: left;width: 100px;"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button type="button" id="uploadVideo" class="layui-btn layui-btn-normal">保存</button>
            <button class="layui-btn layui-btn-normal" type="button" id="formCancel">取消</button>
        </td>
    </tr>
    </tbody>
</table>
<script src="<?php echo Asset::get_file('layui-v1.0.9/layui.js','plugin'); ?>"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    var URL_UPLOADVIDEO = "<?php  echo Uri::create('manager/savevideo'); ?>";
    var currentMovieId = "<?php  echo $current_movie_id; ?>";

    $('#uploadVideo').on('click',function () {
        $currentForm = getForm();
        if($currentForm !== false)
        {
            $.post(URL_UPLOADVIDEO,$currentForm,function (res) {
                if(res == "success"){
                    $('#formCancel').click();
                }else{
                    alert('上传失败！请重试！');
                }
            })
        }
    });

    $('#formCancel').on('click',function () {
        //当你在iframe页面关闭自身时
        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
        parent.layer.close(index); //再执行关闭
    });

    function getForm() {
        if($('#formVideoUrl').val() == ''){

        }else if($('#formActorName').val() == ''){

        }else{
            return {
                id                  : currentMovieId,
                movie_path          : $('#formVideoUrl').val(),     // 视频路径
                movie_sign          : $('#formActorName').val()    // 视频名字
            }
        }
        return false;
    }

    layui.use('upload', function(){
        layui.upload({
            url:  "<?php  echo Uri::create('manager/uploadvideo'); ?>" //上传接口
            ,success: function(res){ //上传成功后的回调
                $('#formVideoUrl').val(res.url);
            }
        });
    });
</script>

</body>
</html>