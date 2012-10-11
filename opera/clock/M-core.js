/* 
 * 这是M框架的核心类库,里面包含如下几个模块
 *
 * 具体文档见:
 * @see http://www.beiju123.cn/M/doc
 * @author 孙信宇(芋头)
 * @version 0.0.1
 *
 * 包含一些最基本的操作方法,本框架提供基本的操作,尽量做到兼容所有的浏览器,但是在测试中忽略了opera浏览器
 * 本框架实现均非常简单,所以提供的配置项较少,属于傻瓜型,易于使用
 *
 *
 * M框架由孙信宇(网名:mier,小haha,芋头,xinyu198736)创作.没有经过任何严格测试,正处在创作阶段.请不要轻易使用
 * 谢谢,有问题联系:
 * @email xinyu198736@gmail.com
 * @qq 676588498
 *
 */
(function(){
    var ap=function(target,prototypes){

        for(var i in prototypes){

            target.prototype[i]=prototypes[i];
        }
    }
    var mix=function(target,prototypes){

        for(var i in prototypes){

            target[i]=prototypes[i];
        }
    }
    ap(Array,{
        /**
             *遍历数组的方法
             *@param {function} func 对每个元素执行的方法,将会把当前处理到的元素作为参数传给这个function
             *@param {context} context 方法的上下文
             */
        each:function(func,context){

            if(typeof this.forEach=="function"){
                this.forEach(func, context)
            }else if(MY.tool.isArray(this)){
                for(var i=0,n=this.length;i<n;i++){
                    func.call(context,this[i],i,this)
                }
            }
        },
        /**
             *判断某个元素是否存在于数组中,是返回true,否返回false
             *@param {object} item 元素
             *@param {object} 按照此元素对比,可以进行第二层的对比
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
        },
        /**
             *从数组中移除某个元素
             *@param {object} item 要移除的元素,注意不是索引
             */
        remove:function(item){
            var j=this.length;
            for(var i=0;i<j;i++){
                if(this[i]==item){
                    this.splice(i, 1);
                    j--;
                }
            }
        },
        /**
             * 将数组打乱,原理是随机交换两个元素的值,可以设定洗牌次数
             * @param {number} times 洗牌次数,如果不存在就按数组长度计算
             */
        random:function(times){
            var this_length=this.length,index_1,index_2;
            times=times||this_length;
            for(var i=0;i<times;i++){
                index_1=Math.floor(Math.random()*this_length)
                while((index_2=Math.floor(Math.random()*this_length))==index_1){
                    continue;
                }
                var temp=this[index_1];
                this[index_1]=this[index_2]
                this[index_2]=temp;
            }
            return this;
        },
        /**
             *获取最大值
             */
        getMax:function(){
            var max=0;
            for(var i=0,j=this.length;i<j;i++){
                if(this[i]*1>max) max=this[i]*1
            }
            return max;
        },
        getMin:function(){
            var min=0;
            for(var i=0,j=this.length;i<j;i++){
                if(this[i]*1<min) min=this[i]*1
            }
            return min;
        },
        /**
             * 统计数组中某个元素出现的次数
             */
        count:function(item){
            var count=0;
            for(var i=0,j=this.length;i<j;i++){
                if(this[i]==item){
                    count++;
                }
            }
            return count;
        },
        swap:function(i,j){
            var temp = this[i];
            this[i] = this[j];
            this[j] = temp;
            return this;
        },
        getPos:function(item,index){
            if(index!=undefined){
                for(var i=0,n=this.length;i<n;i++){
                    if(this[i][index]==item[index]){
                        return i;
                    }
                }
            }
            for(var i=0,n=this.length;i<n;i++){
                if(this[i]==item){
                    return i;
                }
            }
            return -1;
        }
    })
  


    //M是顶级对象,之后所有的对象都依附于此之上
    if(typeof(MY)=="undefined") window.MY=function(){
        
        }

    mix(MY,{
        info:{
            //version代表版本号,如果引用了不同版本号的程序,互相不会冲突,每个版本号下的对象都只依附在此版本号之下,和其他程序不会冲突
            //暂时取消此功能
            VERSION:"version0.0.1",
            //这里存放着使用到的模块列表和方法列表,在use的第三个参数里定义这些东西,之后用在打包压缩里
            MODULES:{},
            RELATIONS:[], //
            ISLOADED:[], //已经加载完的模块
            ISLOADING:[], //正在加载中的模块
            USEFUNCTIONS:[], //用在按需异步加载中,用来存储加载完执行的方法和依赖模块的关系,只有所有模块加载完后才执行
            BASEURL:"http://demo.ued.taobao.net/xinyu/m-javascript-framework/",
            TIMESTAMP:"2010-4-272", //异步加载的js的时间戳
            /**
             *这里是提供给异步按需加载使用的
             *按需异步加载的分析:
             *需要的功能:按需加载,异步,根据依赖关系创建队列,按队列加载
             *如何实现:
             *按需加载是通过use的第一个个参数触发的,它总是有一个起点,例如页面里调用了MY.use就将其第一个参数作为入口点,
             *找到入口点后开始触发按需加载的流程,首先将入口点的模块名放在队列的最后,然后再route里寻找此模块是否需要依赖其他模块,
             *如果需要依赖其他模块,就遍历这些模块,继续检查他们是不是需要依赖其他模块,如此递归直到没有依赖关系为止
             *这里的异步加载并不是严格的一个一个执行的,而是按照依赖关系,如果A依赖于B和C,那么b和c会一起加载,都加载完后开始加载a
             *最后生成的依赖关系的是一个复杂的多维数组
             *第一层是多个加载链,每个加载链由一个use方法触发,每个加载链中都有一个数组,它表示了加载的顺序,数组元素可能是一个或者多个模块,
             *如果是多个模块就多个都加载完了再加载下一个,加载完数组里所有元素后,就去执行链中的第二个元素,既要执行的方法.
             *每个链条独立加载还是按照顺序来加载待定,如果对use之间的执行顺序有要求,则需要挨个链条加载,否则完全可以同时进行.
             *需要哪些功能块:
             *又一个入口点生成一个加载链的数据结构
             *加载单个文件和加载多个文件 都加载完的事件通知机制
             *按数组顺序调用上面的功能块
             *
             */
            ROUTE:{   //路由信息,定位到不同的模块
                "base":["base.js",[]],
                "base-extend":["base-extend.js",[]],
                "anim":["modules/anim.js",["base"]],
                "ajax":["modules/ajax.js",[]],
                "dd":['modules/dd.js',[]],
                "table":['modules/table.js',[]],
                "canvas.base":['canvas/base.js',[]]
            }
        },
        /**
             *这里面存放的是一些工具方法,直接依附在M.tool上
             */
        tool:function(){
            return{
                /**
                     *指示是否是ie,注意这是一个变量,不是一个函数,在初始化后就确定值了
                     */
                isIE:function(){
                    if(document.all) return true;
                    return false;
                }(),
                /**
                     *输出,这些函数可以随意变动,属于无关紧要的函数
                     *@param {string} str 要输出的值
                     *@param {string} method 类型,例如:alert,或者error,warning之类
                     */
                trace:function(str,method){
                    if(method=="alert"){
                        alert(str);
                        return;
                    }
                    if(!document.getElementById("debug")){
                        var ele=document.createElement("div")
                        ele.id="debug";
                        document.body.appendChild(ele)
                    }
                    document.getElementById("debug").innerHTML+="<font size=1>"+str+"</font><br/>"
                },
                getBody:function(){
                    return document.body;
                }(),
                trim:function(str){
                    return str.replace(/(^\s*)|(\s*$)/g, "");
                },
                isNumber:function(o) {
                    return typeof o === "number";
                },
                isFunction:function(o){
                    return typeof o=== "function"
                },
                isArray: function(o) {
                    if (o) {
                        return this.isNumber(o.length) && this.isFunction(o.splice);
                    }
                    return false;
                },
                isElement:function(object) {
                    return !!(object && object.nodeType == 1);
                },
                baseEach:function(array,func,context){
                    for(var i=0,n=array.length;i<n;i++){
                        func.call(context||window,array[i])
                    }
                },
                /****************************扩展object*******************************/
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
                }

            }
        }(),
        global:{},//全局变量都放在这里,使用后注意清除,可以定时检查是否有没有清楚掉的全局变量(待定
        data:{//用来存储一些状态数据,是临时性容器
            importing:0
        }
    })

    /**
     *这是一个基本方法,建议所有的代码都写在use里的参数里的function里,防止代码污染.
     *在方法参数里返回一个函数或者对象,将被自动赋给第一个参数设定的作用域,不能多次设定,也就是说一个空间里只能定义一次
     *@param {string} 第一个参数是命名空间,可以省略,如果省略,则第二个方法参数里的代码都直接执行,
     *否则,则在命名空间下执行,并且在方法里可以用this调用命名空间
     *@param {function} 执行的方法
     *@param {array} 此类型需要使用的模块,可以只包括模块,例如:["Array"].说明内部使用了M.Array对象
     *如果指定包含模块,并指定使用了哪些方法,可以用这种方法指定 [{module:"Array",methods:["each","sort"]}]
     *现在不会对程序造成任何影响,但是后期加入服务器打包功能,服务器脚本将把只用到的方法和模块打包,其他的都删除.
     *当然这也依靠模块内部的方法引用,所以每个模块如果里面包含互相调用的情况,需要加入一个属性RELATION,用来指明引用关系,之后打包程序可以识别并知道哪些要删除哪些被引用了不能删除
     *
     */
    mix(MY,{
        checkUse:function(module){
            var t
            MY.info.ISLOADED.push(module)
            MY.info.ISLOADING.remove(module)
            for(var i=0 ,m=(t=MY.info.USEFUNCTIONS).length;i<m;i++ ){

                for(var j=0,n=t[i].modules.length;j<n;j++){
                    if(!MY.info.ISLOADED.has(t[i].modules[j])){
                        return
                    }
                }

                t[i].func.call(window)
                t.splice(i,1)
            }
           
        },
        use:function(modules,method){
            var t=MY.tool,info=MY.info

            if(t.isArray(modules)){
                info.USEFUNCTIONS.push({
                    func:method,
                    modules:modules
                })
                modules.each(function(item){
                    if((!info.ISLOADING.has(item)&&!info.ISLOADED.has(item))){ //已经加载的或者正在加载的都不用再次加载
                        MY.$importJS(info.BASEURL+info.VERSION+"/"+info.ROUTE[item.toLowerCase()][0]+"?"+info.TIMESTAMP+".js", MY.checkUse,item);
                        MY.info.ISLOADING.push(item)
                    }
                })
            }else{
                info.USEFUNCTIONS.push({
                    func:method,
                    modules:[modules]
                })
                
                if((!info.ISLOADING.has(modules)&&!info.ISLOADED.has(modules))){
                    MY.$importJS(info.BASEURL+info.VERSION+"/"+info.ROUTE[modules.toLowerCase()][0]+"?"+info.TIMESTAMP+".js",MY.checkUse,modules);
                    MY.info.ISLOADING.push(modules)
                }
            }
        },
        create:function(){
            var each=MY.tool.baseEach;
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
                    MY.info.RELATIONS.push(i);
                })
            }else{
                if(typeof(arguments[1])=="function"){
                    var n=MY.namespace(arguments[0])
                    n.obj[n.name]=n.obj[n.name]||arguments[1].call();
                    MY.info.MODULES[arguments[0]]=null;
                    if(arguments[2]){
                        var arg=arguments[2]
                        MY.info.MODULES[arguments[0]]={}
                        for(var i=0,m=arg.length;i<m;i++){
                            if(typeof(arg[i])=="string")
                                MY.info.MODULES[arguments[0]][arg[i]]=[]
                            else{
                                MY.info.MODULES[arguments[0]][arg[i].module]=arg[i].methods||null
                            }
                        }
                    }
                }
            }
        },
        namespace:function(name){
            var ns=name.split("."),t=MY;
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
            if(MY.global.onloadfuncs){
                MY.global.onloadfuncs.push(func);
            }else{
                MY.global.onloadfuncs=[];
                MY.global.onloadfuncs.push(func)
                if(!MY.tool.isIE){
                    document.addEventListener("DOMContentLoaded", function(){
                        for(var i=0;i<MY.global.onloadfuncs.length;i++){
                            MY.global.onloadfuncs[i].call(MY.global)
                        }
                    }, false);
                }else{

                    MY.global.isready=false;//全局变量,用来标示页面dom是否加载完毕
                    MY.global.ieReady=function(){
                        if(!MY.global.isready){
                            MY.global.isready=true;
                            for(var i=0;i<MY.global.onloadfuncs.length;i++){
                                MY.global.onloadfuncs[i].call(MY.global)
                            }
                        }
                    };
                    //下面一直检查document的doScroll方法是否可用,直到可用则执行函数序列
                    (function(){
                        try {
                            document.documentElement.doScroll('left');
                        } catch (e) {
                            setTimeout(arguments.callee, 0);
                            return;
                        }
                        MY.global.ieReady.call();
                        MY.global.isready=null;
                    })();
                    document.onreadystatechange = function() {
                        if (document.readyState == 'complete') {
                            document.onreadystatechange = null;
                            MY.global.ieReady.call();
                            MY.global.ieReady=null;
                        }
                    };
                }
            }
        },
        $importJS:function(src,callback,param){
            var a=document.createElement("script");
            a.src=src;
            a.type="text/javascript"
            document.getElementsByTagName("head")[0].appendChild(a);
            MY.tool.trace(src)
            if(callback!=undefined){

                a.onload=function(){
                    MY.data.importing--;
                    try{
                        callback.call(window,param)
                    }catch(e){}
                }
                a.onreadystatechange=function(){
                    if(this.readyState=="complete"||this.readyState=="loaded"){
                        try{
                            callback.call(window,param)
                        }catch(e){}
                    }
                }
            }
        }
    })
})();


