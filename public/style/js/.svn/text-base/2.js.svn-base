var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?
function(a) {
    return typeof a
}: function(a) {
    return a && "function" == typeof Symbol && a.constructor === Symbol && a !== Symbol.prototype ? "symbol": typeof a
};
try { !
    function() {
        function aq(b, a) {
            var c = 0;
            return c = b.indexOf("#"),
            c > 0 ? (a && (am = b.substring(c)), b.substring(0, c)) : (a && (am = ""), b)
        }
        function ad(b) {
            var a = 0;
            return a = b.indexOf("#"),
            a > 0 ? (changeHash && (am = b.substring(a)), b.substring(0, a)) : (changeHash && (am = ""), b)
        }
        function ai(b) {
            for (var a = 0,
            d = 0,
            c = b;;) {
                if (a = c.indexOf("<"), d = c.indexOf(">", a), !(a >= 0 && d >= 0 && d > a)) {
                    break
                }
                c = c.substring(0, a) + c.substring(d + 1, c.length)
            }
            return c
        }
        function ah() {
            if ("" != W) {
                return W
            }
            var b = "",
            a = q.toLowerCase(),
            d = a.indexOf("api.");
            if (d > 0) {
                b = "api.cn"
            } else {
                var c = a.indexOf(".");
                if (! (c > 0)) {
                    return ""
                }
                c += 1,
                d = a.indexOf("/", c),
                0 > d && (d = a.length),
                b = a.substring(c, d)
            }
            return W = b,
            b
        }
        function af(b) {
            var a = document.cookie.indexOf(b + "=");
            if ( - 1 == a) {
                return ""
            }
            a = document.cookie.indexOf("=", a) + 1;
            var c = document.cookie.indexOf(";", a);
            return 0 >= c && (c = document.cookie.length),
            ckValue = document.cookie.substring(a, c),
            ckValue
        }
        function av(d, b, f) {
            if (null != b) {
                if (_suds_cmp_domainRoot = ah(), "undefined" == f || null == f) {
                    document.cookie = d + "=" + b + "; domain=" + _suds_cmp_domainRoot + "; path=/"
                } else {
                    var a = new Date,
                    c = a.getTime();
                    c += 86400000 * f,
                    a.setTime(c),
                    c = a.getTime(),
                    document.cookie = d + "=" + b + "; domain=" + _suds_cmp_domainRoot + "; expires=" + a.toUTCString() + "; path=/"
                }
            }
        }
        function at() {
            if (ckTmp = af(Z), "" == ckTmp) {
                var a = new Date;
                ckTmp = 10000000000000 * Math.random() + "." + a.getTime(),
                av(Z, ckTmp)
            }
            return ckTmp
        }
        function ar() {
            var a = Math.floor(100 * Math.random());
            if (! (aw > a)) {
                return 0
            }
            window.suda = !0,
            "" == P && (P = at(Z)),
            "" == X && (X = af(J)),
            "" == B && (B = af(G));
            try {
                document.addEventListener ? (document.addEventListener("click", ap, !1), window.addEventListener("load", aa, !1)) : (document.attachEvent("onclick", ap), window.attachEvent("onload", aa))
            } catch(b) {}
            Q = escape(aq(window.document.referrer)),
            q = escape(aq(window.document.URL))
        }
        function ac(h, f, l, j) {
            var d = "";
            "undefined" != typeof sudaMapConfig.uId && (d = sudaMapConfig.uId),
            "undefined" != typeof sudaMapConfig.addRequestTime && (z = sudaMapConfig.addRequestTime),
            strSudsClickMapQuest = q + "|*|" + h + "|*|" + P + "|*|" + X + "|*|" + Q + "|*|" + Y + "|*|" + d + "|*|" + B;
            var g = F + "?" + strSudsClickMapQuest,
            b = new Image;
            window.SUDAPIC = b,
            b.src = g,
            window.SIMA(j);
            var k = f.toLocaleLowerCase();
            f && -1 == k.indexOf("javascript:") && setTimeout(function() {
                if (z) {
                    var m = (new Date).getTime(),
                    n = "user" + m + Math.random().toString().slice(2),
                    a = f.indexOf("?") > -1 ? "&": "?";
                    f = f + a + "clicktime=" + m + "&userid=" + n
                }
                if (console.log(f, am), "_blank" == l) {
                    var c = window.navigator.userAgent.toLowerCase();
                    /ucbrowser/i.test(c) ? window.location.href = "ext:wo:" + f + am: /qqbrowser/i.test(c) ? window.location.href = f + am: window.open(f + am)
                } else {
                    window.location.href = f + am
                }
            },
            200)
        }
        function ae(b, a, d) {
            for (var c = 0; d > c; c++) {
                if (!b.parentNode || b == document) {
                    return null
                }
                if (b = b.parentNode, a == b.tagName) {
                    break
                }
            }
            return c >= d ? null: b
        }
        function ap(E) {
            var E = E || event,
            O = E.srcElement || E.target;
            if (null == O && O == document) {
                return ! 1
            }
            var M = "",
            aD = "",
            aB = "",
            aA = "",
            az = "";
            if ("A" == O.tagName) {
                M = "txt",
                aD = ai(O.innerHTML),
                aB = aq(O.href, !0),
                az = O.getAttribute("target"),
                aA = O
            } else {
                if ("IMG" == O.tagName) {
                    M = "img",
                    aD = O.alt;
                    var A = ae(O, "A", 8);
                    A && (aB = aq(A.href, !0), az = O.getAttribute("target"), aA = A)
                } else {
                    M = "txt",
                    aD = ai(O.innerHTML);
                    var A = ae(O, "A", 8);
                    A && (aB = aq(A.href, !0), az = A.getAttribute("target"), aA = A)
                }
            }
            var R = "",
            S = O.tagName,
            N = "",
            ay = !1;
            try {
                for (i = 0; i < 10 && O != document; i++) {
                    var D = O.getAttribute("data-sudaclick");
                    if (D) {
                        var ax = O.getAttribute("data-sudatagname");
                        if (ax) {
                            ay = !0;
                            var aC = ax.split(",");
                            aC.forEach(function(a) {
                                console.log(a.toUpperCase(), S),
                                a.toUpperCase() == S && (ay = !1)
                            })
                        }
                        R = D;
                        for (var U = O.getElementsByTagName("A"), n = 0; n < U.length; n++) {
                            if (U[n].innerHTML == aA.innerHTML) {
                                N = n;
                                break
                            }
                        }
                        break
                    }
                    if (!O.parentNode) {
                        break
                    }
                    O = O.parentNode
                }
            } catch(aE) {}
            if (!ay && R) {
                aB && E.preventDefault(),
                aD && aD.length > 30 && (aD = aD.substr(0, 30));
                var j = new Date,
                u = j.getTime(),
                aB = aB.replace(/(\r\n)|(\n)|(\t)|(\<)|(\>)/gim, "");
                R = K ? R + "_" + K: R;
                var L = {
                    data: {
                        index: N,
                        aid: R,
                        url: encodeURIComponent(aB)
                    },
                    action: "_click"
                },
                s = "t=" + M + ",s=" + aD + ",h=" + escape(aB) + ",ct=" + u + ",aid=" + R + "-" + N + "|";
                ac(s, aB, az, L)
            }
        }
        function aa() {
            aj(window)
        }
        function aj(b) {
            for (var a = b.frames,
            d = 0; d < a.length; d++) {
                try {
                    "" != a[d].location && null != a[d].document && (document.addEventListener ? (a[d].document.removeEventListener("click", ap, !1), a[d].document.addEventListener("click", ap, !1)) : (a[d].document.detachEvent("onclick", ap), a[d].document.attachEvent("onclick", ap)), aj(a[d]))
                } catch(c) {}
            }
        }
        function ak() {
            var a = window.navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test(a) ? "ios": "android"
        }
        function ag(a) {
            window.checkLogin() ? window.getUserInfo(function(b) {
                a && a(b.uid || "")
            }) : a && a("")
        }
        function ao() {
            var b = (new Date).getTime(),
            a = Math.random();
            return "" + b + "_" + a
        }
        function ab(b) {
            var a = new Image;
            a.src = b
        }
        function an() {
            return ""
        }
        function au() {
            var b, a;
            return "function" == typeof window.getCookie && (b = af(J) || ""),
            "object" === _typeof(window.userInfo) && (a = userInfo.uid || ""),
            (a || "") + ";" + (b || "")
        }
        function al(a) {
            switch (a) {
            case "_click":
            case "click":
                return "CLICK";
            case "_exposure":
            case "exposure":
            case "_loadmore":
            case "loadmore":
                return "SLIDE";
            case "_up":
            case "up":
                return "POLLUP";
            case "_down":
            case "down":
                return "POLLDOWN";
            default:
                return ""
            }
        }
        function ad(a) {
            for (i in a) {
                "string" == typeof a[i] && (a[i] = a[i].replace(/(\r\n)|(\n)|(\t)|(\<)|(\>)/gim, ""))
            }
            return a
        }
        var Y = 0,
        aw = 100,
        K = "",
        z = !1,
        Z = "Apache",
        W = "",
        P = "",
        J = "ustat",
        G = "statuid",
        X = "",
        B = "",
        Q = document.referrer,
        q = document.URL,
        V = "//",
        H = "beacon2.api.com.cn",
        F = V + H + "/b.gif",
        am = "";
        "" == Q && (Q = "newpage"),
        window.suda_init = window.suds_init = function(b, a, d) {
            var c = arguments.length;
            c > 0 && (Y = b, aw = a, K = d, "function" == typeof window.getUserInfo ? window.getUserInfo(function(f) {
                f && f.uid && (window.sudaMapConfig.uId = f.uid),
                ar()
            },
            !0) : ar())
        },
        window.suda_count = window.suds_count = function(c) {
            if (!c.name) {
                return ! 1
            }
            c.type || (c.type = "btn"),
            c.title || (c.title = ""),
            c.index || (c.index = 0),
            c.href || (c.href = "");
            var b = "",
            f = "",
            d = (new Date).getTime(),
            a = "t=" + c.type + ",s=" + c.title + ",h=" + escape(c.href) + ",ct=" + d + ",aid=" + c.name + "-" + c.index + "|";
            f = void 0 == c.target ? "": c.target,
            ac(a, b, f)
        },
        "function" != typeof Object.assign && (Object.assign = function(d, b) {
            if (null == d) {
                throw new TypeError("Cannot convert undefined or null to object")
            }
            for (var g = Object(d), f = 1; f < arguments.length; f++) {
                var a = arguments[f];
                if (null != a) {
                    for (var c in a) {
                        Object.prototype.hasOwnProperty.call(a, c) && (g[c] = a[c])
                    }
                }
            }
            return g
        }),
        window.SIMA = function(g) {
            if (g && g.action && g.data) {
                var f = "//",
                h = "style/images",
                b = h + "/mrt.gif?",
                l = window.location.href.match(/\w+\.api\.cn/) || "";
                l = l ? l[0].split(".")[0] : "";
                var k = al(g.action),
                j = ak(),
                m = ao(),
                p = an();
                g.pk || (g.data.cre || g.data.mod ? g.pk = "187522": g.pk = "187523"),
                ag(function(d) {
                    g.data.uid = au();
                    var a = {
                        _pk: g.pk,
                        _src: "web",
                        _rk: m,
                        _v: "1.0",
                        _cp: {
                            os: j,
                            uid: d,
                            accesstype: p,
                            device_id: window.getCookie(J) || ""
                        },
                        _ep: [{
                            attribute: ad(g.data),
                            channel: l ? "wap_" + l: "",
                            ek: g.action || "",
                            ref: encodeURIComponent(aq( - 1 == window.document.referrer.indexOf("baidu") ? window.document.referrer: "baidu.com")) || "",
                            et: "custom",
                            src: g.src || encodeURIComponent(aq(window.location.href)) || "",
                            method: k,
                            timestamp: (new Date).getTime()
                        }]
                    };
                    if (window.SIMAconfig && window.SIMAconfig.reset) {
                        for (var c in window.SIMAconfig.reset) {
                            a[c] = Object.assign(a[c], window.SIMAconfig.reset[c])
                        }
                    }
                    ab(b + JSON.stringify(a))
                })
            }
        }
    } ()
} catch(e) {
    console.error(e, "suda_map.js")
};