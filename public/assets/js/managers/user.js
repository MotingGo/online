var layer;
layui.define(['laypage', 'layer', 'form', 'pagesize', 'jquery'], function (exports) {
    var $ = layui.jquery,
        layer = layui.layer,
        form = layui.form(),
        laypage = layui.laypage;
    var laypageId = 'pageNav';
    var data;
    //获取数据
    // $.post(URL_PAGEDATA,{type:'page',movie_type:MOVIE_TYPE},function (res) {
    //     data = eval('(' + res + ')');
    //     initilData(1, 3);
    // });

    //页数据初始化
    //currentIndex：当前也下标
    //pageSize：页容量（每页显示的条数）
    function initilData(currentIndex, pageSize) {
        var index = layer.load(1);
        //模拟数据加载
        setTimeout(function () {
            layer.close(index);
            //计算总页数（一般由后台返回）
            var pages = Math.ceil(data.length / pageSize);
            //模拟数据分页（实际上获取的数据已经经过分页）
            var skip = pageSize * (currentIndex - 1);
            var take = skip + Number(pageSize);
            var hanledata = data.slice(skip, take);
            var html = '';  //由于静态页面，所以只能作字符串拼接，实际使用一般是ajax请求服务器数据
            html += '<table style="" class="layui-table" lay-even>';
            html += '<col width="200"/><col width="350"/><col width="250"/><col width="250"/><col width="250"><col width="200"/><col width="350"/><col width="250"/><col width="250"/><col width="250">';
            html += '<thead><tr><th>视频例图</th><th>视频信息</th><th>视频简介</th><th>资源列表</th><th>操作</th></tr></thead>';
            html += '<tbody>';
            //遍历文章集合
            for (var i = 0; i < hanledata.length; i++) {
                var item = hanledata[i];
                html += "<tr>";
                html += "<td><img alt='"
                    + item['movie_name']
                    + "' title='"
                    + item['movie_name']
                    + "' style='height:270px;' src='"
                    + item['picture_src_path']
                    + "'/></td>";
                html += "<td style='font-size: 10px;'><table class='layui-custom-table'><colgroup><col width='86'/><col width=''/></colgroup><tbody><tr><td><span>视频名称</span></td><td>" + item['movie_name'] + "</td></tr><tr><td><span>导演</span></td><td>" + item['director_name'] + "</td></tr><tr><td><span>主演</span></td><td>" + item['actor_name'] + "</td></tr><tr><td><span>类型</span></td><td>" + item['movie_type'] + "</td></tr><tr><td><span>制片国家</span></td><td>" + item['state_name'] + "</td></tr><tr><td><span>上映日期</span></td><td>" + item['update_time'] + "</td></tr><tr><td><span>评分</span></td><td>" + item['grade_num'] + "</td></tr></tbody></table></td>";
                html += "<td class='custom-textbox'><p>"
                    + item['movie_detail']
                    + "</p></td>";
                if(item['movie_path'] == null){
                    html += "<td><button type='button' class='layui-btn ' onclick='openUploadVideo("
                        + item['id']
                        + ")'>添加</button></td>";
                }else{
                    html += "<td><div class='custom_lable'>"
                        + item['movie_sign']
                        + "<i class='custom_icon_close'>ဆ</i></div></td>";
                }
                //html += "<td><div class='custom_lable'>长输入框<i class='custom_icon_close'>ဆ</i></div><div class='custom_lable'>长输入框<i class='custom_icon_close'>ဆ</i></div><div class='custom_lable'>长输入框<i class='custom_icon_close'>ဆ</i></div><div class='custom_lable'>长输入框<i class='custom_icon_close'>ဆ</i></div><div class='custom_lable'>长输入框<i class='custom_icon_close'>ဆ</i></div><div class='custom_lable'>长输入框<i class='custom_icon_close'>ဆ</i></div><button type='button' class='layui-btn layui-btn-primary layui-custom-btn-add' onclick='openUploadVideo(" + item['id'] + ")'>添加</button></td>";
                //html += "<td><button type='button' class='layui-btn layui-btn-primary custom_icon_close'>添加</button></td>";
                html += "<td><form class='layui-form' action='#'><div class='layui-form-item' style='margin:0;'><input class='' type='checkbox' name='top' title='可见' value='" + item['id'] + "' " + item['display_sign'] + " lay-filter='display_sign' /></div></form><button class='layui-btn layui-btn-small layui-btn-normal ' onclick='openEditPage(" + item['id'] + ")'><i class='layui-icon'>&#xe642;</i></button><br/><button class='layui-btn layui-btn-small layui-btn-danger' onclick='openDelete(" + item['id'] + ",this)'><i class='layui-icon'>&#xe640;</i></button></td>";
                html += "</tr>";
            }
            html += '</tbody>';
            html += '</table>';
            html += '<div id="' + laypageId + '"></div>';

            $('#dataContent').html(html);

            form.render('checkbox');  //重新渲染CheckBox，编辑和添加的时候
            $('#dataConsole,#dataList').attr('style', 'display:block'); //显示FiledBox

            laypage({
                cont: laypageId,
                pages: pages,
                groups: 8,
                skip: true,
                curr: currentIndex,
                jump: function (obj, first) {
                    var currentIndex = obj.curr;
                    if (!first) {
                        initilData(currentIndex, pageSize);
                    }
                }
            });
            //该模块是我定义的拓展laypage，增加设置页容量功能
            //laypageId:laypage对象的id同laypage({})里面的cont属性
            //pagesize当前页容量，用于显示当前页容量
            //callback用于设置pagesize确定按钮点击时的回掉函数，返回新的页容量
            pagesize(laypageId, pageSize).callback(function (newPageSize) {
                //这里不能传当前页，因为改变页容量后，当前页很可能没有数据
                initilData(1, newPageSize);
            });
        }, 500);
    }

    function pagesize(id, pageSize) {
        $('#' + id + ' .layui-laypage').append('<span class="laypage-extend-pagesize">&#x6bcf;&#x9875; <input type="number" min="1" onkeyup="this.value = this.value.replace(/\D/, \'\');" value="1" class="layui-laypage-skip" > &#x6761; <button type="button" class="layui-laypage-btn">&#x786e;&#x5b9a;</button></span>');
        $('#' + id + ' .laypage-extend-pagesize input[class=layui-laypage-skip]').val(pageSize);
        var pagesize = {
            btn: $('#' + id + ' .laypage-extend-pagesize .layui-laypage-btn'),
            callback: function (callback) {
                this.ok = callback;
            },
            ok: null
        };
        $(pagesize.btn).on('click', function () {
            pagesize.ok(pagesize.btn.siblings('input[class=layui-laypage-skip]').val());
        });
        return pagesize;
    }
    //监听置顶CheckBox
    form.on('checkbox(display_sign)', function (data) {
        var displaySign = '';
        var currentId = data.elem.value;
        if (!data.elem.checked) {
            displaySign = '';
        }
        else {
            displaySign = 'checked';
        }
        if(data.elem.checked){
            data.elem.checked = false;
        }else{
            data.elem.checked = true;
        }
        form.render();  //重新渲染
        var index = layer.load(1);

        setTimeout(function () {
            $.post(URL_UPDATEDISPLAY,{current_id:currentId,display_sign:displaySign},function (res) {
                layer.close(index);
                if(res == 'error'){
                    layer.msg('操作失败，返回原来状态');
                }else{
                    if(data.elem.checked){
                        data.elem.checked = false;
                    }else{
                        data.elem.checked = true;
                    }
                    form.render();  //重新渲染
                }
            });
        }, 300);
    });

    //监听推荐CheckBox
    form.on('checkbox(recommend)', function (data) {
        var index = layer.load(1);
        setTimeout(function () {
            layer.close(index);
            layer.msg('操作成功');
        }, 300);
    });
    //添加数据
    $('#addArticle').click(function () {
        var index = layer.load(1);
        setTimeout(function () {
            layer.close(index);
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['600px', '555px'], //宽高
                content: URL_CREATE,
            });
        }, 500);
    });
    exports('datalist', {});
});

function openEditPage(currentId) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['600px', '555px'], //宽高
        content: URL_EDIT + "/" + currentId
    });
}

function openDelete(currentId,Event) {
    var currentTrObj = $(Event).parent().parent();
    layer.confirm('确定删除？', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        $.post(URL_DELETEDATA,{current_id:currentId},function (res) {
            if(res == 'success'){
                layer.msg('删除Id为【' + currentId + '】的数据成功');
                currentTrObj.remove();
            }else{
                layer.msg('删除Id为【' + currentId + '】的数据失败');
            }
        });
    }, function () {
    });
}

function openUploadVideo(currentId) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['310px', '140px'], //宽高
        content: URL_UPLOADVEDIO + '/' + currentId,
        end:function () {
            //window.location = URL_CURRENT;
        }
    });
}

