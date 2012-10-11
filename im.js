window.im=window.im||{};

(function(){
    /**
     * 局部函数-混合object到prototype
     */
    var ap=function(target,prototypes){
        for(var i in prototypes){
            target.prototype[i]=prototypes[i];
        }
    }
    /**
     * 混合两个object
     */
    var mix=function(target,prototypes){
        for(var i in prototypes){
            target[i]=prototypes[i];
        }
    }
    //给原生数组扩展原型方法
    ap(Array,{
        /**
         *遍历数组的方法
         *@param {function} func 对每个元素执行的方法,将会把当前处理到的元素作为参数传给这个function
         *@param {context} context 方法的上下文
         */
        each:function(func,context){
            if(typeof this.forEach=="function"){
                this.forEach(func, context)
            }else{
                for(var i=0,n=this.length;i<n;i++){
                    func.call(context,this[i],i,this)
                }
            }
        },
        /**
         *判断某个元素是否存在于数组中,是返回true,否返回false
         *@param {object} item 元素
         *@param {object} 按照此元素对比,可以进行第二层的对比,即判断this[i][index]==item[index]
         *@return {boolean} 是否存在
         */
        has:function(item,index){
            if(index!=undefined){
                for(var i=0,j=this.length;i<j;i++){
                    if(this[i][index]==item[index]) return true;
                }
                return false;
            }
            for(var i=0,j=this.length;i<j;i++){
                if(this[i]==item) return true;
            }
            return false;
        }
    });
    mix(im,{
        /**
         *@class MJ.tool
         *@description 这里面存放的是一些工具方法,直接依附在M.tool上
         */
        tool:function(){
            return{
                /**
                 *指示是否是ie,注意这是一个变量,不是一个函数,在初始化后就确定值了
                 *@return {boolean} 是否是ie
                 */
                isIE:function(){
                    if(document.all) return true;
                    return false;
                }(),
                /**
                 *在度量窗口的整体样式的时候会用到
                 */
                body:function(){
                    return document.compatMode=="CSS1Compat" ? document.documentElement : document.body;
                }(),
                /**
                 *去掉字符串的前后空白字符
                 *@return {string} 处理后的字符串
                 */
                trim:function(str){
                    return str.replace(/(^\s*)|(\s*$)/g, "");
                },
                /**
                 *是否是数字
                 *@param {object} o 元素
                 *return {boolean}
                 */
                isNumber:function(o) {
                    return typeof o === "number";
                },
                /**
                 *判断是否是function
                 *@param {object} o
                 *@return {boolean}
                 */
                isFunction:function(o){
                    return typeof o=== "function"
                },
                /**
                 *判断是否是数组
                 *@param {object} o
                 *@return {boolean}
                 */
                isArray: function(o) {
                    if (o) {
                        return this.isNumber(o.length) && this.isFunction(o.splice);
                    }
                    return false;
                },
                /**
                 *判断某个元素是否是节点元素
                 *@param {object} o
                 */
                isElement:function(o) {
                    return !!(o && o.nodeType == 1);
                },
                /****************************扩展object*******************************/
                /**
                 *可以输出一个json的结构
                 *@param {object} o json对象
                 *@return {string}
                 */
                toJsonString:function(o){
                    var r = [];
                    if(typeof o =="string") return "\""+o.replace(/([\'\"\\])/g,"\\$1").replace(/(\n)/g,"\\n").replace(/(\r)/g,"\\r").replace(/(\t)/g,"\\t")+"\"";
                    if(typeof o =="undefined") return "undefined";
                    if(typeof o == "object"){
                        if(o===null) return "null";
                        else if(!o.sort){
                            for(var i in o)
                                r.push("\""+i+"\":"+this.toJsonString(o[i]))
                            r="{"+r.join()+"}"
                        }else{
                            for(var i =0;i<o.length;i++)
                                r.push(this.toJsonString(o[i]))
                            r="["+r.join()+"]"
                        }
                        return r;
                    }
                    return o.toString();
                },
                pickDomain:function(len){
                    var arr=location.hostname.split(".")
                    return arr.splice((arr.length-len)>0?arr.length-len:0).join(".")
                }

            }
        }(),
    });
    mix(im,{
        MODCONFIG:{   //路由信息,定位到不同的模块
            "base":["lib/base.js",["vector"]],
            "ease":["lib/ease.js",["matrix"]],
            "vector":["lib/math/vector.js",[]],
            "matrix":["lib/math/matrix.js",["vector"]],
            "cubicBezier":["lib/math/cubicbezier.js",["matrix"]],
            "anim":["lib/anim.js",["base"]],
            "ui-anim":["lib/anim/ui-anim.js",["anim"]],
            "canvas.base":['lib/canvas/base.js',["base","vector"]],
            "canvas.event":['lib/canvas/event.js',["canvas.base"]],
            "canvas.sprite":['lib/canvas/sprite.js',["canvas.event"]],
            "canvas.sprite.circle":['lib/canvas/sprite/circle.js',["canvas.sprite"]],
            "ui":["ui/M-UI.js",["base","base-extend","anim"]],
            "test":["mod/test.js",['ui-anim','matrix','ease']]
        }
    })
    var MODCONFIG=im.MODCONFIG;
    var loader=function(){
        mix(this,{
            isLoaded:[],//已经加载完的模块
            isLoading:[],//正在加载中的模块
            useFunctions:[],//用在按需异步加载中,用来存储加载完执行的方法和依赖模块的关系,只有所有模块加载完后才执行
            baseUrl:MJBASEURL,
            version:"1.0.3",
            route:MODCONFIG,//模块依赖关系
            relations:{},//最后生成的关系数组
            loadingInfo:{},
            topMod:"",//触发加载的最顶层模块名
            relationCount:0,
            nowIndex:0//现在正在加载的数组的索引
        })
    };
    var now
    ap(loader,{
        init:function(m,f){
            now=this
            this.getRelation(m,f);
            this.load()
        },
        /**
         *生成顶级的加载数组
         */
        getRelation:function(m,f){
            var r=this.relations
            mix(r,{
                data:[],
                func:f
            })
            if(MJ.tool.isArray(m)){
                r.data.push(m);
                this.recur(m)
            }else{
                r.data.push([m]);
                this.recur([m])
            }
            return r;
        },
        /**
         *递归生成加载数组,加载数组的格式:
         *{data:[["aa","bb","cc"],['dd']],func:function(){}}
         */
        recur:function(m){
            var r=this.relations,route=this.route
            var mods=[]//当前层的模块
            m.each(function(i){
                route[i][1].each(function(ii){
                    mods.push(ii)
                })
            })
            //一层层向下递归
            if(mods.length==0) return
            r.data.push(mods)
            this.recur(mods)
        },
        /**
         *
         */
        load:function(){
            var r=this.relations,info=this.loadingInfo
            //将加载关系映射到loadingInfo中,每个加载数组对应一个info对象,里面包含模块数目和模块
            r.data.each(function(i,index){
                i=i.unique()
                info[index]={
                    length:i.length,
                    mods:i
                }
            })
            /*
            loadingInfo={
                "0":{length:1,mods:['test']},
                "1":{length:3,mods:['ui-anim','matrix','ease']},
                "2":{length:3,mods:['anim','vector','matrix']},
                "3":{length:2,mods:['base','vector']},
                "4":{length:1,mods:['vector']}
            }*/
            this.nowIndex=r.data.length-1;
            //
            this.loadScript();
        },
        check:function(mod){

            var info=now.loadingInfo;

            if( info[now.nowIndex].length==1){

                if(now.nowIndex==0){
                    now.relations.func.call()
                    now.loaded();
                }else{
                    now.nowIndex--
                    now.loadScript()
                }
            }else{
                info[now.nowIndex].length--
            }
        },
        loadScript:function(){
            var info=this.loadingInfo
            info[this.nowIndex].mods.each(function(i,index){
                if(typeof(MJ[i])!="undefined"){
                    now.check(i)
                }else{
                    MJ.$importJS(MJBASEURL+"/"+MODCONFIG[i][0]+"?"+".js", now.check,i);
                }

            })
        },
        /**
         *此条加载链已经加载完毕
         */
        loaded:function(){
            var ulist=MJ.useList;
            ulist.shift();
            if(ulist.length!=0){
                ulist[0].loader.init(ulist[0].m,ulist[0].f)
            }
        }
    });
    mix(im,{
        useList:[],
        use:function(m,f){
            var load=new loader(),ulist=this.useList
            ulist.push({
                "loader":load,
                "m":m,
                "f":f
            });
            if(ulist.length==1){
                //启动加载
                ulist[0].loader.init(ulist[0].m,ulist[0].f)
            }

        },
        add:function(){
            if(typeof(arguments[0])=="function"){
                arguments[0]();
                if(arguments[1]==undefined) return;
                var arg=arguments[1];
                arg.each(function(i){
                    i=(typeof(i)=="string"?({
                        module:i,
                        all:true,
                        methods:[]
                    }):(i))
                    MJ.info.RELATIONS.push(i);
                })
            }else{
                if(typeof(arguments[1])=="function"){
                    var n=MJ.namespace(arguments[0])
                    n.obj[n.name]=n.obj[n.name]||arguments[1].call();
                    MJ.info.MODULES[arguments[0]]=null;
                    if(arguments[2]){
                        var arg=arguments[2]
                        MJ.info.MODULES[arguments[0]]={}
                        for(var i=0,m=arg.length;i<m;i++){
                            if(typeof(arg[i])=="string")
                                MJ.info.MODULES[arguments[0]][arg[i]]=[]
                            else{
                                MJ.info.MODULES[arguments[0]][arg[i].module]=arg[i].methods||null
                            }
                        }
                    }
                }
            }
        },
        namespace:function(name){
            var ns=name.split("."),t=MJ;
            for(var i=0,n=ns.length-1;i<n;i++){
                t[ns[i]]=t[ns[i]]||{}
                t=t[ns[i]];
            }
            //    t.namespace=name;
            return {
                obj:t,
                name:ns[ns.length-1]
            }
        },
        /**
         *本方法经过改进,在dom加载完后即执行
         *将所有的代码都放在这里来写,表示dom加载完后再执行,细节问题需要仔细研究,例如:何时才算加载完
         *可以多次调用
         * M.ready(function(){
			...代码
		})
         *@param {function} func 要执行的函数
         */
        ready:function(func){
            if(MJ.global.onloadfuncs){
                MJ.global.onloadfuncs.push(func);
            }else{
                MJ.global.onloadfuncs=[];
                MJ.global.onloadfuncs.push(func)
                document.addEventListener("DOMContentLoaded", function(){
                    for(var i=0;i<MJ.global.onloadfuncs.length;i++){
                        MJ.global.onloadfuncs[i].call(MJ.global)
                    }
                }, false);

            }
        },

        setConfig:function(detail){

        }
    });
})();