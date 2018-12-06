var xh5_define, KKE = KKE || {};~
function(t) {
    function e(f, m, j) {
        if (!u.isStr(f)) {
            return void u.err(j, [o.CMD_UNEXIST, f].join(":"))
        }
        m = m || {};
        var k = f.split("."),
        p = k.splice(k.length - 1, k.length).join(""),
        g = k.splice(k.length - 1, k.length).join(""),
        b = k.splice(0, k.length),
        q = b.join("."),
        h = [q, g].join(".");
        d.relyCall(h,
        function() {
            var x = d.modsTree,
            v = void 0;
            do {
                var w = b.shift();
                if (v = v ? v[w] : x[w], !v) {
                    return void u.err(j, [o.MOD_ERR, g].join(":"))
                }
            } while ( b . length );
            var z = v[g] || {},
            A = z.entity || {},
            y = A[p];
            "undefined" == typeof y ? u.err(j, [o.CMD_UNEXIST, f].join(":")) : u.isFunc(y) ? y(m, j) : u.isFunc(j) && j(y)
        },
        m.modUrl || null)
    }
    for (var n, r, o = {
        SDK_REG: new RegExp("sf_sdk.js", a),
        isLocal: !1,
        isDebug: !1,
        isSSL: !0,
        custom_mod_url: void 0,
        MOD_URL: "js/$moduleName.js",
        MOD_URL_PROD: "style/js/$moduleName.js",
        MOD_URL_PROD_S: "style/js/$moduleName.js",
        getModUrl: function() {
            return this.custom_mod_url ? this.custom_mod_url + "/$moduleName.js": this.isLocal ? this.MOD_URL: this.isSSL ? this.MOD_URL_PROD_S: this.MOD_URL_PROD
        },
        CMD_404: "error occured while loading",
        CMD_UNEXIST: "calling nonexistent API",
        MOD_ERR: "erroneous module",
        MOD_DEF_ERR: "illegal module",
        DEP_ERR: "error def module"
    },
    i = document.getElementsByTagName("script"), a = i.length; a--;) {
        if (n = i[a], r = n.src || "", o.SDK_REG.test(r)) {
            for (var s, l = n.attributes.length; l--;) {
                s = n.attributes[l],
                "ssl" == s.name && (o.isSSL = "true" == s.value),
                "debug" == s.name && (o.isDebug = "true" == s.value),
                "local" == s.name && (o.isLocal = "true" == s.value),
                "murl" == s.name && (o.custom_mod_url = s.value)
            }
            break
        }
    }
    0 == location.protocol.indexOf("http:") && (o.isSSL = !0);
    var u = new
    function() {
        function b(g, j, q, m) {
            var v = !1,
            k = document.createElement("script"),
            h = document.getElementsByTagName("script")[0],
            w = document.head || document.getElementsByTagName("head")[0] || document.documentElement,
            p = w.getElementsByTagName("base")[0];
            k.charset = m || "gb2312",
            k.src = g,
            k.async = !0,
            k.onload = k.onreadystatechange = function() {
                v || k.readyState && !/loaded|complete/.test(String(k.readyState)) || (v = !0, k.onload = k.onreadystatechange = k.onerror = null, k.parentNode.removeChild(k), k = null, "function" == typeof j && j())
            },
            k.onerror = function() {
                k.onload = k.onreadystatechange = k.onerror = null,
                k.parentNode.removeChild(k),
                k = null,
                "function" == typeof q && q()
            },
            h.parentNode ? h.parentNode.insertBefore(k, h) : p ? w.insertBefore(k, p) : w.appendChild(k)
        }
        this.fBind = function(j, h) {
            var g = Array.prototype.slice.call(arguments, 2);
            return function() {
                return j.apply(h, g.concat(Array.prototype.slice.call(arguments)))
            }
        };
        var f = function(g) {
            return function(h) {
                return {}.toString.call(h) == "[object " + g + "]"
            }
        };
        this.isStr = f("String"),
        this.isFunc = f("Function"),
        this.isArr = f("Array"),
        this.trace = function(g) {
            return {
                log: function() {
                    g && g.log && g.log.apply(g, arguments)
                },
                error: function() {
                    g && g.error && g.error.apply(g, arguments)
                }
            }
        } (null),
        this.err = function(h, g) {
            this.isFunc(h) && h({
                msg: g,
                data: null
            }),
            this.trace.error(g)
        },
        this.load = b
    },
    c = ["datas.hq", "datas.k", "datas.t", "utils.util"],
    d = new
    function() {
        function w(y, C, x) {
            if (3 != arguments.length) {
                return void u.trace.error(o.MOD_DEF_ERR, y)
            }
            var F = j(y),
            z = F[0],
            P = F[1],
            A = z[P];
            A ? A.init = !0 : A = z[P] = {
                init: !0,
                name: y,
                funcQ: [],
                entity: void 0
            },
            u.isStr(C) && (C = [C]);
            for (var B, D = C.length; D--;) {
                if (B = C[D], B.indexOf("*") > -1) {
                    C.splice(D, 1);
                    var Q = B.split(".");
                    Q.splice(Q.length - 1, Q.length);
                    var E = Q.join(".");
                    C = C.concat(k(E, y));
                    break
                }
            }
            v(C, C.slice(0), A, x)
        }
        var g = {},
        j = function(B) {
            for (var x, z = B.split("."), y = z.splice(z.length - 1, z.length).join(""), C = z.splice(0, z.length), D = C.join("."), A = void 0; C.length;) {
                var E = C.shift();
                A ? (x = A[E], x || (x = A[E] = {})) : (x = g[E], x || (x = g[E] = {})),
                A = x
            }
            return [A, y, D]
        },
        m = function(x) {
            for (; x.funcQ.length;) {
                var y = x.funcQ.shift();
                u.isFunc(y) && y()
            }
        },
        p = function(B) {
            if (!B) {
                return null
            }
            for (var x = [], z = [], C = 0, D = B.length; D > C; C++) {
                for (var A, E = B[C].split("."), y = void 0; E.length;) {
                    if (A = E.shift(), y = y ? y[A] : g[A], !y) {
                        u.trace.error(o.DEP_ERR, E.toString());
                        break
                    }
                }
                z.push(y.entity),
                x.push(A)
            }
            return {
                n: x,
                e: z
            }
        },
        b = function(z, x, A) {
            var C = x.toString(),
            B = 0 == C.indexOf("function");
            if (B) {
                var D = p(A),
                y = x.apply(null, D.e.concat(g));
                z.entity = u.isFunc(y) ? new y: y
            } else {
                z.entity = x
            }
            m(z)
        },
        v = function(y, z, x, A) {
            z.length ? h(z.shift(), u.fBind(v, this, y, z, x, A)) : b(x, A, y)
        },
        q = function(y, z, x) {
            z = z.replace(/\./g, "/"),
            x && (x += "$moduleName.js");
            var A = x || o.getModUrl();
            u.load(A.replace("$moduleName", z), null, u.fBind(u.trace.error, this, o.CMD_404, y.name))
        },
        f = function(C, A) {
            u.isArr(C) && (C = C.join("."));
            var z = j(C),
            y = z[0],
            x = z[1],
            B = y[x];
            return B || (B = {
                init: !1,
                name: C,
                funcQ: [],
                entity: void 0
            },
            y[x] = B, q(B, C, A)),
            B
        },
        k = function(y, z) {
            for (var A, B = [], x = c.length; x--;) {
                A = c[x],
                0 == A.indexOf(y) && -1 == A.indexOf(z) && (B[B.length] = A)
            }
            return B
        },
        h = function(y, z, x) {
            var A = f(y, x);
            u.isFunc(z) && (A.init ? z() : A.funcQ.push(z))
        };
        this.modsTree = g,
        this.relyCall = h,
        xh5_define = w
    };
    t.api = e,
    t.cls = {},
    t.istLL = "KKE|1.0.4|WANGXuan|apiFinance|wangxuan2@staff.api.com.cn"
} (KKE);
xh5_define("utils.util", [],
function() {
    return function() {
        function p(q, j) {
            var z = x(j.prototype);
            z.constructor = q,
            q.prototype = z
        }
        function S() {
            this.evtObj = {}
        }
        function g(q, j) {
            var z = Array.prototype.slice.call(arguments, 2);
            return function() {
                return q.apply(j, z.concat(Array.prototype.slice.call(arguments)))
            }
        }
        function h() {
            return Date.now ? Date.now() : (new Date).getTime()
        }
        function l(q, D) {
            D || (q = q.toLowerCase());
            for (var z, B = 1315423911,
            j = q.length; j--;) {
                z = q.charCodeAt(j),
                B ^= (B << 5) + z + (B >> 2)
            }
            return 2147483647 & B
        }
        function c(j, B, F, G) {
            var H = !1,
            D = document.createElement("script"),
            z = document.getElementsByTagName("script")[0],
            I = document.head || document.getElementsByTagName("head")[0] || document.documentElement,
            E = I.getElementsByTagName("base")[0];
            G = G || {};
            var q;
            D.charset = G.charset || "gb2312",
            D.src = j,
            D.async = !0,
            D.onload = D.onreadystatechange = function() {
                if (!H && (!D.readyState || /loaded|complete/.test(D.readyState))) {
                    if (q) {
                        var K = new Date - q,
                        J = G.market.toLowerCase(),
                        L = G.type.toLowerCase();
                        y.sima({
                            simadata: {
                                cre: J,
                                mod: L,
                                during: K
                            },
                            symbol: G.symbol,
                            type: G.type
                        })
                    }
                    H = !0,
                    D.onload = D.onreadystatechange = D.onerror = null,
                    D.parentNode.removeChild(D),
                    D = null,
                    "function" == typeof B && B()
                }
            },
            D.onerror = function() {
                if (q) {
                    var K = new Date - q,
                    J = G.market.toLowerCase(),
                    L = G.type.toLowerCase();
                    y.sima({
                        simadata: {
                            cre: J,
                            mod: L,
                            during: K,
                            error_type: "err"
                        },
                        symbol: G.symbol,
                        type: G.type
                    })
                }
                D.onload = D.onreadystatechange = D.onerror = null,
                D.parentNode.removeChild(D),
                D = null,
                "function" == typeof F && F()
            },
            G.market && G.type && G.symbol && (q = new Date),
            z.parentNode ? z.parentNode.insertBefore(D, z) : E ? I.insertBefore(D, E) : I.appendChild(D)
        }
        function A() {
            function q(J) {
                var K = J.style;
                for (var I in K) {
                    K.hasOwnProperty(I) && (J.dom.style[I] = K[I])
                }
            }
            function B() {
                for (var J = ["@keyframes KKELoading", "@-webkit-keyframes KKELoading", "@-moz-keyframes KKELoading"], K = 0, I = J.length; I > K; K++) {
                    r.cssUtil.inject(J[K] + E.scaleY)
                }
            }
            function F() {
                if (B(), !H) {
                    H = r.$C("div"),
                    q({
                        dom: H,
                        style: E.ctn
                    });
                    for (var J = 0.1,
                    L = 0,
                    I = E.color.length; I > L; L++) {
                        var Q = r.$C("span");
                        q({
                            dom: Q,
                            style: E.item
                        });
                        var O = r.clone(E.delay, O),
                        K = -1 + J * L + "s";
                        for (var M in O) {
                            O.hasOwnProperty(M) && (O[M] = K)
                        }
                        q({
                            dom: Q,
                            style: O
                        }),
                        Q.style.background = E.color[L],
                        H.appendChild(Q)
                    }
                }
            }
            function G() {
                clearTimeout(z),
                z = setTimeout(function() {
                    "none" != H.style.display && (H.style.display = "none")
                },
                9000)
            }
            var H, D, z, j, E = {
                ctn: {
                    width: "40px",
                    height: "30px",
                    margin: 0,
                    display: "none",
                    position: "absolute",
                    zIndex: 1
                },
                item: {
                    display: "inline-block",
                    width: "4px",
                    height: "30px",
                    margin: "0px 2px",
                    borderRadius: "5px",
                    animation: "KKELoading 1.2s infinite",
                    webkitAnimation: "KKELoading 1.2s infinite",
                    MozAnimation: "KKELoading 1.2s infinite"
                },
                color: ["#FF5472", "#FF706E", "#FF8762", "#FFAF4C", "#FFD53E"],
                delay: {
                    animationDelay: -1,
                    webkitAnimationDelay: -1,
                    MozAnimationDelay: -1
                },
                scaleY: "{0%,40%,100%{-moz-transform:scaleY(0.2);-webkit-transform:scaleY(0.2);transform:scaleY(0.2);}20%,60%{-moz-transform:scaleY(1);-webkit-transform:scaleY(1);transform:scaleY(1);}}"
            };
            F(),
            this.appendto = function(I, J) {
                D = I,
                j = J,
                D.appendChild(H)
            },
            this.setPosition = function() {
                D && D.offsetHeight > 0 ? (H.style.top = (D.offsetHeight - f(E.ctn.height)) / 2 + "px", H.style.left = (D.offsetWidth - f(E.ctn.width)) / 2 + "px") : j && j.DIMENSION.h_t && (H.style.top = (j.DIMENSION.h_t - f(E.ctn.height)) / 2 + "px", H.style.left = (j.DIMENSION._w - f(E.ctn.width)) / 2 + "px")
            },
            this.show = function() {
                G(),
                H.style.display = ""
            },
            this.hide = function() {
                clearTimeout(z),
                H.style.display = "none"
            }
        }
        function o(H) {
            H = H || {};
            var q, D, E, F, z, I, G = r.$C("div"),
            B = 70,
            J = function() {
                clearTimeout(I),
                D && (D.style.display = "none", G.innerHTML = ""),
                q && T(q.closeCb) && q.closeCb()
            },
            j = function(M) {
                if (q = M, clearTimeout(I), !D) {
                    D = r.$C("div"),
                    D.style.width = "100%",
                    D.style.height = "100%",
                    D.style.position = "absolute",
                    D.style.zIndex = B,
                    D.style.top = 0,
                    D.style.textAlign = "center",
                    E = r.$C("div"),
                    F = r.$C("div"),
                    z = r.$C("span"),
                    G.style.fontSize = "12px",
                    G.style.margin = "9px auto",
                    E.style.position = "absolute",
                    E.style.top = 0,
                    E.style.left = 0,
                    E.style.width = "100%",
                    E.style.height = "100%",
                    E.style.backgroundColor = H.TIP_ARR ? H.TIP_ARR[2] || "#fff": "#fff",
                    E.style.opacity = 0.5,
                    E.style.filter = "alpha(opacity=50)",
                    F.style.padding = "1px 3px 10px",
                    F.style.top = H.TIP_ARR ? H.TIP_ARR[4] || "26%": "26%",
                    F.style.position = "relative",
                    F.style.margin = "0 auto",
                    F.style.width = "100%",
                    z.style.cursor = "pointer",
                    z.style.display = "block",
                    z.style.margin = "0 auto",
                    z.style.lineHeight = z.style.height = "28px",
                    z.style.width = "60px",
                    z.style.fontSize = "14px",
                    z.style.borderRadius = "3px",
                    r.xh5_EvtUtil.addHandler(z, "click", J),
                    F.appendChild(G);
                    var R = !(!H.TIP_ARR || !H.TIP_ARR[3]); ! R && D.appendChild(E),
                    D.appendChild(F)
                }
                D.style.display = "",
                G.style.color = "undefined" != typeof M.fontColor ? M.fontColor: H.TIP_ARR ? H.TIP_ARR[1] || "#fff": "#fff";
                var O = H.TIP_ARR ? H.TIP_ARR[0] || "#000": "#000";
                if (F.style.backgroundColor = r.xh5_BrowserUtil.noH5 ? O: r.hex2dec(O, 0.8), M.bgStyle) {
                    for (var V in M.bgStyle) {
                        M.bgStyle.hasOwnProperty(V) && (F.style[V] = M.bgStyle[V])
                    }
                }
                if (G.innerHTML = M.txt || "", M.content && G.appendChild(M.content), !isNaN(M.autoHide) && M.autoHide > 0 && setTimeout(J, 1000 * M.autoHide), M.noBtn ? r.$CONTAINS(F, z) && F.removeChild(z) : (z.innerHTML = M.btnLb || "\u786e\u5b9a", z.style.background = H.BTN_ARR ? H.BTN_ARR[0] || "#2b9dfc": "#2b9dfc", z.style.color = H.BTN_ARR ? H.BTN_ARR[1] || "#fff": "#fff", !r.$CONTAINS(F, z) && F.appendChild(z)), M.extraBtn) {
                    for (var Q = 0,
                    W = M.extraBtn,
                    U = W.length; U > Q; Q++) {
                        var K = W[Q],
                        L = r.$C("input");
                        L.type = "button",
                        L.value = K.value,
                        L.style.marginTop = "20px",
                        L.style.cursor = "pointer",
                        r.xh5_EvtUtil.addHandler(L, "click", K.onClk),
                        F.appendChild(L)
                    }
                }
                return M.parent.appendChild(D),
                D
            };
            this.genTip = j,
            this.hide = J
        }
        function e() {
            var j = "hq";
            return location.hostname.indexOf("api.cn") > -1 && (j = "w", location.pathname.indexOf("appchart") > -1 && (j = "a")),
            j
        }
        this.VER = "2.3.5";
        var r = this,
        N = function(j) {
            return function(q) {
                return {}.toString.call(q) == "[object " + j + "]"
            }
        },
        P = N("Object"),
        b = N("String"),
        T = N("Function"),
        i = N("Array"),
        a = N("Number"),
        s = N("Date");
        this.isObj = P,
        this.isStr = b,
        this.isFunc = T,
        this.isArr = i,
        this.isNum = a,
        this.isDate = s;
        var f = function(j) {
            return parseInt(j, 10)
        };
        this.uae = function(j) {
            for (var D, z = [], B = {},
            E = 0, q = j.length; q > E; E++) {
                D = j[E],
                1 !== B[D] && (B[D] = 1, z[z.length] = D)
            }
            return z
        };
        var v = new
        function() {
            var q;
            if (XMLHttpRequest) {
                q = new XMLHttpRequest
            } else {
                if (ActiveXObject) {
                    try {
                        q = new ActiveXObject("MSXML2.XMLHTTP")
                    } catch(j) {
                        try {
                            q = new ActiveXObject("Microsoft.XMLHTTP")
                        } catch(z) {}
                    }
                }
            }
            this.send = function(E, B, D, F) {
                if (!q || !E) {
                    return void(D && D("error while sending"))
                }
                if (E += E.indexOf("?") < 0 ? "?": "&", E += "_=" + (new Date).getTime(), F = F || "POST", q.onreadystatechange = function() {
                    if (4 == q.readyState) {
                        var I;
                        200 == q.status && (I = q.responseText),
                        D && D(I)
                    }
                },
                q.open(F, E, !0), "POST" == F) {
                    q.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
                    var G = "";
                    for (var H in B) {
                        B.hasOwnProperty(H) && (G += [encodeURIComponent(H), encodeURIComponent(B[H])].join("=") + "&")
                    }
                    q.send(G)
                } else {
                    q.send(null)
                }
            }
        };
        this.POST = "undefined" != typeof jQuery && jQuery.post ? jQuery.post: v.send,
        this.trace = function(j) {
            return {
                log: function() {
                    j && j.log && j.log.apply(j, arguments)
                },
                error: function() {
                    j && j.error && j.error.apply(j, arguments)
                }
            }
        } (null);
        var C = function(q, j) {
            var z = -1;
            if (q.indexOf) {
                z = q.indexOf(j)
            } else {
                for (var B = q.length; B--;) {
                    if (q[B] === j) {
                        z = B;
                        break
                    }
                }
            }
            return z
        };
        this.arrIndexOf = C;
        var u = function(q, j) {
            if (null == q || "object" != typeof q) {
                return q
            }
            if (q.constructor == Date || q.constructor == RegExp || T(q) || b(q) || q.constructor == Number || q.constructor == Boolean) {
                return new q.constructor(q)
            }
            j = j || new q.constructor;
            for (var z in q) {
                q.hasOwnProperty(z) && (j[z] = "undefined" == typeof j[z] ? u(q[z], null) : j[z])
            }
            return j
        };
        this.clone = u;
        var t = function(q) {
            if (!q) {
                return q
            }
            var j = {};
            for (var z in q) {
                q.hasOwnProperty(z) && (j[z] = q[z])
            }
            return j
        };
        this.co = t,
        this.oc = function(q, j) {
            if (!q) {
                return j
            }
            for (var z in j) {
                j.hasOwnProperty(z) && (q[z] = P(q[z]) && P(j[z]) ? arguments.callee(q[z], j[z]) : j[z])
            }
            return q
        };
        var x = function(q) {
            function j() {}
            return j.prototype = q,
            new j
        };
        this.fInherit = p,
        this.urlUtil = new
        function() {
            this.getUrlParam = function() {
                var q, B = {};
                try {
                    q = location.search.substring(1)
                } catch(F) {}
                if (q) {
                    for (var G, H, D, z = q.split("&"), j = z.length, E = 0; j > E; E++) {
                        D = z[E].indexOf("="),
                        -1 != D && (G = z[E].substring(0, D), H = z[E].substring(D + 1), B[G] = H)
                    }
                }
                return B
            },
            this.getMainUrl = function() {
                return window.location != window.parent.location ? document.referrer: document.location.href
            }
        },
        this.xh5_BrowserUtil = new
        function() {
            this.info = function() {
                var q, j = navigator.userAgent,
                z = j.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
                return /trident/i.test(z[1]) ? (q = /\brv[ :]+(\d+)/g.exec(j) || [], {
                    name: "IE ",
                    version: q[1] || ""
                }) : "Chrome" === z[1] && (q = j.match(/\bOPR\/(\d+)/), null != q) ? {
                    name: "Opera",
                    version: q[1]
                }: (z = z[2] ? [z[1], z[2]] : [navigator.appName, navigator.appVersion, "-?"], null != (q = j.match(/version\/(\d+)/i)) && z.splice(1, 1, q[1]), {
                    name: z[0],
                    version: z[1]
                })
            } (),
            this.noH5 = !1,
            this.hdpr = function(q) {
                var j = document.createElement("canvas");
                if (j.getContext && j.getContext("2d")) {
                    var z = Math.ceil(window.devicePixelRatio || 1),
                    B = j.getContext("2d").webkitBackingStorePixelRatio || 1;
                    return z / B
                }
                return q.noH5 = !0,
                1
            } (this)
        },
        this.xh5_deviceUtil = function() {
            return {
                istd: function() {
                    if ("ontouchend" in window) {
                        var q;
                        try {
                            q = navigator.userAgent
                        } catch(j) {}
                        return q && q.indexOf("Windows NT") > 0 ? !1 : !0
                    }
                    return ! 1
                } (),
                allowt: "ontouchend" in window
            }
        } ();
        var k = function() {
            function I(K) {
                return K = JSON.stringify(K),
                K || (K = ""),
                K = encodeURIComponent(K)
            }
            function z(K) {
                try {
                    K = JSON.parse(K)
                } catch(L) {
                    K = decodeURIComponent(K)
                }
                return K
            }
            function E(R, U, V) {
                if (V = V || {},
                void 0 != R && void 0 != U) {
                    var W, K, O, M;
                    K = V.path ? "; path=" + V.path: "",
                    O = V.domain ? "; domain=" + V.domain: "",
                    M = V.secure ? "; secure": "";
                    var L, Q = V.expires;
                    switch (J(Q)) {
                    case "Number":
                        L = new Date,
                        L.setTime(L.getTime() + 1000 * Q);
                        break;
                    case "String":
                        L = new Date(Q),
                        "Invalid Date" == L && (L = "");
                        break;
                    case "Date":
                        L = Q
                    }
                    W = L ? "; expires=" + L.toUTCString() : "",
                    document.cookie = [encodeURIComponent(R), "=", I(U), W, K, O, M].join("")
                }
            }
            function F(K) {
                var L = document.cookie.match("(?:^|;)\\s*" + encodeURIComponent(K) + "=([^;]*)");
                return L ? z(L[1]) || "": null
            }
            function G(K) {
                document.cookie = encodeURIComponent(K) + "=;expires=" + new Date(0).toUTCString()
            }
            function B(K, L) {
                void 0 != K && void 0 != L && localStorage.setItem(encodeURIComponent(K), I(L))
            }
            function j(K) {
                var L = localStorage.getItem(encodeURIComponent(K));
                return z(L)
            }
            function H(K) {
                localStorage.removeItem(encodeURIComponent(K))
            }
            var D = Object.prototype.toString,
            J = function(K) {
                return null === K ? "Null": void 0 === K ? "Undefined": D.call(K).slice(8, -1)
            },
            q = function() {
                if ("object" == typeof localStorage && localStorage && localStorage.setItem) {
                    var K = "KKE_LOCALSTORAGE_TESTing";
                    try {
                        return localStorage.removeItem(K),
                        localStorage.setItem(K, K),
                        localStorage.removeItem(K),
                        !0
                    } catch(L) {
                        return ! 1
                    }
                }
                return ! 1
            } ();
            return {
                hasls: q,
                save: function(L, Q, M) {
                    M = M || {};
                    var K = M.mode;
                    if (K) {
                        switch (K) {
                        case "localStorage":
                            if (!q) {
                                return
                            }
                            B(L, Q);
                            break;
                        case "cookie":
                            E(L, Q, M)
                        }
                    } else {
                        if (q) {
                            try {
                                H(L),
                                B(L, Q)
                            } catch(O) {}
                        } else {
                            E(L, Q, M)
                        }
                    }
                },
                load: function(K, M) {
                    var L;
                    if ("Object" == J(M) && (M = M.mode), M) {
                        switch (M) {
                        case "localStorage":
                            if (!q) {
                                return
                            }
                            L = j(K);
                            break;
                        case "cookie":
                            L = F(K)
                        }
                    } else {
                        q && (L = j(K)),
                        !L && (L = F(K))
                    }
                    return L
                },
                remove: function(K, L) {
                    if ("Object" == J(L) && (L = L.mode), L) {
                        switch (L) {
                        case "localStorage":
                            if (!q) {
                                return
                            }
                            H(K);
                            break;
                        case "cookie":
                            G(K)
                        }
                    } else {
                        q && H(K),
                        G(K)
                    }
                },
                clear: function(K) {
                    q && H(K)
                }
            }
        } ();
        this.localSL = k,
        this.xh5_EvtUtil = {
            addHandler: function(q, j, z) {
                q && (q.addEventListener ? q.addEventListener(j, z, !1) : q.attachEvent ? q.attachEvent("on" + j, z) : q["on" + j] = z)
            },
            removeHandler: function(q, j, z) {
                q && (q.removeEventListener ? q.removeEventListener(j, z, !1) : q.detachEvent ? q.detachEvent("on" + j, z) : q["on" + j] = null)
            },
            getEvent: function(j) {
                return j ? j: window.event
            },
            getTarget: function(j) {
                return ! j && (j = this.getEvent()),
                j ? j.target || j.srcElement: null
            },
            preventDefault: function(j) { ! j && (j = this.getEvent()),
                j && (j.preventDefault ? j.preventDefault() : j.returnValue = !1)
            },
            stopPropagation: function(j) { ! j && (j = this.getEvent()),
                j && (j.stopPropagation ? j.stopPropagation() : j.cancelBubble = !0)
            },
            getRelatedTarget: function(j) {
                return ! j && (j = this.getEvent()),
                j.relatedTarget ? j.relatedTarget: j.toElement ? j.toElement: j.fromElement ? j.fromElement: null
            },
            getWheelDelta: function(j) {
                return ! j && (j = this.getEvent()),
                j ? j.wheelDelta ? client.engine.opera && client.engine.opera < 9.5 ? -j.wheelDelta: j.wheelDelta: 40 * -j.detail: 0
            }
        },
        S.prototype.al = function(q, j, z) {
            z && this.evtObj[q] || (!this.evtObj[q] && (this.evtObj[q] = []), this.evtObj[q].push(j))
        },
        S.prototype.rl = function(q, j) {
            var z = this.evtObj[q];
            if (i(z)) {
                for (var B = z.length; B--;) {
                    z[B] == j && z.splice(B, 1)
                }
            }
        },
        S.prototype.re = function(q, D) {
            var z = this.evtObj[q];
            if (i(z)) {
                for (var B = 0,
                j = z.length; j > B; B++) {
                    "function" == typeof z[B] && z[B](q, D)
                }
            }
        },
        this.xh5_EvtDispatcher = S,
        this.$DOM = function(q, j) {
            return j = j || document,
            j.getElementById(q)
        },
        this.$C = function(q, j) {
            var z = document.createElement(q);
            return j && (z.id = j),
            z
        },
        this.$T = function(j) {
            return document.createTextNode(j)
        },
        this.$CONTAINS = function(q, j) {
            if (q.compareDocumentPosition) {
                return q === j || !!(16 & q.compareDocumentPosition(j))
            }
            if (q.contains && 1 === j.nodeType) {
                return q.contains(j) && q !== j
            }
            for (; j = j.parentNode;) {
                if (j === q) {
                    return ! 0
                }
            }
            return ! 1
        },
        this.getTextNodes = function(q) {
            var j = [];
            for (q = q.firstChild; q; q = q.nextSibling) {
                3 == q.nodeType ? j.push(q) : j = j.concat(arguments.callee(q))
            }
            return j
        },
        this.getCSS = function(q) {
            var j = null;
            return j = window.getComputedStyle ? window.getComputedStyle(q) : q.currentStyle
        },
        this.fBind = g,
        this.isColor = function(j) {
            return /^#[0-9a-fA-F]{3,6}$/.test(j)
        },
        this.isColorRGB = function(j) {
            return /(^#[0-9a-fA-F]{3,6}$)|(^rgba?\(.{5,16}\)$)/.test(j)
        },
        this.randomColor = function() {
            for (var j = Math.floor(16777215 * Math.random()).toString(16); j.length < 6;) {
                j += "0"
            }
            return j
        },
        this.hex2dec = function(E, B, q) {
            if (0 == E.indexOf("rgb")) {
                return E
            }
            E = E.replace(/#|0x/i, "");
            var z, D, F;
            E.replace(/(\w{6})|(\w{3})/,
            function(G, J, I) {
                if (J) {
                    z = E.slice(0, 2),
                    D = E.slice(2, 4),
                    F = E.slice(4)
                } else {
                    if (!I) {
                        return [0, 0, 0]
                    }
                    var H = E.split("");
                    z = H[0],
                    z += String(z),
                    D = H[1],
                    D += String(D),
                    F = H[2],
                    F += String(F)
                }
            });
            var j;
            return isNaN(B) ? (j = [parseInt(z, 16), parseInt(D, 16), parseInt(F, 16)], q ? j: "rgb($color)".replace("$color", j.join(","))) : (j = [parseInt(z, 16), parseInt(D, 16), parseInt(F, 16), B], q ? j: "rgba($color)".replace("$color", j.join(",")))
        },
        this.getTimestamp = h,
        this.cssUtil = {
            inject: function(q) {
                var j = document.createElement("style"),
                z = document.head || document.getElementsByTagName("head")[0] || document.documentElement;
                j.type = "text/css",
                j.styleSheet ? j.styleSheet.cssText = q: j.appendChild(document.createTextNode(q)),
                z.appendChild(j)
            },
            adCls: function(q, j) {
                if (q.className != j) {
                    var z = q.className.split(" ");
                    for (var B in z) {
                        if (z.hasOwnProperty(B) && z[B] == j) {
                            return
                        }
                    }
                    "" == q.className ? q.className = j: q.className += " " + j
                }
            },
            rmCls: function(q, D) {
                if ( - 1 != q.className.indexOf(D)) {
                    if (q.className == D) {
                        q.className = ""
                    } else {
                        var z = q.className.split(" "),
                        B = "";
                        for (var j in z) {
                            if (z.hasOwnProperty(j)) {
                                if (z[j] == D) {
                                    continue
                                }
                                "" != B && (B += " "),
                                B += z[j]
                            }
                        }
                        q.className = B
                    }
                }
            }
        },
        this.load = c;
        var n, d = new
        function() {
            var q = n || {};
            n = q;
            var j = function(D, z) {
                for (var B = q[D][z ? "errCbArr": "cbArr"], E = B.length; E--;) {
                    var F = B[E];
                    T(F) && F()
                }
                q[D] = null,
                delete q[D]
            };
            this.load = function(B, F, D, G) {
                var E = "urlhash_" + l(B);
                for (var z in q) {
                    if (q.hasOwnProperty(z) && z == E) {
                        return q[z].cbArr.push(F),
                        void q[z].errCbArr.push(D)
                    }
                }
                q[E] = {
                    url: B,
                    cbArr: [F],
                    errCbArr: [D]
                },
                c(B, g(j, this, E), g(j, this, E, !0), G)
            }
        };
        this.relyLoader = d,
        this.iframer = function(q, B) {
            function F() {
                if (document && document.body) {
                    clearInterval(H),
                    z = 0;
                    var I = document.body;
                    I.insertBefore(G, I.firstChild),
                    G.setAttribute("data-ready", "1")
                } else {
                    z++>9 && (clearInterval(H), T(B) && B())
                }
            }
            var G, H, D = q.attribute ? q.attribute.id || "_kkeiframe" + (new Date).getTime() : "_kkeiframe" + (new Date).getTime(),
            z = 0;
            if (! (G = document.getElementById(D))) {
                if (G = document.createElement("iframe"), G.setAttribute("data-ready", "0"), q.attribute) {
                    for (var j in q.attribute) {
                        q.attribute.hasOwnProperty(j) && (G[j] = q.attribute[j])
                    }
                }
                if (G.style.height = G.style.width = 0, G.style.borderStyle = "none", G.style.position = "absolute", G.style.zIndex = -9, G.style.display = "none", q.style) {
                    for (var E in q.style) {
                        q.style.hasOwnProperty(E) && (G.style[E] = q.style[E])
                    }
                }
                H = setInterval(F, 500),
                F()
            }
            return G
        },
        this.ca = function(j) {
            if (j) {
                for (; j.length > 0;) {
                    j.length--
                }
            }
        },
        this.isRepos = function(j) {
            return /^(sh204\d{3}|sz1318\d{2})$/.test(j)
        },
        this.market = function(j) {
            return /^s[hz]\d{6}$/.test(j) ? "CN": /^GN|gn\d{6}$/.test(j) ? "CN": /^HY|hy\d{6}$/.test(j) ? "CN": /^DY|dy\d{6}$/.test(j) ? "CN": /^s[hz]\d{6}_i$/.test(j) ? "CNI": /^sb[48]\d{5}$/.test(j) ? "OTC": /^[48]\d{5}$/.test(j) ? "OTC": /^otc_\d{6}$/.test(j) ? "OTC": /^btc_\w+/.test(j) ? "BTC": /^gb_.+$/.test(j) ? "US": /^(hk|rt_hk)\w+/.test(j) ? "HK": /^hf_\w+/.test(j) ? "HF": /^nf_\w+/.test(j) ? "NF": /^f_\d{6}$/.test(j) || /^fu_\d{6}$/.test(j) || /^pwbfbyd_\d{6}$/.test(j) || /^pwbfbjd_\d{6}$/.test(j) || /^pwbfbnd_\d{6}$/.test(j) || /^ljjz_\d{6}$/.test(j) || /^dwjz_\d{6}$/.test(j) || /^lshb_\d{6}$/.test(j) ? "fund": /^CON_OP_\w+/.test(j) ? "option_cn": /^P_OP_\w+/.test(j) ? "op_m": /^znb_\w+/.test(j) ? "global_index": /^fx_.+$/.test(j) ? "forex": /^(DINIW|USDCNY)$/.test(j) ? "forex_yt": /^CFF_RE_.+$/.test(j) ? "CFF": /\d+$/.test(j) ? "NF": void 0
        },
        this.cookieUtil = {
            escape: function(j) {
                return j.replace(/([.*+?^${}()|[\]\/\\])/g, "\\$1")
            },
            get: function(q) {
                var j = document.cookie.match("(?:^|;)\\s*" + this.escape(q) + "=([^;]*)");
                return j ? j[1] || "": ""
            },
            set: function(F, B, q) { ! q && (q = {}),
                B || (B = "", q.expires = -1);
                var z = "";
                if (q.expires && (Number(q.expires) || q.expires.toUTCString)) {
                    var D;
                    Number(q.expires) ? (D = new Date, D.setTime(D.getTime() + 1000 * q.expires)) : D = q.expires,
                    z = "; expires=" + D.toUTCString()
                }
                var G = q.path ? "; path=" + q.path: "",
                j = q.domain ? "; domain=" + q.domain: "",
                E = q.secure ? "; secure": "";
                document.cookie = [F, "=", B, z, G, j, E].join("")
            }
        };
        var y = new
        function() {
            function j(M) {
                c(M.url,
                function() {
                    for (var Q = M.f(); Q && M.q.length;) {
                        var O = M.q.shift();
                        Q.apply(null, O)
                    }
                },
                function() {--M.count && j(M),
                    M.count < 1 && (M.q = [])
                })
            }
            function L(M) {
                setTimeout(function() {
                    var O = !!M.f(); ! O && j(M)
                },
                2000)
            }
            function E(V) {
                if ("undefined" != typeof SIMA) {
                    for (var R, O = G.length; O--;) {
                        if (R = G[O], R.symbol == V.symbol && R.type == V.type) {
                            return
                        }
                    }
                    G.push(V)
                }
                var Q = V.simadata,
                U = {
                    action: "hq",
                    data: Q,
                    pk: "179824"
                };
                try {
                    SIMA(U)
                } catch(M) {
                    H.count && H.q.push([V])
                }
            }
            var F = navigator.userAgent || "unknownUa";
            F = encodeURIComponent("_UA_" + F);
            var I = {
                url: "//wwws.apiimg.cn/unipro/pub/suda_s_v851c.js",
                q: [],
                count: 5,
                f: function() {
                    return "undefined" == typeof SUDA ? void 0 : SUDA.uaTrack
                }
            },
            H = {
                url: "//news.api.com.cn/js/pctianyi/sima.js",
                q: [],
                count: 5,
                f: function() {
                    return "undefined" == typeof SIMA ? void 0 : E
                }
            };
            L(H),
            L(I);
            var G = [];
            this.sima = E;
            var D, z, J = [],
            K = function() {
                for (var M, R = "chart_finance",
                O = "",
                Q = ",",
                X = "",
                W = 0,
                V = J.length; V > W; W++) {
                    M = J[W],
                    X += [M.k, M.v].join(O) + Q
                }
                for (; J.length;) {
                    J.length--
                }
                if (X !== D) {
                    D = X,
                    X += F;
                    try {
                        SUDA.uaTrack(R, X)
                    } catch(U) {
                        I.count && I.q.push([R, X])
                    }
                }
            };
            this.s = function(M, R, O) {
                if (M) { (isNaN(O) || 0 > O) && (O = 3000),
                    R = JSON.stringify(R),
                    R || (R = ""),
                    R = encodeURIComponent(R);
                    for (var Q = J.length; Q--;) {
                        if (J[Q].k == M) {
                            J.splice(Q, 1);
                            break
                        }
                    }
                    J.push({
                        k: M,
                        v: R
                    }),
                    clearTimeout(z),
                    z = setTimeout(K, O)
                }
            };
            var B, q;
            this.s2 = function(M, R, O) {
                if (O = O || "chart_detail", q != M || B != O) {
                    B = O,
                    q = M,
                    setTimeout(function() {
                        B = void 0,
                        q = void 0
                    },
                    99);
                    try {
                        SUDA.uaTrack(O, R || M)
                    } catch(Q) {
                        I.count && I.q.push([O, R || M])
                    }
                }
            },
            this.log = function() {
                try {
                    SUDA.log()
                } catch(M) {}
            }
        };
        this.sudaLog = y.log,
        this.stc = y.s,
        this.suda = y.s2,
        this.xh5_PosUtil = {
            pp: function(q, j, z, B) {
                return isNaN(q) || j >= q ? B: q >= z ? 1 : Math.max(B * (1 - (q - j) / (z - j)), 1)
            },
            ppp: function(q, D, z, B, j) {
                return q = (q - j) / j,
                this.pp(q, D, z, B)
            },
            vp: function(q, j, z) {
                return isNaN(q) || 0 >= q ? z - 1 : z * (1 - q / j)
            }
        },
        this.xh5_HtmlPosUtil = {
            pageX: function(j) {
                return j.offsetParent ? j.offsetLeft + this.pageX(j.offsetParent) : j.offsetLeft
            },
            pageY: function(j) {
                return j.offsetParent ? j.offsetTop + this.pageY(j.offsetParent) : j.offsetTop
            },
            parentX: function(j) {
                return j.parentNode == j.offsetParent ? j.offsetLeft: this.pageX(j) - this.pageX(j.parentNode)
            },
            parentY: function(j) {
                return j.parentNode == j.offsetParent ? j.offsetTop: this.pageY(j) - this.pageY(j.parentNode)
            }
        },
        this.xh5_ADJUST_HIGH_LOW = new
        function() {
            var q = function(B) {
                var z = parseInt(Math.round(100 * B));
                return z % 100 != 0 && (z % 10 == 0 && (z *= 0.1), z % 5 != 0 && z % 2 != 0) ? !0 : !1
            },
            j = function(B, z) {
                if (z) {
                    for (; B > 5;) {
                        if (B % 2 == 0) {
                            B *= 0.5
                        } else {
                            if (B % 3 != 0) {
                                break
                            }
                            B /= 3
                        }
                    }
                } else {
                    B > 9 && (B % 3 == 0 ? B /= 3 : B % 4 == 0 ? B *= 0.25 : B % 2 == 0 && (B *= 0.5))
                }
                return B
            };
            this.c = function(aa, D, J, U, z, Q) {
                if (isNaN(aa) || isNaN(D) || D > aa) {
                    return [0, 0, 0]
                }
                isNaN(Q) || (Q = (aa - D) * Q, aa += Q, D -= Q);
                for (var W, X, F, H, O, I, E, L, ab, Z, af, B, ae, ac, at = -0.000001,
                G = 0.5 * (D + aa), K = U ? [4, 5, 6, 8, 9, 10, 12, 15, 16, 18, 20] : [4, 5, 6, 7, 8, 9, 10, 12, 14, 15, 16, 18, 20], V = [1, 2, 3, 4, 5, 6, 8], aw = !1, M = V.length, av = 0, ad = K.length; ad > av; av++) {
                    for (aw = !1, ae = K[av], F = (aa - D) / ae, L = Math.pow(10, 0 - J); ! aw;) {
                        for (ac = 0; M > ac; ac++) {
                            if (H = L * V[ac], H - F > at && (1 & ae ? (O = Math.round((G + 0.5 * H) / H) * H, af = (O + 0.5 * (ae - 1) * H).toFixed(5), B = (O - 0.5 * (ae + 1) * H).toFixed(5)) : (O = Math.round(G / H) * H, af = (O + 0.5 * ae * H).toFixed(5), B = (O - 0.5 * ae * H).toFixed(5)), I = Number(af), E = Number(B), I - aa > at && at > E - D)) {
                                if (aw = !0, 0 > E && !z && (I -= E, E = 0), !ab) {
                                    ab = I - E,
                                    W = I,
                                    X = E,
                                    Z = ae;
                                    break
                                }
                                var R = (I - E) / j(ae);
                                if (1 != Math.round(100 * R) && 1 != Math.round(10 * R) && q(R)) {
                                    break
                                }
                                if (I - E > ab) {
                                    break
                                }
                                if (I - E == ab) {
                                    var Y = W - aa,
                                    au = D - X,
                                    ar = Math.abs(Y - au);
                                    Y = I - aa,
                                    au = D - E;
                                    var aq = Math.abs(Y - au);
                                    if (aq >= ar) {
                                        break
                                    }
                                }
                                if (q(I)) {
                                    break
                                }
                                if (q(E)) {
                                    break
                                }
                                ab = I - E,
                                W = I,
                                X = E,
                                Z = ae;
                                break
                            }
                        }
                        L *= 10
                    }
                }
                return Z = j(Z, U),
                [W, X, Z]
            }
        },
        this.xh5_S_KLC_D = function(X) {
            var L, G, I, R, q, E, W, B = 86400000,
            Y = 7657,
            H = [],
            J = [],
            V = ~ (3 << 30),
            O = 1 << 30,
            K = [0, 3, 5, 6, 9, 10, 12, 15, 17, 18, 20, 23, 24, 27, 29, 30],
            Q = Math,
            Z = function() {
                var ag, af;
                for (ag = 0; 64 > ag; ag++) {
                    J[ag] = Q.pow(2, ag),
                    26 > ag && (H[ag] = D(ag + 65), H[ag + 26] = D(ag + 97), 10 > ag && (H[ag + 52] = D(ag + 48)))
                }
                for (H.push("+", "/"), H = H.join(""), G = X.split(""), I = G.length, ag = 0; I > ag; ag++) {
                    G[ag] = H.indexOf(G[ag])
                }
                return R = {},
                L = E = 0,
                q = {},
                af = aa([12, 6]),
                W = 63 ^ af[1],
                {
                    _1479: z,
                    _136: U,
                    _200: M,
                    _139: j,
                    _197: ae
                } ["_" + af[0]] ||
                function() {
                    return []
                }
            },
            D = String.fromCharCode,
            ac = function(af) {
                return af === {}._
            },
            F = function() {
                var ag, af;
                for (ag = ab(), af = 1;;) {
                    if (!ab()) {
                        return af * (2 * ag - 1)
                    }
                    af++
                }
            },
            ab = function() {
                var af;
                return L >= I ? 0 : (af = G[L] & 1 << E, E++, E >= 6 && (E -= 6, L++), !!af)
            },
            aa = function(al, ai, am) {
                var aj, ah, ag, af, ak;
                for (ah = [], ag = 0, ai || (ai = []), am || (am = []), aj = 0; aj < al.length; aj++) {
                    if (af = al[aj], ag = 0, af) {
                        if (L >= I) {
                            return ah
                        }
                        if (al[aj] <= 0) {
                            ag = 0
                        } else {
                            if (al[aj] <= 30) {
                                for (; ak = 6 - E, ak = af > ak ? ak: af, ag |= (G[L] >> E & (1 << ak) - 1) << al[aj] - af, E += ak, E >= 6 && (E -= 6, L++), af -= ak, !(0 >= af);) {}
                                ai[aj] && ag >= J[al[aj] - 1] && (ag -= J[al[aj]])
                            } else {
                                ag = aa([30, al[aj] - 30], [0, ai[aj]]),
                                am[aj] || (ag = ag[0] + ag[1] * J[30])
                            }
                        }
                        ah[aj] = ag
                    } else {
                        ah[aj] = 0
                    }
                }
                return ah
            },
            ad = function(af) {
                var aj, ah, ai, ag;
                for (af > 1 && (aj = 0), aj = 0; af > aj; aj++) {
                    R.d++,
                    ai = R.d % 7,
                    (3 == ai || 4 == ai) && (R.d += 5 - ai)
                }
                return ah = new Date,
                ag = 60 * ah.getTimezoneOffset() * 1000,
                ah.setTime((Y + R.d) * B + ag),
                ah.setHours(ah.getHours() + 8),
                ah
            },
            M = function() {
                var ah, ag, ai, aj, af;
                if (W >= 1) {
                    return []
                }
                for (R.d = aa([18], [1])[0] - 1, ai = aa([3, 3, 30, 6]), R.p = ai[0], R.ld = ai[1], R.cd = ai[2], R.c = ai[3], R.m = Q.pow(10, R.p), R.pc = R.cd / R.m, ag = [], ah = 0; aj = {
                    d: 1
                },
                ab() && (ai = aa([3])[0], 0 == ai ? aj.d = aa([6])[0] : 1 == ai ? (R.d = aa([18])[0], aj.d = 0) : aj.d = ai), af = {
                    date: ad(aj.d)
                },
                ab() && (R.ld += F()), ai = aa([3 * R.ld], [1]), R.cd += ai[0], af.close = R.cd / R.m, ag.push(af), !(L >= I) && (L != I - 1 || 63 & (R.c ^ ah + 1)); ah++) {}
                return ag[0].prevclose = R.pc,
                ag
            },
            U = function() {
                var am, ak, ai, ao, aj, an, ap, af, ah, ag, al;
                if (W >= 2) {
                    return []
                }
                for (ap = [], ah = {
                    v: "volume",
                    p: "price",
                    a: "avg_price"
                },
                R.d = aa([18], [1])[0] - 1, af = {
                    date: ad(1)
                },
                ai = aa(1 > W ? [3, 3, 4, 1, 1, 1, 5] : [4, 4, 4, 1, 1, 1, 3]), am = 0; 7 > am; am++) {
                    R[["la", "lp", "lv", "tv", "rv", "zv", "pp"][am]] = ai[am]
                }
                for (R.m = Q.pow(10, R.pp), W >= 1 ? (ai = aa([3, 3]), R.c = ai[0], ai = ai[1]) : (ai = 5, R.c = 2), R.pc = aa([6 * ai])[0], af.pc = R.pc / R.m, R.cp = R.pc, R.da = 0, R.sa = R.sv = 0, am = 0; ! (L >= I) && (L != I - 1 || 7 & (R.c ^ am)); am++) {
                    for (aj = {},
                    ao = {},
                    ag = R.tv ? ab() : 1, ak = 0; 3 > ak; ak++) {
                        if (al = ["v", "p", "a"][ak], (ag ? ab() : 0) && (ai = F(), R["l" + al] += ai), an = "v" == al && R.rv ? ab() : 1, ai = aa([3 * R["l" + al] + ("v" == al ? 7 * an: 0)], [ !! ak])[0] * (an ? 1 : 100), ao[al] = ai, "v" == al) {
                            if (! (aj[ah[al]] = ai) && 241 > am && (R.zv ? !ab() : 1)) {
                                ao.p = 0;
                                break
                            }
                        } else {
                            "a" == al && (R.da = (1 > W ? 0 : R.da) + ao.a)
                        }
                    }
                    R.sv += ao.v,
                    aj[ah.p] = (R.cp += ao.p) / R.m,
                    R.sa += ao.v * R.cp,
                    aj[ah.a] = ac(ao.a) ? am ? ap[am - 1][ah.a] : aj[ah.p] : R.sv ? ((Q.floor((R.sa * (2000 / R.m) + R.sv) / R.sv) >> 1) + R.da) / 1000 : aj[ah.p] + R.da / 1000,
                    ap.push(aj)
                }
                return ap[0].date = af.date,
                ap[0].prevclose = af.pc,
                ap
            },
            z = function() {
                var aj, ai, ag, ah, ak, al, af;
                if (W >= 1) {
                    return []
                }
                for (R.lv = 0, R.ld = 0, R.cd = 0, R.cv = [0, 0], R.p = aa([6])[0], R.d = aa([18], [1])[0] - 1, R.m = Q.pow(10, R.p), ak = aa([3, 3]), R.md = ak[0], R.mv = ak[1], aj = []; ak = aa([6]), ak.length;) {
                    if (ag = {
                        c: ak[0]
                    },
                    ah = {},
                    ag.d = 1, 32 & ag.c) {
                        for (;;) {
                            if (ak = aa([6])[0], 63 == (16 | ak)) {
                                af = 16 & ak ? "x": "u",
                                ak = aa([3, 3]),
                                ag[af + "_d"] = ak[0] + R.md,
                                ag[af + "_v"] = ak[1] + R.mv;
                                break
                            }
                            if (32 & ak) {
                                al = 8 & ak ? "d": "v",
                                af = 16 & ak ? "x": "u",
                                ag[af + "_" + al] = (7 & ak) + R["m" + al];
                                break
                            }
                            if (al = 15 & ak, 0 == al ? ag.d = aa([6])[0] : 1 == al ? (R.d = al = aa([18])[0], ag.d = 0) : ag.d = al, !(16 & ak)) {
                                break
                            }
                        }
                    }
                    ah.date = ad(ag.d);
                    for (al in {
                        v: 0,
                        d: 0
                    }) {
                        ac(ag["x_" + al]) || (R["l" + al] = ag["x_" + al]),
                        ac(ag["u_" + al]) && (ag["u_" + al] = R["l" + al])
                    }
                    for (ag.l_l = [ag.u_d, ag.u_d, ag.u_d, ag.u_d, ag.u_v], af = K[15 & ag.c], 1 & ag.u_v && (af = 31 - af), 16 & ag.c && (ag.l_l[4] += 2), ai = 0; 5 > ai; ai++) {
                        af & 1 << 4 - ai && ag.l_l[ai]++,
                        ag.l_l[ai] *= 3
                    }
                    ag.d_v = aa(ag.l_l, [1, 0, 0, 1, 1], [0, 0, 0, 0, 1]),
                    al = R.cd + ag.d_v[0],
                    ah.open = al / R.m,
                    ah.high = (al + ag.d_v[1]) / R.m,
                    ah.low = (al - ag.d_v[2]) / R.m,
                    ah.close = (al + ag.d_v[3]) / R.m,
                    ak = ag.d_v[4],
                    "number" == typeof ak && (ak = [ak, ak >= 0 ? 0 : -1]),
                    R.cd = al + ag.d_v[3],
                    af = R.cv[0] + ak[0],
                    R.cv = [af & V, R.cv[1] + ak[1] + !!((R.cv[0] & V) + (ak[0] & V) & O)],
                    ah.volume = (R.cv[0] & O - 1) + R.cv[1] * O,
                    aj.push(ah)
                }
                return aj
            },
            j = function() {
                var ag, af, ah, ai;
                if (W > 1) {
                    return []
                }
                for (R.l = 0, ai = -1, R.d = aa([18])[0] - 1, ah = aa([18])[0]; R.d < ah;) {
                    af = ad(1),
                    0 >= ai ? (ab() && (R.l += F()), ai = aa([3 * R.l], [0])[0] + 1, ag || (ag = [af], ai--)) : ag.push(af),
                    ai--
                }
                return ag
            },
            ae = function() {
                var ah, ag, ai, af;
                if (W >= 1) {
                    return []
                }
                for (R.f = aa([6])[0], R.c = aa([6])[0], ai = [], R.dv = [], R.dl = [], ah = 0; ah < R.f; ah++) {
                    R.dv[ah] = 0,
                    R.dl[ah] = 0
                }
                for (ah = 0; ! (L >= I) && (L != I - 1 || 7 & (R.c ^ ah)); ah++) {
                    for (af = [], ag = 0; ag < R.f; ag++) {
                        ab() && (R.dl[ag] += F()),
                        R.dv[ag] += aa([3 * R.dl[ag]], [1])[0],
                        af[ag] = R.dv[ag]
                    }
                    ai.push(af)
                }
                return ai
            };
            return Z()()
        };
        var w = {
            dd: function(j) {
                return new Date(j.getFullYear(), j.getMonth(), j.getDate())
            },
            ddt: function(j) {
                return new Date(j.getTime())
            },
            stbd: function(q, j) {
                return q && j && q.getFullYear() == j.getFullYear() && q.getMonth() == j.getMonth() ? q.getDate() == j.getDate() : !1
            },
            stbdt: function(q, j) {
                return q && j ? q.getTime() == j.getTime() : !1
            },
            stbs: function(q, j, z, B) {
                return q.getFullYear() == j && q.getMonth() == z ? q.getDate() == B: !1
            },
            stbds: function(q, j, z) { ! z && (z = "-");
                var B = j.split(z);
                return this.stbs(q, Number(B[0]), Number(B[1]) - 1, Number(B[2]))
            },
            ds: function(q, B, F, G, H, D) {
                "undefined" == typeof B && (B = "-");
                var z = [];
                if (G || z.push(q[F ? "getUTCFullYear": "getFullYear"]()), !H) {
                    var j = q[F ? "getUTCMonth": "getMonth"]() + 1;
                    z.push(10 > j ? "0" + j: j)
                }
                if (!D) {
                    var E = q[F ? "getUTCDate": "getDate"]();
                    z.push(10 > E ? "0" + E: E)
                }
                return z.join(B)
            },
            dss: function(F, B, q) {
                var z = this.ds(F, B, q),
                D = [F["get" + (q ? "UTC": "") + "Hours"]()],
                G = [F["get" + (q ? "UTC": "") + "Minutes"]()],
                j = [F["get" + (q ? "UTC": "") + "Seconds"]()],
                E = [10 > D ? "0" + D: D, 10 > G ? "0" + G: G, 10 > j ? "0" + j: j].join(":");
                return [z, E].join(" ")
            },
            dst: function(E, B, q) {
                var z = [E["get" + (q ? "UTC": "") + "Hours"]()],
                D = [E["get" + (q ? "UTC": "") + "Minutes"]()],
                F = [10 > z ? "0" + z: z, 10 > D ? "0" + D: D];
                if (B) {
                    var j = [E["get" + (q ? "UTC": "") + "Seconds"]()];
                    F.push(10 > j ? "0" + j: j)
                }
                return F.join(":")
            },
            sd: function(q, B) {
                var F = q.split("-"),
                G = F[0],
                H = F[1] - 1 || 0,
                D = F[2] || 1,
                z = 0,
                j = 0,
                E = 0;
                return B && (F = B.split(":"), z = F[0] || 0, j = F[1] || 0, E = F[2] || 0),
                new Date(G, H, D, z, j, E)
            },
            ssd: function(q) {
                var j = q.split(" "),
                z = j[0],
                B = j[1];
                return this.sd(z, B)
            },
            gw: function(j, D) {
                var z = 604800000,
                B = 259200000,
                E = (j.getTime() - B) / z,
                q = (D.getTime() - B) / z;
                return Math.floor(E) == Math.floor(q)
            },
            gm: function(q, j) {
                return q.getFullYear() == j.getFullYear() ? q.getMonth() == j.getMonth() : !1
            },
            weekname: ["\u65e5", "\u4e00", "\u4e8c", "\u4e09", "\u56db", "\u4e94", "\u516d", "\u65e5"],
            nw: function(j) {
                return this.weekname[j] || ""
            }
        };
        this.dateUtil = w,
        this.LoadingSign = A;
        var m = {
            trim: function(j) {
                return j.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, "")
            },
            ps: function(q, j) {
                if (q = Number(q), isNaN(q)) {
                    return "-"
                }
                var z = Math.abs(q);
                return 100000 > z ? q.toFixed(j) : 10000000 > z ? (q / 10000).toFixed(j) + "\u4e07": 100000000 > z ? (q / 10000000).toFixed(j) + "\u5343\u4e07": (q / 100000000).toFixed(j) + "\u4ebf"
            },
            nu: function(j) {
                return j = Number(j),
                j = Math.abs(j),
                100000 > j || isNaN(j) ? [1, ""] : 10000000 > j ? [10000, "\u4e07"] : 100000000 > j ? [10000000, "\u5343\u4e07"] : [100000000, "\u4ebf"]
            },
            vs: function(q, j) {
                var z, B = "";
                return q > 1000000000000 ? (z = (q / 1000000000000).toFixed(0), B = "\u4e07\u4ebf") : q > 100000000 ? (z = (q / 100000000).toFixed(2), B = "\u4ebf") : q > 100000 ? (z = (q / 10000).toFixed(2), B = "\u4e07") : z = q >= 1 ? q.toFixed(0) : "-",
                j ? z + B: z
            },
            zp: function(j) {
                return j = String(j),
                j.length < 2 ? "0" + j: j
            }
        };
        this.strUtil = m,
        this.tUtil = {
            s0: function(j) {
                return j = parseInt(Number(j)),
                0 > j ? "": 10 > j ? "0" + String(j) : String(j)
            },
            tIWS: function(q, j) {
                for (var z = [], B = q; j >= B; B++) {
                    z.push(this.s0(B / 60) + ":" + this.s0(B % 60))
                }
                return z
            },
            gtr: function(q) {
                for (var B, F, G, H, D, z = [], j = 0, E = q.length; E > j; j++) {
                    B = q[j][0],
                    F = q[j][1],
                    G = 60 * Number(B.split(":")[0]) + Number(B.split(":")[1]),
                    H = 60 * Number(F.split(":")[0]) + Number(F.split(":")[1]),
                    D = this.tIWS(G, H),
                    z = z.concat(D)
                }
                return z
            },
            tradingA: [],
            gta: function() {
                return this.tradingA.length || (this.tradingA = this.gtr([["9:30", "11:29"], ["13:00", "15:00"]])),
                this.tradingA
            },
            tradingUs: [],
            gtus: function() {
                return this.tradingUs.length || (this.tradingUs = this.gtr([["9:30", "16:00"]])),
                this.tradingUs
            },
            tradingHk: [],
            gthk: function() {
                return this.tradingHk.length || (this.tradingHk = this.gtr([["09:30", "11:59"], ["13:00", "16:00"]])),
                this.tradingHk
            },
            trading: [],
            gtAll: function(j) {
                return this.trading = this.gtr(j),
                this.trading
            },
            gata: function(q, j) {
                var z;
                switch (q) {
                case "US":
                    z = this.gtus();
                    break;
                case "HK":
                    z = this.gthk();
                    break;
                case "NF":
                    z = this.gtAll(j);
                    break;
                case "HF":
                case "global_index":
                    z = this.gtAll(j);
                    break;
                default:
                case "CN":
                    z = this.gta()
                }
                return z
            },
            ist: function(q, j) {
                return q = q.toUpperCase(),
                C(this.gata(q), j) >= 0
            },
            gltbt: function(j, L, E, F, I, B) {
                for (var H, G = [], D = this.gata(F, B), z = D.length, J = 0, K = 0, q = j * z; q > J; J++) {
                    H = {
                        time: D[J % z],
                        price: 0,
                        percent: 0,
                        avg_price: 0,
                        volume: -0.01,
                        inventory: 0
                    },
                    J % z == 0 && I && (H.date = I[K], K++),
                    G.push(H),
                    E || (G[J].price = G[J].avg_price = L)
                }
                return G[0].price = G[0].avg_price = G[0].prevclose = L,
                G[0].volume = G[0].totalVolume = G[0].totalAmount = 0,
                G[0].inventory = 0,
                G
            },
            azft: function(q, D) {
                if (!q) {
                    return q
                }
                for (var z = this.gata(D), B = 0, j = q.length; j > B; B++) {
                    q[B].time = z[B]
                }
                return q[0].date.setHours(0),
                q
            }
        },
        this.kUtil = {
            mw: function(Z, G, Q, R, X) {
                "number" != typeof R && (R = 0);
                var L = Z.length,
                B = Z[0];
                R > 1 && (B.volume /= R);
                var Y, M = [],
                aa = [];
                if (1 == L) {
                    M[0] = {
                        open: G.open,
                        high: G.high,
                        low: G.low,
                        close: G.price,
                        volume: G.totalVolume,
                        date: w.dd(G.date)
                    },
                    aa[0] = {
                        open: G.open,
                        high: G.high,
                        low: G.low,
                        close: G.price,
                        volume: G.totalVolume,
                        date: w.dd(G.date)
                    }
                } else {
                    for (var E, F = B.open,
                    K = B.high,
                    H = B.low,
                    V = B.close,
                    I = B.volume,
                    j = B.date,
                    O = B.open,
                    J = B.high,
                    D = B.low,
                    z = B.close,
                    q = B.volume,
                    U = B.date,
                    W = 1; L > W; W++) {
                        B = Z[W],
                        R > 1 && (B.volume /= R),
                        w.gw(Z[W - 1].date, B.date) ? (B.high > K && (K = B.high), B.low < H && (H = B.low), V = B.close, I += B.volume, j = B.date) : (isNaN(X) || (Y = j.getDay(), 0 == Y && (Y = 7), E = Y - X, E > 0 && (j = w.ddt(j), j.setDate(j.getDate() - E))), M.push({
                            open: F,
                            high: K,
                            low: H,
                            close: V,
                            volume: I,
                            date: j
                        }), F = B.open, K = B.high, H = B.low, V = B.close, I = B.volume, j = B.date),
                        w.gm(Z[W - 1].date, B.date) ? (B.high > J && (J = B.high), B.low < D && (D = B.low), z = B.close, q += B.volume, U = B.date) : (isNaN(X) || (Y = U.getDay(), 0 == Y && (Y = 7), E = Y - X, E > 0 && (U = w.ddt(U), U.setDate(U.getDate() - E))), aa.push({
                            open: O,
                            high: J,
                            low: D,
                            close: z,
                            volume: q,
                            date: U
                        }), O = B.open, J = B.high, D = B.low, z = B.close, q = B.volume, U = B.date),
                        W == L - 1 && (M.push({
                            open: F,
                            high: K,
                            low: H,
                            close: V,
                            volume: I,
                            date: j
                        }), aa.push({
                            open: O,
                            high: J,
                            low: D,
                            close: z,
                            volume: q,
                            date: U
                        }))
                    }
                }
                return M[0].prevclose = Q,
                aa[0].prevclose = Q,
                [M, aa]
            },
            nc: function(F, B, q, z) {
                if (F && !(F.length < 1)) {
                    z = z || {};
                    var D = F[F.length - 1];
                    if (168 == q && w.gw(D.date, B.date) || 720 == q && w.gm(D.date, B.date)) {
                        return D.day = String(B.today).split("-").join("/"),
                        void(D.date = w.dd(B.date))
                    }
                    D = F[F.length - 1];
                    var G = D.close,
                    j = B.price - G,
                    E = j / G;
                    F.push({
                        open: isNaN(z.price) ? G: z.price,
                        high: isNaN(z.price) ? B.high: z.price,
                        low: isNaN(z.price) ? B.low: z.price,
                        close: isNaN(z.price) ? B.price: z.price,
                        volume: isNaN(z.volume) ? B.totalVolume: z.volume,
                        percent: E,
                        day: String(B.today).split("-").join("/"),
                        date: w.ddt(B.date),
                        time: B.time,
                        ampP: 0,
                        amplitude: 0,
                        change: j,
                        kke_cs: 0
                    })
                }
            },
            pd: function(j, B) {
                var F = j.length,
                G = j[0],
                H = G.prevclose; (isNaN(H) || 0 >= H) && (H = G.open);
                for (var D = 0; F > D; D++) {
                    if (G = j[D], B && B.usePc && (H = G.prevclose), G.amplitude = G.high - G.low, G.ampP = G.amplitude / H, G.change = G.close - H, G.percent = G.change / H, H = G.close, G.day) {
                        var z = G.day.split(" ");
                        G.day = z[0],
                        G.time = z[1].slice(0, 5),
                        G.date = w.sd(G.day, G.time),
                        G.day = G.day.split("-").join("/")
                    } else {
                        var I = G.date,
                        E = m.zp(I.getMonth() + 1),
                        q = m.zp(I.getDate());
                        G.day = [I.getFullYear(), E, q].join("/")
                    }
                    G.kke_cs = G.close > G.open ? 1 : G.open > G.close ? -1 : 0
                }
            },
            ms: function(q, D, z, B, j) {
                return z > q && (q += 24),
                Math.max(1, Math.ceil((60 * (q - z) + D - B) / j))
            },
            spk: function(F, K, D, G, J) {
                if (F == K) {
                    return ! 0
                }
                var q = F.split(":"),
                j = Number(q[0]),
                E = Number(q[1]);
                q = K.split(":");
                var B = Number(q[0]),
                H = Number(q[1]);
                if (j > B && 3 > j - B || j == B && E >= H) {
                    return ! 0
                }
                if (60 != G || J && /^forex/.test(J)) {
                    q = D.split(":");
                    var z = Number(q[0]),
                    I = Number(q[1]),
                    M = this.ms(j, E, z, I, G),
                    L = this.ms(B, H, z, I, G);
                    return M == L
                }
                return "10:30" != F && "11:30" != F && "14:00" != F && "15:00" != F || H == E ? !0 : !1
            },
            yd: function(q) {
                for (var j = q[q.length - 1].date.getFullYear(), z = [], B = q.length; B--&&q[B].date.getFullYear() == j;) {
                    z[z.length] = q[B]
                }
                return z.reverse(),
                z[0].prevclose = q[B] ? q[B].prevclose || q[B].close: z[0].prevclose || z[0].close,
                z
            },
            rd: function(q, D) {
                var z = [],
                B = w.dd(D);
                B.setFullYear(B.getFullYear() - 5);
                for (var j = q.length; j--&&!(q[j].date < B);) {
                    z[z.length] = q[j]
                }
                return z.reverse(),
                z[0].prevclose = q[j] ? q[j].close: z[0].close,
                z
            },
            adbd: function(F, K, D, G) {
                for (var J, q, j, E, B = D ? w.stbdt: w.stbd, H = F.length, z = K.length; z--;) {
                    if (j = K[z].date, 1 > H) {
                        z = K.length - F.length;
                        for (var I = [], M = F[0]; z-->0;) {
                            if (q = t(M) || {},
                            q.isFake = !0, q.kke_cs = 0, G) {
                                for (J in q) {
                                    q.hasOwnProperty(J) && a(q[J]) && (q[J] = 0)
                                }
                            }
                            I.push(q)
                        }
                        F = I.concat(F);
                        break
                    }
                    for (var L = H--; L--&&(E = F[L].date, !B(j, E));) {
                        if (j > E) {
                            if (q = t(F[L]), q.isFake = !0, q.date = j, q.kke_cs = 0, G) {
                                for (J in q) {
                                    q.hasOwnProperty(J) && a(q[J]) && (q[J] = 0)
                                }
                            }
                            F.splice(++L, 0, q),
                            H++;
                            break
                        }
                        F.splice(L, 1),
                        H--
                    }
                }
                return H > 0 && F.splice(0, H),
                F
            },
            ayd: function(F, K, D, G, J) {
                for (var q, j, E, B, H = w.stbd,
                z = F.length,
                I = K.length; I--;) {
                    if (E = K[I], !(E > J)) {
                        if (G > E && !w.stbd(E, G)) {
                            break
                        }
                        for (var M = z--; M--&&(B = F[M].date, !H(E, B));) {
                            if (E > B) {
                                j = t(F[M]);
                                var L = j.close;
                                for (q in j) {
                                    j.hasOwnProperty(q) && a(j[q]) && (j[q] = 0)
                                }
                                j.open = j.high = j.low = j.close = L,
                                j.date = E,
                                F.splice(++M, 0, j),
                                z++;
                                break
                            }
                            F.splice(M, 1),
                            z--
                        }
                    }
                }
                return z > 0 && F.splice(0, z),
                F
            }
        },
        this.domGc = new
        function() {
            var j = r.$C("div");
            return j.style.display = "none",
            function(q, z) {
                if (q) {
                    if (q.hasChildNodes()) {
                        for (; q.childNodes.length > 0;) {
                            q.removeChild(q.firstChild)
                        }
                    }
                    if (z) {
                        return void(q.innerHTML = "")
                    }
                    j.appendChild(q),
                    j.innerHTML = ""
                }
            }
        },
        this.getSUrl = function(q) {
            if (!q) {
                return null
            }
            var D, z = q.match(/(\w*:\/\/)?([^\/]+)(\/+.*)?/i),
            B = z[2],
            j = z[3];
            return D = ["//", B, j].join("")
        },
        this.TipM = o,
        this.logoM = new
        function() {
            var F = watermarke_data,
            B = r.$C("img"),
            q = !1,
            z = [],
            D = [],
            G = function() {
                r.xh5_EvtUtil.addHandler(B, "load",
                function() {
                    for (q = !0; z.length;) {
                        var H = z.shift();
                        E(H)
                    }
                }),
                B.src = F
            },
            j = function(H) {
                if (H.logo && !r.xh5_BrowserUtil.noH5) {
                    var O = H.logo;
                    H.color || (H.color = "#ccc");
                    var U = r.hex2dec(H.color, 0 / 0, !0); (!U || U.length < 3) && (U = [200, 200, 200]);
                    for (var I = O.getContext("2d"), K = I.getImageData(0, 0, O.width, O.height), Q = U[0], J = U[1], L = U[2], R = 0, M = K.data.length; M > R; R += 4) {
                        0 != K.data[R + 3] && (K.data[R] = Q, K.data[R + 1] = J, K.data[R + 2] = L)
                    }
                    I.putImageData(K, 0, 0)
                }
            },
            E = function(H) {
                if (r.xh5_BrowserUtil.noH5) {
                    return null
                }
                if (!q) {
                    for (var K = z.length; K--;) {
                        if (z[K].id == H.id) {
                            return null
                        }
                    }
                    return z.push(H),
                    null
                }
                var M;
                M = r.$C("canvas", H.id),
                M.style.zIndex = 0,
                D.push(M),
                M.style.position = "absolute",
                M.style.top = H.top + "px",
                M.style.right = H.right + "px",
                M.width = B.width,
                M.height = B.height,
                M.style.width = H.LOGO_W + "px",
                M.style.height = H.LOGO_H + "px";
                var I = M.getContext("2d");
                if (H.isShare) {
                    var J = r.xh5_BrowserUtil.hdpr;
                    if (2 > J) {
                        var L = J / 2;
                        I.scale(L, L)
                    }
                }
                return I.drawImage(B, 0, 0),
                j({
                    logo: M,
                    color: H.color
                }),
                T(H.cb) && H.cb(M),
                M
            };
            this.getLogo = E,
            this.styleLogo = j,
            G()
        },
        this.grabM = new
        function() {
            var q = function(H) {
                var O = H.dom,
                Z = H.child;
                if (!O || !Z) {
                    return null
                }
                b(O) && (O = r.$DOM(O));
                var B = O.getElementsByTagName(Z);
                if (!B || B.length < 1) {
                    return null
                }
                var E = r.xh5_BrowserUtil.hdpr,
                V = O.offsetWidth,
                I = O.offsetHeight,
                F = r.$C("canvas"),
                W = F.getContext("2d");
                F.style.width = V + "px",
                F.style.height = I + "px",
                F.width = V * E,
                F.height = I * E,
                1 != E && W.scale(E, E);
                var L = r.xh5_HtmlPosUtil.pageX(O),
                M = r.xh5_HtmlPosUtil.pageY(O),
                R = r.xh5_HtmlPosUtil.parentY(O);
                W.textBaseline = "top";
                for (var D, U, J = 0,
                Y = B.length; Y > J; J++) {
                    D = B[J],
                    U = r.getCSS(D);
                    var X = r.xh5_HtmlPosUtil.pageX(D) - L,
                    K = r.xh5_HtmlPosUtil.pageY(D) - M,
                    Q = Number(U.paddingLeft.split("px")[0]),
                    G = 0.5 * (Number(U.lineHeight.split("px")[0]) - Number(U.fontSize.split("px")[0]));
                    W.fillStyle = U.backgroundColor,
                    W.fillRect(X, K, D.offsetWidth, D.offsetHeight),
                    W.font = [U.fontSize, U.fontFamily].join(" "),
                    W.fillStyle = U.color,
                    W.fillText(D.innerHTML, X + Q, K + G)
                }
                return {
                    canvas: F,
                    x: L,
                    y: R
                }
            },
            j = function(G, E) {
                if (r.POST) {
                    var B = E.txt || "",
                    D = E.url || "",
                    F = "_" + Math.floor(1000 * Math.random());
                    window.open("about:blank", F);
                    var H = r.getSUrl("//www.baidu.com");
                    r.POST(H, {
                        imgData: G,
                        symbol: "imgData"
                    },
                    function(I) {
                        I && I.match(/^http.+/) && (I = encodeURIComponent(I), I = "//service.weibo.com/share/share.php?source=bookmark&title=" + encodeURIComponent(B) + "&url=" + encodeURIComponent(D) + "&pic=" + I, window.open(I, F))
                    })
                }
            },
            z = function(V) {
                if (!r.xh5_BrowserUtil.noH5) {
                    var W = V.ctn;
                    if (W) {
                        for (var Y, M, D = W.getElementsByTagName("canvas"), aa = V.w || W.offsetWidth, R = V.h || W.offsetHeight, F = r.xh5_BrowserUtil.hdpr, G = [], L = r.xh5_HtmlPosUtil.pageX(W), I = r.xh5_HtmlPosUtil.pageY(W), K = D.length; K--;) {
                            M = D[K],
                            Y = M.style.zIndex;
                            var ab, U = !1;
                            for (ab = V.ignoreZIdxArr.length; ab--;) {
                                if (Y == V.ignoreZIdxArr[ab]) {
                                    U = !0;
                                    break
                                }
                            }
                            if (!U) {
                                for (ab = V.ignoreIdArr.length; ab--;) {
                                    if (M.id == V.ignoreIdArr[ab]) {
                                        U = !0;
                                        break
                                    }
                                }
                                if (!U) {
                                    var H = {
                                        canvas: M,
                                        x: r.xh5_HtmlPosUtil.pageX(M) - L,
                                        y: r.xh5_HtmlPosUtil.pageY(M) - I
                                    };
                                    G.push(H)
                                }
                            }
                        }
                        if (!V.nologo) {
                            var E = r.logoM.getLogo({
                                cb: null,
                                id: "share_logo",
                                isShare: !0,
                                top: V.top,
                                right: V.right,
                                LOGO_W: V.LOGO_W,
                                LOGO_H: V.LOGO_H,
                                color: V.color
                            });
                            E && G.push({
                                canvas: E,
                                x: aa - Number(E.style.right.split("px")[0]) - V.LOGO_W,
                                y: Number(E.style.top.split("px")[0])
                            })
                        }
                        if (V.extra) { ! i(V.extra) && (V.extra = [V.extra]);
                            for (var B = 0,
                            ac = V.extra.length; ac > B; B++) {
                                var J = q(V.extra[B]);
                                J && (G = G.concat(J))
                            }
                        }
                        var X = r.$C("canvas"),
                        Z = X.getContext("2d");
                        X.style.width = aa + "px",
                        X.style.height = R + "px",
                        X.width = aa * F,
                        X.height = R * F,
                        Z.fillStyle = V.bgColor,
                        Z.fillRect(0, 0, aa, R);
                        for (var Q = 0,
                        ad = G.length; ad > Q; Q++) {
                            var O = G[Q];
                            Z.drawImage(O.canvas, O.x * F, O.y * F)
                        }
                        j(X.toDataURL("image/png").substring(22), V)
                    }
                }
            };
            this.shareTo = z
        },
        this.bridge = new
        function() {
            function J(R, V) {
                for (var U in R) {
                    R.hasOwnProperty(U) && (R[U] = V + R[U])
                }
            }
            var G, Q, z = !1,
            K = "apitkchart_SLBridge~",
            M = {
                SAVE: "save",
                LOAD: "load",
                REMOVE: "remove",
                DATA: "data",
                READY: "ready"
            };
            J(M, K);
            var D = [],
            H = {},
            O = [],
            E = function(R) {
                var W = R,
                U = W.key,
                V = W.options,
                X = W.value;
                k.save(U, X, V)
            },
            F = function(R) {
                z || Q || O.push([R])
            },
            I = function(R) {
                var W = R,
                U = W.key,
                V = W.options;
                return k.load(U, V)
            },
            j = function(R, U) {
                return z ? void 0 : Q ? void(H[R.uid] = U) : void D.push([R, U])
            },
            B = function(R, W, U) {
                var V = I(R);
                W(V),
                U || j(R, W)
            },
            q = function(R, U) {
                R && (E(R), U || F(R))
            },
            L = new
            function() {
                var R = function(W) {
                    if (W && W.type) {
                        var V = W.type;
                        if ( - 1 != V.indexOf(K)) {
                            return V
                        }
                    }
                    return void 0
                },
                U = function() {
                    for (var V; D.length;) {
                        V = D.shift(),
                        B(V[0], V[1])
                    }
                    for (; O.length;) {
                        V = O.shift(),
                        q(V[0])
                    }
                };
                this.onMsg = function(V) {
                    var W;
                    try {
                        W = JSON.parse(V.data)
                    } catch(X) {}
                    var Y = R(W);
                    if (Y) {
                        switch (Y) {
                        case M.READY:
                            U();
                            break;
                        case M.DATA:
                            if (!r.isFunc(H[W.uid])) {
                                return
                            }
                            H[W.uid](W.result),
                            H[W.uid] = null,
                            delete H[W.uid]
                        }
                    }
                }
            };
            r.xh5_EvtUtil.addHandler(window, "message", L.onMsg),
            this.load = B,
            this.save = q,
            this.getStatus = function() {
                return Q && !z && "1" == G.getAttribute("data-ready")
            }
        },
        this.colorPicker = function() {
            function am(aq, au) {
                var ar = function() {},
                at = aq.prototype;
                ar.prototype = au.prototype,
                aq.prototype = new ar;
                for (var ap in at) {
                    at.hasOwnProperty(ap) && (aq.prototype[ap] = at[ap])
                }
                aq.prototype.constructor = aq
            }
            function aa(aq, ar, at) {
                if (!ar) {
                    return aq
                }
                aq || (aq = {});
                for (var ap in ar) {
                    ar.hasOwnProperty(ap) && ("Object" === R(ar[ap]) ? (!aq[ap] && (aq[ap] = {}), aa(aq[ap], ar[ap], at)) : !at && ap in aq || (aq[ap] = ar[ap]))
                }
                return aq
            }
            function ah(aq) {
                var ap = "undefined" == typeof getComputedStyle ? aq.currentStyle: getComputedStyle(aq);
                return ap ? (aq.clientWidth || f(ap.width) || f(aq.style.width)) - (f(ap.paddingLeft) || 0) - (f(ap.paddingRight) || 0) | 0 : 0
            }
            function ai(aq) {
                var ap = "undefined" == typeof getComputedStyle ? aq.currentStyle: getComputedStyle(aq);
                return ap ? (aq.clientHeight || f(ap.height) || f(aq.style.height)) - (f(ap.paddingTop) || 0) - (f(ap.paddingBottom) || 0) | 0 : 0
            }
            function ak(ap) {
                return ap.getBoundingClientRect ? ap.getBoundingClientRect() : {
                    left: 0,
                    top: 0
                }
            }
            function ae(aq) {
                var ap = aq.getContext("2d");
                ap.clearRect(0, 0, aq.width, aq.height)
            }
            function W(at, ax) {
                var aq = document.createElement("canvas"),
                au = aq.style,
                aw = ah(at),
                ar = ai(at),
                ap = aw * ax.width,
                av = ar * ax.height;
                return aq.width = ap,
                aq.height = av,
                au.position = "absolute",
                au.width = ap + "px",
                au.height = av + "px",
                au.left = aw * ax.left + "px",
                au.top = ar * ax.top + "px",
                at.appendChild(aq),
                aq
            }
            function al(aq, aw) {
                var ay = document.createElement("ul"),
                ax = ay.style,
                at = aw.label,
                ap = ah(aq),
                ar = ai(aq);
                ax.listStyle = "none",
                ax.padding = 0,
                ax.margin = 0,
                ax.font = aw.font,
                ax.position = "absolute",
                ax.left = ap * aw.left + "px",
                ax.top = ar * aw.top + "px";
                for (var au = 0,
                av = at.length; av > au; au++) {
                    ag(ay, au, aw)
                }
                return aq.appendChild(ay),
                ay
            }
            function ag(ap, ar, av) {
                var aw = document.createElement("li"),
                ax = document.createElement("label"),
                at = document.createElement("input"),
                aq = ax.style,
                ay = aw.style,
                au = at.style;
                return ax.innerHTML = av.label[ar],
                aq.textAlign = "right",
                aq.display = "inline-block",
                aq.width = av.labelWidth + "px",
                aq.color = av.color,
                "number" == av.type && (at.type = "number"),
                au.width = av.inputWidth + "px",
                ay.marginBottom = av.gap + "px",
                F(at, "mousemove",
                function(az) {
                    af(az)
                }),
                aw.appendChild(ax),
                aw.appendChild(at),
                ap.appendChild(aw),
                aw
            }
            function Y(au, aq) {
                var ar = document.createElement("div"),
                av = ar.style,
                ap = ah(au),
                at = ai(au);
                return av.position = "absolute",
                av.left = ap * aq.left + "px",
                av.top = at * aq.top + "px",
                av.width = ap * aq.width + "px",
                av.height = at * aq.height + "px",
                au.appendChild(ar),
                ar
            }
            function Z(av, at) {
                function aq(ax) {
                    ax = G(at, ax),
                    av._onmousemove(ax.NyanX, ax.NyanY),
                    av.onmousemove && av.onmousemove(av)
                }
                function ar(ax) {
                    ap = !0,
                    aq(ax)
                }
                function au(ax) {
                    ap && aq(ax),
                    af(ax),
                    an(ax)
                }
                function aw() {
                    ap && (ap = !1)
                }
                var ap = !1;
                "ontouchend" in window ? (F(at, "touchstart", ar), F(at, "touchmove", au), F(at, "touchend", aw)) : (F(at, "mousedown", ar), F(at, "mousemove", au), F(at, "mouseup", aw), F(at, "mouseout", aw))
            }
            function ad(aq, ap, ar) {
                return aq = Math.round(aq),
                ap > aq ? ap: aq > ar ? ar: aq
            }
            function ab(aq, ap, ar) {
                return ap > aq ? ap: aq > ar ? ar: aq
            }
            function aj(ap) {
                return ap.length && "%" === ap.charAt(ap.length - 1) ? ad(parseFloat(ap) / 100 * 255, 0, 255) : ad(parseInt(ap, 10), 0, 255)
            }
            function ac(ap) {
                return ap.length && "%" === ap.charAt(ap.length - 1) ? ab(parseFloat(ap) / 100, 0, 1) : ab(parseFloat(ap), 0, 1)
            }
            function j(aq, ap, ar) {
                return 0 > ar ? ar += 1 : ar > 1 && (ar -= 1),
                1 > 6 * ar ? aq + (ap - aq) * ar * 6 : 1 > 2 * ar ? ap: 2 > 3 * ar ? aq + (ap - aq) * (2 / 3 - ar) * 6 : aq
            }
            function B(ap) {
                var au = (parseFloat(ap[0]) % 360 + 360) % 360 / 360,
                ar = ac(ap[1]),
                at = ac(ap[2]),
                av = 0.5 >= at ? at * (ar + 1) : at + ar - at * ar,
                aq = 2 * at - av;
                return [ab(255 * j(aq, av, au + 1 / 3), 0, 255), ab(255 * j(aq, av, au), 0, 255), ab(255 * j(aq, av, au - 1 / 3), 0, 255)]
            }
            function X(ax) {
                if (ax) {
                    var aB, av, aw = ax[0] / 255,
                    az = ax[1] / 255,
                    aq = ax[2] / 255,
                    ar = Math.min(aw, az, aq),
                    au = Math.max(aw, az, aq),
                    at = au - ar,
                    ap = (au + ar) / 2;
                    if (0 === at) {
                        aB = 0,
                        av = 0
                    } else {
                        av = 0.5 > ap ? at / (au + ar) : at / (2 - au - ar);
                        var ay = ((au - aw) / 6 + at / 2) / at,
                        aA = ((au - az) / 6 + at / 2) / at,
                        aC = ((au - aq) / 6 + at / 2) / at;
                        aw === au ? aB = aC - aA: az === au ? aB = 1 / 3 + ay - aC: aq === au && (aB = 2 / 3 + aA - ay),
                        0 > aB && (aB += 1),
                        aB > 1 && (aB -= 1)
                    }
                    return [360 * aB, av, ap]
                }
            }
            function z(av) {
                if (av) {
                    av += "";
                    var at = av.replace(/ /g, "").toLowerCase();
                    if ("#" !== at.charAt(0)) {
                        var aq = at.indexOf("("),
                        ar = at.indexOf(")");
                        if ( - 1 !== aq && ar + 1 === at.length) {
                            var au = at.substr(0, aq),
                            aw = at.substr(aq + 1, ar - (aq + 1)).split(",");
                            switch (au) {
                            case "rgb":
                                if (3 !== aw.length) {
                                    return
                                }
                                return [aj(aw[0]), aj(aw[1]), aj(aw[2])];
                            case "hsl":
                                if (3 !== aw.length) {
                                    return
                                }
                                return B(aw);
                            default:
                                return
                            }
                        }
                    } else {
                        if (4 === at.length) {
                            var ap = parseInt(at.substr(1), 16);
                            if (! (ap >= 0 && 4095 >= ap)) {
                                return
                            }
                            return [(3840 & ap) >> 4 | (3840 & ap) >> 8, 240 & ap | (240 & ap) >> 4, 15 & ap | (15 & ap) << 4]
                        }
                        if (7 === at.length) {
                            if (ap = parseInt(at.substr(1), 16), !(ap >= 0 && 16777215 >= ap)) {
                                return
                            }
                            return [(16711680 & ap) >> 16, (65280 & ap) >> 8, 255 & ap]
                        }
                    }
                }
            }
            function q(aq) {
                var ap = [( + aq[0]).toFixed(0), ( + aq[1]).toFixed(0), ( + aq[2]).toFixed(0)];
                return ((1 << 24) + (ap[0] << 16) + (ap[1] << 8) + +ap[2]).toString(16).slice(1)
            }
            function O(aq) {
                var ap = [aq[0].toFixed(0), (100 * aq[1]).toFixed(0) + "%", (100 * aq[2]).toFixed(0) + "%"];
                return "hsl(" + ap.join(",") + ")"
            }
            function D(aq, ap) {
                if (aq) {
                    var ar = "Array" == R(aq) ? aq: z(aq);
                    switch (ap) {
                    case "rgb":
                        return ap + "(" + ar.join(",") + ")";
                    case "hex":
                        return "#" + q(ar);
                    case "hsl":
                        return O(X(ar))
                    }
                }
            }
            if ("undefined" != typeof getComputedStyle) {
                var F = function() {
                    return window.addEventListener ?
                    function(aq, ap, ar) {
                        aq.addEventListener(ap, ar)
                    }: function(aq, ap, ar) {
                        aq.attachEvent("on" + ap, ar)
                    }
                } (),
                af = function() {
                    return window.addEventListener ?
                    function(ap) {
                        ap.stopPropagation()
                    }: function(ap) {
                        ap.cancelBubble = !0
                    }
                } (),
                an = function() {
                    return window.addEventListener ?
                    function(ap) {
                        ap.preventDefault()
                    }: function(ap) {
                        ap.returnValue = !1
                    }
                } (),
                V = Object.prototype.toString,
                R = function(ap) {
                    return null === ap ? "Null": void 0 === ap ? "Undefined": V.call(ap).slice(8, -1)
                },
                J = function(aq, ap) {
                    if (!aq) {
                        return - 1
                    }
                    if (aq.indexOf) {
                        return aq.indexOf(ap)
                    }
                    for (var ar = aq.length; ar--;) {
                        if (aq[ar] === ap) {
                            return ar
                        }
                    }
                },
                G = function(av, at) {
                    if (at = at || window.event, null != at.NyanX) {
                        return at
                    }
                    var aq = at.type,
                    ar = aq && J(aq, "touch") >= 0;
                    if (ar) {
                        var aw = "touchend" != aq ? at.targetTouches[0] : at.changedTouches[0];
                        if (aw) {
                            var ap = ak(av);
                            at.NyanX = aw.clientX - ap.left,
                            at.NyanY = aw.clientY - ap.top
                        }
                    } else {
                        var au = ak(av);
                        at.NyanX = at.clientX - au.left,
                        at.NyanY = at.clientY - au.top,
                        at.NyanDelta = at.wheelDelta ? at.wheelDelta / 120 : -(at.detail || 0) / 3
                    }
                    return at
                },
                I = {
                    width: 320,
                    height: 200,
                    zIndex: 10002,
                    backgroundColor: "#444",
                    wrapShadow: "3px 3px 4px rgba(0, 0, 0, 0.4)",
                    color: "#66ccff",
                    picker: {
                        left: 0.05,
                        top: 0.15,
                        width: 0.4,
                        height: 0.65,
                        size: 10,
                        color: "#000",
                        lineWidth: 1
                    },
                    slider: {
                        left: 0.5,
                        top: 0.15,
                        width: 0.05,
                        height: 0.65
                    },
                    rgbBox: {
                        label: ["R:", "G:", "B:"],
                        font: "12px Microsoft YaHei",
                        color: "#FFFEFA",
                        gap: 8,
                        type: "number",
                        labelWidth: 15,
                        inputWidth: 36,
                        left: 0.6,
                        top: 0.15
                    },
                    hslBox: {
                        label: ["H:", "S:", "L:"],
                        font: "12px Microsoft YaHei",
                        color: "#FFFEFA",
                        gap: 8,
                        type: "number",
                        labelWidth: 15,
                        inputWidth: 36,
                        left: 0.78,
                        top: 0.15
                    },
                    hexBox: {
                        label: ["#"],
                        font: "12px Microsoft YaHei",
                        color: "#FFFEFA",
                        labelWidth: 15,
                        inputWidth: 60,
                        left: 0.03,
                        top: 0.85
                    },
                    colorBox: {
                        left: 0.63,
                        top: 0.6,
                        width: 0.32,
                        height: 0.2
                    },
                    okBtn: {
                        text: "\u786e\u5b9a",
                        backgroundColor: "#6C6C6C",
                        color: "#FFFEFA",
                        font: "12px Microsoft YaHei",
                        left: 0.65,
                        top: 0.87,
                        width: 0.12,
                        height: 0.1
                    },
                    cancelBtn: {
                        text: "\u53d6\u6d88",
                        backgroundColor: "#6C6C6C",
                        color: "#FFFEFA",
                        font: "12px Microsoft YaHei",
                        left: 0.83,
                        top: 0.87,
                        width: 0.12,
                        height: 0.1
                    }
                },
                Q = function(aq, ap) {
                    aa(this, ap),
                    this.background = W(aq, ap),
                    this.layer = W(aq, ap),
                    this.H = 0,
                    this.S = 0,
                    Z(this, this.layer),
                    this.paintBG()
                };
                Q.prototype = {
                    constructor: Q,
                    paintBG: function() {
                        for (var ap = this.background,
                        au = ap.getContext("2d"), ar = ap.width, at = ap.height, av = au.createLinearGradient(0, 0, ar, 0), aq = 0; 1 > aq; aq += 1 / 6) {
                            av.addColorStop(aq, "hsl(" + 360 * aq + " , 100%, 50%)")
                        }
                        au.fillStyle = av,
                        au.fillRect(0, 0, ar, at),
                        av = au.createLinearGradient(0, 0, 0, at),
                        av.addColorStop(0, "hsla(0, 0%, 50%, 0)"),
                        av.addColorStop(1, "hsla(0, 0%, 50%, 1)"),
                        au.fillStyle = av,
                        au.fillRect(0, 0, ar, at)
                    },
                    _onmousemove: function(at, aq) {
                        var ar = this.layer,
                        au = ah(ar),
                        ap = ai(ar);
                        this.H = at / au * 360,
                        this.S = (ap - aq) / ap
                    },
                    updatePoint: function() {
                        var au = this.layer,
                        aq = au.getContext("2d"),
                        ar = this.size,
                        av = ah(au),
                        aw = ai(au),
                        at = this.H * av / 360,
                        ap = aw - this.S * aw;
                        aq.clearRect(0, 0, au.width, au.height),
                        aq.beginPath(),
                        aq.moveTo(at - ar, ap),
                        aq.lineTo(at + ar, ap),
                        aq.moveTo(at, ap - ar),
                        aq.lineTo(at, ap + ar),
                        aq.strokeStyle = "black",
                        aq.lineWidth = 2,
                        aq.stroke()
                    },
                    update: function(ap) {
                        this.H = ap[0],
                        this.S = ap[1],
                        this.updatePoint()
                    }
                };
                var M = function(aq, ap) {
                    aa(this, ap),
                    this.background = W(aq, ap),
                    this.layer = W(aq, ap),
                    this.L = 0.5,
                    Z(this, this.layer)
                };
                M.prototype = {
                    constructor: M,
                    paintBG: function(av) {
                        var at = this.background,
                        aq = at.getContext("2d"),
                        ar = at.width,
                        au = at.height,
                        ap = aq.createLinearGradient(0, 0, 0, au);
                        ae(at),
                        ap.addColorStop(0, "#fff"),
                        ap.addColorStop(0.5, "hsl(" + ( + av[0]).toFixed(0) + ", " + (100 * av[1]).toFixed(0) + "%, 50%)"),
                        ap.addColorStop(1, "#000"),
                        aq.fillStyle = ap,
                        aq.fillRect(0, 0, ar, au)
                    },
                    _onmousemove: function(aq, at) {
                        var ar = this.layer,
                        ap = ai(ar);
                        this.L = (ap - at) / ap
                    },
                    updatePoint: function(av) {
                        for (var ar = this.layer,
                        aq = ar.getContext("2d"), at = ai(ar), aw = at - this.L * at, ap = B(av), au = ap.length; au--;) {
                            ap[au] = (255 - ap[au]).toFixed(0)
                        }
                        aq.clearRect(0, 0, ar.width, ar.height),
                        aq.beginPath(),
                        aq.moveTo(0, aw + 0.5),
                        aq.lineTo(ar.width, aw + 0.5),
                        aq.strokeStyle = D(ap, "hex"),
                        aq.lineWidth = 3,
                        aq.stroke()
                    },
                    update: function(ap) {
                        this.L = ap[2],
                        this.paintBG(ap),
                        this.updatePoint(ap)
                    }
                };
                var L = function(aq, ap) {
                    var ar = this;
                    this.box = al(aq, ap),
                    F(this.box, "input",
                    function(at) {
                        at.target.value = ad(at.target.value, 0, 255),
                        ar.oninput && ar.oninput(at)
                    })
                };
                L.prototype = {
                    constructor: L,
                    getRGB: function() {
                        var ap = this.box.childNodes;
                        return "rgb(" + ap[0].childNodes[1].value + ", " + ap[1].childNodes[1].value + ", " + ap[2].childNodes[1].value + ")"
                    },
                    getRGBArr: function() {
                        var ap = this.box.childNodes;
                        return [ap[0].childNodes[1].value, ap[1].childNodes[1].value, ap[2].childNodes[1].value]
                    },
                    update: function(aq) {
                        for (var au = this.box.childNodes,
                        ar = B(aq), at = 0, ap = ar.length; ap > at; at++) {
                            au[at].childNodes[1].value = ( + ar[at]).toFixed(0)
                        }
                    }
                };
                var U = function(aq, ap) {
                    var ar = this;
                    this.box = al(aq, ap);
                    var at = this.box.childNodes;
                    F(at[0].childNodes[1], "input",
                    function(au) {
                        au.target.value = ad(au.target.value, 0, 360),
                        ar.oninput && ar.oninput(au)
                    }),
                    F(at[1].childNodes[1], "input",
                    function(au) {
                        au.target.value = ad(au.target.value, 0, 100),
                        ar.oninput && ar.oninput(au)
                    }),
                    F(at[2].childNodes[1], "input",
                    function(au) {
                        au.target.value = ad(au.target.value, 0, 100),
                        ar.oninput && ar.oninput(au)
                    })
                };
                U.prototype = {
                    constructor: U,
                    getHSL: function() {
                        var ap = this.box.childNodes;
                        return "hsl(" + ap[0].childNodes[1].value + ", " + ap[1].childNodes[1].value + "%, " + ap[2].childNodes[1].value + "% )"
                    },
                    getHSLArr: function() {
                        var ap = this.box.childNodes;
                        return [ap[0].childNodes[1].value, ap[1].childNodes[1].value / 100, ap[2].childNodes[1].value / 100]
                    },
                    update: function(aq) {
                        for (var ap = this.box.childNodes,
                        ar = 0,
                        at = aq.length; at > ar; ar++) {
                            ap[ar].childNodes[1].value = (ar > 0 ? 100 * aq[ar] : +aq[ar]).toFixed(0)
                        }
                    }
                };
                var ao = function(aq, ap) {
                    var ar = this;
                    this.box = al(aq, ap);
                    var at = this.box.childNodes;
                    F(at[0].childNodes[1], "input",
                    function(av) {
                        av.target.value = av.target.value.replace(/[^0-9A-Fa-f]/g, "").slice(0, 6);
                        var au = av.target.value.length;
                        6 == au && ar.oninput && ar.oninput(av)
                    })
                };
                ao.prototype = {
                    constructor: ao,
                    getHEX: function() {
                        return "#" + this.box.childNodes[0].childNodes[1].value
                    },
                    update: function(aq) {
                        var ap = this.box.childNodes;
                        ap[0].childNodes[1].value = q(B(aq))
                    }
                };
                var E = function(aq, ap) {
                    this.btn = Y(aq, ap);
                    var ar = this.btn.style;
                    this.btn.innerHTML = ap.text,
                    ar.font = ap.font,
                    ar.lineHeight = ai(aq) * ap.height + "px",
                    ar.textAlign = "center",
                    ar.backgroundColor = ap.backgroundColor,
                    ar.color = ap.color,
                    ar.cursor = "pointer"
                },
                H = function(aq, ap) {
                    this.box = Y(aq, ap),
                    this.box.style.backgroundColor = "#000"
                };
                H.prototype = {
                    constructor: H,
                    update: function(aq) {
                        for (var ap = B(aq), ar = ap.length; ar--;) {
                            ap[ar] = ( + ap[ar]).toFixed(0)
                        }
                        this.box.style.backgroundColor = "rgb(" + ap[0] + ", " + ap[1] + ", " + ap[2] + ")"
                    }
                };
                var K = function(ap) {
                    ap = ap || {},
                    this.param = aa(ap, I),
                    this.inited = !1,
                    r.xh5_EvtDispatcher.call(this)
                };
                return K.prototype = {
                    constructor: K,
                    init: function() {
                        if (!this.inited) {
                            var aq = this.param,
                            ap = X(z(aq.color));
                            this._initDoms(aq),
                            this._initEvent(),
                            this.update(ap),
                            document.body.appendChild(this.wrap),
                            this.inited = !0
                        }
                    },
                    _initDoms: function(aq) {
                        var ap = document.createElement("div"),
                        ar = ap.style;
                        ar.position = "absolute",
                        ar.width = aq.width + "px",
                        ar.height = aq.height + "px",
                        ar.zIndex = aq.zIndex,
                        ar.backgroundColor = aq.backgroundColor,
                        ar.boxShadow = aq.wrapShadow,
                        ar.transition = "opacity 0.2s ease-in-out 0s",
                        ar.opacity = 0,
                        ar.visibility = "hidden",
                        ar.userSelect = "none",
                        ar.webkitUserSelect = "none",
                        ar.msUserSelect = "none",
                        ar.mosUserSelect = "none",
                        this.wrap = ap,
                        this.picker = new Q(ap, aq.picker),
                        this.slider = new M(ap, aq.slider),
                        this.rgbBox = new L(ap, aq.rgbBox),
                        this.hslBox = new U(ap, aq.hslBox),
                        this.hexBox = new ao(ap, aq.hexBox),
                        this.colorBox = new H(ap, aq.colorBox),
                        this.okBtn = new E(ap, aq.okBtn),
                        this.cancelBtn = new E(ap, aq.cancelBtn)
                    },
                    _initEvent: function() {
                        function aE(aK) {
                            aG = !0,
                            aw = +aH.left.replace(/[^0-9.]/g, ""),
                            aB = +aH.top.replace(/[^0-9.]/g, ""),
                            aK.targetTouches ? (av = aK.targetTouches[0].clientX, aI = aK.targetTouches[0].clientY) : (av = aK.clientX, aI = aK.clientY)
                        }
                        function aq(aK) {
                            aG && (aK.targetTouches ? (aC = aK.targetTouches[0].clientX - av, ax = aK.targetTouches[0].clientY - aI) : (aC = aK.clientX - av, ax = aK.clientY - aI), aH.left = +aw + +aC + "px", aH.top = +aB + +ax + "px", af(aK)),
                            an(aK)
                        }
                        function aA() {
                            aG = !1
                        }
                        var aw, aB, av, aI, aC, ax, aF = this,
                        aJ = this.wrap,
                        ap = this.picker,
                        au = this.slider,
                        ar = this.rgbBox,
                        ay = this.hslBox,
                        at = this.hexBox,
                        aD = this.okBtn,
                        az = this.cancelBtn,
                        aH = aJ.style,
                        aG = !1;
                        "ontouchend" in window ? (F(aJ, "touchstart", aE), F(aJ, "touchmove", aq), F(aJ, "touchend", aA)) : (F(aJ, "mousedown", aE), F(aJ, "mousemove", aq), F(aJ, "mouseup", aA), F(aJ, "mouseout", aA)),
                        ap.onmousemove = function() {
                            aF.update([ap.H, ap.S, au.L])
                        },
                        au.onmousemove = function() {
                            aF.update([ap.H, ap.S, au.L])
                        },
                        ay.oninput = function() {
                            aF.update(ay.getHSLArr())
                        },
                        ar.oninput = function() {
                            aF.update(X(ar.getRGBArr()))
                        },
                        at.oninput = function() {
                            aF.update(at.getHEX())
                        },
                        F(aD.btn, "click",
                        function() {
                            aF.hide(),
                            aF.re("ok", [{
                                rgb: ar.getRGB(),
                                hsl: ay.getHSL(),
                                hex: D(ay.getHSL(), "hex")
                            },
                            aF.target]),
                            aF.onok && aF.onok({
                                rgb: ar.getRGB(),
                                hsl: ay.getHSL(),
                                hex: D(ay.getHSL(), "hex")
                            },
                            aF.target)
                        }),
                        F(az.btn, "click",
                        function() {
                            aF.hide()
                        })
                    },
                    show: function(ap, au, ar, at) { ! this.inited && this.init();
                        var av = this.wrap,
                        aq = av.style;
                        aq.left = (ap ? ap: 0) + "px",
                        aq.top = (au ? au: 0) + "px",
                        aq.visibility = "visible",
                        aq.opacity = 1,
                        at && this.update(at),
                        this.target = ar
                    },
                    hide: function() {
                        if (this.inited) {
                            var aq = this.wrap,
                            ap = aq.style;
                            ap.visibility = "hidden",
                            ap.opacity = 0
                        }
                    },
                    update: function(aq) {
                        var ap = "Array" == R(aq) ? aq: X(z(aq));
                        this.picker.update(ap),
                        this.slider.update(ap),
                        this.rgbBox.update(ap),
                        this.hslBox.update(ap),
                        this.hexBox.update(ap),
                        this.colorBox.update(ap)
                    }
                },
                am(K, r.xh5_EvtDispatcher),
                new K
            }
        } (),
        this.HQ_DOMAIN = e()
    }
});
xh5_define("cfgs.settinger", [],
function() {
    function d(a) {
        this.uid = a,
        this.custom = {
            show_underlay_vol: !0,
            show_ext_marks: !0,
            show_floater: !0,
            mousewheel_zoom: !0,
            keyboard: !0,
            history_t: "window",
            allow_move: !0,
            mouse_and_touch: !0,
            tchart_tap: !0,
            show_k_rangepercent: !0,
            k_0pct: "no",
            touch_prevent: !0,
            mini_threshold: {
                width: 0 / 0,
                height: 0 / 0
            },
            show_logo: !0,
            k_overlay: !1,
            stick: !0,
            smooth: !1,
            indicatorpanel_url: "//" + window.location.host + "/style/html/tool.html?20180904",
            allow_indicator_edit: !0,
            storage_lv: 2,
            indicator_reorder: !0,
            indicator_cvs_title: !1,
            indicator_reheight: !1,
            centerZoom: !0
        },
        this.PARAM = {
            K_CL_NUM: 260,
            updateRate: 5,
            T_RATE: 120,
            minCandleNum: 25,
            maxCandleNum: 0 / 0,
            defaultCandleNum: 80,
            zoomUnit: 90,
            zoomLimit: 10,
            zoomArea: 0.15,
            I_Z_INDEX: 50,
            G_Z_INDEX: 30,
            _hd: 1,
            setHd: function(b) {
                "number" == typeof b && (this._hd = b)
            },
            getHd: function() {
                return this._hd
            },
            isFlash: !1,
            LOGO_ID: "KKE_api_finance_logo"
        },
        this.DIMENSION = {
            extend_draw: !1,
            LOGO_W: 80,
            LOGO_H: 20,
            posY: 0,
            posX: 55,
            RIGHT_W: 55,
            K_RIGHT_W: 9,
            _w: void 0,
            _h: void 0,
            w_t: void 0,
            w_k: void 0,
            h_t: void 0,
            h_k: void 0,
            P_HV: 0.28,
            H_MA4K: 13,
            H_TIME_PART: 13,
            K_F_T: 47,
            T_F_T: 13,
            H_T_T: 14,
            W_T_L: 43,
            H_T_G: 60,
            H_BLK: 50,
            H_T_B: 7,
            I_V_O: 0,
            getOneWholeTH: function() {
                return this.H_T_T + this.H_T_G
            },
            H_RS: 30,
            setStageW: function(b) {
                this._w = b,
                this.w_k = b - this.posX - this.K_RIGHT_W,
                this.w_t = b - this.posX - this.RIGHT_W
            },
            setStageH: function(e, b) {
                this._h = e,
                this.h_k = this.h_t = e - b - this.H_TIME_PART - this.H_MA4K
            },
            getStageW: function() {
                return this._w
            },
            getStageH: function() {
                return this._h
            }
        },
        this.STYLE = {
            FONT_SIZE: 12,
            FONT_FAMILY: "helvetica,arial,sans-serif"
        },
        this.COLOR = {
            BG: "#fff",
            T_P: "#007cc8",
            T_AVG: "#000000",
            T_PREV: "#9b9b9b",
            K_RISE: "#f11200",
            K_FALL: "#00a800",
            K_N: "#000000",
            K_CL: "#007cc8",
            K_MS_RISE: "#f11200",
            K_MS_FALL: "#00a800",
            K_MS_N: "#000000",
            T_RISE: "#f11200",
            T_FALL: "#00a800",
            T_N: "#000000",
            F_RISE: "#f11200",
            F_FALL: "#00a800",
            F_N: "#000000",
            F_BG: "rgba(255,255,255,.9)",
            F_BR: "#000",
            F_T: "#000",
            K_EXT: "#080208",
            T_T: "#777",
            K_P: "#555",
            V_SD: "#dddddd",
            M_ARR: ["#fff", "#BCD4F9"],
            M_ARR_A: [0.5, 0],
            TIME_S: "#000000",
            TIME_L: "#eeeeee",
            GRID: "#eee",
            IVH_LINE: "#494949",
            P_TC: "#fff",
            P_BG: "#494949",
            T_TC: "#fff",
            T_BG: "#494949",
            REMARK_T: "#fff",
            REMARK_BG: "#494949",
            K_PCT: "#ccc",
            BTN_ARR: ["#2b9dfc", "#fff"],
            TIP_ARR: ["#000", "#fff", null, !1, null],
            LOGO: "#ccc"
        },
        this.datas = {
            s: "sh000001",
            mode: "",
            tDataLen: 241,
            t: "",
            isT: !1,
            scaleType: "price",
            candle: "solid"
        }
    }
    var c = {
        URLHASH: {
            TS: 1,
            T1: 1,
            T5: 5,
            FAKE_T5: 2,
            NTS: "ts",
            NT5: "t5",
            KD: 24,
            KW: 168,
            KM: 720,
            KCL: 365,
            KDF: 23,
            KDB: 25,
            KWF: 167,
            KWB: 169,
            KMF: 719,
            KMB: 721,
            KCLF: 364,
            KCLB: 366,
            NKD: "kd",
            NKW: "kw",
            NKM: "km",
            NKCL: "kcl",
            NKDF: "kdf",
            NKDB: "kdb",
            NKWF: "kwf",
            NKWB: "kwb",
            NKMF: "kmf",
            NKMB: "kmb",
            NKCLF: "kclf",
            NKCLB: "kclb",
            K1: 1,
            K5: 5,
            K15: 15,
            K30: 30,
            K60: 60,
            K240: 240,
            NK1: "k1",
            NK5: "k5",
            NK15: "k15",
            NK30: "k30",
            NK60: "k60",
            NK240: "k240",
            KMS: 1000,
            NKMS: "kms",
            KYTD: 983,
            NYTD: "kytd",
            vn: function(b) {
                for (var a in this) {
                    if (this.hasOwnProperty(a) && "number" == typeof this[a] && b == this[a]) {
                        return this[a]
                    }
                }
                return void 0
            },
            vi: function(a) {
                switch (a) {
                case this.NTS:
                    return this.TS;
                case this.NT5:
                    return this.FAKE_T5;
                default:
                    return this[a.toUpperCase()]
                }
            },
            gt: function(b) {
                var a;
                switch (b) {
                case this.KMS:
                    a = {
                        type: "msk"
                    };
                    break;
                case this.K1:
                case this.K5:
                case this.K15:
                case this.K30:
                case this.K60:
                case this.K240:
                    a = {
                        type: "mink"
                    };
                    break;
                case this.KDF:
                case this.KWF:
                case this.KMF:
                case this.KCLF:
                    a = {
                        type: "rek",
                        dir: "q"
                    };
                    break;
                case this.KDB:
                case this.KWB:
                case this.KMB:
                case this.KCLB:
                    a = {
                        type: "rek",
                        dir: "h"
                    };
                    break;
                default:
                    a = {
                        type: "k"
                    }
                }
                switch (b) {
                case this.KD:
                case this.KDF:
                case this.KDB:
                    a.baseid = this.KD;
                    break;
                case this.KW:
                case this.KWF:
                case this.KWB:
                    a.baseid = this.KW;
                    break;
                case this.KM:
                case this.KMF:
                case this.KMB:
                    a.baseid = this.KM;
                    break;
                case this.KCL:
                case this.KCLF:
                case this.KCLB:
                    a.baseid = this.KCL;
                    break;
                default:
                    a.baseid = b
                }
                return a
            }
        },
        e: {
            K_DATA_LOADED: "kDataLoaded",
            T_DATA_LOADED: "tDataLoaded",
            I_EVT: "iEvent"
        },
        nohtml5info: "\u68c0\u6d4b\u5230\u60a8\u7684\u6d4f\u89c8\u5668\u8fc7\u65e7\u4e14\u4e0d\u652f\u6301HTML 5\uff0c\u5f53\u524d\u4ee5\u517c\u5bb9\u6a21\u5f0f\u8fd0\u884c\u3002<br/>\u4e3a\u83b7\u5f97\u66f4\u597d\u7684\u4f53\u9a8c\u53ca\u5b8c\u5584\u7684\u529f\u80fd\uff0c\u5efa\u8bae\u4f7f\u7528<a style='color:#fff;text-decoration:underline;' href='//down.tech.api.com.cn/content/40975.html' target='_blank'>\u8c37\u6b4cChrome</a>\u6d4f\u89c8\u5668\uff0c\u6216\u5347\u7ea7\u5230\u60a8\u6d4f\u89c8\u5668\u7684<a style='color:#fff;text-decoration:underline;' href='//down.tech.api.com.cn/content/58979.html' target='_blank'>\u6700\u65b0\u7248\u672c</a>\u3002",
        historyt08: "\u5f53\u524d\u63d0\u4f9bA\u80a12008\u5e74\u4ee5\u6765\u7684\u5386\u53f2\u5206\u65f6\u8d70\u52bf\u67e5\u8be2",
        nohistoryt: "\u65e0\u6b64\u8bc1\u5238\u6b64\u65f6\u6bb5\u5386\u53f2\u5206\u65f6\u6570\u636e",
        norecord: "\u8bc1\u5238\u4ee3\u7801\u65e0\u8bb0\u5f55",
        notlisted: "\u672a\u4e0a\u5e02",
        delisted: "\u9000\u5e02",
        nodata: "\u672a\u52a0\u8f7d\u5230\u6709\u6548\u6570\u636e",
        noredata: "\u90e8\u5206\u8bc1\u5238\u65e0\u590d\u6743\u6570\u636e"
    };
    return new
    function() {
        this.VER = "2.0.30";
        var a = [];
        this.getSetting = function(b) {
            for (var h, e = a.length; e--;) {
                if (h = a[e], b == h.uid) {
                    return h
                }
            }
            return h = new d(b),
            a.push(h),
            h
        },
        this.globalCfg = c
    }
});
xh5_define("datas.hq", ["utils.util"],
function(a) {
    var l = a.load,
    n = a.fBind,
    r = a.market,
    t = a.cookieUtil,
    e = a.dateUtil,
    s = a.tUtil,
    u = 0 == location.protocol.indexOf("http:"),
    o = a.HQ_DOMAIN,
    c = new
    function() {
        var d, b = "apiH5EtagStatus",
        f = {
            domain: "",
            path: "/",
            expires: 3600
        },
        j = "n",
        g = "y",
        h = 0,
        k = "//" + window.location.host + "/api/real.php?list=sys_hqEtagMode",
        p = function() {
            l(k,
            function() {
                var q = window.hq_str_sys_hqEtagMode;
                0 == h ? h = q: (h == q ? (d = !1, t.set(b, j, f)) : (d = !0, t.set(b, g, f)), h = 0)
            })
        },
        m = function() {
            var q = t.get(b);
            switch (q) {
            case j:
                d = !1;
                break;
            case g:
                d = !0;
                break;
            default:
                d = !1,
                p()
            }
        };
        m(),
        setInterval(m, 2000),
        this.isETag = function() {
            return d
        }
    },
    i = function() {
        function k(B, E, G) {
            var K = {},
            J = w[B];
            J || (J = {
                symbol: B
            },
            w[B] = J);
            var H = O.trHandler(G, J);
            H && (J.trstr = G),
            K[B] = J;
            var z = {
                msg: "",
                dataObj: K
            };
            return a.isFunc(E) && E(z),
            z
        }
        function R(z) {
            return /^nf_(IF|IC|IH|TF|TS)\w+$/.test(z) ? "CFF": /^nf_T(\d{4}|0)$/.test(z) ? "CFF": "NF"
        }
        function d(ac, z, J, Y) {
            if (Y && --Y.count > 0) {
                return null
            }
            for (var G, U, B, V, ae, aa, ad = ac.split(","), H = [], E = {},
            W = 0, Z = ad.length; Z > W; W++) {
                if (G = ad[W], B = b[G], B || (B = {
                    symbol: G
                },
                b[G] = B), U = r(G), J) {
                    V = J
                } else {
                    switch (V = window["hq_str_" + G], U) {
                    case "HK":
                        ae = window["hq_str_" + G.replace("rt_", "") + "_i"];
                        break;
                    default:
                        ae = window["hq_str_" + G + "_i"]
                    }
                    if ("US" == U) {
                        var Q = window.hq_str_gb_$ixic || window.hq_str_gb_ixic || window.hq_str_gb_$dji || window.hq_str_gb_dji
                    }
                }
                aa = V && V.length > 0 ? V.split(",") : void 0;
                var K;
                switch (U) {
                case "CN":
                    K = O;
                    break;
                case "CNI":
                    K = O;
                    break;
                case "US":
                    K = N;
                    break;
                case "HK":
                    K = j;
                    break;
                case "OTC":
                    K = C;
                    break;
                case "HF":
                    K = I;
                    break;
                case "NF":
                    K = "CFF" == R(G) ? T: p;
                    break;
                case "global_index":
                    K = q;
                    break;
                case "fund":
                    K = f;
                    break;
                case "op_m":
                case "option_cn":
                    K = L;
                    break;
                case "forex":
                case "forex_yt":
                    K = D;
                    break;
                case "CFF":
                    K = T;
                    break;
                case "BTC":
                    K = A;
                    break;
                default:
                    K = void 0
                }
                var aj = !0;
                K && (aj = K.update(aa, B, ae, Q)),
                aj && (B.hqstr = V),
                H.push(B),
                E[G] = B
            }
            var X = {
                msg: "",
                data: H,
                dataObj: E
            };
            return a.isFunc(z) && z(X),
            X
        }
        function S(z) {
            var G = 40,
            E = z.split(","),
            B = [];
            for (E = a.uae(E); E.length > G;) {
                B.push(E.splice(0, G))
            }
            return B.push(E.splice(0, E.length)),
            B
        }
        this.VER = "2.6.17";
        var ab, h = {
            "00": "",
            "01": "\u505c\u724c\u4e00\u5c0f\u65f6",
            "02": "\u505c\u724c\u4e00\u5929",
            "03": "\u8fde\u7eed\u505c\u724c",
            "04": "\u76d8\u4e2d\u505c\u724c",
            "05": "\u505c\u724c\u534a\u5929",
            "06": "\u505c\u724c\u534a\u5c0f\u65f6",
            "07": "\u6682\u505c",
            "08": "\u53ef\u6062\u590d\u4ea4\u6613\u7194\u65ad",
            "09": "\u4e0d\u53ef\u6062\u590d\u4ea4\u6613\u7194\u65ad"
        },
        g = (new Date).getTime(),
        b = {},
        w = {},
        P = new
        function() {
            var B = window.location.host,
            G = "//" + window.location.host + "/api/real.php?_=$rn&list=$symbol",
            E = "//" + window.location.host + "/api/real.php?_=" + g + "&list=$symbol",
            z = function(H) {
                var J, K = "";
                return J = H.cancelEtag ? K + G.replace("$rn", String(Math.random())) : K + (c.isETag() ? E: G.replace("$rn", String(Math.random())))
            };
            return function(H, J, K) {
                K = K || {},
                l(z(K).replace("$symbol", H), J)
            }
        },
        F = function(J) {
            var ac = J.timeStr || "",
            an = J.dateStr || "",
            B = J.tArr || void 0,
            G = J.hqObj || {},
            H = J.dateDiv || "-",
            ao = ac.split(":"),
            K = Number(ao[0]) || 0,
            Z = Number(ao[1]) || 0,
            am = Number(ao[2]) || 0,
            aa = [s.s0(K), s.s0(Z)].join(":"),
            ad = 0 / 0;
            if (B) {
                if (B.indexOf) {
                    ad = B.indexOf(aa)
                } else {
                    for (var E = B.length; E--;) {
                        if (B[E] == aa) {
                            ad = E;
                            break
                        }
                    }
                }
            }
            var z = {
                time: aa,
                isUpdateTime: isNaN(ad) ? !0 : Boolean(ad >= 0),
                index: ad
            },
            ae = an.split(H),
            Q = ~~Number(ae[0]),
            Y = ~~ (Number(ae[1]) - 1),
            X = ~~Number(ae[2]),
            W = {
                isErrData: !1,
                isDateChange: !1,
                date: G.date,
                today: [Q, Y + 1, X].join("-")
            };
            if (G.date) {
                var U = new Date(Q, Y, X, K, Z, am),
                V = e.stbd(G.date, U);
                V ? U >= G.date ? W.date.setHours(K, Z, am) : W.isErrData = !0 : (W.isDateChange = Boolean(U > G.date), W.isDateChange ? W.date = U: W.isErrData = !0)
            } else {
                an ? W.date = new Date(Q, Y, X, K, Z, am) : W.isErrData = !0
            }
            return {
                datePart: W,
                timePart: z
            }
        },
        x = {
            swap: function(E) {
                var H, G = E.split(","),
                B = "";
                G[8] = "TP" == G[8] ? "03": "00",
                H = [0, 4, 3, 7, 5, 6, 26, 46, 10, 11, 36, 26, 37, 27, 38, 28, 39, 29, 40, 30, 56, 46, 57, 47, 58, 48, 59, 49, 60, 50, 2, 1, 8];
                for (var z = 0; z < H.length; z++) {
                    B += G[H[z]] + ","
                }
                return B = B.slice(0, B.length - 1)
            },
            kak: function(B, z) {
                var E;
                switch (z) {
                case "CN_2":
                    E = this.swap(B);
                    break;
                default:
                    E = B
                }
                return E
            }
        },
        A = new
        function() {
            var z;
            this.update = function(J, E) {
                if (!J) {
                    return ! 1
                }
                z || (z = s.gtr([["0:00", "23:59"]]));
                var H = z,
                K = "00:00",
                B = J[11],
                Q = J[0],
                G = F({
                    dateStr: B,
                    timeStr: Q,
                    hqObj: E,
                    tArr: H,
                    start: K
                });
                if (G.datePart.isErrData) {
                    return ! 1
                }
                E.date = G.datePart.date,
                E.today = G.datePart.today,
                E.time = G.timePart.time,
                E.index = G.timePart.index,
                E.isUpdateTime = G.timePart.isUpdateTime,
                E.name = String(J[9]);
                var U = Number(J[3]) || 0;
                return E.prevclose = U,
                E.open = Number(J[5]) || U,
                E.high = Number(J[6]) || U,
                E.low = Number(J[7]) || U,
                E.price = Number(J[8]) || U,
                E.totalVolume = 0,
                !0
            }
        },
        D = new
        function() {
            var B, z;
            this.update = function(H, U) {
                if (!H) {
                    return ! 1
                }
                B || (B = s.gtr([["6:00", "23:59"], ["0:00", "5:59"]]));
                var W = B,
                V = "06:00",
                J = 17,
                Q = U.symbol;
                0 !== Q.indexOf("fx_") && (J = 10, "DINIW" == Q && (z || (z = s.gtr([["6:00", "23:59"], ["0:00", "5:59"]])), W = z, V = "06:00"));
                var K = H[J],
                X = H[0],
                G = F({
                    dateStr: K,
                    timeStr: X,
                    hqObj: U,
                    tArr: W,
                    start: V
                });
                if (G.datePart.isErrData) {
                    return ! 1
                }
                U.date = G.datePart.date,
                U.today = G.datePart.today,
                U.time = G.timePart.time,
                U.index = G.timePart.index,
                U.isUpdateTime = G.timePart.isUpdateTime,
                U.name = String(H[9]);
                var E = Number(H[3]) || 0;
                return U.prevclose = E,
                U.open = Number(H[5]) || E,
                U.high = Number(H[6]) || E,
                U.low = Number(H[7]) || E,
                U.price = Number(H[8]) || E,
                U.totalVolume = 0,
                !0
            }
        },
        O = new
        function() {
            var H, G, B = function(aa, J) {
                if (!aa) {
                    return ! 1
                }
                H || (H = s.gta());
                var K = 100;
                /[gz]/.test(J.type) ? K = 10 : a.isRepos(J.symbol) ? K = 10 : /^(sh000|sh580)\d+/.test(J.symbol) && (K = 1);
                var V = aa[30],
                Q = aa[31],
                ac = F({
                    dateStr: V,
                    timeStr: Q,
                    hqObj: J,
                    tArr: H,
                    start: "09:30"
                });
                if (ac.datePart.isErrData) {
                    return ! 1
                }
                if (J.date = ac.datePart.date, J.isDateChange = ac.datePart.isDateChange, J.today = ac.datePart.today, J.time = ac.timePart.time, J.index = ac.timePart.index, J.isUpdateTime = ac.timePart.isUpdateTime, !ac.timePart.isUpdateTime) {
                    var U = J.time.split(":"),
                    W = Number(U[0]),
                    Z = Number(U[1]);
                    switch (W) {
                    case 11:
                        36 > Z && (J.isUpdateTime = !0, J.index = 119);
                        break;
                    case 15:
                        10 > Z && (J.isUpdateTime = !0, J.index = 240)
                    }
                }
                J.name = String(aa[0]),
                J.isNewListed = Boolean(0 == J.name.indexOf("N"));
                var X = Number(aa[2]) || 0;
                J.prevclose = X,
                J.preopen = Number(aa[1]) || Number(aa[6]) || Number(aa[7]) || X,
                J.open = Number(aa[1]) || X,
                J.price = Number(aa[3]) || X,
                J.high = Number(aa[4]) || X,
                J.low = Number(aa[5]) || X,
                J.buy = Number(aa[6]),
                J.sell = Number(aa[7]);
                var Y = Number(aa[8]) || 0;
                Y /= K,
                J.totalVolume = Y,
                J.totalAmount = Number(aa[9]) || 0;
                var ad = aa[32];
                return J.state = ad,
                J.isStopDay = "02" == ad || "03" == ad,
                J.statusStr = h[ad] || "",
                !0
            },
            z = function(Q, K) {
                var J = Q.split(","); ! J || J.length < 16 || (K.type = String(J[0]).toLowerCase(), K.lastfive = Number(J[6]), K.fc = Number(J[8]), K.issueprice = Number(J[14]), K.status = Number(J[15]))
            },
            E = function(Y, V) {
                G || (G = s.gtr([["9:15", "11:30"], ["13:00", "15:01"]]));
                var J = b[V.symbol] || {},
                K = J.date;
                a.isDate(K) || (K = new Date);
                var X = Y.split("|"),
                U = e.ds(K),
                W = X[1],
                Q = F({
                    dateStr: U,
                    timeStr: W,
                    hqObj: V,
                    tArr: G,
                    start: "09:15"
                });
                return Q.datePart.isErrData ? !1 : Q.datePart.date.getHours() - K.getHours() > 2 ? !1 : (V.date = Q.datePart.date, V.isDateChange = Q.datePart.isDateChange, V.today = Q.datePart.today, V.time = Q.timePart.time, V.index = Q.timePart.index, V.isUpdateTime = Q.timePart.isUpdateTime, V.name = J.name || "", V.isNewListed = Boolean(0 == V.name.indexOf("N")), V.price = Number(X[2]), V.trvolume = 0.01 * (Number(X[3]) || 0), V.tramount = Number(X[4]) || 0, V.trbs = Number(X[7]) || 0, !0)
            };
            this.trHandler = function(J, K) {
                return E(J, K)
            },
            this.update = function(Q, K, U) {
                var J = !0;
                return U && z(U, K),
                Q && (J = B(Q, K)),
                J
            }
        },
        T = new
        function() {
            var z;
            this.update = function(H, K) {
                if (!H) {
                    return ! 1
                }
                z || (z = s.gata(r(K.symbol), window["kke_future_" + K.symbol] && window["kke_future_" + K.symbol].time || [["09:30", "11:29"], ["13:00", "02:59"]]));
                var J = H[36],
                E = H[37],
                B = F({
                    dateStr: J,
                    timeStr: E,
                    hqObj: K,
                    tArr: z,
                    start: z[0]
                });
                if (B.datePart.isErrData) {
                    return ! 1
                }
                K.name = H[49] || K.symbol.replace("CFF_RE_", ""),
                K.date = B.datePart.date,
                K.isDateChange = B.datePart.isDateChange,
                K.today = B.datePart.today,
                K.time = B.timePart.time,
                K.index = B.timePart.index,
                K.isUpdateTime = B.timePart.isUpdateTime;
                var G = Number(H[14]) || Number(H[13]) || 0;
                return K.settlement = K.prevclose = G,
                K.open = Number(H[0]) || G,
                K.price = Number(H[3]) || G,
                K.high = Number(H[1]) || G,
                K.low = Number(H[2]) || G,
                K.preopen = K.open,
                K.totalVolume = Number(H[4]) || 0,
                K.totalAmount = Number(H[5]) || 0,
                K.holdingAmount = Number(H[6]) || 0,
                K.preHoldingAmount = Number(H[15]) || 0,
                K.iscff = 1,
                K.withNight = !1,
                !0
            }
        },
        N = new
        function() {
            var H, E = function(ao) {
                if (!ao || ao.length < 9) {
                    return null
                }
                for (var Q, W = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], Z = ao.split(" "), ae = new Date, X = ae.getFullYear(), aa = 0, U = W.length; U > aa; aa++) {
                    if (String(Z[0]).toUpperCase() == String(W[aa]).toUpperCase()) {
                        Q = aa;
                        break
                    }
                }
                var ac = parseInt(Number(Z[1])),
                am = String(Z[2]),
                K = am.toUpperCase().indexOf("PM") > 0,
                an = am.split(":"),
                ap = parseInt(Number(an[0]));
                K && 12 != ap && (ap += 12);
                var Y = an[1],
                V = Y.slice(0, -2),
                J = [a.strUtil.zp(ap), a.strUtil.zp(V), "00"].join(":"),
                ad = new Date(X, Q, ac);
                if ( + ad > +ae) {
                    if (! (0 == ae.getMonth() && ae.getDate() < 7)) {
                        return null
                    }
                    X--,
                    ad = new Date(X, Q, ac)
                }
                var al = [ad.getFullYear(), a.strUtil.zp(ad.getMonth() + 1), a.strUtil.zp(ad.getDate())].join("-");
                return [J, al]
            },
            B = function(Q, K) {
                if (Q && K) {
                    var J = Q.split(","); ! J || J.length < 3 || (K.exchange = J[0], K.industry = J[1], K.issueprice = J[2])
                }
            },
            z = function(U, J, K) {
                function Q(aa) {
                    return 0 === parseInt(aa[2]) && 0 === parseInt(aa[4]) && 0 === parseInt(aa[5]) && 0 === parseInt(aa[6]) && 0 === parseInt(aa[7]) && 0 === parseInt(aa[10])
                }
                if (!U || U.length < 28) {
                    return ! 1
                }
                H || (H = s.gtus());
                var Z, V = !1;
                K ? (Z = K.split(","), V = Q(Z)) : V = Q(U);
                var W;
                if (J.prevclose = Number(U[26]) || 0, V) {
                    J.high = J.prevclose,
                    J.open = J.prevclose,
                    J.low = J.prevclose;
                    var Y = new Date((window.hq_str_sys_time ? new Date(1000 * window.hq_str_sys_time) : new Date) - 43200000);
                    W = ["09:10", Y.getFullYear() + "-" + (Y.getMonth() + 1) + "-" + Y.getDate()]
                } else {
                    J.open = Number(U[5]) || J.prevclose,
                    J.high = Number(U[6]) || J.prevclose,
                    J.low = Number(U[7]) || J.prevclose,
                    W = E(String(Z ? Z[25] : U[25]))
                }
                if (J.name = U[0], J.price = Number(U[1]) || J.open, J.preopen = J.open, J.totalVolume = Number(U[10]) || 0, J.prevclose <= 0 && (J.prevclose = J.price), J.isUnlisted = 0 == J.price && 0 == Number(U[8]) && 0 == Number(U[9]), W) {
                    var X = F({
                        dateStr: W[1],
                        timeStr: W[0],
                        hqObj: J,
                        tArr: H
                    });
                    J.date = X.datePart.date,
                    J.isDateChange = X.datePart.isDateChange,
                    J.today = X.datePart.today,
                    J.time = X.timePart.time,
                    J.index = X.timePart.index,
                    J.isUpdateTime = X.timePart.isUpdateTime,
                    G = !0
                }
                return ! 0
            },
            G = !1;
            this.update = function(U, Q, V, K) {
                var J;
                return V && B(V, Q),
                U && (J = z(U, Q, K)),
                J
            }
        },
        f = new
        function() {
            var z;
            this.update = function(E, B) {
                if (!E) {
                    return ! 1
                }
                z || (z = s.gthk());
                var H = E[7],
                J = E[1],
                G = F({
                    dateStr: H,
                    dateDiv: "-",
                    timeStr: J,
                    hqObj: B,
                    tArr: z,
                    start: "09:30"
                });
                return B.date = G.datePart.date,
                B.isDateChange = G.datePart.isDateChange,
                B.today = G.datePart.today,
                B.time = G.timePart.time,
                B.index = G.timePart.index,
                B.isUpdateTime = G.timePart.isUpdateTime,
                B.name = String(E[0]),
                B.volume = 0,
                B.price = Number(E[2]),
                B.prevprice = B.prevclose = Number(E[3]),
                !0
            }
        },
        p = new
        function() {
            this.update = function(K, E) {
                if (!K) {
                    return ! 1
                }
                var H = window["kke_future_" + E.symbol] && window["kke_future_" + E.symbol].time || [["09:30", "11:29"], ["13:00", "02:59"]],
                Q = s.gata(r(E.symbol), H),
                z = K[1],
                G = K[17],
                J = z.slice(0, 2) + ":" + z.slice(2, 4),
                U = F({
                    dateStr: G,
                    dateDiv: "-",
                    timeStr: J,
                    hqObj: E,
                    tArr: Q,
                    start: Q[0]
                });
                E.date = U.datePart.date,
                E.isDateChange = U.datePart.isDateChange,
                E.today = U.datePart.today,
                E.time = U.timePart.time,
                E.index = U.timePart.index,
                E.isUpdateTime = U.timePart.isUpdateTime,
                Q[0] > "15:00" && ("00:00" == H[1][0] ? J > H[1][1] && "09:00" > J && (E.index = Q.indexOf(H[1][1])) : J > H[0][1] && "09:00" > J && (E.index = Q.indexOf(H[0][1]))),
                E.name = String(K[0]);
                var B = Number(K[10]) || 0;
                return E.prevclose = B,
                E.open = Number(K[2]) || B,
                E.preopen = E.open || E.price,
                E.high = Number(K[3]) || B,
                E.low = Number(K[4]) || B,
                E.close = Number(K[5]) || B,
                E.buy = Number(K[6]),
                E.sell = Number(K[7]),
                E.price = Number(K[8]) || B,
                E.activeprevclose = Number(K[9]),
                E.buyAmount = Number(K[11]),
                E.sellAmount = Number(K[12]),
                E.holdingAmount = Number(K[13]),
                E.totalVolume = Number(K[14]) || 0,
                E.exchange = K[15],
                E.futuresType = K[16],
                E.isHot = Number(K[18]),
                E.day5Highest = Number(K[19]),
                E.day5Lowest = Number(K[20]),
                E.day10Highest = Number(K[21]),
                E.day10Lowest = Number(K[22]),
                E.day20Highest = Number(K[23]),
                E.day20Lowest = Number(K[24]),
                E.day55Highest = Number(K[25]),
                E.day55Lowest = Number(K[26]),
                E.weighted = Number(K[27]),
                E.withNight = Q[0] > "15:00",
                !0
            }
        },
        j = new
        function() {
            var B, z = function(K, V) {
                if (!K) {
                    return ! 1
                }
                B || (B = s.gthk());
                var J = K[17],
                Q = K[18],
                W = K[24],
                U = F({
                    dateStr: J,
                    dateDiv: "/",
                    timeStr: Q,
                    hqObj: V,
                    tArr: B,
                    start: "09:30"
                });
                V.date = U.datePart.date || new Date,
                V.isDateChange = U.datePart.isDateChange,
                V.today = U.datePart.today;
                var H = !1; (!V.time || U.timePart.time > "09:29" && V.time < U.timePart.time) && (H = !0),
                V.time = U.timePart.time,
                V.index = U.timePart.index,
                V.isUpdateTime = U.timePart.isUpdateTime,
                H && (V.isUpdateTime = !0),
                V.name = V.cnName || String(K[1]);
                var G = Number(K[3]) || 0;
                return V.prevclose = G,
                V.open = "Y" == W ? Number(K[2]) || G: G,
                V.preopen = Number(K[2]) || Number(K[9]) || Number(K[10]) || G,
                V.price = Number(K[6]) || G,
                V.high = Number(K[4]) || G,
                V.low = Number(K[5]) || G,
                V.totalVolume = Number(K[12]) || 1000 * Number(K[11]) || 0,
                V.totalAmount = Number(K[11]) || 0,
                !0
            },
            E = function(J, H) {
                var G = J.split(","); ! G || G.length < 15 || (H.type = String(G[0]).toLowerCase(), H.lastfive = 0, H.status = Number(G[14]), H.issueprice = Number(G[16]), H.cnName = G[19])
            };
            this.update = function(K, J, H) {
                var G = !0;
                return H && E(H, J),
                K && (G = z(K, J)),
                G
            }
        },
        q = new
        function() {
            this.update = function(H, B) {
                if (!H) {
                    return ! 1
                }
                var J = s.gata(r(B.symbol), window["kke_global_index_" + B.symbol] && window["kke_global_index_" + B.symbol].time || [["06:00", "23:59"], ["00:00", "05:00"]]),
                U = J,
                V = J[0],
                G = 6,
                K = H[G],
                Q = H[7],
                z = F({
                    dateStr: K,
                    timeStr: Q,
                    tArr: U,
                    start: V,
                    hqObj: B
                });
                if (z.datePart.isErrData) {
                    return ! 1
                }
                B.date = z.datePart.date,
                B.today = z.datePart.today,
                B.time = z.timePart.time,
                B.index = z.timePart.index,
                B.isUpdateTime = z.timePart.isUpdateTime,
                B.name = String(H[0]);
                var E = Number(H[9]) || 0;
                return B.prevclose = E,
                B.open = Number(H[8]) || E,
                B.price = Number(H[1]) || E,
                B.high = Number(H[10]) || E,
                B.low = Number(H[11]) || E,
                B.buy = Number(H[9]),
                B.sell = Number(H[9]),
                B.totalVolume = Number(H[12]) || 0,
                B.holdingAmount = 0,
                !0
            }
        },
        I = new
        function() {
            this.update = function(H, B) {
                if (!H) {
                    return ! 1
                }
                var J = s.gata(r(B.symbol), window["kke_future_" + B.symbol] && window["kke_future_" + B.symbol].time || [["06:00", "23:59"], ["00:00", "05:00"]]),
                U = J,
                V = J[0],
                G = 12,
                K = H[G],
                Q = H[6],
                z = F({
                    dateStr: K,
                    timeStr: Q,
                    tArr: U,
                    start: V,
                    hqObj: B
                });
                if (z.datePart.isErrData) {
                    return ! 1
                }
                B.date = z.datePart.date,
                B.today = z.datePart.today,
                B.time = z.timePart.time,
                B.index = z.timePart.index,
                B.isUpdateTime = z.timePart.isUpdateTime,
                B.name = String(H[13]);
                var E = Number(H[7]) || 0;
                return B.prevclose = E,
                B.open = Number(H[8]) || E,
                B.price = Number(H[0]) || E,
                B.high = Number(H[4]) || E,
                B.low = Number(H[5]) || E,
                B.buy = Number(H[2]),
                B.sell = Number(H[3]),
                B.buyAmount = Number(H[10]),
                B.sellAmount = Number(H[11]),
                B.holdingAmount = Number(H[9]),
                !0
            }
        },
        L = new
        function() {
            var z;
            this.update = function(J, E) {
                if (!J) {
                    return ! 1
                }
                z || (z = s.gta());
                var H = J[32],
                K = H.split(" "),
                B = K[0],
                Q = K[1],
                G = F({
                    dateStr: B,
                    timeStr: Q,
                    hqObj: E,
                    tArr: z,
                    start: "09:30"
                });
                if (G.datePart.isErrData) {
                    return ! 1
                }
                E.date = G.datePart.date,
                E.isDateChange = G.datePart.isDateChange,
                E.today = G.datePart.today,
                E.time = G.timePart.time,
                E.index = G.timePart.index,
                E.isUpdateTime = G.timePart.isUpdateTime,
                E.name = String(J[37]),
                E.isNewListed = Boolean(0 == E.name.indexOf("N"));
                var U = Number(J[8]) || 0;
                return E.prevclose = U,
                E.preopen = Number(J[9]) || U,
                E.open = Number(J[9]) || U,
                E.price = Number(J[2]) || U,
                E.high = Number(J[39]) || U,
                E.low = Number(J[40]) || U,
                E.position = Number(J[5]) || 0,
                E.totalVolume = Number(J[41]) || 0,
                E.totalAmount = Number(J[42]) || 0,
                !0
            }
        },
        C = new
        function() {
            var z;
            this.update = function(B, G) {
                if (!B) {
                    return ! 1
                }
                z || (z = s.gta());
                var Q = B[30],
                V = B[31],
                U = F({
                    dateStr: Q,
                    timeStr: V,
                    hqObj: G,
                    tArr: z,
                    start: "09:30"
                });
                if (U.datePart.isErrData) {
                    return ! 1
                }
                if (G.date = U.datePart.date, G.isDateChange = U.datePart.isDateChange, G.today = U.datePart.today, G.time = U.timePart.time, G.index = U.timePart.index, G.isUpdateTime = U.timePart.isUpdateTime, !U.timePart.isUpdateTime) {
                    var H = G.time.split(":"),
                    K = Number(H[0]),
                    J = Number(H[1]);
                    switch (K) {
                    case 11:
                        59 > J && (G.isUpdateTime = !0);
                        break;
                    case 15:
                        31 > J && (G.isUpdateTime = !0)
                    }
                }
                G.name = String(B[0]),
                G.isNewListed = Boolean(0 == G.name.indexOf("N"));
                var W = Number(B[2]) || 0;
                G.prevclose = W,
                G.preopen = Number(B[1]) || Number(B[6]) || Number(B[7]) || W,
                G.open = Number(B[1]) || W,
                G.price = Number(B[3]) || W,
                G.high = Number(B[4]) || W,
                G.low = Number(B[5]) || W,
                G.buy = Number(B[6]),
                G.sell = Number(B[7]),
                G.totalVolume = Number(B[8]) / 1000 || 0,
                G.totalAmount = Number(B[9]) || 0;
                var E = B[32];
                return G.state = E,
                G.isStopDay = "02" == E || "03" == E,
                G.statusStr = h[E] || "",
                !0
            }
        },
        M = [],
        m = "",
        v = "",
        y = function(B) {
            for (var z = M.length; z--;) {
                M[z](B),
                M[z] = null,
                M.length--
            }
        };
        this.get = function(H, Y) {
            var X, Q = H.symbol,
            U = H.withI,
            G = Q,
            B = 0;
            if (U) {
                for (var J, W = Q.split(","), V = W.length; V > B; B++) {
                    J = W[B];
                    var E;
                    E = "HK" == r(J) ? J.replace("rt_", "") + "_i": J + "_i",
                    G += "," + E
                }
            }
            var z, K;
            if (H.delay) {
                m += Q + ",",
                v += G + ",",
                M.push(Y),
                clearTimeout(ab),
                ab = setTimeout(function() {
                    for (v = v.substring(0, v.length - 1), m = m.substring(0, m.length - 1), X = S(v), K = X.length, z = {
                        count: K
                    },
                    B = 0; K > B; B++) {
                        P(X[B].join(","), n(d, null, m, y, null, z), H)
                    }
                    m = "",
                    v = ""
                },
                100)
            } else {
                for (X = S(G), K = X.length, z = {
                    count: K
                },
                B = 0; K > B; B++) {
                    P(X[B].join(","), n(d, null, Q, Y, null, z), H)
                }
            }
        },
        this.parse = function(B, E) {
            var H, G = B.symbol;
            switch (B.market) {
            case "CN_TR":
                H = k(G, null, B.hqStr);
                break;
            default:
                var z = x.kak(B.hqStr, B.market);
                H = d(G, null, z, null)
            }
            a.isFunc(E) && E(H)
        }
    };
    return i
});
xh5_define("utils.painter", ["utils.util", "cfgs.settinger"],
function(t, e) {
    function n() {
        function g(p) {
            function k(w) {
                j = w.hd || j;
                var v = w.width || q.width || 0,
                y = w.height || q.height || 0,
                x = j;
                switch (q.style.width = v + "px", q.style.height = y + "px", x) {
                case 0:
                    break;
                case 1:
                    x = o.hdpr,
                    v *= x,
                    y *= x;
                    break;
                default:
                    v *= x,
                    y *= x
                }
                q.height = q.width = 0,
                q.height = y,
                q.width = v,
                x && 1 != x && m.scale(x, x)
            }
            this.VER = "2.0.1";
            var q = i("canvas");
            "undefined" != typeof FlashCanvas && FlashCanvas.initElement(q);
            var m = q.getContext("2d"),
            j = 1;
            p && k(p),
            this.canvas = q,
            this.g = m,
            this.resize = k
        }
        function d(A) {
            var v, C, j, ab, x, ac, m, p, N, q = A.parentObj,
            ad = A.ctn,
            y = q.sd,
            ai = q.setting,
            k = 0,
            af = ai.DIMENSION.H_TIME_PART,
            ag = q.nu,
            ae = q.fixScale,
            aj = 99999,
            ah = function() {
                v = new g,
                C = v.canvas,
                j = v.g,
                C.style.position = "absolute",
                C.style.zIndex = 0,
                r.addHandler(C, "touchstart",
                function(z) {
                    ai.custom.touch_prevent && r.preventDefault(z)
                }),
                ad.appendChild(C)
            },
            ak = function(z) {
                z = z || {},
                ab = ai.DIMENSION.getStageW(),
                k = isNaN(z.mh) ? k: z.mh,
                x = ai.DIMENSION.posX,
                ac = ai.DIMENSION.RIGHT_W,
                m = ai.DIMENSION.K_RIGHT_W,
                p = isNaN(z.h) ? p: z.h,
                af = isNaN(z.eh) ? af: z.eh,
                v.resize({
                    width: ab,
                    height: p + af + k,
                    hd: ai.PARAM.getHd()
                }),
                j.font = ai.STYLE.FONT_SIZE + "px " + ai.STYLE.FONT_FAMILY
            },
            T = function(E, D, B, z) {
                E = ~~ (E + 0.5),
                E -= 0.5,
                D = ~~ (D + 0.5),
                D -= 0.5,
                B = ~~ (B + 0.5),
                B -= 0.5,
                j.beginPath(),
                z ? (j.moveTo(E, B), j.lineTo(D, B)) : (j.moveTo(B, E), j.lineTo(B, D)),
                j.stroke()
            },
            w = function(z, D) {
                var B;
                return ae ? B = isNaN(D) ? 0 > z ? Math.floor(z) : Math.ceil(z) : z.toFixed(D) : (z = (10000 * z).toFixed(0), B = z / 10000, B > aj && (B = Math.floor(B))),
                B
            },
            S = new
            function() {
                var J, D, Q, z, U, O = 4,
                G = y.futureTime || window["kke_future_" + y.symbol],
                P = function() {
                    if (! (y.business || !isNaN(ai.custom.mini_threshold.height) && p < ai.custom.mini_threshold.height)) {
                        var aG = ai.DIMENSION.extend_draw,
                        V = x;
                        aG ? (j.textAlign = "left", j.textBaseline = "top") : j.textAlign = "right",
                        j.fillStyle = ai.COLOR.T_N,
                        j.strokeStyle = ai.COLOR.GRID,
                        ai.DIMENSION.getStageH() < 0 && "TFLOW" == y.name && (y.labelPriceCount = 4),
                        !y.isSC && ai.DIMENSION.h_t < 150 && (y.labelPriceCount = 2);
                        for (var aL, W, aa, ax, aK, ay = y.labelMaxP,
                        X = ag ? t.strUtil.nu(ay) : null, aH = y.labelMinP, az = y.labelPriceCount, aN = ai.DIMENSION.posX, aI = ay - aH, aQ = p / az, Z = 0; az >= Z; Z++) {
                            aK = Z * aQ + k,
                            j.fillStyle = ai.COLOR.T_N,
                            aa = ay - Z * aI / az,
                            aa > 0 ? j.fillStyle = ai.COLOR.T_RISE: 0 > aa && (j.fillStyle = ai.COLOR.T_FALL),
                            aG ? Z == az && (j.textBaseline = "bottom") : j.textBaseline = 0 == Z ? "top": Z == az ? "bottom": "middle";
                            var Y;
                            if (y.isCompare) {
                                if (y.dAdd <= 1) {
                                    aa *= 100,
                                    ax = aa.toFixed(2),
                                    ax += "%",
                                    j.fillText(ax, aN, aK),
                                    j.fillText(ax, aN + ai.DIMENSION.w_t + j.measureText(ax).width, aK)
                                } else {
                                    Y = y.datas[0][0].prevclose;
                                    var aM, aO = aa;
                                    aO *= 100,
                                    aM = aO.toFixed(2),
                                    aM += "%",
                                    aG ? j.fillText(aM, ai.DIMENSION.w_t - j.measureText(aM).width, aK) : j.fillText(aM, aN + ai.DIMENSION.w_t + j.measureText(aM).width, aK),
                                    aa = aa * Y + Y,
                                    ax = aa.toFixed(2),
                                    j.fillText(ax, aN, aK)
                                }
                                T(V, ab - ac, aK, !0)
                            } else {
                                if (y.isSC) {
                                    if (j.fillStyle = ai.COLOR.K_P, ag) {
                                        var aw = y.name && "TFLOW" == y.name ? 2 : 0;
                                        aa /= X[0],
                                        0 == Z || Z == az ? (ax = Z >= az ? X[1] : w(aa, aw), ("NaN" == ax || "" == ax) && (ax = 0)) : ax = ""
                                    } else {
                                        ax = 0 == Z || Z == az ? aa.toFixed(1 > aH ? 4 : 2) : 0,
                                        0 == ax && 0 != Z && Z != az && (ax = "")
                                    }
                                } else {
                                    if (ai.DIMENSION.h_t < 0) {
                                        return
                                    }
                                    Y = y.datas[0][0].prevclose;
                                    var aP = "HK" == y.market ? 3 : 4,
                                    aJ = 1 > aH ? aP: y.nfloat || 2;
                                    "HF" == t.market(y.symbol) && (3 > aH ? aJ = 4 : 99 > aH && (aJ = 3)),
                                    ax = Math.abs(aa) > aj ? Math.floor(aa) : aa.toFixed(aJ),
                                    aL = 100 * (aa - Y) / Y,
                                    j.fillStyle = aL > 0 ? ai.COLOR.T_RISE: 0 > aL ? ai.COLOR.T_FALL: ai.COLOR.T_N,
                                    W = isNaN(aL) ? "--%": aL.toFixed(2) + "%",
                                    aG ? j.fillText(W, aN + ai.DIMENSION.w_t - j.measureText(W).width, aK) : j.fillText(W, aN + ai.DIMENSION.w_t + j.measureText(W).width, aK)
                                }
                                j.fillText(ax, aN, aK),
                                T(V, ab - ac, aK, !0)
                            }
                        }
                    }
                },
                E = function(Y, W) {
                    var V = y && t.market(y.symbol),
                    X = ai.DIMENSION.w_t;
                    "HK" == V && 415 > X && !W || T(k, p + k, Y, !1)
                },
                K = function(am, X, an, Z, aa) {
                    if (J = am, q.dt) {
                        var W = j.measureText(X).width,
                        V = 0;
                        if (V = 0 == an ? 0 : an == Z - 1 ? -W: -W / 2, 0 == Z && (V = aa / 2 - W / 2), y.business) {
                            j.font = "14px " + ai.STYLE.FONT_FAMILY;
                            var Y = 10; (0 == an || an == Z - 1) && j.fillText(X, am + V, k + p + ai.STYLE.FONT_SIZE + 2 + Y)
                        } else {
                            j.fillText(X, am + V, k + p + ai.STYLE.FONT_SIZE + 2)
                        }
                    }
                },
                F = function(W) {
                    var V = W.replace("nf_", "").replace(/[\d]+$/, "");
                    return "TF" == V || "T" == V ? "CFF": "NF"
                },
                R = 30,
                I = "ignore",
                H = "ignoreT",
                L = function() {
                    var aq, ar = y && t.market(y.symbol);
                    switch (ar) {
                    case "US":
                        O = 7;
                        break;
                    case "HK":
                        O = 5;
                        break;
                    case "NF":
                    case "HF":
                        O = 0;
                        break;
                    default:
                        O = 4
                    }
                    if (!D) {
                        switch (ar) {
                        case "HF":
                            D = t.tUtil.gata(ar, G && G.time || [["06:00", "23:59"], ["00:00", "05:00"]]);
                            break;
                        case "NF":
                            D = t.tUtil.gata(ar, G && G.time || [["09:00", "23:29"], ["13:00", "02:59"]]);
                            break;
                        case "global_index":
                            D = t.tUtil.gata(ar, G && G.time || [["06:00", "23:59"], ["00:00", "05:00"]]);
                            break;
                        default:
                            D = t.tUtil.gata(ar)
                        }
                        for ("CFF" == F(y.symbol) && (R = 15), Q = [], aq = 0; aq < D.length; aq += R) {
                            Q.push(D[aq])
                        }
                        var Y = D[D.length - 1].split(":")[1];
                        "00" != Y && "30" != Y && Q.push(D[D.length - 1])
                    }
                    z = [],
                    U = [];
                    var V = ai.DIMENSION.w_t,
                    av = 370,
                    Z = 70,
                    W = 35,
                    X = V / Q.length,
                    aa = 0,
                    au = 0;
                    if (q.dt && "HK" == ar) {
                        var aw = y.hq.time;
                        q.dt && aw > "15:59" && (aw > "16:09" && (aw = "16:09"), Q[Q.length - 1] = aw),
                        av = 415
                    }
                    for (aq = 0; aq < Q.length; aq++) {
                        0 == aq || aq == Q.length - 1 ? (z.push(Q[aq]), U.push(H)) : aq == O ? (z.push(Q[aq]), U.push(Q[aq])) : av > V ? z.push(I) : aq > 0 && O > aq ? X * (aq - aa) > Z && X * (O - aq) > Z ? (z.push(Q[aq]), aa = aq) : z.push(I) : (O > aa && (aa = O), X * (aq - aa) > Z && X * (Q.length - 1 - aq) > Z ? (z.push(Q[aq]), aa = aq) : z.push(I)),
                        0 != aq && aq != O && aq != Q.length - 1 && (aq > 0 && O > aq ? X * (aq - au) > W && X * (O - aq) > W ? (U.push(Q[aq]), au = aq) : U.push(H) : (O > au && (au = O), X * (aq - au) > W && X * (Q.length - 1 - aq) > W ? (U.push(Q[aq]), au = aq) : U.push(H)))
                    }
                    switch (ar) {
                    case "NF":
                        G && ("21:00" != G.time[0][0] ? O = 15 == R ? ai.DIMENSION._w <= 550 ? 9 : 0 : 4 : av > V && (O = Math.floor(U.length / 2))),
                        z[z.length - 1] = 30 == R ? "15:00": "15:15";
                        var at = Q[O].split(":");
                        59 == at[1] && (Q[O] = Number(at[0]) + 1 + ":00"),
                        z[O] = Q[O];
                        break;
                    case "HF":
                        av > V && (O = Math.floor(U.length / 2)),
                        z[O] = Q[O]
                    }
                },
                B = function() {
                    var W = ai.DIMENSION.w_t;
                    if (isNaN(ai.custom.mini_threshold.width) || !(W < ai.custom.mini_threshold.width)) {
                        j.textBaseline = "bottom",
                        j.textAlign = "left",
                        j.strokeStyle = ai.COLOR.TIME_L,
                        j.fillStyle = ai.COLOR.TIME_S,
                        J = x;
                        var X = y.datas,
                        Y = X.length,
                        ao = y && t.market(y.symbol),
                        ap = Q.length,
                        V = 1;
                        "NF" == ao && "CFF" == F(y.symbol) && (V = 1);
                        var aa = W / Math.max(ap - V, 5),
                        Z = x,
                        ar = 550;
                        if (ai.DIMENSION.getStageH() < 0 && (q.dt = !0), q.dt) {
                            var aq;
                            if (1 == Y || Y > 6) {
                                for (aq = 0; ap > aq; aq++) {
                                    z[aq] !== I && K(Z, z[aq], aq, ap),
                                    "HF" == ao || "NF" == ao ? z[aq] !== I && U[aq] !== H && (aq == O ? E(Z, O) : E(Z)) : y.business || U[aq] !== H && (aq == O ? E(Z, O) : E(Z)),
                                    Z += aa
                                }
                            } else {
                                if (6 > Y) {
                                    for (aa = W / Y, aq = 0; Y > aq; aq++) {
                                        ai.DIMENSION._w < ar ? K(Z, c.ds(X[aq][0].date, "/", !1, !0, !1, !1), aq, 0, aa) : K(Z, c.ds(X[aq][0].date, "/") + "/" + c.nw(X[aq][0].date.getDay()), aq, 0, aa),
                                        0 != aq && E(Z),
                                        Z += aa
                                    }
                                }
                            }
                        }
                    }
                };
                this.drawFrames = function() {
                    ak(),
                    L(),
                    B(),
                    P()
                }
            },
            M = new
            function() {
                this.iOffsetX = 0;
                var J, z, O, I, B, G = this,
                D = 0,
                E = 22,
                K = 99,
                F = function(U, Y, W) {
                    if (isNaN(W)) {
                        if (D + K >= U || U >= ab - K) {
                            return
                        }
                        T(k + 1, p + k, U, !1)
                    }
                    if (D = U, q.dt) {
                        var V, X = p + k + ai.STYLE.FONT_SIZE + 3;
                        switch (W) {
                        case 1:
                            j.fillText(Y, U, X);
                            break;
                        case 2:
                            V = j.measureText(Y).width,
                            j.fillText(Y, U - V, X);
                            break;
                        case 3:
                            break;
                        default:
                            V = j.measureText(Y).width,
                            j.fillText(Y, U - (V >> 1), X)
                        }
                    }
                },
                R = function() {
                    var ay = ai.DIMENSION.w_k;
                    if (isNaN(ai.custom.mini_threshold.width) || !(ay < ai.custom.mini_threshold.width)) {
                        j.textBaseline = "bottom",
                        j.textAlign = "left",
                        j.strokeStyle = ai.COLOR.TIME_L,
                        j.fillStyle = ai.COLOR.TIME_S,
                        D = x;
                        var aP, aN = y.datas,
                        aS = aN.length;
                        switch (N) {
                        case h.URLHASH.KMS:
                            aP = "sec";
                            break;
                        case h.URLHASH.K1:
                            aP = "h";
                            break;
                        case h.URLHASH.K5:
                        case h.URLHASH.K15:
                        case h.URLHASH.K30:
                        case h.URLHASH.K60:
                        case h.URLHASH.K240:
                            aP = 60 / N * 24 > aS ? "h": "d";
                            break;
                        case h.URLHASH.KD:
                        case h.URLHASH.KDF:
                        case h.URLHASH.KDB:
                        case h.URLHASH.KCL:
                        case h.URLHASH.KCLF:
                        case h.URLHASH.KCLB:
                            aP = aS > 300 ? "y": 28 > aS ? "w": "m";
                            break;
                        default:
                            aP = aS > 300 ? "y": "m"
                        }
                        for (var W, aa, Z, aJ, aL, Y, aQ = ay / Math.max(aS, ai.PARAM.minCandleNum), aI = G.iOffsetX + x + 0.6 * aQ, U = ay / K, V = ay / (aQ * E), X = Math.ceil(V / U), aO = 0, aU = 0, aV = -1, aW = -1, al = -1, aX = -1, aT = -1, aR = 0; aS > aR; aR++) {
                            if (Y = aN[aR], aL = Y.date, aa = aL.getMonth(), W = aL.getFullYear(), 0 != aR) {
                                if (aR >= aS - 1) {
                                    F(aI + aQ / 2, W + "/" + (aa + 1) + "/" + aL.getDate(), aS >= ai.PARAM.minCandleNum ? 2 : 3)
                                } else {
                                    switch (aP) {
                                    case "sec":
                                        var aK = aL.getSeconds();
                                        aK != aX && (aK = t.strUtil.zp(aK), aJ = t.strUtil.zp(aL.getMinutes()), Z = t.strUtil.zp(aL.getHours()), F(aI, Z + ":" + aJ + ":" + aK)),
                                        aX = Number(aK);
                                        break;
                                    case "min":
                                        aJ = aL.getMinutes(),
                                        aJ != al && (aJ = t.strUtil.zp(aJ), Z = t.strUtil.zp(aL.getHours()), F(aI, Z + ":" + aJ)),
                                        al = Number(aJ);
                                        break;
                                    case "h":
                                        Z = aL.getHours(),
                                        Z != aW && (aJ = t.strUtil.zp(aL.getMinutes()), F(aI, Z + ":" + aJ)),
                                        aW = Z;
                                        break;
                                    case "d":
                                        var az = aL.getDate();
                                        az != aO && F(aI, W + "/" + (aa + 1) + "/" + az),
                                        aO = az;
                                        break;
                                    case "w":
                                        var aM = aL.getDay();
                                        aT > aM && F(aI, aa + 1 + "/" + aL.getDate()),
                                        aT = aM;
                                        break;
                                    default:
                                    case "m":
                                        aa == aV || aa % X || F(aI, W + "/" + (aa + 1)),
                                        aV = aa;
                                        break;
                                    case "y":
                                        W != aU && F(aI, W),
                                        aU = W
                                    }
                                    aI += aQ
                                }
                            } else {
                                F(x, W + "/" + (aa + 1) + "/" + aL.getDate(), 1)
                            }
                        }
                    }
                },
                P = 37,
                Q = function() {
                    j.fillStyle = ai.COLOR.K_PCT,
                    j.textBaseline = "top",
                    j.textAlign = "right";
                    for (var V, al, aq = y.nfloat || 2,
                    X = y.prevclose,
                    ar = y.labelPriceCount,
                    U = 0,
                    Z = p / ar,
                    aa = y.labelMaxP,
                    W = y.labelMinP,
                    ap = aa - W; ar >= U; U++) {
                        if (! (P > Z && 1 & U)) {
                            al = U * Z + k,
                            0 == U && al++,
                            V = aa - U * ap / ar,
                            U == ar && (j.textBaseline = "bottom");
                            var Y;
                            N === h.URLHASH.KMS || N === h.URLHASH.K1 ? (Y = ((V - X) / X * 100).toFixed(aq) + "%", j.fillStyle = V > X ? ai.COLOR.K_MS_RISE: X > V ? ai.COLOR.K_MS_FALL: ai.COLOR.K_MS_N) : Y = Math.round((V - X) / X * 100) + "%",
                            j.fillText(Y, ab - m, al)
                        }
                    }
                },
                H = function() {
                    var U;
                    switch (ai.custom.k_0pct) {
                    case "hq":
                        U = y.hq.prevclose;
                        break;
                    case "range":
                        U = y.prevclose;
                        break;
                    default:
                        return
                    }
                    var W = t.xh5_PosUtil.pp(U, y.labelMinP, y.labelMaxP, p) + k;
                    W = ~~ (W + 0.5),
                    W -= 0.5;
                    var V = x,
                    X = 5;
                    for (j.beginPath(); ab - m > V;) {
                        j.moveTo(V, W),
                        V += X,
                        j.lineTo(V, W),
                        V += X
                    }
                    j.strokeStyle = ai.COLOR.T_PREV,
                    j.stroke()
                },
                L = function() {
                    if (isNaN(ai.custom.mini_threshold.height) || !(p < ai.custom.mini_threshold.height)) {
                        var aa = ai.DIMENSION.extend_draw;
                        j.fillStyle = ai.COLOR.K_P,
                        j.strokeStyle = ai.COLOR.GRID;
                        var au = x;
                        aa ? (j.textAlign = "left", j.textBaseline = "top") : j.textAlign = "right";
                        for (var aw, ay, Y, Z = y.labelPriceCount,
                        U = 0,
                        av = ai.DIMENSION.posX,
                        V = p / Z,
                        al = y.labelMaxP,
                        X = y.labelMinP,
                        ax = al - X,
                        W = y.prevclose,
                        at = ag ? t.strUtil.nu(al) : null; Z >= U; U++) {
                            P > V && 1 & U || (ay = U * V + k, 0 == U && ay++, aw = al - U * ax / Z, y.isCompare && (aw *= 100), ag ? (aw /= at[0], Y = U >= Z ? at[1] : w(aw)) : Y = w(aw), y.isCompare && (Y += "%"), aa ? U == Z && (j.textBaseline = "bottom") : j.textBaseline = 0 == U ? "top": U == Z ? "bottom": "middle", N === h.URLHASH.KMS && W && (j.fillStyle = aw > W ? ai.COLOR.K_MS_RISE: W > aw ? ai.COLOR.K_MS_FALL: ai.COLOR.K_MS_N), j.fillText(Y, av, ay), T(au, ab - m, ay, !0))
                        }
                        W && (y.isCompare || (ai.custom.show_k_rangepercent && Q(), "no" != ai.custom.k_0pct && H()))
                    }
                };
                this.drawFrames = function(U) { (U || y.datas[0].date != O || y.datas[y.datas.length - 1].date != I || y.labelMaxP != J || y.labelMinP != z || N != B) && (ak(), L(), R()),
                    B = y.viewState.viewId,
                    O = y.datas[0].date,
                    I = y.datas[y.datas.length - 1].date,
                    J = y.labelMaxP,
                    z = y.labelMinP
                }
            };
            this.drawBg = function(z, B) {
                y.datas && (N = y.viewState.viewId, ai.datas.isT ? S.drawFrames(z) : (isNaN(B) || (M.iOffsetX = B, z = !0), M.drawFrames(z)))
            },
            this.respos = function(z) {
                ak(z),
                C.style.left = 0,
                C.style.top = ai.DIMENSION.posY + "px",
                this.drawBg(!0)
            },
            this.gc = function() {
                t.domGc(C)
            },
            ah()
        }
        function f(p) {
            var N, P = p.parentObj,
            k = p.ctn,
            U = P.iMgr,
            x = l(P.iTo, null, k),
            m = P.iClk,
            v = U.globalDragHandler,
            S = U.zoomView,
            w = U.shortClickHandler,
            V = P.setting,
            y = V.PARAM.isFlash,
            Q = !y,
            j = !1,
            R = 300,
            q = {
                isM: !1,
                isTch: !1,
                isP: !1,
                tCount: void 0,
                tXOff: -1,
                isPv: !1,
                lastIy: null,
                mDx: 0 / 0,
                mDy: 0 / 0,
                isClk: 0,
                isTMin: !1,
                mvOx: 0,
                vP: function(E) {
                    var C, A;
                    if (E.changedTouches) {
                        r.preventDefault(E),
                        r.stopPropagation(E);
                        var F = r.getTarget(E),
                        B = E.changedTouches[0],
                        G = F.getBoundingClientRect(),
                        D = G.left,
                        z = G.top;
                        C = B.clientX - D,
                        A = B.clientY - z
                    } else {
                        C = E.offsetX,
                        isNaN(C) && (C = E.layerX),
                        A = E.offsetY,
                        isNaN(A) && (A = E.layerY)
                    }
                    x(C, A, E)
                },
                vH: function(A) {
                    if (! (this.isClk > 0) && V.custom.allow_move) {
                        r.preventDefault(A),
                        r.stopPropagation(A);
                        var z = A.changedTouches ? A.changedTouches[0].pageX: A.layerX;
                        isNaN(z) && (z = A.offsetX);
                        var B = A.changedTouches ? A.changedTouches[0].pageY: A.layerY;
                        isNaN(B) && (B = A.offsetY),
                        v(this.mDx, z, this.mDy, B)
                    }
                },
                mD: function(z) {
                    this.mDx = isNaN(z.layerX) ? z.offsetX: z.layerX,
                    this.mDy = isNaN(z.layerY) ? z.offsetY: z.layerY,
                    this.isM = this.isP = !0,
                    this.isClk = 2,
                    T(!0)
                },
                mM: function(z) {
                    this.isTch || (j = !0, this.isClk--, this.isP ? this.vH(z) : this.vP(z))
                },
                mU: function(z) {
                    this.mDx = 0 / 0,
                    this.mDy = 0 / 0,
                    this.isM = this.isP = !1,
                    v(0 / 0, 0 / 0, 0 / 0, 0 / 0, z),
                    this.isClk > 0 && m && (this.isClk = 0, m()),
                    T(!1)
                },
                mO: function() {
                    this.isClk = 0,
                    this.isM = this.isP = j = !1,
                    x(0 / 0, 0 / 0),
                    T(!1)
                },
                tR: function() {
                    clearTimeout(this.tCount),
                    this.isPv = this.isTMin = !1
                },
                gR: function() {
                    this.tR(),
                    this.tXOff = -1
                },
                tCheck: function(A) {
                    this.mvOx = A.touches[0].pageX;
                    var z = this;
                    z.isClk = 2,
                    this.tCount = setTimeout(function() {
                        z.isPv = !0,
                        z.vP(A),
                        z.isClk = 0
                    },
                    R)
                },
                tE: function(z) {
                    V.custom.touch_prevent && r.preventDefault(z),
                    this.isPv || w(),
                    this.tR(),
                    this.isTch = j = !1,
                    this.mDx = 0 / 0,
                    this.mDy = 0 / 0,
                    x(0 / 0, 0 / 0),
                    v(0 / 0, 0 / 0, 0 / 0, 0 / 0, z),
                    this.isClk > 0 && m && (this.isClk = 0, m())
                },
                tM: function(E) {
                    if (this.isClk--, 1 == E.touches.length) {
                        if (!this.isPv && !this.isTMin && Math.abs(this.mvOx - E.touches[0].pageX) < 5) {
                            return
                        }
                        this.isTMin = !0,
                        clearTimeout(this.tCount),
                        this.isPv ? this.vP(E) : this.vH(E)
                    } else {
                        if (2 == E.touches.length) {
                            r.preventDefault(E);
                            var D = E.touches[0],
                            A = E.touches[1];
                            if (this.tXOff >= 0) {
                                var F = Math.abs(D.pageX - A.pageX);
                                if (F != this.tXOff) {
                                    var C = r.getTarget(E),
                                    G = s.pageX(C),
                                    z = D.pageX - G,
                                    B = A.pageX - G;
                                    S(F < this.tXOff, [z, B])
                                }
                            }
                            this.tXOff = Math.abs(D.pageX - A.pageX)
                        }
                    }
                },
                tS: function(z) {
                    switch (this.tR(), V.custom.touch_prevent && r.preventDefault(z), this.isTch = j = !0, this.lastIy = z.touches[0].pageY, this.mDx = z.changedTouches[0].pageX, this.mDy = z.changedTouches[0].pageY, z.touches.length) {
                    case 1:
                        this.tCheck(z);
                        break;
                    case 2:
                        this.gR()
                    }
                },
                handleEvent: function(z) {
                    if (V.custom.mouse_and_touch) {
                        switch (z.type) {
                        case "mouseup":
                            this.mU(z);
                            break;
                        case "mousedown":
                            this.mD(z);
                            break;
                        case "mouseout":
                            this.mO();
                            break;
                        case "mousemove":
                            this.mM(z);
                            break;
                        case "touchend":
                            this.tE(z);
                            break;
                        case "touchmove":
                            this.tM(z);
                            break;
                        case "touchstart":
                            this.tS(z)
                        }
                    }
                }
            },
            W = new
            function() {
                this.onmouseup = function(z) {
                    V.custom.mouse_and_touch && q.mU(z)
                },
                this.onmousedown = function(z) {
                    V.custom.mouse_and_touch && q.mD(z)
                },
                this.onmouseout = function() {
                    V.custom.mouse_and_touch && q.mO()
                },
                this.onmousemove = function(z) {
                    V.custom.mouse_and_touch && q.mM(z)
                }
            },
            X = function() {
                Q ? N = i("canvas") : (N = i("div"), N.style.backgroundColor = "#eee", N.style.opacity = 0, N.style.filter = "alpha(opacity=0)"),
                N.style.position = "absolute",
                N.style.zIndex = V.PARAM.I_Z_INDEX;
                var A;
                a.istd ? A = ["touchend", "touchmove", "touchstart"] : (A = ["mousedown", "mouseup", "mousemove", "mouseout"], a.allowt && (A = A.concat(["touchend", "touchmove", "touchstart"])));
                for (var z = A.length; z--;) {
                    Q ? r.addHandler(N, A[z], q) : r.addHandler(N, A[z], W["on" + A[z]] ||
                    function() {})
                }
                k.appendChild(N)
            },
            T = function(z) {
                z ? (N.style.cursor = "grabbing", N.style.cursor = "-webkit-grabbing") : N.style.cursor = "default"
            };
            this.respos = function(A) {
                N.style.top = V.DIMENSION.posY + A.mh + "px",
                N.style.left = V.DIMENSION.posX + "px";
                var z;
                z = V.datas.isT ? V.DIMENSION.w_t: V.DIMENSION.w_k,
                N.style.width = z + "px",
                N.style.height = A.h + "px"
            },
            this.gc = function() {
                t.domGc(N)
            },
            X()
        }
        function b(k) {
            this.VER = "2.2.8",
            k = u({
                setting: void 0,
                sd: void 0,
                ctn: void 0,
                reO: void 0,
                withHBg: !1,
                nu: !1,
                dt: !0,
                fixScale: !0,
                iTo: function() {},
                iMgr: void 0,
                iClk: void 0
            },
            k || {});
            var v, K, x, I, j, w = k.setting,
            m = function() {
                k.ctn ? v = k.ctn: (v = i("div"), v.style.position = "relative")
            },
            q = function() {
                K = i("canvas"),
                "undefined" != typeof FlashCanvas && FlashCanvas.initElement(K),
                K.style.position = "absolute",
                K.style.zIndex = w.PARAM.G_Z_INDEX,
                x = K.getContext("2d"),
                v.appendChild(K)
            },
            p = function() {
                j = new f({
                    parentObj: k,
                    ctn: v
                })
            },
            y = function() {
                I = new d({
                    parentObj: k,
                    ctn: v
                })
            },
            J = function(E) {
                E = E || {};
                var B, A, D = isNaN(E.mh) ? w.DIMENSION.H_T_T: E.mh,
                C = isNaN(E.eh) ? w.DIMENSION.H_TIME_PART: E.eh,
                z = w.PARAM.getHd();
                switch (B = w.datas.isT ? w.DIMENSION.w_t: w.DIMENSION.w_k, A = isNaN(E.h) ? w.DIMENSION.h_k: E.h, E.h = A, E.mh = D, E.eh = C, v.style.height = A + D + C + "px", K.style.top = w.DIMENSION.posY + D + "px", K.style.left = w.DIMENSION.posX + "px", K.style.width = B + "px", K.style.height = A + "px", z) {
                case 0:
                    break;
                case 1:
                    z = o.hdpr,
                    B *= z,
                    A *= z;
                    break;
                default:
                    B *= z,
                    A *= z
                }
                K.width = B,
                K.height = A,
                j && j.respos(E),
                I && I.respos(E)
            };
            this.resize = J,
            this.getCanvas = function() {
                return K
            },
            this.getG = function() {
                return x
            },
            this.getWrap = function() {
                return v
            };
            var L;
            this.scale = function(z) {
                switch (z) {
                case 0:
                    return;
                case 1:
                    z = o.hdpr
                }
                z && x.scale(z, z)
            },
            this.newGStyle = function(z) {
                for (var A in z) {
                    z.hasOwnProperty(A) && (x[A] = z[A])
                }
            },
            this.newStyle = function(z, B, A) {
                L = x.strokeStyle = z,
                B && x.beginPath(),
                A && (x.lineWidth = A)
            },
            this.newFillStyle = function(C, B) {
                if (C && !(C.length < 1)) {
                    var A = C.length;
                    if (1 == A) {
                        x.fillStyle = C[0]
                    } else {
                        if (A > 1) {
                            for (var z = x.createLinearGradient(0, 0, 0, B), D = 0; A > D; D++) {
                                z.addColorStop(1 / (A - 1) * D, C[D])
                            }
                            x.fillStyle = z
                        }
                    }
                }
            },
            this.newFillStyle_rgba = function(A, F, C) {
                for (var z = t.isArr(C) ? C: [C], B = x.createLinearGradient(0, 0, 0, F), E = 0, D = A.length; D > E; E++) {
                    B.addColorStop(1 / (D - 1) * E, t.hex2dec(A[E], z[E] || 0))
                }
                x.fillStyle = B
            },
            this.clear = function(z, A) {
                K.width = K.width,
                z && (L && x.strokeStyle != L && (x.strokeStyle = L), x.beginPath()),
                this.scale(A)
            },
            this.clearLimit = function(z, A) {
                x.clearRect(z, 0, A, K.height),
                x.beginPath()
            },
            this.beginPath = function() {
                x.beginPath()
            },
            this.closePath = function() {
                x.closePath()
            },
            this.fill = function() {
                x.fill()
            },
            this.stroke = function() {
                x.stroke()
            },
            this.save = function() {
                x.save()
            },
            this.translate = function(z, A) {
                x.translate(z, A)
            },
            this.restore = function() {
                x.restore()
            },
            this.moveTo = function(z, A) {
                x.moveTo(z, A)
            },
            this.lineTo = function(z, A) {
                x.lineTo(z, A)
            },
            this.drawDot = function(B, A, C, z) {
                z && x.moveTo(B, A),
                x.arc(B, A, C, 0, 2 * Math.PI)
            },
            this.arc = function(D, C, A, z, B, E) {
                x.arc(D, C, A, z, B, E)
            },
            this.drawCandleRect = function(F, C, z, E, B, D) {
                if (C != z && !(2 > E)) {
                    var A = z - C;
                    F += 0.5 * E,
                    E = ~~ (E + 0.5),
                    F = ~~ (F + 0.5),
                    C = ~~ (C + 0.5),
                    A = ~~ (A + 0.5),
                    x.lineWidth = 1,
                    D ? (F -= 0.5, C -= 0.5, x.strokeStyle = B, x.strokeRect(F, C, E, A)) : (1 > A && (A = 1), x.fillStyle = B, x.fillRect(F, C, E, A), F -= 0.5, C -= 0.5, x.strokeStyle = B, x.strokeRect(F, C, E, A))
                }
            },
            this.drawCandleRect_solid = function(D, C, A, z, B) {
                if (C != A && !(2 > z)) {
                    var E = A - C;
                    D += 0.5 * z,
                    z = ~~ (z + 0.5),
                    D = ~~ (D + 0.5),
                    C = ~~ (C + 0.5),
                    E = ~~ (E + 0.5),
                    x.lineWidth = 1,
                    x.fillStyle = B,
                    x.fillRect(D, C, z, E),
                    D -= 0.5,
                    C -= 0.5,
                    x.strokeStyle = B,
                    x.strokeRect(D, C, z, E)
                }
            },
            this.drawCandleLineRect = function(z, D, R, G, F, S, B, H) {
                if (z += S, z = ~~ (z + 0.5), x.strokeStyle = B, x.lineWidth = 1, R == G) {
                    var C = 0.5 * S;
                    C = ~~ (C + 0.5),
                    0.5 > C && (C = 0.5),
                    R = ~~ (R + 0.5),
                    R -= 0.5,
                    x.moveTo(z - C, R),
                    x.lineTo(z + C, R)
                }
                if (D != F) {
                    if (z -= 0.5, x.moveTo(z, D), H && S >= 2) {
                        var A = Math.min(R, G),
                        E = Math.max(R, G);
                        x.lineTo(z, A),
                        x.moveTo(z, E)
                    }
                    x.lineTo(z, F)
                }
            },
            this.drawOhlc = function(B, z, E, C, G, A, F) {
                x.strokeStyle = F,
                x.lineWidth = 1;
                var D = 0.5 * A;
                D = ~~ (D + 0.5),
                0.5 > D && (D = 0.5),
                B += A,
                B = ~~ (B + 0.5),
                z = ~~ (z + 0.5),
                z -= 0.5,
                x.moveTo(B - D, z),
                x.lineTo(B, z),
                G = ~~ (G + 0.5),
                G -= 0.5,
                x.moveTo(B, G),
                x.lineTo(B + D, G),
                B -= 0.5,
                x.moveTo(B, E),
                x.lineTo(B, C)
            },
            this.drawVStickC = function(C, B, A, z, D) {
                C += A,
                A = ~~ (A + 0.5),
                1 > A && (A = 1),
                C = ~~ (C + 0.5),
                1 & A && (C -= 0.5),
                B = ~~ (B + 0.5),
                z = ~~ (z - 0.5),
                x.strokeStyle = D,
                x.lineWidth = A,
                x.moveTo(C, B),
                x.lineTo(C, B + z)
            },
            this.drawVStickRect = function(F, C, z, E, B, D) {
                F += 0.5 * z;
                var A = z;
                F = ~~ (F + 0.5),
                A = ~~ (A + 0.5),
                C = ~~ (C + 0.5),
                E = ~~ (E + 0.5),
                0 == E && (E = 1),
                D ? (0.5 > A && (A = 0.5), x.fillStyle = B, x.fillRect(F, C, A, E)) : (F -= 0.5, C -= 0.5, x.strokeStyle = B, x.strokeRect(F, C, A, E))
            },
            this.drawBg = function(z) {
                I && I.drawBg(!1, z)
            },
            this.remove = function() {
                t.domGc(K),
                j && j.gc(),
                I && I.gc()
            },
            m(),
            q(),
            k.withHBg && (p(), y()),
            J(k.reO)
        }
        this.xh5_ibPainter = b,
        this.xh5_Canvas = g
    }
    var i = t.$C,
    o = t.xh5_BrowserUtil,
    r = t.xh5_EvtUtil,
    a = t.xh5_deviceUtil,
    s = t.xh5_HtmlPosUtil,
    l = t.fBind,
    c = t.dateUtil,
    u = t.oc,
    h = e.globalCfg;
    return n
});