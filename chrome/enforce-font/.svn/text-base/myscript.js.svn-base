(function(){

    chrome.extension.sendRequest({
        cmd:"style"
    },function(response){
        if(response.enforce_font==="true"){
            var black_list=response.b_list.split("$$$")
            for(var i in black_list){
                if(black_list[i]==location.hostname)
                    return
            }
            if(document.getElementById("change-font-link")){
                document.getElementById("change-font-link").innerHTML="*{-webkit-text-size-adjust:none;font-size:"+response.size+" !important;}"
            }else{
                var style=document.createElement("style");
                style.id="change-font-link"
                style.innerHTML="*{font-family:\'"+response.name+"\' !important;}";
                document.getElementsByTagName('head')[0].appendChild(style);
            }
         
        }
        if(response.enforce_size==="true"){
            var black_list=response.b_list_size.split("$$$")
            for(var i in black_list){
                if(black_list[i]==location.hostname)
                    return
            }
            if(document.getElementById("change-font-size")){
           
                document.getElementById("change-font-size").innerHTML="body{-webkit-text-size-adjust:none;font-size:"+response.size+"px !important;}"
            }
            else {
                var style=document.createElement("style");
                style.id="change-font-size";
                style.innerHTML="body{-webkit-text-size-adjust:none;font-size:"+response.size+"px !important;}";
                document.getElementsByTagName('head')[0].appendChild(style);
            }
        
        }
    
    });
})();
