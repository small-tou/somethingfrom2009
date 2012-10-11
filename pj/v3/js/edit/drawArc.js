define(function(require, exports, module) {
    var p=require("util/point.js")
    var DrawArc=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawArc,{
        _init:function(){
            this.controls=[
            ];
            this.scaleControls=[
            ]
            this.step=1;
            this.isCreateEnd=true;
            this.rightClickExit=true;
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
            this.context.clearSub();
            this.draw();
            this.context.addGO(this)
           
        },
        lButtonDown:function(pos,posStd){
            this.step++;
            if(this.step==2){ //确定了半径
                this.controls[1]=posStd
                this.controls[2]=posStd
                this.scaleControls[1]=pos
                this.scaleControls[2]=pos
            }else if(this.step==3){
                this.controls[2]=posStd
                this.scaleControls[2]=pos
                this.end();
            }
            
        },
        moving:function(pos){
            
        },
        placing:function(pos){
            this.context.switchCtx("sub")
            var ctx=this.context.ctx;
            var canvas=this.context.sub_canvas;
            var c=this.scaleControls;

            var r=0;
            var begin_r=0;
            var end_r=Math.PI*2
            if(this.step==1){
                r=c[0].distance(pos)

            }else if(this.step==2){
                r=c[0].distance(c[1]);
                begin_r=Math.atan2(pos.y-c[0].y,pos.x-c[0].x)
                end_r=Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x);
            }
            this.context.clearSub();
            ctx.beginPath();
            //      ctx.arc(c[0].x,c[1].y,Math.sqrt((c[1].x-c[0].x)*(c[1].x-c[0].x)+(c[1].y-c[0].y)*(c[1].y-c[0].y)),Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x),Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x))
            ctx.arc(c[0].x,c[0].y,r,begin_r,end_r)
            ctx.stroke()
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
            var c=this.scaleControls;
            var r=0;
            var begin_r=0;
            var end_r=Math.PI*2
            r=c[0].distance(c[1]);
            begin_r=Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x)
            end_r=Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x);
          ctx.save();
          ctx.lineWidth=this.lineWidth;
            ctx.strokeStyle=this.strokeStyle;
            ctx.beginPath();
            ctx.arc(c[0].x,c[0].y,r,begin_r,end_r)
            ctx.stroke();
            ctx.restore();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.clearSub();
        },
        getCompress:function(){
            var c=this.controls;
            var r=c[0].distance(c[1]),
            begin_r=Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x),
            end_r=Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x);
            var temp=[
            c[0].x,
            c[0].y,
            r,
            begin_r,
            end_r,
            this.strokeStyle,
            this.lineWidth
            ]
            this.compressStr="A:"+temp.join("|")
            return this.compressStr;
        },
        isIn:function(pos){
            var c=this.scaleControls;
            var r2=c[0].distance(c[1])
            var p2=Math.PI*2
            
            var _r2=pos.distance(c[0])
            if(Math.abs(r2-_r2)<this.lineWidth){
                var begin_r=Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x),
                end_r=Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x);
                if(begin_r<0) begin_r=-begin_r;
                else begin_r=2*Math.PI-begin_r;
                var angle=Math.atan2(pos.y-c[0].y,pos.x-c[0].x);
                if(angle<0) angle=-angle
                else angle=p2-angle

                if(end_r>0){ //都是逆时针画出来的
                    
                    begin_r+=Math.abs(end_r);
                    begin_r>p2&&(begin_r-=p2);
                    angle+=Math.abs(end_r)
                    angle>p2&&(angle-=p2);
                    end_r=0;
                }else{
                    begin_r-=Math.abs(end_r);
                    begin_r<0&&(begin_r+=p2);
                    angle-=Math.abs(end_r)
                    angle<0&&(angle+=p2);
                    end_r=0;
                }
                if(begin_r>end_r){
                    
                    if(angle>end_r&&angle<begin_r) return true;
                    else return false;
                }else{
                    if(angle<end_r&&angle>begin_r) return true;
                    else return false;
                }
            }
            return false;
        } ,
        setScale:function(){
            
            var now=this;
            $.each(this.controls,function(i,n){
                now.scaleControls[i]=n.sub(now.context.orgin).mulNum(now.context.scale)
            })
        }
    });
    return DrawArc;
});
