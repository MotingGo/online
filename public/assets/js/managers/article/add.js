// 检测提交对象
function check_article(article) {

    if ('' == article.title){

        $msg = '标题不能为空';

    } else if ('1' != article.label_id && '2' != article.label_id){

        $msg = '请选择类型';

    } else if ('' == article.summary){

        $msg = '请填写简介';

    } else if ('' == article.content){

        $msg = '请填写主要内容';

    } else if ('' == article.attachment_id){

        $msg = '请上传附件';

    } else {
        return true;
    }

    layer.alert($msg,{icon:2});
    return false;
}

function check_changed(article, sourceArticle) {

    var result = {};

    for (var key in article){
        if (article[key] != sourceArticle[key]){
            result[key] = article[key];
        }
    }

    return result;
}