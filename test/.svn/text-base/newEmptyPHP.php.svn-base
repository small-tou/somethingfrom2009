<html>
    <head>
        <title>Bezier曲线</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script>
           var getHref=function(){
                var href=window.location.href;
                href=href.replace(/(.*\/.*?\/).*?\/[^\/]*$/,"$1")
                return href
            }
            var   MJBASEURL=getHref(),
            CACHE=true,
            DEBUG=true
        </script>
        <script src="../core.js"></script>
    </head>
    <body>
    <canvas id="canvas" width="500" height="313"></canvas>
</body>
</html>
<script>
    var $=MJ;
    $.use(["base"],function(){
         var D=$.Dom
        var canvas=D.get("#canvas");
        var ctx=canvas.getContext('2d');
        var img=new Image();
        img.src="aa.png";
        img.onload=function(){
              ctx.drawImage(img,0,0);
        var image=new Image();
        image.src=canvas.toDataURL();
        document.body.appendChild(image)
        }
      
    })

</script>
