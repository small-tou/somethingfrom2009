/*
 * 这是M框架的核心类库,里面包含如下几个模块
 *
 * 具体文档见:
 * @see http://www.html-js.com
 * @author 孙信宇(芋头)
 * @version 1.0.3
 *
 * 包含一些最基本的操作方法,本框架提供基本的操作,尽量做到兼容所有的浏览器,但是在测试中忽略了opera浏览器
 * 本框架实现均非常简单,所以提供的配置项较少,属于傻瓜型,易于使用
 * 框架包含诸多创新功能,部分处于试验阶段
 *
 *
 * M框架由天祁创作.没有经过任何严格测试,正处在创作阶段.请不要轻易使用
 * 谢谢,有问题联系:
 * @email xinyu198736@gmail.com
 * @qq 676588498
 *
 */
var MJ={};
MODCONFIG={   //路由信息,定位到不同的模块
    "base":["lib/base.js",["vector"]],
    "ease":["lib/ease.js",["matrix"]],
    "vector":["lib/math/vector.js",[]],
    "matrix":["lib/math/matrix.js",["vector"]],
    "cubicBezier":["lib/math/cubicbezier.js",["matrix"]],
    "anim":["lib/anim.js",["base"]],
    "ui-anim":["lib/anim/ui-anim.js",["anim"]],
    "ajax":["mods/ajax.js",[]],
    "dd":['mods/ddd.js',["anim"]],
    "table":['mods/table.js',["base","base-extend"]],
    "canvas.base":['canvas/base.js',[]],
    "ui":["ui/M-UI.js",["base","base-extend","anim"]],
    "mquery":["MQuery/MQuery.js",["base"]],
    "ta":["mods/TA.js",["base"]]
};
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
        },
        /**
             *从数组中移除元素
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
             * @return {array} 返回被打乱后的数组
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
             *@return {object} 最大的值
             */
        max:function(){
            var max=0;
            for(var i=0,j=this.length;i<j;i++){
                if(this[i]*1>max) max=this[i]*1
            }
            return max;
        },
        /**
         *获取最小值
         *@return {object} 最小的值
         */
        min:function(){
            var min=0;
            for(var i=0,j=this.length;i<j;i++){
                if(this[i]*1<min) min=this[i]*1
            }
            return min;
        },
        /**
             * 统计数组中某个元素出现的次数
             * @param {object} item 要统计的元素
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
        /**
         *二维数组字符串化输出
         *@return {string} 输出后的字符串
         */
        to_s:function(){
            var return_str="";
            if(typeof(this[0])=="array"){
                for(var i=0,n=this.length;i<n;i++){
                    return_str+=this.toString1(this[i])+"\n";
                }
            }else{
                for(var i=0,j=this.length;i<j;i++){
                    return_str+=this[i]+"\n"
                }
            }
            return return_str;
        },
        /**
         *交换两个索引的元素的值
         *@param {number} i 第一个索引
         *@param {number} j 第二个索引
         */
        swap:function(i,j){
            var temp = this[i];
            this[i] = this[j];
            this[j] = temp;
            return this;
        },
        /**
             *判断某个元素在数组中的索引
             *@param {object} item 元素
             *@param {object} 按照此元素对比,可以进行第二层的对比,即判断this[i][index]==item[index]
             *@return {boolean} 索引位置,找不到就返回-1
             */
        pos:function(item,index){
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
        },
        /**
         *去重
         *@return {array} 去重后的新数组
         */
        unique:function(){
            var arr=[],arr_r=[]
            for(var i=0,j=this.length;i<j;i++){
                if(arr.has(this[i])){
                    arr_r.push(this[i])
                    this.splice(i,1)
                }else{
                    arr.push(this[i])
                }
            }
            return arr_r
        }
    });

    //给array添加原型结束
    //在此添加了一个css3 选择器代码
    eval(function(p,a,c,k,e,d){
        e=function(c){
            return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))
        };

        if(!''.replace(/^/,String)){
            while(c--)d[e(c)]=k[c]||e(c);
            k=[function(e){
                return d[e]
            }]
            e=function(){
                return'\\w+'
            };
            c=1
        };
        while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);
        return p
    }('7 x=6(){7 1D="2.0.2";7 C=/\\s*,\\s*/;7 x=6(s,A){33{7 m=[];7 u=1z.32.2c&&!A;7 b=(A)?(A.31==22)?A:[A]:[1g];7 1E=18(s).1l(C),i;9(i=0;i<1E.y;i++){s=1y(1E[i]);8(U&&s.Z(0,3).2b("")==" *#"){s=s.Z(2);A=24([],b,s[1])}1A A=b;7 j=0,t,f,a,c="";H(j<s.y){t=s[j++];f=s[j++];c+=t+f;a="";8(s[j]=="("){H(s[j++]!=")")a+=s[j];a=a.Z(0,-1);c+="("+a+")"}A=(u&&V[c])?V[c]:21(A,t,f,a);8(u)V[c]=A}m=m.30(A)}2a x.2d;5 m}2Z(e){x.2d=e;5[]}};x.1Z=6(){5"6 x() {\\n  [1D "+1D+"]\\n}"};7 V={};x.2c=L;x.2Y=6(s){8(s){s=1y(s).2b("");2a V[s]}1A V={}};7 29={};7 19=L;x.15=6(n,s){8(19)1i("s="+1U(s));29[n]=12 s()};x.2X=6(c){5 c?1i(c):o};7 D={};7 h={};7 q={P:/\\[([\\w-]+(\\|[\\w-]+)?)\\s*(\\W?=)?\\s*([^\\]]*)\\]/};7 T=[];D[" "]=6(r,f,t,n){7 e,i,j;9(i=0;i<f.y;i++){7 s=X(f[i],t,n);9(j=0;(e=s[j]);j++){8(M(e)&&14(e,n))r.z(e)}}};D["#"]=6(r,f,i){7 e,j;9(j=0;(e=f[j]);j++)8(e.B==i)r.z(e)};D["."]=6(r,f,c){c=12 1t("(^|\\\\s)"+c+"(\\\\s|$)");7 e,i;9(i=0;(e=f[i]);i++)8(c.l(e.1V))r.z(e)};D[":"]=6(r,f,p,a){7 t=h[p],e,i;8(t)9(i=0;(e=f[i]);i++)8(t(e,a))r.z(e)};h["2W"]=6(e){7 d=Q(e);8(d.1C)9(7 i=0;i<d.1C.y;i++){8(d.1C[i]==e)5 K}};h["2V"]=6(e){};7 M=6(e){5(e&&e.1c==1&&e.1f!="!")?e:23};7 16=6(e){H(e&&(e=e.2U)&&!M(e))28;5 e};7 G=6(e){H(e&&(e=e.2T)&&!M(e))28;5 e};7 1r=6(e){5 M(e.27)||G(e.27)};7 1P=6(e){5 M(e.26)||16(e.26)};7 1o=6(e){7 c=[];e=1r(e);H(e){c.z(e);e=G(e)}5 c};7 U=K;7 1h=6(e){7 d=Q(e);5(2S d.25=="2R")?/\\.1J$/i.l(d.2Q):2P(d.25=="2O 2N")};7 Q=6(e){5 e.2M||e.1g};7 X=6(e,t){5(t=="*"&&e.1B)?e.1B:e.X(t)};7 17=6(e,t,n){8(t=="*")5 M(e);8(!14(e,n))5 L;8(!1h(e))t=t.2L();5 e.1f==t};7 14=6(e,n){5!n||(n=="*")||(e.2K==n)};7 1e=6(e){5 e.1G};6 24(r,f,B){7 m,i,j;9(i=0;i<f.y;i++){8(m=f[i].1B.2J(B)){8(m.B==B)r.z(m);1A 8(m.y!=23){9(j=0;j<m.y;j++){8(m[j].B==B)r.z(m[j])}}}}5 r};8(![].z)22.2I.z=6(){9(7 i=0;i<1z.y;i++){o[o.y]=1z[i]}5 o.y};7 N=/\\|/;6 21(A,t,f,a){8(N.l(f)){f=f.1l(N);a=f[0];f=f[1]}7 r=[];8(D[t]){D[t](r,A,f,a)}5 r};7 S=/^[^\\s>+~]/;7 20=/[\\s#.:>+~()@]|[^\\s#.:>+~()@]+/g;6 1y(s){8(S.l(s))s=" "+s;5 s.P(20)||[]};7 W=/\\s*([\\s>+~(),]|^|$)\\s*/g;7 I=/([\\s>+~,]|[^(]\\+|^)([#.:@])/g;7 18=6(s){5 s.O(W,"$1").O(I,"$1*$2")};7 1u={1Z:6(){5"\'"},P:/^(\'[^\']*\')|("[^"]*")$/,l:6(s){5 o.P.l(s)},1S:6(s){5 o.l(s)?s:o+s+o},1Y:6(s){5 o.l(s)?s.Z(1,-1):s}};7 1s=6(t){5 1u.1Y(t)};7 E=/([\\/()[\\]?{}|*+-])/g;6 R(s){5 s.O(E,"\\\\$1")};x.15("1j-2H",6(){D[">"]=6(r,f,t,n){7 e,i,j;9(i=0;i<f.y;i++){7 s=1o(f[i]);9(j=0;(e=s[j]);j++)8(17(e,t,n))r.z(e)}};D["+"]=6(r,f,t,n){9(7 i=0;i<f.y;i++){7 e=G(f[i]);8(e&&17(e,t,n))r.z(e)}};D["@"]=6(r,f,a){7 t=T[a].l;7 e,i;9(i=0;(e=f[i]);i++)8(t(e))r.z(e)};h["2G-10"]=6(e){5!16(e)};h["1x"]=6(e,c){c=12 1t("^"+c,"i");H(e&&!e.13("1x"))e=e.1n;5 e&&c.l(e.13("1x"))};q.1X=/\\\\:/g;q.1w="@";q.J={};q.O=6(m,a,n,c,v){7 k=o.1w+m;8(!T[k]){a=o.1W(a,c||"",v||"");T[k]=a;T.z(a)}5 T[k].B};q.1Q=6(s){s=s.O(o.1X,"|");7 m;H(m=s.P(o.P)){7 r=o.O(m[0],m[1],m[2],m[3],m[4]);s=s.O(o.P,r)}5 s};q.1W=6(p,t,v){7 a={};a.B=o.1w+T.y;a.2F=p;t=o.J[t];t=t?t(o.13(p),1s(v)):L;a.l=12 2E("e","5 "+t);5 a};q.13=6(n){1d(n.2D()){F"B":5"e.B";F"2C":5"e.1V";F"9":5"e.2B";F"1T":8(U){5"1U((e.2A.P(/1T=\\\\1v?([^\\\\s\\\\1v]*)\\\\1v?/)||[])[1]||\'\')"}}5"e.13(\'"+n.O(N,":")+"\')"};q.J[""]=6(a){5 a};q.J["="]=6(a,v){5 a+"=="+1u.1S(v)};q.J["~="]=6(a,v){5"/(^| )"+R(v)+"( |$)/.l("+a+")"};q.J["|="]=6(a,v){5"/^"+R(v)+"(-|$)/.l("+a+")"};7 1R=18;18=6(s){5 1R(q.1Q(s))}});x.15("1j-2z",6(){D["~"]=6(r,f,t,n){7 e,i;9(i=0;(e=f[i]);i++){H(e=G(e)){8(17(e,t,n))r.z(e)}}};h["2y"]=6(e,t){t=12 1t(R(1s(t)));5 t.l(1e(e))};h["2x"]=6(e){5 e==Q(e).1H};h["2w"]=6(e){7 n,i;9(i=0;(n=e.1F[i]);i++){8(M(n)||n.1c==3)5 L}5 K};h["1N-10"]=6(e){5!G(e)};h["2v-10"]=6(e){e=e.1n;5 1r(e)==1P(e)};h["2u"]=6(e,s){7 n=x(s,Q(e));9(7 i=0;i<n.y;i++){8(n[i]==e)5 L}5 K};h["1O-10"]=6(e,a){5 1p(e,a,16)};h["1O-1N-10"]=6(e,a){5 1p(e,a,G)};h["2t"]=6(e){5 e.B==2s.2r.Z(1)};h["1M"]=6(e){5 e.1M};h["2q"]=6(e){5 e.1q===L};h["1q"]=6(e){5 e.1q};h["1L"]=6(e){5 e.1L};q.J["^="]=6(a,v){5"/^"+R(v)+"/.l("+a+")"};q.J["$="]=6(a,v){5"/"+R(v)+"$/.l("+a+")"};q.J["*="]=6(a,v){5"/"+R(v)+"/.l("+a+")"};6 1p(e,a,t){1d(a){F"n":5 K;F"2p":a="2n";1a;F"2o":a="2n+1"}7 1m=1o(e.1n);6 1k(i){7 i=(t==G)?1m.y-i:i-1;5 1m[i]==e};8(!Y(a))5 1k(a);a=a.1l("n");7 m=1K(a[0]);7 s=1K(a[1]);8((Y(m)||m==1)&&s==0)5 K;8(m==0&&!Y(s))5 1k(s);8(Y(s))s=0;7 c=1;H(e=t(e))c++;8(Y(m)||m==1)5(t==G)?(c<=s):(s>=c);5(c%m)==s}});x.15("1j-2m",6(){U=1i("L;/*@2l@8(@\\2k)U=K@2j@*/");8(!U){X=6(e,t,n){5 n?e.2i("*",t):e.X(t)};14=6(e,n){5!n||(n=="*")||(e.2h==n)};1h=1g.1I?6(e){5/1J/i.l(Q(e).1I)}:6(e){5 Q(e).1H.1f!="2g"};1e=6(e){5 e.2f||e.1G||1b(e)};6 1b(e){7 t="",n,i;9(i=0;(n=e.1F[i]);i++){1d(n.1c){F 11:F 1:t+=1b(n);1a;F 3:t+=n.2e;1a}}5 t}}});19=K;5 x}();',62,190,'|||||return|function|var|if|for||||||||pseudoClasses||||test|||this||AttributeSelector|||||||cssQuery|length|push|fr|id||selectors||case|nextElementSibling|while||tests|true|false|thisElement||replace|match|getDocument|regEscape||attributeSelectors|isMSIE|cache||getElementsByTagName|isNaN|slice|child||new|getAttribute|compareNamespace|addModule|previousElementSibling|compareTagName|parseSelector|loaded|break|_0|nodeType|switch|getTextContent|tagName|document|isXML|eval|css|_1|split|ch|parentNode|childElements|nthChild|disabled|firstElementChild|getText|RegExp|Quote|x22|PREFIX|lang|_2|arguments|else|all|links|version|se|childNodes|innerText|documentElement|contentType|xml|parseInt|indeterminate|checked|last|nth|lastElementChild|parse|_3|add|href|String|className|create|NS_IE|remove|toString|ST|select|Array|null|_4|mimeType|lastChild|firstChild|continue|modules|delete|join|caching|error|nodeValue|textContent|HTML|prefix|getElementsByTagNameNS|end|x5fwin32|cc_on|standard||odd|even|enabled|hash|location|target|not|only|empty|root|contains|level3|outerHTML|htmlFor|class|toLowerCase|Function|name|first|level2|prototype|item|scopeName|toUpperCase|ownerDocument|Document|XML|Boolean|URL|unknown|typeof|nextSibling|previousSibling|visited|link|valueOf|clearCache|catch|concat|constructor|callee|try'.split('|'),0,{}))
    //选择器代码结束
    
    
    var E,D,T
    /**
     *@class query
     *@description 每次调用MJ()都会返回一个此对象的实例
     *@param {object} selector 选择器,可以是dom元素也可以是选择器
     */
    var Query=function(selector){
        this.init(selector)
    }
    Query.prototype={
        isQuery:true,
        
        init:function(selector){
            E=MJ.Event||null,D=MJ.Dom||null,T=MJ.tool||null
            if(T.isElement(selector)){
                this.eles=[selector]
                this.selector=null;
                this.length=1;
                return this;
            }else if(selector==undefined){
                this.eles=[]
                this.selector=null;
                this.length=0;
                return this;
            }
            this.eles=cssQuery(selector);
            this.selector=selector;
            this.length=this.eles.length

            return this;
        },
        /**
         *对每个元素执行一次方法
         *@param {function} callback 要执行的方法
         *@param {object} context 执行的作用域
         *@return {query} Query的实例
         */
        each:function(callback,context){
            this.eles.each(callback,context);
            return this;
        },
        /**
         *获取存在元素里的dom元素的个数
         *@return {number} 
         */
        size:function(){
            return this.length;
        },
        get:function(){
            return this;
        },
        index:function(item){
            return this.eles.getPos(item);
        },
        addClass:function(className){
            this.each(function(i){
                D.addClass(i,className)
            })
            return this;
        },
        removeClass:function(className){
            this.each(function(i){
                D.removeClass(i,className)
            })
        },
        getClasses:function(){
            return this._AtoS(D.getAllClass(this.eles[0]))
        },
        hasClass:function(className){
            var returnValue=[]
            this.each(function(i){
                returnValue.push(D.hasClass(i,className))
            })
            return this._AtoS(returnValue)
        },
        toggleClass:function(className){
            this.each(function(i){
                var j;
                if((j=MJ.MQuery(i)).hasClass(className)){
                    j.removeClass(className)
                }else{
                    j.addClass(className)
                }
            })
        },
        attr:function(key,value){
            if(value==undefined){
                var returnValue=[],j;
                this.each(function(i){
                    (j=i.getAttribute(key))&&returnValue.push(j);
                })
                return this._AtoS(returnValue)
            }else{
                this.each(function(i){
                    i.setAttribute(key,value)
                })
                return this;
            }
        },
        removeAttr:function(key){
            this.each(function(i){
                i.removeAttribute(key)
            })
            return this;
        },
        html:function(value){
            if(this._U(value))
                return this.eles[0].innerHTML;
            else{
                this.each(function(i){
                    i.innerHTML=value;
                })
                return this;
            }
        },
        text:function(value){
            if(this._U(value)){
                return this.eles[0].innerHTML.replace(/\<.*?\>(.*?)\<\/.*?\>/g,"$1")
            }else{
                this.each(function(i){
                    i.innerHTML=value.replace(/\<.*?\>(.*?)\<\/.*?\>/g,"$1");
                })
                return this;
            }
        },
        val:function(value){
            if(this._U(value)){
                var ele=this.eles[0]
                if(ele.options){
                    return ele.options[ele.selectedIndex].text
                }
                return this.eles[0].value
            }else{
                this.each(function(i){
                    i.value=value;
                })
            }
        },
        append:function(html){
            if(typeof(html)=="string") this.html(this.html()+html);
            else if(html.isQuery){
                A.each(html.eles,function(i){
                    this.eles[0].appendChild(i)
                })
            }else{
                this.eles[0].appendChild(html)
            }
        },
        anim:function(config,interval){
            if(!MJ.Anim) {
                alert("no anim module")
            }
            this.each(function(i){
                var anim=new MJ.Anim(i,config,interval)
                anim.animate();
            })
        },
        ajax:function(method1,url1,callback1,postdata){
            if(!MJ.Ajax) {
                alert("no ajax module")
            }
            var ajax=new MJ.Ajax(method1,url1,callback1,postdata);
        },
        getCss:function(key,haspx){
            var _ele=this.eles[0]
            if(haspx===undefined) haspx=true
            var val=T.isIE?_ele.currentStyle[key]:window.getComputedStyle(_ele,null)[key];
            if(val!="auto") return haspx?val:val.replace("px","")*1
            return false;
        },
        setCss:function(attr,value){
            this.each(function(ele){
                if(attr!="opacity"){
                    ele.style[attr]=value+"px"
                }else{
                    T.isIE?ele.style.filter="alpha(opacity="+value*100+")":ele.style['opacity']=value+"";
                }
            })

        },
        _addEvent:function(){

        }(),
        toString:function(){
            return this.eles;
        },
        /**
         * 传入一个数组,判断如果只有一个值,返回其第一个元素
         * 否则,返回数组
         * 主要在此环境中,数组和单个对象混淆使用
         */
        _AtoS:function(object){
            if(object.length==1){
                return object[0]
            }else{
                return object
            }
        },
        _U:function(value){
            return value==undefined;
        },
        getEle:function(index){
            if(index==undefined)
                return this.eles
            else return this.eles[index]
        }
    }
    //添加jq式的事件支持
    var EventList=[
    "mousewheel",
    "click",
    "blur",
    "mouseover",
    "mousemove",
    "mouseout",
    "mousedown",
    "mouseup",
    "focus",
    "load",
    "abort",
    "change",
    "dblclick",
    "keydown",
    "focus",
    "keypress",
    "keyup",
    "resize",
    "select",
    "submit",
    "unload"
    ]
    EventList.each(function(i){
        Query.prototype[i]=function(func){
            this.each(function(j){
                E.on(j,i,func)
            })
            return this;
        }
    },Query);
    //MJ是顶级对象,之后所有的对象都依附于此之上
    /**
     *顶级对象
     */
    MJ=function(selector){
        return new Query(selector)
    }
    /**
     *给MJ对象添加几个基本方法和属性
     */
    
    mix(MJ,{
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
                     *输出,这些函数可以随意变动,属于无关紧要的函数
                     *@param {string} str 要输出的值
                     *@param {string} method 类型,例如:alert,或者error,warning之类,目前可用alert和debug,debug会在页面生成一个textarea
                     */
                trace:function(str,method){
                    if(DEBUG===false) return;
                    if(method=="alert"){
                        alert(str);
                        return;
                    }
                    if(!document.getElementById("debug")){

                        var ele=document.createElement("textarea")
                        ele.style.width="300px";
                        ele.style.height="200px"
                        ele.id="debug";
                        document.body.appendChild(ele)
                    }
                    document.getElementById("debug").value+=str+"\r\n";
                    document.getElementById("debug").scrollTop = document.getElementById("debug").scrollHeight;
                },
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
                }

            }
        }(),
        global:{},//全局变量都放在这里,使用后注意清除,可以定时检查是否有没有清楚掉的全局变量(待定
        data:{//用来存储一些状态数据,是临时性容器
            importing:0
        },
        info:{
            //version代表版本号,如果引用了不同版本号的程序,互相不会冲突,每个版本号下的对象都只依附在此版本号之下,和其他程序不会冲突
            //暂时取消此功能

            //这里存放着使用到的模块列表和方法列表,在use的第三个参数里定义这些东西,之后用在打包压缩里
            MODULES:{},
            RELATIONS:[]

        }
    });
    try{
        window.MJBASEURL=MJBASEURL||"http://localhost/MJ/"
         window.CACHE=CACHE||false
    }catch(e){
        window.MJBASEURL="http://localhost/MJ/"
         window.CACHE=false
    }
  
   
    mix(MJ,{
        loadInfo:{
            ISLOADED:[], //已经加载完的模块
            ISLOADING:[], //正在加载中的模块
            USEFUNCTIONS:[], //用在按需异步加载中,用来存储加载完执行的方法和依赖模块的关系,只有所有模块加载完后才执行
            BASEURL:MJBASEURL,
            VERSION:"version1.0.3",
            TIMESTAMP:"2010-4-272", //异步加载的js的时间戳

            /**
             *这里是提供给异步按需加载使用的
             *按需异步加载的分析:
             *需要的功能:按需加载,异步,根据依赖关系创建队列,按队列加载
             *如何实现:
             *按需加载是通过use的第一个个参数触发的,它总是有一个起点,例如页面里调用了MJ.use就将其第一个参数作为入口点,
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
            ROUTE:MODCONFIG,
            relations:{}, //最后生成的关系数组
            loadingInfo:{},
            isCache:false
        },
        checkUse:function(module){

        },
        use:function(m,f){
            this._getRelation(m,f)
            this._load()
        },
        _getRelation:function(m,f){
            var g=MJ.global,
            c,
            info=MJ.loadInfo,
            d
            (g.relationCount==undefined)?g.relationCount=0:g.relationCount++;
            c=g.relationCount;
            mix(d=info.relations[c]={},{
                data:[],
                func:f
            })
            if(this.tool.isArray(m)){
                d.data.push(m)
                this.recur(m)
            }
            else{
                d.data.push([m])
                this.recur([m])
            }
            return info.relations
        },
        recur:function(ms){
            var info=this.loadInfo,
            modules=[],
            r=info.ROUTE;
            ms.each(function(i){
                r[i][1].each(function(ii){
                    modules.push(ii)
                })
            })
            if(modules.length==0) return
            info.relations[MJ.global.relationCount].data.push(modules);
            this.recur(modules)

        },
        /**
         *开始加载某个关系链
         *
         */
        _load:function(){
            var info=this.loadInfo,
            r=info.relations,
            l=(info.loadingInfo[MJ.global.relationCount]={}),
            g=MJ.global,
            c=MJ.global.relationCount,
            i,j,
            nowData=r[c]
            mix(l,{
                f:nowData.func,
                count:(i=nowData.data.length),
                loading_arr:nowData.data[i-1]
            })
            this.loadScript(c);
        },
        check:function(m,num){
            MJ.tool.trace("加载了"+m+"模块")
            var info=MJ.loadInfo,
            l=info.loadingInfo[num]
            l.loading_arr.remove(m);
            if(l.loading_arr.length===0){
                if(l.count>=1){
                    l.count--;
                    l.loading_arr=info.relations[num].data[l.count-1]
                    if(l.count==0){
                        l.f.call(window)
                    }
                    MJ.loadScript(num)
                }else{

            }
            }else{

        }
        },
        loadScript:function(num){
            var info=this.loadInfo,
            baseinfo=this.info,
            r=info.relations,
            l=info.loadingInfo[MJ.global.relationCount],
            arr=l.loading_arr
            arr.each(function(i){
                MJ.$importJS(info.BASEURL+info.VERSION+"/"+info.ROUTE[i][0]+"?"+(CACHE==false?info.TIMESTAMP:"")+(info.isCache?"":Math.random())+".js", MJ.check,i,num);
            })
        },
        add:function(){
            var each=MJ.tool.baseEach;
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
        $importJS:function(src,callback,param1,param2){
            var a=document.createElement("script");
            a.src=src;
            a.type="text/javascript"
            document.getElementsByTagName("head")[0].appendChild(a);

            if(callback!=undefined){

                a.onload=function(){
                    MJ.data.importing--;
                    try{
                        callback.call(window,param1,param2)
                    }catch(e){}
                }
                a.onreadystatechange=function(){
                    if(this.readyState=="complete"||this.readyState=="loaded"){
                        try{
                            callback.call(window,param1,param2)
                        }catch(e){}
                    }
                }
            }
        },
        setConfig:function(detail){

        }
    });
    mix(MJ,{
        mix:mix,
        ap:ap,
        /**
         * 产生一个新的对象，让它继承自某个对象，并添加一些方法 
         * #约定:在对象的构造方法里不允许加入任何参数，参数通过原型方法init等传入
         *
         * @param {object} r 新的对象
         * @param {object} s 被扩展的对象
         * @param {object} px 添加到新对象中的原型成员
         * @param {object} sx 添加到新对象中的静态成员
         */
        extend:function(r,s,px,sx){
            var n=this.namespace(r)

            n.obj[n.name]=function(){
                for(var i in sx){
                    this[i]=sx[i]
                }
            }
            var rObj= n.obj[n.name];
            for(var i in s.prototype){
                rObj.prototype[i]=s.prototype[i]
            }
            
            this.ap(rObj,px)
            return rObj;
        }
    })
})();