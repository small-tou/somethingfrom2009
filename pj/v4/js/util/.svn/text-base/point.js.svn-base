define(function(require, exports, module) {
var Point=function(x,y){
        this.x=x||0;
        this.y=y||0;
    }

    Point.prototype={
        /*~!Vector*/
        toArray:function(){
            return [this.x,this.y]
        },
        add:function(v){
            return new Point(this.x+v.x,this.y+v.y);
        },
        sub:function(v){
            return new Point(this.x-v.x,this.y-v.y);
        },
        getMod:function(){
            return Math.sqrt(this.x*this.x+this.y*this.y);
        },
        mulNum:function(num){
            return new Point(this.x*num,this.y*num);
        },
        getNegative:function(){
            return new Point(-this.x,-this.y);
        },
        /**
         *返回一个常数代表b在a上的投影乘以a的长度
         */
        dotMul:function(v){
            return this.x*v.x+this.y*v.y;
        },
        crossMul:function(v){
            return   this.x*v.y-this.y*v.x;
        },
        /**
         *获取夹角,注意返回的是角度
         */
        getAngle:function(v){
            return Math.acos(this.dotMul(v)/(this.getMod()*v.getMod()))* 180/Math.PI;

        },
        /**
         *获取夹角,返回的是弧度
         */
        getRadian:function(v){
            var m1=this.getMod(),m2=v.getMod();
            if(m1==0||m2==0){
                return 0;
            }
            return Math.acos(this.dotMul(v)/(m1*m2));
        },
        distance:function(v){
            return Math.sqrt((this.x-v.x)*(this.x-v.x)+(this.y-v.y)*(this.y-v.y))
        },
        distance2:function(v){
            return (this.x-v.x)*(this.x-v.x)+(this.y-v.y)*(this.y-v.y)
        },
        /**
         *求某向量的法向量,返回一个单位向量,其模为1,返回的向量总是指向this向量的右边
         * @return
         */
        getNormal:function(){
            return new Point(this.y/(Math.sqrt(this.x*this.x+this.y*this.y)),-this.x/(Math.sqrt(this.x*this.x+this.y*this.y)));
        },
        reflex:function(v){
            var normal=v.getNormal();//先求法向量
            var angle=this.getAngle(normal);//求与法线的夹角
            return this.sub(normal.mulNum(2*this.dotMul(normal)));
        },
        mirror:function(v){
            return this.reflex(v).getNegative();
        },
        isZero:function(){
            if(this.x==0&&this.y==0) return true;else return false;
        },
        /**
         *判断某个点是否在某个矩形区域里，如果在里面的话，并且存在第四个参数的话（true），
         *就继续判断相对矩形中心点所在象限，最后返回象限，不存在第四个参数返回-1
         *如果不在矩形区域里，就直接返回false
         *
         *@param {vector} t 矩形左上角坐标
         *@param {vector} b 矩形右下角坐标
         *@param {boolean} q 是否返回象限
         *@return {number} 象限或者-1
         */
        isIn:function(t,b,q){
            var r1=this.sub(t),r2=this.sub(b)
            if(r1.x>=0&&r1.y>=0&&r2.x<=0&&r2.y<=0){
                if(q){
                    var c=t.add(b).mulNum(0.5)
                    return this.getQ(c)
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        },
        /**
         *获取第一个点相对第二个点所在的象限
         *
         *@param {vector} pc 第二个点的坐标
         */
        getQ:function(pc){
            var r=this.sub(pc);
            if(r.x>=0&&r.y>=0){
                return 4
            }else if(r.x<0 &&r.y>=0){
                return 3
            }else if(r.x<0&&r.y<0){
                return 2
            }else if(r.x>=0&&r.y<0){
                return 1
            }
        },
        toString:function(){
            return this.x+":"+this.y;
        }
    /*END~!Vector*/
    }
    return Point;
});
