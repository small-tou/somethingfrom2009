define(function(require, exports, module) {
    var p=require("util/point.js")
     var u=require("util/util.js")
    var DrawBezier=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawBezier,{
        _init:function(){
            this.controls=[
            ];
            this.scaleControls=[
            ]
            this.isCreateEnd=true;
            this.rightClickExit=false;
            this.step=1;
            this.compressStr=""
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
            this.lineWidth=this.context.lineWidth
            this.strokeStyle=this.context.strokeStyle;
            this.draw();
            this.context.addGO(this)
        },
        lButtonDown:function(pos,posStd){
            this.step++;
            this.controls.push(posStd)
            this.scaleControls.push(pos)
        },
        moving:function(pos){
           

        },
        placing:function(pos){
            this.context.switchCtx("sub")
            var ctx=this.context.ctx;
            var c=this.scaleControls;
            this.context.clearSub();
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y)

            for(var i=2;i<c.length;i++){
                if(i%3==0){
                    ctx.bezierCurveTo(c[i-2].x,c[i-2].y,c[i-1].x,c[i-1].y,c[i].x,c[i].y);
                }
            }
            var l=c.length;
            if(l>=2){
                if(l%3==2)   ctx.quadraticCurveTo(c[l-1].x,c[l-1].y,pos.x,pos.y);
                else if(l%3==0) ctx.bezierCurveTo(c[l-2].x,c[l-2].y,c[l-1].x,c[l-1].y,pos.x,pos.y);
            }

            ctx.stroke();
            //画虚线框,参考点
            ctx.beginPath();
            ctx.save()
            ctx.strokeStyle="#ddd";
            ctx.lineWidth="2"
            ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
            ctx.lineTo(pos.x,pos.y)
            ctx.stroke();
            ctx.restore();
        },
        rButtonDown:function(){
            if(this.controls.length==2){
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
            ctx.lineWidth=this.lineWidth;
            ctx.strokeStyle=this.strokeStyle;
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y)
            //每三个点产生一个三次贝塞尔.最后如果剩下两个点,则画二次贝塞尔
            for(var i=2;i<c.length;i++){
                if(i%3==0){
                    ctx.bezierCurveTo(c[i-2].x,c[i-2].y,c[i-1].x,c[i-1].y,c[i].x,c[i].y);
                }
            }
            var l=c.length;
            if(l>=2){
                if(l%3==2)   ctx.quadraticCurveTo(c[l-2].x,c[l-2].y,c[l-1].x,c[l-1].y);
                else if(l%3==0) ctx.bezierCurveTo(c[l-3].x,c[l-3].y,c[l-2].x,c[l-2].y,c[l-1].x,c[l-1].y);
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
            var str="B:"
            $.each(this.controls,function(i,n){
                str+=n.x+","+n.y+" "
            })
            str+="|"+this.strokeStyle+"|"+this.lineWidth
            this.compressStr=str
            return str;
        },
        isIn:function(pos){
            var c=this.controls;
            var ctx=this.context.sub_ctx
            //每三个点产生一个三次贝塞尔.最后如果剩下两个点,则画二次贝塞尔
            for(var i=2;i<c.length;i++){
                if(i%3==0){
                    var ps=u.brokenBezier(c[i-3],c[i-2], c[i-1], c[i],10) //打碎曲线到折线
                    for(var n=0;n<ps.length-1;n++){
                        if(pos.distance(ps[n])+pos.distance(ps[n+1])<ps[n+1].distance(ps[n])+0.3*this.lineWidth){
                            return true;
                        }
                    }
                    
                }
            }
            var l=c.length;
            if(l>=2){
                if(l%3==0) {
                    var ps=u.brokenQuadratic(c[l-3], c[l-2], c[l-1],6) //打碎曲线到折线
                    for(var n=0;n<ps.length-1;n++){
                        if(pos.distance(ps[n])+pos.distance(ps[n+1])<ps[n+1].distance(ps[n])+0.3*this.lineWidth){
                            return true;
                        }
                    }
                } 
            }
            return false;
        } ,
        setScale:function(){
            var scale=this.context.scale;
            var now=this;
            $.each(this.controls,function(i,n){
                 now.scaleControls[i]=now.context.getScreenPos(n)
            })
        },
        drawOutline:function(){
            this.context.switchCtx("sub");
           
            var ctx=this.context.ctx;
            var c=this.scaleControls
             this.context.clearSub();
             var rect=this.getRect();
            ctx.save();
            ctx.strokeStyle="#ddd";
            ctx.beginPath();
            ctx.strokeRect(rect[0],rect[1],rect[2]-rect[0],rect[3]-rect[1])
             ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
           // ctx.lineTo(pos.x,pos.y)
            ctx.stroke();
            
            ctx.restore();
        }
    });
    return DrawBezier;
})
