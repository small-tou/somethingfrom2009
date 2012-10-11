<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=GBK" />
        <title>交易流程商城化demo列表</title>
        <style class="demo">
            *{
                font-size:12px;
                  color:#666;
            }
            table,th,tr,td{
                border:0;
                border-collapse:collapse
            }
            table{
                width:100%;
            }
            td,th{
                border:1px dotted #89CBF2;
                padding:10px;
                margin:0;

            }
            th.time{
                width:15%;
            }
            th.owner,th.subject{
                width:15%;
            }
            th.list{
                width:80%;
            }
            .task .owner,.subject{
                background: #FFE9DA;
            }
            .time.done,.list{
                background: #DAFFDD;
            }

            .task .subject{background:none;}
            .wrap{
                margin:10px auto;
                width:80%;
            }
            ul,li{
                list-style:disc;
                list-style-position: inside;
                margin:0;
                padding:0;
            }
            em{
                font-style: normal;
                padding-right:5px;

                color:#666;
            }
            a{
                color:#36c;
                text-decoration: none;
            }
            h1.main-title{
                text-align: center;
                font-size:24px;
                font-family: 微软雅黑;
            }
            li.item{
                line-height:20px;
            }
            .item span{
                color:#F18A44;
            }
        </style>
    </head>
    <body>
        <div class="wrap">
            <h1 class="main-title">交易流程商城化demo列表</h1>
            <div style="background:#fcd3a5;padding:20px;line-height:30px;">
                <div>本次项目的前端开发有:天祁 和 治修.</div>
                <div>负责人:天祁.</div>
                <div>PM:妙风,PD:优河,设计师:龙襄,测试负责人:宋缺  ,SCM: </div>
                <div>绑定:暂时木有 </div>
                <div>时间安排:从即日起到29号陆续出前端demo,按照难度和需要跟开发的配合度确定优先级,先出优先级高的页面. </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="time">状态</th>
                        <th class="subject">文件</th>
                        <th class="list">链接</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="time">开发中</td>
                        <td class="subject">确认收货</td>
                        <td class="list">
                            <a href="http://fed.ued.taobao.net/2011/dianqicheng/shouhuo.php" target="_blank">http://fed.ued.taobao.net/2011/dianqicheng/shouhuo.php</a>
                        </td>
                    </tr>
                   <tr>
                        <td class="time">开发中</td>
                        <td class="subject">确认订单</td>
                        <td class="list">
                            <a href="http://fed.ued.taobao.net/2011/dianqicheng//conform_order.php" target="_blank">http://fed.ued.taobao.net/2011/dianqicheng//conform_order.php</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="time">开发中</td>
                        <td class="subject">订单详情</td>
                        <td class="list">
                            <a href="http://fed.ued.taobao.net/2011/dianqicheng//order-info-one.php" target="_blank">http://fed.ued.taobao.net/2011/dianqicheng//order-info-one.php</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="time">开发中</td>
                        <td class="subject">确认收货</td>
                        <td class="list">
                            <a href="http://fed.ued.taobao.net/2011/dianqicheng//shouhuo.php" target="_blank">http://fed.ued.taobao.net/2011/dianqicheng//shouhuo.php</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="time">开发中</td>
                        <td class="subject">订单详情(卖家)</td>
                        <td class="list">
                            <a href="" target="_blank"></a>
                        </td>
                    </tr>
                
                    <tr>
                        <td class="time">开发中</td>
                        <td class="subject">付款成功</td>
                        <td class="list">
                            <a href="http://fed.ued.taobao.net/2011/dianqicheng//shouhuo-success.php" target="_blank">http://fed.ued.taobao.net/2011/dianqicheng//shouhuo-success.php</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="time">开发中</td>
                        <td class="subject">确认收货成功</td>
                        <td class="list">
                              <a href="http://fed.ued.taobao.net/2011/dianqicheng//shouhuo-success.php" target="_blank">http://fed.ued.taobao.net/2011/dianqicheng//shouhuo-success.php</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <h1 class="main-title">交易流程商城化前端分工</h1>
            <table class="task">
                <thead>
                    <tr>
                        <th class="subject">功能模块/页面</th>
                        <th class="owner">负责人</th>
                        <th class="time">进度</th>
                        <th class="detail">详情</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="subject">确认订单信息页</td>
                        <td class="owner">天祁</td>
                        <td class="time ">0%</td>
                        <td class="detail">根据传过来的地址选择默认收货地址,物流宝库存信息及预计送达时间展示,特色服务展示,发票,积分,支付方式,优惠信息</td>
                    </tr>
                    <tr>
                        <td class="subject">付款成功页 </td>
                        <td class="owner">治修</td>
                        <td class="time ">0%</td>
                        <td class="detail">支付宝付款成功后跳回淘宝的付款成功页面，显示积分&会员引导信息、物流宝信息，其他同现有的页面</td>
                    </tr>
                    <tr>
                        <td class="subject">订单详情页 </td>
                        <td class="owner">天祁</td>
                        <td class="time ">0%</td>
                        <td class="detail">需要跟pd确定在哪些页面可以设置服务时间,使用服务   物流信息区块,安装信息展示安装服务的状态</td>
                    </tr>
                    <tr>
                        <td class="subject">确认收货页 </td>
                        <td class="owner">治修</td>
                        <td class="time ">0%</td>
                        <td class="detail">此页面订单信息区块同订单详情页改造后的订单信息区块</td>
                    </tr>
                    <tr>
                        <td class="subject">确认收货成功 </td>
                        <td class="owner">治修</td>
                        <td class="time ">0%</td>
                        <td class="detail"></td>
                    </tr>
                     <tr>
                        <td class="subject">订单详情(卖家看到的)</td>
                        <td class="owner">治修</td>
                        <td class="time ">0%</td>
                        <td class="detail">卖家查看的订单详情页面，展示订单包含的特色服务信息，并提供修改订单与服务关联关系的入口</td>
                    </tr>
                </tbody>
            </table>
            <h1 class="main-title">交易流程商城化前端工作量集中点</h1>
            <table class="task">
                <thead>
                    <tr>
                        <th class="subject">功能模块/页面</th>
                        <th class="owner">负责人</th>
                        <th class="time">难度系数(0-10)</th>
                        <th class="detail">详情</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="subject">确认订单信息页默认选中相应的收货地址</td>
                        <td class="owner">天祁</td>
                        <td class="time ">5</td>
                        <td class="detail"></td>
                    </tr>
                    <tr>
                        <td class="subject">确认订单信息页-将地址传入iframe,后台计算如何显示物流信息</td>
                        <td class="owner">天祁</td>
                        <td class="time ">5</td>
                        <td class="detail"></td>
                    </tr>
                    <tr>
                        <td class="subject">确认订单信息页-发票信息</td>
                        <td class="owner">天祁</td>
                        <td class="time ">2</td>
                        <td class="detail"></td>
                    </tr>
                    <tr>
                        <td class="subject">确认订单信息页-预约安装时间,选择服务 </td>
                        <td class="owner">天祁</td>
                        <td class="time ">8</td>
                        <td class="detail"></td>
                    </tr>
                    <tr>
                        <td class="subject">订单详情页-使用服务的弹窗及相关 </td>
                        <td class="owner">治修</td>
                        <td class="time ">6</td>
                        <td class="detail"></td>
                    </tr>
                    <tr>
                        <td class="subject">订单详情页(卖家)-更改服务商 </td>
                        <td class="owner">治修</td>
                        <td class="time ">6</td>
                        <td class="detail"></td>
                    </tr>
                    <tr>
                        <td class="subject">其他静态页面 </td>
                        <td class="owner">治修主要负责</td>
                        <td class="time ">4</td>
                        <td class="detail"></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </body>
</html>
