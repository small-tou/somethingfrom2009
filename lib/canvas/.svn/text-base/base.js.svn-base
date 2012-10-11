MJ.add("Canvas.core",function(){
    var Event=MJ.CustomEvent
    /**
     *帧对象,每隔一段时间重画自己一次,类似flash中的帧概念
     *原理就是每到一定时间就清除canvas,然后调用当前帧里的所有的动画元素的draw()方法,将所有动画元素按照新的配置重画
     *从而生成动画,之后程序无需关心元素的重画,只需要调整元素属性即可,这个对象会自动管理元素的渲染
     *
     */
 
    var Canvas=function(){

    }
    /**
     *
     */
    Canvas.prototype={
        init:function(){
            this.interval=null;
            this.fps=20
            this.sprites=[]
            this.points=[]
            this.canvas=null;
            this.ctx=null;
            this.events={
                renderEvent:new Event("render",this)
            }
        },

        /**
         * 开始动画
         */
        begin:function(){
            this.interval=setInterval((function(param){
                return function(){
                    param.render();
                }
            })(this),this.fps);
        },
        /**
         *渲染
         */
        render:function(){

            this.ctx.clearRect(-800, -800, 1600, 1600)
            this.sprites.each(function(i){
                i.move();
                i.draw();
            })
            this.points.each(function(j){
                j.move();
            })
            this.events.renderEvent.fire();
        },
        /**
         *添加动画元素
         */
        addSprite:function(sprite){
            sprite.ctx=this.ctx;
            this.sprites.push(sprite);
        },
        addPoint:function(point){
            this.points.push(point)
        },
        /**
         * 停止动画
         */
        stop:function(){
            clearInterval(this.interval)
        },
        clear:function(){

           
        },
        on:function(type,func,param){
            for(var i in this.EVENT_LIST){
                if(i==type){
                    this.EVENT_LIST[i].push({func:func,param:param})
                    return;
                }
            }
        }
    }
    return Canvas;
});