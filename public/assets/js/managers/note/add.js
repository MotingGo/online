// 检测提交对象
function check_article(article) {

    if ('' == article.content){

        $msg = '请输入内容';

    } else {
        return true;
    }
    layer.alert($msg, {icon: 2});
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