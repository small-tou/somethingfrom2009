(function(){
    var p=SCD.Point;
    SCD.DrawLine=SCD.extend(SCD.EditGO);
    SCD.ap(SCD.DrawLine,{
        _init:function(){
            this.controls=[
            new p(0,0),
            new p(0,0)
            ];
            this.isCreateEnd=true;
             this.rightClickExit=true;
        },
        //从某处开始画线
        begin:function(pos){
            this.isCreateEnd=false;
            this.controls[0]=pos;
        },
        end:function(){
            this.isCreateEnd=true;
            this.draw();
        },
        lButtonDown:function(pos){
            this.controls[1]=pos;
            this.end();
        },
        moving:function(pos){
            var ctx=this.context.sub_ctx;
            var canvas=this.context.sub_canvas;
            var c=this.controls;
            ctx.clearRect(0,0,canvas.width,canvas.height)
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y)
            ctx.lineTo(pos.x,pos.y)
            ctx.stroke();
        },
        rButtonDown:function(){
            
        },
        active:function(){
            
        },
        draw:function(){
            var ctx=this.context.ctx;
            var canvas=this.context.canvas;
            var c=this.controls;
            //    ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y)
            ctx.lineTo(c[1].x,c[1].y)
            ctx.stroke();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.sub_ctx.clearRect(0,0,this.context.canvas.width,this.context.canvas.height)
        }
    });
})();
