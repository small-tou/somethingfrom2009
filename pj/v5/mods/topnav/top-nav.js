define(function(require, exports, module) {
    var util=require("s/util.js")
    var event=util.event;
    
   var t={
       init:function(){
           util.mix(this,event())
           this._build();
           this._bind();
       },
       set:function(x,y,text){
           $("#top-item .sub-item",item).each(function(index,item){
               if($(item).attr("data-nav-x")==x&&$(item).attr("data-nav-y")==y){
                   $(item).html(text)
               }
           });
       },
       disable:function(x,y){
           $("#top-item .sub-item",item).each(function(index,item){
               if($(item).attr("data-nav-x")==x&&$(item).attr("data-nav-y")==y){
                   $(item).addClass("disabled")
               }
           });
       },
       enable:function(x,y){
            $("#top-item .sub-item",item).each(function(index,item){
               if($(item).attr("data-nav-x")==x&&$(item).attr("data-nav-y")==y){
                   $(item).removeClass("disabled")
               }
           });
       },
       _build:function(){
           $("#top-nav .nav-item").each(function(index,item){
               $(item).attr("data-nav-x",index)
               $(".sub-item",item).each(function(i,m){
                   $(m).attr({"data-nav-y":i,"data-nav-x":index})
               })
           })
       },
       _bind:function(){
           var self=this;
           $("#top-nav .nav-item").bind("mouseenter",function(){
               $("#top-nav .nav-item").removeClass("expand")
               $(this).addClass("expand")
           })
           $("#top-nav .nav-item").bind("mouseleave",function(){
               $(this).removeClass("expand")
           })
           $("#top-nav .sub-item").bind("click",function(){
               $(this).closest(".nav-item").removeClass("expand")
               if($(this).hasClass("disabled")) return
               self.fire("click",{
                   x:$(this).attr("data-nav-x"),
                   y:$(this).attr("data-nav-y"),
                   text:$(this).html()
               })
           })
       }
   }
   
   return t;
});

