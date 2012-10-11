(function(){
    var obj={
        line:'DrawLine',
        arc:"DrawArc",
        brokenline:"DrawBrokenLine"
    }
    var p=SCD.Point;
    var contextCount=0;
    var Context=function(){

    }
    Context.prototype={
        init:function(c){
            this.config={
                view_width:1280,
                view_height:800,
                container:null
            }
            SCD.mix(this.config,c)
            this.canvas;
            this.ctx;
            this.effect=0;//0表示当前生效点在context上,1表示生效点在创建新的图形,2表示在选中图形进行操作
            this.nowOBJ=null;

            
            this.active_go=null;
            this.strokeStyle="#111";
            this.lineWidth="2";
            this.fillStyle="#ff6700"
            this.id=contextCount++;

            this.createContext();
            this.bind();
        },
        createContext:function(){
            var config=this.config
            this.canvas=document.createElement("canvas");
            $(this.canvas).attr({
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
            this.ctx=this.canvas.getContext("2d")
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
        },
        changeView:function(data){

        },
        bind:function(){
            var now=this;
            
            $(this.sub_canvas).bind("click",function(e){
               
              
                });
            $(this.sub_canvas).bind("mousedown",function(e){
                e.preventDefault();
                if(e.which==1){
                    var pos=new p(e.offsetX||e.layerX,e.offsetY||e.layerY);
                    if(now.effect==0){//生效在context上
                        var go=new now.nowOBJ();
                        go.init(now);
                        go.begin(pos);
                        now.activeGO(go)
                        now.effect=1;
                    }else if(now.effect==1){
                        now.active_go.lButtonDown(pos)
                        if(now.active_go.isCreateEnd==true){
                            
                            now.effect=0
                        }
                    }else if(now.effect==2){

                }
                }else if(e.which==3){
                    if(now.effect==1){
                        
                        if(now.active_go.rightClickExit==false){
                            now.active_go.end();
                        }else{
                            now.active_go.isCreateEnd||now.active_go.destroy();
                        }
                       // now.active_go=null;
                        now.effect=0;
                    }
                    e.cancelBubble = true 
                    e.returnValue = false; 
                    return false;
                  
                }
            })
            $(this.sub_canvas).bind("mousemove",function(e){
                if(now.effect==0){//生效在context上
                    return;
                }else if(now.effect==1){
                    var pos=new p(e.offsetX||e.layerX,e.offsetY||e.layerY);
                    now.active_go.moving(pos)
                }else if(now.effect==2){
                    
            }

            })
        },
        activeGO:function(go){
            this.active_go=go;
        },
        selectOBJ:function(name){
            this.nowOBJ=SCD[obj[name]]
        }
    }

    SCD.EditContext=Context;
})();

