var NoteTr = {
    trObject:null,
    id:null,
    displayAt:null,
    content:null,
    tdsObject:null,
    displayAtObject:null,
    contentObject:null,
    editButtonObject:null,
    deleteButtonObject:null,
    /**
     * 通过jquery的Dom操作获取目标对象
     * @param oneObject
     */
    setTrObject:function(oneObject){
        this.trObject = oneObject;

        this.tds = [];
        this.tds[0] = this.trObject.children().first();
        this.tds[1] = this.tds[0].next();
        this.tds[2] = this.tds[1].next();

        this.editButtonObject = this.tds[2].children().first();
        this.deleteButtonObject = this.editButtonObject.next();


        this.displayAtObject = this.tds[0];

        this.contentObject = this.tds[1];
    },
    setId:function(id){
        this.editButtonObject.attr('articleId', id);
        this.deleteButtonObject.attr('articleId', id);
        this.id = id;
    },
    getId:function(){
        if (null == this.id){
            this.id = this.editButtonObject.attr('articleId');
        }
        return this.id;
    },
    getContent:function () {
        if (null == this.content){
            this.content = this.contentObject.html();
        }
        return this.content;
    },
    setContent:function (content) {
        this.contentObject.html(content);
        this.content = content;
    },
    getDisplayAt:function () {
        if (null == this.displayAt){
            this.displayAt = DatetimeToStamp(this.displayAtObject.html());
        }
        return this.displayAt;
    },
    setDisplayAt:function (displayAt) {
        this.displayAtObject.html(TimeStampToMyDate(displayAt))
        this.displayAt = displayAt;
    }
};
/**
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

/**
 * @return {number}
 */
function DatetimeToStamp(datetime) {

    return Date.parse(datetime)
}