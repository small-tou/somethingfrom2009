define(function(require, exports, module) {
   
    var obj={
        line:require("edit/drawL.js"),
        arc:require("edit/drawArc.js"),
        brokenline:require("edit/drawBrokenLine.js"),
        bezier:require("edit/drawBezier.js"),
        polygon:require("edit/drawPolygon.js"),
        rect:require("edit/drawRect.js"),
        ellipse:require("edit/drawEllipse.js")
    }
    var p=require("util/point.js")
    var cm=require("edit/controlManager.js")
    var option=require("edit/option.js")
    var contextCount=0;
    var Context=function(){

    }
    Context.prototype={
        init:function(c){
            this.config={
                view_width:1280,
                view_height:800,
                container:null,
                gridSize:10
            }
            SCD.mix(this.config,c)
            this.canvas;
            this.ctx;
            this.effect=0;//0表示当前生效点在context上,1表示生效点在创建新的图形,2表示选中操作
            this.nowOBJ=null;
            this.GOs=[]
            this.active_go=null;
            this.strokeStyle="#000";
            this.strokeWidth="2";
            this.fillStyle="#000"
            this.lineWidth=1;
            this.id=contextCount++;
            this.scale=1;
            this.mousedown=false;
            this.orgin=new p(); //视野相对原点的偏移
            this.orginDirect=0; 
            this.option=option;
            this.lastX=null;
            this.lastY=null;
            this.gridSize=this.config.gridSize
            this.gridCapture=false;
            this.cm=new cm();
            this.createContext();
            this.bind();
        },
        createContext:function(){
            var config=this.config
            this.main_canvas=document.createElement("canvas");
            $(this.main_canvas).attr({
                width:config.view_width,
                height:config.view_height,
                id:"main_view_"+this.id
            }).css({
                position:"absolute",
                top:"0",
                left:"0",
                zIndex:"1"
            }).appendTo(config.container).bind("contextmenu",function(){
                return false;
            })
            this.main_ctx=this.main_canvas.getContext("2d")
            this.sub_canvas=document.createElement("canvas");
            $(this.sub_canvas).attr({
                width:config.view_width,
                height:config.view_height,
                id:"sub_view_"+this.id
            }).css({
                position:"absolute",
                top:"0",
                left:"0",
                zIndex:"10"
            }).appendTo(config.container).bind("contextmenu",function(){
                return false;
            })
            this.sub_ctx=this.sub_canvas.getContext("2d")
            this.grid_canvas=document.createElement("canvas");
            $(this.grid_canvas).attr({
                width:config.view_width,
                height:config.view_height,
                id:"sub_view_"+this.id
            }).css({
                position:"absolute",
                top:"0",
                left:"0",
                zIndex:"0"
            }).appendTo(config.container).bind("contextmenu",function(){
                return false;
            })
            this.grid_ctx=this.grid_canvas.getContext("2d")
            
            this.main_ctx.translate(0.5,0.5);
            this.sub_ctx.translate(0.5,0.5);
        },
        changeView:function(data){

        },
        switchCtx:function(to){
            if(to=="main"){
                this.ctx=this.main_ctx;
            }else if(to=="sub"){
                this.ctx=this.sub_ctx;
            }
        },
        bind:function(){
            var now=this;

            $(this.sub_canvas).bind("click",function(e){


                });
            $(this.sub_canvas).bind("mouseup",function(e){
                now.mousedown=false;
            })
            $(this.sub_canvas).bind("mousedown",function(e){
                e.preventDefault();
                now.mousedown=true;
                if(e.which==1){

                    var pos=now.capturePos(e.offsetX||e.layerX,e.offsetY||e.layerY)
                    if(now.effect==0){//生效在context上
                        var go=new now.nowOBJ();
                        go.init(now);
                        go.begin(pos,pos.mulNum(1/now.scale).add(now.orgin));
                        now.activeGO(go)
                        now.effect=1;
                    }else if(now.effect==1){ //移交到元件操作
                        now.active_go.lButtonDown(pos,pos.mulNum(1/now.scale).add(now.orgin))
                        if(now.active_go.isCreateEnd==true){
                            now.effect=0
                        }
                    }else if(now.effect==2){//选择中
                        $.each(now.GOs,function(i,n){
                            if(n.isIn(pos)){
                                alert("select")
                            }
                        })
                    }else if(now.effect==3){
                        now.orgin.x+=pos.x-now.config.view_width/2;
                        now.orgin.y+=pos.y-now.config.view_height/2;
                        now.rePaint()
                    }
                }else if(e.which==3){
                    if(now.effect==1){
                        now.active_go.rButtonDown(pos);
                        // now.active_go=null;
                        now.effect=0;
                    }
                    e.cancelBubble = true
                    e.returnValue = false;
                    return false;

                }
            })
            $(this.sub_canvas).bind("touchStart",function(e){
                e.preventDefault();
                now.mousedown=true;
                if(e.which==1){

                    var pos=now.capturePos(e.offsetX||e.layerX,e.offsetY||e.layerY)
                    if(now.effect==0){//生效在context上
                        var go=new now.nowOBJ();
                        go.init(now);
                        go.begin(pos,pos.mulNum(1/now.scale).add(now.orgin));
                        now.activeGO(go)
                        now.effect=1;
                    }else if(now.effect==1){
                        now.active_go.lButtonDown(pos,pos.mulNum(1/now.scale).add(now.orgin))
                        if(now.active_go.isCreateEnd==true){
                            now.effect=0
                        }
                    }else if(now.effect==2){//选择中
                        $.each(now.GOs,function(i,n){
                            if(n.isIn(pos)){
                                alert("select")
                            }
                        })
                    }
                }else if(e.which==3){
                    if(now.effect==1){
                        now.active_go.rButtonDown(pos);
                        // now.active_go=null;
                        now.effect=0;
                    }
                    e.cancelBubble = true
                    e.returnValue = false;
                    return false;

                }
            })
            $(this.sub_canvas).bind("mousemove",function(e){
                var x=e.offsetX||e.layerX;
                var y=e.offsetY||e.layerY;
               
                if(now.effect==0){//生效在context上
                    return;
                }else if(now.effect==1){
                    var pos=now.capturePos(e.offsetX||e.layerX,e.offsetY||e.layerY)
                    now.active_go.placing(pos)
                }else if(now.effect==2){
                    var pos=now.capturePos(e.offsetX||e.layerX,e.offsetY||e.layerY)
                    now.active_go.moving(pos)
                }else if(now.effect==5){ //拖动视野
                    if(now.mousedown&&now.lastX!==null&&now.lastY!==null){
                        now.orgin.x-=x-now.lastX;
                        now.orgin.y-=y-now.lastY;
                        now.rePaint()
                    }
                    now.lastX=x;
                    now.lastY=y;
                }
               

            });
            $(this.sub_canvas).bind("mousewheel",function(e){
                if(e.wheelDelta >0){
                    now.setScale(now.scale+now.scale*0.25)
                }else{
                    now.setScale(now.scale-now.scale*0.25)
                }
                  
                e.preventDefault();
            });
           
        },
        activeGO:function(go){
            this.active_go=go;
        },
        selectOBJ:function(name){
            this.nowOBJ=obj[name]
            this.effect=0
        },
        setEffect:function(type){
            this.effect=type;
        },
        addGO:function(go){
            this.GOs.push(go)
        },
        toJSON:function(){
            var json={
                part:[

            ]
            }
            $.each(this.GOs,function(i,n){
                json.part.push(n.getCompress())
            })
            return json;
        },
        setStrokeStyle:function(style){
            this.strokeStyle=style;
            this.sub_ctx.strokeStyle=style;
            this.main_ctx.strokeStyle=style;
        },
        setLineWidth:function(width){
            this.lineWidth=width;
            this.sub_ctx.lineWidth=width;
            this.main_ctx.lineWidth=width;
        },
        setFillStyle:function(style){
            this.fillStyle=style;
            this.sub_ctx.fillStyle=style;
            this.main_ctx.fillStyle=style;
        },
        clearSub:function(){
            this.sub_ctx.clearRect(0,0,this.sub_canvas.width,this.sub_canvas.height)
        },
        capturePos:function(x,y){
            x=this.gridCapture?Math.round(x/this.gridSize/this.scale)*this.gridSize*this.scale:x;
            y=this.gridCapture?Math.round(y/this.gridSize/this.scale)*this.gridSize*this.scale:y;
            return new p(x,y);
        },
        setScale:function(scale){
            this.scale=scale;
            this.gridSize=this.config.gridSize*scale;
            
            this.rePaint()
            this.redrawGrid();
        },
        rePaint:function(){
            this.main_ctx.clearRect(0,0,this.main_canvas.width,this.main_canvas.height)
            $.each(this.GOs,function(i,n){
                if(n.inView()){
                    n.draw()
                }
                
            })
        },
        redrawGrid:function(){
            if(!this.gridCapture) return;
            this.hideGrid();
            var w=this.config.view_width;
            var h=this.config.view_height;
            var g=this.gridSize*this.scale;
            var ctx=this.grid_ctx;
            ctx.lineWidth=1;
            ctx.strokeStyle="#aaa"
            ctx.beginPath();
            for(var i =0;i<w/g;i++){
                ctx.moveTo(i*g,0);
                ctx.lineTo(i*g,h)
            }
            for(var i =0;i<h/g;i++){
                ctx.moveTo(0,i*g);
                ctx.lineTo(w,i*g)
            }
            ctx.stroke();
        },
        hideGrid:function(){
            this.grid_ctx.clearRect(0,0,this.grid_canvas.width,this.grid_canvas.height)
        },
        setOrigin:function(x,y){
            this.orgin.x=x-this.config.view_width/2;
            this.orgin.y=y-this.config.view_height/2;
        } 

    }
    return Context;
});


