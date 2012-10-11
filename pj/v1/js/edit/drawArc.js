(function(){
    var p=SCD.Point;
    SCD.DrawArc=SCD.extend(SCD.EditGO);
    SCD.ap(SCD.DrawArc,{
        _init:function(){
            this.controls=[
            new p(0,0),
            new p(0,0),
            new p(0,0)
            ];
            this.step=1;
            this.isCreateEnd=true;
            this.rightClickExit=true;
        },
        //从某处开始画线
        begin:function(pos){
            this.isCreateEnd=false;
            this.controls[0]=pos;
        },
        end:function(){
            console.log("arc_end")
            this.isCreateEnd=true;
            this.draw();
        },
        lButtonDown:function(pos){
            this.step++;
            if(this.step==2){ //确定了半径
                this.controls[1]=pos;
                this.controls[2]=pos;
            }else if(this.step==3){
                this.controls[2]=pos;
                this.end();
            }
        },
        moving:function(pos){
            var ctx=this.context.sub_ctx;
            var canvas=this.context.sub_canvas;
            var c=this.controls;

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
            ctx.clearRect(0,0,canvas.width,canvas.height)
            ctx.beginPath();
            //      ctx.arc(c[0].x,c[1].y,Math.sqrt((c[1].x-c[0].x)*(c[1].x-c[0].x)+(c[1].y-c[0].y)*(c[1].y-c[0].y)),Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x),Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x))
            ctx.arc(c[0].x,c[0].y,r,begin_r,end_r)
            ctx.stroke()
        },
        rButtonDown:function(){

        },
        active:function(){

        },
        draw:function(){
            var ctx=this.context.ctx;
            var canvas=this.context.canvas;
            var c=this.controls;
            var r=0;
            var begin_r=0;
            var end_r=Math.PI*2
            r=c[0].distance(c[1]);
            begin_r=Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x)
            end_r=Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x);
           
            ctx.beginPath();
            //      ctx.arc(c[0].x,c[1].y,Math.sqrt((c[1].x-c[0].x)*(c[1].x-c[0].x)+(c[1].y-c[0].y)*(c[1].y-c[0].y)),Math.atan2(c[1].y-c[0].y,c[1].x-c[0].x),Math.atan2(c[2].y-c[0].y,c[2].x-c[0].x))
            ctx.arc(c[0].x,c[0].y,r,begin_r,end_r)
            ctx.stroke()
        },
        destroy:function(){
             this.isCreateEnd=true;
            this.context.sub_ctx.clearRect(0,0,this.context.canvas.width,this.context.canvas.height)
        }
    });
})();
