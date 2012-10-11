
var $=function(ele){
    return document.getElementById(ele)
}


var count=0;
var lastCount=0;
setInterval(function(){
if(!$("unreadTotalCount")) return;
    var count=$("unreadTotalCount").innerHTML*1;
            chrome.extension.sendRequest({
                cmd: "hasMessage",
                value:count,
                count:count
            });
},3000)

chrome.extension.sendRequest({
    cmd: "tabid"
}, function(response) {
    console.log(response)
});