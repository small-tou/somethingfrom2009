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
        }
    });
    return EditGO;
});
