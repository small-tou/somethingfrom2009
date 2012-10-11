(function(){
    var mix=function(target,prototypes){
        for(var i in prototypes){
            target[i]=prototypes[i];
        }
    }
    if(document.getElementById("weibo_chrome_iframe_omni")) return;
    var iframe_weibo=document.createElement("iframe");
    iframe_weibo.id="weibo_chrome_iframe_omni"
    iframe_weibo.src=chrome.extension.getURL("upload.html")
    mix(iframe_weibo.style,{
        position:"relative",
        top:"0",
        left:"0",
        width:"100%",
        height:"0px",
        background:"#fff",
        borderBottom:"4px solid #333",
        overflow:"hidden"
    })
    var height=0;
    var speed=1;
    var timer;
    var defaultHeight=150;
    function show(){
        height=0
        timer=setInterval(function(){
            if(speed<0.1){
                speed=0;
                clearInterval(timer)
                return;
            }
            speed=(defaultHeight-height)*0.1
            height+=speed
            iframe_weibo.style.height=height+"px"
        },50)
    }
    function hide(){
        
        height=defaultHeight
        speed=1;
        timer=setInterval(function(){
            if(speed<0.1){
                speed=0;
                iframe_weibo.style.display="none"
                clearInterval(timer)
                
                return;
            }
            speed=(height)*0.4
            height-=speed
            iframe_weibo.style.height=height+"px"
        },50)
    }
    
    document.body.insertBefore(iframe_weibo,document.body.getElementsByTagName("*")[0]);
    show();
     chrome.extension.onRequest.addListener(
    function(request, sender, sendResponse) {
        if (request.cmd == "pic"){
           hide();
        }

    });
})();
