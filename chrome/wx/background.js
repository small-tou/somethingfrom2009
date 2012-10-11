

    var tabid=null;
    var msgid=[]
    var count=0;
    var lastCount=0;
    //  localStorage['no_10']="";
    var ul=document.createElement("div");
    chrome.extension.onRequest.addListener(
    function(request, sender, sendResponse) {
        if (request.cmd == "hasMessage"){
            chrome.browserAction.setBadgeText({
                text:request.count.toString()
            });
            localStorage['count']=request.count.toString()
            count=request.count;
            
            if(count!=0){
                if(count!=lastCount){
                    lastCount=count;
                    //     ((new Date()).getTime()-localStorage['no_10']*1>10*60*1000)&&
                    if(chrome.extension.getViews({
                        type:'notification'
                    }).length==0){
                        var notification = webkitNotifications.createNotification(
  'icon.png',  // icon url - can be relative
  '微信消息',  // notification title
  '微信网页版提醒您：您有（'+count+'）条新消息'  // notification body text
);
                        notification.show();
                    }else{
                        
                    }
                    return;
                }
                
            }
            
            
            
           
        }
        if (request.cmd == "tabid"){
            tabid=sender.tab.id
        }
        /*
        if(request.cmd=="history"){
            chrome.history.search({
                'text': ''              // Return every history item....
            },
            function(historyItems) {
                // For each history item, get details on all visits.
                    var url = historyItems[0].url;
                   chrome.tabs.create({
                url:url
            })
            });

        }*/
        request=null;
    });
    chrome.browserAction.onClicked.addListener(function() {
        if(tabid){
            chrome.tabs.update(sender.tab.id, {
                selected:true
            })
        }else{
            chrome.tabs.create({
                url:"http://wx.qq.com"
            })
        }
    });