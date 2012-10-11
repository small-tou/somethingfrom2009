<style>
    .code,#code{
        font-size:12px;
        font-family: "Georgia","Consolas", "Bitstream Vera Sans Mono", "Courier New", Courier, monospace !important;
        width:700px;
        word-wrap:break-word;word-break:break-all;
        background:#fff;
        border:1px solid #ddd;
        padding:10px;
        color:#000 !important;
        border-left:5px solid #96FF96;
    }
    .keyword{
        color:#069;
        font-weight:bold;
    }
    .tab{
        padding-left:30px;
    }
    .string{
        color:#075BE7;
    }
    .blank{
        padding-left:8px;
    }
    .quo{
        color:#DA5F57;
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
<div style="float:left;">
<textarea id="source" style="width:500px;height:400px;">
//这里填代码

</textarea><br/>
<button id="run">点击着色</button>
</div>
<div id="code" style="float: left;display:inline;">

</div>
<div style="clear:both;"></div>

<script>
    var dealWork=function(){
        var nowIndex=0;//当前正在处理的字符的索引,在处理引号之类的这个变量可能会跳跃增加而不是递增.
        var lastIndex=0;//上一次发生拆分的字符索引,本次拆分从这里开始,拆分完后更新此变量
        var KEYWORD=["break","false","in","this","void","continue","for","new","true","while","delete","function","null","typeof","with","else","if","return","var",
            "case","debugger","export","super","catch","default","extends","switch","class","do","finally","throw","const","enum","import","try","public","private","static"]
        function has(arr,item){
            for(var i=0,j=arr.length;i<j;i++){
                if(arr[i]==item) return true;
            }
            return false;
        }
        return {
            source:"",
            result:[],  //结果是一个数组,将此数组join即可获得最后的字符串
            keyword:[],
            begin:function(){
                nowIndex=0;
                lastIndex=0;
                //开始遍历字符串,中间会跳跃进行,不一定是挨个遍历
                for(nowIndex =0;nowIndex<this.source.length;){
                    //处理顺序不能变,先处理注释和正则,在处理字符串,在处理换行,再处理其他
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
                //把剩余部分补上
                this.result.push(this.source.substring(lastIndex,this.source.length))
            },
            /**
             * 首先处理注释和正则
             */
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
            /**
             * 处理括号
             */
            dealQuo:function(mark){
                var index=nowIndex
                //包含对转义的处理
                while((!(this.source.charAt(++nowIndex)==mark&&this.source.charAt(nowIndex-1)!="\\"))&&nowIndex<this.source.length){}
                nowIndex++
                this.result.push(this.source.substring(lastIndex,index))
                this.result.push("<span class=\"quo\">"+this.source.substring(index,nowIndex)+"</span>")
                lastIndex=nowIndex
            },
            /**
             * 处理换行
             */
            dealLine:function(){
                var index=nowIndex
                this.result.push(this.source.substring(lastIndex,index))

                this.result.push("<br/>")
                lastIndex=++nowIndex
            },
            /**
             * 处理其他
             */
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
                    if(has(this.keyword,str)){
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
</script>
<script>
    document.getElementById("run").onclick=function(){
        dealWork.source=document.getElementById("source").value.replace(/</g,"&lt;").replace(/>/g,"&gt;");
        dealWork.begin();
        var code=dealWork.result.join("");
        document.getElementById("code").innerHTML=code
    }
    
</script>