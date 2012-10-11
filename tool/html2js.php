
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../index.css"/>
        <script src="../../core_test_1.js"></script>

        <style>
            textarea{
                width:600px;
                height:200px;
}
button{
    display: block;
    width:200px;
    height:30px;
    text-align: center;
    margin:20px;
}
        </style>
    </head>
    <body>
        <textarea id="source"></textarea>
         <textarea id="result"></textarea>
         <button id="run">转换</button>
    </body>
</html>
<script>
MY.use("mquery",function(){
    var $=MY.Query
    var source
    $("#run").click(function(){
        source=$("#source").val()
        $("#result").val("\""+source.replace(/\"/g,"\\\"").replace(/\'/g,"\\\'").replace(/\n/g,"\"+\n\"").replace(/\//g,"\\/")+"\"")
    })
})
</script>