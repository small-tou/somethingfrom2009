define(function(require, exports, module) {
    var util=require("s/util.js")
    var event=util.event;
    var w={
        _build:function(){
           
        },
        _bind:function(){
            var isDragging=false;
            var offsetX=0;
            var offsetY=0;
            var self=this;
            var hd= $(".hd",this.ele)
            hd.bind("mousedown",function(e){
                isDragging=true;
                var nowPos=hd.offset();
                offsetX=e.originalEvent.x-nowPos.left;
                offsetY=e.originalEvent.y-nowPos.top;
            }).bind("mouseup",function(e){
                isDragging=false;
                var nowPos=hd.offset();
                if((offsetX==e.originalEvent.x-nowPos.left)&&(offsetY==e.originalEvent.y-nowPos.top)){
                    $(".bd",self.ele).toggle()
                }else{
                    e.preventDefault();
                    
                    return false;
                }
            }).bind("selectstart",function(e){
                return false;
            })
           
            $(window).bind("mousemove",function(e){
                if(!isDragging) return;
                self.ele.css({
                    left:e.originalEvent.x-offsetX,
                    top:e.originalEvent.y-offsetY
                })
            })
        },
        show:function(){
            $(this.ele).removeClass("hidden")
        },
        hide:function(){
            $(this.ele).addClass("hidden")
        }
    } 
    return w;
    
});

