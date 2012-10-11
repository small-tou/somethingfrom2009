var ACTJS={}
ACTJS={
    act:function(el,type){
        if (document.createEvent)
        {
            var evObj = document.createEvent('MouseEvents')
            evObj.initEvent( 'click', true, false )
            el.dispatchEvent(evObj)
        }
        else if (document.createEventObject)
        {
            el.fireEvent('onclick')
        }
    }
}

