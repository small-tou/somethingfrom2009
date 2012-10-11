/**
 * 这是一个基础中的基础的模块的集合,只包含常用方法,如果觉得不够用,可以包含base-extend.js文件来扩充功能
 *
 * @author 孙信宇(芋头)
 * @blog http://www.beiju123.cn/blog
 * @time 2010-4-27 14:16:52
 *
 */
MJ.add("Vector",function(){
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
        toArray:function(){
            return [this.x,this.y]
        },
	add:function(v){
            this.x=this.x+v.x
            this.y=this.y+v.y
	    return this;
	},
	sub:function(v){
            this.x=this.x-v.x
            this.y=this.y-v.y
	    return this;
	},
	xyToVector:function(xy){
            this.x=xy.x
            this.y=xy.y
	    return this;
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
	/**
         *求某向量的法向量,返回一个单位向量,其模为1,返回的向量总是指向this向量的右边
         * @return
         */
	getNormal:function(){
            this.x=this.y/(Math.sqrt(this.x*this.x+this.y*this.y))
            this.y=-this.x/(Math.sqrt(this.x*this.x+this.y*this.y))
	    return this;
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
    return Vector;
});
/**
 *大多数基础操作都在这个对象中,即M.Dom对象,这是一个单例对象,可以直接调用.
 *例如:M.Dom.get("id");
 *有一个别名叫做M.base,所以也可以这样调用:M.base.get("id");
 *M.dom相当于一个工具库,里面包含了很多特殊的操作.掌握了这些方法可以让代码写的更简洁,更整洁
 */
MJ.add("Dom",function(){
    var T=MJ.tool,V=MJ.Vector
    var dom=function(){
        
        return {
            _bodyValue:function(key){
	    if(document.documentElement&&document.documentElement[key])
		return document.documentElement[key]
	    else
		return document.body[key]
	},
            body:T.body,
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
            create:function(tagName,params,childs){
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
                        MJ.Dom.mixStyle(ele,params.s)
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
            str2ele:function(){

            },
            /**
             *通过选择器获取选择后的第一个元素
             *@param {object} query 选择器
             *@return {element}
             */
            get:function(query,from){
                return MJ(query,from).getEle()[0];
            },
            /**
             *通过选择器选择元素,总是返回数组
             *@param {object} query 选择器
             *@return {array} 元素数组
             */
            query:function(query,from){
                return MJ(query,from).getEle();
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
             *在输入框中获取光标的坐标,并将此坐标传入第二个参数的函数中
             *@param {element} ele 输入框元素
             *@param {function} func 每次输入都会触发的函数
             */
            getCursorPos:function(ele,func){
                var refer=document.createElement("div"),D=M.dom,E=M.Event,
                referInner=document.createElement("span")
                refer.contentEditable=true
                document.body.appendChild(refer);
                refer.appendChild(referInner)
                D.mixStyle(refer,D.getCSSes(ele,[
                    "width","height","fontSize","lineHeight","fontSize","border","padding","paddingLeft","paddingRight","paddingTop","paddingBottom","borderTop","fontFamily","overflowX","overflowY","wordBreak","wordSpacing","wordWrap"
                    ]))
                D.mixStyle(referInner,D.getCSSes(ele,[
                    "fontSize","lineHeight","fontSize","fontFamily","fontStyle","fontVariant","fontWeight","letterSpacing"
                    ]))
                D.mixStyle(refer,{
                    "visibility":"hidden"
                })
                D.setXY(refer,D.getXY(ele));
                var span=document.createElement("span");
                span.innerHTML=""
                refer.appendChild(span)
                E.on(ele,"input",function(){
                    referInner.innerHTML=this.value
                    var xy=D.getXY(span)
                    //   D.setXY(D.get("input"),new M.Vector(xy.x+10,xy.y+18))
                    func.call(window,xy)
                })
            },
            /**
             * 有的时候某个元素会同时拥有两个class,这个时侯判断class_a 是否是class_b的一部分
             * 也可以第一个参数是dom元素,第二个是要判断的className
             * @param {string|element} class_a
             * @param {string} class_b
             * @return {boolean}
             */
            hasClass:function(class_a,class_b){
                if(typeof(class_a)!="string"){
                    return this.hasClass(class_b,class_a.className)
                }
                var class_arr=class_a.replace(/\s{2,}/g," ").split(" ");
                for(var i=0;i<class_arr.length;i++){
                    if(class_arr[i]==class_b) return true;
                }
                return false;
            },
            /**
             *向某个元素的classname添加一个class
             *此函数的特点是防止了误判断,例如 如果原来的classname是"realname" 再向其添加"name"的时候 不会将realname中的name当成已经存在的name.
             *从而精确地判断是否已经存在这个class了.
             *虽然字符串操作可能会耗费性能,对性能要求过高的情况避免使用
             *@param {element} ele 操作的元素
             *@param {string} className 添加的classname
             */
            addClass:function(ele,className){
                if(T.isArray(className)){
                    for(var i=0,n=className.length;i<n;i++){
                        this.addClass(ele,className[i])
                    }
                    return;
                }
                var str=ele.className;
                //过滤多余的空格,同时在首尾添加空格
                str=(" "+str+" ").replace( /\s{2,}/g," ");
                if(str.indexOf(" "+className+" ")==-1){
                    str+=" "+className;
                }
                ele.className=str;
            },
            /**
             *从某个元素的classname里移除一个class
             *@param {element} ele 操作的元素
             *@param {string} className 移除的classname
             */
            removeClass:function(ele,className){
                if(T.isArray(className)){
                    for(var i=0,n=className.length;i<n;i++){
                        this.removeClass(ele,className[i])
                    }
                    return;
                }
                var str=ele.className;
                //过滤多余的空格,同时在首尾添加空格
                str=(" "+str+" ").replace( /\s{2,}/g," ");
                str=str.replace(" "+className+" "," ");
                ele.className=str;
            },
            /**
             *获取某个元素上所有classname的数组
             *@param {element} ele 操作的元素
             *@return {array}
             */
            getAllClass:function(ele){
                return ele.className.split(/\s{1,}/);
            },
            /**
             *一次性赋予多个属性值
             *@param {element} ele 元素
             *@param {json} details 属性的键值对
             */
            setAttrs:function(ele,details){
                for(var i  in details){
                    ele.setAttribute(i,details[i])
                }
            },
            /**
             *获取类似style里的结构的元素属性的json表示,属性里这样写:  aa:value;bb:value2;cc:value3;
             *@param {element} ele 元素
             *@param {string} attr 属性的键名
             *@return {json} 键值对
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
            *mixStyle(M.dom.get("block2"),{
             *   backgroundColor:"#aaa",
             *   height:"200px"
            *})
            *@param {element} ele 操作的元素
            *@param {json} styles 要附加的属性
             */
            mixStyle:function(ele,styles){
                if(ele.length){
                    for(var i=0;i<ele.length;i++){
                        this.mixin(ele[i].style,styles)
                    }
                    return;
                }
                this.mixin(ele.style,styles)
            },
            mixin:function(target,options){
                for(var i in options){
                    target[i]=options[i]
                }
                return target
            },

            /**
             *获取当前在元素上生效的css属性的值
             *@param {element} 操作的元素
             *@param {string} 索引键
             */
            getCss:function(_ele,key,haspx){
                if(haspx===undefined) haspx=true
                var val=T.isIE?_ele.currentStyle[key]:window.getComputedStyle(_ele,null)[key];
                if(val!="auto") return haspx?val:val.replace("px","")*1
                return false;
            },
            /**
             *获取或者设置css样式
             *@param {element} ele 元素
             *@param {string} attr 属性名
             *@param {string} value 属性值,如果没有此参数则是设置属性值,否则是获取
             */
            css:function(ele,attr,value){
                if(value===undefined){
                    return this._getCssValue(ele,attr)
                }else{
                    return this._setCssValue(ele,attr,value)
                }
            },
            _setCssValue:function(ele,attr,value){
                if(attr!="opacity"){
                    ele.style[attr]=value+"px"
                }else{
                    T.isIE?ele.style.filter="alpha(opacity="+value*100+")":ele.style['opacity']=value+"";
                }
            },
            /**
             *通用函数,用来获取某个css属性的值
             */
            _getCssValue:function(ele,attr){
                if(attr!="opacity"){
                    return ele.style[attr].replace("px","")
                }
                else
                    return T.isIE?ele.filters.alpha.opacity/100:ele.style.opacity;
            },
            /**
             *获取可视区域宽度
             *@return {number}
             */
            getDocumentWidth:function(){
                return this.body["clientWidth"]
            },
            /**
             *获取可视区域高度
             *@return {number}
             */
            getDocumentHeight:function(){
                return this.body["clientHeight"]
            },
            /**
             *获取页面滚动过的高和宽
             *@return {vector} 高和宽
             */
            getScrollXY:function(){
                var x=document.documentElement.scrollLeft||document.body.scrollLeft;
                var y=document.documentElement.scrollTop||document.body.scrollTop;
                return new MJ.Vector(x,y)
            },
            /**
             *获取或者设置位置
             *@param {element} ele 元素
             *@param {vector} point 坐标,如果不存在就获取位置,如果存在就设置位置
             */
            place:function(ele,point){
                if(point===undefined){
                    return  this._getXY(ele);
                }else{
                    return this._setXY(ele,point)
                }
            },
            _setXY:function(ele,point){
                this.mixStyle(ele,{
                    position:"absolute",
                    left:point.x+"px",
                    top:point.y+"px"
                })
                return new MJ.Vector(point.x,point.y);
            },
            _getXY:function(el) {
                if (document.documentElement.getBoundingClientRect) { // IE,FF3.0+,Opera9.5+
                    var box = el.getBoundingClientRect();
                    return new MJ.Vector(box.left+this.getScrollXY().x,box.top+this.getScrollXY().y )
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
                    return new MJ.Vector(pos[0],pos[1])
                }
            },
            /**
             *获取offset大小,带有边框和padding
             *@param {element} ele 元素
             *@param {vector}
             */
            getOffsetSize:function(ele){
                return new MJ.Vector(ele.offsetWidth, ele.offsetHeight);
            },
            /**
             *获取鼠标位置
             *@param {event} ev 当前的事件对象
             *@return {vector}
             */
            getMousePos:function(ev){
                if(ev.pageX || ev.pageY){

                    return new MJ.Vector(ev.pageX,ev.pageY)
                }
                return new MJ.Vector(
                    ev.clientX + this._bodyValue('scrollLeft') - this._bodyValue('clientLeft'),
                    ev.clientY + this._bodyValue('scrollTop')  - this._bodyValue('clientTop')
                    )
            },
            /**
             *防止innerHTML的内存泄露的危险
             *@param {element} el 要操作的元素
             *@param {string} html html字符串
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
                            MJ.Event.clearListener(c);
                        }
                    }
                })(el);
                // 从HTML字符串中移除script，并设置innerHTML属性
                el.innerHTML = html.replace(/<script[^>]*>[\S\s]*?<\/script[^>]*>/ig, "");
                // 返回第一个子节点的引用
                return el.firstChild;
            }
        }
    }()
    return dom;
},["Vector",{
    module:"Event",
    methods:["on"]
}]);
MJ.dom=MJ.Dom;
/**
 *@class Event
 *MJ的事件实现
 *@description 此event实现了几个基本功能,例如:
 *1.添加了mouseenter和mouseleave两个特殊事件
 *2.可以向事件里传参数
 *3.可以完全清除已经绑定的事件
 *4.对冒泡等的封装
 */
MJ.add("Event",function(){
    var T=MJ.tool,
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
            /**
             *所有的事件type
             */
            types:["abort","blur","change","click","dblclick","error","focus","keydown","keypress","keyup",
            "load","mousedown","mousemove","mouseout","mouseover","mouseup","reset","resize","select","submit","unload"],
            /**
             *为了和普通的添加方法兼容,这里的第四个参数需要判断和约定
             *第四个参数如果是字符串,且前缀是$_,则这个参数代表事件标识id,否则代表传进来的参数
             *如果没设置id标识,那么这个事件就是不可移除的,只有设置了的才可以移除
             *@param {element} ele 要处理的元素
             *@param {string} type 事件名
             *@param {function} func 要绑定的事件方法
             *@param {string|object} id 如果此参数是以"$_"开头的string,则是一个标识符,标识符用在后面移除的时候指定移除对象,否则是传进来的参数
             *@param {object} handle 可省的,在有标识的时候表示传进来的参数
             */
            addListener:function(ele,type,func,id,handle){
                if(!ele) return;
                if(ele.length&&ele.length>1){
                    for(var i=0,n=ele.length;i<n;i++){
                        this.addListener(ele[i],type,func,id,handle);
                    }
                    return;
                }
                if(typeof(id)=="string"){
                    if(/^\$\_.*/.test(id)==false) T.trace("event.addlistener事件标识符应该用$_开头");
                    else{

                }
                }else if(/^\$\_.*/.test(id)==false){
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
             *从事件列表里删除某个方法
             *@param {element} ele 元素
             *@param {string} type 事件类型
             *@param {string} id 事件id
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
	     *@param {element} ele dom节点对象
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
            /**
             *addListener的别名
             */
            on:function(ele,type,func,id,handle){
                this.addListener(ele, type, func, id, handle)
            },
            /**
             *removeListener的别名
             */
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
            /**
             *停止事件冒泡
             *@param {event} e 事件对象
             */
            stop:function(e){
                this.stopPropagation(e)
            },
            /**
             *阻止默认事件
             *@param {event} e 事件对象
             */
            preventDefault:function(e){
                if ( e && e.preventDefault )
                    //阻止默认浏览器动作(W3C)
                    e.preventDefault();
                else
                    //IE中阻止函数器默认动作的方式
                    window.event.returnValue = false;
                return false;
            }
        }
    }();
    return Event;
});
MJ.add("CustomEvent",function(){
    /**
     *自定义的事件方法,此方法在对象内部定义,同时对象内部需要自定义一个addListener方法,用来绑定事件,
     *在对象内部用fire方法触发事件,同时可以向事件方法里传入参数
	 在对象中要设定一个方法:
	 on:function(type,func,param){
            for(var i in this.EVENT_LIST){
                if(i==type){
                    this.EVENT_LIST[i].push({func:func,param:param})
                    return;
                }
            }
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
        fire:function(param){
            var ev= this.handle.EVENT_LIST[this.type]
            for(var i=0,n=ev.length;i<n;i++){
                ev[i].func.call(this.handle,{
                    event_param:ev[i].param||null,
                    fire_param:param||null
                });
            }
        }
    /*END~!CustomEvent*/
    }
    return CustomEvent;
});
/*END#!CustomEvent*/
/*#!Vector&TYPE=MUL*/

/*END#!Vector*/
MJ.add("Data",function(){
    var data=function(value){
        this.data=value||0;
        this.events={
            get:new MJ.CustomEvent("get",this),
            set:new MJ.CustomEvent("set",this)
        }
    }
    data.prototype={
        get:function(){
            return this.data
        },
        set:function(data){
            this.data=data;
            this.events.set.fire(data);
        },
        addListener:function(type,func,param){
            for(var i in this.EVENT_LIST){
                if(i==type){
                    this.EVENT_LIST[i].push({
                        func:func,
                        param:param
                    })
                    return;
                }
            }
        },
        on:function(type,func,param){
            this.addListener(type,func,param)
        }
    }
    return data
})