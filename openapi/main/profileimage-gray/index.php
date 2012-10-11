<?php
include_once "config.php";
include "../../sina/sina_init.php";
include "../../renren/renren_init.php";
session_start();

$sina_token=isset ($_SESSION['sina_oauth']['token'])?$_SESSION['sina_oauth']['token']:"";
$sina_secret=isset($_SESSION['sina_oauth']['secret'])?$_SESSION['sina_oauth']['secret']:"";

$sina=new SinaClient($sina_token, $sina_secret);
if (!$sina->can_use()) {
    echo "<a href=" . $sina->oauth_url() . ">绑定新浪网账号</a>";
} else {
   // echo "<div>已绑定新浪网账号</div>";
}
$client=new SinaClient($sina_token,$sina_secret);
$info=$client->verify_credentials();
$pic=$info['profile_image_url'];
$big_pic=preg_replace("/(http:\/\/.*?\/.*?\/)(50)(\/.*$)/iu","\${1}180\${3}",$pic);

?>
<!DOCTYPE HTML>
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
        </style>
    <script src="jquery.js"></script>
  </head>
  <body>
      <div id="header">
            <h1>头像一键变灰工具</h1>
        </div>
      <div>
          <div id="content">
               <div class="note"><h3>当前头像</h3><img src="<?php echo $big_pic;?>"/></div>
               <div class="note"><a href="change.php?action=gray" style="font-size:16px;margin-right:50px;">一键变灰</a><a href="change.php?action=color" style="font-size:16px;margin-right:50px;">恢复彩色</a> </div>
      </div>
      </div>
  </body>
</html>
