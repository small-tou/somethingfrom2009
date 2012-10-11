MJ.extend("Canvas.Sprite.Circle",MJ.Canvas.Sprite,{
    _init:function(){
        this.r=0;
    },
    _draw:function(){
        var ctx=this.ctx;
        ctx.beginPath();
        ctx.arc(this.pos.x,this.pos.y,this.r,0,Math.PI*2,true); // Outer circle
       
        ctx.stroke();
    },
    _checkEvent:function(e){
        
        return true;
    }
   
});

