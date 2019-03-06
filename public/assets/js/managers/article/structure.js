var ArticleTr = {
    trObject:null, // 行对象
    // 基本属性
    id:null,
    title:null,
    thumbnail_id: null,
    thumbnail:null,
    label_id:null,
    label:null,
    summary:null,
    content:null,
    // 单元格组
    tds:null,
    // 缩略图-对象
    thumbnailObject:null,
    // 标题-对象
    titleObject:null,
    // 简介-对象
    summaryObject:null,
    // 操作按钮
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


        this.thumbnailObject = this.tds[0].children().first().children().first();

        var childTrTitle = this.tds[1].children('table').first().children('tbody').children().first();

        var childTrSummary = childTrTitle.next();


        this.titleObject = childTrTitle.children().first().next();
        this.summaryObject = childTrSummary.children().first().next();


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

    getThumbnail:function(){
        if (this.thumbnail == null){
            this.thumbnail = this.thumbnailObject.css('background-image').toString();

            this.thumbnail = this.thumbnail.substr(5, this.thumbnail.length - 5 - 2);
        }
        return this.thumbnail;
    },
    setThumbnail:function(thumbnailUrl){
        this.thumbnailObject.css('background-image', 'URL("' + thumbnailUrl + '")');
        this.thumbnail = thumbnailUrl;
    },

    getTitle:function () {
        if (this.title == null){
            this.title = this.titleObject.html()
        }
        return this.title;
    },
    setTitle:function (title) {
        this.titleObject.html(title);
        this.title = title;
    },

    getSummary:function () {
        if (this.summary == null){
            this.summary = this.summaryObject.html()
        }
        return this.summary;
    },
    setSummary:function (summary) {
        this.summaryObject.html(summary);
        this.summary = summary;
    },

    getLabelId:function () {
        return this.label_id;
    },
    setLabelId:function (labelId) {
        this.label_id = labelId;
    },
    getLabel:function () {
        return this.label_id==1?'原创':'转载';
    },

    getContent:function () {
        return this.content;
    },
    setContent:function (content) {
        this.content = content;
    }
};
