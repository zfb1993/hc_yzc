!
function(b) {
    function a(d) {
        if (c[d]) {
            return c[d].exports
        }
        var e = c[d] = {
            exports: {},
            id: d,
            loaded: !1
        };
        return b[d].call(e.exports, e, e.exports, a),
        e.loaded = !0,
        e.exports
    }
    var c = {};
    return a.m = b,
    a.c = c,
    a.p = "",
    a(0)
} ([function(b, a, c) {
    c(1),
    c(8),
    c(11),
    c(7),
    b.exports = c(9)
},
function(f, d) {
    var h = window,
    c = document,
    g = function(i, a) {
        var j = i = i || {};
        return j._callEventCom = {},
        j._callReadyEvent = {},
        j.callEvent = {
            on: function(m, l) {
                var o = j._callEventCom.hasOwnProperty(m),
                k = j._callReadyEvent.hasOwnProperty(m);
                o || (j._callEventCom[m] = l),
                k && (callEvent.trigger(m, j._callReadyEvent[m]), delete j._callReadyEvent[m])
            },
            trigger: function(l, k) {
                var m = j._callEventCom.hasOwnProperty(l);
                m ? j._callEventCom[l](k) : j._callReadyEvent[l] = k
            }
        },
        j.jsonp = function(A) {
            function G(r) {
                var p, m = [],
                s = /%20/g;
                for (var l in r) {
                    p = r[l].toString(),
                    m.push(h.encodeURIComponent(l).replace(s, "+") + "=" + h.encodeURIComponent(p).replace(s, "+"))
                }
                return m.join("&")
            }
            function q(l) {
                return "[object Function]" === H.call(l)
            }
            function E(m) {
                var l = (new Date).getTime() + Math.floor(100000 * Math.random());
                return m ? m + "" + l: l
            }
            function k(m, l) {
                var o = c.createElement("script");
                return o.src = m,
                l && (o.charset = l),
                o.async = !0,
                B(o),
                w ? C.insertBefore(o, w) : C.appendChild(o),
                o
            }
            var H = Object.prototype.toString,
            C = c.getElementsByTagName("head")[0] || c.documentElement,
            w = C.getElementsByTagName("base")[0],
            F = /^(?:loaded|complete|undefined)/,
            B = function(m, l) {
                m.onload = m.onreadystatechange = function() {
                    F.test(m.readyState) && (m.onload = m.onreadystatechange = null, C.removeChild(m), m = null)
                }
            },
            n = A.jsonp || "callback",
            z = E("jsonpcallback"),
            x = n + "=" + z,
            D = window.setTimeout(function() {
                q(A.ontimeout) && A.ontimeout()
            },
            5000);
            window[z] = function(e) {
                window.clearTimeout(D),
                q(A.onsuccess) && A.onsuccess(e)
            };
            var v = A.url.indexOf("?") > 0 ? "&": "?";
            A.data ? k(A.url + v + G(A.data) + "&" + x, A.charset) : k(A.url + v + x, A.charset)
        },
        j.ajax = function(m) {
            function l(q) {
                var p = [];
                for (var r in q) {
                    p.push(encodeURIComponent(r) + "=" + encodeURIComponent(q[r]))
                }
                return p.push(("v=" + Math.random()).replace(".", "")),
                p.join("&")
            }
            m = m || {},
            m.type = (m.type || "GET").toUpperCase(),
            m.dataType = m.dataType || "json";
            var o = l(m.data);
            if (window.XMLHttpRequest) {
                var k = new XMLHttpRequest
            } else {
                var k = new ActiveXObject("Microsoft.XMLHTTP")
            }
            k.onreadystatechange = function() {
                if (4 == k.readyState) {
                    var e = k.status;
                    e >= 200 && e < 300 ? m.success && m.success(k.responseText, k.responseXML) : m.fail && m.fail(e)
                }
            },
            "GET" == m.type ? (k.open("GET", m.url + "?" + o, !0), k.send(null)) : "POST" == m.type && (k.open("POST", m.url, !0), k.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), k.send(o))
        },
        j.pageVisibility = function() {
            var m, l = function(o, n) {
                return "" !== o ? o + n.slice(0, 1).toUpperCase() + n.slice(1) : n
            },
            q = function() {
                var e = !1;
                return "number" == typeof window.screenX && ["webkit", "moz", "ms", "o", ""].forEach(function(n) {
                    0 == e && void 0 != document[l(n, "hidden")] && (m = n, e = !0)
                }),
                e
            } (),
            k = function() {
                if (q) {
                    return document[l(m, "hidden")]
                }
            },
            p = function() {
                if (q) {
                    return document[l(m, "visibilityState")]
                }
            };
            return {
                hidden: k(),
                visibilityState: p(),
                isSupport: q,
                visibilitychange: function(n, e) {
                    if (e = !1, q && "function" == typeof n) {
                        return document.addEventListener(m + "visibilitychange",
                        function(o) {
                            this.hidden = k(),
                            this.visibilityState = p(),
                            n.call(this, o)
                        }.bind(this), e)
                    }
                }
            }
        } (void 0),
        j.checkUA = {
            _UA: navigator.userAgent.toLowerCase(),
            UAIdentify: {
                weibo: "weibo",
                qq: "qq/",
                qqmobile: "mqqbrowser",
                uc: "ucbrowser/",
                weixin: "micromessenger",
                chrome: "chrome",
                apinews: "apinews",
                apifinance: "apifinance",
                aliPay: "alipayclient",
                ios9: "iphone os 9_",
                ios10: "iphone os 10_",
                ios360: "qhbrowser",
                ios1002: "iphone os 10_0_2"
            },
            OpenTypeIdentify: {
                noIntent: /aliapp|360 aphone|redmi note|weibo|windvane|ucbrowser|baidubrowser|huaweiknt-al20|mqqbrowser|h60-l01|vivo|huaweitag-al00|mxb48t|xiaomibrowser|oppobrowser|sm-g9350/,
                hasIntent: /samsung/,
                speciallIntent: /r7plusm/
            },
            RegExpTest: function(l, k) {
                return l.test(k)
            },
            getOpentype: function() {
                var w = "",
                B = this,
                p = B._UA,
                v = B.OpenTypeIdentify,
                m = B.isWeixin(),
                z = (B.isChrome(), B.isIOS9()),
                k = (!m && B.isQQ(), B.isWeibo(), B.isIos360()),
                C = B._system(),
                y = B.RegExpTest(v.hasIntent, p),
                q = B.RegExpTest(v.noIntent, p),
                A = B.RegExpTest(v.speciallIntent, p),
                x = A || !q && y && "android" == C;
                return z ? w = "op001": "android" == C ? w = x ? "op004": "op002": "ios" == C && (w = k ? "op003": "op002"),
                w
            },
            getWeiboVersion: function() {
                var m = this._UA,
                l = this.UAIdentify,
                o = m.split("__" + l.weibo + "__"),
                k = o.length > 1 ? o[1] : "0.0.0";
                return this.getVersion(k)
            },
            getapiFinanceVersion: function() {
                var p = this._UA,
                m = this.UAIdentify,
                r = p.split(m.apifinance + "__"),
                l = r.length > 1 ? r[1] : "0.0.0__",
                q = l.split("__"),
                k = q.length > 1 ? k[0] : "0.0.0";
                return k
            },
            getVersion: function(l) {
                var k = l.split("."),
                m = 0;
                return m = parseFloat(k[0] + "." + parseInt(k[1]))
            },
            getAndroidVersion: function() {
                var l = this._UA,
                k = l.match(/android\s?[\d.]+/gi)[0],
                m = k.split(" ")[1];
                return m
            },
            getIosVersion: function() {
                var m = this._UA,
                l = "",
                o = m.match(/os (\d+)_(\d+)_?(\d+)?/),
                k = o ? o[0].split(" ")[1] : 0;
                return "" != k && (l = k.split("_")[0]),
                l
            },
            isInclude: function(l, k) {
                return l.indexOf(k) > -1
            },
            isIos1002: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.ios1002);
                return !! k
            },
            isIos360: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.ios360);
                return !! k
            },
            isUC: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.uc);
                return !! k
            },
            isapiNews: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.apinews);
                return !! k
            },
            isapiFinance: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.apifinance);
                return !! k
            },
            isWeibo: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.weibo);
                return !! k
            },
            isQQ: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.qq);
                return !! k
            },
            isWeixin: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.weixin);
                return !! k
            },
            isChrome: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.chrome);
                return !! k
            },
            isQQBrowswer: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.qqmobile);
                return !! k
            },
            isAliPay: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.aliPay);
                return !! k
            },
            isIOS9: function() {
                var k = this.getIosVersion() - 0;
                return k > 8
            },
            isIOS10: function() {
                var l = this.UAIdentify,
                k = this.isInclude(this._UA, l.ios10);
                return !! k
            },
            _system: function() {
                var k = this._UA;
                return k.match(/iphone|ipod/gi) ? "ios": "android"
            },
            getBrowserName: function() {
                var p = "",
                m = this,
                r = (m._UA, m.isWeixin()),
                l = !r && m.isQQ(),
                q = m.isWeibo(),
                k = m.isapiFinance();
                m.isUC(),
                m.isIos360(),
                m.isQQBrowswer();
                return p = r ? "weixin": l ? "QQ": q ? "weibo": k ? "apifinance": "browser"
            },
            getFullNumber: function(l) { ! l && (l = 1);
                var k = l.toString().length;
                return (k < 3 || 3 == k) && (l = ("000" + l).substr( - 3, 3)),
                l
            }
        },
        j.bindEventForApp = function(l, k, m) {
            document.addEventListener ? l.addEventListener(k, m, !0) : l.attachEvent(k, m)
        },
        j.stopDefault = function(k) {
            k = k || window.event,
            k.preventDefault ? k.preventDefault() : k.returnValue = !1
        },
        j._addParams = function(l, k) {
            return l + (l.indexOf("?") === -1 ? "?": "&") + k
        },
        j.showWeiXinTips = function() {
            var n = "j_callupTips_bg",
            w = {
                ios: "ios",
                android: "android"
            },
            q = h.callupTips || {
                android: "" + window.prtl.prefix + ("http" == window.prtl.type ? "n.apiimg.cn": "ns.apiimg.cn") + "/dae7ff0c/20151013/popup_android.png",
                ios: "" + window.prtl.prefix + ("http" == window.prtl.type ? "n.apiimg.cn": "ns.apiimg.cn") + "/dae7ff0c/20151013/popup_ios.png"
            },
            k = c.querySelector("." + n),
            x = c.createElement("section");
            if (k) {
                k = c.querySelector("." + n),
                k.style.display = "block"
            } else {
                var p = new Array,
                m = "" + window.prtl.prefix + "u1.apiimg.cn/upload/2014/12/19/102181.png",
                v = 100,
                o = j.checkUA._system();
                q && (o == w.android && (m = q.android), o == w.ios && (m = q.ios), v = "100%"),
                p.push('<a class="j_share_wx" href="javascript:;">'),
                p.push("<span></span>"),
                p.push("</a>"),
                p.push('<a class="goback" href="javascript:;">'),
                p.push("</a>"),
                p.push('<div class="share_bg ' + n + '" style="position:fixed;display:block;left:0;top:0;width:100%;height:100%;z-index:10009; background:rgba(0,0,0,.6);-webkit-animation:opacityIn 1s .2s ease both;">'),
                p.push('<p class="share_icon" style="clear:both; padding:10px; text-align:right;height:100%;background-position: right top; -webkit-animation:rotateUp 1s .8s ease both;z-index:9999;"><img src="' + m + '" alt="" width="' + v + '" /></p>'),
                p.push("</div>"),
                x.innerHTML = p.join(""),
                c.body.appendChild(x),
                k = c.querySelector("." + n),
                k.onclick = function() {
                    "none" != k.style.display && (k.style.display = "none", j.callEvent && j.callEvent.trigger("api_clear_lock"))
                }
            }
        },
        j.extend = function(q, w, m) {
            q = q || {};
            var p, l = typeof w,
            v = 1;
            for ("undefined" !== l && "boolean" !== l || (m = "boolean" === l && w, w = q, q = this), "object" != typeof w && "[object Function]" !== Object.prototype.toString.call(w) && (w = {}); v <= 2;) {
                if (p = 1 === v ? q: w, null !== p) {
                    for (var k in p) {
                        var x = q[k],
                        u = p[k];
                        q !== u && (m && u && "object" == typeof u && !u.nodeType ? q[k] = this.extend(x || (null !== u.length ? [] : {}), u, m) : void 0 !== u && (q[k] = u))
                    }
                }
                v++
            }
            return q
        },
        j.Clz = function(m) {
            var l = "___ytreporp___",
            o = function() {
                this.init.apply(this, arguments)
            };
            if (m) {
                var k = function() {};
                k.prototype = m.prototype,
                o.prototype = new k
            }
            return o.prototype.init = function() {},
            o.prototype.set = function(v, y) {
                this[l] || (this[l] = {});
                for (var q, w = 0,
                p = this[l], u = v.split("."), t = u.length, x = t - 1; w < t;) {
                    q = u[w],
                    w == x && (p[q] = y),
                    void 0 === p[q] && (p[q] = {}),
                    p = p[q],
                    w++
                }
            },
            o.prototype.get = function(v) {
                this[l] || (this[l] = {});
                for (var x, q = 0,
                w = this[l], p = v.split("."), u = p.length, t = u - 1; q < u;) {
                    if (x = p[q], q == t) {
                        return w[x]
                    }
                    void 0 === w[x] && (w[x] = {}),
                    w = w[x],
                    q++
                }
            },
            o.fn = o.prototype,
            o.fn.parent = o,
            o._super = o.__proto__,
            o.extend = function(q) {
                var p = q.extended;
                for (var n in q) {
                    o[n] = q[n]
                }
                p && p(o)
            },
            o.include = function(q) {
                var p = q.included;
                for (var n in q) {
                    o.fn[n] = q[n]
                }
                p && p(o)
            },
            o
        },
        i
    } (g || {},
    window.jQuery || window.Zepto),
    b = function(i, a) {
        i = i || {};
        return i
    } (b || {},
    window.jQuery || window.Zepto);
    window.apiFinanceCallUp = b,
    apiFinanceCallUp.util = g,
    f.exports = g
},
function(h, d, k) {
    var c = k(1),
    j = k(3),
    b = k(5),
    g = k(4),
    f = {
        _getDataInfo: function(q) {
            var i, w, u, p, m, v = {};
            if (i = new b({
                screen_resolution: !0,
                canvas: !0
            }).get(), u = c.checkUA._system(), "android" == u) {
                var a = c.checkUA.getAndroidVersion();
                w = window.screen.width + "x" + a
            } else {
                w = window.screen.width + "x" + window.screen.height
            }
            return p = q.iosNativeUrl || q.androidNativeUrl,
            m = document.title,
            v = {
                fpId: i,
                resolution: w,
                platform: u,
                url: p,
                title: m
            }
        },
        initClipboardEvent: function(i) {
            var a = new g("." + i.className);
            a.on("success",
            function(e) {
                i.onSuccess && i.onSuccess(e)
            }),
            a.on("error",
            function(e) {
                i.onError && i.onError(e)
            })
        },
        copyText: function(m) {
            var l = document.createElement("textarea"),
            o = "rtl" == document.documentElement.getAttribute("dir");
            l.style.fontSize = "12pt",
            l.style.border = "0",
            l.style.padding = "0",
            l.style.margin = "0",
            l.style.position = "absolute",
            l.style[o ? "right": "left"] = "-9999px";
            var a = window.pageYOffset || document.documentElement.scrollTop;
            l.style.top = a + "px",
            l.setAttribute("readonly", ""),
            l.value = m,
            document.body.appendChild(l),
            l.select(),
            l.setSelectionRange(0, l.value.length),
            document.execCommand("copy"),
            document.body.removeChild(l)
        },
        send: function(o, l, p) {
            var i = this,
            m = {};
            m = JSON.stringify(i._getDataInfo(o)),
            c.ajax({
                url: j.finance.apis.deferrerLink,
                type: "POST",
                data: {
                    data: m
                },
                dataType: "json",
                success: function(a) {
                    l && l(a)
                },
                fail: function(a) {
                    p && p(a)
                }
            })
        }
    };
    h.exports = f
},
function(b, a) {
    window.prtl = {
        type: "http:" == window.location.protocol ? "http": "http",
        prefix: "http:" == window.location.protocol ? "//": "//"
    };
    var c = {
        finance: {
            type: "finance",
            head: "apifinance",
            ios9http: "//stock.api.com.cn/iphone/jump",
            iosInstallUrl: "" + window.prtl.prefix + "itunes.apple.com/cn/app/xin-lang-cai-jing-zheng-quan/id430165157?mt=8",
            androidInstallUrl: "" + window.prtl.prefix + "apo51.cn/mobile/comfinanceweb.shtml",
            wxUrl: "" + window.prtl.prefix + "apo51.cn/mobile/comfinanceweb.shtml",
            weiboSlience: "apiweibo://appsdownload?APPID=138578",
            androidOpenTime: 3000,
            iosOpenTime: 800,
            isDownload: !0,
            callback: function() {},
            downloadCallback: function() {},
            openBrowser: null,
            golink: "",
            apis: {
                deferrerLink: "" + window.prtl.prefix + "cj.api.cn/api/access_records/submit"
            }
        }
    };
    b.exports = c
},
function(c, b, d) {
    var a, a;
    /*!
	 * clipboard.js v1.5.16
	 * //zenorocha.github.io/clipboard.js
	 *
	 * Licensed MIT © Zeno Rocha
	 */
    !
    function(e) {
        c.exports = e()
    } (function() {
        var g;
        return function f(k, m, l) {
            function h(o, q) {
                if (!m[o]) {
                    if (!k[o]) {
                        var e = "function" == typeof a && a;
                        if (!q && e) {
                            return a(o, !0)
                        }
                        if (j) {
                            return j(o, !0)
                        }
                        var n = new Error("Cannot find module '" + o + "'");
                        throw n.code = "MODULE_NOT_FOUND",
                        n
                    }
                    var p = m[o] = {
                        exports: {}
                    };
                    k[o][0].call(p.exports,
                    function(r) {
                        var s = k[o][1][r];
                        return h(s ? s: r)
                    },
                    p, p.exports, f, k, m, l)
                }
                return m[o].exports
            }
            for (var j = "function" == typeof a && a,
            i = 0; i < l.length; i++) {
                h(l[i])
            }
            return h
        } ({
            1 : [function(l, k, p) {
                function j(n, i) {
                    for (; n && n.nodeType !== m;) {
                        if (n.matches(i)) {
                            return n
                        }
                        n = n.parentNode
                    }
                }
                var m = 9;
                if (Element && !Element.prototype.matches) {
                    var h = Element.prototype;
                    h.matches = h.matchesSelector || h.mozMatchesSelector || h.msMatchesSelector || h.oMatchesSelector || h.webkitMatchesSelector
                }
                k.exports = j
            },
            {}],
            2 : [function(l, k, p) {
                function j(v, s, w, q, o) {
                    var u = m.apply(this, arguments);
                    return v.addEventListener(w, u, o),
                    {
                        destroy: function() {
                            v.removeEventListener(w, u, o)
                        }
                    }
                }
                function m(r, q, s, o) {
                    return function(e) {
                        e.delegateTarget = h(e.target, q),
                        e.delegateTarget && o.call(r, e)
                    }
                }
                var h = l("./closest");
                k.exports = j
            },
            {
                "./closest": 1
            }],
            3 : [function(i, h, j) {
                j.node = function(k) {
                    return void 0 !== k && k instanceof HTMLElement && 1 === k.nodeType
                },
                j.nodeList = function(l) {
                    var k = Object.prototype.toString.call(l);
                    return void 0 !== l && ("[object NodeList]" === k || "[object HTMLCollection]" === k) && "length" in l && (0 === l.length || j.node(l[0]))
                },
                j.string = function(k) {
                    return "string" == typeof k || k instanceof String
                },
                j.fn = function(l) {
                    var k = Object.prototype.toString.call(l);
                    return "[object Function]" === k
                }
            },
            {}],
            4 : [function(m, u, k) {
                function l(o, i, r) {
                    if (!o && !i && !r) {
                        throw new Error("Missing required arguments")
                    }
                    if (!v.string(i)) {
                        throw new TypeError("Second argument must be a String")
                    }
                    if (!v.fn(r)) {
                        throw new TypeError("Third argument must be a Function")
                    }
                    if (v.node(o)) {
                        return j(o, i, r)
                    }
                    if (v.nodeList(o)) {
                        return q(o, i, r)
                    }
                    if (v.string(o)) {
                        return h(o, i, r)
                    }
                    throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")
                }
                function j(o, i, r) {
                    return o.addEventListener(i, r),
                    {
                        destroy: function() {
                            o.removeEventListener(i, r)
                        }
                    }
                }
                function q(o, i, r) {
                    return Array.prototype.forEach.call(o,
                    function(n) {
                        n.addEventListener(i, r)
                    }),
                    {
                        destroy: function() {
                            Array.prototype.forEach.call(o,
                            function(n) {
                                n.removeEventListener(i, r)
                            })
                        }
                    }
                }
                function h(o, i, r) {
                    return p(document.body, o, i, r)
                }
                var v = m("./is"),
                p = m("delegate");
                u.exports = l
            },
            {
                "./is": 3,
                delegate: 2
            }],
            5 : [function(k, j, l) {
                function h(p) {
                    var o;
                    if ("SELECT" === p.nodeName) {
                        p.focus(),
                        o = p.value
                    } else {
                        if ("INPUT" === p.nodeName || "TEXTAREA" === p.nodeName) {
                            p.focus(),
                            p.setSelectionRange(0, p.value.length),
                            o = p.value
                        } else {
                            p.hasAttribute("contenteditable") && p.focus();
                            var q = window.getSelection(),
                            m = document.createRange();
                            m.selectNodeContents(p),
                            q.removeAllRanges(),
                            q.addRange(m),
                            o = q.toString()
                        }
                    }
                    return o
                }
                j.exports = h
            },
            {}],
            6 : [function(k, j, l) {
                function h() {}
                h.prototype = {
                    on: function(p, o, q) {
                        var m = this.e || (this.e = {});
                        return (m[p] || (m[p] = [])).push({
                            fn: o,
                            ctx: q
                        }),
                        this
                    },
                    once: function(q, p, s) {
                        function m() {
                            r.off(q, m),
                            p.apply(s, arguments)
                        }
                        var r = this;
                        return m._ = p,
                        this.on(q, m, s)
                    },
                    emit: function(q) {
                        var p = [].slice.call(arguments, 1),
                        s = ((this.e || (this.e = {}))[q] || []).slice(),
                        m = 0,
                        r = s.length;
                        for (m; m < r; m++) {
                            s[m].fn.apply(s[m].ctx, p)
                        }
                        return this
                    },
                    off: function(u, q) {
                        var w = this.e || (this.e = {}),
                        p = w[u],
                        v = [];
                        if (p && q) {
                            for (var m = 0,
                            s = p.length; m < s; m++) {
                                p[m].fn !== q && p[m].fn._ !== q && v.push(p[m])
                            }
                        }
                        return v.length ? w[u] = v: delete w[u],
                        this
                    }
                },
                j.exports = h
            },
            {}],
            7 : [function(h, j, e) { !
                function(l, i) {
                    if ("function" == typeof g && g.amd) {
                        g(["module", "select"], i)
                    } else {
                        if ("undefined" != typeof e) {
                            i(j, h("select"))
                        } else {
                            var k = {
                                exports: {}
                            };
                            i(k, l.select),
                            l.clipboardAction = k.exports
                        }
                    }
                } (this,
                function(u, m) {
                    function w(i) {
                        return i && i.__esModule ? i: {
                            "default": i
                        }
                    }
                    function l(n, i) {
                        if (! (n instanceof i)) {
                            throw new TypeError("Cannot call a class as a function")
                        }
                    }
                    var v = w(m),
                    k = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?
                    function(i) {
                        return typeof i
                    }: function(i) {
                        return i && "function" == typeof Symbol && i.constructor === Symbol && i !== Symbol.prototype ? "symbol": typeof i
                    },
                    q = function() {
                        function i(s, r) {
                            for (var x = 0; x < r.length; x++) {
                                var o = r[x];
                                o.enumerable = o.enumerable || !1,
                                o.configurable = !0,
                                "value" in o && (o.writable = !0),
                                Object.defineProperty(s, o.key, o)
                            }
                        }
                        return function(r, s, o) {
                            return s && i(r.prototype, s),
                            o && i(r, o),
                            r
                        }
                    } (),
                    p = function() {
                        function i(n) {
                            l(this, i),
                            this.resolveOptions(n),
                            this.initSelection()
                        }
                        return q(i, [{
                            key: "resolveOptions",
                            value: function() {
                                var n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                                this.action = n.action,
                                this.emitter = n.emitter,
                                this.target = n.target,
                                this.text = n.text,
                                this.trigger = n.trigger,
                                this.selectedText = ""
                            }
                        },
                        {
                            key: "initSelection",
                            value: function() {
                                this.text ? this.selectFake() : this.target && this.selectTarget()
                            }
                        },
                        {
                            key: "selectFake",
                            value: function() {
                                var r = this,
                                o = "rtl" == document.documentElement.getAttribute("dir");
                                this.removeFake(),
                                this.fakeHandlerCallback = function() {
                                    return r.removeFake()
                                },
                                this.fakeHandler = document.body.addEventListener("click", this.fakeHandlerCallback) || !0,
                                this.fakeElem = document.createElement("textarea"),
                                this.fakeElem.style.fontSize = "12pt",
                                this.fakeElem.style.border = "0",
                                this.fakeElem.style.padding = "0",
                                this.fakeElem.style.margin = "0",
                                this.fakeElem.style.position = "absolute",
                                this.fakeElem.style[o ? "right": "left"] = "-9999px";
                                var s = window.pageYOffset || document.documentElement.scrollTop;
                                this.fakeElem.addEventListener("focus", window.scrollTo(0, s)),
                                this.fakeElem.style.top = s + "px",
                                this.fakeElem.setAttribute("readonly", ""),
                                this.fakeElem.value = this.text,
                                document.body.appendChild(this.fakeElem),
                                this.selectedText = (0, v["default"])(this.fakeElem),
                                this.copyText()
                            }
                        },
                        {
                            key: "removeFake",
                            value: function() {
                                this.fakeHandler && (document.body.removeEventListener("click", this.fakeHandlerCallback), this.fakeHandler = null, this.fakeHandlerCallback = null),
                                this.fakeElem && (document.body.removeChild(this.fakeElem), this.fakeElem = null)
                            }
                        },
                        {
                            key: "selectTarget",
                            value: function() {
                                this.selectedText = (0, v["default"])(this.target),
                                this.copyText()
                            }
                        },
                        {
                            key: "copyText",
                            value: function() {
                                var o = void 0;
                                try {
                                    o = document.execCommand(this.action)
                                } catch(n) {
                                    o = !1
                                }
                                this.handleResult(o)
                            }
                        },
                        {
                            key: "handleResult",
                            value: function(n) {
                                this.emitter.emit(n ? "success": "error", {
                                    action: this.action,
                                    text: this.selectedText,
                                    trigger: this.trigger,
                                    clearSelection: this.clearSelection.bind(this)
                                })
                            }
                        },
                        {
                            key: "clearSelection",
                            value: function() {
                                this.target && this.target.blur(),
                                window.getSelection().removeAllRanges()
                            }
                        },
                        {
                            key: "destroy",
                            value: function() {
                                this.removeFake()
                            }
                        },
                        {
                            key: "action",
                            set: function() {
                                var n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "copy";
                                if (this._action = n, "copy" !== this._action && "cut" !== this._action) {
                                    throw new Error('Invalid "action" value, use either "copy" or "cut"')
                                }
                            },
                            get: function() {
                                return this._action
                            }
                        },
                        {
                            key: "target",
                            set: function(n) {
                                if (void 0 !== n) {
                                    if (!n || "object" !== ("undefined" == typeof n ? "undefined": k(n)) || 1 !== n.nodeType) {
                                        throw new Error('Invalid "target" value, use a valid Element')
                                    }
                                    if ("copy" === this.action && n.hasAttribute("disabled")) {
                                        throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute')
                                    }
                                    if ("cut" === this.action && (n.hasAttribute("readonly") || n.hasAttribute("disabled"))) {
                                        throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes')
                                    }
                                    this._target = n
                                }
                            },
                            get: function() {
                                return this._target
                            }
                        }]),
                        i
                    } ();
                    u.exports = p
                })
            },
            {
                select: 5
            }],
            8 : [function(h, j, e) { !
                function(l, i) {
                    if ("function" == typeof g && g.amd) {
                        g(["module", "./clipboard-action", "tiny-emitter", "good-listener"], i)
                    } else {
                        if ("undefined" != typeof e) {
                            i(j, h("./clipboard-action"), h("tiny-emitter"), h("good-listener"))
                        } else {
                            var k = {
                                exports: {}
                            };
                            i(k, l.clipboardAction, l.tinyEmitter, l.goodListener),
                            l.clipboard = k.exports
                        }
                    }
                } (this,
                function(z, E, v, x) {
                    function q(i) {
                        return i && i.__esModule ? i: {
                            "default": i
                        }
                    }
                    function C(l, i) {
                        if (! (l instanceof i)) {
                            throw new TypeError("Cannot call a class as a function")
                        }
                    }
                    function k(l, i) {
                        if (!l) {
                            throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
                        }
                        return ! i || "object" != typeof i && "function" != typeof i ? l: i
                    }
                    function F(l, i) {
                        if ("function" != typeof i && null !== i) {
                            throw new TypeError("Super expression must either be null or a function, not " + typeof i)
                        }
                        l.prototype = Object.create(i && i.prototype, {
                            constructor: {
                                value: l,
                                enumerable: !1,
                                writable: !0,
                                configurable: !0
                            }
                        }),
                        i && (Object.setPrototypeOf ? Object.setPrototypeOf(l, i) : l.__proto__ = i)
                    }
                    function B(l, i) {
                        var o = "data-clipboard-" + l;
                        if (i.hasAttribute(o)) {
                            return i.getAttribute(o)
                        }
                    }
                    var w = q(E),
                    D = q(v),
                    A = q(x),
                    m = function() {
                        function i(p, o) {
                            for (var r = 0; r < o.length; r++) {
                                var l = o[r];
                                l.enumerable = l.enumerable || !1,
                                l.configurable = !0,
                                "value" in l && (l.writable = !0),
                                Object.defineProperty(p, l.key, l)
                            }
                        }
                        return function(o, p, l) {
                            return p && i(o.prototype, p),
                            l && i(o, l),
                            o
                        }
                    } (),
                    y = function(l) {
                        function i(p, r) {
                            C(this, i);
                            var o = k(this, (i.__proto__ || Object.getPrototypeOf(i)).call(this));
                            return o.resolveOptions(r),
                            o.listenClick(p),
                            o
                        }
                        return F(i, l),
                        m(i, [{
                            key: "resolveOptions",
                            value: function() {
                                var n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                                this.action = "function" == typeof n.action ? n.action: this.defaultAction,
                                this.target = "function" == typeof n.target ? n.target: this.defaultTarget,
                                this.text = "function" == typeof n.text ? n.text: this.defaultText
                            }
                        },
                        {
                            key: "listenClick",
                            value: function(o) {
                                var n = this;
                                this.listener = (0, A["default"])(o, "click",
                                function(p) {
                                    return n.onClick(p)
                                })
                            }
                        },
                        {
                            key: "onClick",
                            value: function(o) {
                                var n = o.delegateTarget || o.currentTarget;
                                this.clipboardAction && (this.clipboardAction = null),
                                this.clipboardAction = new w["default"]({
                                    action: this.action(n),
                                    target: this.target(n),
                                    text: this.text(n),
                                    trigger: n,
                                    emitter: this
                                })
                            }
                        },
                        {
                            key: "defaultAction",
                            value: function(n) {
                                return B("action", n)
                            }
                        },
                        {
                            key: "defaultTarget",
                            value: function(o) {
                                var n = B("target", o);
                                if (n) {
                                    return document.querySelector(n)
                                }
                            }
                        },
                        {
                            key: "defaultText",
                            value: function(n) {
                                return B("text", n)
                            }
                        },
                        {
                            key: "destroy",
                            value: function() {
                                this.listener.destroy(),
                                this.clipboardAction && (this.clipboardAction.destroy(), this.clipboardAction = null)
                            }
                        }]),
                        i
                    } (D["default"]);
                    z.exports = y
                })
            },
            {
                "./clipboard-action": 7,
                "good-listener": 4,
                "tiny-emitter": 6
            }]
        },
        {},
        [8])(8)
    })
},
function(c, b, f) {
    var a, d; !
    function(e, h, g) {
        "undefined" != typeof c && c.exports ? c.exports = g() : (a = g, d = "function" == typeof a ? a.call(b, f, b, c) : a, !(void 0 !== d && (c.exports = d)))
    } ("Fingerprint", this,
    function() {
        var g = function(i) {
            var h, j;
            h = Array.prototype.forEach,
            j = Array.prototype.map,
            this.each = function(p, s, l) {
                if (null !== p) {
                    if (h && p.forEach === h) {
                        p.forEach(s, l)
                    } else {
                        if (p.length === +p.length) {
                            for (var q = 0,
                            k = p.length; q < k; q++) {
                                if (s.call(l, p[q], q, p) === {}) {
                                    return
                                }
                            }
                        } else {
                            for (var m in p) {
                                if (p.hasOwnProperty(m) && s.call(l, p[m], m, p) === {}) {
                                    return
                                }
                            }
                        }
                    }
                }
            },
            this.map = function(m, l, k) {
                var n = [];
                return null == m ? n: j && m.map === j ? m.map(l, k) : (this.each(m,
                function(p, q, o) {
                    n[n.length] = l.call(k, p, q, o)
                }), n)
            },
            "object" == typeof i ? (this.hasher = i.hasher, this.screen_resolution = i.screen_resolution, this.screen_orientation = i.screen_orientation, this.canvas = i.canvas, this.ie_activex = i.ie_activex) : "function" == typeof i && (this.hasher = i)
        };
        return g.prototype = {
            get: function() {
                var i = [];
                if (i.push(navigator.userAgent), i.push(navigator.language), i.push(screen.colorDepth), this.screen_resolution) {
                    var h = this.getScreenResolution();
                    "undefined" != typeof h && i.push(h.join("x"))
                }
                return i.push((new Date).getTimezoneOffset()),
                i.push(this.hasSessionStorage()),
                i.push(this.hasLocalStorage()),
                i.push(this.hasIndexDb()),
                document.body ? i.push(typeof document.body.addBehavior) : i.push("undefined"),
                i.push(typeof window.openDatabase),
                i.push(navigator.cpuClass),
                i.push(navigator.platform),
                i.push(navigator.doNotTrack),
                i.push(this.getPluginsString()),
                this.canvas && this.isCanvasSupported() && i.push(this.getCanvasFingerprint()),
                this.hasher ? this.hasher(i.join("###"), 31) : this.murmurhash3_32_gc(i.join("###"), 31)
            },
            murmurhash3_32_gc: function(q, w) {
                var k, p, j, v, h, x, u, m;
                for (k = 3 & q.length, p = q.length - k, j = w, h = 3432918353, x = 461845907, m = 0; m < p;) {
                    u = 255 & q.charCodeAt(m) | (255 & q.charCodeAt(++m)) << 8 | (255 & q.charCodeAt(++m)) << 16 | (255 & q.charCodeAt(++m)) << 24,
                    ++m,
                    u = (65535 & u) * h + (((u >>> 16) * h & 65535) << 16) & 4294967295,
                    u = u << 15 | u >>> 17,
                    u = (65535 & u) * x + (((u >>> 16) * x & 65535) << 16) & 4294967295,
                    j ^= u,
                    j = j << 13 | j >>> 19,
                    v = 5 * (65535 & j) + ((5 * (j >>> 16) & 65535) << 16) & 4294967295,
                    j = (65535 & v) + 27492 + (((v >>> 16) + 58964 & 65535) << 16)
                }
                switch (u = 0, k) {
                case 3:
                    u ^= (255 & q.charCodeAt(m + 2)) << 16;
                case 2:
                    u ^= (255 & q.charCodeAt(m + 1)) << 8;
                case 1:
                    u ^= 255 & q.charCodeAt(m),
                    u = (65535 & u) * h + (((u >>> 16) * h & 65535) << 16) & 4294967295,
                    u = u << 15 | u >>> 17,
                    u = (65535 & u) * x + (((u >>> 16) * x & 65535) << 16) & 4294967295,
                    j ^= u
                }
                return j ^= q.length,
                j ^= j >>> 16,
                j = 2246822507 * (65535 & j) + ((2246822507 * (j >>> 16) & 65535) << 16) & 4294967295,
                j ^= j >>> 13,
                j = 3266489909 * (65535 & j) + ((3266489909 * (j >>> 16) & 65535) << 16) & 4294967295,
                j ^= j >>> 16,
                j >>> 0
            },
            hasLocalStorage: function() {
                try {
                    return !! window.localStorage
                } catch(h) {
                    return ! 0
                }
            },
            hasSessionStorage: function() {
                try {
                    return !! window.sessionStorage
                } catch(h) {
                    return ! 0
                }
            },
            hasIndexDb: function() {
                try {
                    return !! window.indexedDB
                } catch(h) {
                    return ! 0
                }
            },
            isCanvasSupported: function() {
                var h = document.createElement("canvas");
                return ! (!h.getContext || !h.getContext("2d"))
            },
            isIE: function() {
                return "Microsoft Internet Explorer" === navigator.appName || !("Netscape" !== navigator.appName || !/Trident/.test(navigator.userAgent))
            },
            getPluginsString: function() {
                return this.isIE() && this.ie_activex ? this.getIEPluginsString() : this.getRegularPluginsString()
            },
            getRegularPluginsString: function() {
                return this.map(navigator.plugins,
                function(i) {
                    var h = this.map(i,
                    function(j) {
                        return [j.type, j.suffixes].join("~")
                    }).join(",");
                    return [i.name, i.description, h].join("::")
                },
                this).join(";")
            },
            getIEPluginsString: function() {
                if (window.ActiveXObject) {
                    var h = ["ShockwaveFlash.ShockwaveFlash", "AcroPDF.PDF", "PDF.PdfCtrl", "QuickTime.QuickTime", "rmocx.RealPlayer G2 Control", "rmocx.RealPlayer G2 Control.1", "RealPlayer.RealPlayer(tm) ActiveX Control (32-bit)", "RealVideo.RealVideo(tm) ActiveX Control (32-bit)", "RealPlayer", "SWCtl.SWCtl", "WMPlayer.OCX", "AgControl.AgControl", "Skype.Detection"];
                    return this.map(h,
                    function(j) {
                        try {
                            return new ActiveXObject(j),
                            j
                        } catch(i) {
                            return null
                        }
                    }).join(";")
                }
                return ""
            },
            getScreenResolution: function() {
                var h;
                return h = this.screen_orientation ? screen.height > screen.width ? [screen.height, screen.width] : [screen.width, screen.height] : [screen.height, screen.width]
            },
            getCanvasFingerprint: function() {
                var i = document.createElement("canvas"),
                h = i.getContext("2d"),
                j = "//valve.github.io";
                return h.textBaseline = "top",
                h.font = "14px 'Arial'",
                h.textBaseline = "alphabetic",
                h.fillStyle = "#f60",
                h.fillRect(125, 1, 62, 20),
                h.fillStyle = "#069",
                h.fillText(j, 2, 15),
                h.fillStyle = "rgba(102, 204, 0, 0.7)",
                h.fillText(j, 4, 17),
                i.toDataURL()
            }
        },
        g
    })
},
function(b, a) {
    b.exports = apiFinanceCallUp
},
function(f, d, h) {
    var c = h(1),
    g = h(10),
    b = function(K) {
        var z, D, O, B, A, M, F, x, L, C, J, H, j, E, N = "",
        I = K.callpagetype.toString() || "1",
        q = !1,
        o = c.checkUA._system();
        switch (I) {
        case "1":
            N = "type=" + I;
            break;
        case "2":
            switch (z = K.stocktype || "", D = K.symbol || "", O = K.name || "", F = K.subtype.toString() || "0") {
            case "0":
                N = "type=" + I + "&stocktype=" + z + "&symbol=" + D + "&name=" + O;
                break;
            case "1":
                N = "type=" + I + "&stocktype=" + z + "&symbol=" + D + "&name=" + O + "&subType=" + F,
                "android" == o && (N = "type=20&subType=" + F + "&symbol=" + D);
                break;
            case "2":
                N = "type=" + I + "&stocktype=" + z + "&symbol=" + D + "&subType=" + F;
                break;
            case "kd":
            case "kw":
            case "km":
            case "bs":
            case "k5":
            case "k15":
            case "k30":
            case "k60":
                N = "type=" + I + "&stocktype=" + z + "&symbol=" + D + "&name=" + O + "&subType=" + F
            }
            break;
        case "3":
            z = K.stocktype || "",
            D = K.symbol || "",
            O = K.name || "",
            N = "type=" + I + "&foundtype=" + z + "&symbol=" + D + "&name=" + O;
            break;
        case "4":
            B = K.h5url || "",
            N = "type=" + I + "&hash=" + B;
            break;
        case "10":
            switch (F = K.subtype.toString() || "0") {
            case "1":
                N = "type=" + I + "&subType=" + F;
                break;
            default:
                N = "type=" + I
            }
            break;
        case "17":
            if (B = K.h5url || "", H = K.mid || "", j = K.news_type || "", "" != j) {
                if ("android" == o) {
                    N = "type=" + I + "&mid=" + H + "&news_type=" + j
                } else {
                    var G = {
                        mid: H,
                        news_type: j
                    };
                    N = "type=99999&local_url=newsdetails&queryValues=" + encodeURIComponent(JSON.stringify(G))
                }
            } else {
                "android" == o && B.indexOf("url=") > -1 && (B = B.replace(/\?/g, "&")),
                N = "type=" + I + "&url=" + B + "&pull=toutiao",
                q = !0
            }
            break;
        case "18":
            B = K.h5url || "",
            A = K.commentId || "",
            N = "type=" + I + "&hash=" + B + "&commentId=" + A + "&pull=comment",
            q = !0;
            break;
        case "19":
            B = K.h5url || "",
            A = K.commentId || "",
            N = "type=" + I + "&url=" + B + "&commentId=" + A + "&pull=comment",
            q = !0;
            break;
        case "20":
            switch (B = K.h5url || "", F = K.subtype.toString() || "0", D = K.symbol || "", F) {
            case "0":
                "ios" == o && B.indexOf("url=") > -1 && (B = encodeURIComponent(B)),
                N = "type=" + I + "&url=" + B;
                break;
            case "1":
                N = "type=" + I + "&subType=" + F + "&symbol=" + D
            }
            q = !0;
            break;
        case "21":
            M = K.blogger_liveid || "",
            N = "type=" + I + "&blogger_liveid=" + M;
            break;
        case "22":
            switch (F = K.subtype.toString() || "0", D = K.symbol || "", O = K.name || "", x = K.officeid || "", F) {
            case "0":
            case "3":
                N = "type=" + I + "&subType=" + F;
                break;
            case "1":
            case "2":
            case "4":
                N = "type=" + I + "&subType=" + F + "&symbol=" + D + "&name=" + O;
                break;
            case "5":
                N = "type=" + I + "&subType=" + F + "&id=" + x + "&title=" + O
            }
            break;
        case "23":
            switch (F = K.subtype.toString() || "0") {
            case "0":
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
            case "6":
            case "7":
            case "8":
            case "9":
            case "10":
            case "11":
            case "12":
                N = "type=" + I + "&subType=" + F
            }
            break;
        case "25":
            F = K.subtype.toString() || "0",
            M = K.blogger_liveid || "",
            L = K.cid || "",
            N = "type=" + I + "&program_type=" + F + "&bid=" + M + "&cid=" + L;
            break;
        case "26":
            C = K.pay_type || "",
            J = K.pay_id || "",
            N = "type=" + I + "&pay_type=" + C + "&pay_id=" + J;
            break;
        case "27":
            M = K.blogger_liveid || "",
            O = K.name || "",
            N = "type=" + I + "&bid=" + M + "&name=" + O;
            break;
        case "28":
            F = K.subtype.toString() || "0",
            N = "type=" + I + "&subType=" + F;
            break;
        case "29":
            F = K.subtype.toString() || "0",
            N = "type=" + I;
            break;
        case "30":
            F = K.subtype.toString() || "0",
            B = K.h5url || "",
            E = K.pf || "0",
            N = "type=" + I + "&url=" + B + "&pf=" + E,
            q = !0;
            break;
        case "31":
            M = K.blogger_liveid || "",
            N = "type=" + I + "&uid=" + M,
            q = !0;
            break;
        case "32":
            D = K.symbol || "",
            N = "type=" + I + "&searchkey=" + encodeURIComponent(D);
            break;
        case "33":
            D = K.symbol || "",
            z = K.stocktype || "",
            O = K.name || "",
            F = K.subtype.toString() || "0",
            N = "type=" + I + "&subType=" + F + "&stocktype=" + z + "&symbol=" + D + "&name=" + O;
            break;
        case "35":
            D = K.symbol || "",
            F = K.subtype.toString() || "0",
            N = "type=" + I + "&symbol=" + D;
            break;
        case "36":
            F = K.subtype.toString() || "0",
            H = K.mid || "",
            j = K.news_type || "",
            O = K.name || "",
            N = "type=" + I + "&subType=" + F + "&category=" + j + "&title=" + O + "&id=" + H;
            break;
        default:
            N = "type=1"
        }
        var i = g.apiFinance.forCallUpNum(K),
        P = "&callfailUrl=" + encodeURIComponent(K.callfailUrl);
        return "ios" == o && 0 == K.isDownload && "" != K.callfailUrl && (N += P),
        N = i + "&" + N
    };
    f.exports = b
},
function(g, d, j) {
    var c = j(1),
    h = j(12),
    b = (window, document, j(6)),
    f = (j(2), ""),
    b = function(i, a) {
        var k = i = i || {};
        return k.openApp = h,
        k.RedirectToNative = {
            openTimer: null,
            init: function(r) {
                var z = this,
                x = c.checkUA.isapiFinance(),
                A = c.checkUA.isWeixin(),
                w = (c.checkUA.isChrome(), c.checkUA.isIOS9()),
                n = !A && c.checkUA.isQQ(),
                y = c.checkUA.isWeibo(),
                v = r || {};
                c.checkUA.isIos1002();
                z.platform = c.checkUA._system(),
                z.openByWeixin = v.openByWeixin || f,
                z.isNotScheme = !!v.isNotScheme,
                z._position = v.position || "001001",
                z.position = (v.calluptype || "") + z._position,
                "undefined" != r.setOpenTrackUrl && k.Track.setClickTrackUrl(r.setOpenTrackUrl),
                "undefined" != r.setDownloadTrackUrl && k.Track.setDownloadTrackUrl(r.setDownloadTrackUrl);
                var m = 1 == v.needOpenSource ? k.Track.getUATrackValue(z.position) : z.position,
                q = 1 == v.needOpenSource ? k.Track.getUATrackFailValue() : "";
                if (k.Track.sendUATrack(r.uatrackKey, m), z.platform) {
                    if ("" != v.golink) {
                        return void(window.location.href = v.golink)
                    }
                    if (x) {
                        return "ios" == z.platform ? void(window.location.href = v.iosNativeUrl) : void(window.location.href = v.androidNativeUrl)
                    }
                    if (w && v.ios9Url) {
                        return void(window.location.href = v.ios9Url)
                    }
                    if (w && v.ios9Url && y && !A && !n) {
                        return void(window.location.href = v.ios9Url)
                    }
                    if (w && v.ios9Url && (A || n)) {
                        return void(window.location.href = v.ios9Url)
                    }
                    if ("ios" == z.platform) {
                        z.installUrl = v.iosInstallUrl || f,
                        z.nativeUrl = v.iosNativeUrl || f;
                        var o = z.installUrl.match(/(\S*)(d\.php\?k\=)(\S*)/);
                        z.openTime = v.iosOpenTime || 800,
                        y && z.installUrl && o && (z.installUrl += "&apiinternalbrowser=external"),
                        A && z.installUrl && (z.installUrl = v.openByWeixin)
                    } else {
                        z.installUrl = v.androidInstallUrl || f,
                        z.nativeUrl = v.androidNativeUrl || f,
                        z.openTime = v.androidOpenTime || 3000
                    } ! n && !A || z.isNotScheme ? n || y || A || z.isNotScheme ? h.start({
                        scheme: z.nativeUrl,
                        url: z.installUrl,
                        opentime: z.openTime,
                        isDownload: v.isDownload,
                        callfailUrl: v.callfailUrl,
                        downloadCallback: function() {
                            k.Track.sendUATrack(r.uatrackKey, q),
                            v.downloadCallback && v.downloadCallback()
                        },
                        callback: function() {
                            k.Track.sendUATrack(r.uatrackKey, q),
                            v.callback && v.callback()
                        }
                    }) : h.start({
                        scheme: z.nativeUrl,
                        url: z.installUrl,
                        opentime: z.androidOpenTime,
                        isDownload: v.isDownload,
                        callfailUrl: v.callfailUrl,
                        downloadCallback: function() {
                            k.Track.sendUATrack(r.uatrackKey, q),
                            v.downloadCallback && v.downloadCallback()
                        },
                        callback: function() {
                            k.Track.sendUATrack(r.uatrackKey, q),
                            v.callback && v.callback()
                        }
                    }) : v.openBrowser ? v.openBrowser() : c.showWeiXinTips()
                }
            }
        },
        i
    } (b || {},
    window.jQuery || window.Zepto)
},
function(j, p, f) {
    var h = f(1),
    d = f(3),
    m = f(7),
    b = f(2),
    q = d.finance,
    k = document,
    g = (window, f(6)),
    g = function(c, a) {
        var i = c = c || {};
        return i.CallUpapiFinance = new h.Clz,
        i.CallUpapiFinance.include({
            init: function(n) {
                var l = this;
                l.setOpt(n),
                l.initEvent()
            },
            setOpt: function(l) {
                this.set("opt", h.extend({
                    callUpClass: "j_call_native",
                    uatrackKey: "",
                    eventid: "",
                    wmCode: "",
                    docId: "",
                    head: q.head,
                    ios9http: q.ios9http,
                    iosInstallUrl: q.iosInstallUrl,
                    androidInstallUrl: q.androidInstallUrl,
                    wxUrl: q.wxUrl,
                    weiboSlience: q.weiboSlience,
                    androidOpenTime: q.androidOpenTime,
                    callback: q.callback,
                    downloadCallback: q.downloadCallback,
                    openBrowser: q.openBrowser,
                    isDownload: q.isDownload,
                    golink: q.golink,
                    subname: "",
                    debug: !1,
                    needOpenSource: !0
                },
                l, !0))
            },
            clickInternal: 3000,
            callLocked: !1,
            curCallUpPosition: {},
            totalCallUpPosition: 0,
            clearAllLocked: function() {
                var l = this;
                l.callLocked = !1
            },
            getAndroidInstallUrl: function(y, B) {
                var w = this,
                v = w.get("opt"),
                A = B || v.weiboSlience,
                u = h.checkUA.isWeibo(),
                C = h.checkUA.getWeiboVersion(),
                z = "android" == h.checkUA._system(),
                x = !!y.match(/apks\/apifinance[\/\S]*.apk/g);
                return x && u && z && C >= 6 ? A: y
            },
            initPosition: function() {
                var l = this;
                l.get("opt")
            },
            findDom: function(s) {
                for (var r = this,
                v = 10,
                l = {},
                u = 0; u < v; u++) {
                    if (l.info = r.getDomInfo(s), l.info.isCallNative) {
                        l.dom = s;
                        break
                    }
                    s = s.parentElement
                }
                return l
            },
            findTargetInfo: function(o) {
                var l = this;
                l.getPosition(o);
                var r = this.findDom(o);
                return r && r.info || null
            },
            getDomInfo: function(u) {
                var s = this,
                w = s.get("opt"),
                r = u.className,
                v = {},
                l = u.dataset;
                return v.isCallNative = r.indexOf(w.callUpClass) > -1,
                v.isCallNative && (v.docid = l.docid, v.targetid = l.targetid, v.isDownload = "undefined" == typeof l.isdownload ? w.isDownload: l.isdownload, v.calluptype = l.calluptype || "", v.position = l.position, v.locked = !!parseInt(l.locked) || !1, v.callpagetype = l.callpagetype || 1, v.h5url = l.url || "", v.commentId = l.commentid || "", v.blogger_liveid = l.blogger_liveid || "", v.stocktype = l.stocktype || "cn", v.symbol = l.symbol || "", v.name = l.name || "", v.openBrowser = l.openbrowser || w.openBrowser, v.callback = w.callback, v.downloadCallback = w.downloadCallback, v.golink = l.golink || w.golink, v.subname = l.subname || w.subname, v.subtype = l.subtype || "0", v.officeid = l.officeid || "", v.program_type = l.program_type || "", v.cid = l.cid || "", v.pay_type = l.pay_type || "", v.pay_id = l.pay_id || "", v.callfailUrl = l.callfailurl || "", v.iostoh5 = l.iostoh5 || "", v.mid = l.mid || "", v.news_type = l.news_type || "", v.pf = l.pf || "0", v.needopensource = "undefined" == typeof v.needopensource || "true" == v.needopensource),
                v
            },
            addLock: function(n) {
                var l = this;
                l.callLocked = !0,
                setTimeout(function() {
                    l.clearAllLocked()
                },
                l.clickInternal)
            },
            refreshPosition: function() {
                for (var s = this,
                r = s.get("opt"), v = k.body.querySelectorAll("." + r.callUpClass), l = 0; v && l < v.length;) {
                    var u = v.item(l);
                    s.getPosition(u),
                    l++
                }
            },
            tryDirectCall: function(r) {
                var o = this,
                s = o.get("opt"),
                l = {};
                o.refreshPosition(); (new Date).getTime(),
                o.callLocked || !1;
                l.calluptype = r.calluptype || "",
                l.callpagetype = r.callpagetype || 1,
                l.h5url = r.url || "",
                l.commentId = r.commentid || "",
                l.position = r.position || "001001",
                l.blogger_liveid = r.blogger_liveid || "",
                l.stocktype = r.stocktype || "cn",
                l.symbol = r.symbol || "",
                l.name = r.name || "",
                l.isDownload = "undefined" == typeof r.isDownload ? s.isDownload: r.isDownload,
                l.callback = r.callback || s.callback,
                l.downloadCallback = r.downloadCallback || s.downloadCallback,
                l.openBrowser = r.openBrowser || s.openBrowser,
                l.golink = r.golink || s.golink,
                l.subname = r.subname || s.subname,
                l.subtype = r.subtype || "",
                l.officeid = r.officeid || "",
                l.program_type = r.program_type || "",
                l.cid = r.cid || "",
                l.pay_type = r.pay_type || "",
                l.pay_id = r.pay_id || "",
                l.callfailUrl = r.callfailUrl || "",
                l.iostoh5 = r.iostoh5 || "",
                l.mid = r.mid || "",
                l.news_type = r.news_type || "",
                l.pf = r.pf || "0",
                l.needopensource = "undefined" == typeof r.needopensource || 1 == r.needopensource,
                o.addLock(),
                o.open_or_download_app(l)
            },
            tryCallUp: function(v) {
                var s = this;
                s.refreshPosition();
                var x = v.target || v,
                w = s.findTargetInfo(x),
                l = (new Date).getTime(),
                u = s.callLocked || !1;
                w.isCallNative && !u && (loading = l, s.addLock(x), s.open_or_download_app(w, x)),
                h.stopDefault(v)
            },
            bindTarget: function(n) {
                var l = this;
                h.checkUA._system();
                h.bindEventForApp(n, "click",
                function(o) {
                    l.tryCallUp(o)
                })
            },
            setClipText: function(x) {
                var u = this,
                A = u.get("opt"),
                l = x,
                y = u.findTargetInfo(l),
                w = u.callLocked || !1,
                v = "",
                z = "";
                y.isCallNative && !w && (v = m(y), z = A.head + "://" + v, l.setAttribute("data-clipboard-text", z))
            },
            getScheme: function() {
                var l = this;
                l.get("opt")
            },
            open_or_download_app: function(x, B) {
                var r = this,
                C = r.get("opt"),
                z = x || __callUpConfig,
                v = {},
                A = "",
                y = "",
                n = "",
                w = "";
                z.uatrackKey = C.uatrackKey,
                z.eventid = C.eventid,
                z.sourceCode = C.wmCode,
                z.sourceDocId = C.docId,
                z.opensource = h.checkUA.getBrowserName(),
                y = m(z),
                A = C.head + "://" + y,
                "ios" == h.checkUA._system() && b.copyText(A),
                z.androidInstallUrl = r.getAndroidInstallUrl(C.androidInstallUrl, C.weiboSlience),
                C.ios9http && (n = C.ios9http + "?" + (w ? w: y.replace(/\?/g, "&"))),
                "" != z.iostoh5 && (n += "&iosToH5=" + encodeURIComponent(z.iostoh5)),
                v = {
                    iosNativeUrl: A,
                    androidNativeUrl: A,
                    isDownload: z.isDownload,
                    iosInstallUrl: C.iosInstallUrl,
                    androidInstallUrl: z.androidInstallUrl,
                    ios9Url: n,
                    ios9Weixin: C.ios9Weixin,
                    weiboSlience: C.weiboSlience,
                    openByWeixin: C.weixn,
                    calluptype: z.calluptype,
                    position: z.position,
                    sourceCode: z.sourceCode,
                    uatrackKey: z.uatrackKey,
                    eventid: z.eventid,
                    sourceDocId: z.sourceDocId,
                    androidOpenTime: C.androidOpenTime || 3000,
                    iosOpenTime: C.iosOpenTime || 800,
                    callback: z.callback,
                    downloadCallback: z.downloadCallback,
                    openBrowser: z.openBrowser,
                    golink: z.golink,
                    subname: z.subname,
                    opensource: z.opensource,
                    subtype: z.subtype,
                    officeid: z.officeid,
                    callfailUrl: z.callfailUrl,
                    needOpenSource: C.needOpenSource && ("true" == z.needopensource || 1 == z.needopensource),
                    debug: C.debug,
                    mid: z.mid,
                    news_type: z.news_type
                },
                h.checkUA.isIOS9() ? i.RedirectToNative.init(v) : b.send(v,
                function() {
                    i.RedirectToNative.init(v)
                },
                function() {
                    i.RedirectToNative.init(v)
                })
            },
            getPosition: function(v) {
                var s = this,
                x = (s.get("opt"), v.getAttribute("data-calluptype")),
                w = v.getAttribute("bind-target"),
                l = v.getAttribute("data-position");
                if (!w) {
                    "undefined" != typeof s.curCallUpPosition[x] ? s.curCallUpPosition[x]++:s.curCallUpPosition[x] = 1,
                    s.totalCallUpPosition++;
                    var u = h.checkUA.getFullNumber(s.curCallUpPosition[x]) + h.checkUA.getFullNumber(s.totalCallUpPosition);
                    l || v.setAttribute("data-position", u),
                    v.setAttribute("bind-target", "binded")
                }
            },
            bindCallUp: function() {
                for (var w = this,
                u = w.get("opt"), y = k.body.querySelectorAll("." + u.callUpClass), s = 0; y && s < y.length;) {
                    var x = y.item(s),
                    l = x.getAttribute("bind-target"),
                    v = x.getAttribute("href");
                    w.getPosition(x),
                    l || (v && v.indexOf("javascript:") < 0 && x.setAttribute("data-golink", v), w.bindTarget(x), x.setAttribute("bind-target", "binded")),
                    s++
                }
            },
            initEvent: function() {
                this.bindCallUp()
            }
        }),
        c
    } (g || {},
    window.jQuery || window.Zepto)
},
function(b, a) {
    var c = function(f, d) {
        var g = f = f || {};
        return g.apiFinance = {
            forCallUpNum: function(m) {
                var k, q = {},
                j = "" == m.eventid ? m.uatrackKey: m.eventid,
                p = m.position || "",
                h = m.subname || "",
                l = m.opensource || "";
                return q.uatrackKey = m.uatrackKey,
                q.eventid = j,
                q.params = {
                    position: p,
                    opensource: l
                },
                h && "" != h && (q.params.subname = h),
                k = "apifinance" == l ? "": "statistic=" + encodeURIComponent(JSON.stringify(q))
            },
            h5: function(l) {
                var k = "",
                p = l.calluptype || "",
                j = (l.spCode || "", l.sourceCode || ""),
                m = l.sourceDocId || "",
                h = "";
                switch (p) {
                case "SF_0108":
                    h = l.targetid,
                    k = j + "*" + m + "*" + h + "*video";
                    break;
                case "SF_0110":
                    h = l.h5url,
                    k = j + "*" + m + "*" + h + "*picture";
                    break;
                case "SF_0111":
                    h = l.h5url,
                    k = j + "*" + m + "*" + h + "*pictureSingle";
                    break;
                case "SF_0123":
                    h = j,
                    k = j + "*" + m + "*" + h + "*comment";
                    break;
                case "SF_0124":
                    h = l.targetid,
                    k = j + "*" + m + "*" + h + "*news";
                    break;
                case "SF_0125":
                    h = l.symbol,
                    k = j + "*" + m + "*" + h + "*stockHq"
                }
                return "scheme_call=apiwap*fin*" + k
            }
        },
        f
    } (c || {},
    window.jQuery || window.Zepto);
    b.exports = c
},
function(f, d, h) {
    var c = window,
    g = (document, h(1)),
    b = h(6),
    b = function(i, a) {
        var j = i = i || {};
        return j.Track = {
            trackUrl: {},
            getUATrackValue: function(q) {
                var m = "",
                u = g.checkUA._system(),
                l = g.checkUA.isWeixin(),
                k = !l && g.checkUA.isQQ(),
                p = g.checkUA.isWeibo(),
                o = l ? "weixin": p ? "weibo": k ? "QQ": "browser";
                return m = u + "_" + o + "_" + q
            },
            getUATrackFailValue: function() {
                var l = "",
                k = g.checkUA._system();
                return l = "callfail_" + k
            },
            setClickTrackUrl: function(k) {
                j.Track.trackUrl.click = k
            },
            setDownloadTrackUrl: function(k) {
                j.Track.trackUrl.download = k
            },
            goTrack: function(k) {
                k && g.jsonp({
                    url: k
                })
            },
            sendUATrack: function(l, k) {
                window.SUDA && "" !== l && "" !== k && window.SUDA.uaTrack(l, k)
            },
            sendSudaLog: function(l) {
                var k = {
                    name: l,
                    type: "",
                    title: "",
                    index: "",
                    href: ""
                }; ("function" == typeof c.suds_count || c.suds_count) && c.suds_count && c.suds_count(k)
            },
            sendClickTrack: function(k) {
                j.Track.goTrack(j.Track.trackUrl.click),
                j.Track.sendSudaLog("click_" + k)
            },
            sendDownloadTrack: function(k) {
                j.Track.goTrack(j.Track.trackUrl.download),
                j.Track.sendSudaLog("callfail_" + k)
            }
        },
        i
    } (b || {},
    window.jQuery || window.Zepto)
},
function(O, B, G) {
    var K, F, S = G(1),
    D = navigator.userAgent.toLowerCase(),
    C = S.checkUA.OpenTypeIdentify.noIntent.test(D),
    Q = S.checkUA.OpenTypeIdentify.hasIntent.test(D),
    I = S.checkUA.OpenTypeIdentify.speciallIntent.test(D),
    A = /android|adr/.test(D) && !/windows phone/.test(D),
    P = navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
    E = I || !C && Q && A,
    N = !1;
    D.indexOf("m353") > -1 && !C && (E = !1);
    var L = {
        scheme: "apiweibo://gotohome",
        url: "//m.weibo.cn/feature/download/index",
        isDownload: !0,
        h5pos: null,
        opentime: 1500,
        callback: null,
        downloadCallback: null,
        callfailUrl: ""
    },
    q = function() {
        var a = Date.now(); (!K || a - K < L.opentime + 200) && (L.isDownload ? (L.downloadCallback && L.downloadCallback(), window.location = L.url) : L.callback && (L.callback(), "" != L.callfailUrl && (window.location = L.callfailUrl)))
    },
    H = function() {
        var a;
        return window.CustomEvent ? a = new window.CustomEvent("click", {
            canBubble: !0,
            cancelable: !0
        }) : (a = document.createEvent("Event"), a.initEvent("click", !0, !0)),
        a
    },
    R = function(b) {
        var a = document.getElementById("openIntentLink");
        a || (a = document.createElement("a"), a.id = "openIntentLink", a.style.display = "none", document.body.appendChild(a)),
        a.href = b,
        a.dispatchEvent(H())
    },
    M = function(b) {
        var a = document.createElement("iframe");
        a.src = b,
        a.style.display = "none",
        document.body.appendChild(a)
    },
    z = function(g, d) {
        if (!g) {
            return ""
        }
        var k = g,
        c = "//weibo.cn/appurl?scheme=",
        h = d ? "h5pos:" + d: "",
        b = /^.+(?:[&?]extparam=)(.*?)(?:&|$)/,
        f = k.match(b);
        return f && f[1] && (h = h ? h + "|" + f[1] : "h5pos:" + f[1]),
        c += h ? encodeURIComponent(k + "&extparam=" + encodeURIComponent(h)) : encodeURIComponent(k)
    },
    x = function() {
        if (!N) {
            if (N = !0, K = Date.now(), E) {
                var b, a = "apiweibo";
                L.scheme && (a = L.scheme.substring(0, L.scheme.indexOf("://"))),
                b = L.isDownload ? L.scheme.replace(a, "intent") + "#Intent;scheme=" + a + ";S.browser_fallback_url=" + encodeURIComponent(L.url) + ";end": L.scheme.replace(a, "intent") + "#Intent;scheme=" + a + ";S.browser_fallback_url=" + encodeURIComponent(L.callfailUrl) + ";end",
                R(b)
            } else {
                var c = D.match(/os (\d+)_\d[_\d]* like Mac OS X/i);
                D.indexOf("qq/") > -1 || P && D.indexOf("qhbrowser") > -1 || D.indexOf("safari") > -1 && c && c[1] >= 9 ? R(L.scheme) : M(L.scheme),
                L.url && (F = setTimeout(function() {
                    q()
                },
                L.opentime), S.pageVisibility.isSupport ? S.pageVisibility.visibilitychange(function() {
                    clearTimeout(F)
                }) : window.onblur = function() {
                    clearTimeout(F)
                })
            }
            setTimeout(function() {
                N = !1
            },
            L.opentime + 1000)
        }
    },
    J = function(b) {
        if (!N) {
            N = !0,
            K = Date.now();
            var a = b || "ope002";
            switch (a) {
            case "op002":
                M(L.scheme),
                L.url && (F = setTimeout(function() {
                    q()
                },
                L.opentime), S.pageVisibility.isSupport ? S.pageVisibility.visibilitychange(function() {
                    clearTimeout(F)
                }) : window.onblur = function() {
                    clearTimeout(F)
                });
                break;
            case "op003":
                R(L.scheme),
                L.url && (F = setTimeout(function() {
                    q()
                },
                L.opentime), S.pageVisibility.isSupport ? S.pageVisibility.visibilitychange(function() {
                    clearTimeout(F)
                }) : window.onblur = function() {
                    clearTimeout(F)
                });
                break;
            case "op004":
                var c = "apifinance";
                L.isDownload ? intentUrl = L.scheme.replace(c, "intent") + "#Intent;scheme=" + c + ";S.browser_fallback_url=" + encodeURIComponent(L.url) + ";end": intentUrl = L.scheme.replace(c, "intent") + "#Intent;scheme=" + c + ";end",
                console.log(intentUrl),
                window.location.href = intentUrl
            }
            setTimeout(function() {
                N = !1
            },
            L.opentime + 1000)
        }
    },
    j = function(a) {
        a && S.extend(L, a),
        x()
    },
    T = function(b, a) {
        b && S.extend(L, b),
        J(a)
    };
    O.exports = {
        start: j,
        getUnilink: z,
        startInMethord: T
    }
}]);