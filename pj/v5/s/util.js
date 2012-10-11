define(function(require, exports, module) {
   
   
   
    var util={
        
        mix:function(target,source){
            for(var i in source){
                target[i]=source[i]
            }  
        },
        each:function(array,callback){
            for(var i =0;i<array.length;i++){
                callback.call(array,array[i],i)
            }
        },
        /**
         * 自定义事件。
         * 要使用直接mix此对象到目标对象，目标对象即可拥有自定义事件能力。
         * 例如：util.mix(this,event)
         */
        event:function(){
           
            return{
                listen:function(event_name,callback){
                    var util_events=this.util_events
                    if(!util_events[event_name]){
                        util_events[event_name]={
                            events:[]
                        }
                    }
                   util_events[event_name].events.push(callback)
                },
                fire:function(event_name,data){
                    var self=this;
                    var util_events=this.util_events
                   if(util_events[event_name]){
                       util.each(util_events[event_name].events,function(e,i){
                           e.call(self,data)
                       })
                   }
                },
                util_events:{
                    "util_demo":{
                        events:[
                            
                        ],
                        data:{
                            
                        }
                    }
                }
            }
        }
    }
    return util;
});
