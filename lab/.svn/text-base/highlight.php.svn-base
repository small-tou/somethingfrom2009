<!DOCTYPE html>
<!--
To change this template, choose Tools | Templates
@time
@author
-->
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script>
            var getHref=function(){
                var href=window.location.href;
                href=href.replace(/(.*\/.*?\/).*?\/[^\/]*$/,"$1")
                return href
            }
            console.log(getHref())
            var   MJBASEURL=getHref(),
            CACHE=true,
            DEBUG=true
        </script>
        <script src="../core.js"></script>
        <style>
            *{
                font-size:12px;
                font-family: "Consolas", "Bitstream Vera Sans Mono", "Courier New", Courier, monospace !important;
            }
            .keyword{
                color:#069;
                font-weight:bold;
            }
            .tab{
                padding-left:30px;
            }
            .string{
                color:blue;
            }
            .blank{
                padding-left:8px;
            }
            .quo{
                color:blue;
                font-weight:bold;
            }
            .note{
                color:#008200 !important;
            }
            .reg{
                color:#0886f5;
            }
            .number{
                color:#52ac52;
                font-weight:bold;
            }
        </style>
    </head>
    <body>
        <pre id="code" class="brush">
/*
 * 提取当前hostname的domain.domain;
 * 默认返回当前hostname的第一层父级域，如 www.xyx.taobao.com -> xyz.taoboa.com，store.taobao.com - > taobao.com
 * 可传递一个参数n，指定取n级的父级域，如n=2, 则www.xyx.taobao.com -> taoboa.com
 * 如果hostname本身只有二级域，或参数n过大，则总是返回二级域
 *
 * 注意：类似sina.com.cn这样带国家区域的域名可能有误。
 *
 * @method pickDocumentDomain
 * @return expected document.domain value
 */
pickDocumentDomain: function() {
	var host = arguments[1] || location.hostname;
	var da = host.split('.'), len = da.length;
	var deep = arguments[0]|| (len<3?0:1);
              	if (deep>=len || len-deep<2)
		deep = len-2;
	return da.slice(deep).join('.');
}
        </pre>
        <pre class="brush: js; auto-links: true; collapse: false; first-line: 1; gutter: true; html-script: false; light: false; ruler: false; smart-tabs: true; tab-size: 4; toolbar: true;">
