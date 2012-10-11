define(function(require, exports, module) {
    var p=require("util/point.js")
    var id=1;
    var cube=function(ctx,cm){
        this.init(ctx,cm)
    }
    cube.prototype={
        init:function(context,cm){
            this.context=context;
            this.cm=cm;
            var el=document.createElement("div");
            el.id="cube"+(++id)
            context.config.container.appendChild(el);
            $(el).css({
                width:4,
                height:4,
                position:"absolute",
                zIndex:1000,
                border:"1px solid #999",
                background:"#00ffff",
                cursor:"move"
            });
            this.mousedown=false;
            var now=this;
            $(el).mousedown(function(){
                now.mousedown=true;
            });
            $(context.config.container).mouseup(function(e){
                now.mousedown=false;
            });
            $(context.config.container).mousemove(function(e){
                
                if(now.mousedown) {
                    if(e.target==el){
                        return;
                    }
                    var x=e.offsetX||e.layerX;
                    var y=e.offsetY||e.layerY;
                    var p=context.capturePos(x,y)
                    $(el).css({
                        left:p.x,
                        top:p.y
                    })
                    p=context.getRealPos(p)
                    now.point.x=p.x;
                    now.point.y=p.y;
                  
                    context.rePaint();
                    now.cm.repaint();
                    now.cm.reoutline()
                }
            });
            this.el=el;
        },
        bind:function(point){
            this.point=point;
            var p=this.context.getScreenPos(point)
            $(this.el).css({
                left:p.x,
                top:p.y,
                display:"block"
            })
         
            
        },
        hide:function(){
            this.el.style.display="none"
        },
        repaint:function(){
            var p=this.context.getScreenPos(this.point)
            $(this.el).css({
                left:p.x,
                top:p.y,
                display:"block"
            })
        }
    }
    var ControlManager=function(){
         
    }
    ControlManager.prototype={
        init:function(ctx){
            this.ctx=ctx;
            this.controls=[];
            this.nowControls=null;
            this.go
            this.isShow=false;
        },
        bind:function(go,rect){
            this.hide();
            this.go=go;
            this.isShow=true;
            this.nowControls=go.controls;
            for(var i =0,l=go.controls.length;i<l;i++){
                var c=go.controls[i];
                if(typeof(this.controls[i])!='undefined'){
                    this.controls[i].bind(c)
                }else{
                    this.controls[i]=new cube(this.ctx,this)
                    this.controls[i].bind(c)
                }
            }
          this.reoutline()
        },
        hide:function(){
            if(this.isShow){
                 for(var i=0;i<this.controls.length;i++){
                this.controls[i].hide();
            }
            this.ctx.clearSub();
            this.isShow=false;
            }
           
        },
        
        repaint:function(){
            if(this.isShow){
            for(var i=0;i<this.controls.length;i++){
                this.controls[i].repaint();
            }
            }
        },
        reoutline:function(){
            if(this.isShow){
            this.go.drawOutline();
            }
        }

    }
    return ControlManager;
     
})

