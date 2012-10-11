<!DOCTYPE HTML>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                float:left;
                display:inline;
                width:20px;
                height:20px;
                margin-left:10px;
                border:1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <?php
        if ($_GET['action'] == 'upfile' && $_FILES['photo']) {
            $file_path = pathinfo($_FILES['photo']['name']);
            $target_path = 'temp/' . time() . md5($file_path ['filename']) . '.' . $file_path ['extension'];
//测试函数:　move_uploaded_file
//也可以用函数：copy
            $target_path = iconv("UTF-8", "gb2312", $target_path);
            move_uploaded_file($_FILES['photo']['tmp_name'], $target_path);
            if (file_exists($target_path)) {
                if ($_SERVER["OS"] != "Windows_NT") {
                    @chmod($target_path, 0604);
                }
            } else {
                echo'<font color="red">Failed!</font>';
            }
        }
        ?>
        <div class="config">
            <table>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td class="left">选择图片:</td>
                    <td><form action="index.php?action=upfile" method="post" name="UForm" enctype="multipart/form-data" id="picform"><input type="file" name="photo" onchange="KISSY.DOM.get('#picform').submit();"/></form> </td>
                </tr>
                <form action="create.php" method="post">
                    <tr>
                        <td class="left">前景色:</td>
                        <td class="color-con">
                            <a href="javascript:void(0);" class="color" data:value="07C56A"></a>
                            <a href="javascript:void(0);" class="color" data:value="ff6700"></a>
                        </td>
                    </tr>
                    <tr >
                        <td class="left">主标题:</td>
                        <td><input type="text" name="title" id="title" value="输入标题"/></td>
                    </tr>
                    <tr>
                        <td class="left">副标题:</td>
                        <td><input type="text" name="des" id="des" value="输入文字"/></td>
                    </tr>
                    <tr>
                        <td class="left"></td>
                        <td>
                            <input type="hidden" value="" name="red" id="red"/>
                            <input type="hidden" value="" name="green" id="green"/>
                            <input type="hidden" value="" name="blue" id="blue"/>
                            <input type="hidden" value="<?php
        if ($_FILES['photo']) {
            echo $target_path;
        }
        ?>" name="filename" />
                            <input type="submit" value="生成" class="button orange"/>
                        </td>
                    </tr>
                </form>
            </table>
        </div>

        <div class="content">
            <div class="yulan">预览</div>
            <div class="pic">
                <div class="img">
                    <?php
                    if ($_FILES['photo']) {
                        echo '<img src="' . $target_path . '"/>';
                    } else {
                        echo '请先选择图片(170*150)...';
                    }
                    ?>
                </div>
                <div class="layer" style="background-color:#07C56A;">

                </div>
                <div class="info">
                    <div class="title" id="title-con">输入标题</div>
                    <div class="des" id="des-con">输入文字</div>
                </div>
            </div>

        </div>
        <script>
            var S=KISSY,DOM=S.DOM,Event=S.Event;
            Event.on("#title","keyup",function(){
               
                DOM.html("#title-con",this.value.substr(0,10))
            })
            Event.on("#title","focus",function(){
                if(this.value=="输入标题") this.value="";
            })
            Event.on("#des","focus",function(){
                if(this.value=="输入文字") this.value="";
            })
            Event.on("#des","keyup",function(){
                DOM.html("#des-con",this.value.substr(0,13))
            })
            var colors=DOM.query(".color");
            for(var i=0;i<colors.length;i++){
                colors[i].style.backgroundColor="#"+DOM.attr(colors[i],"data:value")
            }
            var hex2dec=function(hex){
                return parseInt(hex,16)
            }
            var color=DOM.attr(".color","data:value");
            DOM.get("#red").value=hex2dec(color.substr(0,2))
            DOM.get("#green").value=hex2dec(color.substr(2,2))
            DOM.get("#blue").value=hex2dec(color.substr(4,2))
            Event.on(".color","click",function(){
                DOM.css(".layer","backgroundColor","#"+DOM.attr(this,"data:value"))
                var color=DOM.attr(this,"data:value");
                DOM.get("#red").value=hex2dec(color.substr(0,2))
                DOM.get("#green").value=hex2dec(color.substr(2,2))
                DOM.get("#blue").value=hex2dec(color.substr(4,2))
            })

        </script>
    </body>
</html>
