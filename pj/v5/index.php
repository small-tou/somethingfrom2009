<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="index.css">
        <script src="s/sea.js"></script>
        <script src="s/jquery.js"></script>
        <script>
            seajs.config({
                //   base: 'http://localhost/mj-o/pj/v4/js'
                base :"http://localhost/xampp/mj/pj/v5"
                //   base :"http://www.html-js.com/mj/pj/v4/js"
            });
        </script>
    </head>
    <body>
        <div id="page">
            <?php include("mods/topnav/top-nav.php"); ?>
            <?php include("mods/tools/tools.php");?>
            <?php include("mods/stage/stage.php");?>
        </div>
        <script>
            seajs.use([
                "mods/topnav/top-nav.js",
                "mods/tools/tools.js"
            ],function(topNav,tools){
                topNav.init();
                topNav.listen("click",function(data){
                    console.log(data)
                })
                
                console.log(tools)
                tools.init();
                tools.listen("click",function(data){
                    console.log(data)
                })
                
            })
        </script>
    </body>
</html>

