define(function(require, exports, module) {
       var p=require("util/point.js")
       var util=require("util/util.js")
    var DrawPolygon=SCD.extend(require("edit/editGO.js"));
    SCD.ap(DrawPolygon,{
        getOptions:function(){
            return [
            ["线条颜色",this.strokeStyle,"text",this,"strokeStyle"],
             ["填充颜色",this.fillStyle,"text",this,"fillStyle"],
            ["线条宽度",this.lineWidth,"numberbox",this,"lineWidth"],
 ['是否填充',this.isFill,{
                "type":"checkbox",
                "options":{
                    "on":1,
                    "off":0
                }
            },this,"isFill"]
            ];
        },
        _init:function(){
            this.controls=[
            ];
            this.scaleControls=[
            ]
            this.isCreateEnd=true;
            this.rightClickExit=false;
            this.isFill="1";
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
            this.strokeStyle=this.context.strokeStyle
            this.fillStyle=this.context.fillStyle;
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
            ctx.closePath();
            ctx.stroke();
            ctx.fill();
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
            ctx.lineWidth=this.lineWidth;
            ctx.strokeStyle=this.strokeStyle;
            ctx.fillStyle=this.fillStyle;
            ctx.beginPath();
            ctx.moveTo(c[0].x,c[0].y);
            for(var i=1;i<c.length;i++){
                ctx.lineTo(c[i].x,c[i].y);
            }
            ctx.closePath();
            ctx.stroke();
            parseInt(this.isFill)&&ctx.fill();
             ctx.restore();
        },
        destroy:function(){
            this.isCreateEnd=true;
            this.context.clearSub();
        //   this.end()
        },
        getCompress:function(){
            var str="G:"
            $.each(this.controls,function(i,n){
                str+=n.x+","+n.y+" "
            })
            str+="|"+this.strokeStyle+"|"+this.lineWidth+"|"+this.fillStyle;
            this.compressStr=str
            return str;
        },
        isIn:function(pos){
            return util.checkPP(pos,this.controls)
        } ,
        setScale:function(){
            var scale=this.context.scale;
            var now=this;
            $.each(this.controls,function(i,n){
                 now.scaleControls[i]=now.context.getScreenPos(n)
            })
        }
    });
    return DrawPolygon
});

