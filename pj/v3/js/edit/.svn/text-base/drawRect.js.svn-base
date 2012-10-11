define(function(require, exports, module) {
    var p=require("util/point.js")
    var u=require("util/util.js")
    var DrawRect=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawRect,{
        _init:function(){
            this.controls=[
            ];
            this.scaleControls=[
            ]
            this.isCreateEnd=true;
            this.rightClickExit=false;
        },
        //从某处开始画线
        begin:function(pos,posStd){
            this.isCreateEnd=false;
this.controls[0]=posStd
            this.scaleControls[0]=pos
        },
        end:function(){
            this.isCreateEnd=true;
            this.lineWidth=this.context.lineWidth;
            this.strokeStyle=this.context.strokeStyle;
            this.fillStyle=this.context.fillStyle;
          
            this.draw();
            this.context.addGO(this)
              this.context.clearSub();
        },
        lButtonDown:function(pos,posStd){
            this.controls.push(posStd)
            this.scaleControls.push(pos);
            this.end();
        },
        moving:function(pos){
          
        },
        placing:function(pos){
            this.context.switchCtx("sub")
            var ctx=this.context.ctx;
            var canvas=this.context.sub_canvas;
            var c=this.scaleControls;
            this.context.clearSub();
            ctx.fillRect(c[0].x,c[0].y,pos.x-c[0].x,pos.y-c[0].y)
            ctx.strokeRect(c[0].x,c[0].y,pos.x-c[0].x,pos.y-c[0].y)

        },
        rButtonDown:function(){
            this.destroy();
        },
        active:function(){

        },
        draw:function(){
              this.setScale();
            this.context.switchCtx("main")
            var ctx=this.context.ctx;
            var canvas=this.context.canvas;
            var c=this.scaleControls;
           ctx.save();
           if(this.lineWidth%2==0){
              ctx.translate(-0.5,-0.5);
           }
            ctx.lineWidth=this.lineWidth;
            ctx.strokeStyle=this.strokeStyle;
            ctx.fillStyle=this.fillStyle;
            ctx.fillRect(c[0].x,c[0].y,c[1].x-c[0].x,c[1].y-c[0].y)
            ctx.strokeRect(c[0].x,c[0].y,c[1].x-c[0].x,c[1].y-c[0].y)
            ctx.restore();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.clearSub();
        //   this.end()
        },
        getCompress:function(){
            var str="L:"
            $.each(this.controls,function(i,n){
                str+=n.x+","+n.y+" "
            })
            str+="|"+this.strokeStyle+"|"+this.lineWidth+"|"+this.fillStyle
            this.compressStr=str
            return str;
        },
        isIn:function(pos){
            var c=this.scaleControls;
            if(pos.x>c[0].x&&pos.y>c[0].y&&pos.x<c[1].x&&pos.y<c[1].y){
                return true;
            }
            else{
                return false;
            }
        },
        setScale:function(){

           var now=this;
            var c=this.scaleControls
            $.each(this.controls,function(i,n){
                c[i]=n.sub(now.context.orgin).mulNum(now.context.scale)
                c[i].x=parseInt(c[i].x)
                c[i].y=parseInt(c[i].y)
            })
        }
    });
    return DrawRect;
})

