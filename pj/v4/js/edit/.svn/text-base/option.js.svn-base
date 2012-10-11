define(function(require, exports, module) {
    var p=require("util/point.js")
    var now;
    var option=function(){
        return {
            callback:{
                
            },
            title:"选项",
            context:null,
            prototypeGrid:$("#option-table").propertygrid({
                width:300,
                height:'300',
                columns:[[  
                {
                    field:'name',
                    title:'选项名',
                    width:'130'
                },  

                {
                    field:'value',
                    title:'选项值',
                    width:'130'
                }
                ]] ,
                showGroup:true,
                scrollbarSize:0,
                onAfterEdit:function(index,data){
                    console.log(data)
                    now.callback[data.name].obj[now.callback[data.name].key]=data.value;
                    now.context.rePaint();
                }
            }),
            init:function(context){
                now=this;
                this.context=context;
            },
            bind:function(options){
                this.callback={}
              
                this.clear();
                for(var i =0;i<options.length;i++){
                    $('#option-table').propertygrid("insertRow",{
                        index:i,
                        row:
                        {
                            "name":options[i][0],
                            "value":options[i][1],
                            "editor":options[i][2]
                        }
                    });
                    
                    this.callback[options[i][0]]={
                        obj:options[i][3],
                        key:options[i][4]
                    }
                    
                };
                
                
               
            },
            clear:function(){
                var rows = $('#option-table').datagrid("getRows");	//获取你选择的所有行
                //循环所选的行
                for(var i =0,l=rows.length;i<l;i++){
                    var index = $('#option-table').datagrid('getRowIndex',rows[i]);//获取某行的行号
                    $('#option-table').datagrid('deleteRow',index);	//通过行号移除该行
                }
            }
        }
    }();
    return option;
});

