/**
 *这里定义了一些UI组件,UI组件之间有很多相似性,例如:操作,布局,外形,数据,操作等等,我觉得应该给他们都定义一些统一的常量,指定他们的工作方式有何相似之处
 *这样在操作相同类型的组件的时候可以模糊对被操作对象的需求,只需要他符合定义的统一规范,即可互相操作,而不需要之间约定自己的特殊交互方式
 *每个组件都应该拥有的属性:
 *1.在MY.ui.base里定义了一些方法和属性,这些属性属于必有属性
 this.config={}; //配置信息,从参数里传进来后初始化
 this.events={}; //此组件包含的所有的事件,包括内部和外部
 this.data={}; //组件的数据,其中的value属性代表组件的核心值,例如输入框的输入框里的值
 this.eles={}; //组件里可能需要被操作的元素的集合
 this.ele=null; //组件最外层的元素,在和外部交互布局的时候用
 this.isUI=true; //用来标识是否是组件,值均为true
 this.wrap=null;//组件的最内层,可以包含其他组件,如果是不可有子元素的组件,这个值设为null
 变量属于标识性的 用驼峰法命名,否则用下划线方式分割单词命名
方法:
addListener:function(type,func) //给组件添加事件支持
appendTo:function(ele) //把组件添加到另一个组件里
addStyle:function(styles)  //向某个组件的最外层的元素上添加样式

 *组件里德书写规范:
 *1.
 *
 *组件的标识:
 *1.
 */

