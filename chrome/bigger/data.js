var DATA={
    "huajun":{
        reg:/http\:\/\/.*?\.onlinedown\.net\/soft\/[0-9]*?\.htm/,
        selector:".down-menu",
        info:"华军软件园^^http://www.onlinedown.net/"
    },
     "huajun2":{
        reg:/http\:\/\/.*?\.newhua\.com\/soft\/[0-9]*?\.htm/,
        selector:".down-menu"
    },
     "huajun3":{
        reg:/http\:\/\/.*?\.newhua\.com\/softdown\/[0-9]*?\.htm/,
        selector:"#add_info"
    },
    "tiankong":{
        reg:/http\:\/\/.*?\.skycn\.com\/soft\/[0-9]*?\.html/,
        selector:"#downUrl .col1",
        info:"天空软件站^^http://www.skycn.com/"
    },
    "duote":{
        reg:/http\:\/\/.*?\.duote\.com\/soft\/[0-9]*?\.html/,
        selector:".dodo3b",
        info:"多特软件站^^http://www.duote.com/"
    },
    "it168":{
        reg:/download\.it168\.com\/[0-9]*?\/[0-9]*?\/[0-9]*?\/index\.shtml/,
        selector:".right_four_left",
        info:"IT168 下载^^http://download.it168.com/"
    },
    "taipingyang":{
        reg:/dl\.pconline\.com.*?\/download\/[0-9]*?\.html/,
        selector:"#linkPage",
        info:"太平洋下载^^http://dl.pconline.com.cn/"
    },
   "taipingyang2":{
        reg:/dl\.pconline\.com.*?\/download\/[0-9]*?\-[0-9]*?\.html/,
        selector:".dlLinks"
    },
    "taipingyang3":{
        reg:/dl\.pconline\.com.*?\/html\_2\/.*?\.html/,
              selector:"#linkPage"
    },
   // "taipingyang2":{
  //      reg:/dl\.pconline\.com\.cn\/download/,
 //       selector:".tbL .dlLinks"
 //   },
    "xinlang":{
        reg:/down\.tech\.sina\.com\.cn\/content\/[0-9]*?\.html/,
        selector:".b_rjjs .pd a",
        info:"新浪下载^^http://tech.sina.com.cn/down/"
    },
    "xinlang":{
        reg:/down\.tech\.sina\.com\.cn\/page\/[0-9]*?\.html/,
        selector:".b_cmon table",
        info:"新浪下载^^http://tech.sina.com.cn/down/"
    },
    "pchome":{
        reg:/download\.pchome\.net\/.*?\/.*?\/[0-9]*?\.html/,
        selector:"#downloadBtn0x",
       info:"PChome下载^^http://download.pchome.net/"
    },
    "pchome2":{
        reg:/download\.pchome\.net\/.*?\/download\-[0-9]*?\.html/,
        selector:"#downloadAddress"
    },
    "pchome3":{
        reg:/download\.pchome\.net\/.*?\/.*?\/.*?detail\-[0-9\-]*?\.html/,
        selector:"#downloadBtn0x"
    },
    "feifan":{
        reg:/.*?\.crsky\.com\/soft\/[0-9]*?\.html/,
        selector:".mirrordock",
        info:"非凡软件^^http://www.crsky.com/"
    },
    "lvselianmeng":{
        reg:/.*?\.xdowns\.com\/soft\/.*?\/Soft.*?\.html/,
        selector:".co_content7",
        info:"绿色联盟^^http://www.xdowns.com/"
    },
    "lvselianmeng2":{
        reg:/.*?\.xdowns\.com\/soft\/softdown\.asp.*/,
        selector:".dol_con ul table"
    }
};