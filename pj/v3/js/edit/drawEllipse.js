define(function(require, exports, module) {
    var p=require("util/point.js")
    var u=require("util/util.js")
    var DrawEllipse=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawEllipse,{
        _init:function(){
            this.controls=[
            ];
            this.scaleControls=[
            ]
            this.isCreateEnd=true;
            this.rightClickExit=true;
            this.compressStr=""
            this.step=1;
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
            this.controls[1]=posStd;
            this.scaleControls[1]=pos;
            this.end();
        },
        moving:function(pos){
          
        },
        placing:function(pos){
            this.context.switchCtx("sub")
            var ctx=this.context.ctx;
            var canvas=this.context.sub_canvas;
            var c=this.scaleControls;
            var w=Math.abs(pos.x-c[0].x);
            var h=Math.abs(pos.y-c[0].y)
            this.context.clearSub();
            var _isR=(pos.y-c[0].y<0)?-1:1
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y+_isR*h/2)

            ctx.bezierCurveTo(c[0].x,c[0].y-_isR*h/2,pos.x,c[0].y-_isR*h/2,pos.x,c[0].y+_isR*h/2);
            ctx.bezierCurveTo(pos.x,pos.y+_isR*h/2,c[0].x,pos.y+_isR*h/2,c[0].x,c[0].y+_isR*h/2);
            ctx.stroke();
            ctx.fill();
        },
        rButtonDown:function(){
            this.destroy()
        },
        active:function(){

        },
        draw:function(){
            this.setScale();
            this.context.switchCtx("main")
            var ctx=this.context.ctx;
            var canvas=this.context.canvas;
            var c=this.scaleControls;
            var w=Math.abs(c[1].x-c[0].x);
            var h=Math.abs(c[1].y-c[0].y)
            var _isR=(c[1].y-c[0].y<0)?-1:1
            ctx.save();
            ctx.lineWidth=this.lineWidth;
            ctx.strokeStyle=this.strokeStyle;
            ctx.fillStyle=this.fillStyle;
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y+_isR*h/2)

            ctx.bezierCurveTo(c[0].x,c[0].y-_isR*h/2,c[1].x,c[0].y-_isR*h/2,c[1].x,c[0].y+_isR*h/2);
            ctx.bezierCurveTo(c[1].x,c[1].y+_isR*h/2,c[0].x,c[1].y+_isR*h/2,c[0].x,c[0].y+_isR*h/2);
            ctx.stroke();
            ctx.fill();
            ctx.restore();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.clearSub();
        },
        getCompress:function(){
            var str="E:"
            var c=this.controls;
            str+=c[0].x+"|"+c[0].y+"|"+c[1].x+"|"+c[1].y+"|"+this.strokeStyle+"|"+this.lineWidth+"|"+this.fillStyle;
            this.compressStr=str
            return str;
        },
        isIn:function(pos){
            var c=this.scaleControls;
            if(pos.distance(c[0])+pos.distance(c[1])<c[1].distance(c[0])+0.1*this.lineWidth){
                return true;
            }else {
                return false;
            }
        } ,
        setScale:function(){

            var now=this;
            $.each(this.controls,function(i,n){
                now.scaleControls[i]=n.sub(now.context.orgin).mulNum(now.context.scale)
            })
        }
    });
    return DrawEllipse;
});
