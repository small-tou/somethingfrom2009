define(function(require, exports, module) {
    var matrix=function(config){
        this._init(config)
    }
    matrix.prototype={
        _init:function(config){
            if(config&&config.data)
                this.data=config.data;
        },
        /**
         * 矩阵相乘
         * @param {matrix} m 被乘的矩阵
         */
        mul:function(m){
            var r=[],s=this.data,m=m.data,
            p=s[0].length //每次运算相加的次数
            if(m.length!=s[0].length) {
                console.log("矩阵不能相乘")
            }
            for(var i =0;i<s.length;i++){
                r[i]=[]
                for(var n=0;n<m[0].length;n++){
                    r[i][n]=0;
                    for(var l=0;l<p;l++){
                        r[i][n]+=s[i][l]*m[l][n];
                    }
                }
            }
            this.data=r;
            return this;
        },
        set:function(data){
            this.data=data;
        },
        get:function(){
            return this.data
        },
        toString:function(){
            return this.data.to_s()
        }
    };
    return matrix;
});