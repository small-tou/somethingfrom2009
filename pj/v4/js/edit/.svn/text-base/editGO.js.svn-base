define(function(require, exports, module) {
    var p=require("util/point.js")
    var EditGO=SCD.extend(require("baseGraphic.js"));
    SCD.ap(EditGO,{
        _init:function(){
            
        },
        //从某处开始画线
        begin:function(pos){
           
        },
        end:function(){
           
        },
        lButtonDown:function(pos){
          
        },
        moving:function(pos){
          
        },
        placing:function(pos){
            
        },
        rButtonDown:function(){

        },
        active:function(){

        },
        draw:function(){
           
        },
        destroy:function(){
            
        },
        getCompress:function(){
            
        },
        setStyle:function(strokeStyle,strokeWidth,fillStyle){
            this.strokeStyle=strokeStyle
            this.strokeWidth=strokeWidth
            this.fillStyle=fillStyle
        },
        isIn:function(){
            return false;
        },
        setScale:function(scale){
            this.scale=scale;
        },
        inView:function(){
            return true;
        },
        getOptions:function(){
            return [
            ["线条颜色",this.strokeStyle,"text",this,"strokeStyle"],
            ["线条宽度",this.lineWidth,"numberbox",this,"lineWidth"]
            ];
        },
        //获取矩形范围
        getRect:function(){
            var x1,y1,x2,y2;
            for(var i =0;i<this.scaleControls.length;i++){
                var s=this.scaleControls[i];
                if(!(x1)||s.x<x1) x1=s.x;
                if(!(x2)||s.x>x2) x2=s.x;
                if(!(y1)||s.y<y1) y1=s.y;
                if(!(y2)||s.y>y2) y2=s.y;
            }
            return [x1,y1,x2,y2]
        },
        drawOutline:function(){
            this.context.switchCtx("sub");
            this.context.clearSub();
            var ctx=this.context.ctx;
            ctx.save();
            ctx.strokeStyle="#aaa";
            var rect=this.getRect();
            ctx.strokeRect(rect[0],rect[1],rect[2]-rect[0],rect[3]-rect[1])
            ctx.restore();
        }
    });
    return EditGO;
});
