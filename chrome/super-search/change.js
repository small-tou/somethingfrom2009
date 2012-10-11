/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//document.body.innerHTML+="<style>*{font-family:'΢���ź�' !important;}</style>";
// Copyright (c) 2010 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
var searchSites=[
{
    name:"百度",
    url:"http://www.baidu.com/s?wd=$!keyword&bs=$!keyword&ie=utf-8"
},
{
    name:"google",
    "url":"http://www.google.com.hk/search?hl=zh-CN&q=$!keyword"
},
{
    name:"淘宝网",
    "url":"http://s.taobao.com/search?q=$!keyword&commend=all&ssid=s5-e&search_type=item&ie=utf-8"
},
{
    name:"淘宝商城",
    "url":"http://list.tmall.com/search_product.htm?&q=$!keyword&_input_charset=utf-8"
},
{
    name:"搜狗",
    "url":"http://www.sogou.com/sogou?query=$!keyword"
},
{
    name:"bing",
    "url":"http://www.bing.com/search?q=$!keyword"
},
{
    name:"搜搜",
    "url":"http://www.soso.com/q?sc=web&bs=a&ch=w.uf&num=10&w=$!keyword",
    isGB:true
},
{
    name:"有道",
    "url":"http://www.youdao.com/search?q=$!keyword"
},
{
    name:"迅雷狗狗",
    "url":"http://www.gougou.com/search?search=$!keyword"
}
]
var ruanjianSites=[
{
    name:"华军软件",
    url:"http://search.newhua.com/search_list.php?searchname=$!keyword"
},
{
    name:"太平洋软件",
    url:"http://ks.pconline.com.cn/download.jsp?forumName=%C8%AB%B2%BF%C0%E0%D0%CD&qx=%C8%AB%B2%BF%C0%E0%D0%CD&forumValue=&forumOrgID=&forumOrgName=&q=$!keyword",
    isGB:true
},
{
    name:"新浪软件",
    url:"http://down.tech.sina.com.cn/download/search.php?f_name=$!keyword&x=30&y=10",
    isGB:true
},
{
    name:"狗狗软件",
    url:"http://soft.gougou.com/search?search=$!keyword&restype=2&id=1"
}
]
var zhishiSites=[
{
    name:"百度知道",
    "url":"http://zhidao.baidu.com/q?word=$!keyword&ct=17&pn=0&tn=ikaslist&rn=10&lm=0&fr=search"
},
{
    name:"新浪知识人",
    url:"http://iask.sina.com.cn/search_engine/search_knowledge_engine.php?key=$!keyword&classid=0&title=$!keyword&x=0&y=0&tag=0&gjss=0",
    isGB:true
},
{
    name:"问问",
    url:"http://wenwen.soso.com/z/Search.e?sp=S$!keyword&ch=w.search.sb&w=$!keyword&search=%E6%90%9C%E7%B4%A2%E7%AD%94%E6%A1%88"
},
{
    name:"百度百科",
    url:"http://baike.baidu.com/searchword/$!keyword",
    isGB:true
}
]

var help=function(){
    alert("hello!i am tianqi ,i can't help you!because it's so simple!")
}
var blog=function(){
    chrome.tabs.create({
        url:"http://www.html-js.com"
    })
}
var click=function(info,tab){
    var id=info.menuItemId-1
    var text=encodeURI(info.selectionText)
    if(searchSites[id].isGB==true){
        text=encodeToGb2312(info.selectionText)
    }
    chrome.tabs.create({
        url:searchSites[id].url.replace(/\$\!keyword/g,text)
    })
}
var click_ruanjian=function(info,tab){
    var id=info.menuItemId-1
    id=id-searchSites.length-1
     var text=encodeURI(info.selectionText)
    if(ruanjianSites[id].isGB==true){
        text=encodeToGb2312(info.selectionText)
    }
    chrome.tabs.create({
        url:ruanjianSites[id].url.replace("$!keyword",text)
    })
}
var click_zhishi=function(info,tab){
    var id=info.menuItemId-1
    id=id-searchSites.length-ruanjianSites.length-2
      var text=encodeURI(info.selectionText)
    if(zhishiSites[id].isGB==true){
        text=encodeToGb2312(info.selectionText)
    }
    chrome.tabs.create({
        url:zhishiSites[id].url.replace("$!keyword",text)
    })
}
for(var i in searchSites){
    chrome.contextMenus.create({
        "title": searchSites[i].name,
        "contexts":["selection"],
        "onclick":click
    });
}
var ruanjian=chrome.contextMenus.create({
    "title": "软件搜索",
    "contexts":["selection"]
});
for(var i in ruanjianSites){
    chrome.contextMenus.create({
        "title": ruanjianSites[i].name,
        "contexts":["selection"],
        "parentId":ruanjian,
        "onclick":click_ruanjian
    });
}
var zhishi=chrome.contextMenus.create({
    "title": "知识搜索",
    "contexts":["selection"]
});
for(var i in zhishiSites){
    chrome.contextMenus.create({
        "title": zhishiSites[i].name,
        "contexts":["selection"],
        "parentId":zhishi,
        "onclick":click_zhishi
    });
}
var help = chrome.contextMenus.create({
    "title": "帮助",
    "contexts":["selection"],
    "onclick":help
});
var blog=chrome.contextMenus.create({
    "title": "taobaoUED@天祁的博客",
    "contexts":["selection"],
    "onclick":blog
});