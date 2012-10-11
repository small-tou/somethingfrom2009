<style>
    .jiang-result{
        height:830px;
        margin-top:30px;
    }
    .jiang-result .hd{
        height:85px;
        background:url(http://img04.taobaocdn.com/tps/i4/T12lJ9Xb0dXXXXXXXX-550-414.png) no-repeat;
        width:270px;
    }
    .jiang-result .bd{
        background: #782118;
        height:710px;
        margin-left:50px;
        width:920px;
    }
    .jiang-result .item{
        float:left;
        margin-left:10px;
        margin-top:10px;
        display:inline;
    }
    .group-1 .hd{
        background-position:0px -10px;
    }
    .group-2 .hd{
        background-position:0px -112px
    }
    .group-3 .hd{
        background-position:0px -220px;
    }
    .group-4 .hd{
        background-position:0px -322px;
    }
    .group-5 .hd{
        background-position:-270px -10px;
    }
    .group-6 .hd{
        background-position:-270px -110px;
    }
    .group-7 .hd{
        background-position:-270px -200px;
    }
    .group-8 .hd{
        background-position:-270px -300px;
    }
    .jiang-result .title{
        font-size:14px;
        font-family:微软雅黑;
        color:#fff;
        width:120px;
        overflow:hidden;
        height:20px;
    }
    .jiang-result .price{
        font-size:14px;
        font-family:微软雅黑;
        color:#fff;
        width:120px;
        overflow:hidden;
        height:20px;
    }
    .jiang-result a{
        color:#fff;
    }
    .post-info{

        background: #F0BA2B;
        background-position:20px 30px;
        height:100px;
    }
    .jiang-title{
        margin-top:30px;
    }
</style>
<div class="post-info"><img src="http://img01.taobaocdn.com/tps/i1/T1Gl89XiNbXXXXXXXX-990-100.png"/></div>
<div class="jiang-title"><img src="http://img03.taobaocdn.com/tps/i3/T16Rp9XeJhXXXXXXXX-483-62.png"/></div>
<div class="jiang-result group-1">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第1组" group="第1组" row="28" defaultRow="28" >
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-2">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第2组" group="第2组" row="28" defaultRow="28" >
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-3">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第3组" group="第3组" row="28" defaultRow="28" >
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-4">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第4组" group="第4组" row="28" defaultRow="28">
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-5">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第5组" group="第5组" row="28" defaultRow="28" >
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-6">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第6组" group="第6组" row="28" defaultRow="28">
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-7">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第7组" group="第7组" row="28" defaultRow="28">
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>
<div class="jiang-result group-8">
    <div class="hd"></div>
    <div class="bd">
        <ul>
            <cms:custom fields="img:图片地址:string,href:链接地址:string,title:标题名:string,price:价格:string" title="第8组" group="第8组" row="28" defaultRow="28">
                #foreach($item in $customList)
                <li class="item">
                    <div class="pic"><a href="$!item.href" target="_blank"><img src="$!item.img" width="120" height="120" alt="$!item.title"/></a></div>
                    <div class="title"><a href="$!item.href" target="_blank">$!item.title</a></div>
                    <div class="price"><a href="$!item.href" target="_blank">$!item.price</a></div>
                </li>
                #end
            </cms:custom>
        </ul>
    </div>
</div>