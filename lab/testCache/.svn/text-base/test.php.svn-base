<script id="sc">
    var script="";
    var xhr = new XMLHttpRequest();
    var timeStamp=function(){
        return (new Date()).getTime();
    }
    var url = "js.js?t="+timeStamp()

    xhr.open("GET",url, true);
    
    xhr.onreadystatechange =  function(e) {
        if (xhr.readyState == 4) {
            script=xhr.responseText;
            var date=new Date();
            var timeBegin=date.getTime();
            localStorage['script']=script
            var s=document.createElement("script");
            s.text=script;
            document.getElementsByTagName("head")[0].appendChild(s)
            date=new Date();
            var timeEnd=date.getTime();
            alert(timeEnd-timeBegin)
            
            
        }
    }
    xhr.send()

    var LocalAssets=function(){

        return {
            assets:{
                css:[],
                js:[],
                cssBlock:[],
                jsBlock:[]
            },
            init:function(){
                
            },
            /**
             * 向当前环境中加入一段内联的js,保证他的执行时机
             */
            pushBlock:function(code){
                
            },
            /**
             * 向当前环境加入一系列脚本文件,参数是数组
             */
            pushJs:function(jses){

            },
            /**
             * 向当前环境加入一系列css文件,参数是css
             */
            pushCss:function(csses){
                
            },
            /**
             * 开始加载
             */
            load:function(){
                
            },
            /**
             * 执行某条js
             */
            execJs:function(){
                
            },
            /**
             * 执行某条css
             */
            execCss:function(){

            }
        }
    }()
</script>

<script>
LocalAssets.init();

LocalAssets.pushJs([
    "js.js",
    "js2.js"
])
</script>

