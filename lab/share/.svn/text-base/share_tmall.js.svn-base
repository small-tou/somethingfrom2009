(function(){

    KISSY.Share=function(){
        if(typeof(KISSY)=="undefined") return;
        var S=KISSY,D=S.DOM,E=S.Event,
        targetConfig={
            "copy":["MSN/QQ","-248","",""],
            "jianghu" : ["淘江湖","-4","http://share.jianghu.taobao.com/share/addShare.htm?url={U}","width=550,height=400"],
            "sina" : ["新浪微博","-41","http://v.t.sina.com.cn/share/share.php?title={T}&url={U}","width=620,height=450"],
            "qzone" : ["QQ空间","-60","http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={U}","width=900,height=760"],
            "renren" : ["人人网","-79","http://share.renren.com/share/buttonshare.do?link={U}","width=570,height=450"],
            "kaixin" : ["开心网","-22","http://www.kaixin001.com/repaste/bshare.php?rtitle={T}&URL={U}","width=800,height=550"],
            //  "gmail" : ["Gmail","-136","https://mail.google.com/mail/?view=cm&fs=1&tf=1&ui=2&shva=1&to&su={T}&body={U}","width:600,height=400"],
            "douban" : ["豆瓣","-96","http://www.douban.com/recommend/?title={T}&url={U}&v=1&sel=","scrollbars=yes,width=450,height=355"],
            //     "buzz" : ["buzz","-367","http://www.google.com/buzz/post?hl=zh-CN&url={U}","width=716,height=480"]
            //      "google" : ["谷歌","-117","http://www.google.com/bookmarks/mark?op=edit&hl=zh-CN&output=popup&title={T}&bkmk={U}","height=420px,width=550px,alwaysRaised=1"],
            //      "w51" : ["51","-174","http://share.51.com/share/share.php?type=8&title={T}&vaddr={U}","width=780,height=700"],
            "wangyi" : ["网易微博","-211","http://t.163.com/article/user/checkLogin.do?&info={T} {U}",""],
            "tengxun" : ["腾讯微博","-461","http://v.t.qq.com/share/share.php?title={T}&url=={U}",""],
            "souhu" : ["搜狐微博","-192","http://t.sohu.com/third/post.jsp?url={T}&title={U}",""]
        //      "yahoo" : ["雅虎","-268","http://myweb.cn.yahoo.com/popadd.html?title={T}&url={U}","width=440,height=440"],
        //   "baisouhu" : ["搜狐","-193","http://bai.sohu.com/share/blank/addbutton.do?title={T}&link={U}","width=480,height=340"]
        //       "itieba" : ["i贴吧","-308","http://tieba.baidu.com/i/sys/share?title={T}&link={U}&type=text","width=626,height=436"],
        //       "hexun" : ["和讯","-329","http://bookmark.hexun.com/post.aspx?title={T}&url={U}","width=600,height=580"],
        //       "hotmail" : ["Hotmail","-348","http://mail.live.com/secure/start?action=compose&subject={T}&body={U}","width=1010,height=700"],
        //       "hibaidu" : ["百度空间","-385","http://apps.hi.baidu.com/share/?title={T}&url={U}","width=820,height=550"],
        //       "myspace" : ["myspace","-404","http://www.myspace.cn/Modules/PostTo/Pages/DefaultMblog.aspx?t={T}&u={U}&source=bookmark","width=495,height=450"],
        //        "ymail" : ["雅虎邮箱","-268","http://compose.mail.yahoo.com/?subject={T}&body={U}","width=800,height=670"],
        //        "csdn" : ["csdn","-424","http://wz.csdn.net/storeit.aspx?t={T}&u={U}&t","width=600,height=310"],
        //        "youdao" : ["有道","-443","http://shuqian.youdao.com/manage?a=popwindow&title={T}&url={U}","height=200, width=590"]
        },
        initCss='.tmall-share{width:300px;background:#fff;border:1px solid #9A0C1A;-moz-box-shadow:#DAB8BB 0 0 3px;-webkit-box-shadow:0 0 3px #DAB8BB;position:absolute;top:400px;left:500px;display:none;}.tmall-share-inner{background:#f7f7f7;height:100%;position:relative;}.tmall-share-hd{border-bottom:1px solid #ddd;height:25px;padding-left:5px;line-height:25px;position:relative;font-size:12px;}.tmall-share-hd h2{font-weight:bold;font-size:12px;}.tmall-share-close{position:absolute;right:5px;top:0;height:25px;width:30px;line-height:25px;text-align:center;cursor:pointer;display:block;}.tmall-share-s{background:url(http://img02.taobaocdn.com/tps/i2/T1gGhSXoRrXXXXXXXX-67-16.png) no-repeat;width:11px;height:11px;position:absolute;}.pos-1 .tmall-share-s{background-position:-3px 0;top:-11px;}.pos-2 .tmall-share-s{background-position:-20px -1px;right:-11px;}.pos-3 .tmall-share-s{background-position:-36px -1px;bottom:-9px;_bottom:-13px;}.pos-4 .tmall-share-s{background-position:-53px -1px;left:-10px;}.pos-1 .s-1,.pos-3 .s-1{left:10px;}.pos-1 .s-2,.pos-3 .s-2{right:10px;}.pos-2 .s-1,.pos-4 .s-1{top:10px;}.pos-2 .s-2,.pos-4 .s-2{bottom:10px;}.tmall-share-bd{padding:5px 5px 15px 10px;}.tmall-share-list li{float:left;display:inline;margin-top:5px;height:20px;margin-left:3px;}.tmall-share .show-all li{width:80px;}.tmall-share-list li a{cursor:pointer;padding-left:19px;display:block;height:16px;color:#666;background:url(http://img03.taobaocdn.com/tps/i3/T1VRXQXjtDXXXXXXXX-16-500.gif) no-repeat;line-height:16px;}.tmall-share .show-icon li{width:20px;overflow:hidden;text-indent:-100px;}',
        config={
            //从左上角开始算,有8个位置,从1开始,0表示不显示箭头,位置在1的位置
            pos:1,
            hasText:true,
            //触发方式?click或者hover
            triggerType:"click",
            anim:false,
            triggerClass:".J_Share_Trigger",
            width:350,
            height:120,
            icon_width:260,
            icon_height:65,
            title:document.title,
            url:window.location.href
        //配置存在data:shareConfig中 例如:data:shareConfig="type:hover;hasText:true""
        },
        template=
        "<div class=\"tmall-share-inner\">"+
        "<div class=\"tmall-share-hd\">"+
        "<h2>分享到:</h2>"+
        "<a class=\"tmall-share-close\">关闭</a>"+
        "</div>"+
        "<div class=\"tmall-share-bd\">"+
        "<ul class=\"tmall-share-list  clearfix\">"+
        "</ul>"+
        "</div>"+
        "</div>"+
        "<div class=\"tmall-share-s\"></div>",
        dom,
        w,  //页面的宽
        h,      //页面的高
        pView,  //popup的大小
        tView, //trigger的大小
        pOffset,        //popup的位置
        share,  //当前对象
        isShow=false, //当前popup是否在显示状态
        firstClick=true,  //标识是否点击过了,只有第一次点击才会调用一些构建方法,不点击不执行这些方法
        //获取热点位置,扩展了kissy的方法,对热区同样可以获取位置,返回两个坐标点标识的位置和大小信息
        getView=function(selector){
            var ele=D.get(selector)
            if(ele){
                if(ele.nodeName=="AREA"){
                    var a=D.attr(ele,"coords").split(",")
                    ele=D.filter('img', function(img) {
                        return D.attr(img, 'usemap') == "#"+D.attr(ele.parentNode,'name');
                    })[0];
                    var p=D.offset(ele)
                    return{
                        x1:p.left+a[0]*1,
                        y1:p.top+a[1]*1,
                        x2:p.left+a[2]*1,
                        y2:p.top+a[3]*1
                    }
                }else{
                    var p=D.offset(ele)
                    return{
                        x1:p.left,
                        y1:p.top,
                        x2:p.left+ele.offsetWidth  ,
                        y2:p.top+ele.offsetHeight 
                    }
                }
            }
            return {
                x1:0,
                x2:0,
                y1:0,
                y2:0
            }
        }
        return {
            init:function(){
                this.triggerDom=D.get(config.triggerClass);
                dom=null;
                if(typeof(dom)=="undefined") return
                var c=this.getConfig()
                c.hasText&&(c.hasText=(c.hasText=="1")?true:false)
                c.anim&&(c.anim=(c.anim=="1")?true:false)
                S.mix(config,c);
                share=this
                this.bindEvent();
            },
            /*
             * 从属性中获取config配置
             */
            getConfig:function(){
                var params=D.attr(this.triggerDom,"data:shareConfig")||"",r={},c
                params=params.split(";");
                S.each(params,function(i){
                    c=i.split(":");
                    r[c[0]]=c[1];
                })
                return r;
            },
            /*
             *绑定事件
             */
            bindEvent:function(){
                var tDom=this.triggerDom,t=config.triggerType;
                (t=="click")&&E.on(tDom,"click",this.show);
                (t=="hover")&&E.on(tDom,"mouseenter",this.show);
            },
            createHtml:function(){
                var ele;
                D.addStyleSheet(initCss);
                (ele=D.create("<div>")).className="tmall-share";
                D.css(ele,{
                    width:(config.hasText?config.width:config.icon_width)+"px",
                    height:(config.hasText?config.height:config.icon_height)+"px"
                })
                ele.id="J_Tmall_Share";
                ele.innerHTML=template
                document.body.appendChild(dom=ele);
                D.addClass(".tmall-share-list",config.hasText?"show-all":"show-icon")
                this.createItems();
                E.on(".tmall-share-close","click",this.hide)
                E.on(D.query("a",D.get(".tmall-share-list")),"click",function(){
                    var index=this.className,
                    name=targetConfig[index][0],
                    url=targetConfig[index][2].replace("{U}",config.url).replace("{T}",config.title),
                    size=targetConfig[index][3],
                    win=window
                    if(index!="copy"){
                        win.open(url,name,size+",scrollbars=no,status=no,modal=yes")
                    }else{
                        if(win.clipboardData)
                        {
                            if(win.clipboardData.setData("Text", config.title+" \n "+config.url)) alert('复制成功,请粘贴到你的QQ/MSN上推荐给你的好友！')
                        }else
                            win.prompt("您使用的是非ie浏览器,不支持直接复制功能,请用右键复制下面的内容到QQ或者MSN内跟好友分享!",config.title+"  "+config.url)
                    }
                })
            },
            show:function(e){
                e.halt()
                if(isShow) return
                isShow=true
                if(firstClick){
                    share.createHtml();
                    firstClick=false
                }
                share.initTrigger();
                if(config.anim){
                    D.css(dom,{
                        opacity:0,
                        display:"block"
                    })
                    var o=0
                    setTimeout(function(){
                        D.css(dom,"opacity",(o+=0.05))
                        if(D.css(dom,"opacity")<1) {
                            setTimeout(arguments.callee,10)
                        }
                    },10)
                }else{
                    dom.style.display="block";
                }
               
            },
            hide:function(e){
                e.halt()
                isShow=false
                if(config.anim){
                    var o=D.css(dom,"opacity")
                    setTimeout(function(){
                        D.css(dom,"opacity",(o-=0.05))
                        if(D.css(dom,"opacity")>0) {
                            setTimeout(arguments.callee,10)
                        }else{
                            dom.style.display="none";
                        }
                    },10)
                }else{
                    dom.style.display="none";
                }
            },
            /*
             * 安排如何放置弹出框
             */
            initTrigger:function(){
                w=D.viewportWidth()
                h=D.viewportHeight()
                pView={
                    x:(config.hasText?config.width:config.icon_width),
                    y:(config.hasText?config.height:config.icon_height)
                }
                tView=getView(config.triggerClass)
                var p
                this.countPopupPos(config.pos)
                reMap={  //修正映射,数组第一个值为x超出的时候,第二个值为y超出的时候,第三个为都超出的时候
                    1:[2,6,5],
                    2:[1,5,6],
                    3:[8,4,7],
                    4:[7,3,8],
                    5:[6,2,1],
                    6:[5,1,2],
                    7:[4,8,3],
                    8:[3,7,4]
                }
                p=config.pos
                var x_b=pOffset.x<D.scrollLeft() ||pOffset.x+pView.x*1-D.scrollLeft()>w-D.scrollLeft()
                var y_b=pOffset.y<D.scrollTop()||pOffset.y+pView.y*1-D.scrollTop()>h-D.scrollTop()
                if(x_b&&y_b){
                    p=reMap[config.pos][2]
                }else if(x_b){
                    p=reMap[config.pos][0]
                }else if(y_b){
                    p=reMap[config.pos][1]
                }
                this.countPopupPos(p)
                D.css(dom,{
                    left:pOffset.x+"px",
                    top:pOffset.y+"px"
                })
            },
            /**
             * 计算八个不同方向下
             */
            countPopupPos:function(pos){
                pos=pos*1
                pOffset={},cache=[]
                switch(pos){
                    case 1:
                        cache= [ tView.x1,tView.y1-pView.y-10]
                        break;
                    case 2:
                        cache=  [tView.x2-pView.x,tView.y1-pView.y-10];
                        break;
                    case 3:
                        cache=  [tView.x2+10,tView.y1];
                        break;
                    case 4:
                        cache=  [tView.x2+10,tView.y2-pView.y];
                        break;
                    case 5:
                        cache=  [tView.x2-pView.x,tView.y2+10];
                        break;
                    case 6:
                        cache=[tView.x1,tView.y2+10];
                        break;
                    case 7:
                        cache=[tView.x1-pView.x-10,tView.y2-pView.y];
                        break;
                    case 8:
                        cache=[tView.x1-pView.x-10,tView.y1];
                        break;
                    default:
                        cache=[tView.x1,tView.y2+10];
                        break;  //默认是6
                }
                pOffset={
                    x:cache[0],
                    y:cache[1]
                }
                this.setPointer(pos);
                return pOffset;
            },
            setPointer:function(pos){
                var ele=D.get(".tmall-share-s");
                pos=pos*1
                var map={  //指针class映射
                    1:3,
                    2:4,
                    3:1,
                    4:2
                }
              
                dom.className="tmall-share"+" pos-"+map[Math.ceil(pos/2)]
                ele.className="tmall-share-s "+" s-"+(((280%pos==0)&&(pos!=1)&&(pos!=8))?"2":"1");
                ele.style.backgroundImage="url(http://img02.taobaocdn.com/tps/i2/"+((S.UA.ie=="6")?"T1gGhSXoRr":"T1I9XQXkpk")+"XXXXXXXX-67-16.png)"
            },
            createItems:function(){
                for(var i in targetConfig){
                    var li=D.create("<li>")
                    var a=D.create("<a>",{
                        title:targetConfig[i][0]
                    })
                    a.className=i
                    li.appendChild(a)
                    D.html(a,targetConfig[i][0])
                    D.get(".tmall-share-list").appendChild(li)
                    a.style.backgroundPosition="0 "+targetConfig[i][1]+"px";
                }
            },
            die:function(){
                dom&&document.body.removeChild(dom);
                dom=null
                w=0
                h=0
                pView=null
                tView=null
                pOffset=null
                isShow=false
                firstClick=true
                E.remove(".J_Share_Trigger","click")
                E.remove(".J_Share_Trigger","mouseenter")
            }
        }
    }();
    KISSY.ready(function(){
        KISSY.Share.init();
    })
   
})();