/*
 * @Time:2011-11-24
 * @Encode:UTF-8
 * @Filename:util.js
 * @Author:tianqi.sxy
 */
define(function(require, exports, module) {
    var util=function(){

        return {
            extend:function(source){
                var r=function(){

                }
                for(var i in source.prototype){
                    r.prototype[i]=source.prototype[i]
                }
                return r;
            },
            ap:function(target,prototypes){
                for(var i in prototypes){
                    target.prototype[i]=prototypes[i];
                }
                return target;
            },
            mix:function(target,prototypes){
                for(var i in prototypes){
                    target[i]=prototypes[i];
                }
            },
            debug:function(canvas){
                var w=window.open("","","width=1100,height=610");
                var d=w.document
                d.open();
                d.write("<img src='"+$(canvas)[0].toDataURL()+"' />");
                d.close();
            }
        }

    }();
    return util;
});


