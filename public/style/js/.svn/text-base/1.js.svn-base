!
function() {
    function z(a) {
        a && a()
    }
    function E() {
        document.addEventListener ? document.addEventListener("DOMContentLoaded",
        function() {
            D = (new Date).getTime(),
            document.removeEventListener("DOMContentLoaded", arguments.callee, !1)
        },
        !1) : document.getElementById && (document.write('<script id="ie-domReady" defer=\'defer\'src="//:"><\/script>'), document.getElementById("ie-domReady").onreadystatechange = function() {
            "complete" === this.readyState && (D = (new Date).getTime(), this.onreadystatechange = null, this.parentNode.removeChild(this))
        })
    }
    function k(aI) {
        function av(f, a) {
            var g = aC.getElementsByName(f),
            d = a > 0 ? a: 0;
            return g.length > d ? g[d].content: ""
        }
        function az() {
            for (var m = aC.getElementsByName("sudameta"), g = [], G = 0; G < m.length; G++) {
                var l = m[G].content;
                if (l) {
                    if ( - 1 != l.indexOf(";")) {
                        for (var f = l.split(";"), p = 0; p < f.length; p++) {
                            var d = aB(f[p]);
                            d && g.push(d)
                        }
                    } else {
                        g.push(l)
                    }
                }
            }
            return g.join("|")
        }
        function aw(g, d, m, f) {
            if ("" == g) {
                return ""
            }
            f = "" == f ? "=": f,
            d += f;
            var a = g.indexOf(d);
            if (0 > a) {
                return ""
            }
            a += d.length;
            var l = g.indexOf(m, a);
            return a > l && (l = g.length),
            g.substring(a, l)
        }
        function aE(a) {
            return void 0 == a || "" == a ? "": aw(aC.cookie, a, ";", "")
        }
        function ay(g, d, m, f) {
            if (null != d) {
                if ((void 0 == f || null == f) && (f = "api.cn"), void 0 == m || null == m || "" == m) {
                    aC.cookie = g + "=" + d + ";domain=" + f + ";path=/"
                } else {
                    var a = new Date,
                    l = a.getTime();
                    l += 86400000 * m,
                    a.setTime(l),
                    l = a.getTime(),
                    aC.cookie = g + "=" + d + ";domain=" + f + ";expires=" + a.toUTCString() + ";path=/"
                }
            }
        }
        function aL(f, a, g) {
            var d = f;
            return null == d ? !1 : (a = a || "click", "function" == (typeof g).toLowerCase() ? (d.attachEvent ? d.attachEvent("on" + a, g) : d.addEventListener ? d.addEventListener(a, g, !1) : d["on" + a] = g, !0) : void 0)
        }
        function aJ() {
            if (null != window.event) {
                return window.event
            }
            if (window.event) {
                return window.event
            }
            for (var d, a = arguments.callee.caller,
            f = 0; null != a && 40 > f;) {
                if (d = a.arguments[0], d && (d.constructor == Event || d.constructor == MouseEvent || d.constructor == KeyboardEvent)) {
                    return d
                }
                f++,
                a = a.caller
            }
            return d
        }
        function aH(a) {
            return a = a || aJ(),
            a.target || (a.target = a.srcElement, a.pageX = a.x, a.pageY = a.y),
            "undefined" == typeof a.layerX && (a.layerX = a.offsetX),
            "undefined" == typeof a.layerY && (a.layerY = a.offsetY),
            a
        }
        function aB(f) {
            if ("string" != typeof f) {
                throw "trim need a string as parameter"
            }
            for (var a = f.length,
            g = 0,
            d = /(\u3000|\s|\t|\u00A0)/; a > g && d.test(f.charAt(g));) {
                g += 1
            }
            for (; a > g && d.test(f.charAt(a - 1));) {
                a -= 1
            }
            return f.slice(g, a)
        }
        function aG(a) {
            return "[object Array]" === Object.prototype.toString.call(a)
        }
        function ax(m, I) {
            for (var g = aB(m).split("&"), d = {},
            l = function(a) {
                return I ? decodeURIComponent(a) : a
            },
            f = 0, G = g.length; G > f; f++) {
                if (g[f]) {
                    var H = g[f].split("="),
                    L = H[0],
                    p = H[1];
                    H.length < 2 && (p = L, L = "$nullName"),
                    d[L] ? (1 != aG(d[L]) && (d[L] = [d[L]]), d[L].push(l(p))) : d[L] = l(p)
                }
            }
            return d
        }
        function aA(a) {
            au(a)
        }
        function au(d) {
            var a = new Image;
            SUDA.img = a,
            a.src = d
        }
        function at(g, d, l, f) {
            SUDA.sudaCount++;
            var a = af + [ah.V(), ah.CI(), ah.PI(l, f), ah.UI(), ah.MT(), ah.EX(g, d), ah.R()].join("&");
            au(a)
        }
        function aF(d, a, f) {
            0 == SUDA.sudaCount && at(d, a, f)
        }
        function aq(f, a, i) {
            i = i ? escape(i) : "";
            var d = "UATrack||" + aE(ae) + "||" + aE(an) + "||" + s.userNick() + "||" + f + "||" + a + "||" + ai.referrer() + "||" + i + "||",
            g = K + d + "&gUid_" + (new Date).getTime();
            aA(g)
        }
        function am(f, a, i) {
            i = i ? escape(i) : "";
            var d = "UATrack||" + aE(ap) + "||" + aE(an) + "||" + s.userNick() + "||" + f + "||" + a + "||" + ai.referrer() + "||" + i + "||",
            g = K + d + "&gUid_" + (new Date).getTime();
            aA(g)
        }
        function Q(g) {
            var d, m = aH(g),
            f = m.target,
            a = "",
            l = "";
            if (null != f && f.getAttribute && !f.getAttribute("suda-uatrack") && !f.getAttribute("suda-data")) {
                for (; null != f && f.getAttribute && 0 == ( !! f.getAttribute("suda-uatrack") || !!f.getAttribute("suda-data"));) {
                    if (f == aC.body) {
                        return
                    }
                    f = f.parentNode
                }
            }
            null != f && null != f.getAttribute && (a = f.getAttribute("suda-uatrack") || f.getAttribute("suda-data") || "", a && (d = ax(a), "a" == f.tagName.toLowerCase() && (l = f.href), d.key && SUDA.uaTrack && SUDA.uaTrack(d.key, d.value || d.key, l)))
        }
        var aK = window,
        aC = document,
        aM = navigator,
        ag = (aM.userAgent, aK.screen),
        ao = aK.location.href,
        ar = "style/images",
        af = ar + "/a.gif?",
        K = ar + "/e.gif?",
        al = "",
        W = "";
        startTime = "",
        readyTime = "",
        ext1 = "",
        ext2 = "",
        currTime = parseInt((new Date).getTime()),
        "undefined" != typeof sudaLogConfig && (al = void 0 !== sudaLogConfig.uId ? sudaLogConfig.uId: "", W = void 0 !== sudaLogConfig.url ? sudaLogConfig.url: "", "undefined" != typeof globalConfig && (startTime = void 0 !== globalConfig.startTime ? globalConfig.startTime: F), ext1 = void 0 !== sudaLogConfig.ext1 ? sudaLogConfig.ext1: "", ext2 = void 0 !== sudaLogConfig.ext2 ? sudaLogConfig.ext2: ""),
        al = al || aI || "",
        onloadTime = currTime - startTime,
        readyTime = D - startTime;
        var ak = "MT=" + (az() || "");
        if ("undefined" != typeof sudaLogConfig && "undefined" != typeof sudaLogConfig.prevPageClickTime && "" !== sudaLogConfig.prevPageClickTime) {
            var ad = void 0 !== sudaLogConfig.prevPageClickTime ? sudaLogConfig.prevPageClickTime: 0,
            ac = startTime - ad;
            ak += "|mperform:1|starttime:" + ad + "|endtime:" + startTime + "|clicktime:" + ac
        }
        var aD = aC.referrer.toLowerCase(),
        ae = "apiGLOBAL",
        an = "Apache",
        ab = "ULV",
        aa = "SUP",
        ap = "ustat",
        J = "",
        u = "",
        c = "",
        aj = {
            screenSize: function() {
                return ag.width + "x" + ag.height
            },
            colorDepth: function() {
                return ag.colorDepth || ""
            },
            appCode: function() {
                return aM.appCodeName || ""
            },
            appName: function() {
                return aM.appName.indexOf("Microsoft Internet Explorer") > -1 ? "MSIE": aM.appName
            },
            cpu: function() {
                return aM.cpuClass || aM.oscpu || ""
            },
            platform: function() {
                return aM.platform || ""
            },
            jsVer: function() {
                var g, d, m, f = 1,
                a = aM.appName.indexOf("Microsoft Internet Explorer") > -1 ? "MSIE": aM.appName,
                l = aM.appVersion;
                return "MSIE" == a ? (d = "MSIE", g = l.indexOf(d), g >= 0 && (m = window.parseInt(l.substring(g + 5)), m >= 3 && (f = 1.1, m >= 4 && (f = 1.3)))) : ("Netscape" == a || "Opera" == a || "Mozilla" == a) && (f = 1.3, d = "Netscape6", g = l.indexOf(d), g >= 0 && (f = 1.5)),
                f
            },
            network: function() {
                var d = "";
                d = aM.connection && aM.connection.type ? aM.connection.type: d;
                try {
                    aC.body.addBehavior("#default#clientCaps"),
                    d = aC.body.connectionType
                } catch(a) {
                    d = "unkown"
                }
                return d
            },
            language: function() {
                return aM.systemLanguage || aM.language || ""
            },
            timezone: function() {
                return (new Date).getTimezoneOffset() / 60 || ""
            },
            flashVer: function() {
                return ""
            },
            javaEnabled: function() {
                var g, d, l = aM.plugins,
                f = aM.javaEnabled();
                if (1 == f) {
                    return 1
                }
                if (l && l.length) {
                    for (var a in l) {
                        if (g = l[a], null != g.description) {
                            if (null != f) {
                                break
                            }
                            d = g.description.toLowerCase(),
                            -1 == d.indexOf("java plug-in") || (f = parseInt(g.version))
                        }
                    }
                } else {
                    window.ActiveXObject && (f = null != new ActiveXObject("JavaWebStart.IsInstalled"))
                }
                return f ? 1 : 0
            }
        },
        ai = {
            pageId: function() {
                return ""
            },
            sessionCount: function() {
                return ""
            },
            excuteCount: function() {
                return SUDA.sudaCount
            },
            referrer: function() {
                var d = /^[^\?&#]*.swf([\?#])?/;
                if ("" == aD || aD.match(d)) {
                    var a = aw(ao, "ref", "&", "");
                    if ("" != a) {
                        return escape(a)
                    }
                }
                return escape(aD)
            },
            isHomepage: function() {
                var d = "";
                try {
                    aC.body.addBehavior("#default#homePage"),
                    d = aC.body.isHomePage(ao) ? "Y": "N"
                } catch(a) {
                    d = "unkown"
                }
                return d
            },
            PGLS: function() {
                return av("stencil") || ""
            },
            ZT: function() {
                var a = av("subjectid");
                return a.replace(",", "."),
                a.replace(";", ","),
                escape(a)
            },
            mediaType: function() {
                return az() || ""
            },
            domCount: function() {
                return aC.getElementsByTagName("*").length || ""
            },
            iframeCount: function() {
                return aC.getElementsByTagName("iframe").length
            },
            onloadTime: onloadTime,
            readyTime: readyTime,
            webUrl: W,
            ch: function() {
                return window.__docConfig ? __docConfig.__domain: ""
            },
            PE: function() {
                var a = document.getElementsByName("sudameta")[0];
                return a ? a.content: ""
            }
        },
        s = {
            visitorId: function() {
                if ("" != ae) {
                    var d = aE(ae);
                    if (1, "" == d) {
                        d = aE(an);
                        var a = 3650;
                        ay(ae, d, a)
                    }
                    return d
                }
                return ""
            },
            sessionId: function() {
                var d = aE(an);
                if ("" == d) {
                    var a = new Date;
                    d = 10000000000000 * Math.random() + "." + a.getTime(),
                    ay(an, d)
                }
                return d
            },
            flashCookie: function(a) {
                return ""
            },
            lastVisit: function() {
                var l, g = aE(an),
                m = aE(ab),
                i = m.split(":"),
                d = "";
                if (i.length >= 6) {
                    if (g != i[4]) {
                        l = new Date;
                        var f = new Date(window.parseInt(i[0]));
                        i[1] = window.parseInt(i[1]) + 1,
                        l.getMonth() != f.getMonth() ? i[2] = 1 : i[2] = window.parseInt(i[2]) + 1,
                        (l.getTime() - f.getTime()) / 86400000 >= 7 ? i[3] = 1 : l.getDay() < f.getDay() ? i[3] = 1 : i[3] = window.parseInt(i[3]) + 1,
                        d = i[0] + ":" + i[1] + ":" + i[2] + ":" + i[3],
                        i[5] = i[0],
                        i[0] = l.getTime(),
                        ay(ab, i[0] + ":" + i[1] + ":" + i[2] + ":" + i[3] + ":" + g + ":" + i[5], 360)
                    } else {
                        d = i[5] + ":" + i[1] + ":" + i[2] + ":" + i[3]
                    }
                } else {
                    l = new Date,
                    d = ":1:1:1",
                    ay(ab, l.getTime() + d + ":" + g + ":", 360)
                }
                return d
            },
            userNick: function() {
                if ("" != J) {
                    return J
                }
                var i = unescape(aE(aa)),
                g = "",
                m = "",
                l = al,
                d = "",
                f = "";
                return "" != i && (g = aw(i, "ag", "&", ""), m = aw(i, "user", "&", ""), al = aw(i, "uid", "&", ""), d = aw(i, "sex", "&", ""), f = aw(i, "dob", "&", "")),
                J = g + ":" + m + ":" + l + ":" + d + ":" + f
            },
            userOrigin: function() {
                return ""
            },
            advCount: function() {
                return ""
            },
            subp: function() {
                return aE("SUBP")
            }
        },
        ah = {
            CI: function() {
                var a = ["sz:" + aj.screenSize(), "dp:" + aj.colorDepth(), "ac:" + aj.appCode(), "an:" + aj.appName(), "cpu:" + aj.cpu(), "pf:" + aj.platform(), "jv:" + aj.jsVer(), "ct:" + aj.network(), "lg:" + aj.language(), "tz:" + aj.timezone(), "fv:" + aj.flashVer(), "ja:" + aj.javaEnabled()];
                return "CI=" + a.join("|")
            },
            PI: function(f, a) {
                var g = ai.webUrl;
                f && (g = escape(f));
                var d = ["pid:" + ai.pageId(), "st:" + ai.sessionCount(), "et:" + ai.excuteCount(), "ref:" + (a || ai.referrer()), "hp:" + ai.isHomepage(), "PGLS:" + ai.PGLS(), "ZT:" + ai.ZT(), "MT:", "keys:", "dom:" + ai.domCount(), "ifr:" + ai.iframeCount(), "nld:" + ai.onloadTime, "drd:" + ai.readyTime, "url:" + g, "ch:" + ai.ch()];
                return "PI=" + d.join("|")
            },
            UI: function() {
                var a = ["vid:" + s.visitorId(), "sid:" + s.sessionId(), "lv:" + s.lastVisit(), "un:" + s.userNick(), "uo:" + s.userOrigin(), "ae:" + s.advCount(), "su:" + s.subp(), "lu:", "si:", "rs:0", "dm:0"];
                return "UI=" + a.join("|")
            },
            EX: function(d, a) {
                return d = null != d ? d || "": u,
                a = null != a ? a || "": c,
                "EX=ex1:" + d + "|ex2:ustat-" + aE(ap) + (a ? "," + a: "")
            },
            MT: function() {
                return ak
            },
            V: function() {
                return "V=2.3.1"
            },
            R: function() {
                return "gUid_" + (new Date).getTime()
            }
        };
        window.SUDA = window.SUDA || [],
        SUDA.sudaCount = SUDA.sudaCount || 0,
        SUDA.log = function() {
            at.apply(null, arguments)
        },
        SUDA.uaTrack = function() {
            aq.apply(null, arguments)
        },
        SUDA.uaTrackLike = function() {
            am.apply(null, arguments)
        },
        aL(aC.body, "click", Q),
        window.sudaLogConfig && window.sudaLogConfig.preventDefault || aF(ext1, ext2)
    }
    function b(f, c) {
        c = c || "encode";
        for (var l = ["a", "B", "X", "M", "Z", "Y", "Q", "c", "I", "p"], d = "", a = 0, g = f.length; g > a; a++) {
            d += "encode" == c ? l[parseInt(f[a])] : l.indexOf(f[a])
        }
        return d
    }
    function w(m) {
        m.data = m.data || {},
        m.timeout = m.timeout || 0,
        m.callback = m.callback || "callback";
        var g = "jsonp_" + Math.random();
        g = g.replace(".", ""),
        window[g] = function(a) {
            clearTimeout(d),
            m.success && m.success(a),
            m.complete && m.complete(),
            c.removeChild(p),
            window[g] = null
        },
        m.data[m.callback] = g;
        var s = [];
        for (var l in m.data) {
            s.push(l + "=" + encodeURIComponent(m.data[l]))
        }
        var f = "&" + s.join("&"),
        p = document.createElement("script");
        p.src = m.url + f;
        var c = document.getElementsByTagName("head")[0];
        if (c.appendChild(p), m.timeout) {
            var d = setTimeout(function() {
                m.error && m.error(),
                m.complete && m.complete(),
                c.removeChild(p),
                window[g] = null
            },
            m.timeout)
        }
    }
    function j(a) {
        document.cookie = a + "=;expires=Fri, 31 Dec 1999 23:59:59 GMT;path=/;domain=.api.cn"
    }
    function C(f, c, l, d) {
        if ("" == f) {
            return ""
        }
        d = "" == d ? "=": d,
        c += d;
        var a = f.indexOf(c);
        if (0 > a) {
            return ""
        }
        a += c.length;
        var g = f.indexOf(l, a);
        return a > g && (g = f.length),
        f.substring(a, g)
    }
    var D = "",
    F = (new Date).getTime();
    E();
    var B = "//";
    window.checkLogin = function() {
        if (getCookie("SUBP")) {
            var c = v.decode(getCookie("SUBP"));
            if ("object" == typeof c) {
                if ("0" === c.status) {
                    var a = !0
                } else {
                    var a = !1
                }
            } else {
                var a = !1
            }
        } else {
            var a = !1
        }
        return a
    };
    var A = {
        uid: "",
        nick: "手机新浪网用户",
        portrait_url: "//n.apiimg.cn/default/b4f710f5/20170112/default_avatar_male_50.gif"
    };
    window.getUserInfo = function(m, g, o) {
        if (window.userInfo) {
            return void(m && m(window.userInfo))
        }
        if (g = g || !1, !window.checkLogin() && !o) {
            return j("api_ucode"),
            window.userInfo = !1,
            void(m && m({}))
        }
        if (m && g) {
            var d = getCookie("api_ucode");
            if (d) {
                return m({
                    uid: b(d, "decode")
                })
            }
        }
        if (window.getUserInfo.aFn || (window.getUserInfo.aFn = []), window.getUserInfo.aFn.push(m), !(window.getUserInfo.aFn.length > 1)) {
            var f = B + "passport.api.cn/sso/islogin?"; - 1 == f.indexOf("?") && (f += "?");
            var i = new Date,
            c = {
                random: Math.random(),
                time: i.getTime()
            };
            w({
                success: function(a) {
                    a.data = a.data || {},
                    a.data.uid || (j("SUBP"), a.data = A),
                    a.data.uname = a.data.nick,
                    a.data.userface = a.data.portrait_url,
                    a.data.uid && (a.data.islogin = 1),
                    a.data.uid && y("api_ucode", b(a.data.uid), 240, "/", ".api.cn"),
                    window.userInfo = a.data,
                    window.getUserInfo.aFn.length > 0 && window.getUserInfo.aFn.forEach(function(e) {
                        "function" == typeof e && e(a.data)
                    })
                },
                error: function() {
                    m({})
                },
                url: f,
                data: c,
                timeout: 3000
            })
        }
    },
    window.getCookie = function(a) {
        return void 0 == a || "" == a ? !1 : C(document.cookie, a, ";", "")
    };
    var y = function(l, G, f, c, g, d) {
        var m = [];
        if (m.push(l + "=" + escape(G)), f) {
            var p = new Date,
            H = p.getTime() + 3600000 * f;
            p.setTime(H),
            m.push("expires=" + p.toGMTString())
        }
        c && m.push("path=" + c),
        g && m.push("domain=" + g),
        d && m.push(d),
        document.cookie = m.join(";")
    },
    v = {
        __parse: function(m) {
            var I, g, d, l, f = 0,
            G = {},
            H = "",
            J = "";
            if (!m) {
                return G
            }
            do {
                for (g = m[f], I = ++f, l = f; g + I > l; l++, f++) {
                    H += String.fromCharCode(m[l])
                }
                if (d = m[f], I = ++f, "status" == H || "flag" == H) {
                    for (l = f; d + I > l; l++, f++) {
                        J += m[l]
                    }
                } else {
                    J = m.slice(l, d + I);
                    try {
                        J = h(J)
                    } catch(p) {
                        J = ""
                    }
                    f += d
                }
                G[H] = J, H = "", J = ""
            } while ( f < m . length );
            return G
        },
        decode: function(f) {
            var c, g = [],
            d = f.substr(0, 3),
            a = decodeURIComponent(f.substr(3));
            switch (d) {
            case "002":
                return g = x.decode(a, "subp_v2", "array"),
                v.__parse(g);
            case "003":
                return c = a.substr(0, 1),
                a = a.substr(1),
                g = x.decode(a, "subp_v3_" + c, "array"),
                v.__parse(g);
            default:
                return decodeURIComponent(f)
            }
        }
    },
    x = {
        encode: function(m) {
            if (m = "" + m, "" == m) {
                return ""
            }
            var I, g, d, l, f, G = "",
            H = "",
            J = "",
            p = 0;
            do {
                I = m.charCodeAt(p++), g = m.charCodeAt(p++), H = m.charCodeAt(p++), d = I >> 2, l = (3 & I) << 4 | g >> 4, f = (15 & g) << 2 | H >> 6, J = 63 & H, isNaN(g) ? f = J = 64 : isNaN(H) && (J = 64), G = G + this._keys.charAt(d) + this._keys.charAt(l) + this._keys.charAt(f) + this._keys.charAt(J), I = g = H = "", d = l = f = J = ""
            } while ( p < m . length );
            return G
        },
        decode: function(P, V, J) {
            var G = function(c, a) {
                for (var d = 0; d < c.length; d++) {
                    if (c[d] === a) {
                        return d
                    }
                }
                return - 1
            };
            "string" == typeof P && (P = P.split(""));
            var M, I, S, U, W, R = [],
            Q = "",
            O = "";
            P.length % 4 != 0;
            var L = /[^A-Za-z0-9+\/=]/,
            N = this._keys.split("");
            "urlsafe" == V && (L = /[^A-Za-z0-9-_=]/, N = this._keys_urlsafe.split("")),
            "subp_v2" == V && (L = /[^A-Za-z0-9_=-]/, N = this._subp_v2_keys.split("")),
            "subp_v3_3" == V && (L = /[^A-Za-z0-9-_.-]/, N = this._subp_v3_keys_3.split(""));
            var H = 0;
            if ("binnary" == V) {
                for (N = [], H = 0; 64 >= H; H++) {
                    N[H] = H + 128
                }
            }
            if ("binnary" != V && L.test(P.join(""))) {
                return "array" == J ? [] : ""
            }
            H = 0;
            do {
                S = G(N, P[H++]), U = G(N, P[H++]), W = G(N, P[H++]), O = G(N, P[H++]), M = S << 2 | U >> 4, I = (15 & U) << 4 | W >> 2, Q = (3 & W) << 6 | O, R.push(M), 64 != W && -1 != W && R.push(I), 64 != O && -1 != O && R.push(Q), M = I = Q = "", S = U = W = O = ""
            } while ( H < P . length );
            if ("array" == J) {
                return R
            }
            for (var K = "",
            T = 0; T < R.lenth; T++) {
                K += String.fromCharCode(R[T])
            }
            return K
        },
        _keys: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
        _keys_urlsafe: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_=",
        _subp_v2_keys: "uAL715W8e3jJCcNU0lT_FSXVgxpbEDdQ4vKaIOH2GBPtfzqsmYZo-wRM9i6hynrk=",
        _subp_v3_keys_3: "5WFh28sGziZTeS1lBxCK-HgPq9IdMUwknybo.LJrQD3uj_Va7pE0XfcNR4AOYvm6t"
    },
    h = function(c) {
        for (var a = "",
        d = 0; d < c.length; d++) {
            a += "%" + q(c[d])
        }
        return decodeURIComponent(a)
    },
    q = function(c) {
        var a = "0" + c.toString(16);
        return a.length <= 2 ? a: a.substr(1)
    };
    z(function() {
        getUserInfo(function(a) {
            a.uid ? k(a.uid) : k()
        },
        !0)
    })
} (),
function() {
    function b(f) {
        function c() {
            return (new Date).getTime()
        }
        function g() {
            var h = c(),
            e = h - window.heartbeat_lastInterval;
            window.heartbeat_lastInterval = h,
            e > 3000 && f && f()
        }
        var d;
        "onpageshow" in window && "onpagehide" in window ? (window.addEventListener("pageshow",
        function(e) {
            e.persisted ? f && f() : g()
        },
        !1), window.addEventListener("pagehide",
        function(h) {
            window.mimic_bfc_cache_ts = (new Date).getTime()
        },
        !1)) : (d = setInterval(g, 800), window.heartbeat_lastInterval = (new Date).getTime())
    }
    var a = {
        set: function(j, g, l, h, f) {
            var k = [];
            if (k.push(j + "=" + g), l) {
                var c = new Date,
                d = c.getTime() + 3600000 * l;
                c.setTime(d),
                k.push("expires=" + c.toGMTString())
            }
            h && k.push("path=" + h),
            f && k.push("domain=" + f),
            document.cookie = k.join(";")
        },
        getRecord: function() {
            var c = window.getCookie("historyRecord") || "";
            return window.historyRecord = c = c ? JSON.parse(c) : c,
            c
        },
        setRecord: function() {
            var c = {
                href: -1 == window.location.href.indexOf("?") ? window.location.href: window.location.href.split("?")[0],
                refer: -1 == document.referrer.indexOf("?") ? document.referrer: document.referrer.split("?")[0]
            };
            a.set("historyRecord", JSON.stringify(c), 24, "/", ".api.cn")
        }
    };
    a.setRecord(),
    ( - 1 != window.location.href.indexOf("//api.cn") || window.sudaLogConfig && sudaLogConfig.backOff) && b(function() {
        var c = a.getRecord();
        if (c && -1 == c.href.indexOf("//api.cn")) {
            var d = c.href
        } else {
            var d = ""
        }
        SUDA.log("", "twice", "", d),
        apiSax && apiSax.callback("saxHistory")
    })
} (),
-1 == window.navigator.userAgent.toLowerCase().indexOf("weibo") && window.addEventListener("load",
function() { !
    function(c, a, d) {
        var b = "http:" == window.location.protocol ? "//r.dmp.api.cn": "//cm.dmp.api.cn";
        setTimeout(function() {
            var e = c.getElementsByTagName(a)[0];
            c.getElementById(d) || (a = c.createElement(a), a.id = d, a.setAttribute("charset", "utf-8"), a.src = "", e.parentNode.insertBefore(a, e))
        },
        1000)
    } (document, "script", "apiads-ck-script")
},
!1),
function() {
    function b(h) {
        function m(s) {
            var p = {};
            if (s) {
                for (var u = s.split("&"), q = 0; q < u.length; q++) {
                    var o = u[q].split("=");
                    o && (p[o[0]] = o[1])
                }
                return p
            }
            return p
        }
        for (var d = 0; d < h.length; d++) {
            var g = h[d],
            f = g.getAttribute("href");
            if (f && -1 != f.indexOf("http")) {
                var k = f.lastIndexOf("?"),
                l = k > -1,
                n = l ? f.slice(k + 1) : "",
                j = m(n);
                j.wm || (f = l ? f: f + "?", f = f + "&wm=" + c, f = f.replace("?&", "?"), g.setAttribute("href", f))
            }
        }
    }
    function a(g, d) {
        var h = new RegExp(d + "=(.*?)(&|$)"),
        f = g.match(h);
        return null != f ? f[1] : ""
    }
    if ( - 1 != window.location.href.indexOf("wm")) {
        var c = a(window.location.href, "wm");
        document.addEventListener("DOMNodeInserted",
        function(d) {
            switch (d.target.tagName) {
            case void 0:
                return;
            case "A":
                var e = [d.target];
                break;
            default:
                var e = d.target.querySelectorAll("a")
            }
            b(e)
        },
        !1)
    }
} ();