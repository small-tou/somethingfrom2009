<div id="aa">fdsf</div>
<script>
    document.getElementById("aa").attachEvent("onclick", function(){
        alert(this.id)
    });
</script>
<style>
    #aa{
        
}
/*<editor-fold defaultstate="collapsed" desc="测试代码折叠">   */
    #detail {
        color: #404040;
        background: #fff;
    }
    #detail .tb-detail-hd {
        position: relative;
        z-index: 2;
        margin-bottom: 10px;
    }
    #detail .tb-detail-hd h3 {
        width: 530px;
        overflow: hidden;
        line-height: 22px;
        text-align: left;
        text-indent: 5px;
        white-space: nowrap;
        font-size: 14px;
        color: #000;
    }
    #detail .tb-detail-hd p {
        position: absolute;
        right: 0;
        top: 0;
    }
/*</editor-fold>*/
</style>