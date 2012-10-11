/* 
 * 这是一个M框架基础对象,包含一些最基本的操作方法,本框架提供基本的操作,尽量做到兼容所有的浏览器,但是在测试中忽略了opera浏览器
 * 此框架包含几个特殊组件,包括一个性能测试,一个动画,一个ajax组件.实现均非常简单,所以提供的配置项较少,属于傻瓜型,易于使用
 *
 *
 * M框架由孙信宇(网名:mier,小haha,芋头,xinyu198736)创作.没有经过任何严格测试,正处在创作阶段.请不要轻易使用
 * 谢谢,有问题联系:xinyu198736@gmail.com
 * qq:676588498
 *
 * 斟酌再三,我不能确定是否在框架里加入不同的命名空间控制,待定吧,我嚼的无需加入, 
 */
//M是顶级对象,之后所有的对象都依附于此之上
(function(){
    //M是顶级对象,创建其下
    if(typeof(M)=="undefined") window.M=function(){
        return {
            info:{
                //version代表版本号,如果引用了不同版本号的程序,互相不会冲突,每个版本号下的对象都只依附在此版本号之下,和其他程序不会冲突
                //暂时取消此功能
                VERSION:"0.9",
                //这里存放着使用到的模块列表和方法列表,在use的第三个参数里定义这些东西,之后用在打包压缩里
                PACKAGES:{},
                RELATIONS:[]
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
                    }
                }
            }(),
            global:{},//全局变量都放在这里,使用后注意清除,可以定时检查是否有没有清楚掉的全局变量(待定
            data:{//用来存储一些状态数据,是临时性容器
                importing:0
            }
        }
    }()
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
    M.use=function(){
        var each=M.tool.baseEach;
        if(typeof(arguments[0])=="function"){
            arguments[0]();
            if(arguments[1]==undefined) return;
            var arg=arguments[1];
            each(arg,function(i){
                i=(typeof(i)=="string"?({module:i,all:true,methods:[]}):(i))
                M.info.RELATIONS.push(i);
            })
        }else{
            if(typeof(arguments[1])=="function"){
                var n=M.namespace(arguments[0])
                n.obj[n.name]=n.obj[n.name]||arguments[1].call();
                M.info.PACKAGES[arguments[0]]=null;
                if(arguments[2]){
                    var arg=arguments[2]
                    M.info.PACKAGES[arguments[0]]={}
                    for(var i=0,m=arg.length;i<m;i++){
                        if(typeof(arg[i])=="string")
                            M.info.PACKAGES[arguments[0]][arg[i]]=[]
                        else{
                            M.info.PACKAGES[arguments[0]][arg[i].module]=arg[i].methods||null
                        }
                    }
                }
            }
        }
    };
    M.namespace=function(name){
        var ns=name.split("."),t=M;
        for(var i=0,n=ns.length-1;i<n;i++){
            t[ns[i]]=t[ns[i]]||{}
            t=t[ns[i]];
        }
        //    t.namespace=name;
        return {
            obj:t,
            name:ns[ns.length-1]
        }
    };
    /**
     *本方法经过改进,在dom加载完后即执行
     *将所有的代码都放在这里来写,表示dom加载完后再执行,细节问题需要仔细研究,例如:何时才算加载完
     *可以多次调用
     * M.ready(function(){
			...代码
		})
     *@param {function} func 要执行的函数
     */
    M.ready=function(func){
        if(window.onloadfuncs){
            window.onloadfuncs.push(func);
        }else{
            window.onloadfuncs=[];
            window.onloadfuncs.push(func)
            if(!M.tool.isIE){
                document.addEventListener("DOMContentLoaded", function(){
                    for(var i=0;i<window.onloadfuncs.length;i++){
                        window.onloadfuncs[i].call(window)
                    }
                }, false);
            }else{
			
                M.global.isready=false;//全局变量,用来标示页面dom是否加载完毕
                M.global.ieReady=function(){
                    if(!M.global.isready){
                        M.global.isready=true;
                        for(var i=0;i<window.onloadfuncs.length;i++){
                            window.onloadfuncs[i].call(window)
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
                    M.global.ieReady.call();
                    //              M.global.ieReady=null;
                    M.global.isready=null;
                })();
                document.onreadystatechange = function() {
                    if (document.readyState == 'complete') {
                        document.onreadystatechange = null;
                        M.global.ieReady.call();
                        M.global.isready=null;
                    }
                }; 
            }
        }
    };
  
})();
/*#!Vector&TYPE=MUL*/
M.use("Vector",function(){
    /**
     *一个简单的向量对象,用来表示坐标位置,可以做向量运算
     *程序中所有涉及二维运算的例如:位置,大小等都以此做为基本数据结构,
     *所以可以减少大量的代码书写,可以串行运算
     */
    Vector=function(x,y){
        this.x=x||0;
        this.y=y||0;
    }
    /**
         *函数的依赖关系,在按需压缩的时候用
         */
    Vector.RELATION={
        "getAngle":["dotMul","getMod"],
        "getRadian":["dotMul","getMod"],
        "reflex":["getNormal","getAngle","sub","mulNum","dotMul"],
        "mirror":["reflex","getNegative"]
    },
    Vector.prototype={
        /*~!Vector*/

        add:function(v){
            return new M.Vector(this.x+v.x,this.y+v.y);
        },
        sub:function(v){
            return new M.Vector(this.x-v.x,this.y-v.y);
        },
        xyToVector:function(xy){
            return new Vector(xy.x,xy.y)
        },
        getMod:function(){
            return Math.sqrt(this.x*this.x+this.y*this.y);
        },
        mulNum:function(num){
            this.x=this.x*num;
            this.y=this.y*num;
            return this;
        },
        getNegative:function(){
            this.x=-this.x;
            this.y=-this.y;
            return this;
        },
        /**
         *返回一个常数代表b在a上的投影乘以a的长度
         */
        dotMul:function(v){
            return this.x*v.x+this.y*v.y;
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
        getRadian:function(){
            return Math.acos(this.dotMul(vector)/(this.getMod()*v.getMod()));
        },
        /**
         *求某向量的法向量,返回一个单位向量,其模为1,返回的向量总是指向this向量的右边
         * @return 
         */
        getNormal:function(){
            return new M.Vector(this.y/(Math.sqrt(this.x*this.x+this.y*this.y)),-this.x/(Math.sqrt(this.x*this.x+this.y*this.y)));
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
        toString:function(){
            return this.x+":"+this.y;
        }
    /*END~!Vector*/
    }
    return Vector;
});
/*END#!Vector*/
/*#!Math&TYPE=SIG*/
M.use("Math",function(){
    /**
     *数学类,(完善中)
     */
    Math1=function(){
        return {
            /*~!Math*/
            /**
             * 正常的随机数
             */
            RELATION:{
                "randomRang":["random"]
            },
            random:function(x,isInt){
                if(isInt) return Math.floor(Math.random()*(x))
                return Math.random()*x
            },
            /**
             * 带负号的随机数
             */
            randomD:function(x){
                var r=Math.random();
                if(r-0.5>0){
                    return Math.random()*x;
                }else{
                    return Math.random()*x*(-1);
                }
            },
            /**
             * 范围内的随机数
             */
            randomRang:function(x,y){
                return this.random(y-x)+x;
            },
            fillZero:function(num,length){
                num=num.toString();
                var str="";
                for(var i=0,n=length-num.length;i<n;i++){
                    str+="0";
                }
                return str+num;
            },
            /**
			*给二维数组排序,可以指定参考的列和方向
			*/
            sortT:function(array,referIndex,isUp){
                var length = array.length,referIndex=referIndex||0,i,j,temp;
                if(isUp){
                    for(i=0; i<=length-2; i++) {
                        for(j=length-1; j>=1; j--) {
                            //对两个元素进行交换
                            if(array[j][referIndex]< array[j-1][referIndex]) {
                                temp = array[j];
                                array[j] = array[j-1];
                                array[j-1] = temp;
                            }
                        }
                    }
                }else{
                    for( i=0; i<=length-2; i++) {
                        for(j=length-1; j>=1; j--) {
                            //对两个元素进行交换
                            if(array[j][referIndex] > array[j-1][referIndex]) {
                                temp = array[j];
                                array[j] = array[j-1];
                                array[j-1] = temp;
                            }
                        }
                    }
                }
                return array;
            },
            /**
			*给一维数组排序
			*/
            sort:function(array,isUp){
                var length = array.length,temp;
                if(isUp==true){
                    for(var i=0; i<=length-2; i++) {
                        for(var j=length-1; j>=1; j--) {
                            //对两个元素进行交换
                            if(array[j] < array[j-1]) {
                                temp = array[j];
                                array[j] = array[j-1];
                                array[j-1] = temp;
                            }
                        }
                    }
                }else{
                    for(var i=0; i<=length-2; i++) {
                        for(var j=length-1; j>=1; j--) {
                            //对两个元素进行交换
                            if(array[j] > array[j-1]) {
                                temp = array[j];
                                array[j] = array[j-1];
                                array[j-1] = temp;
                            }
                        }
                    }
                }
                return array;
            }
        /*END~!Math*/
        }
    }();
    return Math1;
});
/*END#!Math*/
/**
 *大多数基础操作都在这个对象中,即M.dom对象,这是一个单例对象,可以直接调用.
 *例如:M.dom.get("id");
 *有一个别名叫做M.base,所以也可以这样调用:M.base.get("id");
 *M.dom相当于一个工具库,里面包含了很多特殊的操作.掌握了这些方法可以让代码写的更简洁,更整洁
 */
/*#!dom&TYPE=SIG*/
M.use("dom",function(){
    var dom=function(){
        return {
            /*~!dom*/
            RELATION:{
                "createElement":["mixinStyle"],
                "getByClass":["hasClass"],
                "_handleEleParam":["getByClass"],
                "mixinStyle":["mixin"],
                "getCss":["_handleEleParam"],
                "setCssValue":["_handleEleParam"],
                "getCssValue":["_handleEleParam"],
                "setXY":["_handleEleParam","mixinStyle"],
                "getRelativeXY":["getCss"]
                
            },
            /**
             *一次性完成创建和初始化某个dom元素的操作,在特定情况下使用节省代码
             *简单的创建不推荐使用
             *@param {string} tagName 标签名
             *@param {ele} parentNode 父元素也可以用p简写
             *@param {string} innerHTML 内容
             *@param {json} attributes 属性值对
             *@param {json} styles 要赋予的样式
             *@param {json} event 绑定的事件 例如:event={type:"click",func:function(){}}
             */
            createElement:function(tagName,params,childs){
                var ele=document.createElement(tagName);
                if(params!=undefined){
                    //可以用p也可以用parentNode指定父元素
                    if(params.parentNode||params.p){
                        (params.parentNode||params.p).appendChild(ele)
                    }
                    if(params.innerHTML||params.i){
                        ele.innerHTML=params.innerHTML||params.i;
                    }
                    if(params.className||params.c){
                        ele.className=params.className||params.c;
                    }
                    if(params.attr||params.a){
                        var attr=params.attr||params.a;
                        for(var i in attr){
                            ele[i]=attr[i];
                        }
                    }
                    if(params.styles||params.s){
                        //这是我定义的一个函数,用来混合样式
                        M.dom.mixinStyle(ele,params.styles||params.s)
                    }
                    if(params.event||params.e){
                        params.event=params.event||params.e;
                        //用来添加事件
                        M.Event.on(ele,params.event.type,params.event.func);
                    }
                }
                if(childs==undefined) return ele;
                if(childs.length==undefined){
                    ele.appendChild(childs);
                } else{
                    for(var i=0,n=childs.length;i<n;i++){
                        ele.appendChild(childs[i])
                    }
                }
                return ele;
            },
            /**
             *通过id来获取元素,返回一个元素引用
             *@param {str} id_str 要获取的元素的ieid
             */
            get:function(id_str){
                return document.getElementById(id_str)||id_str;
            },
            /**
             *通过class获取元素,返回一个元素的数组
             *@param {string} className 要获取的元素的类名
             *@param {string} tag 元素的tagname 可以省略
             *@param {htmlelement} root 根元素
             */
            getByClass:function(className, tag, root){
                var tag=tag||"*",
                root=root||document,
                eles = root.getElementsByTagName(tag),
                return_ele=[];
                for(var i=0,j=eles.length;i<j;i++){
                     
                    if(this.hasClass(className,eles[i].className)){
                       
                        return_ele.push(eles[i])
                    }
                }
                return return_ele;
            },
            getByTag:function(tagName,root){
                var tag=tagName||"*",
                root=root||document,
                eles = root.getElementsByTagName(tag);
                return eles
            },
            insertAfter:function(newEl, targetEl){
                var parentEl = targetEl.parentNode;
            
                if(parentEl.lastChild == targetEl){
                    parentEl.appendChild(newEl);
                }else{
                    parentEl.insertBefore(newEl,targetEl.nextSibling);
                }
            },
            /**
             * 有的时候某个元素会同时拥有两个class,这个时侯判断class_a 是否是class_b的一部分
             * 也可以第一个参数是dom元素,第二个是要判断的className
             */
            hasClass:function(class_a,class_b){
                if(typeof(class_a)!="string"){
                    return this.hasClass(class_b,class_a.className)
                }
                var class_arr=class_b.replace(/\s{2,}/g," ").split(" ");
                for(var i=0;i<class_arr.length;i++){
                    if(class_arr[i]==class_a) return true;
                }
                return false;
            },
            /**
             *向某个元素的classname添加一个class
             *此函数的特点是防止了误判断,例如 如果原来的classname是"realname" 再向其添加"name"的时候 不会将realname中的name当成已经存在的name.
             *从而精确地判断是否已经存在这个class了.
             *虽然字符串操作可能会耗费性能,对性能要求过高的情况避免使用
             */
            addClass:function(ele,className){
                if(M.tool.isArray(className)){
                    for(var i=0,n=className.length;i<n;i++){
                        this.addClass(ele,className[i])
                    }
                    return;
                }
                var str=ele.className;
                str=(" "+str+" ").replace( /\s{2,}/g," ");//过滤多余的空格,同时在首尾添加空格
                if(str.indexOf(" "+className+" ")==-1){
                    str+=" "+className;
                }
                ele.className=str;
            },
            removeClass:function(ele,className){
                if(M.tool.isArray(className)){
                    for(var i=0,n=className.length;i<n;i++){
                        this.removeClass(ele,className[i])
                    }
                    return;
                }
                var str=ele.className;
                str=(" "+str+" ").replace( /\s{2,}/g," ");//过滤多余的空格,同时在首尾添加空格
                str=str.replace(" "+className+" ","");
                ele.className=str;
            },
            getAllClass:function(ele){
                return ele.className.split(/\s{1,}/);
            },
            /**
             * 在向某些方法传递节点参数的时候,可以直接传id的字符串,也可以传元素的实体,也可以传一个class
             * 最后分别返回元素实体,或者实体数组,
             * 这个函数就用来处理这种情况
             * 通用函数
             */
            _handleEleParam:function(ele){
                var returnele;
                if(typeof(ele)=="string"){
                    if((returnele=this.get(ele))){
                        return returnele;
                    }else {
                        return this.getByClass(ele);
                    }
                }
                return ele;

            },
            /**
             *将一个json的style表示形式赋值到一个元素的style上,直接赋值无法正常运行,所以分开赋值
             *例如:
             *mixinStyle(M.dom.get("block2"),{
            backgroundColor:"#aaa",
            height:"200px"
          })
             */
            mixinStyle:function(ele,styles){
                if(ele.length){
                    for(var i=0;i<ele.length;i++){
                        this.mixin(ele[i].style,styles)
                    }
                    return;
                }
                this.mixin(ele.style,styles)
            },
            /**
			*典型用法:
			1.this.ele=D.mixin(document.createElement("div"),{className:"m-spinner"});//顶级dom
			2.D.mixin(this.config,config);
			*/
            mixin:function(target,options){
                for(var i in options){
                    target[i]=options[i]
                }
                return target
            },

            /**
             *获取当前在元素上生效的css属性
             */
            getCss:function(_ele,key){
                _ele=this._handleEleParam(_ele)
                var val=M.tool.isIE?_ele.currentStyle[key]:window.getComputedStyle(_ele,null)[key];
                if(val!="auto") return val
                return false;
            },
            setCssValue:function(ele,attr,value){
                ele=this._handleEleParam(ele)
                if(attr!="opacity"){
                    ele.style[attr]=value+"px"
                }else{
                    M.tool.isIE?ele.style.filter="alpha(opacity="+value*100+")":ele.style['opacity']=value+"";
                }
            },
            /**
             *通用函数,用来获取某个css属性的值
             */
            getCssValue:function(ele,attr){
                ele=this._handleEleParam(ele)
                if(attr!="opacity"){
                    return ele.style[attr].replace("px","")
                }

                else
                    return M.tool.isIE?ele.filters.alpha.opacity/100:ele.style.opacity;
            },
            getDocumentWidth:function(){
                return this._bodyValue("clientWidth")
            },
            getDocumentHeight:function(){
                return this._bodyValue("clientHeight")
            },
            getScrollXY:function(){
                var x=document.documentElement.scrollLeft||document.body.scrollLeft;
                var y=document.documentElement.scrollTop||document.body.scrollTop;
                return new M.Vector(x,y)
            },
            setXY:function(ele,point){
                ele=this._handleEleParam(ele);
                this.mixinStyle(ele,{
                    position:"absolute",
                    left:point.x+"px",
                    top:point.y+"px"
                })
                return new M.Vector(point.x,point.y);
            },
            getRelativeXY:function(el){
                return new M.Vector(this.getCss(el, "left").replace("px","")*1||"0px",this.getCss(el, "top").replace("px","")*1||"0px")
            },
            getXY:function(el) {
                if (document.documentElement.getBoundingClientRect) { // IE,FF3.0+,Opera9.5+
                    var box = el.getBoundingClientRect();
                    return new M.Vector(box.left+this.getScrollXY().x,box.top+this.getScrollXY().y )
                } else {

                    var pos = [el.offsetLeft, el.offsetTop];
                    var op = el.offsetParent;
                    if (op != el) {
                        while (op) {
                            pos[0] += op.offsetLeft + parseInt(getStyle(op,'borderLeftWidth')) || 0;
                            pos[1] += op.offsetTop + parseInt(getStyle(op,'borderTopWidth')) || 0;
                            op = op.offsetParent;
                        }
                    }
                    return new M.Vector(pos[0],pos[1])
                }
            },
            getMousePos:function(ev){
                if(ev.pageX || ev.pageY){
                    return new M.Vector(ev.pageX,ev.pageY)
                }
                return new M.Vector(
                    ev.clientX + this._bodyValue['scrollLeft'] - this._bodyValue['clientLeft'],
                    ev.clientY + this._bodyValue['scrollTop']  - this._bodyValue['clientTop']
                    )
            },
            _bodyValue:function(key){
                return document.documentElement[key]||document.body[key]
            },
            /**
             *兼容ie的获取offsetWidth的方法,包括padding和border的值
             */
            getOffsetSize:function(ele){
                return new M.Vector(ele.offsetWidth, ele.offsetHeight);
            },
            /**
             *一些类似浮层之类的绝对定位的元素需要插入到body元素里,可以调用此方法
             *此方法可以一次插入多个
             *后续可以修改,以防兼容性问题
             */
            appendToBody:function(ele){
                try{
                    if(M.tool.isArray(ele)){
                        for(var i=0;i<ele.length;i++){
                            document.body.appendChild(ele[i])
                        }
                    }else{
                        document.body.appendChild(ele)
                    }
                }catch(e){
                    alert(e)
                }
            },
            setInnerHTML:function (el, html) {
                if (!el || typeof html !== 'string') {
                    return null;
                }
                // 中止循环引用
                (function (o) {

                    var a = o.attributes, i, l, n, c;
                    if (a) {
                        l = a.length;
                        for (i = 0; i < l; i += 1) {
                            n = a[i].name;
                            if (typeof o[n] === 'function') {
                                o[n] = null;
                            }
                        }
                    }
                    a = o.childNodes;

                    if (a) {
                        l = a.length;
                        for (i = 0; i < l; i += 1) {
                            c = o.childNodes[i];
                            // 清除子节点
                            arguments.callee(c);

                            // 移除所有通过YUI的addListener注册到元素上所有监听程序
                            M.Event.clearListener(c);
                        }
                    }
                })(el);
                // 从HTML字符串中移除script，并设置innerHTML属性
                el.innerHTML = html.replace(/<script[^>]*>[\S\s]*?<\/script[^>]*>/ig, "");
                // 返回第一个子节点的引用
                return el.firstChild;
            }
        /*END~!dom*/
        }
    }()
    return dom;
},["Vector",{
    module:"Event",
    methods:["on"]
}]);
/*END#!dom*/
M.use("base",function(){
    return M.dom;
});
/*#!Array&TYPE=SIG*/
M.use("Array",function(){
    var arr=function(){
        return {
            /*~!Array*/
            each:function(array,func,context){

                if(typeof array.forEach=="function"){
                    array.forEach(func, context)
                }else if(M.tool.isArray(array)){
                    for(var i=0,n=array.length;i<n;i++){
                        func.call(context,array[i],i,array)
                    }
                }else if(typeof(array)=="string"){
                    for(var i=0,n=array.length;i<n;i++){
                        func.call(context,array.charAt(i),i,array)
                    }
                }
            },
            /**
             *判断某个元素是否存在于数组中,是返回true,否返回false
             *@param {array} arr 要处理的数组
             *@param {object} item 元素
             *@param {object} 按照此元素对比,可以进行第二层的对比
             */
            has:function(arr,item,index){
                if(index!=undefined){
                    for(var i=0,j=arr.length;i<j;i++){
                    if(arr[i][index]==item[index]) return true;
                }
                return false;
                }
                for(var i=0,j=arr.length;i<j;i++){
                    if(arr[i]==item) return true;
                }
                return false;
            },
            /**
             *从数组中移除某个元素
             *@param {array} arr 要处理的数组
             *@param {object} item 要移除的元素,注意不是索引
             */
            remove:function(arr,item){
                var j=arr.length;
                for(var i=0;i<j;i++){
                    if(arr[i]==item){
                        arr.splice(i, 1);
                        j--;
                    }
                }
            },
            /**
             * 将数组打乱,原理是随机交换两个元素的值,可以设定洗牌次数
             * @param {array} arr 要处理的数组
             * @param {number} times 洗牌次数,如果不存在就按数组长度计算
             */
            random:function(arr,times){
                var arr_length=arr.length,index_1,index_2;
                times=times||arr_length;
                for(var i=0;i<times;i++){
                    index_1=Math.floor(Math.random()*arr_length)
                    while((index_2=Math.floor(Math.random()*arr_length))==index_1){
                        continue;
                    }
                    var temp=arr[index_1];
                    arr[index_1]=arr[index_2]
                    arr[index_2]=temp;
                }
                return arr;
            },
            toString:function(arr){
                var return_str="";
                if(typeof(arr[0])=="array"){
                    for(var i=0,n=arr.length;i<n;i++){
                        return_str+=this.toString(arr[i])+"\n";
                    }
                }else{
                    for(var i=0,j=arr.length;i<j;i++){
                        return_str+=arr[i]+"\n"
                    }
                }
                return return_str;
            },
            getMax:function(arr){
                var max=0;
                for(var i=0,j=arr.length;i<j;i++){
                    if(arr[i]*1>max) max=arr[i]*1
                }
                return max;
            },
            getMin:function(arr){
                var min=0;
                for(var i=0,j=arr.length;i<j;i++){
                    if(arr[i]*1<min) min=arr[i]*1
                }
                return min;
            },
            /**
             * 统计数组中某个元素出现的次数
             */
            count:function(arr,item){
                var count=0;
                for(var i=0,j=arr.length;i<j;i++){
                    if(arr[i]==item){
                        count++;
                    }
                }
                return count;
            },
            swap:function(arr,i,j){
                var temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
                return arr;
            },
            getPos:function(array,item,index){
                if(index!=undefined){
                    for(var i=0,n=array.length;i<n;i++){
                    if(array[i][index]==item[index]){
                        return i;
                    }
                }
                }
                for(var i=0,n=array.length;i<n;i++){
                    if(array[i]==item){
                        return i;
                    }
                }
                return -1;
            }
        /*END~!Array*/
        }
    }();
    return arr;
});
/*END#!Array*/
/*#!CustomEvent&TYPE=MUL*/
M.use("CustomEvent",function(){
    /**
     *自定义的事件方法,此方法在对象内部定义,同时对象内部需要自定义一个addListener方法,用来绑定事件,
     *在对象内部用fire方法触发事件,同时可以向事件方法里传入参数
	 在对象中要设定一个方法:
	 addListener:function(type,func){
            for(var i in this.EVENT_LIST){
                if(i==type){
                    this.EVENT_LIST[i].push(func)
                    return;
                }
            }
            M.tool.trace("sprite中没有定义此种类型事件","alert")
        },
     */
    var CustomEvent=function(type,handle){
        this.handle=handle;
        this.type=type;
        this.init(type)
    }
    CustomEvent.NEEDED=["init"]
    CustomEvent.prototype={
        /*~!CustomEvent*/
        init:function(type){
            if(this.handle.EVENT_LIST==undefined){
                this.handle.EVENT_LIST=[];
            }
            this.handle.EVENT_LIST[type]=[]
        },
        fire:function(param){
            var ev= this.handle.EVENT_LIST[this.type]
            for(var i in ev){
                ev[i].call(this.handle,param);
            }
        }
    /*END~!CustomEvent*/
    }
    return CustomEvent;
});
/*END#!CustomEvent*/
/*#!Event*/
M.use("Event",function(){
    Event=function(){
        return{
            /*~!Event*/
            RELATION:{
                "on":["addListener"],
                "off":["removeListener"],
                "removeListener":["_withinElement"],
                "addListener":["_withinElement"]
            },
            /**
             *所有的事件type
             */
            types:["abort","blur","change","click","dblclick","error","focus","keydown","keypress","keyup",
            "load","mousedown","mousemove","mouseout","mouseover","mouseup","reset","resize","select","submit","unload"],
            /**
             *为了和普通的添加方法兼容,这里的第四个参数需要判断和约定
             *第四个参数如果是字符串,且前缀是$_,则这个参数代表事件标识id,否则代表传进来的参数
             *如果没设置id标识,那么这个事件就是不可移除的,只有设置了的才可以移除
             */
            addListener:function(ele,type,func,id,handle){
                if(ele.length&&ele.length>1){
                    for(var i=0,n=ele.length;i<n;i++){
                        this.addListener(ele[i],type,func,id,handle);
                    }
                    return;
                }
                if(typeof(id)=="string"&&/^\$\_.*/.test(id)==true){

                }else{
                    if(handle){
                        M.tool.trace("event.addlistener有多余的参数或者事件标识符应该用$_开头");
                        return;
                    }
                    var handle=id||"";
                    id="_undefined";
                }
                if(!ele.events) ele.events=[];
                var eve=null;
                if(id=="_undefined") {
                    eve=ele.events[ele.events.length]=function(e){
                        func.call(ele,e,handle)
                    }
                }else{
                    eve=ele.events[id]=function(e){
                        func.call(ele,e,handle)
                    }
                }

                if(M.tool.isIE){
                    ele.attachEvent("on"+type, eve);
                }else{
				
                    if (type === 'mouseenter') {
                        ele.addEventListener('mouseover', this._withinElement(eve), false);
                    } else if (type === 'mouseleave') {
                        ele.addEventListener('mouseout', this._withinElement(eve), false);
                    } else {
                        ele.addEventListener(type, eve, false);
                    }
                }

            },
            /**
             *从事件列表里删除某个函数
             *
             */
            removeListener:function(ele,type,id){
                try{
                    if(M.tool.isIE)
                        ele.detachEvent("on"+type, ele.events[id]);
                    else{
                        if (type === 'mouseenter') {
                            ele.removeEventListener('mouseover', this._withinElement(ele.events[id]), false);
                        } else if (type === 'mouseleave') {
                            ele.removeEventListener('mouseout', this._withinElement(ele.events[id]), false);
                        } else {
                            ele.removeEventListener(type, ele.events[id], false);
                        }
                    }
                }catch(e){}
            },
            /**
             *在清除dom元素的时候,先用此方法清除所有绑定其上的事件,注意只能清除本框架的事件,
             *需要不断改进
			@param {element} ele dom节点对象
             */
            clearListener:function(ele){
			
                if(ele.events){
                    for(var i in ele.events){
                        ele.events=null;//此处用不用循环移除listener,还不知道
                    }
                }
                ele.events.length=0;
                ele.events=null;
            },
            on:function(ele,type,func,id,handle){
                this.addListener(ele, type, func, id, handle)
            },
            off:function(ele,type,id){
                this.removeListener(ele, type, id)
            },
            stopPropagation:function(e){
                if ( e && e.stopPropagation )
                    //因此它支持W3C的stopPropagation()方法
                    e.stopPropagation();
                else
                    //否则，我们需要使用IE的方式来取消事件冒泡
                    window.event.cancelBubble = true;
                return false;
            },
            stopEvent:function(e){
                this.stopPropagation(e)
            },
            preventDefault:function(e){
                if ( e && e.preventDefault )
                    //阻止默认浏览器动作(W3C)
                    e.preventDefault();
                else
                    //IE中阻止函数器默认动作的方式
                    window.event.returnValue = false;
                return false;
            },
            _withinElement:function(handler) {
                return function (e) {
                    var parent = e.relatedTarget;
                    while ( parent && parent != this ) {
                        try {
                            parent = parent.parentNode;
                        }
                        catch(e) {
                            break;
                        }
                    }
                    if ( parent != this )
                        handler.call(this, e);
                }
            }
        /*END~!Event*/
        }
    }();
    return Event;
});
/*END#!Event*/
/*#!Color*/
M.use("Color",function(){
    var color=function(){
        return {
            /*~!Color*/
            DtoHex:function(number){
                return M.Math.fillZero(number.toString(16),2)
            },
            getRandomColor:function(){
                var str = "0123456789abcdef";
                var t = "#";
                for(var j=0;j<6;j++)
                {
                    t = t+ str.charAt(Math.random()*str.length);
                }
                return t;
            }
        /*END~!Color*/
        }
    }();
    return color;
},[{
    module:"Math",
    methods:["fillZero"]
}]);
/*END#!Color*/
/*
 *一些特殊的方法集合
 */
/*#!light*/
M.use("light",function(){
    var light=function(){
        return {
            /*~!light*/
            /**
		*循环指定某个方法多少次
		*/
            loop:function(func,times){
                var func=func||function(){};
                var times=times||1;
                for(var i=0;i<times;i++){
                    func(i);
                }
            },
            /**
             *遍历数组或者字符串
             */
            each:function(arr,funcs,handle){
                M.Array.each(arr, funcs,handle)
            },
            /**
             * 获取url参数,如果指定参数,则返回此索引的值,如果没有指定参数就返回一个json的键值对
             */
            getUrlParam:function(key){
                var href=window.location.href,pos=href.indexOf("?"),arr,json;
                href=href.substr(pos+1,href.length).split("&")
                if(key==undefinded){
                    this.each(href,function(i){
                        arr=i.split("=")
                        json[arr[0]]=arr[1]
                    })
                    return json;
                }else{
                    for(var i =0,n=href.length;i<n;i++){
                        if(href[i].indexOf(key)!=-1){
                            return href[i].split("=")[1]
                        }
                    }
                }
            },
            obj2str:function(o){
                var r = [];
                if(typeof o =="string") return "\""+o.replace(/([\'\"\\])/g,"\\$1").replace(/(\n)/g,"\\n").replace(/(\r)/g,"\\r").replace(/(\t)/g,"\\t")+"\"";
                if(typeof o =="undefined") return "undefined";
                if(typeof o == "object"){
                    if(o===null) return "null";
                    else if(!o.sort){
                        for(var i in o)
                            r.push("\""+i+"\":"+this.obj2str(o[i]))
                        r="{"+r.join()+"}"
                    }else{
                        for(var i =0;i<o.length;i++)
                            r.push(this.obj2str(o[i]))
                        r="["+r.join()+"]"
                    }
                    return r;
                }
                return o.toString();
            }
        /*END~!light*/
            
        }
    }();
    return light;
},[{
    module:"Array",
    methods:["each"]
}])
/*END#!light*/
/*#!OOP*/
M.use("OOP",function(){
    var oop=function(){
        return{
            /*~!OOP*/
            extend:function(target,source){
                var s=new source(),f;
                for(var i in s){
                    target.prototype[i]=s[i];
                }
                return target;
            },
            addPrototype:function(target,prototypes){
                for(var i in prototypes){
                    target.prototype[i]=prototypes[i];
                }
            }
        /*END~!OOP*/
        }
    }();
    return oop;
});
/*END#!OOP*/
/*#!Import*/
M.use("Import",function(){
    var Import=function(){
        return{
            /**
     *引入js文件,必须在domready之后调用,不确定的方法,待定
     *@param {string} src js文件的url路径
     */
            /*~!Import*/
            $importJS:function(src,callback){
                var a=document.createElement("script");
                a.src=src;
                a.type="text/javascript"
                document.getElementsByTagName("head")[0].appendChild(a);
                if(callback!=undefined){

                    a.onload=function(){
                        M.data.importing--;
                        try{
                            callback();
                        }catch(e){}
                    }
                    a.onreadystatechange=function(){
                        if(this.readyState=="complete"||this.readyState=="loaded"){
                            try{
                                callback();
                            }catch(e){}
                        }
                    }
                }
            },
            $importCSS:function(src){
                var a=document.createElement("link");
                a.rel="stylesheet"
                a.type="text/css"
                a.href=src;
                document.getElementsByTagName("head")[0].appendChild(a);
            },
            $importImg:function(src,callback){
                var img=new Image();
                img.onload=function(){
                    callback.call(img);
                    this.onload=null;
                }
                img.src=src;
                return img;
            }
        /*END~!Import*/
        }
    }()
   
    return Import;
})
/*END#!Import*/