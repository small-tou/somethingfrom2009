define(function(require, exports, module) {
    var p=require("util/point.js")
    var DrawLine=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawLine,{
        options:[
            ["线条颜色","color",this.context,"lineStyle"],
            ["线条宽度","number",this.context,"lineStyle"]
        ],
        _init:function(){
            this.controls=[
            ];
             this.scaleControls=[
            ]
            this.isCreateEnd=true;
            this.rightClickExit=true;
            this.compressStr="";
            
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
            this.context.clearSub();
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y)
            ctx.lineTo(pos.x,pos.y)
            ctx.stroke();
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
                ctx.save();
                   if(this.lineWidth%2==0){
              ctx.translate(-0.5,-0.5);
           }
            ctx.lineWidth=this.lineWidth;
            ctx.strokeStyle=this.strokeStyle;
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y)
            ctx.lineTo(c[1].x,c[1].y)
            ctx.stroke();
            ctx.restore();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.clearSub();
        },
        getCompress:function(){
            var str="L:"
            $.each(this.controls,function(i,n){
                str+=n.x+","+n.y+" "
            })
            str+="|"+this.context.strokeStyle+"|"+this.context.strokeWidth
            this.compressStr=str
            return str;
        },
        isIn:function(pos){
            var c=this.controls;
            if(pos.distance(c[0])+pos.distance(c[1])<c[1].distance(c[0])+0.1*this.lineWidth){
               return true;
            }else {
                return false;
            }
        }  ,
        setScale:function(){

            var now=this;
            var c=this.scaleControls
            $.each(this.controls,function(i,n){
                now.scaleControls[i]=n.sub(now.context.orgin).mulNum(now.context.scale)
                  c[i].x=parseInt(c[i].x)
                    c[i].y=parseInt(c[i].y)
            })
        }
        
    });
    return DrawLine;
})
