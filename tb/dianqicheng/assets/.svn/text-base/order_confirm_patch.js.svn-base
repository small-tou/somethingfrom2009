/**
 * 购物车订单确认脚本
 * @author 渐飞
 * @date 2010-4-15
 * @version 2
 * @modify 20100701 阿大 添加修改发票抬头的功能
 *
 * 2011-04-20 根据新优惠平台重构
 *
 */
TB.namespace('TC');
TB.TC.OrderConfirm = function() {
    var Y = YAHOO,
    L = Y.lang,
    U = Y.util,
    C = U.Connect,
    D = U.Dom,
    E = U.Event,
    UA = YAHOO.env.ua;

    L.isInArray = function(element, array) {
        if (array.length === 0) {
            return false;
        }
        for (var i = 0; i < array.length; i++) {
            if (element === array[i]) {
                return true;
            }
        }
        return false;
    };

    L.removeFromArray = function(element, array) {
        if (!L.isInArray(element, array)) {
            return false;
        }
        for (var i = 0; i < array.length; i++) {
            if (array[i] === element) {
                array.splice(i, 1);
            }
        }
    };


    L.ObjectEach = function(o, fn, p) {
        if (!o) {
            return;
        }
        for (var k in o) {
            if (o.hasOwnProperty(k)) {
                p = p || o[k];
                fn.call(p, o[k], k);
            }
        }
    };

    D.getElementBy = function(method, tag, root) {
        var ret = D.getElementsBy(method, tag, root, null, null, null, true);
        return (L.isArray(ret) && !ret.length) ? null : ret;
    };

    if (UA.ie >= 6 && UA.ie <= 8) {
        Number.prototype.toFixed = function(precision) {
            var power = Math.pow(10, precision || 0);
            var n = String(Math.round(this * power) / power);
            var nf = n.split(".")[1];
            var suffixLeng = 0;
            if (nf) {
                suffixLeng = nf.length;
            } else if (precision != suffixLeng) {
                n = n + ".";
            }
            for (var i = 0; i < precision - suffixLeng; i++) {
                n = n + "0";
            }
            return n;
        }
    }

    var DEBUG_MODE = true;
    var log = function(obj, method) {
        if (DEBUG_MODE) {
            YAHOO.util.Event.throwErrors = true;
            try {
                if (typeof method === 'string') {
                    method = method.toLowerCase();
                    console[method](obj);
                } else {
                    console.log(obj);
                }
            }
            catch (e) {
            }
        } else {
            YAHOO.util.Event.throwErrors = false;
        }
    };

    var divCodeEl = D.get('J_DivisionCode');
    var orderTable = D.get('J_OrderTable');
    var orders = D.getElementsByClassName('J_Shop', 'tbody', orderTable);


    var timer = null;

    // 请求运费险的url
    var requestInsureAPI = '';
    // 运费险赔付价格前缀
    var InsurePayPricePrefix = 'J_InsurePayPrice_';
    // 运费险购买价格前缀
    var InsureBuyPricePrefix = 'J_InsureBuyPrice_';
    // 运费险文案钩子前缀
    var InsureTextPrefix = 'J_FareInsureText_';


    // 父页面是否改过
    var hasModified = function() {
        if (window.parent != window) {
            try{
                window.parent.TB.TC.DeliverAddress.modifiedCallback();
            }catch(e){
                setTimeout(arguments.callee,300);
            }
        }
    };

    // iframe 自适应高度
    var autoHeight = function() {
        var height = document.body.clientHeight || document.documentElement.clientHeight;
        if (window.parent != window) {
            try{
                window.parent.TB.TC.DeliverAddress.loadedCallback(height * 1 + 10);
            }catch(e){
                setTimeout(arguments.callee,300);
            }
        }
    };

    var bindDeduction = function(){
        var maxCon = D.get('J_MaxUsablePoints'),
        dischargeCon = D.get('J_AvailableDischarge'),
        comboElem,orderID,model,controller,view,
        check;
        if (!maxCon) {
            return
        };

        comboElem = D.getAncestorByClassName(maxCon,'J_PromoCombo'),

        orderID = comboElem.getAttribute('data-order');
        model = TB.Promotion.Models.get('orders',orderID);
        view = TB.Promotion.Views.get('orders',orderID);

        check = function(){
            var usablePoints = model.getAttr('mallCond'),
            availablePoints = parseInt(D.get('J_AvailablePoints').innerHTML, 10),
            outputPoint = usablePoints < availablePoints ? Math.floor(usablePoints) : Math.floor(availablePoints);
            //取可用商城积分与现有商城积分中的较小值
            maxCon.innerHTML = outputPoint;
            dischargeCon.innerHTML = (outputPoint / 100).toFixed(2);
        };

        view.pushQueue(orderID,check);
        model.subscribe('calculator',check);
    };
    var pointKeyupTrigger = function () {
        var self = this;
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(function() {
            pointKeyupTriggerMain.call(self);
        }, 200);
    };

    var pointKeyupTriggerMain = function() {
        var val = this.value;
        var hintEl = D.getElementsByClassName('msg', 'div', this.parentNode)[0],
        comboElem = D.getAncestorByClassName(this,'J_PromoCombo'),
        orderID = comboElem.getAttribute('data-order'),
        controller = TB.Promotion.Controllers.get('orders',orderID);
        if (!/^(\d+)?$/.test(val)) {
            message.call(this, '使用商城积分点数必须为大于或等于0的整数');
            return;
        }
        if (parseInt(val, 10) > parseInt(D.get('J_MaxUsablePoints').innerHTML, 10)) {
            message.call(this, '您使用的商城积分点数超过了该次订单确认允许使用的最大商城积分点数');
            return;
        }
        if (hintEl) {
            D.addClass(hintEl, 'hidden');
        }
        D.get('J_Discharge').innerHTML = '-' + parseFloat(String(this.value / 100).replace(/(\.\d{2}).*$/, '$1')).toFixed(2);

        /*updateMainTotal();*/
        controller.deduction({
            'val':this.value
            })

        function message(msg) {
            if (!hintEl) {
                hintEl = document.createElement('div');
                hintEl.id = 'J_pointHint';
                hintEl.className = 'msg';
                this.parentNode.appendChild(hintEl);
            }
            D.removeClass(hintEl, 'hidden');
            hintEl.innerHTML = '<p class="stop">' + msg + '</p>';
        }
    };

    // 显示自定义发票抬头输入款
    var showCustomInvoiceTitle = function(e) {
        E.stopEvent(e);
        var _invoice = D.getAncestorByClassName(this, "J_Inv");
        D.addClass(_invoice, "invoice-edit");
    };
    var checCustomInvoiceInput = function() {
        var hasEmpty = false;
        D.getElementsByClassName("J_EditInvInput", null, null, function(node) {
            var _p = node.parentNode.parentNode;
            var msg = D.getElementsByClassName("msg", null, _p)[0];
            if (YAHOO.lang.trim(node.value) === "") {
                if (!msg) {
                    msg = document.createElement("DIV");
                    msg.className = "msg";
                    msg.innerHTML = "<em class=\"error\">请填写发票抬头</em>";
                    _p.appendChild(msg);
                } else {
                    D.removeClass(msg, "hidden");
                }
                hasEmpty = true;
            } else {
                if (msg) {
                    D.addClass(msg, "hidden");
                }
            }
        });
        return hasEmpty;
    };

    // 文本框的Focus事件
    var textareaFocusHandler = function() {
        this.className = 'on s';
        autoHeight(); // 自适应高度
    //hasModified(); // 标记修改状态
    };

    // 文本框的Blur事件
    var textareaBlurHandler = function() {
        if (L.trim(this.value) == '') {
            this.className = 'off';
        }
    };

    // 文本框的KeyUp事件
    var textareaKeyupHandler = function() {
        var len = YAHOO.lang.trim(this.value).length; // 不区分中英文 .replace(/[^\x00-\xff]/g, '**')
        var msgEl = D.getElementsByClassName('msg', 'div', this.parentNode)[0];

        if (len > 200) {
            if (!msgEl) {
                msgEl = document.createElement('div');
                msgEl.className = 'msg';
                msgEl.innerHTML = '<em class="error" style="text-align:left;width:auto;">留言字数不能超过200字。</em>';
                this.parentNode.appendChild(msgEl);
            }
            return false;
        } else {
            if (msgEl) {
                msgEl.parentNode.removeChild(msgEl);
            }
            return true;
        }
    };
    var isCOD = D.get('J_COD') && D.get('J_COD').value == 'true';

    // 获取运费险数据
    var getInsureInfo = function() {
        if (!requestInsureAPI) {
            return;
        }
        //重置所有保险相关checkbox
        D.getElementsByClassName('J_BuyInsureCheck', 'input', 'J_OrderTable', function(el) {
            el.checked = false;
        });

        // 格式：http://xxx/xx.htm?recieveAddr=100101&itemAddress=123456|100101,110101;234567|101101,120101&callback=TB.TC.OrderConfirm
        var requestInsuleUrl = requestInsureAPI + (requestInsureAPI.indexOf('?') < 0 ? '?' : '&')
        + 'callback=TB.TC.OrderConfirm.GetInsureFee&t=' + (+new Date());
        Y.util.Get.script(requestInsuleUrl, {
            onFailure: function() {
                log('sorry 获取运费险数据出错!');
            },
            autopurge: true,
            timeout: 10000,
            charset: document.charset || document.characterSet || 'gb2312'
        });
    };

    /**
     * 设置运费保险的价格
     *
     * @param outOrderId
     * @param insurePayPrice 赔付费用
     * @param insureBuyPrice 购买费用
     */
    var setInsurePrice = function(outOrderId, insureBuyPrice, insurePayPrice) {
        var payDom = D.get(InsurePayPricePrefix + outOrderId);
        var buyDom = D.get(InsureBuyPricePrefix + outOrderId);
        if (payDom) {
            payDom.innerHTML = (insurePayPrice / 100).toFixed(2);
        }
        if (buyDom) {
            //从页面取数据不和谐
            buyDom.setAttribute('data-buy-price', insureBuyPrice);
            buyDom.innerHTML = (insureBuyPrice / 100).toFixed(2);
        }
    };

    return {
        initInsureApi:function(cfg) {
            if (cfg.requestAPI) {
                requestInsureAPI = cfg.requestAPI;
            }
        },

        // 获取运费险
        GetInsureFee:function(status, insureData) {
            /**
             * status :  "true"  ,    //标识是否成功
             * insurance_data :  [ { outorderId: "123456",  secret : "******" , insuranceFee: 0.5, compensation: 10, insuranceSellerId: 222555666} ，
             * { outorderId: "234567",  secret : "******" , insuranceFee: 0.25, compensation: 5, insuranceSellerId: 222444666}
             * ]
             */
            if (status === 'true' && insureData.length) {
                var insuranceData = [];
                for (var i = 0; i < insureData.length; i++) {
                    var oneInsure = insureData[i],orderID = oneInsure['outOrderId'],controller;
                    insuranceData.push([
                        oneInsure['outOrderId'],
                        oneInsure['insuranceFee'],
                        oneInsure['compensation'],
                        oneInsure['insuranceSellerId'],
                        oneInsure['secret']].join(','), ';');

                    //设置运费险价格
                    setInsurePrice(oneInsure['outOrderId'], oneInsure['insuranceFee'], oneInsure['compensation']);

                    //显示当前tbody里的tips
                    D.batch(orders, function(parent) {
                        var outId = parent.getAttribute('data-outOrderId');
                        if (outId && outId === oneInsure['outOrderId']) {
                            D.removeClass(D.getElementsByClassName('J_FareInsureTips', 'div', parent), 'hidden');
                        }
                    });
                    controller = TB.Promotion.Controllers.get('orders',orderID);
                }

                D.get('J_InsuranceDatas').value = insuranceData.join('');
                //防止iframe过低
                autoHeight();

                //给运费险的checkbox绑定上事件
                E.on('J_OrderTable', 'click', function(e) {
                    var target = E.getTarget(e),relatedOrder,orderID,controller,val;
                    if (D.hasClass(target, 'J_BuyInsureCheck')) {
                        relatedOrder = D.getAncestorByClassName(target, 'J_Shop');

                        orderID = relatedOrder.getAttribute('data-outOrderId');
                        controller = TB.Promotion.Controllers.get('orders',orderID);
                        val = target.checked ? D.get(InsureBuyPricePrefix + orderID).getAttribute('data-buy-price') : 0;

                        //updateInsureCheckBox(target, relatedOrder.getAttribute('data-outOrderId'));

                        //调用buy_patch版本的优惠接口
                        controller.insure({
                            'val':val
                        });
                    }
                });

                function updateInsureCheckBox(el, outOrderId) {
                    var payAnother = D.get('pay-for-another');
                    if (el.checked) {
                        D.removeClass(InsureTextPrefix + outOrderId, 'hidden');
                        if (payAnother) {
                            payAnother.checked = false;
                            payAnother.disabled = 'disabled';
                        }
                    } else {
                        D.addClass(InsureTextPrefix + outOrderId, 'hidden');
                        if (payAnother) {
                            payAnother.disabled = '';
                        }
                    }
                }
            }
        },
        init:function(ds, dc, dm) {

            // 元素欠缺，则直接返回
            if (!orderTable || !(D.getElementsByClassName('shop', 'tr', orderTable).length)) {
                autoHeight();
                return;
            }
            dataShop = ds || {};
            dataCard = dc || {};
            dataMap = dm || {};
            textarea = orderTable.getElementsByTagName('textarea');

            setTimeout(function() {
                D.batch(orders, function(order) {
                    /*updateOrderDetails(order);
                    updateOrderTotal(order);*/
                    });
            }, 50);

            // Textarea 相关事件
            E.on(textarea, 'focus', textareaFocusHandler);
            E.on(textarea, 'blur', textareaBlurHandler);
            E.on(textarea, 'keyup', textareaKeyupHandler);

            //编辑发票抬头
            E.on(D.getElementsByClassName("J_EditInvTitle"), "click", showCustomInvoiceTitle);
            E.on(D.getElementsByClassName("J_EditInvInput"), "keyup", function() {
                checCustomInvoiceInput();
            });

            E.on(D.get('J_PointsToUse'), 'keyup', pointKeyupTrigger);


            E.on(D.get('J_pointTipClose'), 'click', function(e) {
                E.stopEvent(e);
                var target = E.getTarget(e);
                D.addClass(target.parentNode, 'hidden');
            });

            E.on(D.get('J_pointTipTrigger'), 'click', function(e) {
                E.stopEvent(e);
                var target = E.getTarget(e);
                var em = D.getNextSibling(target);
                D.hasClass(em, 'hidden') ? D.removeClass(em, 'hidden') : D.addClass(em, 'hidden');

            });


            // 防止多次提交
            var alreadySubmited = false;

            // 绑定提交按钮事件
            E.on(D.get('J_Form'), 'submit', function(ev) {
                E.stopEvent(ev);

                // 置入hidden值
                if (window.parent != window) {
                    var map = window.parent.TB.TC.DeliverAddress.getDataCallback();
                    for (var k in map) {
                        if (YAHOO.env.ua.ie && YAHOO.env.ua.ie < 9) {
                            var hid = document.createElement('<input name="' + k + '" >');
                        } else {
                            hid = document.createElement('input');
                            hid.name = k;
                        }
                        hid.value = map[k];
                        hid.type = 'hidden';
                        D.get('J_Form').appendChild(hid);
                    }
                }

                if (D.get('J_pointHint') && !D.hasClass(D.get('J_pointHint'), 'hidden')) {
                    if (window.parent != window) {
                        if (window.parent.TB.TC.DeliverAddress.isLoadingCallback()) {
                            alert('数据载入中，请稍候');
                            return;
                        }
                        if (window.parent.TB.TC.DeliverAddress.isEditingCallback()) {
                            alert('请先确认你的地址');
                            return;
                        }
                    }
                    var val = D.get('J_BonusToUse').value;
                    if (!/^(\d+)?$/.test(val)) {
                        alert('使用商城积分点数必须为大于或等于0的整数');
                        D.get('J_BonusToUse').focus();
                        return;
                    }
                    if (parseInt(val) > parseInt(D.get('J_MaxUsablePoints').innerHTML)) {
                        alert('您使用的商城积分点数超过了该次订单确认允许使用的最大商城积分点数');
                        D.get('J_BonusToUse').focus();
                        return;
                    }
                }

                if (D.get('verify-code') && L.trim(D.get('verify-code').value) === '') {
                    alert('请输入验证码');
                    D.get('verify-code').focus();
                    return;
                }

                // COD
                if (isCOD) {
                    if (D.get('cod-error')) {
                        alert('货到付款暂时不支持您的收货地址或金额,请更换收货地址或者采用支付宝付款的方式!');
                        //E.stopEvent(ev);
                        E.on(D.get('J_Form'), 'submit', function() {
                            return false;
                        });
                        D.get('cod-error').focus();
                        return;
                    }
                }

                // 清空hasClass('off')的textarea
                var gbookFlood = false;
                D.batch(textarea, function(el) {
                    if (!textareaKeyupHandler.call(el)) {
                        gbookFlood = true;
                    } else {
                        if (D.hasClass(el, 'off')) {
                            el.value = '';
                        }
                    }
                });
                if (gbookFlood) {
                    alert('留言字数不能超过200字。');
                    return;
                }

                //验证发票抬头是否为空
                if (checCustomInvoiceInput()) {
                    alert('发票抬头不能为空');
                    return;
                }

                var getHidValue = function(e) {
                    var params = [];
                    if (L.isArray(e)) {
                        for (var i = 0,l = e.length; i < l; i++) {
                            params[params.length] = encodeURIComponent(L.trim(D.get(e[i]).name)) + '=' + encodeURIComponent(L.trim(D.get(e[i]).value));
                        }
                    }
                    if (typeof e === 'String') {
                        params[params.length] = encodeURIComponent(L.trim(D.get(e).name)) + '=' + encodeURIComponent(L.trim(D.get(e).value));
                    }
                    return params.join('&');
                };

                var submitForm = function() {
                    if (!alreadySubmited) {
                        alreadySubmited = true;
                    } else {
                        alert('提交订单中，请稍候。');
                        return;
                    }
                    // 提交表单
                    D.get('J_Form').submit();
                };
                if (D.get('verify-code')) {
                    if (D.get('J_isCheckCode')) {
                        var uri = D.get('J_checkCodeUrl') && D.get('J_checkCodeUrl').value;
                        uri += '?' + getHidValue(['J_isCheckCode','J_encrypterString','J_sid','J_gmtCreate','J_cartId']);
                        // AJAX审核验证码
                        uri += '&checkCode=' + L.trim(D.get('verify-code').value);
                    }
                    else {//checkcode修改前逻辑 by yuchun 2009-10-9
                        var query = 'checkCode=' + L.trim(D.get('verify-code').value);
                        uri = D.get('J_verifyImage').getAttribute('data-url') + '?' + query;
                    }
                    // test data url: http://projects/tc/assets/testData/checkCode.php
                    YAHOO.util.Connect.asyncRequest('get', uri, {
                        success: function(r) {
                            if (typeof r.responseText !== 'undefined') {
                                var rt = L.trim(r.responseText);
                                if (rt !== 'error') {
                                    // 不为error的时候，返回的是md5加密字符串
                                    // 创建hidden域
                                    if (D.get('check-code')) {
                                        D.get('check-code').value = rt;
                                    } else {
                                        if (YAHOO.env.ua.ie && YAHOO.env.ua.ie < 9) {
                                            var hid = document.createElement('<input name="newCheckCode" >');
                                        } else {
                                            hid = document.createElement('input');
                                            hid.name = 'newCheckCode';
                                        }
                                        hid.id = 'check-code';
                                        hid.value = rt;
                                        hid.type = 'hidden';
                                        D.get('J_Form').appendChild(hid);
                                    }
                                    submitForm();

                                } else {
                                    // 处理错误情况
                                    // 更新验证码
                                    if (!D.get('J_verifyImage')) {
                                        return;
                                    }

                                    var url = D.get('J_verifyImage').src;
                                    D.get('J_verifyImage').src = url + "&t=" + new Date().getTime();

                                    // 提示验证码出错
                                    var vertifyWrapper = D.get('J_verifyImage').parentNode;
                                    var msgElmt = D.getElementsByClassName('msg', 'div', vertifyWrapper)[0];
                                    if (msgElmt) {
                                        D.removeClass(msgElmt, 'hidden');
                                    } else {
                                        msgElmt = document.createElement('div');
                                        msgElmt.className = 'msg';
                                        msgElmt.innerHTML = '<p class="stop">请填写正确的校验码</p>';
                                        vertifyWrapper.appendChild(msgElmt);
                                    }
                                }
                            }
                        },
                        failure: function() {
                            alert('请求失败，请重试！');
                            if (!D.get('J_verifyImage')) {
                                return;
                            }
                            var url = D.get('J_verifyImage').src;
                            D.get('J_verifyImage').src = url + "&t=" + new Date().getTime();
                        },
                        timeout: 6000,
                        cache: false
                    });
                }
                else {
                    submitForm();
                }

            });

            var asyncBind = function(){
                var B = TB.Promotion,models = B.Models.orders;

                if (top === window) {
                    return;
                }
                try{
                    L.ObjectEach(models,function(m){
                        m.subscribe('promotionFailure',function(){
                            var parentDom = parent.YAHOO.util.Dom,
                            address = parentDom.get('address'),tips = parentDom.get('J_BundleDisabled');
                            if (!tips) {
                                tips  = parent.document.createElement('div');
                                parentDom.addClass(tips,'msg24');
                                parentDom.addClass(tips,'bundle-disabled');
                                tips.setAttribute('id','J_BundleDisabled');

                                tips.innerHTML = '<p class="tips">系统故障，所有优惠已禁用，但不影响当前订单的提交。重新启用优惠，请尝试刷新此页面。</p>'
                            };
                            parentDom.insertAfter(tips,address);
                        });
                    });
                }catch(e){
                    setTimeout(arguments.callee,300);
                }
            };

            E.onDOMReady(function() {
                hasModified();
                autoHeight();
                asyncBind();
            });

            getInsureInfo();
            /*add new promotion port*/
            bindDeduction();

        }
    };
}();
