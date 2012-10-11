(function(){
    var p=SCD.Point;
    SCD.DrawBrokenLine=SCD.extend(SCD.EditGO);
    SCD.ap(SCD.DrawBrokenLine,{
        _init:function(){
            this.controls=[
            new p(0,0),
            ];
            this.isCreateEnd=true;
             this.rightClickExit=false;
        },
        //从某处开始画线
        begin:function(pos){
            this.isCreateEnd=false;
            this.controls[0]=pos;
        },
        end:function(){
            this.isCreateEnd=true;
            this.context.sub_ctx.clearRect(0,0,this.context.canvas.width,this.context.canvas.height)
            this.draw();
        },
        lButtonDown:function(pos){
            this.controls.push(pos)
        },
        moving:function(pos){
            var ctx=this.context.sub_ctx;
            var canvas=this.context.sub_canvas;
            var c=this.controls;
            ctx.clearRect(0,0,canvas.width,canvas.height)
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
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
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
            ctx.stroke();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.sub_ctx.clearRect(0,0,this.context.canvas.width,this.context.canvas.height)
         //   this.end()
        }
    });
})();



