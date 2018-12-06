xh5_define("plugins.apiAppTKChart", ["utils.util"],
function(aC) {
    function aR(a) {
        a.stopPropagation()
    }
    function aN(a) {
        a.preventDefault(),
        a.stopPropagation()
    }
    function aV(a) {
        return document.createElement(a)
    }
    function aI(b, c) {
        c = c || "block";
        var a = b.style;
        b && (a.display = "none" === a.display ? c: "none")
    }
    function aE(a) {
        a.style.display = "none"
    }
    function aO(b) {
        var c, a = "undefined" == typeof getComputedStyle ? b.currentStyle: getComputedStyle(b);
        return a.height ? (c = parseFloat(a.width), "content-box" === a.boxSizing && (c = c + parseFloat(a.paddingLeft) + parseFloat(a.paddingRight) + parseFloat(a.borderLeftWidth) + parseFloat(a.borderRightWidth))) : c = b.clientWidth || parseFloat(b.style.width),
        0 | c
    }
    function aH(b) {
        var c, a = "undefined" == typeof getComputedStyle ? b.currentStyle: getComputedStyle(b);
        return a.height ? (c = parseFloat(a.height), "content-box" === a.boxSizing && (c = c + parseFloat(a.paddingTop) + parseFloat(a.paddingBottom) + parseFloat(a.borderTopWidth) + parseFloat(a.borderBottomWidth))) : c = b.clientHeight || parseFloat(b.style.height),
        0 | c
    }
    function aD(a) {
        return null === a ? "Null": void 0 === a ? "Undefined": Z.call(a).slice(8, -1)
    }
    function aK(d, f, c) {
        if (!f) {
            return d
        }
        d || (d = {});
        for (var b in f) {
            f.hasOwnProperty(b) && ("Object" === aD(f[b]) ? (!d[b] && (d[b] = {}), aK(d[b], f[b], c)) : !c && b in d || (d[b] = f[b]))
        }
        return d
    }
    function aT(b, c) {
        if (b = Number(b), isNaN(b)) {
            return "-"
        }
        var a = Math.abs(b);
        return 100000 > a ? b.toFixed(0) : 10000000 > a ? (b / 10000).toFixed(c) + "\u4e07": 100000000 > a ? (b / 10000000).toFixed(c) + "\u5343\u4e07": (b / 100000000).toFixed(c) + "\u4ebf"
    }
    function aG(a) {
        return "forex" == an(a) && (a = a.slice( - 6)),
        "BTC" == an(a) && (a = a.replace("btc_btc", "")),
        a = a.split("_"),
        a = a[a.length - 1].toUpperCase()
    }
    function aS(a) {
        return /^sh6\d{5}|sh900\d{3}|sz00\d{4}|sz30\d{4}|sz20\d{4}$/.test(a)
    }
    function aJ(d, f, c) {
        d = "prototype" in d ? d.prototype: d,
        f = "prototype" in f ? f.prototype: f;
        for (var b in f) {
            f.hasOwnProperty(b) && (c ? null != f[b] : null == d[b]) && (d[b] = f[b])
        }
        return d
    }
    function aB(a) {
        switch (a) {
        case "t1":
        case "t5":
            return "tChart";
        case "repay":
            return "repayChart";
        case "predict":
            return "predictChart";
        case "networth":
            return "netWorthChart";
        default:
            return "kChart"
        }
    }
    function aQ(d, j) {
        var c = document.createElement("ul"),
        b = j.more,
        k = b.length;
        aK(c.style, j.subNavStyle, !0),
        c.style.display = "none";
        for (var g = 0; k > g; g++) {
            var f = document.createElement("li");
            c.appendChild(f),
            aK(f.style, j.subNavItemStyle, !0),
            f.innerHTML = j.viewMap[b[g]],
            f.setAttribute("type", "subNav"),
            f.setAttribute(j.attributeName, b[g])
        }
        d.appendChild(c)
    }
    function ax(d, j) {
        var c = document.createElement("ul"),
        b = j.list,
        g = b.length;
        d.appendChild(c),
        c.style.display = "none",
        aK(c.style, j.navTopStyle, !0);
        for (var k = 0; g > k; k++) {
            var f = document.createElement("li");
            c.appendChild(f),
            aK(f.style, j.navItemStyle, !0),
            f.innerHTML = j.viewMap[b[k]],
            f.setAttribute("type", "nav"),
            "more" === b[k] ? (aQ(f, j), f.addEventListener("click",
            function() {
                aI(this.querySelector("ul"))
            })) : (f.setAttribute(j.attributeName, b[k]), f.addEventListener("click",
            function() {
                for (var h = d.querySelectorAll("li>ul"), a = h.length; a--;) {
                    aE(h[a])
                }
            }))
        }
        return c
    }
    function aL(a, b) {
        this.parent = a,
        this.param = b,
        this._init()
    }
    function ar(d, f, c) {
        var b = d.getAttribute("type");
        "nav" == b ? aK(d.style, f, !0) : "subNav" == b && aK(d.style, c, !0)
    }
    function aA(a) {
        var b = {
            t1: "touzi_wap_v2_hq_04",
            t5: "touzi_wap_v2_hq_05",
            kcl: "touzi_wap_v2_hq_06",
            dk: "touzi_wap_v2_hq_07",
            kd: "touzi_wap_v2_hq_08",
            kw: "touzi_wap_v2_hq_09",
            km: "touzi_wap_v2_hq_10",
            k5: "touzi_wap_v2_hq_11",
            k15: "touzi_wap_v2_hq_12",
            k30: "touzi_wap_v2_hq_13",
            k60: "touzi_wap_v2_hq_14"
        };
        b[a] && ak(b[a], null, "touzi_wap_v2_hq")
    }
    function az(b, c, a) {
        return b + ': <span style="color: ' + a + '">' + c + "</span>"
    }
    function ad(a) {
        return - 1 == ["HF", "forex_yt", "forex"].indexOf(a)
    }
    function aU(a, b) {
        this.parent = a,
        this.param = b,
        this._init(),
        this.simple(!0)
    }
    function aP(d, f) {
        if ("LI" == d.target.nodeName) {
            for (var c = d.target,
            b = this.querySelectorAll("li"), g = b.length; g--;) {
                aK(b[g].style, f.itemNormalStyle, !0),
                b[g].setAttribute("selected", "false")
            }
            aK(c.style, f.itemActiveStyle, !0),
            c.setAttribute("selected", "true")
        }
    }
    function ay(a, b) {
        this.parent = a,
        this.param = b,
        this._init(),
        this.isShow = !0,
        this.hide()
    }
    function aW(a, b) {
        this.parent = a,
        this.param = b,
        this._init()
    }
    function aj(d, f) {
        var c = !1,
        b = an(d);
        switch (b) {
        case "BTC":
        case "forex":
        case "forex_yt":
            f.on("viewChange",
            function(e) {
                if (f.kChart) {
                    if ("k1" === e) {
                        if (f.kChart.setLineStyle({
                            linetype: "line"
                        }), !c) {
                            var h = new Date,
                            g = 60 * h.getTimezoneOffset() * 1000;
                            h.setTime(h.getTime() + g),
                            h.setHours(h.getHours() + 4),
                            f.kChart.dateFromTo(h, new Date(99999, 9, 9)),
                            KKE.api("patch.forex.newhqtime", {
                                symbol: d,
                                timeSymbol: "sys_time",
                                interval: 30,
                                offset: 30
                            },
                            function(a) {
                                a && f.kChart.pushData({
                                    symbol: d,
                                    data: a
                                })
                            }),
                            c = !0,
                            f.hideKTechM("MA")
                        }
                    } else {
                        f.kChart.setLineStyle({
                            linetype: "solid"
                        })
                    }
                }
            })
        }
    }
    function au(a, g) {
        this.parent = a,
        this.param = g;
        var k = aV("div"),
        f = k.style;
        aK(f, g.style, !0);
        var d = aV("div"),
        i = d.style;
        aK(i, g.zoomInStyle, !0),
        d.addEventListener("click",
        function(c) {
            a.chart.chart.zoom(!0),
            aN(c)
        }),
        k.appendChild(d);
        var b = aV("div"),
        j = b.style;
        aK(j, g.zoomOutStyle, !0),
        b.addEventListener("click",
        function(c) {
            a.chart.chart.zoom(!1),
            aN(c),
            ai(a, "zoom")
        }),
        k.appendChild(b),
        this.dom = k,
        a.param.wrap.dom.appendChild(k)
    }
    function am(b, f) {
        this.parent = b,
        this.param = f;
        var a = aV("div"),
        g = a.style;
        aK(g, f.closeBoxStyle, !0);
        var d = aV("div"),
        c = d.style;
        aK(c, f.closeStyle, !0),
        d.addEventListener("click",
        function() {
            window.h5chart.closeClickChart()
        }),
        a.appendChild(d),
        this.dom = a,
        b.param.wrap.dom.appendChild(a)
    }
    function aq(b, f) {
        this.parent = b,
        this.param = f;
        var a = aV("div"),
        g = aV("div"),
        d = a.style,
        c = g.style;
        aK(d, f.style, !0),
        d.width = b._calcChartWidth() + "px",
        d.height = b._calcChartHeight() + "px",
        c.width = "100%",
        c.height = "100%",
        c.position = "absolute",
        c.background = "rgba(0,0,0)",
        c.zIndex = "999",
        c.top = 0,
        this.maskDom = g,
        this.parent.chart.dom.appendChild(g)
    }
    function ac(b, c) {
        this.parent = b,
        this.param = c;
        var a = {
            eventid: c.key || "universal_callup",
            subname: c.value || "chart_CN_bs",
            uatrackKey: c.key || "universal_callup",
            androidInstallUrl: c.apk || "//file.apo51.cn/finapp/apks/apifinance_h5chart.apk",
            needOpenSource: !1
        };
        this.sfc = null,
        "undefined" != typeof apiFinanceCallUp && (this.sfc = new apiFinanceCallUp.CallUpapiFinance(a))
    }
    function at(a, f) {
        this.parent = a,
        this.param = f;
        var i = this,
        d = aV("div"),
        c = d.style;
        aK(c, f.style, !0);
        var g, b = {
            eventid: "callup_zhengu",
            subname: "fromWapHq",
            uatrackKey: "callup_zhengu",
            needOpenSource: !1
        };
        "undefined" != typeof apiFinanceCallUp && (g = new apiFinanceCallUp.CallUpapiFinance(b)),
        d.addEventListener("click",
        function(j) {
            var k = "//finance.api.cn/finance_zt/financeapp/hqzg.shtml?stockcode=@symbol".replace("@symbol", i.parent.symbol),
            h = aS(i.parent.symbol) ? k: "//finance.api.cn/finance_zt/financeapp/znzg.shtml";
            g && g.tryDirectCall({
                callpagetype: "2",
                subtype: "1",
                symbol: i.parent.symbol,
                position: "fromwaphq",
                iostoh5: h,
                isDownload: !1,
                callfailUrl: h,
                openBrowser: function() {
                    window.open(h, "_self")
                }
            }),
            ak("dsjzg", null, "hq_center_hs"),
            aN(j)
        }),
        this.dom = d,
        a.param.wrap.dom.appendChild(d)
    }
    function ai(d, f, c) {
        var b = d.param.callUpApp;
        1 != b.isCall && (0 == b.isSE ? b.SEList.indexOf(f) > -1 && b.callBack && b.callBack({
            pos: b.pix + d.market + "_" + c,
            key: "universal_callup",
            androidurl: b.bag
        }) : b.noSEList.indexOf(f) > -1 && b.callBack && b.callBack({
            pos: b.pix + d.market + "_" + c,
            key: "universal_callup",
            androidurl: b.bag
        }))
    }
    function aw(a) {
        for (var b = al.length; b--;) {
            if (a.match(al[b])) {
                return ! 0
            }
        }
        return ! 1
    }
    function ao(a) {
        a.chart.kInitParam.theme.K_RISE = "#00a800",
        a.chart.kInitParam.theme.K_FALL = "#f11200",
        a.chart.kInitParam.theme.T_RISE = "#00a800",
        a.chart.kInitParam.theme.T_FALL = "#f11200",
        a.chart.tInitParam.theme.K_RISE = "#00a800",
        a.chart.tInitParam.theme.K_FALL = "#f11200",
        a.chart.tInitParam.theme.T_RISE = "#00a800",
        a.chart.tInitParam.theme.T_FALL = "#f11200",
        a.info.upColor = "#00a800",
        a.info.downColor = "#f11200"
    }
    function ah(a) {
        return ["sh000001", "sz399001", "sz399006", "sz399415", "sz399416", "sz399300", "sz000300"].indexOf(a) > -1
    }
    function ae(b) {
        for (var c = ["USDTRY", "USDZAR", "AUDUSD", "USDCAD", "USDCHF", "USDCNH", "CZKUSD", "DKKUSD", "EURUSD", "GBPUSD", "USDHKD", "USDHUF", "ILSUSD", "USDINR", "USDJPY", "USDMXN", "MYRUSD", "USDNOK", "NZDUSD", "PLNUSD", "USDRUB", "SEKUSD", "SGDUSD", "ARSUSD", "USDPHP", "USDKRW", "USDIDR"], a = c.length; a--;) {
            if (b === "fx_s" + c[a].toLowerCase()) {
                return ! 0
            }
        }
        return ! 1
    }
    function ap(d, f, c) {
        var b = an(f);
        if (c) {
            d.tab.list = ["networth", "repay"],
            d.chart.initView = "networth",
            Number(c.flashType[1]) && (d.tab.list.unshift("predict"), d.chart.initView = "predict"),
            Number(c.flashType[0]) && (d.tab.list.unshift("more"), d.chart.initView = "t1"),
            d.tab.more = ["t1", "t5", "kd", "kw", "km"],
            d.tab.viewMap.more = "\u884c\u60c5\u8d70\u52bf",
            d.info.toFixedNum = 4
        } else {
            switch (b) {
            case "CN":
                if (aS(f)) {
                    d.tech.kChart.rek = [ - 1, 0, 1];
                    var g = decodeURIComponent(aF.load("hqchart_type"));
                    g = "null" === g ? 0 : Number(g.replace('"rek', "").replace(/"/g, "")),
                    d.chart.kChart.setReK = g
                }
                d.tab.list = ["t1", "t5", "kd", "kw", "km", "more"];
                break;
            case "HK":
                d.tab.list = ["t1", "kcl", "kd", "kw", "km"],
                d.chart.kInitParam.rate = 0,
                d.chart.tInitParam.rate = 0,
                d.info.toFixedNum = 3,
                ao(d);
                break;
				    case "option_cn":
                d.tab.list = ["t1",  "kd", "kw", "km","kcl"],
                d.chart.kInitParam.rate = 0,
                d.chart.tInitParam.rate = 0,
                d.info.toFixedNum = 3,
                ao(d);
                break;
            case "US":
                ao(d);
                break;
            case "global_index":
                d.tab.list = ["t1", "kcl", "kd", "kw", "km"],
                d.chart.tChart.tCharts = [{
                    name: "MACD"
                }],
                d.chart.kChart.tCharts = [{
                    name: "MACD"
                }],
                d.tech.tChart.pCharts = [],
                d.tech.tChart.tCharts = ["null", "MACD", "BOLL", "RSI", "BBIBOLL", "ROC", "TRIX", "DMA", "EXPMA", "BIAS", "VR"],
                d.tech.kChart.pCharts = ["MA", "BBIBOLL", "BOLL", "EXPMA", "SAR"],
                d.tech.kChart.tCharts = ["null", "MACD", "ASI", "BIAS", "BRAR", "CCI", "DMA", "DMI", "KDJ", "PSY", "ROC", "RSI", "SAR", "TRIX", "WR"];
                break;
            case "forex":
            case "forex_yt":
                d.tab.list = ["k1", "kd", "kw", "km", "more"],
                d.tab.more = "forex_yt" === b ? ["k5", "k30"] : ["k5", "k15", "k30", "k60", "k240"],
                d.chart.initView = ae(f) ? "k1": "kd",
                d.chart.kInitParam.nfloat = 4,
                d.chart.kInitParam.newthour = "forex_yt" === b ? 6 : 7,
                d.chart.kChart.tCharts = [{
                    name: "MACD"
                }],
                d.chart.kChart.pCharts = [],
                d.tech.kChart.pCharts = ["MA", "BBIBOLL", "BOLL", "EXPMA", "SAR"],
                d.tech.kChart.tCharts = ["null", "MACD", "ASI", "BIAS", "BRAR", "CCI", "DMA", "DMI", "KDJ", "PSY", "ROC", "RSI", "SAR", "TRIX", "WR"],
                d.info.toFixedNum = 4,
                d.chart.kChart.showRangeSelector = {
                    display: !1
                },
                ao(d);
                break;
            case "BTC":
                d.tab.list = "btc_btcokcoin" === f ? ["kd", "k15","kw", "km"] : ["k1","k15", "kd", "kw", "km"],
                d.tab.more = ["k15"],
                d.chart.initView = "btc_btcokcoin" === f ? "kd": "k1",
                d.chart.kInitParam.nfloat = 2,
                d.chart.kInitParam.newthour = 0,
                d.chart.kChart.tCharts = [{
                    name: "MACD"
                }],
                d.chart.kChart.pCharts = [],
                d.info.toFixedNum = 2,
                d.chart.kChart.showRangeSelector = {
                    display: !1
                },
                ao(d);
                break;
            case "HF":
                d.chart.tChart.tCharts = [{
                    name: "MACD"
                }],
                d.chart.kChart.tCharts = [{
                    name: "MACD"
                }],
                d.tech.tChart.pCharts = [],
                d.tech.tChart.tCharts = ["null", "MACD", "BOLL", "RSI", "BBIBOLL", "ROC", "TRIX", "DMA", "EXPMA", "BIAS", "VR"],
                d.tech.kChart.pCharts = ["MA", "BBIBOLL", "BOLL", "EXPMA", "SAR"],
                d.tech.kChart.tCharts = ["null", "MACD", "ASI", "BIAS", "BRAR", "CCI", "DMA", "DMI", "KDJ", "PSY", "ROC", "RSI", "SAR", "TRIX", "WR"],
                d.tab.list = ["t1", "kcl", "kd", "kw", "km"],
                d.chart.tChart.showScale = "pct",
                d.chart.tInitParam.tchartobject = {
                    t: ["MACD", "BOLL", "RSI", "BBIBOLL", "ROC", "TRIX", "DMA", "EXPMA", "BIAS", "VR"]
                },
                d.chart.kInitParam.tchartobject = {
                    k: ["MACD", "ASI", "BIAS", "BRAR", "CCI", "DMA", "DMI", "KDJ", "PSY", "ROC", "RSI", "SAR", "TRIX", "WR"]
                },
                ~ ["hf_ES"].indexOf(f) ? d.info.toFixedNum = 2 : ~ ["hf_DXF", "hf_SF", "hf_CD", "hf_JY", "hf_BP", "hf_EC"].indexOf(f) ? (d.info.toFixedNum = 4, d.info.percentToFixedNum = 4) : d.info.toFixedNum = 3;
                break;
            case "NF":
                d.tab.list = ["t1", "t5", "kd", "k30", "k60", "more"],
                d.tab.more = ["k5", "k15", "kcl", "kw", "km"],
                d.chart.tChart.showScale = "pct",
                d.tech.tChart.tCharts = ["null", "TVOL", "POSITION", "LB", "MACD", "BOLL", "RSI", "BBIBOLL", "ROC", "TRIX", "DMA", "EXPMA", "BIAS", "VR"];
                break;
            case "OTC":
                "sb899001" === f ? (d.tab.list = ["kcl", "kd", "kw", "km"], d.chart.initView = "kcl") : d.tab.list = ["t1", "kcl", "kd", "kw", "km"]
            }
        }
    }
    function ag(d, f) {
        Q.call(this);
        var c = d.chart.symbol,
        b = this;
        if (this.symbol = d.chart.symbol, d.chart.isFund) {
            var g = "https://app.xincai.com/fund/api/jsonp.json/$cb/XinCaiFundService.getFlashDataStep1?symbol=$symbol&___qn=1";
            g = g.replace("$cb", "var%20FundData=").replace("$symbol", c),
            aa(g,
            function() {
                d.chart.isFund = FundData,
                ap(aM, c, FundData),
                b._init(d)
            })
        } else {
            ap(aM, c),
            this._init(d, f)
        }
    }
    function af() {
        return window.chart ? "vertical" == window.chart.direction: !1
    }
    function ab() {
        this.VERSION = "1.2.12",
        this.get = function(d, c) {
            function b(a) {
                f.off(a, b),
                aC.isFunc(c) && c(f)
            }
            var f = new ag(d, c);
            f.on("AppTKChartLoaded", b, !1)
        }
    }
    var an = aC.market,
    ak = aC.suda,
    aa = aC.load,
    aF = aC.localSL,
    Z = Object.prototype.toString,
    Q = function() {
        var a = Array.prototype.slice,
        b = function() {
            this.eventList = {}
        };
        return b.prototype = {
            constructor: b,
            on: function(f, g, d, c) {
                var h = this.eventList;
                return g && f ? (h[f] || (h[f] = []), h[f].push({
                    handler: g,
                    one: c,
                    ctx: d || this
                }), this) : this
            },
            one: function(d, f, c) {
                this.on(d, f, c, !0)
            },
            off: function(f, h) {
                var d = this.eventList;
                if (!f) {
                    return this.eventList = {},
                    this
                }
                if (h) {
                    if (d[f]) {
                        for (var c = [], j = 0, g = d[f].length; g > j; j++) {
                            d[f][j].handler != h && c.push(d[f][j])
                        }
                        d[f] = c
                    }
                    d[f] && 0 === d[f].length && delete d[f]
                } else {
                    delete d[f]
                }
            },
            trigger: function(j) {
                if (this.eventList[j]) {
                    var d = arguments,
                    c = d.length;
                    c > 3 && (d = a.call(d, 1));
                    for (var k = this.eventList[j], g = k.length, f = 0; g > f;) {
                        switch (c) {
                        case 1:
                            k[f].handler.call(k[f].ctx);
                            break;
                        case 2:
                            k[f].handler.call(k[f].ctx, d[1]);
                            break;
                        case 3:
                            k[f].handler.call(k[f].ctx, d[1], d[2]);
                            break;
                        default:
                            k[f].handler.apply(k[f].ctx, d)
                        }
                        k[f].one ? (k.splice(f, 1), g--) : f++
                    }
                }
                return this
            }
        },
        b
    } ();
    aL.prototype = {
        constructor: aL,
        _init: function() {
            var b, c = this.param,
            a = this.parent,
            d = aV("div");
            aK(d.style, c.style, !0),
            a.param.wrap.dom.appendChild(d),
            this.nav = ax(d, this.param),
            this.dom = d,
            b = this.nav.querySelector("[" + c.attributeName + "=" + a.param.chart.initView + "]"),
            ar(b, c.navItemActiveStyle, c.subNavItemActiveStyle),
            this.selectedView = b,
            this.resize(),
            this.bindClickEvent()
        },
        setStyle: function() {
            this.nav.style.display = "block",
            this.resize()
        },
        setView: function(d) {
            var f = this.param,
            c = d,
            b = this.nav.querySelector("[" + f.attributeName + "=" + c + "]");
            ar(this.selectedView, f.navItemStyle, f.subNavItemStyle),
            this.selectedView = b,
            ar(b, f.navItemActiveStyle, f.subNavItemActiveStyle)
        },
        bindClickEvent: function() {
            var d, f = this,
            c = this.param,
            b = this.parent;
            this.nav.addEventListener("click",
            function(j) {
                var g = j.target,
                e = g.getAttribute(c.attributeName);
                if (e) {
                    if (location.origin.match("touzi") && aA(e), b.chart) {
                        if ("app" === e) {
                            return void(b.bsCallUp && b.bsCallUp.call())
                        }
                        if (b.chart.showView(e), "dk" === e) {
                            ah(f.parent.symbol) ? (b.chart.chart.showKTechM("DPDK"), b.chart.chart.switchKTech("DPDKS")) : (b.chart.chart.showKTechM("TZY"), b.chart.chart.switchKTech("TZYS")),
                            b.tech && b.tech.hide()
                        } else {
                            if (b.chart.chart.hideKTechM("TZY"), b.chart.chart.hideKTechM("DPDK"), b.tech) {
                                switch (b.chart.chart.getChartType()) {
                                case "tChart":
                                    b.tech.param.tChart.show && "vertical" != b.direction ? (b.tech.show(), b.tech.switchTechList("tChart")) : b.tech.hide();
                                    break;
                                case "kChart":
                                    if (b.tech.param.kChart.show && "vertical" != b.direction ? (b.tech.show(), b.tech.switchTechList("kChart")) : b.tech.hide(), "dk" === d) {
                                        var i = f.parent.tech.kChart.tCharts.querySelector("[selected=true]");
                                        i && b.chart.chart.switchKTech(i.getAttribute("value"))
                                    }
                                    if ("k1" === e) {
                                        b.chart.chart.hideKTechM("MA")
                                    } else {
                                        var a = f.parent.tech.kChart.pCharts.querySelector("[selected=true]");
                                        a && "MA" === a.getAttribute("value") && b.chart.chart.showKTechM("MA")
                                    }
                                    break;
                                default:
                                    b.tech.hide()
                                }
                            }
                        }
                        b.resize(),
                        d = e
                    }
                    ar(f.selectedView, c.navItemStyle, c.subNavItemStyle),
                    ar(g, c.navItemActiveStyle, c.subNavItemActiveStyle),
                    f.selectedView = g
                }
            })
        },
        resize: function() {
            for (var d = this.nav,
            f = this.nav.querySelectorAll("ul li"), c = this.param.list, b = aO(d) / c.length, g = f.length; g--;) {
                f[g].style.width = b + "px"
            }
        },
        moveTo: function(a) {
            var b = this.nav.querySelector("li>ul");
            "bottom" == a ? (this.parent.param.wrap.dom.appendChild(this.dom), aK(this.nav.style, this.param.navBottomStyle, !0), b && (b.style.bottom = "100%")) : (this.parent.param.wrap.dom.insertBefore(this.dom, this.parent.param.wrap.dom.firstChild), aK(this.nav.style, this.param.navTopStyle, !0), b && (b.style.bottom = ""))
        }
    };
    var G = ["t", "k", "netWorth", "repay", "predict"];
    aU.prototype = {
        constructor: aU,
        _init: function() {
            var b = this.parent,
            c = this.param,
            a = aV("div"),
            d = a.style;
            aK(d, this.isSimple ? c.simpleStyle: c.completeStyle, !0),
            this.dom = a,
            b.param.wrap.dom.appendChild(a),
            this._initDoms()
        },
        simple: function(b) {
            "undefined" == typeof b && (b = !0);
            var c = this.param;
            if (this.isSimple = b, b) {
                aK(this.dom.style, c.simpleStyle, !0),
                this.doms.nameBox.style.display = "none",
                this.doms.price.style.display = "none";
                for (var a = G.length; a--;) {
                    aK(this.doms[G[a] + "Detail"].style, c.simpleDetailStyle, !0)
                }
            } else {
                for (aK(this.dom.style, c.completeStyle, !0), this.doms.nameBox.style.display = "block", this.doms.price.style.display = "block", a = G.length; a--;) {
                    aK(this.doms[G[a] + "Detail"].style, c.completeDetailStyle, !0)
                }
            }
        },
        _initDoms: function() {
            function o(d, v) {
                var i = aV("div");
                g.appendChild(i),
                a.doms[d + "Detail"] = i;
                for (var e = 0; v > e; e++) {
                    var u = aV("div"),
                    r = u.style;
                    g.appendChild(u),
                    aK(r, k[d + "DetailItemStyle"], !0),
                    r.lineHeight = aH(u) + "px",
                    i.appendChild(u)
                }
            }
            var k = this.param,
            g = aV("div"),
            f = g.style,
            a = this;
            this.doms = {},
            f.height = "100%",
            f.width = "100%",
            this.dom.appendChild(g);
            var j = aV("div");
            g.appendChild(j),
            aK(j.style, k.nameBoxStyle, !0),
            this.doms.nameBox = j;
            var q = aV("div");
            j.appendChild(q),
            aK(q.style, k.nameStyle, !0),
            this.doms.name = q;
            var m = aV("div");
            j.appendChild(m),
            aK(m.style, k.symbolStyle, !0),
            this.doms.symbol = m;
            var b = aV("div"),
            l = b.style;
            return g.appendChild(b),
            aK(b.style, k.priceStyle, !0),
            l.lineHeight = aH(b) + "px",
            this.doms.price = b,
            o("t", 6),
            o("k", 6),
            o("netWorth", 2),
            o("repay", 1),
            o("predict", 3),
            this.doms.dom = g,
            g
        },
        _displayNoneExcept: function(a) {
            for (var b = G.length; b--;) {
                G[b] !== a && (this.doms[G[b] + "Detail"].style.display = "none")
            }
        },
        _showDetailInfo: function(y, v, q) {
            var x, g, b = v.percent,
            u = this.param,
            f = u.toFixedNum,
            z = this.param.percentToFixedNum,
            k = u.upColor,
            c = u.downColor,
            w = u.levelColor;
            if ("tChart" == y) {
                this._displayNoneExcept("t"),
                x = this.doms.tDetail,
                g = v.price / (1 + b),
                x.childNodes[0].innerHTML = az("\u4ef7", v.price.toFixed(f), b > 0 ? k: 0 > b ? c: w),
                x.childNodes[1].innerHTML = az("\u5747", isNaN(v.avg_price) ? "-": v.avg_price.toFixed(f), v.avg_price > g ? k: v.avg_price < g ? c: w),
                x.childNodes[2].innerHTML = az("\u5e45", (100 * b).toFixed(z) + "%", b > 0 ? k: 0 > b ? c: w),
                x.childNodes[3].innerHTML = this.parent.hasVolume ? "\u91cf: " + aT(v.volume, 2) : ""
            } else {
                if ("kChart" == y) {
                    this._displayNoneExcept("k"),
                    x = this.doms.kDetail,
                    g = v.close / (1 + b),
                    x.childNodes[0].innerHTML = az("\u5f00", v.open.toFixed(f), v.open > g ? k: v.open < g ? c: w),
                    x.childNodes[1].innerHTML = az("\u9ad8", v.high.toFixed(f), v.high > g ? k: v.high < g ? c: w),
                    x.childNodes[2].innerHTML = az("\u5e45", (100 * b).toFixed(z) + "%", b > 0 ? k: 0 > b ? c: w),
                    x.childNodes[3].innerHTML = az("\u6536", v.close.toFixed(f), b > 0 ? k: 0 > b ? c: w),
                    x.childNodes[4].innerHTML = az("\u4f4e", v.low.toFixed(f), v.low > g ? k: v.low < g ? c: w),
                    x.childNodes[5].innerHTML = this.parent.hasVolume ? "\u91cf: " + aT(v.volume, 2) : ""
                } else {
                    if ("netWorthChart" == y) {
                        this._displayNoneExcept("netWorth"),
                        x = this.doms.netWorthDetail,
                        q.length > 1 && (x.childNodes[0].innerHTML = az(q[0].name, q[0].data.close.toFixed(u.toFixedNum)), x.childNodes[1].innerHTML = az(q[1].name, q[1].data.close.toFixed(u.toFixedNum)))
                    } else {
                        if ("repayChart" === y) {
                            this._displayNoneExcept("repay"),
                            x = this.doms.repayDetail;
                            var j = "";
                            this.parent.tab.param.viewMap && this.parent.tab.param.viewMap.repay && (j = this.parent.tab.param.viewMap.repay),
                            x.childNodes[0].innerHTML = az(j || "\u5386\u53f2\u56de\u62a5", v.close.toFixed(u.toFixedNum))
                        } else {
                            "predictChart" === y && (this._displayNoneExcept("predict"), x = this.doms.predictDetail, g = v.price / (1 + b), x.childNodes[0].innerHTML = az("\u4f30", v.price.toFixed(f), b > 0 ? k: 0 > b ? c: w), x.childNodes[1].innerHTML = az("\u5747", isNaN(v.avg_price) ? "-": v.avg_price.toFixed(f), v.avg_price > g ? k: v.avg_price < g ? c: w), x.childNodes[2].innerHTML = az("\u5e45", (100 * b).toFixed(z) + "%", b > 0 ? k: 0 > b ? c: w))
                        }
                    }
                }
            }
            x.style.display = "block"
        },
        _showSimple: function(b, c) {
            var a = b.data;
            b.interacting ? (this.dom.style.display = "block", this._showDetailInfo(c, a, b.data_array)) : this.dom.style.display = "none"
        },
        _showComplete: function(l, j) {
            var f, k = this.param,
            d = this.doms.price,
            b = this.doms.symbol,
            g = this.doms.name,
            c = l.data,
            m = this.parent.chart.param.isFund;
            g.innerHTML = m ? m.name: l.curname,
            b.innerHTML = aG(this.parent.param.chart.symbol),
            f = c.percent,
            d.style.color = f > 0 ? k.upColor: 0 > f ? k.downColor: k.levelColor,
            this._showDetailInfo(j, c, l.data_array),
            d.innerHTML = "tChart" == j ? c.price.toFixed(k.toFixedNum) : "kChart" == j ? c.close.toFixed(k.toFixedNum) : ""
        },
        show: function(a, b) {
            this[this.isSimple ? "_showSimple": "_showComplete"](a, b)
        }
    },
    ay.prototype = {
        constructor: ay,
        _init: function() {
            var b = this.parent,
            c = this.param,
            a = aV("div"),
            d = a.style;
            aK(d, c.style, !0),
            this.dom = a;
            this._initTechList("tChart"),
            this._initTechList("kChart");
            this.switchTechList(aB(b.param.chart.initView)),
            this.resize(),
            b.param.wrap.dom.appendChild(a)
        },
        switchTechStyle: function(d, g) {
            for (var c = this.param,
            b = g.Indicator,
            h = this[d].tCharts.querySelectorAll("li"), f = h.length; f--;) {
                aK(h[f].style, c.itemNormalStyle, !0),
                h[f].setAttribute("selected", "false"),
                h[f].getAttribute("value") === b.name && aK(h[f].style, c.itemActiveStyle, !0)
            }
            g.Indicator.name != this.parent.chart.param.tChart.tCharts[0].name && g.Indicator.name != this.parent.chart.param.kChart.tCharts[0].name && ai(this.parent, "tech", d + "_" + g.Indicator.name)
        },
        switchTechList: function(a) {
            this.tChart && (this.tChart.dom.style.display = "none"),
            this.kChart && (this.kChart.dom.style.display = "none"),
            ("tChart" == a || "kChart" == a) && (this[a] ? this[a].dom.style.display = "block": this._initTechList(a), this.isShow = !0)
        },
        _initTechList: function(l) {
            var j, f, d, a = this.parent,
            g = this.dom,
            b = this.param,
            m = aV("div"),
            k = m.style;
            return this[l] = {},
            k.width = "100%",
            k.height = "100%",
            b[l].rek && b[l].rek.length && (j = this._initOneList(m, b[l].rek, a.param.chart[l].setReK), j.addEventListener("click",
            function(c) {
                aP.call(this, c, b),
                a.chart.chart.setReK(c.target.getAttribute("value")),
                aF.save("hqchart_type", "rek" + c.target.getAttribute("value"))
            })),
            f = this._initOneList(m, b[l].pCharts, a.param.chart[l].pCharts, !0),
            f.addEventListener("click",
            function(h) {
                var c = h.target;
                "LI" == h.target.nodeName && ("true" == c.getAttribute("selected") ? (c.setAttribute("selected", "false"), aK(c.style, b.itemNormalStyle, !0), a.chart.chart["tChart" == l ? "hideTTechM": "hideKTechM"](c.getAttribute("value"))) : (c.setAttribute("selected", "true"), aK(c.style, b.itemActiveStyle, !0), a.chart.chart["tChart" == l ? "showTTechM": "showKTechM"](c.getAttribute("value"))), ai(a, "tech", l + "_" + c.getAttribute("value")))
            }),
            d = this._initOneList(m, b[l].tCharts, a.param.chart[l].tCharts, !0),
            d.addEventListener("click",
            function(c) {
                aP.call(this, c, b),
                a.chart.chart["tChart" == l ? "switchTTech": "switchKTech"](c.target.getAttribute("value"))
            }),
            this[l].rek = j,
            this[l].pCharts = f,
            this[l].tCharts = d,
            this[l].dom = m,
            g.appendChild(m),
            m
        },
        _initOneList: function(v, q, k, g) {
            var a = aV("ul"),
            l = this.param,
            f = l.techMap;
            aK(a.style, l.boxStyle, !0);
            for (var u = 0,
            b = q.length; b > u; u++) {
                var s = aV("li");
                if (s.innerHTML = f[q[u]] ? f[q[u]] : q[u], s.setAttribute("value", q[u]), "Array" == aD(k)) {
                    aK(s.style, l.itemNormalStyle, !0);
                    for (var j = k.length; j--;) {
                        if (k[j].name == q[u]) {
                            aK(s.style, l.itemActiveStyle, !0),
                            g && s.setAttribute("selected", "true");
                            break
                        }
                    }
                } else {
                    q[u] == k ? aK(s.style, l.itemActiveStyle, !0) : aK(s.style, l.itemNormalStyle, !0)
                }
                a.appendChild(s)
            }
            return v.appendChild(a),
            a
        },
        resize: function() {
            var l, j, f = this.tChart,
            k = this.kChart,
            d = this.parent._calcChartHeight(),
            b = 42,
            g = 0.5,
            c = 0.5,
            m = 3;
            l = 3 * b,
            this.dom.style.height = d + "px",
            f && (f.pCharts.style.height = d * g + "px", f.tCharts.style.height = d * c + "px"),
            k && (k.rek ? (j = d - l, b * m > j && (j = d > b * m ? m * b: d, l = d - j), k.rek.style.height = l + "px") : j = d, k.pCharts.style.height = j * g + "px", k.tCharts.style.height = j * c + "px")
        },
        show: function() {
            this.dom.style.display = "block",
            this.isShow = !0
        },
        hide: function() {
            this.dom.style.display = "none",
            this.isShow = !1
        }
    },
    aW.prototype = {
        constructor: aW,
        _init: function() {
            this._initWrap();
            var b = this,
            c = this.parent,
            a = this.param;
            KKE.api("plugins.lightTKChart.get", aK(a, {
                dom: this.childDom,
                kInitParam: {
                    onviewprice: function(d) {
                        c.info.show(d, "kChart")
                    },
                    ontechchanged: function(d) {
                        c.tech.switchTechStyle("kChart", d)
                    },
                    onshortclickmain: function() {
                        af()
                    }
                },
                tInitParam: {
                    onviewprice: function(d) {
                        c.info.show(d, "tChart")
                    },
                    ontechchanged: function(d) {
                        c.tech.switchTechStyle("tChart", d)
                    },
                    onshortclickmain: function() {
                        af()
                    }
                },
                netWorthInitParam: {
                    onviewprice: function(d) {
                        c.info.show(d, "netWorthChart")
                    }
                },
                repayInitParam: {
                    onviewprice: function(d) {
                        c.info.show(d, "repayChart")
                    }
                },
                predictInitParam: {
                    onviewprice: function(d) {
                        c.info.show(d, "predictChart")
                    }
                }
            },
            !0),
            function(d) {
                b.chart = d,
                b.parent.trigger("AppTKChartLoaded", null),
                b.parent.tab.setStyle(),
                aj(a.symbol, d)
            })
        },
        _initWrap: function() {
            var b = this.parent,
            f = this.param,
            a = b.param.wrap.dom,
            j = aV("div"),
            d = aV("div"),
            c = j.style,
            g = d.style;
            aK(c, f.style, !0),
            c.position = "relative",
            c.width = b._calcChartWidth() + "px",
            c.height = b._calcChartHeight() + "px",
            g.width = "100%",
            g.height = "100%",
            this.dom = j,
            this.childDom = d,
            j.appendChild(d),
            a.appendChild(j)
        },
        resize: function() {
            var b = this.dom,
            c = b.style,
            a = this.parent;
            c.width = a._calcChartWidth() + "px",
            c.height = a._calcChartHeight() + "px",
            this.chart && this.chart.resize()
        },
        showView: function(a, b) {
            this.chart && (this.chart.showView("dk" == a ? "kd": a), ai(this.parent, a, a), this.currentView = a),
            b && this.parent.tab.setView(b)
        }
    },
    au.prototype = {
        moveTo: function(a, b) {
            this.dom.style.right = a,
            this.dom.style.bottom = b
        }
    },
    am.prototype = {
        show: function() {
            this.dom.style.display = "block"
        },
        hide: function() {
            this.dom.style.display = "none"
        }
    },
    aq.prototype = {
        show: function() {
            this.maskDom.style.display = "block"
        },
        hide: function() {
            this.maskDom.style.display = "none"
        }
    },
    ac.prototype = {
        call: function() {
            this.sfc && this.sfc.tryDirectCall({
                callpagetype: "2",
                symbol: this.parent.symbol,
                position: this.param.value || "chart_CN_bs"
            })
        }
    },
    at.prototype = {
        moveTo: function(a, b) {
            this.dom.style.right = a,
            this.dom.style.bottom = b
        }
    };
    var aM = {
        tab: {
            list: ["t1", "t5", "kd", "kw", "km", "more"],
            more: ["kcl", "k5", "k15", "k30", "k60"],
            viewMap: {
                t1: "\u5206\u65f6",
                t5: "\u4e94\u65e5",
                kd: "\u65e5K",
                kw: "\u5468K",
                km: "\u6708K",
                kcl: "\u5e74\u7ebf",
                k1: "1\u5206",
                k5: "5\u5206",
                k15: "15\u5206",
                k30: "30\u5206",
                k60: "60\u5206",
                k240: "4\u5c0f\u65f6",
                more: "\u66f4\u591a",
                dk: "B/S\u70b9",
                app: "B/S\u70b9",
                predict: "\u51c0\u503c\u9884\u6d4b",
                networth: "\u5386\u53f2\u51c0\u503c",
                repay: "\u5386\u53f2\u56de\u62a5"
            },
            style: {
                "float": "left",
                width: "100%",
                height: "35px",
                lineHeight: "35px",
                textAlign: "center",
                fontSize: "14px",
                backgroundColor: "#F0F0F0",
                listStyle: "none"
            },
            navTopStyle: {
                width: "100%",
                height: "100%",
                listStyle: "none"
            },
            navBottomStyle: {
                margin: "auto",
                width: "80%",
                height: "100%",
                listStyle: "none"
            },
            navItemStyle: {
                position: "relative",
                "float": "left",
                listStyle: "none",
                height: "35px",
                color: "#000",
                backgroundColor: "",
                borderBottom: "",
                boxSizing: "border-box",
                webkitBoxSizing: "border-box"
            },
            navItemActiveStyle: {
                color: "#0099ff",
                backgroundColor: "#fff",
                borderBottom: "2px solid #0099ff"
            },
            subNavStyle: {
                position: "absolute",
                width: "100%",
                zIndex: 999,
                listStyle: "none"
            },
            subNavItemStyle: {
                color: "#000",
                backgroundColor: "#F0F0F0"
            },
            subNavItemActiveStyle: {
                color: "#0099ff",
                backgroundColor: "#E8E8E8"
            },
            attributeName: "data-view"
        },
        chart: {
            symbol: "sh000001",
            initView: "t1",
            style: {
                "float": "left",
                width: "90%"
            },
            kInitParam: {
                theme: {},
                dim: {
                    H_T_G: 45
                },
                candlenum: 50
            },
            tInitParam: {
                theme: {},
                dim: {
                    H_T_G: 45
                }
            },
            netWorthInitParam: {
                theme: {
                    K_CL: "#00c1eb"
                },
                dual: {
                    theme: {
                        K_CL: "#fe6623"
                    }
                },
                rate: 0,
                nfloat: 4
            },
            repayInitParam: {
                theme: {
                    K_CL: "#987654"
                },
                rate: 0,
                nfloat: 4
            },
            predictInitParam: {
                nfloat: 4
            },
            kChart: {
                setCustom: {
                    allow_indicator_edit: !0,
                    storage_lv: 2,
                    touch_prevent: !1
                },
                setReK: 0,
                tCharts: [{
                    name: "VOLUME"
                }],
                pCharts: [{
                    name: "MA"
                }]
            },
            tChart: {
                setCustom: {
                    allow_indicator_edit: !0,
                    storage_lv: 2,
                    touch_prevent: !1
                },
                tCharts: [{
                    name: "TVOL"
                }],
                pCharts: []
            },
            netWorthChart: {},
            repayChart: {},
            predictChart: {
                tCharts: [{
                    name: "ADL"
                }]
            }
        },
        info: {
            simpleStyle: {
                width: "100%",
                height: "35px",
                paddingTop: "",
                lineHeight: "15px",
                textAlign: "left",
                display: "none",
                position: "absolute",
                color: "#000",
                backgroundColor: "#fff",
                boxSizing: "content-box",
                webkitBoxSizing: "content-box"
            },
            completeStyle: {
                width: "100%",
                height: "40px",
                paddingTop: "5px",
                lineHeight: "",
                textAlign: "left",
                "float": "left",
                display: "block",
                position: "",
                color: "#000",
                backgroundColor: "#F0F0F0",
                boxSizing: "content-box",
                webkitBoxSizing: "content-box"
            },
            nameBoxStyle: {
                "float": "left",
                width: "20%",
                height: "100%",
                paddingLeft: "10px",
                boxSizing: "border-box",
                webkitBoxSizing: "border-box"
            },
            nameStyle: {
                fontSize: "17px",
                color: "black",
                height: "24px",
                lineHeight: "24px",
                textOverflow: "ellipsis",
                overflow: "hidden",
                whiteSpace: "nowrap"
            },
            symbolStyle: {
                fontSize: "13px",
                color: "#999999",
                height: "16px",
                lineHeight: "16px"
            },
            priceStyle: {
                "float": "left",
                width: "25%",
                height: "100%",
                fontSize: "26px"
            },
            simpleDetailStyle: {
                "float": "left",
                width: "90%",
                height: "100%",
                fontSize: "13px",
                marginLeft: "10%"
            },
            completeDetailStyle: {
                "float": "left",
                width: "55%",
                marginLeft: "",
                height: "100%",
                fontSize: "13px"
            },
            tDetailItemStyle: {
                "float": "left",
                width: "50%",
                height: "50%"
            },
            kDetailItemStyle: {
                "float": "left",
                width: "33%",
                height: "50%"
            },
            netWorthDetailItemStyle: {
                "float": "left",
                width: "50%",
                height: "100%"
            },
            repayDetailItemStyle: {
                width: "100%",
                height: "100%"
            },
            predictDetailItemStyle: {
                "float": "left",
                width: "33%",
                height: "100%"
            },
            upColor: "#f11200",
            downColor: "#00a800",
            levelColor: "black",
            toFixedNum: 2,
            percentToFixedNum: 2
        },
        tech: {
            show: !0,
            style: {
                width: "10%",
                "float": "left"
            },
            boxStyle: {
                width: "100%",
                textAlign: "center",
                borderTop: "1px solid #888",
                overflowY: "auto",
                backgroundColor: "#F0F0F0",
                fontSize: "12px",
                listStyle: "none",
                margin: 0,
                padding: 0
            },
            kChart: {
                show: !0,
                tCharts: ["null", "VOLUME", "ASI", "BIAS", "BRAR", "CCI", "DMA", "DMI", "EMV", "KDJ", "MACD", "OBV", "PSY", "ROC", "RSI", "SAR", "TRIX", "VR", "WR", "WVAD", "EMV"],
                pCharts: ["VOLUME", "MA", "BBIBOLL", "BOLL", "EXPMA", "SAR"]
            },
            tChart: {
                show: !0,
                tCharts: ["null", "TVOL", "LB", "MACD", "BOLL", "RSI", "BBIBOLL", "ROC", "TRIX", "DMA", "EXPMA", "BIAS", "VR"],
                pCharts: ["VOLUME"]
            },
            itemNormalStyle: {
                color: "#000",
                padding: "10px 0"
            },
            itemActiveStyle: {
                color: "#09f",
                padding: "10px 0"
            },
            techMap: {
                "null": "\u65e0",
                "-1": "\u524d\u590d\u6743",
                0 : "\u4e0d\u590d\u6743",
                1 : "\u540e\u590d\u6743",
                VOLUME: "\u6210\u4ea4\u91cf",
                TVOL: "\u6210\u4ea4\u91cf",
                POSITION: "\u6301\u4ed3\u91cf",
                LB: "\u91cf\u6bd4"
            }
        },
        wrap: {
            style: {
                position: "relative",
                height: "100%",
                width: "100%",
                overflow: "hidden",
                webkitTouchCallout: "none",
                webkitUserSelect: "none",
                mozUserSelect: "none",
                msUserSelect: "none",
                userSelect: "none",
                webkitTapHighlightColor: "rgba(0,0,0,0)"
            }
        },
        zoomBar: {
            show: !0,
            style: {
                position: "absolute",
                bottom: 0,
                right: 0,
                width: "70px",
                height: "30px",
                overflow: "hidden",
                zIndex: 998
            },
            zoomOutStyle: {
                width: "30px",
                height: "30px",
                backgroundPosition: "0 0",
                backgroundRepeat: "no-repeat",
                backgroundSize: "100%",
                "float": "right",
                backgroundImage: "url(style/images/icon_add.png)"
            },
            zoomInStyle: {
                width: "30px",
                height: "30px",
                backgroundPosition: "0 0",
                backgroundRepeat: "no-repeat",
                backgroundSize: "100%",
                "float": "left",
                backgroundImage: "url(style/images/icon_subtract.png)"
            }
        },
        closeBtn: {
            show: !1,
            closeBoxStyle: {
                padding: 0,
                bottom: 0,
                right: 0,
                position: "absolute",
                background: "#F0F0F0",
                textAlign: "center",
                overflow: "hidden",
                width: "35px",
                height: "35px"
            },
            closeStyle: {
                width: "20px",
                height: "20px",
                backgroundPosition: "0 0",
                backgroundRepeat: "no-repeat",
                backgroundSize: "100%",
                backgroundImage: "url(style/images/iconclose2x.png)",
                margin: "8px 5px"
            }
        },
        mask: {
            show: !1
        },
        clinicStock: {
            show: 0,
            style: {
                position: "absolute",
                bottom: 0,
                right: 0,
                width: "30px",
                height: "31px",
                overflow: "hidden",
                zIndex: 998,
                backgroundPosition: "0 0",
                backgroundRepeat: "no-repeat",
                backgroundSize: "100%",
                "float": "right",
                backgroundImage: "url(//n.apiimg.cn/finance/201706cn/icon_zhen.png)"
            }
        },
        callUpApp: {
            isCall: 1,
            isSE: 1,
            pix: "chart_",
            bag: "//file.apo51.cn/finapp/apks/apifinance_h5chart.apk",
            SEList: ["km", "kw", "k5", "k15", "k30", "k60", "k240", "zoom", "tech"],
            noSEList: ["t5", "k1", "kd", "kw", "km", "kcl", "k5", "k15", "k30", "k60", "k240", "zoom", "tech"],
            callBack: null
        },
        bsCallUp: {
            show: !1,
            value: "",
            key: "",
            apk: "//file.apo51.cn/finapp/apks/apifinance_h5chart.apk"
        }
    },
    al = [],
    av = ag.prototype;
    return av._init = function(i) {
        var a = this.symbol;
        this.param = aK(i, aM),
        this.market = an(a),
        this.hasVolume = ad(this.market);
        var k = this.param.wrap.dom;
        if (aK(k.style, this.param.wrap.style, !0), k.addEventListener("click", aR), k.addEventListener("touchstart", aR), k.addEventListener("touchmove", aR), aw(window.location.href) && 1 != aC.localSL.load("tipToApp", "cookie")) {
            aC.localSL.save("tipToApp", !0, {
                mode: "cookie",
                expires: 10
            });
            var g = aV("div"),
            x = g.style;
            x.position = "absolute",
            x.left = "50%",
            x.top = "50%",
            x.width = "300px",
            x.height = "140px",
            x.marginLeft = "-150px",
            x.marginTop = "-90px",
            x.backgroundColor = "rgba(0, 0, 0, 0.8)",
            x.zIndex = "999";
            var t = aV("span"),
            e = t.style;
            e.display = "inline-block",
            e.width = "100%",
            e.height = "100px",
            e.lineHeight = "100px",
            e.textAlign = "center",
            e.color = "#fff",
            e.borderBottom = "1px solid #959595",
            t.innerHTML = "\u524d\u5f80\u65b0\u6d6a\u8d22\u7ecf\u5ba2\u6237\u7aef\u67e5\u770b\u5b8c\u6574\u884c\u60c5",
            g.appendChild(t);
            var q = aV("span"),
            j = q.style;
            j.display = "inline-block",
            j["float"] = "left",
            j.width = "50%",
            j.height = "40px",
            j.lineHeight = "40px",
            j.textAlign = "center",
            j.color = "#fff",
            q.innerHTML = "\u6682\u4e0d\u524d\u5f80",
            g.appendChild(q);
            var w = aV("span"),
            l = w.style;
            l.display = "inline-block",
            l["float"] = "left",
            l.width = "50%",
            l.height = "40px",
            l.lineHeight = "40px",
            l.textAlign = "center",
            l.color = "#fff",
            w.innerHTML = "\u7acb\u5373\u524d\u5f80",
            g.appendChild(w),
            k.appendChild(g),
            x.display = "none",
            k.addEventListener("click",
            function(c) {
                x.display = "block",
                c && aN(c)
            }),
            w.addEventListener("click",
            function() {
                x.display = "none",
                k.removeChild(g),
                window.location = "apifinance://type=2&stocktype=cn&symbol=" + a,
                setTimeout(function() {
                    window.location = "https://stock.api.com.cn/iphone/jump?type=2&stocktype=cn&symbol=" + a
                },
                1000)
            }),
            q.addEventListener("click",
            function() {
                x.display = "none",
                k.removeChild(g)
            })
        }
        this.tab = new aL(this, i.tab),
        this.info = new aU(this, i.info),
        i.tech.show && (this.tech = new ay(this, i.tech)),
        this.chart = new aW(this, i.chart),
        i.zoomBar.show && (this.zoomBar = new au(this, i.zoomBar)),
        i.closeBtn.show && (this.closeBtn = new am(this, i.closeBtn)),
        i.mask.show && (this.mask = new aq(this, i.mask));
        var v = /^sz100\d{3}|sz101\d{3}|sz106\d{3}|sz107\d{3}|sz108\d{3}|sz109\d{3}|sz111\d{3}|sz112\d{3}|sz115\d{3}|sz12\d{4}|sz13\d{4}$/,
        b = /^sh020\d{3}|sh20\d{4}|sh1\d{5}|sh009\d{3}|sh010\d{3}|^sh019\d{3}$/;
        "CN" === this.market && (v.test(this.symbol) || b.test(this.symbol) || i.clinicStock.show && (this.clinicStock = new at(this, i.clinicStock)), i.bsCallUp.show && (this.bsCallUp = new ac(this, i.bsCallUp))),
        this.setDirection("vertical")
    },
    av.setDirection = function(b) {
        var c = this.chart.chart ? this.chart.chart.currentView: this.chart.param.initView,
        a = aB(c);
        "vertical" == b ? (this.tech && this.tech.hide(), this.tab.moveTo("top"), this.info.simple(!0), this.zoomBar && this.zoomBar.moveTo(this.clinicStock ? "50px": "10px", "35px"), this.clinicStock && this.clinicStock.moveTo("10px", "35px"), this.closeBtn && this.closeBtn.hide(), this.mask && this.mask.show()) : (this.tech && ("dk" == c ? this.tech.hide() : ("tChart" === a ? this.tech.param.tChart.show && this.tech.show() : "kChart" === a && this.tech.param.kChart.show && this.tech.show(), this.tech.switchTechList(aB(c)))), this.tab.moveTo("bottom"), this.info.simple(!1), this.zoomBar && this.zoomBar.moveTo(this.clinicStock ? "50px": "10px", "70px"), this.clinicStock && this.clinicStock.moveTo("10px", "70px"), this.closeBtn && this.closeBtn.show(), this.mask && this.mask.hide()),
        this.direction = b,
        this.resize(),
        this.update()
    },
    av.setCustom = function(a) {
        this.chart && this.chart.chart ? this.chart.chart.setCustom(a) : (aK(this.param.chart.kChart.setCustom, a, !0), aK(this.param.chart.tChart.setCustom, a, !0))
    },
    av.resize = function() {
        this.tab && this.tab.resize(),
        this.tech && this.tech.isShow && this.tech.resize(),
        this.chart && this.chart.resize()
    },
    av.appendTo = function(a) {
        a.appendChild(this.param.wrap.dom),
        this.resize()
    },
    av.update = function() {
        this.chart && this.chart.chart && this.chart.chart.update()
    },
    av.pushData = function(a, b) {
        this.chart && this.chart.chart && this.chart.chart.pushData(a, b)
    },
    av._calcChartHeight = function() {
        var a = this.param.wrap.dom,
        b = aH(a);
        return this.tab && (b -= aH(this.tab.dom)),
        this.info && !this.info.isSimple && (b -= aH(this.info.dom)),
        b
    },
    av._calcChartWidth = function() {
        var a = this.param.wrap.dom,
        b = aO(a);
        return this.tech && this.tech.isShow && (b = b - aO(this.tech.dom) - 1),
        b
    },
    window.shortClickChart = af,
    aJ(ag, Q),
    ab
});