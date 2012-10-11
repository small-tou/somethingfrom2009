(function () {
    var a = {
        hostName: "www.zhimei.com",
        domain: "http://www.zhimei.com",
        locationHost: encodeURIComponent(window.location),
        isIE: navigator.userAgent.indexOf("MSIE") > 0,
        isIE6: navigator.userAgent.indexOf("MSIE 6") > 0,
        isIE7: navigator.userAgent.indexOf("MSIE 7") > 0,
        isIE8: navigator.userAgent.indexOf("MSIE 8") > 0,
        isIE9: navigator.userAgent.indexOf("MSIE 9") > 0,
        isFireFox: navigator.userAgent.indexOf("Firefox") > 0,
        isSafari: (navigator.userAgent.indexOf("Safari") > 0 && navigator.userAgent.indexOf("Chrome")) < 0,
        isChrome: (navigator.userAgent.indexOf("Safari") > 0 && navigator.userAgent.indexOf("Chrome")) > 0,
        isOpera: navigator.userAgent.indexOf("Opera") > -1,
        isSaAndChr: navigator.userAgent.indexOf("Safari") > 0,
        isMaxthon: navigator.userAgent.toLowerCase().indexOf("maxthon") > 0,
        isSogou: navigator.userAgent.toLowerCase().indexOf("mozilla") > -1 && navigator.userAgent.toLowerCase().indexOf("metasr") > -1,
        isOther: navigator.userAgent.toLowerCase().indexOf("mozilla") > -1 && navigator.userAgent.indexOf("MSIE") > 0,
        picWidth: 200,
        picHeight: 200,
        selected: [],
        init: function () {
            if (document.getElementById("imPingMaskDiv")) {
                return
            } else {
                var c = window.location.hostname;
                if (c.indexOf(a.hostName) > -1) {
                    im.window.alert("不可以在本站采图片哦！", "error");
                    return
                }
                var d = a.getImages();
                if (d.length == 0) {
                    alert("对不起，该页面没有找到合适的图片！");
                    return
                }
                a.addStyle();
                a.maskLayout();
                a.addLayout()
            }
        },
        maskLayout: function () {
            var d = document.createElement("div");
            var e = document.body.clientHeight;
            var c = document.body.clientWidth;
            a.isIE ? d.id = "imPingMaskDiv" : d.setAttribute("id", "imPingMaskDiv");
            d.style.height = e + "px";
            d.style.width = c + "px";
            document.body.appendChild(d);
            a.updateDiv()
        },
        addStyle: function () {
            var f, c;
            if (a.isIE6 || a.isIE7) {
                f = ".imSubmitInputOff{cursor:pointer;border:0;padding:0;background-image: url(http://a.imimg.cn/r13090/images/pin/addcc_ok0.gif);background-repeat:no-repeat ;visibility:visible;width:340px;height:52px;line-height:52px;margin:0 auto;vertical-align:bottom;}";
                c = ".imSubmitInput{cursor:pointer;border:0;padding:0;margin:0;background-image: url(http://a.imimg.cn/r13090/images/pin/addcc_ok1.gif) ; background-repeat:no-repeat;visibility:visible;height: 52px;line-height:52px;margin: 0 auto;vertical-align: text-bottom;width: 340px;}"
            } else {
                f = ".imSubmitInputOff{cursor:pointer;border:0;padding:0;background:url(http://a.imimg.cn/r13090/images/pin/addcc_ok0.gif) no-repeat;visibility:visible;width:340px;height:52px;line-height:52px;margin:0 auto;vertical-align:bottom;}";
                c = ".imSubmitInput{cursor:pointer;border:0;padding:0;background: url(http://a.imimg.cn/r13090/images/pin/addcc_ok1.gif) no-repeat ; visibility:visible;height: 52px;line-height:52px;margin: 0 auto;vertical-align: text-bottom;width: 340px;}"
            }
            var d = ["\n#imPingMaskDiv{position:absolute;left:0;top:0;opacity:.8;filter:alpha(opacity=80);z-index:1000000;background:#ffffff;}", "\n.defaultimg {background:#eee;width:192px;height:132px;padding-top:60px;display:block;}", "\n.pincontainer {position:absolute;top:0;left:0;z-index:1000002;width:100%;padding-top:80px;}", '\n.closewin {float:right;margin-right:10px;width:54px;height:54px;background: url("http://a.imimg.cn/r13090/images/pin/pin.png") no-repeat 0 -775px;}', "\n.closewin:hover {background-position:-60px -775px;}", "\n.closewin:active {background-position:-120px -775px;}", "\n.divaddcc {left:0;padding-top:10px;height:70px; text-align:center;position:fixed;background:url(http://a.imimg.cn/r13090/images/pin/pintopbar.gif) repeat-x;width:100%;top:0;z-index:5;}", '\n.divaddcc {_position:absolute;_left:0px;_top:expression(eval(document.documentElement.scrollTop)+"px");}}', "\n.divaddcc .defaultimg {background:#ddd;width:192px;height:192px;display:block;}", "\n.divaddcc .checkimg,.divaddcc .checkedimg {cursor:pointer;vertical-align:bottom;display:inline-block;background:url(http://a.imimg.cn/r13090/images/pin/pinCheck.gif) no-repeat 10px 1px;padding-left:27px; height:15px; font-size:12px}", "\n.divaddcc .checkedimg {background-position:10px -30px;}", "\n.btadd,.btaddhover,.btadddisabled {background: url(http://a.imimg.cn/r13090/images/pin/addcc_03.gif) no-repeat;display:inline-block;width:340px;height:52px;margin:0 auto;vertical-align:bottom;}", "\n.btaddhover {background-position:0 -67px;}", "\n.btadddisabled {background-position:0 -132px;cursor:default;}", "\n a{cursor:pointer;}", "\n#imPingForm{text-align:center;height:60px;}", "\n.getimglist {border-top: 1px solid #e7e7e7;border-left: 1px solid #e7e7e7;float:left;}", '\n.getimglist a {display: block;position: absolute;background:url("http://a.imimg.cn/r13090/images/pin/pin.png") no-repeat 200px 0;width:192px;height: 192px;line-height:192px;left:4px;top:4px;_top:5px;z-index:2;}', "\n.getimglist a.selected {background-position:0 -193px;}", "\n.getimglist a.selected:hover {background-position:0 0;}", "\n.getimglist a.notselected:hover {background-position:0 -386px;}", "\n.getimglist a.btover {background-position:0 -579px;}", "\n.getimglist a span {position:absolute;top:80px;left:32px;width:132px;height:32px;display:block;cursor:pointer;}", "\n.getimglist div {border-right:1px solid #e7e7e7;border-bottom:1px solid #e7e7e7;padding:4px;float:left;position:relative;background:#fff;height:192px;width:192px;text-align:center;overflow:hidden;}", "\n.getimglist img {vertical-align:middle;}", '\n.getimglist em {font-style:normal;font-size:10px;font-family:Arial;position:absolute;bottom:10px;left:56px;text-align:center;width:85px;height:21px;z-index:1000;background:url("http://a.imimg.cn/r13090/images/pin/pin_220x250.png") no-repeat;line-height:21px;z-index:1;}', c, f].join("");
            var e = document.createElement("style");
            e.type = "text/css";
            a.isIE ? (function () {
                e.media = "screen";
                e.styleSheet.cssText = d;
                document.getElementsByTagName("head")[0].appendChild(e)
            })() : (function () {
                e.innerHTML = d;
                document.body.appendChild(e)
            })()
        },
        getImages: function () {
            var k = document.images;
            var g = [];
            g = i(k);
            var d = document.getElementsByTagName("iframe");
            var h = [];
            try {
                for (var c = 0; c < d.length; c++) {
                    try {
                        h.push(d[c].contentWindow.document.images)
                    } catch (j) {}
                }
                for (var f = 0; f < h.length; f++) {
                    g = g.concat(i(h[f]))
                }
            } catch (j) {}
            function i(l) {
                var o = l;
                var n = [];
                for (var m = 0, e = o.length; m < e; m++) {
                    if (parseInt(o[m].width) > 200 && parseInt(o[m].height) > 200) {
                        n.push(o[m])
                    }
                }
                return n
            }
            return g
        },
        addImages: function () {
            var l = a.getImages();
            var d = "";
            var j = [];
            for (var e = 0, c = l.length; e < c; e++) {
                var k = [];
                k[0] = l[e].width * l[e].height;
                k[1] = l[e];
                j.push(k)
            }
            j.sort(function (h, i) {
                return h[0] - i[0]
            });
            var l = j;
            for (var c = l.length; c--;) {
                if (parseInt(l[c][1].width) > parseInt(l[c][1].height)) {
                    var f = Math.floor(l[c][1].height / (l[c][1].width / 192));
                    var g = Math.floor((200 - f) / 2);
                    d += ("<div class='imImg'><img width='192' style='margin-top:" + g + "px' src='" + l[c][1].src + "'/><a class='notselected' href='javascript:void(0);'><span></span></a><em>" + l[c][1].width + "x" + l[c][1].height + "</em></div>")
                } else {
                    d += ("<div class='imImg'><img height='192' src='" + l[c][1].src + "'/><a class='notselected' href='javascript:void(0);'><span></span></a><em>" + l[c][1].width + "x" + l[c][1].height + "</em></div>")
                }
            }
            return d
        },
        getObj: function (d) {
            if (a.isIE) {
                var f = [];
                for (var g = 0, e = d.length; g < e; g++) {
                    if (d[g] != document.getElementById("imLogo")) {
                        f.push(d[g])
                    }
                }
                objDiv = f
            } else {
                var f = [];
                for (var c = 0, e = d.length; c < e; c++) {
                    if (d[c].nodeType == 1 && d[c] != document.getElementById("imLogo")) {
                        f.push(d[c])
                    }
                }
                objDiv = f
            }
            return objDiv
        },
        addLayout: function () {
            var m = document.createElement("DIV");
            a.isIE ? (function () {
                m.id = "imMain";
                m.className = "pincontainer"
            })() : (function () {
                m.setAttribute("id", "imMain");
                m.setAttribute("class", "pincontainer")
            })();
            document.body.appendChild(m);
            var e = document.createElement("div");
            a.isIE ? (function () {
                e.id = "imTitle";
                e.className = "divaddcc"
            })() : (function () {
                e.setAttribute("id", "imTitle");
                e.setAttribute("class", "divaddcc")
            })();
            m.appendChild(e);
            var f = '<a id="imClosePing" class="closewin" href="javascript:void(0);"></a>';
            e.innerHTML = f;
            var g = document.createElement("div");
            a.isIE ? (function () {
                g.className = "getimglist";
                g.id = "imContent"
            })() : (function () {
                g.setAttribute("id", "imContent");
                g.setAttribute("class", "getimglist")
            })();
            m.appendChild(g);
            g.innerHTML = a.addImages();
            var n = document.createElement("div");
            n.setAttribute("id", "imLogo");
            g.insertBefore(n, g.firstChild);
            n.innerHTML = '<span class="defaultimg"><img src="http://a.imimg.cn/r13090/images/pin/logo_pin.gif" /></span>';
            document.documentElement.scrollTop = 0;
            document.body.scrollTop = 0;
            var d = document.getElementById("imContent").childNodes;
            var o = a.getObj(d);
            for (var j = 0, k = o.length; j < k; j++) {
                o[j].getElementsByTagName("a")[0].onclick = function () {
                    l(this);
                    return false
                }
            }
            document.getElementById("imClosePing").onclick = function () {
                h()
            };
            var c = new b();

            function l(q) {
                q.className = "selected";
                q.parentNode.setAttribute("selected", "true");
                var i = encodeURIComponent(c.encode(q.parentNode.getElementsByTagName("img")[0].src));
                var p = a.domain + "/pin/board/batch?imgUrl=" + i + "&pageUrl=" + a.locationHost + "&cookie='" + a.getCookie() + "'";
                window.open(p, "imPingTool", "width=790,height=490,scrollbars=yes");
                h()
            }
            function h() {
                document.body.removeChild(document.getElementById("imPingMaskDiv"));
                document.body.removeChild(document.getElementById("imMain"))
            }
        },
        closePinWin: function () {
            document.body.removeChild(document.getElementById("imPingMaskDiv"));
            document.body.removeChild(document.getElementById("imMain"));
            document.getElementById("imPingForm").onsubmit()
        },
        updateDiv: function () {
            var g = document.getElementsByTagName("body")[0].children;
            var f = 0;
            for (var e = 0, c = g.length; e < c; e++) {
                if (g[e].nodeName == "DIV" && g[e].style.display != "none" && g[e].getAttribute("id") != "imPingMaskDiv" && g[e].getAttribute("id") != "imMain") {
                    f += g[e].offsetHeight
                }
            }
            var j = Math.max(document.documentElement.clientHeight, document.body.clientHeight);
            var d = Math.max(f, j);
            document.getElementById("imPingMaskDiv") ? document.getElementById("imPingMaskDiv").style.height = d + "px" : (function () {
                return
            })()
        },
        getCookie: function () {
            return document.cookie;

            function c(h) {
                var g = documents.cookie.indexOf(";", h);
                if (g == -1) {
                    g = documents.cookie.length
                }
                return unescape(documents.cookie.substring(h, g))
            }
            function f(h, n) {
                var i = new Date();
                var m = f.arguments;
                var k = f.arguments.length;
                var j = (k > 2) ? m[2] : null;
                var o = (k > 3) ? m[3] : null;
                var l = (k > 4) ? m[4] : null;
                var g = (k > 5) ? m[5] : false;
                if (j != null) {
                    i.setTime(i.getTime() + (j * 1000))
                }
                documents.cookie = h + "=" + escape(n) + ((j == null) ? "" : ("; expires=" + i.toGMTString())) + ((o == null) ? "" : ("; path=" + o)) + ((l == null) ? "" : ("; domain=" + l)) + ((g == true) ? "; secure" : "")
            }
            function e(g) {
                var i = new Date();
                i.setTime(i.getTime() - 1);
                var h = d(g);
                documents.cookie = g + "=" + h + "; expires=" + i.toGMTString()
            }
            function d(l) {
                var h = l + "=";
                var n = h.length;
                var g = documents.cookie.length;
                var m = 0;
                while (m < g) {
                    var k = m + n;
                    if (documents.cookie.substring(m, k) == h) {
                        return c(k)
                    }
                    m = documents.cookie.indexOf(" ", m) + 1;
                    if (m == 0) {
                        break
                    }
                }
                return null
            }
        }
    };

    function b() {
        _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        this.encode = function (e) {
            var c = "";
            var m, k, h, l, j, g, f;
            var d = 0;
            e = _utf8_encode(e);
            while (d < e.length) {
                m = e.charCodeAt(d++);
                k = e.charCodeAt(d++);
                h = e.charCodeAt(d++);
                l = m >> 2;
                j = ((m & 3) << 4) | (k >> 4);
                g = ((k & 15) << 2) | (h >> 6);
                f = h & 63;
                if (isNaN(k)) {
                    g = f = 64
                } else {
                    if (isNaN(h)) {
                        f = 64
                    }
                }
                c = c + _keyStr.charAt(l) + _keyStr.charAt(j) + _keyStr.charAt(g) + _keyStr.charAt(f)
            }
            return c
        };
        _utf8_encode = function (e) {
            e = e.replace(/\r\n/g, "\n");
            var d = "";
            for (var g = 0; g < e.length; g++) {
                var f = e.charCodeAt(g);
                if (f < 128) {
                    d += String.fromCharCode(f)
                } else {
                    if ((f > 127) && (f < 2048)) {
                        d += String.fromCharCode((f >> 6) | 192);
                        d += String.fromCharCode((f & 63) | 128)
                    } else {
                        d += String.fromCharCode((f >> 12) | 224);
                        d += String.fromCharCode(((f >> 6) & 63) | 128);
                        d += String.fromCharCode((f & 63) | 128)
                    }
                }
            }
            return d
        }
    }
    a.init();
    window.onresize = a.updateDiv;
    window.onscroll = a.updateDiv
})();

function im20_submitFunc() {
    window.open("imPingTool", "imPingTool", "width=790,height=490,scrollbars=yes");
    setTimeout(function () {
        im20_closePing()
    }, 1000);
    return true
}
function im20_closePing() {
    document.body.removeChild(document.getElementById("imPingMaskDiv"));
    document.body.removeChild(document.getElementById("imMain"))
};