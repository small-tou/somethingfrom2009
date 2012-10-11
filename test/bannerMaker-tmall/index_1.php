<!DOCTYPE HTML>
<html>
    <head>
        <title>bannerMaker(淘宝商城banner工具)</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="http://a.tbcdn.cn/??s/kissy/1.1.6/kissy-min.js,p/global/1.0/global-min.js?t=2011062920110301.js"></script>

        <style>
            body{
                font-size:12px;
            }
            th {
                background: #328AA4  ;

                height:3px;
            }
            td{
                background: #E5F1F4;
                height:30px;
                padding:5px;
            }
            .config{
                float:left;
            }
            .config .left{
                text-align: right;
                padding-left:50px;
            }

            input[type="text"] {
                border:1px solid #aaa;
                height:22px;
            }
            .button {
                display: inline-block;
                outline: none;
                cursor: pointer;
                text-align: center;
                text-decoration: none;
                font: 14px/100% Arial, Helvetica, sans-serif;
                padding: .5em 2em .55em;
                text-shadow: 0 1px 1px rgba(0,0,0,.3);
                -webkit-border-radius: .5em;
                -moz-border-radius: .5em;
                border-radius: .3em;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
                box-shadow: 0 1px 2px rgba(0,0,0,.2);
            }
            .button:hover {
                text-decoration: none;
            }
            .button:active {
                position: relative;
                top: 1px;
            }
            .orange {
                color: #fff;
                font-weight:bold;
                border: solid 1px #da7c0c;
                background: #f78d1d;
                background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
                background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
            }
            .orange:hover {
                background: #f47c20;
                background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
                background: -moz-linear-gradient(top,  #f88e11,  #f06015);
                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
            }
            .orange:active {
                color: #fcd3a5;
                background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
                background: -moz-linear-gradient(top,  #f47a20,  #faa51a);
                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
            }
            .content{
                float:left;
                margin-left:40px;
                width:170px;
                height:190px;
                border:1px solid #f3f3f3;
                padding:20px;
                padding-top:10px;
            }
            .content .yulan{
                font-size:14px;
                font-weight:bold;
                padding-bottom:20px;
            }
            .content .pic, .content .img,.content .img img{
                width:170px;
                height:150px;
                position: relative;
            }
            .content .layer{
                opacity:0.75;
                height:50px;
                overflow:hidden;
                position:absolute;
                bottom:0;
                left:0;
                width:170px;
            }
            .content .info{
                height:50px;
                overflow:hidden;
                position:absolute;
                bottom:0;
                left:0;
                width:170px;
            }
            .content .title{
                margin:10px 0 0 10px;
                font-size:14px;
                font-weight:bold;
                color:#fff;
            }
            .content .des{
                margin:0px 0 0 10px;
                font-size:12px;
                color:#fff;
                margin-top:2px;
                opacity:0.75;
            }
            .color-con{

            }
            .color-con a{

                display:inline-block;
                width:20px;
                height:20px;
                margin-left:10px;
                border:2px solid #ddd;
            }
            .color-con div{
            }
            .color-con .selected{
                border:2px solid #111;
            }
            body{
                margin:0;
                padding:0;
            }
            #browser{
                width:100%;
                height:50px;
                background: #fafafa;

                color:#333;
                font-size:14px;
                line-height:50px;
                border-bottom:5px solid #7EE992;
                margin-bottom:20px;

            }
            #browser a, #browser a:visited{

                color:#ff6700;
                font-size:14px;
                margin-left:10px;
                font-weight:bold;
            }
            #browser span{
                padding-left:20px;
            }
            #logo{
                height:90px;
                line-height:80px;
                font-size:40px;
                font-family: 微软雅黑,Arial;
                font-weight:bold;
                text-shadow:#aaa 1px 1px 2px;
                color: #333; /* 为较旧的或者不支持的浏览器设置备用属性 */
                -webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,0)), to(rgba(0,0,0,1)));
                position:relative;
            }
            #help{
                position:absolute;
                left:450px;
                bottom:10px;
                font-size:14px;
                height:20px;
                line-height:20px;
            }

        </style>

    </head>
    <body>
        <div id="browser" style="display:none;">
            <span>本应用只支持以下浏览器,请更新后再使用,谢谢您对前端事业的支持!</span>
            <a href="http://www.google.com/chrome?hl=zh-cn" >Google浏览器</a>
            <a href="http://firefox.com.cn/download/" >最新版的火狐浏览器</a>
            <a href="http://cn.opera.com/browser/download/" >最新版的Opera浏览器</a>
        </div>
        <div id="logo">
            bannerMaker-simple
            <div id="help">有问题请联系旺旺id : 天祁</div>
        </div>
        <div class="config">
            <table>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td class="left">选择图片(170*150):</td>
                    <td><input type="file" name="photo" id="getfile"/> </td>
                </tr>

                <tr>
                    <td class="left">前景色:</td>
                    <td class="color-con">
                        <div>
                            <a href="javascript:void(0);" class="color selected" data-value="e98587" ></a>
                            <a href="javascript:void(0);" class="color " data-value="f09a84" ></a>
                            <a href="javascript:void(0);" class="color " data-value="8f8fbe" ></a>
                            <a href="javascript:void(0);" class="color " data-value="b68bb4" ></a>
                            <a href="javascript:void(0);" class="color " data-value="ed9dad" ></a>

                        </div>
                        <div>
                            <a href="javascript:void(0);" class="color " data-value="4378b6" ></a>
                            <a href="javascript:void(0);" class="color " data-value="62629f" ></a>
                            <a href="javascript:void(0);" class="color " data-value="744283" ></a>
                            <a href="javascript:void(0);" class="color " data-value="362270" ></a>
                            <a href="javascript:void(0);" class="color" data-value="4a005c"></a>
                        </div>
                        <div>
                            <a href="javascript:void(0);" class="color " data-value="9e5e64" ></a>
                            <a href="javascript:void(0);" class="color " data-value="b06258" ></a>
                            <a href="javascript:void(0);" class="color " data-value="b47551" ></a>
                            <a href="javascript:void(0);" class="color " data-value="a7925d" ></a>
                            <a href="javascript:void(0);" class="color" data-value="95a967"></a>
                        </div>
                        <div>
                            <a href="javascript:void(0);" class="color " data-value="64527f" ></a>
                            <a href="javascript:void(0);" class="color " data-value="88466c" ></a>
                            <a href="javascript:void(0);" class="color " data-value="d2aea8" ></a>
                            <a href="javascript:void(0);" class="color " data-value="d3ad9a" ></a>
                            <a href="javascript:void(0);" class="color" data-value="9999b0"></a>
                        </div>
                        <div>
                            <a href="javascript:void(0);" class="color " data-value="aca0b2" ></a>
                            <a href="javascript:void(0);" class="color " data-value="6a5161" ></a>
                            <a href="javascript:void(0);" class="color " data-value="eaeaea" ></a>
                            <a href="javascript:void(0);" class="color" data-value="0089be"></a>
                        </div>
                    </td>
                </tr>
                <tr >
                    <td class="left">主标题:</td>
                    <td><input type="text" name="title" id="title"/></td>
                </tr>
                <tr>
                    <td class="left">副标题:</td>
                    <td><input type="text" name="des" id="des"/></td>
                </tr>
                <tr>
                    <td class="left"></td>
                    <td>
                        <form action="create_1.php" method="post" >
                            <input type="hidden" value="" name="image_data" id="image_data"/>
                            <input type="submit" value="生成" class="button orange"/>
                        </form>
                    </td>
                </tr>

            </table>
        </div>

        <div class="content">
            <div class="yulan">预览()</div>
            <div class="pic">
                <div id="img_con">
                    <canvas id="canvas" width="170" height="150">

                    </canvas>
                </div>
            </div>

        </div>
        <script>
            if(typeof(FileReader)=="undefined"){
                document.getElementById("browser").style.display="block"
            }
        </script>
        <script>
           
            var BannerMaker=function(){
                var bgColor="",
                title="请输入标题",
                des="请输入副标题",
                img=document.createElement("img"),
                can,
                ctx
                
                var S=KISSY,DOM=S.DOM,Event=S.Event;
                var $=DOM.get
                
                var now;

                var hex2dec=function(hex){
                    return parseInt(hex,16)
                }
                var html2rgba=function(html,alpha){
                    var rgba="rgba("
                    for(var i=0;i<3;i++){
                        rgba+=hex2dec(html.substr(i*2,2))+","
                    }
                    rgba+=alpha+")"
                    return rgba;
                }
                return{
                    init:function(){
                        now=this;
                        can=DOM.get("#canvas");
                        ctx=can.getContext('2d');
                        $("#getfile").addEventListener("change", this.handleFiles, false);
                        bgColor=html2rgba(DOM.attr(DOM.get(".color"),"data-value"),0.75)
                        var colors=DOM.query(".color");
                        for(var i=0;i<colors.length;i++){
                            colors[i].style.backgroundColor="#"+DOM.attr(colors[i],"data-value")
                        }
                        Event.on("#title","keyup",function(){
                            title=this.value.substr(0,10)
                            now.update();
                        })
                        Event.on("#des","keyup",function(){
                            des=this.value.substr(0,13)
                            now.update();
                        })
                        Event.on(".color","click",function(){
                            DOM.css(".layer","backgroundColor","#"+DOM.attr(this,"data-value"))
                            DOM.removeClass(".color","selected")
                            DOM.addClass(this,"selected")
                            bgColor=html2rgba(DOM.attr(this,"data-value"),0.75)
                            now.update();
                        })
                        img.src="data:image/png;base64,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"
                        img.onload=function(){
                            now.update();
                        }
                        
                    },
                    handleFiles:function(){
                        var files = this.files;
                        for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            var imageType = /image.*/;
                            if (!file.type.match(imageType)) {
                                continue;
                            }
                            img = document.createElement("img");
                            img.onload=function(){
                                now.update();
                            }
                            var reader = new FileReader();
                            reader.onload = (function(aImg){
                                return function(e){
                                    console.log(e.target.result)
                                    aImg.src = e.target.result;
                                };
                            })(img);
                            reader.readAsDataURL(file);
                        }
                    },
                    drawImg:function(){
                        var w=img.width,h=img.height,x=0,y=0
                        if(img.width/img.height>can.width/can.height){
                            y=0;h=img.height;
                            var zoom=h/can.height;
                            w=zoom*can.width;
                            x=(img.width-w)/2
                        }else if(img.width/img.height<can.width/can.height){
                            x=0;w=img.width;
                            var zoom=w/can.width;
                            h=zoom*can.height;
                            y=(img.height-h)/2;
                        }
                        img&&ctx.drawImage(img,x,y,w,h,0,0,can.width,can.height);
                    },
                    drawBG:function(){
                        ctx.fillStyle =bgColor;
                        ctx.fillRect(0,100,170,50);
                    },
                    drawText:function(){
                        ctx.fillStyle = "rgb(255,255,255)";
                        ctx.font = 'bold 14px/1.5 tahoma,arial,宋体';
                        ctx.fillText(title, 10, 123 );
                        ctx.fillStyle = "rgba(255,255,255,0.75)";
                        ctx.font = 'normal 12px/1.5 tahoma,arial,宋体';
                        ctx.fillText(des, 10, 140 );
                    },
                    clear:function(){
                        ctx.clearRect(0,0,can.width,can.height)
                    },
                    update:function(){
                        this.clear();
                        this.drawImg();
                        this.drawBG();
                        this.drawText();
                        $("#image_data").value=can.toDataURL();
                    }
                }
            }();

            BannerMaker.init()
        </script>
    </body>
</html>
<script>
    //等比缩放。
    //can是canvas元素，ctx是canvas.getContext()，img是图片元素
    var w=img.width,h=img.height,x=0,y=0
    if(img.width/img.height>can.width/can.height){
        y=0;h=img.height;
        var zoom=h/can.height;
        w=zoom*can.width;
        x=(img.width-w)/2
    }else if(img.width/img.height<can.width/can.height){
        x=0;w=img.width;
        var zoom=w/can.width;
        h=zoom*can.height;
        y=(img.height-h)/2;
    }
    img&&ctx.drawImage(img,x,y,w,h,0,0,can.width,can.height);
</script>