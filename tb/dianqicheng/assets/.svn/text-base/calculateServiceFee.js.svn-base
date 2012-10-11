/**
 * COD服务费计算，注意不含初始运费
 * @param {Number} initPayment 初始化总金额，店铺总计，含各子订单优惠后的价格，单位：分.
 * @param {Number} fare 初始化运费，单位：分.
 * @param {Number} level COD档位，单位：分.
 * @param {Array} subOrders 子订单的总价跟COD买家服务费比率, [[订单1价格，订单1比率], [订单2价格，订单2比率], ..]，单位：元.
 * @param {Boolean} all 是否返回完整用例.
 */
var calculateServiceFee = function(initPayment, fare, level, subOrders, all) {
    var isInSale = false;
    if (isInSale) return 0;

    // 验证是否是正确的数据（正整数）
    var checkInt = function(val) {
        return /^\d+$/.test(val.toString());
    };

    if (!checkInt(initPayment) || !checkInt(fare)) {
        return -1;
    }

    if (!level) {
        return fare;
    }

    var M = Math, RND = M.round, FLR = M.floor, PF = parseFloat;

    level = level.split('|');
    var r = level[1], min = level[0], max = level[2];

    // 运费为0，直接向下取整，然后返回
    if (fare === 0) {
        var m = initPayment < 100 ? 'ceil' : 'floor';
        serviceFee = -(initPayment - M[m](initPayment / 100) * 100);
        return all ? {
            serviceFee: serviceFee,
            factor: 0
        } : serviceFee;
    }

    //起步价
    var MIN = min ? RND(PF(min) * 100) : null;
    //封顶价
    var MAX = max ? RND(PF(max) * 100) : null;

    // 计算服务费比率，跟是否需要取整
    var factor = 0, sum = 0, total = 0, dofloor = true;
    for (var i = 0, l = subOrders.length; i < l; i++) {
        total += subOrders[i][0] * subOrders[i][1];
        sum += subOrders[i][0];
    }

    // 所有宝贝都不是买家100%的时候，向下取整
    for (var i = 0, l = subOrders.length; i < l; i++) {
        if (subOrders[i][1] === 100) {
            dofloor = false;
            break;
        }
    }

    factor = total / (sum * 100);

    //若卖家COD比例为空，则默认为买家承担全部COD服务费
    factor = !factor ? 0 : factor;

    // 买家比率向下取整两位，后端也是这么计算，会丢精度
    factor = M.floor(factor * 100) / 100;

    // 商品单价 * 数量 - 各种优惠之后的价格，加上COD快递费后乘以服务费率后得到初步的COD服务费
    var serviceFee = RND((initPayment + fare) * PF(r));

    // 与服务费上限做比较，取其中较小的值
    serviceFee = (MAX && serviceFee > MAX) ? MAX : serviceFee;
    // 与服务费下限做比较，取其中较大的值
    serviceFee = (MIN && serviceFee < MIN) ? MIN : serviceFee;

    // 买家应该承担的服务费金额
    serviceFee = RND(serviceFee * factor);

    // 为了使COD货款收取方便，需要取整
    // 一笔主订单下，只要有一件商品买家承担的服务费比例是100%的，
    // 就进行四舍五入的补整，即补整零头由买家服务费承担，补整金额加到运费上
    var method = '';
    if ((serviceFee + initPayment + fare) < 100) {
        method = 'ceil';
    } else if (dofloor) {
        method = 'floor';
    } else {
        method = 'round';
    }

    // 取整操作
    var totalServiceAndFee = (M[method]((serviceFee + initPayment + fare) / 100)) * 100;
    serviceFee = RND(totalServiceAndFee - initPayment - fare);

    // 与服务费上限做比较，取其中较小的值
    while (MAX && serviceFee > MAX) {
        serviceFee = RND(serviceFee - 100);
    }

    // 若买家承担100%服务费，刚再比较一次起步
    if (1 === factor && MIN && serviceFee < MIN) {
        // 与服务费下限做比较，取其中较大的值
        serviceFee = serviceFee + (FLR((MIN - 1 - serviceFee) / 100) + 1) * 100;
    }

    // 只要有一个买家100%服务费，且金额小于0，就不做这一步取整
    if (!dofloor && serviceFee < 0) {
        serviceFee += 100;
    }

    if (typeof console !== 'undefined') {
        console.log('params:', initPayment, fare, level, subOrders, all);
        console.log('result:', factor, serviceFee);
    }

    return all ? {
        factor: factor,
        serviceFee: serviceFee
    } : serviceFee;
};
