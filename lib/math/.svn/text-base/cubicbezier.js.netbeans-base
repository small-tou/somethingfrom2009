/**
 * 这是一个计算三次贝塞尔曲线的对象,需要为每条曲线实例化一个实例,
 * 然后设置四个参考点,第一个和第三个点为起点和终点,其他两个为偏移参考点.
 * 之后在时间线上计算点的坐标
 */
MJ.add("CubicBezier",function(){
    var Matrix=MJ.Matrix
    if(Matrix==undefined) MJ.tool.trace("没有引用矩阵对象:Matrix,无法正常运作!","alert");
    var cubicBezier=function(config){
        this._init(config)
    }
    cubicBezier.prototype={
        _init:function(config){
            var p=this.points=config.points;
            this.m1=new MJ.Matrix();
            this.m2=new MJ.Matrix({
                data:[
                [1,0,0,0],
                [-3,3,0,0],
                [3,-6,3,0],
                [-1,3,-3,1]
                ]
            });
            this.m3=new MJ.Matrix({
                data:[
                p.p0.toArray(),
                p.p1.toArray(),
                p.p2.toArray(),
                p.p3.toArray()
                ]
            })
            this.m=null
        },
        /**
         * 获取某个时间点计算出来的坐标值,时间线不由此类控制
         */
        get:function(t){
            this.m1.set([
                [1,t*t,t*t*t,t*t*t*t]
                ]);
            this.m=this.m1.mul(this.m2).mul(this.m3)
            return new MJ.Vector(this.m.get()[0][0],this.m.get()[0][1]);
        }
    }
    return cubicBezier;
})
