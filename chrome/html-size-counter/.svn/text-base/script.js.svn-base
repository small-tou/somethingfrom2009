if(document.body.hscchromeoff==undefined){
    var target=null
    var target2=null
    var CLASSNAME="highlight-hsc-chrome"
    var has=function(array,item){
        for(var i=0,j=array.length;i<j;i++){
            if(array[i]==item) return true;
        }
        return false;
    }
    var remove=function(array,item){
        var j=array.length;
        for(var i=0;i<j;i++){
            if(array[i]==item){
                array.splice(i, 1);
                j--;
            }
        }
    }
    var addClass=function(ele,className){
        var elesClasses=(" "+ele.className+" ").replace( /\s{2,}/g," ").split(" ");
        if(!has(elesClasses,className)){
            elesClasses.push(className)
        }
        ele.className=elesClasses.join(" ")
    }
    var removeClass=function(ele,className){
        var elesClasses=(" "+ele.className+" ").replace( /\s{2,}/g," ").split(" ");
        remove(elesClasses,className)
        ele.className=elesClasses.join(" ")
    }

    document.body.onmouseover=function(e){
        try{
            if(document.body.hscchromeoff=="1") return;
            if(target!==e.target){
                target2=target
                target=e.target;
                addClass(target,CLASSNAME)
                removeClass(target2,CLASSNAME)
                e.target.title=e.target.innerHTML.length
            }
        }catch(e){

        }


    }
    
}
document.body.hscchromeoff='0';



 

