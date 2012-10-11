MJ.add("Vector3D",function(){
    /**
     *一个缩减版的向量对象,用来表示坐标位置,可以做向量运算
     *程序中所有涉及三维运算的例如:位置,大小等都以此做为基本数据结构,但是如果需要使用其高级功能,需要引入base-extend.js
     *所以可以减少大量的代码书写,可以串行运算
     */
    Vector=function(x,y,z){
        this.x=x||0;
        this.y=y||0;
        this.z=z||0;
    }
    /**
     *函数的依赖关系,在按需压缩的时候用
     */
    
    Vector.prototype={
        /*~!Vector*/
        toArray:function(){
            return [this.x,this.y,this.z]
        },
        /**
         *向量加法
         *@param vector3d v 相加的向量
         *@return vector3d 相加的结果
         */
        add:function(v){
            this.x=this.x+v.x
            this.y=this.y+v.y
            this.z=this.z+v.z
            return this;
        },
        /**
         *向量减法
         *@param vector3d v 相减的向量
         *@return vector3d 相减的结果
         */
        sub:function(v){
            this.x=this.x-v.x
            this.y=this.y-v.y
            this.z=this.z-v.z
            return this;
        },
        /**
         *获取向量的模
         *@return number 向量的模
         */
        getMod:function(){
            return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z);
        },
        /**
         *向量与数相乘
         *@param number num 要相乘的数
         *@return vector3d 相乘的结果
         */
        mulNum:function(num){
            this.x=this.x*num;
            this.y=this.y*num;
            this.z=this.z*num
            return this;
        },
        /**
         *取反
         *@return vector3d 取反后的结果
         */
        getNev:function(){
            this.x=-this.x;
            this.y=-this.y;
            this.z=-this.z;
            return this;
        },
        /**
         *返回一个常数代表b在a上的投影乘以a的长度
         *=a*b=|a|*|b|*cosθ
         *@param vector3d v b向量
         *@return number 
         */
        dotMul:function(v){
            return this.x*v.x+this.y*v.y+this.z*v.z;
        },
        /**
         *叉乘
         *垂直于a和b,|a*b|大小等于a和b组成的平行四边形的面积
         *@param vector3d v b向量
         *@return vector3d 叉乘的结果
         */
        crossMul:function(v){
            this.x=this.y*v.z-this.z*v.y;
            this.y=this.z*v.x-this.x*v.z;
            this.z=this.x*v.y-this.y*v.z;
            return   this;
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
       
        isZero:function(){
            if(this.x==0&&this.y==0) return true;else return false;
        },
        toString:function(){
            return this.x+":"+this.y;
        }
    /*END~!Vector*/
    }
    return Vector;
});