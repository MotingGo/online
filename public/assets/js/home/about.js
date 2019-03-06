layui.use(['element', 'jquery', 'form', 'layedit', 'upload'], function () {
    var element = layui.element;
    var $ = layui.jquery;
    var layedit = layui.layedit;
    var upload = layui.upload;
    var contentObject = $('#commentContentId');
    var guestRegisterIndex = null;
    var replyAfterObject = null;
    var replyObject = null;

    var guest_avatar = "";
    // 图片上传
    var uploadInst = upload.render({
        elem: '#test1'
        ,url: UPLOAD_URl
        ,done: function(res){
            //如果上传失败
            if ( ! (res instanceof Object)){
                return layer.msg('上传失败');
            } else if(res.status > 0){
                return layer.msg('上传失败');
            }
            var attachment = res.data[0];
            guest_avatar = attachment.id;
            // 设置显示图片
            $('#guestAvatarImgId').attr("src", attachment.url)
        }
        ,error: function(){
            //演示失败状态，并实现重传
            var demoText = $('#demoText');
            demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
            demoText.find('.demo-reload').on('click', function(){
                uploadInst.upload();
            });
        }
    });

    //评论和留言的编辑器
    var editIndex=layedit.build('remarkEditor', {
        height: 150,
        tool: ['face', '|', 'left', 'center', 'right', '|', 'link'],
    });

    //Hash地址的定位
    var layid = location.hash.replace(/^#tabIndex=/, '');
    if ("" == layid) {
        element.tabChange('tabAbout', 1);
    }
    element.tabChange('tabAbout', layid);

    element.on('tab(tabAbout)', function (elem) {
        location.hash = 'tabIndex=' + $(this).attr('lay-id');
    });

    function checkContent(value) {
        if (value === "") {
            msg =  "不写一个字,怎么留言呢??";
        } else{
            return true;
        }

        layer.alert($msg, {icon: 2});
        return false;
    }

    // 提交留言
    $('#submitButtonId').click(function () {
        var content = $.trim(layedit.getText(editIndex));
        if (!checkContent(content)){
            return false;
        }
        // 检测是否有cookie记录
        var user_key = getCookie('user_key');
        if (false===user_key){
            // 打开注册页面
            //捕获页
            guestRegisterIndex = layer.open({
                type: 1,
                shade: false,
                title: false, //不显示标题
                content: $('#registerId'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            });
            return false;
        }

        // 提交留言
        sendMessage(user_key, content);

    });


    // 提交注册
    $('#registerButtonId').click(function () {

        // 获取输入的用户名 上传的头像
        register($('#usernameID').val(), guest_avatar);
    });

    // 评论
    $('.replyA').click(function () {
        // 检测是否有cookie记录:检测是否有登记历史
        var user_key = getCookie('user_key');
        if (false===user_key){
            // 打开注册页面
            //捕获页
            layer.open({
                type: 1,
                shade: false,
                title: false, //不显示标题
                content: $('#registerId'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            });
            return false;
        }
        // 获取对应数值
        var currentObject = $(this);
        var value = currentObject.attr("value");
        // 检查当前状态
        if ("reply"===value){
            // 更改显示文本
            currentObject.html('收起');
            currentObject.attr("value", "stop");
            // 添加输入框
            currentObject.after(getReplayDiv());
            $('.submitReplyButton').bind('click',submitReplyClick);
        } else if ("stop"===value){
            // 更改显示文本
            currentObject.html('回复');
            currentObject.attr("value", "reply");
            // 去除输入框
            currentObject.next().remove();
        }
    });

    /**
     * 添加评论行
     * @param comment
     */
    function addMessageDiv(comment) {
        contentObject.prepend("<li>"
            + "<div class=\"comment-parent\"><img src=\""
            + comment.avatar
            + "\" alt=\""
            + comment.nickname
            + "\"><div class=\"info\">"
            + "<span class=\"username\">"
            + comment.nickname
            + "</span>"
            + "</div>"
            + "<div class=\"content\">"
            + comment.content
            + "</div>"
            + "<p class=\"info info-footer\">"
            + "<span class=\"time\">"
            + TimeStampToMyDate(comment.display_at)
            + "</span>"
            + "<a class=\"btn-reply replyA\" value=\"reply\" >回复</a>"
            + "</p></div>"
            + "<hr>"
            + "</li>");

        $('#remarkEditor').html('');
        layedit.sync(editIndex);
    }

    /**
     * 添加回复行
     * @param afterObject
     * @param comment
     */
    function addReplyDiv(afterObject, comment) {

        afterObject.after("<hr><div class=\"comment-child\">"
            + "<img src=\""
            + comment.avatar
            + "\" alt=\""
            + + comment.nickname
            + "\">"
            + "<div class=\"info\">"
            + "<span class=\"username\">"
            + comment.nickname
            + "</span>"
            + "<span>"
            + comment.content
            + "</span>"
            + "</div>"
            + "<p class=\"info\">"
            + "<span class=\"time\">"
            + TimeStampToMyDate(comment.display_at)
            + "</span>"
            + "</p>"
            + "</div>");
    }

    /**
     * 提交评论
     * @param user_key
     * @param content
     */
    function sendMessage(user_key, content) {
        $.ajax({
            url:GUEST_SEND_URL,
            data:{
                user_key:user_key,
                content:content
            },
            type:'POST',
            success:function (res) {
                if ('succ' != res.status){
                    layer.alert('提交错误', {icon: 2});
                    return false;
                }
                layer.msg('操作成功', {icon: 1, time:1000});
                addMessageDiv(res.data)
                // 清空输入栏
            }

        });
    }

    /**
     * 提交回复
     * @param user_key
     * @param content
     * @param parent_key
     */
    function sendReply(content, parent_key) {
        $.ajax({
            url:GUEST_REPLY_URL,
            data:{
                content:content,
                parent_key:parent_key
            },
            type:'POST',
            success:function (res) {
                if ('err' === res.status){
                    layer.alert('提交错误', {icon: 2});
                } else {
                    addReplyDiv(replyAfterObject, res.data);
                    replyObject.prev().html('回复');
                    replyObject.prev().attr("value", "reply");
                    replyObject.remove();
                    //提示层
                    layer.msg('提交成功',  {
                        icon: 1,
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    });
                }
            }
        });
    }

    // 提交回复的点击事件
    function submitReplyClick() {

        var btnObject = $(this);
        var contentDivObject = btnObject.parent().prev();
        var content = contentDivObject.children().last().val();
        var CommentReplyObject = contentDivObject.parent().parent().prev();

        var comment_key = CommentReplyObject.attr('commentKey');

        replyAfterObject = CommentReplyObject.parent().parent().parent().children().last();
        replyObject = CommentReplyObject.next();

        sendReply(content, comment_key);
    }

    /**
     * 注册
     * @param avatar_id
     * @param nickname
     */
    function register(nickname, avatar_id) {
        var loadIndex1 = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            url:GUEST_REGISTER_URL,
            data:{
                avatar_id:avatar_id,
                nickname:nickname
            },
            type:'POST',
            success:function (res) {
                if ('err' === res.status){
                    layer.alert('提交错误', {icon: 2});
                    return false;
                }
                layer.msg("请继续操作", {icon: 1,time:1000});
                layer.close(loadIndex1);
                layer.close(guestRegisterIndex);
            }
        });
    }

    /**
     * 添加回复输入框
     * @returns {string}
     */
    function getReplayDiv() {
        return "<div class=\"replycontainer\">" +
            "<form class=\"layui-form\" action=\"\">" +
            "<input type=\"hidden\" name=\"articleId\" value=\"'+comment.id+'\">" +
            "<div class=\"layui-form-item\">" +
            "<textarea name=\"replyContent\" lay-verify=\"replyContent\" placeholder=\"请输入回复内容\" class=\"layui-textarea\" style=\"min-height:80px;\"></textarea>" +
            "</div>" +
            "<div class=\"layui-form-item\">" +
            "<button class=\"layui-btn layui-btn-mini replyButton submitReplyButton\" type=\"button\">提交</button>" +
            "</div>" +
            "</form>" +
            "</div>"
    }

    /**
     * 获取Cookie
     * @param c_name
     * @returns {*}
     */
    function getCookie(c_name) {
        if (document.cookie.length>0)
        {
            var c_start=document.cookie.indexOf(c_name + "=")
            if (c_start!=-1)
            {
                c_start=c_start + c_name.length+1
                var c_end=document.cookie.indexOf(";",c_start)
                if (c_end==-1) c_end=document.cookie.length
                return unescape(document.cookie.substring(c_start,c_end))
            }
        }
        return false
    }

    /**
     * 时间戳转日期
     * @return {string}
     */
    function TimeStampToMyDate(timeStamp){

        var dateTime = new Date(timeStamp * 1000);

        return dateTime.getFullYear().toString() + "年"
            + StructCode(dateTime.getMonth()+1) + "月"
            + StructCode(dateTime.getDate()) + "日 "
            + StructCode(dateTime.getHours()) + ":"
            + StructCode(dateTime.getMinutes()) + ":"
            + StructCode(dateTime.getSeconds());
    }

    /**
     * @return {string}
     */
    function StructCode(str) {
        return str<10 ? "0"+str.toString() : str;
    }

});


