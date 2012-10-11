/*
 * @Time:2011-12-30
 * @Encode:UTF-8
 * @Filename:snow.js
 * @Author:tianqi.sxy
 */
(function(){
    if(document.all) return;
    var S=KISSY,DOM=S.DOM,Event=S.Event;
    var random=function(begin,end){
        return Math.random()*(end-begin)+begin;
    }
    var snows=[]
    var snowCount=150
    var Snow=function(){
        this.x=0;
        this.y=0;
        this.speed={
            x:0,
            y:0
        }
        this.a=0;
        this.weight=0;
        this.ele=DOM.create("<div>");
        this.ele.className="snow";
        document.body.appendChild(this.ele)
    }
    Snow.prototype={
        render:function(){
            DOM.css(this.ele,{
                top:this.y,
                left:this.x,
                //'-webkit-transform':' scale(2, 1)'
                width:this.weight/3,
                height:this.weight/3
            });
        },
        winds:function(winds){
            var force={
                x:0,
                y:0
            }
            for(var i in winds){
                var x=(1/(this.x-winds[i].x)*(this.x-winds[i].x))*winds[i].level;
                var y=(1/(this.y-winds[i].y)*(this.x-winds[i].x))*winds[i].level;
                force.x+=x;
                force.y+=y;
            }
            this.a={
                x:force.x/this.weight+random(0,0.04),
                y:force.y/this.weight+0.05
            }
            this.speed.x+=this.a.x
            this.speed.y+=this.a.y

    
        }
    }
    var Wind=function(){
        this.x=0;
        this.y=0;
        this.level=100;
    }
    Wind.prototype={
        
    }
    for(var i=0;i<snowCount;i++){
        var snow=new Snow()
        snow.x=random(0,DOM.viewportWidth())
        snow.y=random(-600,0)
        snow.speed.x=0;
        snow.speed.y=random(1,5);
        snow.a={
            x:0,
            y:8
        }
        snow.weight=random(10,50)
        snow.render();
    
        snows.push(snow)
    
    }
    var winds=[]
    //var mouseWind=new Wind();
    //mouseWind.level=10;
    //Event.on(window,"mousemove",function(e){
    //      mouseWind.x=e.pageX;
    //      mouseWind.y=e.pageY;
    //    })
    //winds.push(mouseWind)
    var canvas=DOM.create("<canvas>");
    DOM.css(canvas,{
        width:DOM.viewportWidth(),
        height:100,
        position:"fixed",
        left:0,
        bottom:0,
        zIndex:-1000
    })
    document.body.appendChild(canvas)
    var ctx=canvas.getContext("2d");
    var img=new Image();
    img.src="11.png";
    img.onload=function(){
        var count=0
        setInterval(function(){
            var viewWidth=DOM.viewportWidth()-50
            var viewHeight=DOM.viewportHeight()-50
            for(var i=0;i<snowCount;i++){
                var snow=snows[i]
                snow.winds(winds)
            
                if(snow.x>viewWidth||snow.y>viewHeight){
                    snow.x=random(0,viewWidth)
                    snow.y=random(-100,0)
                    snow.speed.x=0;
                    snow.speed.y=random(1,5);
                    snow.a={
                        x:0,
                        y:0.8
                    }
                    snow.render();
                    
                }else{
                    snow.x=snow.x+snow.speed.x      
                    snow.y=snow.y+snow.speed.y
                    snow.render()
            
                }
                if(snow.y>viewHeight){
                    count++;
                    ctx.drawImage(img,0,0,128,128,snow.x,130-count/100,snow.weight/4,snow.weight/4)
                }
            }
        },30)
    }
    

})();
