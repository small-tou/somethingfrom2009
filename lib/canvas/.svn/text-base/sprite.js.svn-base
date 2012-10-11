/**
     * 精灵对象,类似flash(ActionScript3.0)中的精灵.
     * 所有的动画元素都必须继承自此对象,继承之后自动拥有move方法和速度属性
     * 每个动画元素都必须拥有一个自己的特殊的draw()方法的实现,这个方法用来在渲染每一帧的时候指定自己如何呈现在canvas帧画布上
     * 注意这个所谓的"帧画布"不是指原生的canvas元素,而是指下面定义的一个Canvas对象,此对象的意义就是一个帧,它负责把需要在这一帧上呈现的
     * 图形画在canvas上,然后每一帧开始的时候都会清除上次画的,类似flash中的帧概念
     *
     *关于层级之间的速度和位置信息,必须在调用appendChild之后才能设置位置和速度信息
     */
MJ.add("Canvas.Sprite",function(){
    var CustomEvent=MJ.CustomEvent;
    var Sprite=function(){
        
    }
    Sprite.prototype={
        init:function(){
            this.pos=new MJ.Vector();
            this.events={
                drawEvent:new CustomEvent("draw",this),
                moveEvent:new CustomEvent("move",this)
            }
           
            this.ctx=null;
           
            this._init();
        },
        on:function(type,func,param){
            for(var i in this.EVENT_LIST){
                if(i==type){
                    this.EVENT_LIST[i].push({
                        func:func,
                        param:param
                    })
                    return;
                }
            }
        },
        _init:function(){
          
        },
        /**
         *每个精灵都必须有自己的draw实现
         */
        draw:function(){
            this.events.drawEvent.fire();
            this._draw();
        },
        _draw:function(){
            
        },
        /**
         *无需单独实现,通用的动画函数
         */
        move:function(){
            this.events.moveEvent.fire();
            this._move();
        },
        _move:function(){
            
        },
        /**
         *向此精灵添加一个子精灵
         */
        appendChild:function(sprite){
            if(this.childs==null) this.childs=[]
            this.childs.push(sprite)
        //     sprite.addParent(this);
        },
        /**
         *渲染子精灵
         */
        drawChild:function(){
            if(this.childs!=null&&this.childs.length>0){
                for(var i=0;i<this.childs.length;i++){
                    this.childs[i].draw();
                    this.childs[i].move();
                }
            }
        },
        addParent:function(sprite){
            if(this.parent==null) this.parent=[]
            this.parent.push({
                x:sprite.x,
                y:sprite.y,
                v:sprite.v
            })
        },
        checkEvent:function(){
         return   this._checkEvent()
        },
        _checkEvent:function(){
            return false
        }

    };
    return Sprite;
});
