define(function(require, exports, module) {
    var Point=require("util/point.js")
    var util={
        //向量叉乘
        crossMul:function(v1,v2){
            return v1.x*v2.y-v1.y*v2.x;
        },
        //判断两条线段是否相交
        checkCross:function(p1,p2,p3,p4){
            var v1={
                x:p1.x-p3.x,
                y:p1.y-p3.y
            },
            v2={
                x:p2.x-p3.x,
                y:p2.y-p3.y
            },
            v3={
                x:p4.x-p3.x,
                y:p4.y-p3.y
            },
            v=this.crossMul(v1,v3)*this.crossMul(v2,v3)
            v1={
                x:p3.x-p1.x,
                y:p3.y-p1.y
            }
            v2={
                x:p4.x-p1.x,
                y:p4.y-p1.y
            }
            v3={
                x:p2.x-p1.x,
                y:p2.y-p1.y
            }
            return (v<=0&&this.crossMul(v1,v3)*this.crossMul(v2,v3)<=0)?true:false
        },
        //检测点是否在多边形内
        checkPP:function(point,polygon){
            var p1,p2,p3,p4
            p1=point
            p2={
                x:-100,
                y:point.y
            }
            var count=0
            //对每条边都和射线作对比
            for(var i=0;i<polygon.length-1;i++){
                p3=polygon[i]
                p4=polygon[i+1]
                if(this.checkCross(p1,p2,p3,p4)==true){
                    count++
                }
            }
            p3=polygon[polygon.length-1]
            p4=polygon[0]
            if(this.checkCross(p1,p2,p3,p4)==true){
                count++
            }
            //  console.log(count)
            return (count%2==0)?false:true
        },
        //  //  B(u) = P0 * ( 1 - u ) 2 + P1 * 2 * u ( 1 - u ) + P2 u2
        //P0 * ( 1 - u )3 + P1 * 3 * u * ( 1 - u )2 + P2 * 3 * u2 * ( 1 - u ) + P3 * u3
        //三维贝塞尔
        bezier:function(begin,c1,c2,end,t){
            var p=new Point(0,0)
            p.x=begin.x*(1-t)*(1-t)*(1-t)+c1.x*3*t*(1-t)*(1-t)+c2.x*3*t*t*(1-t)+end.x*t*t*t
            p.y=begin.y*(1-t)*(1-t)*(1-t)+c1.y*3*t*(1-t)*(1-t)+c2.y*3*t*t*(1-t)+end.y*t*t*t
            return p;
        },
        //二维贝塞尔
        quadratic:function(begin,c1,end,t){
            var p=new Point(0,0)
            p.x=begin.x*(1-t)*(1-t)+c1.x*2*t*(1-t)+end.x*t*t
            p.y=begin.y*(1-t)*(1-t)+c1.y*2*t*(1-t)+end.y*t*t
            return p;
        },
        //打碎三维贝塞尔
        brokenBezier:function(begin,c1,c2,end,partCount){
            var partCount=partCount||10;
            var points=[]
            var t=0;
            for(var t=0;t<=1;t+=1/partCount){

                points.push(this.bezier(begin,c1,c2,end,t));
            }
            return points;
        },
        //打碎二维贝塞尔
        brokenQuadratic:function(begin,c1,end,partCount){
            var partCount=partCount||10;
            var points=[]
            var t=0;
            for(var t=0;t<=1;t+=1/partCount){

                points.push(this.quadratic(begin,c1,end,t));
            }
            return points;
        },
        exchange:function(p1,p2){
            var p=new Point();
            p.x=p2.x;
            p.y=p2.y;
            p2.x=p1.x;
            p2.y=p1.y;
            p1.x=p.x;
            p1.y=p.y;

        }
    }
    return util;
});
