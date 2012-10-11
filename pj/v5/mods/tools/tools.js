define(function(require, exports, module) {
    var util=require("s/util.js")
    var win=require("lib/window.js")
    var event=util.event;
    
    var t={}
    util.mix(t,win)
    util.mix(t,{
        init:function(){
            util.mix(this,event());
            this.ele=$("#tools")
            this._build();
            this._bind();
            
            this.__bind();
        },
        __bind:function(){
            var self=this;
            $(".tool-item",this.ele).bind("click",function(){
                self.fire("click",{
                    id:$(this).attr("data-toolid")
                })
            });
            
        },
        __build:function(){
            
        }
    })
    return t;
});