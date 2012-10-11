// vim: set fdm=marker ff=unix fenc=gbk ft=javascript sw=4 sts=4
// @require tbra-aio.js
YAHOO.util.Event.throwErrors = true;
TB.namespace('TB.Promotion');
(function(B) {
    var S=KISSY,DOM=S.DOM,Event=S.Event;
    var amountHandle={
        _removeError :function() {
            var hasDangerWarn = false;
            var em = this.parentNode.getElementsByTagName('em');
            hasDangerWarn = DOM.hasClass(em,'s-danger-text');
            DOM.remove(em);

            return hasDangerWarn;
        },
        _addError : function(msg) {
            amountHandle._removeError.call(this);
            var em = DOM.create('<em>');
            DOM.addClass(em, 'error-msg');
            em.appendChild(DOM.create(msg));
            this.parentNode.appendChild(em);
        },
        changeAmount:function(model,controller,val){
            controller.amount({
                val:val,
                force:true
            });
            
        },
        setNo:function(ele,min_or_max){
            var min=ele.previousSibling;
            if(min_or_max=="min"){
                ele.previousSibling.className="no-minus"
            }else if(min_or_max=="max"){
                ele.nextSibling.className="no-plus"
            }else if(min_or_max=="minmax"){
                ele.previousSibling.className="no-minus"
                ele.nextSibling.className="no-plus"
            }else{
                ele.previousSibling.className="minus"
                ele.nextSibling.className="plus"
            }
        },
        checkAmount:function(ele,max,now,model,controller){
            amountHandle._removeError.call(ele)
            amountHandle.setNo(ele,"")
            if(max<3){
                amountHandle._addError.call(ele, '库存紧张');

            }
            if(max==0){
                amountHandle._addError.call(ele, '库存不足');
                amountHandle.changeAmount(model,controller,"0")
                amountHandle.setNo(ele,"minmax")
                return;
            }
            if(now<=1){
                amountHandle.changeAmount(model,controller,"1")
                amountHandle.setNo(ele,"min")
                return;
            }
           
            if(now>=max){
                amountHandle._addError.call(ele, '最多只可购买' + max + '件');
                amountHandle.changeAmount(model,controller,max+"")
                amountHandle.setNo(ele,"max")
            }else{
                amountHandle.changeAmount(model,controller,now+"")
            }
            
        //  amountHandle.changeAmount(controller,now)
        }
    }
    // Init!! {{{
    var Y = YAHOO.util, Lang = YAHOO.lang, Dom = Y.Dom, Event = Y.Event,
    isIE = YAHOO.env.ua.ie > 0, isIE6 = YAHOO.env.ua.ie === 6,
    Connect = Y.Connect, JSON = Lang.JSON, doc = document,
    CONST = {
        'NO_PROMO_VALUE' : '0',
        'COD_NULL_LEVEL' : '0',
        'COUPLE_SPLITER' : ';',
        'NO_PROMO_TITLE' : '无优惠',
        'JSON_PARSE_ERROR' : '数据解析错误',
        'ASYNC_CONNCET_ERROR' : '通讯错误,请稍后重试。',
        'NO_POSTAGE_FEE' : '免运费',
        'NO_PROMO_DESC' : '暂无优惠详情',
        'COD_PROMO_TPL' : '货到付款优惠{sum}元',
        'COD_UP' : '货到付款向上取整为 1 元'
    },
    utils = {
        JSON: {
            parse: function(data) {
                try {
                    var ret = new Function('return' + data.replace(/\n|\r|\t/g, ''))();
                }catch (e) {
                    alert(CONST['JSON_PARSE_ERROR']);
                }
                return ret;
            },
            stringify: function(data) {
                return JSON.stringify(data);
            }
        },
        size: function(o) {
            var l = 0, k;
            for (k in o) {
                o.hasOwnProperty(k) && (l += 1);
            }
            return l;
        },
        isEmpty: function(o) {
            for (var k in o) {
                if (o.hasOwnProperty(k)) {
                    return false;
                }
            }
            return true;
        },
        each: function(o, fn, p) {
            if (!o) {
                return;
            }
            for (var k in o) {
                if (o.hasOwnProperty(k)) {
                    p = p || o[k];
                    fn.call(p, o[k], k);
                }
            }
        },
        formatURL: function(s) {
            s = s.indexOf('?') > 0 ? s + '&_input_charset=utf-8&': s + '?_input_charset=utf-8&';
            return s;
        },
        _getMVC:function(type,s){
            return this[type][s];
        }
    },
    asyncQueue = null, /*async single request lock*/
    Models = {
        'promos': {},
        'orders': {},
        'get': utils._getMVC
    },
    Controllers = {
        'orders': {},
        'get': utils._getMVC
    },
    Views = {
        'orders': {},
        'get': utils._getMVC
    },
    Model, PromoModel, OrderModel, OrderView, OrderController;
    // }}}

    // 全局Models管理
    Model = function() {}; // {{{
    Lang.augmentProto(Model, Y.EventProvider);
    Lang.augmentObject(Model.prototype, {
        _get: function(o, s) {
            if (!s) {
                return o;
            }
            var data = o, keys = s.split('->'), key, ret,
            i = 0, len = keys.length;
            for (; i < len; i += 1) {
                key = Lang.trim(keys[i]);
                ret = data && data[key];
                if (ret !== undefined) {
                    data = ret;
                } else {
                    ret = null;
                    break;
                }
            }
            return ret;
        },
        _set: function(o, s, val) {
            var data = o, keys = s.split('->'), key, item, i = 0, len = keys.length;
            if (len === 1) {
                key = keys[0];
                data[key] = val;
            } else {
                for (; i < len - 1; i += 1) {
                    key = keys[i];
                    item = data[key];
                    !item && (item = data[key] = {});
                    data = item;
                }
                item[keys[len - 1]] = val;
            }
        },
        _delete: function(o, s) {
            if (!s || !o) {
                return;
            }

            var data = o, keys = s.split('->'), key, item, i = 0, len = keys.length;
            if (len === 1) {
                key = keys[0];
            } else {
                for (; i < len - 1; i += 1) {
                    key = keys[i];
                    item = data[key] || {};
                    data = item;
                }
            }

            if (Lang.isObject(data)) {
                try {
                    delete data[key];
                }catch (e) {}
            }
        },
        query: function(s) {
            var self = this, data = self.data, ret;
            ret = self._get(data, s);
            return ret;
        },
        update: function(s, val) {
            var self = this, data = self.data;
            self._set(data, s, val);
        },
        del: function(s) {
            if (!s) {
                return;
            }
            var self = this, data = self.data;
            self._delete(data, s);
        },
        getAttr: function(s) {
            var self = this, attrs = self.attrs, ret;
            ret = self._get(attrs, s);
            return ret;
        },
        setAttr: function(s, val) {
            var self = this, data = self.attrs;
            self._set(data, s, val);
        }
    }); // }}}

    // Model
    OrderModel = function(o, uid, config) { // {{{
        var self = this,
        eventsList = {
            'CHANGE_BUNDLELIST': 'changeBundles',
            'CALCTWIST': 'calcTwist',
            'CALCULATOR': 'calculator',
            'CHANGE_SELECTED': 'changeSelected',
            'CHANGE_AMOUNT': 'changeAmount',
            'CHANGE_POSTAGE': 'changePostage',
            'CHANGE_BAN': 'changeBan',
            'CHANGE_INSURE':'changeInsure',
            'AVERAGE_SUM':'averageSum',
            'ASYNC':'async',
            'PROMOTION_FAILURE':'promotionFailure',
            'ASYNC_MERGE':'asyncMerge',
            'DEDUCTION':'deduction'
        };

        Models['orders'][uid] = self;

        self.uid = uid;
        self.config = config;
        self.data = o;
        self.attrs = o['orders'] && o['orders'][uid] || {};

        utils.each(eventsList, function(item) {
            self.createEvent(item);
        });
        self.initialize();
    };
    Lang.augmentProto(OrderModel, Model); // }}}
    Lang.augmentObject(OrderModel.prototype, { // {{{
        initialize: function() { // {{{
            var self = this,
            disabled = self.config.disabled,
            twistList = ['calcTwist','changeAmount','changePostage','changeInsure','deduction','averageSum'];

            twistList.forEach(function(key){
                self.subscribe(key,function(o){
                    self.calcTwist({
                        'event':(o && o.event) || key
                    });
                });
            });

            // 更新父订单的运费加价
            self.subscribe('changeAmount',function(){
                !disabled && self._async('amount');
                self.parent && self.parent.changePostage();
            });

            self.subscribe('async',function(o){
                var orders = o && o.val;
                if(!orders){
                    return;
                }
                utils.each(orders, function(item,idx) {
                    var m = B.Models['orders'][idx];
                    m && m.asyncMerge(item);
                });
            });

            self.subscribe('promotionFailure',function(o){
                var orders = B.Models['orders'];

                utils.each(orders, function(m, idx) {
                    m && m.asyncMerge({
                        bundle: null,
                        bundles: {}
                    });
                });
            });

            self.subscribe('changeSelected',function(o){
                if (!o) {
                    return;
                }

                o.deliveryChange && self.changePostage({
                    'refresh':true
                });
                o.bundles && self.changeBundles({
                    'val':o.bundles
                });

                self.changeBan(o.banlist);
                self.calcTwist({
                    'event':'changeSelected'
                });
            });

            try {
                self.changePostage({
                    isInit: true
                });
            }catch (E1) {
                console.log('E1',E1.message);
            }
            try {
                self.changeSelected({
                    isInit: true
                });
            }catch (E2) {
                console.log('E2',E2.message);
            }

            self.calculator();

            //for buynow,get the main order id  only
            if (!B.Single && !self.getAttr('cross') && !self.getAttr('parent')) {
                B.Single = self
            };
        }, // }}}
        _async: function(act) { // {{{
            var status = 'failure', self = this,
            config = self.config, apis = config.apis, url = apis[act], formData = config.form,
            dataForm = Dom.get(formData['promoForm']), dataInput = Dom.get(formData['promoData']), dataOrderID = Dom.get(formData['promoOrder']),
            method = (dataForm && dataForm.getAttribute('method')) || 'POST', postData,
            resetSelected = function(){};
            

            if (!url) {
                return;
            }
            /*simple object clone*/
            postData = utils.JSON.stringify(self.query('orders'));
            postData = utils.JSON.parse(postData);

            utils.each(postData, function(item) {
                var filter = ['bundles','cod','total','sum','postages','banlist','mallCond','point','pointDiscount','postType','codRate','pointRate'];
                filter.forEach(function(idx){
                    try {
                        delete item[idx];
                    }catch (e) {}
                });
            });

            dataInput.value = utils.JSON.stringify(postData);
            dataOrderID.value = self.uid;

            asyncQueue && Connect.abort(asyncQueue); /*async single request unlock*/
            Connect.setForm(dataForm);
            asyncQueue = Connect.asyncRequest(method, url, {
                success: function(res) {
                    var jsonData, mergeData, mergePromos = self.query('promos');

                    try {
                        jsonData = new Function('return' + res.responseText.replace(/\n|\r|\t/g, ''))();
                    }catch (e) {
                        self.fireEvent('promotionFailure');
                    };

                    asyncQueue = null;
                    status = 'success';
                    if (!mergePromos) {
                        mergePromos = {};
                    }

                    if (!jsonData) {
                        return;
                    }
                    if (jsonData.result === 'success') {
                        mergeData = jsonData.data;
                        if(mergeData['promos']){
                            if(!mergePromos) {
                                self.update('promos',mergeData['promos']);
                            } else {
                                Lang.augmentObject(mergePromos, mergeData['promos']);
                            }
                        }
                        self.fireEvent('async',{
                            'val':mergeData['orders']
                        });
                    } else {
                        self.fireEvent('promotionFailure');
                    }
                },
                failure: function() {
                    asyncQueue = null;
                    self.fireEvent('promotionFailure');
                },
                cache: false
            });

            return status;
        }, // }}}
        calculator: function(o) { // {{{
            var self = this, silent = o && o.silent, uid = self.uid, selected = self.getAttr('bundle'),
            freedelivery = selected ? self.getAttr('bundles->' + selected + '->freedelivery') : false,
            isExchange = self.getAttr('exchange'), postType = self.getAttr('postType'),
            mallCond = 0, isBSeller = self.getAttr('isBSeller'),
            amount = self.getAttr('amount'), price = self.getAttr('price'),
            discount = selected ? self.getAttr('bundles->' + selected + '->discount') : 0,
            total = price * amount, sum = total,
            bundlePoint = selected ? self.getAttr('bundles->' + selected + '->point') : 0,
            point = 0, pointRate = self.getAttr('pointRate'), averageSum = self.getAttr('averageSum') || sum;

            discount = +discount;
            averageSum = +averageSum;
            pointRate = +pointRate;

            bundlePoint = +bundlePoint;

            if (self.getAttr('parent')) {
                sum = total - discount;
                if (isBSeller) {
                    mallCond = averageSum;
                    point = Math.floor(averageSum * pointRate / 1000);
                    point = point + bundlePoint;
                }
            } else {
                var children = self.query('relation->' + uid),
                postageFee,
                insureFee = self.getAttr('insureFee') || 0,
                deduction = self.getAttr('deduction') || 0;

                if (postType === 'cod') {
                    postageFee = self._CODCalc({
                        'refresh':true
                    });
                } else {
                    postageFee = self._postageCalc({
                        'refresh':true
                    });
                };
                postageFee = postageFee || 0; //temp,should be removed

                total = 0;
                sum = 0;
                postageFee = +postageFee;
                insureFee = +insureFee;

                children.forEach(function(item) {
                    var child = Models.get('orders', item);

                    total += +child.getAttr('total');
                    
                    if (child.getAttr('parent') && child.getAttr('averageSum')) {
                        sum += +child.getAttr('averageSum');
                    } else {
                        sum += +child.getAttr('sum');
                    };
                    
                    if(isBSeller || self.getAttr('cross')){
                        mallCond += child.getAttr('mallCond');
                        point += child.getAttr('point');
                    }

                });
                
                /*sum -= discount;*/
                sum = !isExchange ? sum : 0;
                sum += postageFee;
                sum += insureFee;
                if (isBSeller || self.getAttr('cross')) {
                    point += bundlePoint;
                }
            /*point -= deduction;*/
            /*sum -= (+deduction);*/
            }
            self.setAttr('mallCond', mallCond < 0 ? 0 : mallCond);
            self.setAttr('sum', sum < 0 ? 0 : sum);
            self.setAttr('total',total);
            self.setAttr('point',point);

            !silent && self.fireEvent('calculator',o);
        }, // }}}
        calcTwist: function(o){ // {{{
            var self = this;
            self.calculator(o);
            self.parent && self.parent.fireEvent('calcTwist',o);
        }, //}}}
        changeBundles: function(o) { // {{{
            var self = this, val = o.val, silent = o.silent;
            self.setAttr('bundles', val);
            !silent && self.fireEvent('changeBundles');
        }, // }}}
        changeSelected: function(o) { // {{{
            var self = this, isInit = o && o.isInit || false, silent = o && o.silent || false, isAsync = o && o.isAsync || false,
            updateBundles = o.bundles, selected = self.getAttr('bundle'), val = !isInit ? (o.val === null ? null : (o.val || selected)) : selected,
            bundleList = isAsync && updateBundles ? updateBundles : self.getAttr('bundles') || {},
            unitData = {},
            stayDelivery = self.getAttr('bundles->' + selected + '->freedelivery'),
            currentDelivery = self.getAttr('bundles->' + val + '->freedelivery'),
            comparePromo = function() {
                var original = selected ? self.getAttr('bundles->' + selected + '->promos') : [],
                current = (val && bundleList[val]) ? bundleList[val]['promos'] : [],
                stay = [], added = [], removed = [], ret;

                current = current || [];
                original = original || [];

                current.forEach(function(item) {
                    if (original.indexOf(item) !== -1) {
                        stay.push(item);
                    } else {
                        added.push(item);
                    }
                });
                original.forEach(function(item) {
                    if (current.indexOf(item) === -1) {
                        removed.push(item);
                    }
                });

                ret = !isInit ? {
                    'original': original,
                    'current': current,
                    'stay': stay,
                    'added': added,
                    'removed': removed
                } : {
                    'original': [],
                    'current': current,
                    'stay': [],
                    'added': current,
                    'removed': []
                };

                return ret;
            },
            coupleUnit = function() {
                var compared = comparePromo(), promoRemoved = compared.removed, promoAdded = compared.added,
                couple = self.getAttr('couple') || [],
                banlist = {
                    'added': [],
                    'removed': []
                };

                promoAdded.forEach(function(item) {
                    var used = self.query('promos->' + item + '->used') || [],
                    unused = self.query('promos->' + item + '->unused') || [],
                    once = self.query('promos->' + item + '->once');

                    unused.some(function(val, idx) {
                        if (couple.indexOf(val) === -1) {
                            used.push(val);
                            couple.push(val);
                            once && unused.splice(idx, 1);
                            return true;
                        }
                    });

                    self.update('promos->' + item + '->used', used);
                    self.update('promos->' + item + '->unused', unused);

                    if (!unused[0]) {
                        banlist['added'].push(item);
                    }
                });

                promoRemoved.forEach(function(item) {
                    var used = self.query('promos->' + item + '->used') || [],
                    unused = self.query('promos->' + item + '->unused') || [],
                    once = self.query('promos->' + item + '->once');

                    used.some(function(val, idx) {
                        var index = couple.indexOf(val);
                        if (index !== -1) {
                            used.splice(idx, 1);
                            couple.splice(index, 1);
                            once && unused.push(val);
                            return true;
                        }
                    });

                    self.update('promos->' + item + '->used', used);
                    self.update('promos->' + item + '->unused', unused);

                    if (unused[0]) {
                        banlist['removed'].push(item);
                    }
                });

                return {
                    'couple' : couple,
                    'banlist' : banlist
                };
            };
            
            unitData = coupleUnit();
            Lang.augmentObject(unitData,{
                'deliveryChange' : !!stayDelivery !== !!currentDelivery,
                'bundles' : updateBundles,
                'isAsync' : isAsync
            });
            /*console.log(self.uid,unitData);*/
            self.setAttr('couple', unitData['couple']);
            self.setAttr('bundle', bundleList[val] ? val : null);
            o.averageSum && self.setAttr('averageSum',o.averageSum);

            !silent && self.fireEvent('changeSelected',unitData);
        }, // }}}
        _CODCalc:function(o){ // {{{
            var self = this, val = o && o.val, refresh = o && o.refresh,
            selected = self.getAttr('bundle'),
            freedelivery = selected ? self.getAttr('bundles->' + selected + '->freedelivery') : false,
            fare = self.getAttr('postages->fare'),
            isExchanged = self.getAttr('exchange'),
            list = self.getAttr('postages->list'),
            children = self.query('relation->' + self.uid),
            val = val || self.getAttr('postages->selected'),
            deduction = self.getAttr('deduction') || 0,
            codFees = {}, serviceFees = {}, codFee, serviceFee,
            factors = {}, factor,
            subOrders = [], bareSum = 0,
            compareArr = [], codDiff = false;

            fare = +fare;
            fare = freedelivery ? 0 : fare;
            deduction = +deduction;
            
            if (refresh) {
                children.forEach(function(item) {
                    var child = Models.get('orders', item),
                    sum = child.getAttr('averageSum') || child.getAttr('sum'),
                    rate = child.getAttr('codRate');

                    sum = +sum;
                    rate = +rate;

                    bareSum += sum;
                    subOrders.push([sum, 100 - rate]);
                });

                bareSum = isExchanged ? 0 : bareSum - deduction;

                utils.each(list,function(item,idx){
                    var fees = calculateServiceFee(bareSum, fare, item.level, subOrders, true),
                    service = fees['serviceFee'],
                    fac = fees['factor'],
                    fee = fare + service;

                    if (!codDiff) {
                        if (compareArr[0] !== undefined && compareArr[0] !== null) {
                            codDiff = (compareArr.indexOf(fee) === -1);
                        } else {
                            compareArr.push(fee);
                        };
                    };

                    codFees[idx] = fee;
                    serviceFees[idx] = service;
                    factors[idx] = fac;

                    if (idx === val) {
                        codFee = fee;
                        serviceFee = service;
                        factor = fac;
                    };
                });

                self.setAttr('postages->diff', codDiff);
                self.setAttr('codFees', codFees);
                self.setAttr('serviceFees', serviceFees);
                self.setAttr('factors', factors);
            } else {
                codFees = self.getAttr('codFees');
                codFee = codFees[val];

                serviceFees = self.getAttr('serviceFees');
                serviceFee = serviceFees[val];

                factors = self.getAttr('factors');
                factors = factors[val];
            };
            
            self.setAttr('postageFee', codFee);
            self.setAttr('serviceFee', serviceFee);
            self.setAttr('factor', factor);
            val !== selected && (self.setAttr('postages->selected',val));

            return codFee;
        }, // }}}
        _postageCalc: function(o){ // {{{
            var self = this,
            cache = self.getAttr('postages->_cache'), path = cache ? 'postages->_cache' : 'postages->list',
            bundle = self.getAttr('bundle'), freedelivery = self.getAttr('bundles->' + bundle + '->freedelivery'),
            children = self.query('relation->' + self.uid),
            postages = self.getAttr('postages'), selected = self.getAttr('postages->selected'),
            val = o && o.val || selected, incr = 0,
            child = B.Models.get('orders',children[0]), amount = child.getAttr('amount'),
            _sum, sum = 0, incr = 0, _incr,single;

            single = self.getAttr(path + '->' + val + '->fee') || 0;
            _incr = self.getAttr(path + '->' + val + '->incr') || 0;
            if (!freedelivery) {
                if (!!single && !!_incr) {
                    single = +single;
                    _incr = +_incr;
                    amount = +amount;

                    incr += _incr * (amount - 1);
                    sum = single + incr;
                } else {
                    _sum = self.getAttr(path + '->' + val + '->fee') || self.getAttr(path + '->' + val + '->sum');
                    sum = +_sum;
                }
            } else {
                sum = 0;
            }

            self.setAttr('postageFee', sum);
            val !== selected && (self.setAttr('postages->selected',val));

            return sum;
        }, // }}}
        _detectPostage: function(o){ // {{{
            var self = this,
            postages = self.getAttr('postages'), list = self.getAttr('postages->list'), k, item,
            postType = self.getAttr('postType');

            if (postType) {
                return postType;
            }

            for (k in list) {
                item = list[k];
                postType = item.level !== undefined ? 'cod' : 'post';
                break;
            };

            self.setAttr('postType',postType);
            return postType;
        }, // }}}
        changePostage: function(o) { // {{{
            var self = this, isInit = o && o.isInit, refresh = o && o.refresh || isInit, silent = o && o.silent, val = o && o.val,
            cache = o && o.cache, postType = (o && o.postType) || self._detectPostage();

            // console.log('changePostage');
            if (self.getAttr('parent') || self.getAttr('cross')) {
                return;
            }

            postType === 'post' ? self._postageCalc({
                'val':val
            }) :  self._CODCalc({
                'val':val,
                'refresh':refresh
            });

            !silent && self.fireEvent('changePostage',o);
        }, // }}}
        changeAmount: function(o) { // {{{
            var self = this,silent = o.silent;
         
            self.setAttr('amount',o.val);
            !silent && self.fireEvent('changeAmount');
        }, // }}}
        changeBan: function(o) { // {{{
            var self = this, silent = o && o.silent, parent = self.getAttr('parent'), banTemp = [] ,banlist,
            seller = self.getAttr('sellerId'),same = self.query('split->' + seller),
            added = o.added || [], removed = o.removed || [],
            serialize = function(){
                removed.forEach(function(item){
                    var idx = banlist.indexOf(item);
                    if (idx !== -1) {
                        banlist.splice(idx,1);
                    }
                });
                added.forEach(function(item){
                    if (banlist.indexOf(item) === -1) {
                        banlist.push(item);
                    }
                });
            },
            getCross = function(){
                var c = B.Cross,ret, k, arr,
                o = self.query('relation');
                if (c) {
                    ret = c;
                } else {
                    for (k in o) {
                        arr = o[k];
                        if (o[arr[0]]) {
                            ret = B.Cross = k;
                            break;
                        }
                    };
                }

                return ret;
            };

            if (self.getAttr('cross')) {
                return
            };

            if (self.getAttr('parent')) {
                if (same && same[1]) {
                    banlist = [];
                    same.forEach(function(item){
                        var list = self.query('orders->' + item + '->banlist') || [];
                        banTemp = banTemp.concat(list);
                    });
                    banTemp.forEach(function(item){
                        (banlist.indexOf(item) === -1) && banlist.push(item);
                    });
                    serialize();
                } else {
                    banlist = self.query('orders->' + parent + '->banlist') || [];
                    serialize();
                }
            } else {
                parent = getCross();
                banlist = self.query('orders->' + parent + '->banlist') || [];
                serialize();
            }
            
            if (self.getAttr('parent') && same[0]) {
                same.forEach(function(item){
                    self.update('orders->' + item + '->banlist',banlist);
                });
            } else {
                self.update('orders->' + parent + '->banlist',banlist);
            };

            !silent && self.fireEvent('changeBan');
        }, // }}}
        changeInsure: function(o){ //{{{
            var self = this, insure = o.val || 0;
            self.setAttr('insureFee',insure);
            self.fireEvent('changeInsure');
        }, //}}}
        averageSum: function(o){ //{{{
            var self = this, average = o && o.val || 0, silent = o && o.silent;
            self.setAttr('averageSum',average);
            !silent && self.fireEvent('averageSum');
        }, //}}}
        deduction: function(o){ //{{{
            var self = this, points = o.val || 0;
            self.setAttr('deduction',points);
            self.fireEvent('deduction');
        }, //}}}
        asyncMerge:function(o){ // {{{
            var self = this,
            bundle = o.bundle, bundles = o.bundles,
            previous = self.getAttr('bundle'), original = self.getAttr('bundles->' + previous + '->promos') || [], added = [],
            averageSum = o.averageSum,
            correct = function(){
                var p, ret = bundle, parent = self.getAttr('cross') ? null : (self.getAttr('parent') || B.Cross), pm, banlist;

                if (!parent || !bundle) {
                    return ret;
                }
                    
                pm = Models.get('orders',parent);
                banlist = pm.getAttr('banlist') || [];

                if (!bundles) {
                    p = model.getAttr('bundles->' + bundle + '->promos') || [];
                } else {
                    p = bundles[bundle]['promos'];
                }
                p.forEach(function(item){
                    if (original.indexOf(item) === -1) {
                        added.push(item)
                    };
                });

                added.some(function(item){
                    if(banlist.indexOf(item) !== -1){
                        ret = null;
                        return true;
                    }
                });
                return ret;
            };

            if (bundle || bundles) {
                bundle = correct();
                self.changeSelected({
                    'val':bundle,
                    'bundles':bundles,
                    'averageSum':averageSum,
                    'isAsync':true
                });
            } else if (averageSum) {
                self.averageSum({
                    'val':averageSum,
                    'isAsync':true
                });
            };
        } // }}}
    }); // }}}

    // View
    OrderView = function(model,controller) { // {{{
        var self = this;

        uid = model.uid;
        self.uid = uid;
        self.model = model;
        self.controller = controller;

        Views['orders'][uid] = self;
        self.initialize();
    }; // }}}
    Lang.augmentObject(OrderView.prototype, { // {{{
        initialize: function() { // {{{
            var self = this, model = self.model, config = model.config;

            model.subscribe('changeBundles', function() {
                self.renderBundles();
            });
            model.subscribe('calculator', function() {
                self.renderSum();
                self.renderPostage();
            });
            model.subscribe('changeSelected',function(o){
                self.renderBundles();
                self.renderExt();
            });
            model.subscribe('changeBan',function(){
                var parent = model.getAttr('cross') ? null : (model.getAttr('parent') || B.Cross),
                seller = model.getAttr('sellerId'), same = seller && model.query('split->' + seller);
                if(!parent){
                    return;
                }

                if (model.getAttr('parent') && same) {
                    same.forEach(function(item){
                        model.query('relation->' + item).forEach(function(idx){
                            var m = Models.get('orders',idx);
                            if (m !== model) {
                                m.fireEvent('changeBundles', {
                                    event: 'changeBan'
                                });
                            }
                        });
                    });
                } else {
                    model.query('relation->' + parent).forEach(function(idx){
                        var m = Models.get('orders',idx);
                        if (m !== model) {
                            m.fireEvent('changeBundles', {
                                event: 'changeBan'
                            });
                        }
                    });
                };
            });
        }, // }}}
        renderQueue: {/*uid:[]*/},
        pushQueue:function(uid,fn){
            var self = this,queues = self.renderQueue,queue = queues[uid] || [];
            if(fn && Lang.isFunction(fn)) {
                queue.push(fn);
                queues[uid] = queue;
            }
        },
        _bindDOM: function(elems){
            var self = this;

            model = self.model;
            self.domData = elems;
            self.elems = elems[model.uid] || {};
        },
        _getElem: function(s) { // {{{
            return this.elems && this.elems[s];
        }, // }}}
        _setHTML: function(o,s,d) { // {{{
            if (!o || !o.tagName) {
                return;
            }
            s = s ? s : d ? d : '';
            o.innerHTML = s;
        }, // }}}
        //tianqi 2011年9月26日20:08:10
        renderAmount:function(silent){
            
            var amount=this.elems.amount;
            if(!amount) return;
            console.log(this)
            var model=this.model,
            controller=this.controller,
            config=model.config
            var p=amount.parentNode;
            var minus=DOM.create("<a>");
            minus.innerText="-"
            DOM.addClass(minus,"minus");
            var plus=DOM.create("<a>");
            plus.innerText="+"
            DOM.addClass(plus,"plus");
            var input=DOM.create("<input>");
            p.insertBefore(minus,amount);
            p.appendChild(plus);
            var max=amount.getAttribute('data-max') * 1;
            var now=model.getAttr("amount")*1
            amountHandle.checkAmount(amount, max, now, model, controller)
            minus.onselectstart=function(){return false;}
            plus.onselectstart=function(){return false;}
            Event.on(plus,"click",function(){
                var max=amount.getAttribute('data-max') * 1;
                var now=model.getAttr("amount")*1+1
                amountHandle.checkAmount(amount, max, now, model, controller)
            });
            Event.on(minus,"click",function(){
                var max=amount.getAttribute('data-max') * 1;
                var now=model.getAttr("amount")*1-1
                amountHandle.checkAmount(amount, max, now, model, controller)
            })
        },
        renderBundles: function(silent) { // {{{
            var self = this, model = self.model, controller = self.controller, config = model.config,
            couple = model.getAttr('couple') || [], parent = model.getAttr('cross') ? null : (model.getAttr('parent') || B.Cross),
            banOriginal = parent ? model.query('orders->' + parent + '->banlist') || [] : [],banlist = banOriginal.copy(),
            template = config.template, bundleTemplate = template['bundleList'], bundlesCon = self._getElem('bundleList'),
            optionList = [], selected = model.getAttr('bundle'), elemSelect, elemAmount,
            descTrigger = self._getElem('desc'), desc,
            filterBan = function(){
                var d = selected ? model.getAttr('bundles->' + selected + '->promos') : [];
                banlist.forEach(function(idx){
                    if (d.indexOf(idx) !== -1) {
                        banlist.splice(idx,1);
                    }
                });
            }(),
            inBanList = function(b){
                var p = model.getAttr('bundles->' + b + '->promos') || [],
                ret = false;
                    
                p.some(function(idx){
                    if(banlist.indexOf(idx) !== -1){
                        ret = true;
                        return true;
                    }
                });
                return ret;
            },
            createOptions = function() {
                var ret = [], optionTemplate = '<option value="{couple}" {selected} data-bundle={bundle}>{title}</option>',
                bundleList = model.getAttr('bundles'), k, bundleData, optionSnippet;

                desc = (bundleList && selected) && model.getAttr('bundles->' + selected + '->desc');

                if (!bundleList || utils.isEmpty(bundleList)) {
                    ret = null;
                } else {
                    if (!selected) {
                        ret.push('<option value="' + CONST['NO_PROMO_VALUE'] + '" selected="selected">' + CONST['NO_PROMO_TITLE'] + '</option>');
                    } else {
                        ret.push('<option value="' + CONST['NO_PROMO_VALUE'] + '">' + CONST['NO_PROMO_TITLE'] + '</option>');
                    }
                    for (k in bundleList) {
                        if (k !== selected && inBanList(k)) {
                            continue;
                        }
                        bundleData = bundleList[k];
                        optionSnippet = Lang.substitute(optionTemplate, bundleData, function(key) {
                            if (key === 'couple' && k === selected) {
                                return couple.join(CONST['COUPLE_SPLITER']);
                            } else if (key === 'selected') {
                                return k === selected ? 'selected="selected"' : '';
                            } else if (key === 'bundle') {
                                return k;
                            } else {
                                return bundleData[key];
                            }
                        });
                        ret.push(optionSnippet);
                    }

                    //for single none-bundle option in the bundle list
                    ret = ret[1] ? ret : null;
                }
                return ret;
            };

            if(!bundlesCon){
                return;
            }
            optionList = createOptions();
            if (optionList) {
                self._setHTML(bundlesCon,Lang.substitute(bundleTemplate, {
                    'options': optionList.join(''),
                    'uid': model.uid
                }));
                elemSelect = bundlesCon.getElementsByTagName('select')[0];
                self.elems.select = elemSelect;
                Event.on(elemSelect, 'change', function(evt) {
                    controller.select({
                        val: this.options[this.selectedIndex].getAttribute('data-bundle'),
                        previous: model.getAttr('bundle'),
                        evt: evt
                    });
                });
                if (!!desc) {
                    Dom.removeClass(descTrigger,'hidden');
                } else {
                    Dom.addClass(descTrigger,'hidden');
                }
            } else {
                self.elems && (self.elems.select = null);
                self._setHTML(bundlesCon, CONST['NO_PROMO_TITLE']);
                Dom.addClass(descTrigger,'hidden');
            }
        }, // }}}
        renderPostage: function(silent) { // {{{
            var self = this, model = self.model,
            fareEl = self._getElem('fare'), codInfoTag = self._getElem('codInfo'), sumEl = self._getElem('sum'),
            multiCOD = self._getElem('multiCOD'),
            bundle = model.getAttr('bundle'), selected = model.getAttr('postages->selected'),
            postType = model.getAttr('postType'), freedelivery = model.getAttr('bundles->' + bundle + '->freedelivery'),
            codInfo = model.getAttr('postages->list->' + selected + '->info'),
            codFare = model.getAttr('postages->fare'),codDiff = model.getAttr('postages->diff'),
            codFee = model.getAttr('postageFee'), codSum = Math.abs(codFee/100).toFixed(2),
            serviceFee = model.getAttr('serviceFee'), serviceSum = Math.abs(serviceFee/100).toFixed(2),
            factor = model.getAttr('factor'),
            emptyPlace, snippetArr = [], emptySnippet, emptyOption, optionsFragment = doc.createDocumentFragment(),
            showUnit = {};

            if(!fareEl || model.getAttr('parent')) {
                return;
            }
            emptyPlace = Dom.getElementsByClassName('J_PostageInfo','span',fareEl.parentNode)[0];

            if(postType === 'post') {
                Dom.addClass(emptyPlace,'hidden');
                fareEl.innerHTML = '';
                utils.each(model.getAttr('postages->list'),function(item,idx){
                    var option = doc.createElement('option');
                    option.setAttribute('value',idx);
                    idx === selected && option.setAttribute('selected','selected');

                    if (freedelivery) {
                        option.innerHTML = item.title + ' ' + CONST['NO_POSTAGE_FEE'];
                    } else {
                        option.innerHTML = item.title + ' ' + (item.sum/100).toFixed(2) + '元';
                    }
                    optionsFragment.appendChild(option);
                });
                fareEl.appendChild(optionsFragment);
                Dom.removeClass(fareEl, 'hidden');
            } else {
                codFare = +codFare;
                codFare = freedelivery ? 0 : codFare;

                showUnit = {
                    select_info:function(){
                        Dom.addClass(emptyPlace,'hidden');
                        Dom.removeClass(codInfoTag,'hidden');
                        Dom.removeClass(fareEl, 'hidden');
                        self._setHTML(codInfoTag,codInfo);
                        fareEl.innerHTML = '';
                        utils.each(model.getAttr('codFees'),function(item,idx){
                            var option = doc.createElement('option');

                            option.setAttribute('value',idx);
                            idx === selected && option.setAttribute('selected','selected');
                            option.innerHTML = (item/100).toFixed(2) + '元';
                            optionsFragment.appendChild(option);
                        });
                        fareEl.appendChild(optionsFragment);
                        multiCOD && (multiCOD.value = 'true');
                    },
                    select:function(){
                        Dom.addClass(codInfoTag,'hidden');
                        Dom.addClass(emptyPlace,'hidden');
                        Dom.removeClass(fareEl, 'hidden');
                        fareEl.innerHTML = '';
                        emptyOption =  doc.createElement('option');
                        emptyOption.setAttribute('value',CONST['COD_NULL_LEVEL']);
                        emptyOption.innerHTML = (codFee/100).toFixed(2) + '元';
                        fareEl.appendChild(emptyOption);

                        multiCOD && (multiCOD.value = 'false');
                    },
                    select_empty:function(){
                        Dom.addClass(codInfoTag,'hidden');
                        Dom.removeClass(emptyPlace,'hidden');
                        Dom.removeClass(fareEl, 'hidden');

                        fareEl.innerHTML = '';
                        emptyOption =  doc.createElement('option');
                        emptyOption.setAttribute('value',CONST['COD_NULL_LEVEL']);
                        emptyOption.innerHTML = (codFare/100).toFixed(2) + '元';
                        fareEl.appendChild(emptyOption);

                        if (!emptyPlace) {
                            emptyPlace = doc.createElement('span');
                            Dom.addClass(emptyPlace,'J_PostageInfo');
                            fareEl.parentNode.appendChild(emptyPlace);
                        };
                        emptySnippet = Lang.substitute(CONST['COD_PROMO_TPL'], {
                            'sum': serviceSum
                        });
                        self._setHTML(emptyPlace, emptySnippet);

                        multiCOD && (multiCOD.value = 'false');
                    },
                    // 向上取整的文案
                    // bug: http://beta.twork.taobao.net/issues/5880
                    codUp: function() {
                        Dom.addClass(fareEl, 'hidden');
                        Dom.addClass(codInfoTag,'hidden');
                        Dom.removeClass(emptyPlace,'hidden');
                        codInfoTag.innerHTML = CONST['COD_UP'];
                    },
                    empty:function(){
                        Dom.addClass(fareEl, 'hidden');
                        fareEl.innerHTML = '';
                        Dom.addClass(codInfoTag,'hidden');
                        if (!emptyPlace) {
                            emptyPlace = doc.createElement('span');
                            Dom.addClass(emptyPlace,'J_PostageInfo');
                            fareEl.parentNode.appendChild(emptyPlace);
                        }
                        Dom.removeClass(emptyPlace,'hidden');

                        if (codFee) {
                            snippetArr = [CONST['NO_POSTAGE_FEE'],Lang.substitute(CONST['COD_PROMO_TPL'], {
                                'sum': codSum
                            })];
                            emptySnippet = snippetArr.join('<br />');
                            self._setHTML(emptyPlace, emptySnippet);
                        } else {
                            emptySnippet = CONST['NO_POSTAGE_FEE'];
                        }
                        self._setHTML(emptyPlace, emptySnippet);

                        multiCOD && (multiCOD.value = 'false');
                    }
                };

                if (!!codDiff) {
                    showUnit.select_info();
                } else {
                    if (codFee > 0) {
                        showUnit.select();
                        if (factor === 0 && (model.getAttr('sum') - (model.getAttr('postageFee') || 0) < 100)) {
                            showUnit.codUp();
                        }
                    } else {
                        if (codFare === 0) {
                            showUnit.empty();
                        } else if (codFare > 0) {
                            showUnit.select_empty();
                        }
                    }
                };
            };

            Event.on(fareEl, 'change', function(evt) {
                var val = this.options[this.selectedIndex].getAttribute('value');
                if (val !== CONST['COD_NULL_LEVEL']) {
                    self.controller.selectPostage({
                        'val': val,
                        'previous': model.getAttr('postages->selected'),
                        'refresh':false
                    });
                }
            });
        }, // }}}
        renderSum: function() { // {{{
            var self = this, model = self.model, elems = self.elems, k, item, elem,
            re = /total|price|discount|sum|postageFee|deduction/,
            deduction = model.getAttr('deduction') || 0;
            for (k in elems) {
                elem = self._getElem(k);
                item = model.getAttr(k);
                //console.log(k, item);
                if (re.test(k)) {
                    item = (item / 100).toFixed(2);
                }
                if (elem && item) {
                    if (elem.tagName.toLowerCase() === 'input') {
                        if (k === 'sumInput') {
                            elem.value = (model.getAttr('sum') - deduction) || '0';
                        } else {
                            elem.value = item;
                        }
                    } else if (k === 'sum' && !!deduction){
                        if (model.getAttr('exchange')) {
                            elem.innerHTML = (item/100).toFixed(2);
                        } else {
                            elem.innerHTML = (item - deduction/100).toFixed(2);
                        }
                    } else if (k === 'point') {
                        elem.innerHTML = parseInt(item);
                    } else {
                        elem.innerHTML = item;
                    }
                }
            }
        }, // }}}
        renderExt: function(){
            var self = this, model = self.model, selected = model.getAttr('bundle'),
            gift,giftCon,giftSnippet = '<a href="{href}" target="_blank">{title}</a>', parent, temp = [];
            
            gift = model.getAttr('bundles->' + selected + '->gift');
            giftCon = self._getElem('gift');

            if (!giftCon) {
                return;
            }
            
            parent = giftCon.parentNode;
            /*check if the giftcon and bundlelist in a same container*/
            Dom.getElementsByClassName('J_BundleList','*',parent)[0] && (parent = giftCon);

            if (gift) {
                Dom.removeClass(parent,'hidden');
                gift.split(';').forEach(function(s){
                    var sp = s.split('|');
                    !sp[1] && (giftSnippet = '{title}');
                    temp.push(Lang.substitute(giftSnippet,{
                        'title':sp[0],
                        'href':sp[1]
                    }));
                    giftCon.innerHTML = temp.join(' ');
                });
            } else {
                Dom.addClass(parent,'hidden');
                giftCon.innerHTML = '';
            }
        },
        renderDesc: function(){
            var self = this, model = self.model, trigger = self._getElem('desc'),
            popupTag = self.elems.descPop, popup = Dom.get(popupTag), eliFrame;

            if (!trigger) {
                return;
            }

            if (!popup) {
                popup = doc.createElement('div');

                popup.setAttribute('id',popupTag);
                Dom.addClass(popup,'bundle-popup');
                Dom.addClass(popup,'hidden');

                popup.innerHTML = '<div class="inner"><div class="entity J_Entity"></div></div><s class="arrow"></s>'

                if (isIE6){
                    eliFrame=doc.createElement('div');
                    eliFrame.innerHTML='<iframe frameborder="0" scrolling="no"></iframe>';

                    Dom.addClass(eliFrame,'iframe');
                    Dom.setStyle(eliFrame,'opacity','0');

                    Dom.insertBefore(eliFrame,Dom.getFirstChild(popup));
                }
                doc.body.appendChild(popup);
            }

            var o = TB.widget.SimplePopup.decorate(trigger, popup, {
                autoFit: false,
                onShow: function(){
                    var bundle = model.getAttr('bundle'),
                    desc = bundle ? model.getAttr('bundles->' + bundle + '->desc') : CONST['NO_PROMO_DESC'],
                    entity = Dom.getElementsByClassName('J_Entity','div',popup)[0],
                    iframe = popup.getElementsByTagName('iframe')[0];

                    entity.innerHTML = desc;

                    if (iframe) {
                        Dom.setStyle(iframe,'height',popup.offsetHeight + 15 + 'px');
                        Dom.setStyle(iframe,'width',popup.offsetWidth + 'px');
                    };
                }
            });
        },
        render: function() { // {{{
            var self = this, model = self.model, controller = self.controller, queues = self.renderQueue;

            self.renderBundles();
            self.renderPostage();
            self.renderSum();
            self.renderExt();
            self.renderDesc();
            self.renderAmount();
            utils.each(queues,function(item,k){
                if (k === model.uid) {
                    item.forEach(function(fn){
                        try{
                            fn(self);
                        }catch(e){}
                    });
                }
            });
        } // }}}
    }); // }}}

    // Controller
    OrderController = function(model) { // {{{
        var self = this,uid;

        uid = model.uid;
        self.uid = uid;
        self.model = model;
        
        Controllers['orders'][uid] = self;
    }; // }}}
    Lang.augmentObject(OrderController.prototype, { // {{{
        select: function(o) { // {{{
            var self = this, model = self.model;

            model.changeSelected(o);
            model._async('bundle',o);
        }, // }}}
        insure: function(o){ // {{{
            var self = this, model = self.model;
            model.changeInsure(o);
        }, // }}}
        deduction:function(o){ // {{{
            var self = this, model = self.model;
            model.deduction(o);
        }, // }}}
        selectPostage: function(o) { // {{{
            // select postage
            this.model.changePostage(o);
        }, // }}}
        amount: function(o) { // {{{
            var self = this, model = self.model;

            if (!o.force && model.getAttr('amount') === o.val) {
                return;
            }
            model.changeAmount({
                val: o.val,
                silent: false
            });
        } // }}}
    }); // }}}

    // 初始化入口
    B.Models = Models; // {{{
    B.Controllers = Controllers;
    B.Views = Views;
    B.init = function(config) {
        if (!config) {
            return;
        }
        var promoData = config.promoData, orderData = config.orderData, viewsDock = [],serviceData=config.serviceData,
        mergeChunk = function() {
            var patch = orderData.orders, k, local,
            patchService=serviceData.orders,
            splitOrder = function(){
                var orders = promoData.orders,splitData = promoData.split;

                !splitData && (splitData = promoData.split = {});

                utils.each(orders,function(item){
                    var parent = item.parent, cross = item.cross, uid = item.uid, seller = item.sellerId;
                    if (seller && !parent) {
                        splitData[seller] ? splitData[seller].push(uid) : (splitData[seller] = [uid]);
                    };
                });
            };

            if (promoData) {
                local = promoData.orders;
                for (k in patch) {
                    Lang.augmentObject(local[k], patch[k]);
                }
                for (k in patchService) {
                    Lang.augmentObject(local[k], patchService[k]);
                }
            } else {
                promoData = orderData;
            }

            //create data table for the orders that be splited
            splitOrder();
        },
        serialize = function(domRef) {
            Lang.augmentObject(config,{
                form:{
                    promoForm: 'J_PromoDataForm',
                    promoData: 'J_PromoData',
                    promoOrder: 'J_PromoOrderID'
                }
            });
            var k, subOrders, crossOrder,
            instance = function(key) {
                var model = new OrderModel(promoData, key, config),
                controller = new OrderController(model),
                view = new OrderView(model, controller);
                viewsDock.push(view);
                return view;
            },
            relation = promoData.relation,
            p, r = [], pr = [];

            for (k in relation) {
                subOrders = relation[k];

                //for all item are disabled
                if (!subOrders[0]) {
                    return
                };

                if (!crossOrder && relation[subOrders[0]]) {
                    crossOrder = k;
                    continue;
                }
                subOrders.forEach(function(order,idx) {
                    r.push(instance(order));
                });
                p = instance(k);
                r.forEach(function(v) {
                    v.model.parent = p.model;
                });
                pr.push(p);
                r = [];
            }
            if (crossOrder) {
                p = instance(crossOrder);
                pr.forEach(function(v) {
                    v.model.parent = p.model;
                });
            }
        };

        mergeChunk();
        serialize();
        console.log(promoData)
        Event.onDOMReady(function() { // {{{
            var mapDom = function() {
                var ret = {},
                promoCombo = Dom.getElementsByClassName('J_PromoCombo', '*', doc.body, function(el) {
                    var uid = el.getAttribute('data-order'),
                    elems = {
                        'bundleList': 'J_BundleList',
                        'amount': 'J_Amount',
                        'price': 'J_Price',
                        'total': 'J_Total',
                        'discount': 'J_Discount',
                        'sum': 'J_Sum',
                        'sumInput': 'J_SumInput',
                        'codInfo': 'J_CodInfo',
                        'fare': 'J_Fare',
                        'gift' : 'J_Gift',
                        'point' : 'J_Point',
                        'desc': 'J_Desc',
                        'multiCOD' : 'J_AllowMultipleCodLevels'
                    },
                    k, item, o = {};

                    for (k in elems) {
                        item = Dom.getElementsByClassName(elems[k], '*', el)[0];
                        item && (o[k] = item);
                    }

                    ret[uid] = Lang.merge(ret[uid] || {},o,{
                        'descPop' : 'J_DescPopup'
                    });
                });
                return ret;
            },
            domRef = mapDom();
            viewsDock.forEach(function(item) {
                item._bindDOM(domRef);
                item.render();
            });
        }); // }}}
    }; // }}}

})(TB.Promotion);
