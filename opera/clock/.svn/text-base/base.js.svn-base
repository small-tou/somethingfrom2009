/**
 * 这是一个基础中的基础的模块的集合,只包含常用方法,如果觉得不够用,可以包含base-extend.js文件来扩充功能
 *
 * @author 孙信宇(芋头)
 * @blog http://www.beiju123.cn/blog
 * @time 2010-4-27 14:16:52
 * 
 */
/*#!Vector&TYPE=MUL*/
MY.create("Vector",function(){
    /**
     *一个缩减版的向量对象,用来表示坐标位置,可以做向量运算
     *程序中所有涉及二维运算的例如:位置,大小等都以此做为基本数据结构,但是如果需要使用其高级功能,需要引入base-extend.js
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
            return new MY.Vector(this.x+v.x,this.y+v.y);
        },
        sub:function(v){
            return new MY.Vector(this.x-v.x,this.y-v.y);
        },
        xyToVector:function(xy){
            return new MY.Vector(xy.x,xy.y)
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
            return new MY.Vector(this.y/(Math.sqrt(this.x*this.x+this.y*this.y)),-this.x/(Math.sqrt(this.x*this.x+this.y*this.y)));
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
/**
 *大多数基础操作都在这个对象中,即M.dom对象,这是一个单例对象,可以直接调用.
 *例如:M.dom.get("id");
 *有一个别名叫做M.base,所以也可以这样调用:M.base.get("id");
 *M.dom相当于一个工具库,里面包含了很多特殊的操作.掌握了这些方法可以让代码写的更简洁,更整洁
 */
/*#!dom&TYPE=SIG*/
MY.create("Dom",function(){
    var T=MY.tool,V=MY.Vector;
    var dom=function(){
        var _bodyValue=function(key){
            if(document.documentElement&&document.documentElement[key])
                return document.documentElement[key]
            else
                return document.body[key]
        }
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
                    if(params.p){
                        (params.p).appendChild(ele)
                    }
                    if(params.i){
                        ele.innerHTML=params.i;
                    }
                    if(params.c){
                        ele.className=params.c;
                    }
                    if(params.a){
                        var attr=params.a;
                        for(var i in attr){
                            ele[i]=attr[i];
                        }
                    }
                    if(params.s){
                        this.mixinStyle(ele,params.s)
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
                return_ele=[]
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
            /**
             *向某个元素后面插入元素
             *@param {element} newEl 新元素
             *@param {element} targetEl 参考元素
             */
            insertAfter:function(newEl, targetEl){
                var parentEl = targetEl.parentNode;

                if(parentEl.lastChild == targetEl){
                    parentEl.appendChild(newEl);
                }else{
                    parentEl.insertBefore(newEl,targetEl.nextSibling);
                }
            },
            /**
             *将新元素放到旧元素原来的位置,删除旧的元素
             *@param {element} newEl 新元素
             *@param {element} targetEl 被替换的元素
             */
            replace:function(newEl, targetEl){
                var p=targetEl.parentNode;
                p.insertBefore(newEl,targetEl);
                p.removeChild(targetEl)
                return true;
            },
            /**
             * 有的时候某个元素会同时拥有两个class,这个时侯判断class_a 是否是class_b的一部分
             * 也可以第一个参数是dom元素,第二个是要判断的className
             * @param {string|element} class_a
             * @param {string} class_b
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
                if(T.isArray(className)){
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
                if(T.isArray(className)){
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
             *获取类似style里的结构的元素属性的json表示
             */
            getAttrJson:function(ele,attr){

                var v=ele.getAttribute(attr),r={},t;
                for(var i=0,n=(v=v.split(";")).length;i<n;i++){
                    t=v[i].split(":");
                    r[t[0]]=t[1]
                }
                return r;
            },
           
            /**
             *将一个json的style表示形式赋值到一个元素的style上,直接赋值无法正常运行,所以分开赋值
             *例如:
            mixinStyle(M.dom.get("block2"),{
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
             *获取当前在元素上生效的css属性的值
             */
            getCss:function(_ele,key){
                var val=T.isIE?_ele.currentStyle[key]:window.getComputedStyle(_ele,null)[key];
                if(val!="auto") return val
                return false;
            },
            setCssValue:function(ele,attr,value){
                if(attr!="opacity"){
                    ele.style[attr]=value+"px"
                }else{
                    T.isIE?ele.style.filter="alpha(opacity="+value*100+")":ele.style['opacity']=value+"";
                }
            },
            /**
             *通用函数,用来获取某个css属性的值
             */
            getCssValue:function(ele,attr){
                if(attr!="opacity"){
                    return ele.style[attr].replace("px","")
                }
                else
                    return T.isIE?ele.filters.alpha.opacity/100:ele.style.opacity;
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
                return new V(x,y)
            },
            setXY:function(ele,point){
                this.mixinStyle(ele,{
                    position:"absolute",
                    left:point.x+"px",
                    top:point.y+"px"
                })
                return new V(point.x,point.y);
            },
            getXY:function(el) {
                if (document.documentElement.getBoundingClientRect) { // IE,FF3.0+,Opera9.5+
                    var box = el.getBoundingClientRect();
                    return new V(box.left+this.getScrollXY().x,box.top+this.getScrollXY().y )
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
                    return new V(pos[0],pos[1])
                }
            },
            
            /**
             *防止innerHTML的内存泄露的危险
             */
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

                            // 移除所有通过M的addListener注册到元素上所有监听程序
                            MY.Event.clearListener(c);
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
MY.dom=MY.Dom;
/*#!Event*/
MY.create("Event",function(){
    var T=MY.tool,
    V=MY.Vector
    Event=function(){
         this._withinElement=function(handler) {
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
                if(!ele) return;
                if(ele.length&&ele.length>1){
                    for(var i=0,n=ele.length;i<n;i++){
                        this.addListener(ele[i],type,func,id,handle);
                    }
                    return;
                }
                if(typeof(id)=="string"&&/^\$\_.*/.test(id)==true){

                }else{
                    if(handle){
                        T.trace("event.addlistener有多余的参数或者事件标识符应该用$_开头");
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

                if(T.isIE){
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
                    if(T.isIE)
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
            getMousePos:function(ev){
                if(ev.pageX || ev.pageY){

                    return new V(ev.pageX,ev.pageY)
                }
                return new V(
                    ev.clientX + this._bodyValue('scrollLeft') - this._bodyValue('clientLeft'),
                    ev.clientY + this._bodyValue('scrollTop')  - this._bodyValue('clientTop')
                    )
            }

            /*END~!Event*/
        }
    }();
    return Event;
});
/*END#!Event*/
/*#!CustomEvent&TYPE=MUL*/
MY.create("CustomEvent",function(){
    /**
     *自定义的事件方法,此方法在对象内部定义,同时对象内部需要自定义一个addListener方法,用来绑定事件,
     *在对象内部用fire方法触发事件,同时可以向事件方法里传入参数
	 在对象中要设定一个方法:
	 addListener:function(type,func){
                    for(var i in this.EVENT_LIST){
                        if(i==type){
                            this.EVENT_LIST[i].push({func:func})
                            return;
                        }
                    }
                    MY.tool.trace("sprite中没有定义此种类型事件","alert")
                }
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
        fire:function(param,e){
            var ev= this.handle.EVENT_LIST[this.type]
            for(var i=0,n=ev.length;i<n;i++){
                ev[i].func.call(this.handle,{event_param:ev[i].param,fire_param:param},e);
            }
        }
        /*END~!CustomEvent*/
    }
    return CustomEvent;
});
/*END#!CustomEvent*/

