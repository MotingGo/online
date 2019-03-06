//cookie操作
var cookie={
    set:function(key,value,fenzhong){
        //document.cookie=key+"="+encodeURI(value,"utf-8");
        value=encodeURI(value,"utf-8");
        var d = new Date();
        d.setTime(d.getTime() + (fenzhong*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = key + "=" + value + "; " + expires;
    },
    get:function(key){
        var cookies=document.cookie;
        var cookeArray=cookies.split(";");
        for(var i=0;i<cookeArray.length;i++){
            var cooke=cookeArray[i].trim();
            var index=cooke.indexOf("=");
            var keyre=cooke.substring(0,index);
            if(keyre==key){
                var value=cooke.substring(index+1);
                return decodeURI(value);
            }
        }
    },
    del:function(name){
        cookie.set(name,"",-1);
    }
}
//头部导航条点击之后,保留颜色
function clickTitle(ob){
    var $=layui.jquery;
    var ind=$(ob).parent().index();
    cookie.set("titleIndex",ind,0.5);
}
layui.use([ 'layer', 'util', 'form'], function () {
    var $ = layui.jquery;


    //侧边导航开关点击事件
    $('.blog-navicon').click(function () {
        var sear = new RegExp('layui-hide');
        if (sear.test($('.blog-nav-left').attr('class'))) {
            leftIn();
        } else {
            leftOut();
        }
    });
    //侧边导航遮罩点击事件
    $('.blog-mask').click(function () {
        leftOut();
    });
    //blog-body和blog-footer点击事件，用来关闭百度分享和类别导航
    $('.blog-body,.blog-footer').click(function () {

        categoryOut();
    });
    //类别导航开关点击事件
    $('.category-toggle').click(function (e) {
        e.stopPropagation();    //阻止事件冒泡
        categroyIn();
    });
    //类别导航点击事件，用来关闭类别导航
    $('.article-category').click(function () {
        categoryOut();
    });
    //具体类别点击事件
    $('.article-category > a').click(function (e) {
        e.stopPropagation(); //阻止事件冒泡
    });

    //显示侧边导航
    function leftIn() {
        $('.blog-mask').unbind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
        $('.blog-nav-left').unbind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');

        $('.blog-mask').removeClass('maskOut');
        $('.blog-mask').addClass('maskIn');
        $('.blog-mask').removeClass('layui-hide');
        $('.blog-mask').addClass('layui-show');

        $('.blog-nav-left').removeClass('leftOut');
        $('.blog-nav-left').addClass('leftIn');
        $('.blog-nav-left').removeClass('layui-hide');
        $('.blog-nav-left').addClass('layui-show');
    }
    //隐藏侧边导航
    function leftOut() {
        $('.blog-mask').on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $('.blog-mask').addClass('layui-hide');
        });
        $('.blog-nav-left').on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $('.blog-nav-left').addClass('layui-hide');
        });

        $('.blog-mask').removeClass('maskIn');
        $('.blog-mask').addClass('maskOut');
        $('.blog-mask').removeClass('layui-show');

        $('.blog-nav-left').removeClass('leftIn');
        $('.blog-nav-left').addClass('leftOut');
        $('.blog-nav-left').removeClass('layui-show');
    }
    //显示类别导航
    function categroyIn() {
        $('.category-toggle').addClass('layui-hide');
        $('.article-category').unbind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');

        $('.article-category').removeClass('categoryOut');
        $('.article-category').addClass('categoryIn');
        $('.article-category').addClass('layui-show');
    }
    //隐藏类别导航
    function categoryOut() {
        $('.article-category').on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $('.article-category').removeClass('layui-show');
            $('.category-toggle').removeClass('layui-hide');
        });

        $('.article-category').removeClass('categoryIn');
        $('.article-category').addClass('categoryOut');
    }
    //定位显示过的标题
    $(function(){
        var ind=cookie.get("titleIndex");
        if(typeof(ind)=="undefined"){
            ind=0;
        }
        $("#title-nav").find('a').eq(ind).attr("style","color: #45B6F7;");
    });
});

