layui.use(['layer'], function(){
    var layer = layui.layer;

    $('.edit-button').click(function () {

        var note = NoteTr;

        note.setTrObject($(this.parentNode.parentNode));
        note.id = this.getAttribute('noteId').toString();

        var index = layer.load(1);

        setTimeout(function () {
            layer.close(index);
            layer.open({
                type: 2,
                area: ['700px', '555px'], //宽高
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
                area: ['700px', '555px'], //宽高
                content: URL_ADD,
                end:function () {
                    $.ajax({
                        type:'GET',
                        url:URL_GET_NEW + '?display_at=' + NoteEndDisplayAt,
                        success:function (res) {

                            if ( 'err' == res.status){
                                layer.alert("获取失败",{icon:2});
                            } else {
                                create_note(res.data);
                                layer.msg("已创建", {icon: 1,time:1000});
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
            newNote.setContent(data[key].thumbnail);
            newNote.setDisplayAt(data[key].thumbnail);
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
});