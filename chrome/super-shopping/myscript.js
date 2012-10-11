(function(){
    chrome.extension.sendRequest({
        cmd:"style"
    },function(response){
 
     var style=document.createElement("style");
     style.innerHTML="*{font-family:\'"+response.name+"\' !important;}";
     document.body.appendChild(style);
    });
})();