var $=MJ
    var KEYWORD=["break","false","in","this","void","continue","for","new","true","while","delete","function","null","typeof","with","else","if","return","var",
        "case","debugger","export","super","catch","default","extends","switch","class","do","finally","throw","const","enum","import","try","begin","end","def"]
    var regStr=""
    var reg=new RegExp(regStr,"g")

    var dealWork=function(){
        var nowIndex=0;//当前正在处理的字符的索引,在处理引号之类的这个变量可能会跳跃增加而不是递增.
        var lastIndex=0;//上一次发生拆分的字符索引,本次拆分从这里开始,拆分完后更新此变量
        return {
            source:"",
            result:[],
            keyword:[],
            begin:function(){
                nowIndex=0;
                lastIndex=0;
                for(nowIndex =0;nowIndex&lt;this.source.length;){
                    
                    switch (this.source.charAt(nowIndex)) {
                        case "/":this.dealNote("");
                            break;
                        case "\"":this.dealQuo("\"");
                            break;
                        case "\'":this.dealQuo("\'");
                            break;
                        case "\n":this.dealLine();
                            break;
                        default:this.deal();break;
                    }
                }
                this.result.push(this.source.substring(lastIndex,this.source.length))
            },
            dealNote:function(mark){
                var index=nowIndex,className="note"
                nowIndex++;
                var secChar=this.source.charAt(nowIndex)
                if(secChar=="*"){
                    while((!(this.source.charAt(++nowIndex)=="*"&&this.source.charAt(nowIndex+1)=="/"))&&nowIndex&lt;this.source.length){}
                    nowIndex++
                }else if(secChar=="/"){
                    while(this.source.charAt(++nowIndex)!="\n"&&nowIndex&lt;this.source.length){}
                    nowIndex--
                }else{
                    while(this.source.charAt(++nowIndex)!="/"&&nowIndex&lt;this.source.length){}
                    className="reg"
                }
                nowIndex++
                this.result.push(this.source.substring(lastIndex,index))
                this.result.push("&lt;span class=\""+className+"\"&gt;"+this.source.substring(index,nowIndex).replace(/\n/g,"&lt;br/&gt;")+"&lt;/span&gt;")
                lastIndex=nowIndex
                
            },
            dealQuo:function(mark){
                var index=nowIndex
                //包含对转义的处理
                while((!(this.source.charAt(++nowIndex)==mark&&this.source.charAt(nowIndex-1)!="\\"))&&nowIndex&lt;this.source.length){}
                nowIndex++
                this.result.push(this.source.substring(lastIndex,index))
                this.result.push("&lt;span class=\"quo\"&gt;"+this.source.substring(index,nowIndex)+"&lt;/span&gt;")
                lastIndex=nowIndex
            },
            dealLine:function(){
                var index=nowIndex
                this.result.push(this.source.substring(lastIndex,index))
                
                this.result.push("&lt;br/&gt;")
                lastIndex=++nowIndex
            },
            deal:function(){
                var index=nowIndex,className="";
                var c=this.source.charAt(nowIndex);
                if(/\s/.test(c)){
                    className="blank";
                    nowIndex++;
                    this.result.push(this.source.substring(lastIndex,index));
                    this.result.push("&lt;span class=\""+className+"\"&gt;&lt;/span&gt;");
                    lastIndex=nowIndex;
                }else if(/[a-zA-Z_]/.test(c)){
                    while(/[a-zA-Z_]/.test(this.source.charAt(++nowIndex))&&nowIndex&lt;this.source.length){}
                    this.result.push(this.source.substring(lastIndex,index))
                    var str=this.source.substring(index,nowIndex)
                    if(this.keyword.has(str)){
                        str="&lt;span class=\"keyword\"&gt;"+str+"&lt;/span&gt;"
                    }
                    this.result.push(str)
                    lastIndex=nowIndex
                }else{
                    nowIndex++
                }
                
            }
        }
    }();


    $.use("base",function(){
        var Dom=$.Dom,Event=$.Event;
        var pres=Dom.query("pre"),eles=[]
        dealWork.keyword=KEYWORD;
        pres.each(function(i){
            if(i.className.indexOf("brush")!=-1){
                eles.push(i)
            }
        })
        eles.each(function(i){
            var code=i.innerHTML;

            dealWork.source=code
            dealWork.result=[]
            dealWork.begin();
            code=dealWork.result;
            code=code.join("")
            var ele=document.createElement("div");
            ele.innerHTML=code;
            ele.className="code";
            
            i.parentNode.replaceChild(ele,i)
            var source=document.createElement("a");
            source.innerHTML="点击查看源代码"
            source.data=i.innerHTML;
            source.onclick=function(){
                var w=window.open("","","width=600,height=400");
                var d=w.document
                d.open();
                d.write("&lt;textarea style='width:100%;height:100%;'&gt;"+this.data+"&lt;/textarea&gt;");
                d.close();
            }
           ele.parentNode.insertBefore(source,ele)
        })
    });
        </pre>
    </body>
