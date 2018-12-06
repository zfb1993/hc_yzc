!
function(G, k) {
    function J(a) {
        return a.replace(/([A-Z])/g, "-$1").toLowerCase()
    }
    function z(a) {
        return C ? C + a: a.toLowerCase()
    }
    var C, w, q, y, B, I, H, x, D, A, F = "",
    j = {
        Webkit: "webkit",
        Moz: "",
        O: "o"
    },
    K = document.createElement("div"),
    b = /^((translate|rotate|scale)(X|Y|Z|3d)?|matrix(3d)?|perspective|skew(X|Y)?)$/i,
    E = {};
    K.style.transform === k && G.each(j,
    function(d, c) {
        if (K.style[d + "TransitionProperty"] !== k) {
            return F = "-" + d.toLowerCase() + "-",
            C = c,
            !1
        }
    }),
    w = F + "transform",
    E[q = F + "transition-property"] = E[y = F + "transition-duration"] = E[I = F + "transition-delay"] = E[B = F + "transition-timing-function"] = E[H = F + "animation-name"] = E[x = F + "animation-duration"] = E[A = F + "animation-delay"] = E[D = F + "animation-timing-function"] = "",
    G.fx = {
        off: C === k && K.style.transitionProperty === k,
        speeds: {
            _default: 400,
            fast: 200,
            slow: 600
        },
        cssPrefix: F,
        transitionEnd: z("TransitionEnd"),
        animationEnd: z("AnimationEnd")
    },
    G.fn.animate = function(c, g, d, f, e) {
        return G.isFunction(g) && (f = g, d = k, g = k),
        G.isFunction(d) && (f = d, d = k),
        G.isPlainObject(g) && (d = g.easing, f = g.complete, e = g.delay, g = g.duration),
        g && (g = ("number" == typeof g ? g: G.fx.speeds[g] || G.fx.speeds._default) / 1000),
        e && (e = parseFloat(e) / 1000),
        this.anim(c, g, d, f, e)
    },
    G.fn.anim = function(d, h, l, t, s) {
        var o, m, r, c = {},
        g = "",
        p = this,
        e = G.fx.transitionEnd,
        a = !1;
        if (h === k && (h = G.fx.speeds._default / 1000), s === k && (s = 0), G.fx.off && (h = 0), "string" == typeof d) {
            c[H] = d,
            c[x] = h + "s",
            c[A] = s + "s",
            c[D] = l || "linear",
            e = G.fx.animationEnd
        } else {
            m = [];
            for (o in d) {
                b.test(o) ? g += o + "(" + d[o] + ") ": (c[o] = d[o], m.push(J(o)))
            }
            g && (c[w] = g, m.push(w)),
            h > 0 && "object" == typeof d && (c[q] = m.join(", "), c[y] = h + "s", c[I] = s + "s", c[B] = l || "linear")
        }
        return r = function(f) {
            if (void 0 !== f) {
                if (f.target !== f.currentTarget) {
                    return
                }
                G(f.target).unbind(e, r)
            } else {
                G(this).unbind(e, r)
            }
            a = !0,
            G(this).css(E),
            t && t.call(this)
        },
        h > 0 && (this.bind(e, r), setTimeout(function() {
            a || r.call(p)
        },
        1000 * (h + s) + 25)),
        this.size() && this.get(0).clientLeft,
        this.css(c),
        h <= 0 && setTimeout(function() {
            p.each(function() {
                r.call(this)
            })
        },
        0),
        this
    },
    K = null
} (Zepto),
function(R) {
    function D() {
        var h = 0,
        m = 0,
        k = 0,
        d = 0,
        g = 0,
        b = 0,
        p = window,
        c = document,
        f = c.documentElement;
        return h = p.innerWidth || f.clientWidth || c.body.clientWidth || 0,
        m = p.innerHeight || f.clientHeight || c.body.clientHeight || 0,
        d = c.body.scrollTop || f.scrollTop || p.pageYOffset,
        k = c.body.scrollLeft || f.scrollLeft || p.pageXOffset,
        g = Math.max(c.body.scrollWidth, f.scrollWidth || 0),
        b = Math.max(c.body.scrollHeight, f.scrollHeight || 0, m),
        {
            scrollTop: d,
            scrollLeft: k,
            documentWidth: g,
            documentHeight: b,
            viewWidth: h,
            viewHeight: m
        }
    }
    function V(h, m, k, d, g, b) {
        void 0 === m && (m = "-");
        var p = [];
        if (d || p.push(h[k ? "getUTCFullYear": "getFullYear"]()), !g) {
            var c = h[k ? "getUTCMonth": "getMonth"]() + 1;
            p.push(c < 10 ? "0" + c: c)
        }
        if (!b) {
            var f = h[k ? "getUTCDate": "getDate"]();
            p.push(f < 10 ? "0" + f: f)
        }
        return p.join(m)
    }
    function J(h, m, k, d) {
        var g = !1,
        b = document.createElement("script"),
        p = document.getElementsByTagName("script")[0],
        c = document.head || document.getElementsByTagName("head")[0] || document.documentElement,
        f = c.getElementsByTagName("base")[0];
        b.charset = d || "gb2312",
        b.src = h,
        b.async = !0,
        b.onload = b.onreadystatechange = function() {
            g || b.readyState && !/loaded|complete/.test(b.readyState) || (g = !0, b.onload = b.onreadystatechange = b.onerror = null, b.parentNode.removeChild(b), b = null, "function" == typeof m && m())
        },
        b.onerror = function() {
            b.onload = b.onreadystatechange = b.onerror = null,
            b.parentNode.removeChild(b),
            b = null,
            "function" == typeof k && k()
        },
        p.parentNode ? p.parentNode.insertBefore(b, p) : f ? c.insertBefore(b, f) : c.appendChild(b)
    }
    function N(b, a) {
        return b > 0 ? a.themeRed: b < 0 ? a.themeGreen: a.themeEqual
    }
    function G(a) {
        this.prefix_visitAll = "_visit_all",
        this.prefix = "_visit_",
        this.v_allList = null,
        this.v_list = null,
        this.v_all_len = 20,
        this.v_len = 10,
        this.code = a.code,
        this.market("cn"),
        this.getVisit()
    }
    function E() {
        this.chart = null,
        this.initChart()
    }
    function I(d) {
        function b() {
            var i = paperCode.toLowerCase().replace(/\$/, "."),
            c = A.newsUrl.replace("$page", h.pageNum).replace("$symbol", i);
            R.ajax({
                type: "GET",
                url: c,
                jsonp: "callback",
                dataType: "jsonp",
                success: function(k) {
                    k && (h.data = k.result.data, h.pageNum++, g(R("#" + h.param.dom), h.data), R("#cn_news_cont").find("a").each(function(m, l) {
                        R(l).attr("suda-uatrack", "key=wapnews_cn&value=news" + m)
                    }))
                },
                error: function() {
                    console.log("api error...")
                }
            })
        }
        function f() {
            var i = "&relate_tid=" + h.relate_tid + "&relate_value=" + h.relate_value,
            c = paperCode.toLowerCase().replace(/\$/, ".");
            J(A.commentUrl.replace("$symbol", c) + A.varComment + "=" + i,
            function() {
                var k = window[A.varComment];
                if (h.data = k, h.data) {
                    if (!k.data) {
                        return R("#cn_comment_refresh").hide(),
                        R("#cn_comment_more").hide(),
                        nHtml = A.nothingComment.replace("@code", c),
                        void R("#" + h.param.dom).find("ul").append(nHtml)
                    }
                    h.relate_tid = k.data.threads[k.data.threads.length - 1].tid,
                    h.relate_value = k.data.threads[k.data.threads.length - 1].timestamp,
                    e(R("#" + h.param.dom), h.data)
                }
            })
        }
        function e(ac, ab) {
            for (var w = ac.find("ul")[0], C = ab.data.threads, k = C.length, ad = 0; ad < k; ad++) {
                var v = A.guHtml,
                y = C[ad],
                aa = document.createElement("li"),
                Z = y.content.replace("<br />", ""),
                u = y.title ? y.title: Z.length < 30 ? Z: Z.substring(0, 30) + "...",
                X = Y = y.lastctime.split(" "),
                x = X[0].substring(5, X[0].length),
                Y = X[1].substring(0, 5);
                v = v.replace("@content", u).replace("@src", y.user.portrait).replace("@time", x + " " + Y).replace("@nick", y.user.nick).replace("@url", "//apo51.cn/view_" + y.bid + "_" + y.tid + ".html"),
                aa.innerHTML = v,
                R(w).append(aa)
            }
            R("#cn_comment_more").show(),
            R("#cn_comment_refresh").hide()
        }
        function g(Z, v) {
            for (var y = Z.find("ul")[0], c = v, aa = c.length, u = 0; u < aa; u++) {
                var x = A.newsHtml,
                Y = c[u],
                k = "none",
                C = "",
                w = document.createElement("li"),
                X = V(new Date(1000 * Number(Y.ctime)));
                Y.thumbs && Y.thumbs.length > 0 && (k = "", C = Y.thumbs[0].replace("//", "//"), x = x.replace("@dlhg", "1.6rem").replace("@ddhg", "1.2rem").replace("@h3hg", ".8rem")),
                x = x.replace("@content", Y.waptitle).replace("@source", Y.media).replace("@time", X).replace("@src", C).replace("@display", k).replace("@href", Y.wapurl),
                w.innerHTML = x,
                R(y).append(w)
            }
            "info" == h.param.tab ? (R("#cn_analysis_more").show(), R("#cn_analysis_refresh").hide()) : (R("#cn_news_more").show(), R("#cn_news_refresh").hide())
        }
        function a() {
            switch (h.param.idx.toString()) {
            case "1":
                b();
                break;
            case "2":
                f()
            }
            1 == h.isLoad && "undefined" != typeof SUDA && SUDA.log()
        }
        this.param = d,
        this.pageNum = 1,
        this.isLoad = !1,
        this.data = null,
        this.relate_tid = 0,
        this.relate_value = 0;
        var h = this;
        this.init = function() {
            a(),
            this.isLoad = 1
        }
    }
    function L(a) {
        relateSymbol || (relateSymbol = "sh000001,sz399001,sz399006,gb_$dji,hkHSI"),
        relateSymbol = relateSymbol.replace(paperCode + ",", ""),
        relateSymbol = relateSymbol.replace(paperCode, ""),
        this.param = a,
        this.inited = !1,
        this.relateSymbol = relateSymbol,
        this.visitSymbol = a.visitSymbol
    }
    function T(a) {
        this.param = a,
        this.addEvent(),
        this.select(0)
    }
    function S(a) {
        this.param = a,
        this.tempHtml = void 0,
        this.tempHHtml = void 0,
        this.inited = 0,
        this.load()
    }
    function H() {
        function Z() {
            v || (v = new I({
                tab: "news",
                idx: 1,
                dom: e[1]
            }), v.init())
        }
        function aj() {
            ab || (ab = new I({
                idx: 2,
                dom: e[2]
            }), ab.init())
        }
        function ad(b) {
            var g = b || null,
            f = g.id;
            hashValue = f.split("_"),
            hashValue[2],
            "news" == hashValue[2] && Z(),
            "relate" == hashValue[2] && d && d.addBlank(),
            l = R("#cn_head").offset().height,
            1 == o && (Y = R("#" + m).offset().top - l + 3, window.scrollTo(0, Y))
        }
        function ae() {
            var a = K.get(X);
            if (a) {
                return a
            }
        }
        function ac() {
            if ("riseGreen" == A.riseColor) {
                var a = A.chartGreen;
                A.chartGreen = A.chartRed,
                A.chartRed = a
            }
            A.theme = {
                T_RISE: A.chartRed,
                T_FALL: A.chartGreen,
                K_RISE: A.chartRed,
                K_FALL: A.chartGreen
            }
        }
        function af() {
            R("#cn_news_more").on("click tap",
            function() {
                R("#cn_news_more").hide(),
                R("#cn_news_refresh").show(),
                v.init()
            }),
            R("#cn_comment_more").on("click tap",
            function() {
                R("#cn_comment_more").hide(),
                R("#cn_comment_refresh").show(),
                ab.init()
            }),
            R("#cn_comment_tw").on("click tap",
            function() {
                var a = "list_$symbol.html".replace("$symbol", paperCode);
                window.open(a, "_self")
            }),
            R(".cn-icon-backtop").on("click tap",
            function() {
                R("#fix_floating").hide(),
                R("#fix_header").hide(),
                window.scrollTo(0, 0)
            })
        }
        function ah() {
            R(window).on("resize",
            function() {
                s.resizeChart(B),
                s && s.chart && s.chart.resize()
            })
        }
        function ak() {
            var a = Y;
            R(window).scroll(function() {
                var b = R(this).scrollTop();
                l = R("#cn_head").offset().height,
                0 == k && (a = Y = R("#" + m).offset().top - l - 3),
                b > 0 ? b > a ? (o = 1, R("#fix_header").hide(), R("#fix_floating").show(), R("#fix_floating").find("header").css("position", "")) : (o = 0, R("#fix_floating").hide(), b > c && R("#fix_header").show()) : (R("#fix_header").hide(), R("#fix_floating").hide()),
                ag()
            })
        }
        function ag() {
            0 == o ? R(".cn-expert-tw").css("display", "none") : R(".cn-expert-tw").css("display", "block")
        }
        function ai() {
            new HQ.DataBox({
                boxId: "cn_hqdata",
                symbol: paperCode,
                getStr: function(b) {
                    var a = Object.keys(b)[0];
                    B && B.pushData({
                        symbol: a,
                        data: b[a]
                    })
                }
            })
        }
        function r() {
            var a = new G({
                code: paperCode
            });
            new L({
                dom: R("#cn_relate_con")
            }).hqComponent(),
            d = new L({
                dom: R("#cn_visit_cont"),
                visitObj: a
            }),
            d.hqComponent({
                symbol: a.v_allList
            }),
            A.riseColor = ae() ? ae() : "riseRed",
            ac(),
            new S({
                dom: ["cn_floating", "cn_floating_h"],
                priceDom: ["cn-floating-price", "cn_floating_price_h"],
                percentDom: ["cn-floating-zdf", "cn_floating_zdf_h"]
            }),
            s = new E,
            aj(),
            ak(),
            af(),
            ah(),
            ai()
        }
        var v, ab, s, d, aa = ["cn_tab_relate", "cn_tab_news", "cn_tab_comment"],
        e = ["cn_relate_cont", "cn_news_cont", "cn_comment_cont"],
        u = ["cn_tab_relate_f", "cn_tab_news_f", "cn_tab_comment_f"],
        m = "cn-news-c",
        o = 0,
        X = "hq_userColor",
        Y = "",
        l = "";
        M = new T({
            tab: aa,
            con: e,
            tabF: u,
            css: {
                active: "active"
            },
            cb: ad
        });
        var k = 0,
        c = 48;
        this.init = r
    }
    function O(b) {
        var a = {
            eventid: "hq_center_hs",
            uatrackKey: "hq_center_hs",
            subname: b.pos,
            needOpenSource: !1,
            androidInstallUrl: b.androidurl
        };
        new apiFinanceCallUp.CallUpapiFinance(a).tryDirectCall({
            stocktype: "cn",
            callpagetype: "2",
            position: b.pos,
            symbol: paperCode
        })
    }
    var K = {
        escape: function(a) {
            return a.replace(/([.*+?^${}()|[\]\/\\])/g, "\\$1")
        },
        get: function(b) {
            var a = document.cookie.match("(?:^|;)\\s*" + this.escape(b) + "=([^;]*)");
            return a ? a[1] || "": ""
        },
        set: function(h, d, b) { ! b && (b = {}),
            d || (d = "", b.expires = -1);
            var l = "";
            if (b.expires && (Number(b.expires) || b.expires.toUTCString)) {
                var c;
                Number(b.expires) ? (c = new Date, c.setTime(c.getTime() + 1000 * b.expires)) : c = b.expires,
                l = "; expires=" + c.toUTCString()
            }
            var g = b.path ? "; path=" + b.path: "",
            f = b.domain ? "; domain=" + b.domain: "",
            k = b.secure ? "; secure": "";
            document.cookie = [h, "=", d, l, g, f, k].join("")
        }
    },
    Q = G.prototype;
    Q.market = function(b) {
        var a = this;
        a.prefix_visit = a.prefix + b
    },
    Q.setMCookie = function(g) {
        var d = g.list,
        b = g.len,
        h = g.prefix,
        c = this;
        d ? (d = d.replace(this.code + ",", ""), d = d.replace(this.code, ""), d = c.code + "," + d, "," == d.charAt(d.length - 1) && (d = d.substring(0, d.length - 1))) : d = c.code;
        var f = d.split(",");
        f.length > b && f.pop(),
        d = f.toString(),
        K.set(h, d, {
            expires: 71996400,
            domain: ".api51.cn",
            path: "/"
        })
    },
    Q.setVisit = function() {
        if (!this.code) {
            return ! 1
        }
        var a = this;
        a.getVisit(),
        a.setMCookie({
            prefix: a.prefix_visit,
            list: a.v_list,
            len: a.v_len
        }),
        a.setMCookie({
            prefix: a.prefix_visitAll,
            list: a.v_allList,
            len: a.v_all_len
        })
    },
    Q.getVisit = function() {
        this.v_list = K.get(this.prefix_visit),
        this.v_allList = K.get(this.prefix_visitAll)
    };
    var B = null,
    W = E.prototype;
    W.initChart = function() {
        var a = this;
        KKE.api("plugins.apiAppTKChart.get", {
            wrap: {
                dom: R("#h5Chart")[0]
            },
            chart: {
                symbol: paperCode,
                kInitParam: {
                    rate: 20,
                    theme: A.theme
                },
                kChart: {
                    pCharts: [{
                        name: "MA",
                        param: [{
                            v: 5,
                            color: "#FC9CB8"
                        },
                        {
                            v: 10,
                            color: "#12BDD9"
                        },
                        {
                            v: 20,
                            color: "#EE2F72"
                        }]
                    }]
                },
                tChart: {
                    toggleExtend: "on",
                    setLineStyle: {
                        linetype: "mountain"
                    }
                },
                tInitParam: {
                    rate: 20,
                    theme: A.theme
                }
            },
            info: {
                upColor: A.chartRed,
                downColor: A.chartGreen
            }
        },
        function(b) {
            B = a.chart = b,
            a.resizeChart(b)
        })
    },
    W.resizeChart = function(c) {
        var h = this,
        d = D(),
        f = R("#hq_chart"),
        e = R("#h5Chart"),
        g = R("#hqMain"),
        b = R(".cn-chart");
        setTimeout(function() { (g.show(), f.hide(), b.append(e), c.setDirection("vertical"))
        },
        100)
    },
    W.resize = function() {
        var c = D(),
        b = c.viewWidth,
        d = c.viewHeight;
        return b > d ? 1 : 0
    };
    var A = {
        cssClass: {
            riseColor: "red",
            fallColor: "green",
            equalColor: "equal",
            themeRed: "#de3639",
            themeGreen: "#1bc07d",
            themeEqual: "#d6d6d6"
        },
        riseColor: "riseRed",
        chartRed: "#f11200",
        chartGreen: "#23bc01",
        theme: {
            T_RISE: void 0,
            T_FALL: void 0,
            K_RISE: void 0,
            K_FALL: void 0
        },
        newsUrl: "api/datalist.php?",
        commentUrl: "api/datalist.php?",
        guBaUrl: "api/datalist.php?",
        bkUrl: "api/datalist.php?",
        gnUrl: "api/datalist.php?",
        varBK: "cnBk",
        varGN: "cnGn",
        varNews: "cnNews",
        varData: "cnData",
        varComment: "cnComment",
        info: "cnInfo",
        newsHtml: '<a href="@href"><dl style="height:@dlhg;"><dt><img src="@src" alt="@alt" style="display: @display;"></dt><dd style="height:@ddhg"><h3 style="height:@h3hg;">@content</h3><p><span>@source</span><span>@time</span></p></dd></dl></a>',
        bkHtml: function(g) {
            var c = g,
            b = c.type,
            i = c.percent > 0 ? "+" + c.percent.toFixed(2) + "%": c.percent.toFixed(2) + "%",
            f = c.lead_cname,
            d = c.increase > 0 ? "+" + c.increase.toFixed(2) + "%": c.increase.toFixed(2) + "%",
            h = N(c.percent, A.cssClass);
            return ldCss = N(c.increase, A.cssClass),
            '<ul class="cn-bk"><li><a href="//apo51.cn/m/#/stock/blockdetail?id=' + b + '"><p>' + c.name + '</p></a></li><li><a href="//apo51.cn/m/#/stock/blockdetail?id=' + b + '"><p style="color:' + h + '">' + i + '</p></a></li><li><a href="//quotes.api.cn/hs/company/quotes/view/' + c.lead_shares + '/"><span>' + f + '</span><span style="color:' + ldCss + '">' + d + "</span></a></li></ul>"
        },
        nothingComment: '<div class="cn-nothing"><div></div><span><a style="color: #0090f7;" href="//apo51.cn/list_@code.html">\u6682\u65e0\u6570\u636e \u70b9\u51fb\u524d\u5f80\u8bc4\u8bba</a></span></div>',
        relatedHtml: '<a href="@href"><ul class="cn-relate"><li><div class="cn-relate-name">@name</div><div class="cn-relate-name gray">@symbol</div></li><li data-attr="@attr">@price</li><li><span data-color="a" class="cn-relate-color" style="background-color:@color">@zdf</span></li></ul></a>',
        guHtml: '<a href="@url"><dl><dt><img src="@src"></dt><dd class="cn-comment-user"><span>@nick</span><span>@time</span></dd><dd><div class="cn-comment-content"><span>@content</span></div></dd></dl></a>',
        more: '<p class="cn-news-more"><a href="@href">\u67e5\u770b\u66f4\u591a<i class="cn-arrow-more"></i></a></p>'
    },
    P = L.prototype;
    P.addBlank = function() {
        var d = R("#cn_blank"),
        b = window.innerHeight;
        d.css("height", 0);
        var g = 0,
        c = "",
        f = 0,
        e = 0; (g = parseInt(g, 10) || 350) < b && d.css("height", b - g - c - f - e)
    },
    P.hqComponent = function(g) {
        var d = this,
        b = null;
        if (d.hasVisit = g, g) {
            for (var h = g.symbol.split(","), c = 0; c < h.length; c++) {
                b = g.symbol.replace(paperCode, ""),
                paperCode == h[c] && h.splice(c, 1)
            }
            for (c = 0; c < h.length; c++) {
                h[c] && (h[c] = h[c])
            }
            var f = h.length > 10 ? h.splice(0, 10) : h;
            if (b = f.join(","), new HQ.DataCenter({
                symbols: paperCode,
                QZindex: !1,
                isANeedQZ: !1,
                isANeedPHP: !1,
                isANeedCWZJ: !1,
                getObj: function(k) {
                    var i = k[paperCode];
                    "--" == i.price && "--" == i.prevclose && "--" == i.name && "--" == i.totalVolume && "--" == i.open || d.param.visitObj.setVisit()
                }
            }), !b) {
                return d.param.dom.hide(),
                !0
            }
        } else {
            b = d.relateSymbol
        }
        "" != b && new HQ.DataCenter({
            symbols: b,
            QZindex: !1,
            isANeedQZ: !1,
            isANeedPHP: !1,
            isANeedCWZJ: !1,
            getObj: function(l) {
                for (var m = b.split(","), a = [], k = 0; k < m.length; k++) {
                    a.push(l[m[k]])
                }
                d.inited ? d.relatedDataUpdate(a) : d.relatedRender(a)
            }
        })
    },
    P.relatedRender = function(X) {
        var C = this;
        C.inited || (C.inited = !0);
        var g = C.param.dom.find("li")[0],
        v = "",
        b = [];
        if (C.hasVisit) {
            for (var Y in X) {
                b.push(Y)
            }
        } else {
            b = C.relateSymbol.split(",")
        }
        for (var f = 0; f < X.length; f++) {
            var u, y = A.relatedHtml,
            x = X[f],
            e = x.name,
            w = A.cssClass.themeGreen,
            k = A.cssClass.themeRed;
            switch (x.type) {
            case "green":
                u = w;
                break;
            case "red":
                u = k;
                break;
            case "equal":
                u = A.cssClass.themeEqual
            }
            y = y.replace("@price", x.price).replace("@zdf", x.percent).replace("@href", x.url).replace("@symbol", String(x.code).toUpperCase()).replace("@name", e).replace("@color", u).replace("@attr", String(x.code).toUpperCase()),
            v += y
        }
        R(g).append(v),
        C.addBlank()
    },
    P.relatedDataUpdate = function(e) {
        function c(p, o) {
            if (p.getAttribute("data-attr")) {
                for (var l = 0; l < o.length; l++) {
                    var r = o[l];
                    if (r.code.toUpperCase() == p.getAttribute("data-attr")) {
                        p.innerHTML = r.price,
                        p.nextElementSibling.childNodes[0].innerHTML = r.percent,
                        p.nextElementSibling.childNodes[0].className = "cn-relate-color cn-relate-@color".replace("@color", r.type);
                        var m = "";
                        m = "red" == r.type ? A.cssClass.themeRed: "green" == r.type ? A.cssClass.themeGreen: A.cssClass.themeEqual,
                        p.nextElementSibling.childNodes[0].style.backgroundColor = m
                    }
                }
            }
        }
        for (var k = R("#cn_relate_cont").find("li"), d = k.length, g = R("#cn_visit_cont").find("li"), f = g.length, h = 0; h < d; h++) {
            var b = k[h];
            c(b, e)
        }
        for (h = 0; h < f; h++) {
            b = g[h],
            c(b, e)
        }
    };
    var U = T.prototype;
    U.setCss = function(d, b) {
        var k = this,
        c = k.param.tab.length;
        k.hide();
        try {
            SUDA && SUDA.log()
        } catch(h) {}
        for (var g = 0; g < c; g++) {
            var f = g;
            if (d.target.id == b[g]) {
                h("#" + k.param.con[f]).show(),
                h("#" + k.param.tab[f])[0].className = k.param.css.active,
                h("#" + k.param.tabF[f])[0].className = k.param.css.active,
                k.param.cb(d.target);
                break
            }
        }
    },
    U.addEvent = function() {
        for (var c = this,
        b = c.param.tab.length,
        d = 0; d < b; d++) {
            R("#" + c.param.tab[d]).on("click tap",
            function(a) {
                c.setCss(a, c.param.tab)
            }),
            R("#" + c.param.tabF[d]).on("click tap",
            function(a) {
                c.setCss(a, c.param.tabF)
            })
        }
    },
    U.select = function(a) {
        this.hide()
    },
    U.hide = function() {
        for (var c = this,
        b = c.param.tab.length,
        d = 0; d < b; d++) {
            R("#" + c.param.con[d]).hide()
        }
    };
    var j = S.prototype;
    j.load = function() {
        var a = this;
        new HQ.DataCenter({
            symbols: paperCode || "sh000001",
            QZindex: !1,
            isANeedQZ: !1,
            isANeedPHP: !1,
            isANeedCWZJ: !1,
            getObj: function(b) {
                a.render(b)
            }
        })
    },
    j.title = function(b) {
        var a = b.code;
        document.title = b.name + " " + a.toUpperCase() + " " + b.price + "(" + b.change + " " + b.percent + ")"
    },
    j.render = function(h) {
        var d = this,
        b = document.getElementById(d.param.dom[0]),
        l = document.getElementById(d.param.dom[1]);
        0 == d.inited && (d.tempHtml = 0, d.tempHHtml = 0, d.inited = 1);
        var c = d.tempHtml,
        g = d.tempHHtml;
        for (var f in h) {
            if (h.hasOwnProperty(f)) {
                var k = h[f];
                d.title(k);
                A.cssClass.themeGreen,
                A.cssClass.themeRed;
                switch (k.type) {
                case "green":
                    color = A.cssClass.themeGreen;
                    break;
                case "red":
                    color = A.cssClass.themeRed;
                    break;
                case "equal":
                    color = A.cssClass.themeEqual
                }
                c = "",
                g = ""
            }
        }
    };
    var z = {
        eventid: "wap_hqcenter_callup",
        subname: "hq_top",
        uatrackKey: "wap_hqcenter_callup",
        androidInstallUrl: ".apk",
        needOpenSource: !1
    },
    F = new apiFinanceCallUp.CallUpapiFinance(z);
    R(".app-open").on("click",
    function() {
        F.tryDirectCall({
            callpagetype: "2",
            symbol: paperCode,
            position: "hq_top"
        })
    });
    var M; (new H).init();
    var q = {
        topBanner: {
            pos: "top_banner",
            androidurl: "apo51.cn.apk"
        },
        bottomBanner: {
            pos: "bottom_banner",
            androidurl: "apo51.cn.apk"
        }
    };
    R("#tbanner, #cnBottomBanner").on("click",
    function() {
        O(q[R(this).data("position")])
    })
} (Zepto),
function(d) {
    function c(a) {
        return this.each(function() {
            var g = d(this),
            e = g.data("InfiniteScroll"),
            f = d.extend({},
            b.DEFAULT, "object" == typeof a && a);
            e || (g.data("infiniteScroll", "mounted"), e = new b(g, f)),
            f.interval && e.infinite()
        })
    }
    var b = function(f, e) {
        this.$elem = f,
        this.options = e,
        this.interval = null,
        this.rendered = !1,
        this.relate = this.$elem.data("relate"),
        d(this.relate).on("click", d.proxy(this.caller, this))
    };
    b.DEFAULT = {
        interval: 8000,
        service: ""
    },
    b.prototype = {
        constructor: b,
        remoteData: function() {
            var a = this;
            d.ajax({
                type: "GET",
                url: this.options.service,
                dataType: "jsonp",
                success: d.proxy(a.render, a),
                error: d.proxy(a.error, a)
            })
        },
        render: function(f) {
            var a = "",
            f = f.result.data;
            f.forEach(function(h, g) {
                a += '<div class="calendar-scroll-item" data-order="@order"><p class="item-title">@country-\u516c\u5e03@title\u524d\u503c@previous\u9884\u6d4b\u503c@median\u516c\u5e03\u503c@ifr_actual</p><div class="clearfix item-msg"><span class="msg-datetime">@datetime </span><span class="msg-mark"><span style="vertical-align: middle">\u91cd\u8981\u6027:</span>@mark</span></div></div>'.replace("@order", g).replace("@title", h.event).replace("@datetime", h.date + " " + h.time).replace("@country", h.country).replace("\u524d\u503c@previous", h.previous ? ": \u524d\u503c" + h.previous: "").replace("\u9884\u6d4b\u503c@median", h.median ? ": \u9884\u6d4b\u503c" + h.median: "").replace("\u516c\u5e03\u503c@ifr_actual", h.ifr_actual ? ": \u516c\u5e03\u503c" + h.ifr_actual: ""),
                "M" === h.importance && (a = a.replace("@mark", '<i class="s1"></i><i class="s1"></i><i class="s0"></i><i class="s0"></i>')),
                "L" === h.importance && (a = a.replace("@mark", '<i class="s1"></i><i class="s0"></i><i class="s0"></i><i class="s0"></i>')),
                "H" === h.importance && (a = a.replace("@mark", '<i class="s1"></i><i class="s1"></i><i class="s1"></i><i class="s0"></i>'))
            }),
            this.$elem.html(a)
        },
        error: function(a) {},
        caller: function() {
            var a = {
                eventid: "hq_center_hs",
                uatrackKey: "hq_center_hs",
                subname: "callup_calendar",
                needOpenSource: !1,
                androidInstallUrl: "apo51.cn.apk"
            };
            new apiFinanceCallUp.CallUpapiFinance(a).tryDirectCall({
                callpagetype: "36",
                position: "callup_calendar"
            })
        },
        next: function() {
            var a = this.$elem;
            a.animate({
                marginTop: "-50px"
            },
            function() {
                a.css("margin-top", 0).children("div").first().appendTo(a)
            })
        },
        infinite: function() { ! this.rendered && this.remoteData(),
            this.rendered = !0,
            this.interval && clearInterval(this.interval),
            this.interval = setInterval(d.proxy(this.next, this), this.options.interval)
        }
    },
    d.fn.InfiniteScroll = c,
    d.fn.InfiniteScroll.Constructor = b,
    d('[data-role="InfiniteScroll"]').each(function() {
        var e = d(this);
        c.call(e, {})
    })
} (Zepto);