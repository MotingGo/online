layui.use(['layedit','upload'], function(){
    var layer = layui.layer;
    var layedit = layui.layedit;


    var currentTr = null;
    var currentConfirmBoxIndex = null;

    layedit.build('MainContentID',{
        height:400
    }); //建立编辑器

    $('.edit-button').click(function () {

        var article = ArticleTr;

        article.setTrObject($(this.parentNode.parentNode));
        article.id = this.getAttribute('articleId').toString();

        var index = layer.load(1);

        setTimeout(function () {
            layer.close(index);
            layer.open({
                type: 2,
                area: ['700px', '555px'], //宽高
                content: URL_EDIT+"/" + article.id,
                end:function () {
                    $.ajax({
                        url:URL_GET + "/" + article.id,
                        type:'GET',
                        success:function (res) {

                            if ( ! (res instanceof Object) ){
                                return false;
                            } else if ('err' == res.status){
                                return false;
                            }
                            var trueArticle = res.data;
                            article.setThumbnail(trueArticle.thumbnail);
                            article.setTitle(trueArticle.title);
                            article.setSummary(trueArticle.summary);
                        }
                    })
                }
            });
        }, 500);
    });

    //添加数据
    $('#addArticle').click(function () {

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
                        url:URL_GET_NEW + '?display_at=' + ArticleEndDisplayAt,
                        success:function (res) {

                            if ( 'err' == res.status){
                                layer.alert("获取失败",{icon:2});
                                false;
                            } else {
                                create_article(res.data);
                                layer.msg("已添加", {icon: 1,time:1000});
                            }
                        }
                    })
                }
            });
        }, 500);
    });

    // 创建文章记录
    function create_article(data) {
        for (var key in data) {
            var newArticle = ArticleTr;
            newArticle.setTrObject(getNewArticleTr())
            newArticle.setThumbnail(data[key].thumbnail);
            newArticle.setId(data[key].id);
            newArticle.setTitle(data[key].title);
            newArticle.setSummary(data[key].summary);
        }
        if (0 != data.length){
            ArticleEndDisplayAt = data[key].display_at;
        }
    }

    // 获取新的文章行
    function getNewArticleTr() {
        // // 添加tr/行
        var dataContent = $('#dataContentBodyId');
        dataContent.prepend($('.article-tr')[0].outerHTML);
        return dataContent.children().first();
    }

    // 定义按钮的点击事件
    $('#searchButtonId').click(function () {
        window.location.href = URL_LOCAL + '?keyword=' + $('#searchKeywordId').val();
    });

    $('.delete-button').click(function () {

        currentTr = $(this).parent().parent();
        var currentArticleId = $(this).attr('articleid');

        currentConfirmBoxIndex = layer.confirm('需要删除？', {
            btn: ['是的','取消'] //按钮
        }, function(){
            $.ajax({
                url:URL_DELETE,
                type:'DELETE',
                data:{
                    id:currentArticleId,
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
                    layer.msg('已刪除');
                }
            });
        }, function(){
            layer.close(currentConfirmBoxIndex);
        });
    });
});