</html>
<script>
    var $=MJ
    var KEYWORD=["break","false","in","this","void","continue","for","new","true","while","delete","function","null","typeof","with","else","if","return","var",
        "case","debugger","export","super","catch","default","extends","switch","class","do","finally","throw","const","enum","import","try","begin","end","def"]
    var regStr=""
    var reg=new RegExp(regStr,"g")

    var dealWork=function(){
        var nowIndex=0;//当前正在处理的字符的索引,在处理引号之类的这个变量可能会跳跃增加而不是递增.
        var lastIndex=0;//上一次发生拆分的字符索引,本次拆分从这里开始,拆分完后更新此变量
        return {
            source:"",
            result:[],
            keyword:[],
            begin:function(){
                nowIndex=0;
                lastIndex=0;
                for(nowIndex =0;nowIndex<this.source.length;){
                    
                    switch (this.source.charAt(nowIndex)) {
                        case "/":this.dealNote("");
                            break;
                        case "\"":this.dealQuo("\"");
                            break;
                        case "\'":this.dealQuo("\'");
                            break;
                        case "\n":this.dealLine();
                            break;
                        default:this.deal();break;
                    }
                }
                this.result.push(this.source.substring(lastIndex,this.source.length))
            },
            dealNote:function(mark){
                var index=nowIndex,className="note"
                nowIndex++;
                var secChar=this.source.charAt(nowIndex)
                if(secChar=="*"){
                    while((!(this.source.charAt(++nowIndex)=="*"&&this.source.charAt(nowIndex+1)=="/"))&&nowIndex<this.source.length){}
                    nowIndex++
                }else if(secChar=="/"){
                    while(this.source.charAt(++nowIndex)!="\n"&&nowIndex<this.source.length){}
                    nowIndex--
                }else{
                    while(this.source.charAt(++nowIndex)!="/"&&nowIndex<this.source.length){}
                    className="reg"
                }
                nowIndex++
                this.result.push(this.source.substring(lastIndex,index))
                this.result.push("<span class=\""+className+"\">"+this.source.substring(index,nowIndex).replace(/\n/g,"<br/>")+"</span>")
                lastIndex=nowIndex
                
            },
            dealQuo:function(mark){
                var index=nowIndex
                //包含对转义的处理
                while((!(this.source.charAt(++nowIndex)==mark&&this.source.charAt(nowIndex-1)!="\\"))&&nowIndex<this.source.length){}
                nowIndex++
                this.result.push(this.source.substring(lastIndex,index))
                this.result.push("<span class=\"quo\">"+this.source.substring(index,nowIndex)+"</span>")
                lastIndex=nowIndex
            },
            dealLine:function(){
                var index=nowIndex
                this.result.push(this.source.substring(lastIndex,index))
                
                this.result.push("<br/>")
                lastIndex=++nowIndex
            },
            deal:function(){
                var index=nowIndex,className="";
                var c=this.source.charAt(nowIndex);
                if(/\s/.test(c)){
                    className="blank";
                    nowIndex++;
                    this.result.push(this.source.substring(lastIndex,index));
                    this.result.push("<span class=\""+className+"\"></span>");
                    lastIndex=nowIndex;
                }else if(/[a-zA-Z_]/.test(c)){
                    while(/[a-zA-Z_]/.test(this.source.charAt(++nowIndex))&&nowIndex<this.source.length){}
                    this.result.push(this.source.substring(lastIndex,index))
                    var str=this.source.substring(index,nowIndex)
                    if(this.keyword.has(str)){
                        str="<span class=\"keyword\">"+str+"</span>"
                    }
                    this.result.push(str)
                    lastIndex=nowIndex
                }else{
                    nowIndex++
                }
                
            }
        }
    }();


    $.use("base",function(){
        var Dom=$.Dom,Event=$.Event;
        var pres=Dom.query("pre"),eles=[]
        dealWork.keyword=KEYWORD;
        pres.each(function(i){
            if(i.className.indexOf("brush")!=-1){
                eles.push(i)
            }
        })
        eles.each(function(i){
            var code=i.innerHTML;
            dealWork.source=code
            dealWork.result=[]
            dealWork.begin();
            code=dealWork.result;
            code=code.join("")
            var ele=document.createElement("div");
            ele.innerHTML=code;
            ele.className="code";
            i.parentNode.replaceChild(ele,i)
            var source=document.createElement("a");
            source.innerHTML="点击查看源代码"
            source.data=i.innerHTML;
            source.onclick=function(){
                var w=window.open("","","width=600,height=400");
                var d=w.document
                d.open();
                d.write("<textarea style='width:100%;height:100%;'>"+this.data+"</textarea>");
                d.close();
            }
           ele.parentNode.insertBefore(source,ele)
        })
    });
    
</script>