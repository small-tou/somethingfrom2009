/**
 *
 *
 * 任何anim变化都包括这些必要的属性
 * +有一个数值在驱动整个过程,数值不断变化
 * +数值从一个初始值变化到另一个结束值,两个值可以相等
 * +数值变化可以设置缓动效果
 * 
 */

MJ.add("Anim",function(){
    var _t=MJ.tool,_m=MJ.Dom,_e=MJ.Event;

    var anim=function(){
        
    }
    anim.prototype={
        _init:function(){
            //data是整个anim对象的核心,所有变化只发生在它一个变量之上{
            this.data=0;
            //变化配置信息
            this.config={};
            //持续的时间
            this.time=0;
        },
        on:function(type,func,param){
            for(var i in this.EVENT_LIST){
                if(i==type){
                    this.EVENT_LIST[i].push({
                        func:func,
                        param:param
                    })
                    return;
                }
            }
            T.trace("不存在此种类型事件","alert")
        },
        animate:function(config){
            
        },
        /**
         * 初始化初始值,因为可能没有提供初始值,这时候需要按照常规生成初始值
         * 例如:对于ui来说,要根据当前元素当前的属性信息作初始值
         * 对于数值变化,从0开始
         * 对于颜色变化从白色开始
         */
        _initFrom:function(){
            
        }

    }
    return anim;
});
