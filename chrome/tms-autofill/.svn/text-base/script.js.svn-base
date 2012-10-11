function doClick(linkId){
  
    var fireOnThis = linkId
        var evObj = document.createEvent('Event')
        evObj.initEvent( 'change', true, false )
        fireOnThis.dispatchEvent(evObj)
    console.log(evObj)
}
function getImgs(){
    var imgs=document.getElementsByTagName("img");
    var imgArr=[];
    for(var i =0;i<imgs.length;i++){
        (imgs[i].src&&imgs[i].src.indexOf("taobaocdn.com")!=-1)&&imgArr.push(imgs[i].src)
    }
    return imgArr;
}
chrome.extension.onRequest.addListener(
    function(request, sender, sendResponse) {
        if (request.cmd == "zhua")
            sendResponse({
                imgs:getImgs()
            });
    });
var text="本测试数据由工具自动生成by天祁(淘宝UED前端开发工程师)本测试数据由工具自动生成by天祁(淘宝UED前端开发工程师)本测试数据由工具自动生成by天祁(淘宝UED前端开发工程师)本测试数据由工具自动生成by天祁(淘宝UED前端开发工程师)本测试数据由工具自动生成by天祁(淘宝UED前端开发工程师)本测试数据由工具自动生成by天祁(淘宝UED前端开发工程师)"
var randomInt=function(min,max){
    return Math.floor(Math.random()*(max+1-min)+min)
}
var addClass=function(ele,className){
                var str=ele.className;
                //过滤多余的空格,同时在首尾添加空格
                str=(" "+str+" ").replace( /\s{2,}/g," ");
                if(str.indexOf(" "+className+" ")==-1){
                    str+=" "+className;
                }
                ele.className=str;
            }
if(window.location.href.indexOf("tms.taobao.com/page/module.htm")!=-1){
   
    var inputs=document.getElementsByTagName("input");
    console.log(inputs)
    for(var i=0;i<inputs.length;i++){
        if(inputs[i].type=="text"){
            inputs[i].addEventListener("click",function(e){
                chrome.extension.sendRequest({
                    cmd: "getState"
                }, function(response) {
                    var r=response.state;
                    if(r.nowType=="1"){
                        var len=r.imgs.length;
                        e.target.value=r.imgs[Math.floor(Math.random()*(len))]
                      
                    }else if(r.nowType=="2"){
                        var len=randomInt(r.minText*1,r.maxText*1);
                        var index=randomInt(0,text.length-len-1)
                        e.target.value=text.substr(index,len)
                      
                    }else if(r.nowType=="3"){
                        e.target.value=randomInt(r.minNum*1,r.maxNum*1)
                        
                    }else if(r.nowType=="4"){
                        e.target.value="#"
                        
                    }
                    addClass(e.target,"value-changed")
                        doClick(e.target)
                    
                });
            })
        }
    }
    var ths=document.getElementsByTagName("th");
    for(var i=0;i<ths.length;i++){
        ths[i].addEventListener("click",function(e){
            var table=e.target.parentNode;
            while(table.tagName.toLowerCase()!="table"){
                table=table.parentNode
            }
            var th=table.getElementsByTagName("th");
            var index=0;
            for(var i =0;i<th.length;i++){
                if(e.target===th[i]){
                    index=i
                    break;
                }
            }
            var tbody=table.getElementsByTagName("tbody")[0]
            var tr=tbody.getElementsByTagName("tr")
            var tds=[]
            for(var i =0;i<tr.length;i++){
                var td=tr[i].getElementsByTagName("td")
                var input=td[index].getElementsByTagName("input")
                if(input) tds.push(input[0])
            }

            chrome.extension.sendRequest({
                cmd: "getState"
            }, function(response) {
                var r=response.state;
                if(r.nowType=="1"){
                    var len=r.imgs.length;

                    for(var i=0;i<tds.length;i++){
                        tds[i].value=r.imgs[Math.floor(Math.random()*(len))]
                        
                    }
                }else if(r.nowType=="2"){

                    for(var i=0;i<tds.length;i++){
                        var len=randomInt(r.minText*1,r.maxText*1);
                        var index=randomInt(0,text.length-len-1)
                        tds[i].value=text.substr(index,len)
                    }
                }else if(r.nowType=="3"){
                    for(var i=0;i<tds.length;i++){
                        tds[i].value=randomInt(r.minNum*1,r.maxNum*1)
                    }
                }else if(r.nowType=="4"){
                    for(var i=0;i<tds.length;i++){
                        tds[i].value="#"
                    }
                }
                for(var i=0;i<tds.length;i++){
                        addClass(tds[i],"value-changed")
                        doClick(tds[i])
                    }
                
            });
        })
    }
}
