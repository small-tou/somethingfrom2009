<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="index.css"/>
        <script src="core.js"></script>
        <script src="base.js?ssD"></script>
        <script src="json2.js"></script>
        <style>
            body,html{
                background:#eee;
                padding:0;
                margin:0;
                font-family: Georgia,"微软雅黑","黑体";
                font-size:12px;
                color:#404040;
            }
            a,a:visited{
                color:#0E8CEE;
            }
            a,img{
                border:none;
            }
            #content{

            }
            #header{
                height:80px;
                background: #555;
                border-bottom:5px solid #9ED859;
            }
            h1{
                margin:0;

            }
            #header h1{
                color:#fff;
                padding-top:25px;
                padding-left:50px;
                float:left;
                font-size:35px;
            }
            #header .description{
                margin-top:29px;
                padding-left:50px;
                color:#eee;
                font-size:18px;
                float:left;
                padding-top:10px;
            }
            #header .description span{
                font-size:14px;
                color:#D6ECBC;
                font-weight: normal;

            }

            .note{
                min-height:35px;
                margin:10px;
                background: #fff;
                border-radius:5px;
                line-height:35px;
                padding-left:10px;
            }
            em{
                font-style: normal;
                font-size:12px;
            }
            em.title{
                color:#72B522;
                padding:0 2px;
                font-weight: bold;
            }
            em.num{
                color:#ff6700;
                padding:0 2px;
            }
            em.name{
                color:#666;
                padding:0 2px;
            }
            em.white{
                color:#fff;
                padding:0 2px;
                font-size:14px;
            }
            em.gray{
                color:#999;
            }
            .line{
                height:3px;

                font-size:0px;
                line-height: 0px;
                overflow:hidden;
                background:#9ED859;
                margin:10px;
            }
            .main-container{
                margin:10px;
            }
            ul,li{
                list-style: none;
                padding:0;
                margin:0;

            }
            .main-container li{
                width:23%;
                background:#fff;
                border-radius:5px;
                height:240px;

                float:left;
                display: inline;
                margin-right:2.1%;
                overflow: hidden;
                margin-bottom:20px;
            }
            .main-container li .bd{
                overflow: auto;
                height:200px;
                padding:5px;
            }
            .main-container li .item{
                height:25px;
                border-radius:3px;
                background:#f7f7f7;
                line-height:25px;
                padding-left:10px;
                margin-bottom:5px;
            }
            .main-container li .hd{
                height:30px;
                line-height:30px;
                padding-left:10px;
                background: #C1EC8F;
                font-weight:bold;
            }
            body{
                width:310px;
            }
            .index{
                display: inline-block;
                width:40px;
                text-align: right;
                padding-right:20px;
            }
            #title{
                height:15px;
                width:190px;
            }
            #folder{
                width:195px;
                height:22px;
            }
            .allstar {
                display: inline-block;
                width: 128px;
                height: 11px;
                position: relative;
                margin-right: 5px;
                background: url(star.gif);
                overflow: hidden;
                white-space: nowrap;
                z-index: 1;
            }
            .allstar em {
                position: absolute;
                left: 0;
                top: 0;
                display: inline-block;
                height: 11px;
                background: url(star.gif) 0 -11px;
            }
            .allstar b {
                position: relative;
                display: inline-block;
                width: 13px;
                height: 11px;
                cursor: pointer;
                cursor: hand;
                z-index: 1;
            }
            #help{
                display: inline-block;
                width:20px;
                float:right;
                height:20px;
                padding-top:3px;
            }
            button{
                float:right;
                width:80px;
                height:30px;
                margin-right:10px;
                margin-top:3px;
            }
            #help_layer{
                display:none;
            }
            #update{
                display:none;
            }
        </style>
    </head>
    <body>
        <div class="note">
            <div><label class="index">名称:</label><input type="text" value="" id="title"/></div>
            <div><label class="index">文件夹:</label><select id="folder"></select></div>
        </div>
        <div class="note"><label class="index">打分:</label><span id="grade" class="allstar"><em id="score" style="width: 0%; "></em><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b></span><span id="score_text">请打分</span><span id="help"><img src="help.png" width="16" height="16"/></span></div>
        <input type="hidden" id="score_result" value="0"/>
        <div class="note" id="help_layer">help!</div>
        <div class="note"><button id="update">更 新</button><button id="add">添 加</button><button id="rescore">重新打分</button></div>
    </body>
</html>
<script>
    var $=MJ,D=$.Dom,E=$.Event

   
    chrome.bookmarks.getTree(function(tree){
        FavorPlus.tree=tree
        chrome.tabs.getSelected(undefined, function(tab){

            FavorPlus.title=tab.title
            FavorPlus.url=tab.url
            FavorPlus.init();
        })
    })



</script>