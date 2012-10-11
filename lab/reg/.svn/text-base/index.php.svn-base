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
        <script src="../../core.js"></script>
    </head>
    <body>
        <pre id="code">
MY.use("mquery",function(){
    var $=MY.Query
    var source
    $("#run").click(function(){
        source=$("#source").val()
        $("#result").val("\""+source.replace(/\"/g,"\\\"").replace(/\'/g,"\\\'").replace(/\n/g,"\"+\n\"").replace(/\//g,"\\/")+"\"")
    })
})
        </pre>
    </body>
</html>
<script>
    var $=MJ
    $.use("base",function(){
        var Dom=$.Dom,Event=$.Event;
        var code=Dom.get("#code");
        console.log(code)

    })
</script>