~function(){
    var D=MY.Dom,
    _$=MY.Dom.get,
    G=_$,
    E=MY.Event,
    C=MY.Dom.createElement,
    mix=MY.Dom.mixin,
    GC=D.getByClass
    addPrototype=function(target,prototypes){
        for(var i in prototypes){
            target.prototype[i]=prototypes[i];
        }
    }
    MY.create("ui",function(){
        var _ui=function(){
            return{
                /**
                 *可用的组件名
                 */
                components:[
                "Spinner",
                "TipPanel",
                "Button",
                "LabelButton",
                "layout.layFloat",
                "Window",
                "Tab"
                ],
                coms:{},
                /**
                 * 获取一个组件
                 * @param {string} component_name 组件名,首字符大写的形式
                 * @param {json} config 组件的配置参数
                 * @return {component} 返回一个组件的实例
                 */
                get:function(component_name,config,instance_name){
                    if(this.coms[instance_name]!=undefined){
                        M.tool.trace("实例已经存在,不要重复定义!","alert") ;
                        return;
                    }
                    if(!M.Array.has(M.ui.components, component_name)){
                        M.tool.trace("组件"+component_name+"初始化失败,可能因为不存在此组件","alert");
                        return;
                    }
                    var coms=component_name.split(".");
                    var com=M.ui;
                    for(var i=0,n=coms.length;i<n;i++){
                        com=com[coms[i]]
                    }
                    var return_com=new com(config);

                    this.coms[instance_name]=return_com;
                    return return_com;
                }
            }
        }()
        return _ui
    });


    MY.create("ui.base",function(){
        var base=function(){
            this.config={};
            this.events={};
            this.data={};
            this.eles={};
            this.isUI=true;
            this.ele=null;
            this.wrap=null;
        }
        base.prototype={
            addListener:function(type,func){
                for(var i in this.EVENT_LIST){
                    if(i==type){
                        this.EVENT_LIST[i].push({func:func})
                        return;
                    }
                }
                MY.tool.trace("不存在此种类型事件","alert")
            },
            appendTo:function(ele){
                if(ele.isUI){
                    ele.wrap.appendChild(this.ele);
                    this.parent=ele;
                }
                else
                    ele.appendChild(this.ele);
            },
            /**
             *动态向某组件的"最外层"添加style样式
             */
            addStyle:function(styles){
                if(typeof(styles)=="string")  D.addClass(this.ele,styles)
                else D.mixinStyle(this.ele,styles)
            },
            init:function(config){
                this._constructor(config);
                this._createHtml();
                this._bindEvent&&this._bindEvent();
            },
            _createHtml:function(){

            }
        };
        return base;
    });
    MY.create("ui.layout.layFloat",function(){
        var layFloat=function(config){
            /**
             * 这是一个浮动布局组件,里面的元素都是浮动的,一般容纳相同类型的元素.将他们浮动,然后设置他们的左右上下间距
             *
             */

            this.init(config)
        }
        layFloat.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    x_space:5,
                    y_space:5
                }
                D.mixin(this.config,config)
            },
            _createHtml:function(){
                this.wrap=this.ele=C("div",{
                    c:"m-layout-float",
                    s:{
                        width:this.config.width+"px"
                    }
                });
            },
            add:function(com){
                if(M.tool.isArray(com)){
                    for(var i=0,n=com.length;i<n;i++){
                        this.add(com[i])
                    }
                    return;
                }
                com.addStyle({
                    marginLeft:this.config.x_space+"px",
                    marginTop:this.config.y_space+"px",
                    display:"inline-block"
                })
                com.appendTo(this)
                return com;
            }
        }
        addPrototype(layFloat,proto);
        return layFloat;

    });
    MY.create("ui.Spinner",function(){
        var spinner=function(config){
            this.init(config);
        }
        spinner.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    step:1,
                    defaultValue:0,
                    max:10,
                    min:-10
                };
                this.eles={
                    input:null,
                    up:null,
                    down:null,
                    choose:null,
                    panel:null
                }
                D.mixin(this.config,config)
                this.data.value=this.config.defaultValue;
            },
            _createHtml:function(){
                var e=this.eles;
                this.ele=C("div",{
                    c:"m-spinner"
                },
                [
                e.input=C("input",{
                    a:{
                        type:"text",
                        value:this.config.defaultValue
                    }
                }),
                e.up=C("a",{
                    c:"up",
                    a:{
                        href:"javascript:void(0);"
                    }
                }),
                e.down=C("a",{
                    c:"down",
                    a:{
                        href:"javascript:void(0);"
                    }
                }),
                e.choose=C("a",{
                    c:"choose",
                    a:{
                        href:"javascript:void(0);"
                    }
                }),
                e.panel=C("a",{
                    c:"panel"
                })
                ]);
            },

            _bindEvent:function(){
                var e=this.eles;
                E.on(e.up,"click",function(e,now){
                    E.stopPropagation(e);
                    var value=now.eles.input.value*1;
                    now.eles.input.value=(value<now.config.max)?(value+now.config.step):value;
                },this)
                E.on(e.down,"click",function(e,now){
                    E.stopPropagation(e);
                    var value=now.eles.input.value*1;
                    now.eles.input.value=(value>now.config.min)?(value-now.config.step):value;
                },this)
            }
        };
        addPrototype(spinner,proto);
        return spinner;
    });
    MY.create("ui.TipPanel",function(){
        var panel=function(config){
            this.init(config);
        }
        panel.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    width:100,
                    height:'auto',
                    position:"relative",
                    x:0,
                    y:0
                }
                this.eles={
                    inner:null
                }
                D.mixin(this.config,config)
            },
            _createHtml:function(){
                var e=this.eles,config=this.config;
                this.ele=C("div",{
                    c:"m-tip-panel",
                    s:{
                        width:config.width+"px",
                        height:config.height=="auto"?config.height:(config.height+"px"),
                        position:config.position
                    }
                },[
                C('div',{
                    c:"inner"
                },e.inner=C("div",{
                    c:"wrap"
                }))
                ])
                this.wrap=e.inner;
            },
            _bindEvent:function(){

            }
        };
        addPrototype(panel,proto);
        return panel;
    });
    MY.create("ui.Button",function(){

        var button=function(config){
            this.init(config);
        }
        button.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    x:0,
                    y:0,
                    text:""
                }
                this.eles={
                    inner:null
                }
                D.mixin(this.config,config);
            },
            _createHtml:function(){
                var _e=this.eles,c=this.config;
                //万能构建方法
                this.ele=C("div",{
                    c:"m-button",
                    s:{
                        position:'absolute'
                    }
                },[
                C("div",{
                    c:"l"
                }),
                _e.inner=C("div",{
                    c:"btn-inner",
                    i:c.text
                }),
                C("div",{
                    c:"r"
                })
                ])
            },
            _bindEvent:function(){

            },
            setValue:function(str){
                this.eles.inner.innerHtml=str;
            },
            disable:function(){
                D.addClass(this.ele,"disable")
            },
            enable:function(){
                D.removeClass(this.ele,"disable")
            }
        }
        addPrototype(button,proto);
        return button;
    });
    MY.create("ui.LabelButton",function(){
        var labelbutton=function(config){
            this.init(config)
        }
        labelbutton.prototype=new MY.ui.Button();
        var proto={
            _constructor:function(config){
                this.config={
                    width:20,
                    height:20,
                    x:0,
                    y:0,
                    innerHTML:"",
                    padding:8
                }
                this.eles={
                    inner:null
                }
                this.data={
                    state:0  //0是正常,1是点击后,-1是不可用
                }
                this.events={
                    clickEvent:new M.CustomEvent("click",this)
                }
                D.mixin(this.config,config)
            },
            _createHtml:function(){
                var e=this.eles,c=this.config;
                this.wrap=e.inner=this.ele=C("a",{
                    a:{
                        href:"javascript:void(0)"
                    },
                    c:"m-label-button",
                    i:c.innerHTML,
                    s:{
                        height:c.height+"px",
                        lineHeight:c.height+"px",
                        padding:"0px "+c.padding+"px"
                    }
                })
            },
            _bindEvent:function(){
                E.on(this.ele,"click",function(e,now){
                    if(now.data.state==-1) return;
                    (now.data.state=!now.data.state)?D.addClass(now.ele,"selected"):D.removeClass(now.ele,["selected","disable"]);
                    now.events.clickEvent.fire()
                },"$_mouse_click",this);
            }
        }
        addPrototype(labelbutton,proto);
        return labelbutton;
    })

    MY.create("ui.Window",function(){
        var window=function(config){
            this.init(config);
        }
        window.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    title_image:"",
                    title_text:"M-UI框架的窗口demo",
                    sizeable:true,
                    isMax:false,   //初始化的时候是否是最大化的
                    isCenter:true,
                    width:600,
                    height:300,
                    hasLayer:true,
                    parent:null,
                    canDrag:false
                }
                this.eles={
                    _control_box:null,
                    hd:null,
                    title_image:null,
                    title_text:null,
                    close:null,
                    min:null,
                    resize:null,
                    layer:null
                }
                D.mixin(this.config,config)
            },
            _createHtml:function(){
                var eles=this.eles,_c=this.config;
                this.ele=C("div",{
                    c:"m-window",
                    p:_c.parent||(document.body||document.documentElement),
                    s:{
                        display:"none",
                        width:_c.width+"px",
                        height:_c.height+"px"
                    }
                },C('div',{
                    c:"wrap"
                },[
                eles.hd=C("div",{
                    c:"hd"
                },[
                C("div",{
                    c:"l"
                }),
                C("div",{
                    c:"m"
                },[
                C("div",{
                    c:"icon"
                },
                eles.title_image=(_c.title_image!="")?C("img",{
                    a:{
                        src:_c.title_image
                    }
                }):undefined),
                eles.title_text=C('div',{
                    c:"title",
                    i:_c.title_text
                }),
                eles._control_box=C("div",{
                    c:"control-box sizeable"
                })
                ]),
                C("div",{
                    c:"r"
                })
                ]),
                C("div",{
                    c:"bd"
                },
                this.wrap=C("div",{
                    c:"m"
                }))
                ])
                )
                if(_c.sizeable===true){
                    var b=eles._control_box
                    eles.min=C("a",{
                        c:"min",
                        p:b
                    });
                    eles.resize=C("a",{
                        c:"max",
                        p:b
                    });
                    _c.isMax&&(eles.resize.className="resize")
                    eles.close=C("a",{
                        c:"close",
                        p:b
                    });
                }else{
                    D.addClass(eles._control_box,"nosize")
                    eles.close=C("a",{
                        c:"close",
                        p:eles._control_box
                    });
                }
                this.addStyle({
                    width:_c.width+"px",
                    height:_c.height+"px"
                })
                if(_c.isCenter){

                    this.addStyle({
                        position:"absolute",
                        left:(D.getDocumentWidth()-_c.width)/2+"px",
                        top:(200+D.getScrollXY().y)+"px"
                    })
                    if(_c.hasLayer===true){
                        D.setCssValue(eles.layer=C("div",{
                            s:{
                                width:D.getDocumentWidth()+"px",
                                height:D.getDocumentHeight()+"px",
                                backgroundColor:"#000",
                                zIndex:"1000",
                                top:"0",
                                left:"0",
                                position:"absolute",
                                display:"none"
                            },
                            p:document.body||document.documentElement
                        }),"opacity",0.7);
                        this.ele.style.zIndex="1001"
                    }
                }

            },
            _bindEvent:function(){
                var _e=this.eles
                E.on(this.eles.close,"click",function(e,now){
                    E.stopEvent(e);
                    now.hide();
                },this)
                E.on(_e.close,"mousedown",function(e){
                    E.stopEvent(e)
                })
                E.on(_e.layer,"click",function(e,now){
                    now.hide()
                },this)
            },
            show:function(){
                if(this.config.canDrag){
                    new M.DD({
                        drag_handle:this.eles.hd,//拖动句柄,例如窗口的标题栏
                        mover:this.ele//被拖动移动的元素,例如窗口本身
                    })
                }
                this.eles.layer&&(this.eles.layer.style.display="block")
                this.ele.style.display="block"
                if(this.eles.layer){
                    var anim=new M.Anim(this.eles.layer,{
                        opacity:{
                            from:0,
                            to:0.6
                        }
                    },320)
                    anim.animate();
                }
                var anim1=new M.Anim(this.ele,{
                    opacity:{
                        from:0,
                        to:1
                    }
                },320)
                anim1.animate();
            },
            hide:function(){
                if(this.eles.layer){
                    var anim=new M.Anim(this.eles.layer,{
                        opacity:{
                            to:0
                        }
                    },120)
                    anim.animate();
                }
                var anim1=new M.Anim(this.ele,{
                    opacity:{
                        to:0
                    }
                },120)
                anim1.addListener("finish",function(now){
                    now=now.event_param
                    now.eles.layer&&(now.eles.layer.style.display="none")
                    now.ele.style.display="none"
                },this)
                anim1.animate();
            }
        }
        addPrototype(window,proto);
        return window;
    })
    MY.create("ui.Panel",function(){
        var panel=function(config){
            this.init(config);
        }
        panel.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    width:300,
                    height:100
                }
                D.mixin(this.config,config);
            },
            _createHtml:function(){
                this.ele=this.wrap=C("div",{
                    c:"m-panel"
                })
            }
        }
        addPrototype(panel,proto)
        return panel
    })
    MY.create("ui.Tab",function(){
        var tab=function(config){
            this.init(config);
        }
        tab.idAssign="id_100";//起始的id,自动分配id的时候用
        tab.prototype=new MY.ui.base();
        var proto={
            _constructor:function(config){
                this.config={
                    width:500,
                    height:200
                }
                this.eles={
                    hd:null
                }
                this.tabs=[],
                this.events={
                    change:new MY.CustomEvent("change",this)
                }
                D.mixin(this.config,config);
            },
            _createHtml:function(){
                this.ele=this.wrap=C("div",{
                    c:"m-tab"
                })
                this.ele.innerHTML=
                "<div class=\"hd\">"+
                "                <ul class=\"hd-con\">"+
                "                    "+
                "                </ul>"+
                "                <div class=\"float-clear\"></div>"+
                "            </div>"+
                "            <div class=\"bd\">"+
                "                <ul class=\"bd-con\">"+
                "                    "+
                "                </ul>"+
                "            </div>"
                mix(this.eles,{
                    hd:GC("hd-con", "ul", this.ele)[0],
                    bd:GC("bd-con","ul",this.ele)[0]
                })
                D.mixinStyle(this.ele,{
                    width:this.config.width+"px",
                    height:this.config.height+"px"
                })
            },
            addTab:function(detail){
                var detail_c={
                    title:"",
                    id:0,
                    icon:null,
                    html:"",
                    element:null,
                    selected:false,
                    enable:true
                },
                is_now_str,
                tab_hd_now,
                tab_bd_now,
                now=this
                mix(detail_c,detail)
                is_now_str=detail_c.selected?"now":""

                tab_hd_now=C("li",{
                    c:"tab-hd "+is_now_str+" tab_"+detail_c.id,
                    p:this.eles.hd
                    },[
                C("div",{
                    c:"l"
                }),
                C("a",{
                    c:"m"
                },[
                C("div",{
                    c:"icon"
                },(detail_c.icon?[C("img",{
                    a:{
                        src:detail_c.icon
                        }
                    })]:undefined)),
                C("span",{
                    c:"title",
                    i:detail_c.title
                    })
                ]),
                C("div",{
                    c:"r"
                })
                ])
            if(detail_c.element==null){
                tab_bd_now=C("li",{
                    c:"tab-bd "+is_now_str+" tab_"+detail_c.id,
                    p:this.eles.bd,
                    i:detail_c.html
                })

            }else{
                tab_bd_now= C("li",{
                    c:"tab-bd "+is_now_str+" tab_"+detail_c.id,
                    p:this.eles.bd
                },[
                detail_c.element
                ])
            }

            E.on(tab_hd_now,"click",function(){
                now.events.change.fire(detail_c.id)
                now.tabs.each(function(arr){
                    D.removeClass(arr[0],"now");
                    D.removeClass(arr[1],"now")
                })
                D.addClass(this,"now");
                D.addClass(tab_bd_now,"now");
            })
            this.tabs.push([
                tab_hd_now,
                tab_bd_now
            ])
        },
        deleteTab:function(tabId){

        },
        _bindEvent:function(){


        }
    }
    addPrototype(tab,proto)
        return tab
    })
}()