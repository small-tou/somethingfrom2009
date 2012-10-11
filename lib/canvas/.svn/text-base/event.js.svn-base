/**
 * 所有的可能接收到事件的对象都要添加到此对象的LIST属性中.
 * 而且要实现一个检测鼠标点是否在对象内的接口方法 checkEvent
 * 同事要实现 所有的自定义事情接口
 */
MJ.add("Canvas.Event",function(){
    var Event=MJ.Event,CustomEvent=MJ.CustomEvent,Dom=MJ.Dom;
    var event=function(){
        
    };

    event.prototype={
        init:function(core){
            //维护一个对象列表,这些对象是可能接受到事件的对象
            this.LIST=[
                
            ];
            this.EVENT_TYPE={
                common:[
                "click",
                "mousedown",
                "mouseup",
                "mousemove",
                "dblclick",
                ],
                keyboard:[
                "keydown",
                "keyup",
                "keypress",
                ]
            }
          /*  [
            "mouseover",
            "mouseout",
            "dragstart",
            "dragend"
            ];
            */
            this.canvas=core.canvas;
            var me=this;
            this.EVENT_TYPE.common.each(function(i){
                Event.on(this.canvas,i,function(e){
                    me.spreadMouseCommon(i,e)
                })
            });
            this.EVENT_TYPE.keyboard.each(function(i){
                Event.on(this.canvas,i,function(e){
                    me.spreadKeyboard(i,e)
                })
            });

        },
        /**
         * 转播鼠标事件
         */
        spreadMouseCommon:function(type,e){
            this.LIST.each(function(i){
                if(i.checkEvent(e)){
               //     console.log(i.events)
                    i.events[type].fire(e)
                }
            });
        },
        spreadKeyboard:function(type,e){
            var e=e||window.event;//
            this.LIST.each(function(i){
                i.events[type].fire(e)
            })
        },
        spreadCommon:function(type){
            this.LIST.each(function(i){
                i.events[type].fire()
            })
        },
        add:function(sprite){
            this.LIST.add(sprite)
            for(var n in this.EVENT_TYPE){
                this.EVENT_TYPE[n].each(function(i){
                   
                sprite.events=sprite.events||{}
                sprite.events[i]=new MJ.CustomEvent(i,sprite)
            })
            }
        },
        remove:function(sprite){
            this.LIST.remove(sprite)
        }
    };
    return event;
});