/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
window.Test=window.Test||{}
Test={
    ele:null,
    mix:function(target,prototypes){
        for(var i in prototypes){
            target[i]=prototypes[i];
        }
    },
    log:function(info,line){
        if(this.ele===null){
            this.ele=document.createElement('div');
            this.mix(this.ele.style,{
                border:"1px solid #aaa"
            });
            document.body.appendChild(this.ele)
        }
        console.log(info)
        line&&(info+="<br/>");
        this.ele.innerHTML+=info;
        
    },
    ln:function(info){
        this.log(info,true)
    }
}
