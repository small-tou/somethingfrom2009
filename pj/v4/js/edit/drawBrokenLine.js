define(function(require, exports, module) {
    var p=require("util/point.js")
    var DrawBrokenLine=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawBrokenLine,{
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
            this.context.clearSub();
              this.lineWidth=this.context.lineWidth;
             this.strokeStyle=this.context.strokeStyle;
            this.draw();
            this.context.addGO(this)
           
        },
        lButtonDown:function(pos,posStd){
            this.controls.push(posStd)
            this.scaleControls.push(pos)
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

            ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
            ctx.lineTo(pos.x,pos.y)
            ctx.stroke();
        },
        rButtonDown:function(){
            if(this.controls.length==1){
                this.destroy();
            }else{
                this.end();
            }
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
            ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
            ctx.stroke();
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
            str+="|"+this.strokeStyle+"|"+this.lineWidth
            this.compressStr=str
            return str;
        },
        isIn:function(pos){
            var c=this.controls;
            for(var i=0;i<c.length-1;i++){
                if(pos.distance(c[i])+pos.distance(c[i+1])<c[i+1].distance(c[i])+0.1*this.lineWidth){
                    return true;
                }
            }
            return false;
        } ,
        setScale:function(){

            var now=this;
            var c=this.scaleControls
            $.each(this.controls,function(i,n){
                 c[i]=now.context.getScreenPos(n)
                c[i].x=parseInt(c[i].x)
                    c[i].y=parseInt(c[i].y)
            })
        }
    });
    return DrawBrokenLine;
})

