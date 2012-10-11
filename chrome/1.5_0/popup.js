
        localStorage['env']=localStorage['env']||"com"
        localStorage['env']="com"
        
        var bbc = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
        function bs(str) {
            var out, i, len;
            var c1, c2, c3;

            len = str.length;
            i = 0;
            out = "";
            while(i < len) {
                c1 = str.charCodeAt(i++) & 0xff;
                if(i == len)
                {
                    out += bbc.charAt(c1 >> 2);
                    out += bbc.charAt((c1 & 0x3) << 4);
                    out += "==";
                    break;
                }
                c2 = str.charCodeAt(i++);
                if(i == len)
                {
                    out += bbc.charAt(c1 >> 2);
                    out += bbc.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
                    out += bbc.charAt((c2 & 0xF) << 2);
                    out += "=";
                    break;
                }
                c3 = str.charCodeAt(i++);
                out += bbc.charAt(c1 >> 2);
                out += bbc.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
                out += bbc.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >>6));
                out += bbc.charAt(c3 & 0x3F);
            }
            return out;
        }
        $("#add").click(function(){
            if($("#username").val()!=""&&$("#password").val()!=""){
                localStorage[localStorage['env']+"***"+$("#username").val()]=bs($("#password").val());
                localStorage[localStorage['env']+"***"+'list']=localStorage[localStorage['env']+"***"+'list']||""
                var list=localStorage[localStorage['env']+"***"+'list'].split("%$$%");
                for(var i=0;i<list.length;i++){
                    if(list[i]==""){
                        list.splice(i,1)
                    }
                }
                list.push($("#username").val())
                localStorage[localStorage['env']+"***"+'list']=list.join("%$$%")
                repaint()
                $("#username").val("")
                $("#password").val("")
            }
        })
        $("#password").keyup(function(event){
            if(event.keyCode==13){
                if($("#username").val()!=""&&$("#password").val()!=""){
                    localStorage[localStorage['env']+"***"+$("#username").val()]=bs($("#password").val());
                    localStorage[localStorage['env']+"***"+'list']=localStorage[localStorage['env']+"***"+'list']||""
                    var list=localStorage[localStorage['env']+"***"+'list'].split("%$$%");
                    for(var i=0;i<list.length;i++){
                        if(list[i]==""){
                            list.splice(i,1)
                        }
                    }
                    list.push($("#username").val())
                    localStorage[localStorage['env']+"***"+'list']=list.join("%$$%")
                    repaint()
                    $("#username").val("")
                    $("#password").val("")
                }
            }
        })
        var mix=function(target,prototypes){
            for(var i in prototypes){
                target[i]=prototypes[i];
            }
        }
        function repaint(){
            
            localStorage[localStorage['env']+"***"+'list']=localStorage[localStorage['env']+"***"+'list']||""
            var list=localStorage[localStorage['env']+"***"+'list'].split("%$$%");
            $("#list")[0].innerHTML=""
            for(var i=0;i<list.length;i++){
                var item=document.createElement("div");
                item.className="item";
                var a=document.createElement("a");
                a.innerHTML=list[i]
                a.href="#"
                item.appendChild(a)
                $("#list")[0].appendChild(item)
                var close=document.createElement("a");
                mix(close.style,{
                    "float":"right",
                    paddingRight:"50px",
                    color:"#aaa"
                })
                close.href="#"
                close.innerHTML="delete"
                item.appendChild(close)
                a.onclick=function(){
                    console.log("https://login."+(localStorage['env']=="com"?"taobao.com":"daily.taobao.net")+"/member/login.jhtml?ref=chromeextension&username="+encodeURIComponent(this.innerHTML)+"&password="+localStorage[localStorage['env']+"***"+this.innerHTML])
                    var tab=chrome.tabs.create({
                        url:"http://weibo.com/logout.php?backurl=http%3A%2F%2Fweibo.com/%3Fref=chromeextension%26username="+encodeURIComponent(this.innerHTML)+"%26password="+localStorage[localStorage['env']+"***"+this.innerHTML],
                        selected:false
                    }, function(tab){
                        
                    })
                }
                close._value=list[i]
                close.onclick=function(){
                    var list=localStorage[localStorage['env']+"***"+'list'].split("%$$%");
                    for(var i=0;i<list.length;i++){
                        if(list[i]==""||list[i]==this._value){
                            list.splice(i,1)
                        }
                    }
                    localStorage[localStorage['env']+"***"+'list']=list.join("%$$%")
                    repaint()
                }
            }
            if(list.length=="0"){
                $("#list")[0].innerHTML="<EM>no item</EM>"
            }
        }
        repaint()
        //     var bbc="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";function bs(g){var c,e,a;var f,d,b;a=g.length;e=0;c="";while(e<a){f=g.charCodeAt(e++)&255;if(e==a){c+=bbc.charAt(f>>2);c+=bbc.charAt((f&3)<<4);c+="==";break}d=g.charCodeAt(e++);if(e==a){c+=bbc.charAt(f>>2);c+=bbc.charAt(((f&3)<<4)|((d&240)>>4));c+=bbc.charAt((d&15)<<2);c+="=";break}b=g.charCodeAt(e++);c+=bbc.charAt(f>>2);c+=bbc.charAt(((f&3)<<4)|((d&240)>>4));c+=bbc.charAt(((d&15)<<2)|((b&192)>>6));c+=bbc.charAt(b&63)}return c}$("#add").click(function(){if($("#username").val()!=""&&$("#password").val()!=""){localStorage[$("#username").val()]=bs($("#password").val());localStorage.list=localStorage.list||"";var b=localStorage.list.split(",");for(var a=0;a<b.length;a++){if(b[a]==""){b.splice(a,1)}}b.push($("#username").val());localStorage.list=b.join(",");repaint()}});var mix=function(c,b){for(var a in b){c[a]=b[a]}};function repaint(){var e=localStorage.list.split(",");$("#list")[0].innerHTML="";for(var c=0;c<e.length;c++){var d=document.createElement("div");d.className="item";var b=document.createElement("a");b.innerHTML=e[c];b.href="#";d.appendChild(b);$("#list")[0].appendChild(d);var f=document.createElement("a");mix(f.style,{"float":"right",paddingRight:"50px",color:"#aaa"});f.href="#";f.innerHTML="\u5220\u9664";d.appendChild(f);b.onclick=function(){var a=chrome.tabs.create({url:"https://login.taobao.com/?ref=chromeextension&username="+b.innerHTML+"&password="+localStorage[b.innerHTML],selected:false},function(g){setTimeout(function(){chrome.tabs.remove(g.id)},900)})}}if(e.length=="0"){$("#list")[0].innerHTML="<EM>\u6ca1\u6709\u8d26\u6237,\u8bf7\u6dfb\u52a0</EM>"}}repaint();
