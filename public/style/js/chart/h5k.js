xh5_define("datas.k", ["utils.util"],
function(j) {
    var l = j.load,
    e = j.dateUtil,
    a = j.kUtil,
    k = j.xh5_S_KLC_D,
    i = 0 == location.protocol.indexOf("http:");
    return new
    function() {
        this.VER = "2.5.14";
        var K = {
            CN: {
                MINK_URL: "//" + window.location.host + "/api/kline.php?code=$symbol&cb=$cb&scale=$scale&ma=no&datalen=1023",
                DAYK_URL: "//" + window.location.host + "/api/kline.php?code=$symbol&day=$rn",
                DAYK_RE_URL: "",
                RE_VAR: "$symbol$dirfq"
            },
            HK: {
                MINK_URL: "",
                DAYK_URL: "//" + window.location.host + "/api/hkline.php?code=$symbol&day=$rn"
            },
            US: {
                MINK_URL: "//" + window.location.host + "/api/uminkline.php?code=$symbol&callback=$cb&type=$scale&___qn=3",
                DAYK_URL: "//" + window.location.host + "/api/ukline.php?code=$symbol"
            },
            option_cn: {
				MINK_URL: "//" + window.location.host + "/api/",
                DAYK_URL: "//" + window.location.host + "/api/option.php?type=3&symbol=$symbol&cb=$cb"
            },
            op_m: {
                DAYK_URL: "//" + window.location.host + "/futures/api/jsonp.php/$cb/FutureOptionAllService.getOptionDayline?symbol=$symbol"
            },
            forex: {
                DAYK_URL: "//" + window.location.host + "/api/jsonp.php/$cb/NewForexService.getDayKLine?symbol=$symbol&_=$rn",
                MINK_URL: "//" + window.location.host + "/api/jsonp.php/$cb/NewForexService.getMinKline?symbol=$symbol&scale=$scale&datalen=$datalen"
            },
            forex_yt: {
                DAYK_URL: "//" + window.location.host + "/api/jsonp.php/$cb/NewForexService.getDayKLine?symbol=$symbol&_=$rn",
                MINK_URL: "//" + window.location.host + "/api/jsonp.php/$cb/NewForexService.getOldMinKline?symbol=$symbol&scale=$scale&datalen=$datalen"
            },
            OTC: {
                DAYK_URL: "//" + window.location.host + "/thirdmarket/api/jsonp.php/$cb/ThirdDataService.ThirdDailyData?symbol=$symbol&_=$rn"
            },
            CFF: {
                DAYK_URL: "//" + window.location.host + "/api/jsonp.php/$cb/CffexFuturesService.getCffexFuturesDailyKLine?symbol=$symbol&_=$rn",
                MINK_URL: "//" + window.location.host + "/api/jsonp.php/$cb/CffexFuturesService.getCffexFuturesMiniKLine$scalem?symbol=$symbol&_=$rn"
            },
            HF: {
                DAYK_URL: "//" + window.location.host + "/api/hfchart.php?callback=$cb&type=DailyKLine&code=$symbol&_=$rn",
                INIT_URL: "//" + window.location.host + "/api/hfline.php?callback=$cb&market=hf&code=$symbol&category=hf",
                INIT_VAR_PRE: "kke_future_"
            },
            NF: {
                DAYK_URL: "//" + window.location.host + "/api/nfchart.php?type=DailyKLine&_=$rn&code=$symbol&callback=$cb",
                MINK_URL: "//" + window.location.host + "/api/nfchart.php?type=FewMinLine&code=$symbol&interval=$scale&callback=$cb",
                INIT_URL: "//" + window.location.host + "/api/nfline.php?callback=$cb&market=nf&code=$symbol&category=nf",
                INIT_VAR_PRE: "kke_future_"
            },
            global_index: {
                DAYK_URL: "//"+window.location.host+"/api/gbchart.php?callback=$cb&type=kline&code=$symbol&num=100",
                INIT_URL: "//"+window.location.host+"/api/gbchart.php?callback=$cb&type=trend&code=$symbol&category=index",
                INIT_VAR_PRE: "kke_global_index_"
            },
            BTC: {
                DAYK_URL: "//"+window.location.host+"/api/btcchart.php?callback=$cb&type=kline&code=$symbol",
               MINK_URL: "//"+window.location.host+"/api/btcchart.php?type=mink&code=$symbol&scale=$scale&datalen=$datalen&callback=$cb"
            }
        },
        w = function() {
            return {
                msg: "",
                data: null
            }
        },
        p = function(B, z, t) {
            var A = W(t),
            q = t.symbol,
            n = t.newthour,
            L = 1,
            E = A.market;
            "CN" == E && (L = z && /[gz]/.test(z.type) ? 10 : j.isRepos(q) ? 10 : 100),
            B || (B = []);
            var r = 0 / 0,
            x = "";
            if (z && z.date) {
                var J, M = z.date,
                Q = !1;
                B.length > 0 ? (J = B[B.length - 1], M || (M = J.date)) : Q = !0,
                J && ("NF" == E ? e.stbd(J.date, M) ? 1 != z.iscff && z.withNight && z.time >= n ? Q = !0 : z.open && z.price && (J.open = z.open, J.high = z.high, J.low = z.low, J.close = z.price, J.volume = z.totalVolume * L) : M < J.date || (Q = !0) : e.stbd(J.date, M) ? z.date && z.open && z.price && (J.open = z.open, J.high = z.high, J.low = z.low, J.close = z.price, J.volume = z.totalVolume * L, J.date = e.ddt(M)) : M < J.date || (Q = n ? z.time >= n: !0)),
                Q && B.push({
                    open: z.open,
                    high: z.high,
                    low: z.low,
                    close: z.price,
                    volume: z.totalVolume * L,
                    date: e.ddt(M)
                }),
                r = z.issueprice,
                x = z.name
            }
            if (B.length < 1) {
                return [B, void 0, void 0, void 0]
            }
            var O = !isNaN(r) && r > 0 ? r: B[0].open;
            j.oc(B[0], {
                prevclose: O,
                name: x,
                symbol: q
            });
            var G = a.mw(B, z, O, L, A.endDay),
            C = G[0],
            H = G[1],
            P = void 0;
            if (a.pd(B, null), a.pd(C, null), a.pd(H, null), z && z.settlement) {
                var o = B[B.length - 1];
                o.ampP = o.amplitude / z.settlement,
                o.change = o.close - z.settlement,
                o.percent = o.change / z.settlement
            }
            return j.oc(C[0], {
                name: x,
                symbol: q
            }),
            j.oc(H[0], {
                name: x,
                symbol: q
            }),
            t.ytd && (P = a.yd(B), j.oc(P[0], {
                name: x,
                symbol: q
            })),
            [B, C, H, P]
        },
        d = function(n, r, o) {
            var t = j.market(n),
            q = t ? K[t][r ? "MINK_URL": "DAYK_URL"] : null;
            return (i || o) && (q = j.getSUrl(q)),
            q
        },
        S = function(n, r) {
            var o, t, q = j.market(n);
            return K[q] && (o = K[q].DAYK_RE_URL, t = K[q].RE_VAR),
            o && (i || r) && (o = j.getSUrl(o)),
            {
                url: o,
                VAR: t,
                market: q
            }
        },
        y = function(t, q) {
            var n, r, o, x = j.market(t);
            return K[x] && (n = K[x].INIT_URL, r = K[x].INIT_VAR, o = K[x].INIT_VAR_PRE),
            n && (i || q) && (n = j.getSUrl(n)),
            {
                url: n,
                VAR: r,
                varPre: o,
                market: x
            }
        },
        D = {
            xh5Fund: function(M) {
                for (var t, ad, G, q, n = new Date,
                r = [n.getFullYear(), n.getMonth() + 1, n.getDate()].join("_"), V = M.data, T = M.symbol, J = V.split("#"), x = [], ac = [], o = [], H = [], L = [], Q = [], O = J.length; O--;) {
                    q = J[O].split(","),
                    t = q[0].slice(0, 4),
                    ad = q[0].slice(4, 6),
                    G = q[0].slice(6, 8),
                    G = [t, ad, G].join("-"),
                    x.push({
                        d: G,
                        c: q[1]
                    }),
                    ac.push({
                        d: G,
                        c: q[2]
                    }),
                    o.push({
                        d: G,
                        c: q[3]
                    }),
                    H.push({
                        d: G,
                        c: q[4]
                    }),
                    L.push({
                        d: G,
                        c: q[5]
                    }),
                    Q.push({
                        d: G,
                        c: q[6]
                    })
                }
                var z = ["_dwjz_", T, r].join(""),
                B = ["_ljjz_", T, r].join(""),
                E = ["_lshb_", T, r].join(""),
                P = ["_pwbfbyd_", T, r].join(""),
                U = ["_pwbfbjd_", T, r].join(""),
                A = ["_pwbfbnd_", T, r].join(""),
                C = ["_fh_", T, r].join("");
                window[z] = x,
                window[B] = ac,
                window[E] = o,
                window[P] = H,
                window[U] = L,
                window[A] = Q,
                window[C] = {
                    fhday: M.fhday,
                    fhvalue: M.fhvalue,
                    fhchaifen: M.fhchaifen
                }
            }
        },
        c = function(z) {
            var r = [];
            if (z) {
                for (var q, x, n = 0,
                t = z.length; t > n; n++) {
                    x = z[n],
                    q = Number(x.c);
                    var o = x.d.split("-");
                    r.push({
                        close: q,
                        open: Number(x.o) || q,
                        high: Number(x.h) || q,
                        low: Number(x.l) || q,
                        volume: Number(x.v) || 0,
                        date: new Date(Number(o[0]), Number(o[1]) - 1, Number(o[2]), 0)
                    })
                }
            }
            return r
        },
        f = function(z) {
            var r = [];
            if (z) {
                for (var q, x, n = z.split("|"), t = 0, o = n.length; o > t; t++) {
                    q = n[t].split(","),
                    q.length < 5 || (x = q[0].split("-"), r.push({
                        open: Number(q[1]),
                        low: Number(q[2]),
                        high: Number(q[3]),
                        close: Number(q[4]),
                        volume: Number(q[5]),
                        date: new Date(Number(x[0]), Number(x[1]) - 1, Number(x[2]), 0)
                    }))
                }
            }
            return r
        },
        m = function(r) {
            var n = [];
            if (r && r.result && r.result.data) {
                for (var A, q, t = r.result.data,
                o = t.split("|"), z = 0, x = o.length; x > z; z++) {
                    A = o[z].split(","),
                    A.length < 5 || (q = A[0].split("-"), n.push({
                        open: Number(A[1]),
                        low: Number(A[2]),
                        high: Number(A[3]),
                        close: Number(A[4]),
                        volume: Number(A[5]),
                        date: new Date(Number(q[0]), Number(q[1]) - 1, Number(q[2]), 0)
                    }))
                }
            }
            return n
        },
        g = function(x) {
            var n = [];
            if (x && x.length) {
                for (var o, t, r = 0.001,
                q = x.split("|"), B = 0, A = 0, z = q.length; z > A; A++) {
                    o = q[A].split(","),
                    o.length < 5 || (t = o[0].split("-"), B = Number(o[4]) || B, n.push({
                        open: Number(o[1]) || B,
                        low: Number(o[2]) || B,
                        high: Number(o[3]) || B,
                        close: Number(o[4]) || B,
                        volume: Number(o[5]) * r,
                        date: new Date(Number(t[0]), Number(t[1]) - 1, Number(t[2]), 0)
                    }))
                }
            }
            return n
        },
        v = function(z) {
            var r = [];
            if (z) {
                for (var q, x, n, t = 0,
                o = z.length; o > t; t++) {
                    q = z[t],
                    x = q[0].split("-"),
                    n = Number(q[4]),
                    r.push({
                        date: new Date(Number(x[0]), Number(x[1]) - 1, Number(x[2]), 0),
                        open: Number(q[1]) || n,
                        high: Number(q[2]) || n,
                        low: Number(q[3]) || n,
                        close: n,
                        volume: Number(q[5]) || 0
                    })
                }
            }
            return r
        },
        R = function(n) {
            var q = [];
            if (n) {
                for (var t, r, o = n.length; o--;) {
                    t = n[o],
                    r = Number(t[4]),
                    q.push({
                        day: t[0],
                        open: Number(t[1]) || r,
                        high: Number(t[2]) || r,
                        low: Number(t[3]) || r,
                        close: r,
                        volume: Number(t[5]) || 0
                    })
                }
            }
            return q
        },
        b = function(x) {
            var q = [];
            if (x) {
                for (var t, n, r = 0,
                o = x.length; o > r; r++) {
                    t = x[r],
                    n = Number(t.close),
                    q.push({
                        date: e.sd(t.date),
                        volume: Number(t.volume),
                        open: Number(t.open) || n,
                        high: Number(t.high) || n,
                        low: Number(t.low) || n,
                        close: n
                    })
                }
            }
            return q
        },
        h = function(n, q) {
            if (!n) {
                return null
            }
            for (var t, r = q.vu || 1,
            o = 0,
            x = n.length; x > o; o++) {
                t = n[o],
                t.high *= 1,
                t.open *= 1,
                t.low *= 1,
                t.close *= 1,
                t.volume *= r
            }
            return n
        },
        u = function(n) {
            if (!n) {
                return null
            }
            for (var q, r = 0,
            o = n.length; o > r; r++) {
                q = n[r],
                q.high = 1 * q.h,
                q.open = 1 * q.o,
                q.low = 1 * q.l,
                q.close = 1 * q.c,
                q.volume = 1 * q.v,
                q.day = q.d,
                q.date = e.sd(q.d)
            }
            return n
        },
        F = function(n) {
            if (!n) {
                return null
            }
            for (var q, r = 0,
            o = n.length; o > r; r++) {
                q = n[r],
                q.high = 1 * q.h,
                q.open = 1 * q.o,
                q.low = 1 * q.l,
                q.close = 1 * q.c,
                q.volume = 1 * q.v,
                q.date = e.sd(q.d)
            }
            return n
        },
        X = function(E, L, A, x) {
            for (var B, r, q = j.market(x.hqSb), O = "BTC" == q ? 0 : ("DINIW" == x.hqSb, 6), G = L.length; G--&&0 != G;) {
                for (var t = L[G], z = L[G - 1], M = e.ssd(t.day), P = e.ssd(z.day), o = G; P.setMinutes(P.getMinutes() + A) < M;) {
                    if (B = P.getDay(), 6 == B) {
                        if (r = P.getHours(), r >= O) {
                            continue
                        }
                    } else {
                        if (0 == B) {
                            continue
                        }
                        if (1 == B && (r = P.getHours(), O > r)) {
                            continue
                        }
                    }
                    var n = j.clone(z, null);
                    n.day = e.dss(P),
                    L.splice(o++, 0, n)
                }
            }
            for (var C = L[L.length - 1], H = e.ssd(C.day); H.setMinutes(H.getMinutes() + A) < E;) {
                if (B = H.getDay(), 6 == B) {
                    if (r = H.getHours(), r >= O) {
                        continue
                    }
                } else {
                    if (0 == B) {
                        continue
                    }
                    if (1 == B && (r = H.getHours(), O > r)) {
                        continue
                    }
                }
                var J = {
                    open: C.close,
                    high: C.close,
                    low: C.close,
                    close: C.close,
                    day: e.dss(H),
                    prevclose: C.prevclose
                };
                "BTC" == q && (J.volume = 0),
                L.push(J),
                C = J,
                H = e.ssd(C.day)
            }
        },
        Z = function(q, x, t) {
            var G = j.market(t.hqSb),
            o = "BTC" == G ? 0 : ("DINIW" == t.hqSb, 6),
            n = x[x.length - 1].day,
            J = n.split(" ")[0];
            if (e.stbds(q.date, J, null)) {
                var A, r, C, H = q.prevclose,
                z = q.date.getHours();
                if (o > z) {
                    var B, E = !1;
                    for (A = x.length; A--&&(B = !1, C = x[A], r = Number(C.day.split(" ")[1].split(":")[0]), !E && o > r ? B = !0 : r >= o && (E = !0, B = !0), B);) {
                        C.prevclose = H
                    }
                } else {
                    for (A = x.length; A--&&(C = x[A], r = Number(C.day.split(" ")[1].split(":")[0]), r >= o);) {
                        C.prevclose = H
                    }
                }
            }
        },
        N = function(r, x) {
            if (!r) {
                return null
            }
            var q, C, o = Number(x.scale),
            n = j.market(x.hqSb);
            x.hqObjs && (q = x.hqObjs[x.hqSb], C = new Date(1000 * x.hqObjs[x.withsymbol].hqstr)),
            C || (C = new Date);
            var G = 60 * C.getTimezoneOffset() * 1000;
            C.setTime(C.getTime() + G),
            C.setHours(C.getHours() + 8);
            for (var B, t, A = 0,
            E = r.length; E > A; A++) {
                if (t = r[A], t.high = 1 * t.h, t.open = 1 * t.o, t.low = 1 * t.l, t.close = 1 * t.c, "BTC" == n && (t.volume = 1 * t.v), o > 1) {
                    var z = e.ssd(t.d);
                    z.setMinutes(z.getMinutes() + o),
                    t.day = e.dss(z)
                } else {
                    t.day = t.d,
                    isNaN(t.p) || (B = t.p),
                    isNaN(B) && (B = t.o),
                    t.prevclose = 1 * B
                }
            }
            return X(C, r, o, x),
            1 == o && q && Z(q, r, x),
            r
        },
        Y = function(n, o) {
            return n && n.result && n.result.data ? (n = n.result.data, N(n, o)) : null
        },
        W = function(r) {
            var A, x = r.symbol,
            q = r.volunit || 1,
            C = j.market(x),
            o = !1;
            r.dataurl && r.dataurl.length > 1 ? A = r.dataurl: (A = d(x, !!r.ismink, r.ssl), /^(CN|HK|US)/.test(C) && (o = !0));
            var G, B, t, n = x,
            E = x;
            switch (C) {
            case "HK":
                n = 0 == x.indexOf("rt_") ? x: "rt_" + x,
                E = n.substring(5);
                break;
            case "US":
                n = 0 == x.indexOf("gb_") ? x: "gb_" + x,
                E = n.split("_")[1],
                E = E.replace("$", "."),
                E = E.toUpperCase(),
                G = u;
                break;
            case "op_m":
                E = n.replace("P_OP_", "");
                break;
            case "CN":
                q = 0.01;
                break;
            case "forex":
            case "forex_yt":
                G = N,
                B = f,
                t = 5;
                break;
            case "BTC":
                E = n.replace("btc_", ""),
                G = Y,
                B = m,
                t = 5;
                break;
            case "OTC":
                E = x.replace("sb", "otc_"),
                B = g;
                break;
            case "CFF":
                var z = n.split("_");
                E = z[z.length - 1],
                B = v,
                G = R;
                break;
            case "HF":
                n = 0 == x.indexOf("hf_") ? x: "hf_" + x,
                E = n.split("_")[1],
                B = b;
                break;
            case "NF":
                n = 0 == x.indexOf("nf_") ? x: "nf_" + x,
                E = n.split("_")[1],
                B = c,
                G = u;
                break;
            case "global_index":
                n = 0 == x.indexOf("znb_") ? x: "znb_" + x,
                E = n.split("_")[1],
                B = F
            }
            return r.customksb && (E = r.customksb),
            {
                hqSb: n,
                kSb: E,
                dayDataHandler: B,
                minDataHandler: G,
                endDay: t,
                kUrl: A,
                isCompressData: o,
                vu: q,
                market: C
            }
        },
        s = function(A, q) {
            var B = W(A),
            r = new Date,
            n = [r.getFullYear(), r.getMonth() + 1, r.getDate()].join("_"),
            C = A.scale,
            x = A.$scale || "$scale",
            t = A.datalen || 828,
            o = "_" + B.kSb.replace(/\W/g, "") + "_" + C + "_" + r.getTime(),
            z = function(E) {
                var G = E ? E.dataObj: void 0,
                H = w();
                l(B.kUrl.replace("$symbol", B.kSb).replace(x, C).replace("$cb", "var%20" + o + "=").replace("$rn", n).replace("$datalen", t),
                function() {
                    var M = window[o],
                    L = A.dataformatter || B.minDataHandler || h;
                    if (M = L(M, {
                        vu: B.vu,
                        withsymbol: A.withsymbol,
                        hqSb: B.hqSb,
                        hqObjs: G,
                        scale: C
                    })) {
                        var J = {};
                        1 == C && (/^forex/.test(B.market) || /^BTC/.test(B.market)) && (J.usePc = !0),
                        a.pd(M, J),
                        H.data = M
                    } else {
                        H.msg = "error"
                    }
                    j.isFunc(q) && q(H)
                },
                function() {
                    H.msg = "error",
                    j.isFunc(q) && q(H)
                },
                {
                    market: B.market,
                    symbol: B.hqSb,
                    type: "mink"
                })
            };
            A.withsymbol ? KKE.api("datas.hq.get", {
                symbol: [A.withsymbol, B.hqSb].join(","),
                cancelEtag: !0,
                ssl: A.ssl
            },
            z) : z()
        },
        aa = function(n, r) {
            var o = W(n),
            q = function(C) {
                var z = C ? C.data[0] : void 0,
                t = w(),
                x = new Date,
                B = [x.getFullYear(), x.getMonth() + 1, x.getDate()].join("_"),
                A = "_" + o.kSb.replace(/\W/g, "") + B;
                l(o.kUrl.replace("$symbol", o.kSb).replace("$rn", B).replace("$cb", "var%20" + A + "="),
                function() {
                    var E;
                    if (o.isCompressData) {
                        var J = o.kSb.replace(".", "$");
                        E = window["KLC_KL_" + J],
                        E = k(E)
                    } else {
                        E = window[A];
                        var G = n.dataformatter || o.dayDataHandler || c;
                        E = G(E)
                    }
                    var H = p(E, z, n);
                    H ? t.data = {
                        hq: z,
                        day: H[0],
                        week: H[1],
                        month: H[2],
                        ytd: H[3] || null
                    }: t.msg = "error",
                    j.isFunc(r) && r(t)
                },
                function() {
                    if (z) {
                        var E = p(null, z, n);
                        E ? t.data = {
                            hq: z,
                            day: E[0],
                            week: E[1],
                            month: E[2],
                            ytd: E[3] || null
                        }: t.msg = "error",
                        j.isFunc(r) && r(t)
                    } else {
                        t.msg = "error",
                        t.data = {
                            hq: z
                        },
                        j.isFunc(r) && r(t)
                    }
                },
                {
                    market: o.market,
                    symbol: o.hqSb,
                    type: "k"
                })
            };
            "undefined" == typeof o.market || "UNKNOWN" === o.market ? q() : KKE.api("datas.hq.get", {
                symbol: o.hqSb,
                cancelEtag: !0,
                withI: !0,
                ssl: n.ssl
            },
            q)
        },
        I = function(r, t) {
            var o = r.staticdata,
            n = w();
            if (r.ismink) {
                a.pd(o, null),
                n.data = o
            } else {
                var q = p(o, null, r);
                n.data = {
                    day: q[0],
                    week: q[1],
                    month: q[2],
                    ytd: q[3] || null
                }
            }
            j.isFunc(t) && t(n)
        };
        this.get = function(o, n) {
            o.staticdata ? I(o, n) : (o.wfn && j.isFunc(D[o.wfn]) && (window[o.wfn] = D[o.wfn]), o.ismink ? s(o, n) : aa(o, n))
        },
        this.loadReData = function(A, x) {
            var q = w(),
            B = A.symbol,
            t = S(B, A.ssl),
            r = t.url;
            if (!r) {
                return q.msg = "error",
                void(j.isFunc(x) && x(q))
            }
            var n = A.dir,
            z = t.VAR || "";
            z = z.replace("$symbol", B).replace("$dir", n);
            var o = new Date,
            C = o.getHours();
            l(r.replace("$symbol", B).replace("$dir", n).replace("$rn", C),
            function() {
                var E = window[z];
                window[z] = null,
                E && E[0].total > 0 ? q.data = E[0].data: q.msg = "error",
                j.isFunc(x) && x(q)
            },
            function() {
                q.msg = "error",
                j.isFunc(x) && x(q)
            },
            {
                market: t.market,
                symbol: B,
                type: "rek"
            })
        },
        this.loadHFInit = function(A, n) {
            var r = w(),
            o = A.symbol,
            x = y(o, A.ssl),
            z = x.url,
            t = x.varPre,
            B = t + o,
            q = window[B];
            q ? (r.data = q, j.isFunc(n) && n(r)) : (o = o.split("hf_")[1], l(z.replace("$cb", "var%20" + B + "=").replace("$symbol", o),
            function() {
                q = window[B],
                q ? r.data = q: (window[B] = null, r.msg = "error, illegal data"),
                j.isFunc(n) && n(r)
            },
            function() {
                r.msg = "error",
                j.isFunc(n) && n(r)
            },
            {
                market: x.market,
                symbol: o,
                type: "init_hf"
            }))
        },
        this.loadNFInit = function(A, n) {
            var r = w(),
            o = A.symbol,
            x = y(o, A.ssl),
            z = x.url,
            t = x.varPre,
            B = t + o,
            q = window[B];
            q ? (r.data = q, j.isFunc(n) && n(r)) : (o = o.match(/^nf_([a-zA-Z]+)\d+$/)[1], l(z.replace("$cb", "var%20" + B + "=").replace("$symbol", o),
            function() {
                q = window[B],
                q ? r.data = q: (window[B] = null, r.msg = "error, illegal data"),
                j.isFunc(n) && n(r)
            },
            function() {
                r.msg = "error",
                j.isFunc(n) && n(r)
            },
            {
                market: x.market,
                symbol: o,
                type: "init_nf"
            }))
        },
        this.loadGBInit = function(A, n) {
            var r = w(),
            o = A.symbol,
            x = y(o, A.ssl),
            z = x.url,
            t = x.varPre,
            B = t + o,
            q = window[B];
            q ? (r.data = q, j.isFunc(n) && n(r)) : (o = o.split("znb_")[1], l(z.replace("$cb", "var%20" + B + "=").replace("$symbol", o),
            function() {
                q = window[B],
                q ? r.data = q: (window[B] = null, r.msg = "error, illegal data"),
                j.isFunc(n) && n(r)
            },
            function() {
                r.msg = "error",
                j.isFunc(n) && n(r)
            },
            {
                market: x.market,
                symbol: o,
                type: "init_global"
            }))
        }
    }
});
xh5_define("chart.h5k", ["cfgs.settinger", "utils.util", "utils.painter"],
function(f, y, r) {
    function b(P) {
        function R(aw, aB) {
            function az(ag) {
                aH.setDataRange(ag),
                aE && (aE.linkData(ag), aE.setDataRange()),
                aG && (aG.linkData(ag), aG.setDataRange()),
                ad && (ad.linkData(ag), ad.setDataRange())
            }
            function aA(ah, al) {
                var aj, ag, am = Z.get(v.URLHASH.KD),
                ak = am.length;
                ah || (aj = 0),
                al || (ag = ak - 1);
                for (var ai = 0; ak > ai && (isNaN(aj) && am[ai].date >= ah && (aj = ai), isNaN(ag) && am[ai].date >= al && (ag = ai), isNaN(aj) || isNaN(ag)); ai++) {}
                return [aj, ag]
            }
            function af() {
                aB && (M = Z),
                X.uUpdate(null, !0),
                "CN" !== aD || /^(sh0|sh1|sh5|sz1|sz399)\d+/i.test(aw.symbol) || Z.initExtraData()
            }
            aw = p({
                symbol: void 0,
                datas: {
                    day: {
                        wfn: void 0,
                        url: void 0,
                        dataformatter: void 0,
                        staticdata: void 0
                    },
                    min: {
                        wfn: void 0,
                        url: void 0,
                        dataformatter: void 0,
                        staticdata: void 0
                    }
                }
            },
            aw || {});
            var ay = this,
            aD = y.market(aw.symbol),
            ax = !0;
            this.isErr = !1,
            this.symbol = aw.symbol,
            this.market = aD;
            var ae;
            switch (aD) {
            case "forex":
            case "forex_yt":
                "DINIW" == this.symbol,
                ae = "06:00";
                break;
            case "BTC":
                ae = "00:00";
                break;
            default:
                ae = "09:30"
            }
            this.isMain = aB,
            this.isCompare = !1,
            this.datas = null,
            this.dataLen = 0,
            this.nfloat = aw.nfloat || 2,
            this.dataLenOffset = 0,
            this.prevclose = 0 / 0,
            this.labelMaxP = 0,
            this.labelMinP = Number.MAX_VALUE,
            this.maxPrice = 0,
            this.minPrice = Number.MAX_VALUE,
            this.rangeMax = 0,
            this.rangeMin = Number.MAX_VALUE,
            this.labelMaxVol = 0,
            this.maxVolume = 0,
            this.minPercent = Number.MAX_VALUE,
            this.maxPercent = -Number.MAX_VALUE,
            this.labelPriceCount = 0 / 0,
            this.isTotalRedraw = !0,
            this.hq = void 0,
            this.nco = void 0;
            var aE, aG, ad, aF = new W(this, aw),
            aC = aw.name;
            this.getName = function() {
                return aC || ""
            },
            this.viewState = E;
            var Z = new
            function() {
                var ak, ah = {},
                ai = {
                    rsAmount: void 0
                },
                aj = function(an, at, ap, aq, ao) {
                    if (at) {
                        if (aB) {
                            if (an == v.URLHASH.KD && (ak = y.clone(at, null)), aq && window.datelist && ay.hq) {
                                var al = y.xh5_S_KLC_D(window.datelist);
                                at = y.kUtil.ayd(at, al, !1, at[0].date, ay.hq.date)
                            }
                        } else {
                            ao || (an == v.URLHASH.KD && (ak = y.clone(at, null)), at = y.kUtil.adbd(at, M.get(an), ap, !1))
                        }
                        ah["k" + an] = at;
                        var am = at.length,
                        ar = aq ? C.PARAM.K_CL_NUM: C.PARAM.defaultCandleNum;
                        ah["k" + an + "v"] = am > ar ? am - ar: 0,
                        ah["k" + an + "b"] = am
                    }
                },
                ag = function() {
                    var al = E.viewId;
                    switch (al) {
                    case v.URLHASH.KDF:
                    case v.URLHASH.KDB:
                        al = v.URLHASH.KD;
                        break;
                    case v.URLHASH.KWF:
                    case v.URLHASH.KWB:
                        al = v.URLHASH.KW;
                        break;
                    case v.URLHASH.KMF:
                    case v.URLHASH.KMB:
                        al = v.URLHASH.KM;
                        break;
                    case v.URLHASH.KCLF:
                    case v.URLHASH.KCLB:
                        al = v.URLHASH.KCL
                    }
                    return al
                };
                this.get = function(al) {
                    if (y.isStr(al)) {
                        var am = ag();
                        return ah["k" + am + al]
                    }
                    return ah["k" + (al || E.viewId)]
                },
                this.set = function(an, ao) {
                    var am = ag(),
                    al = "k" + am + an;
                    "undefined" != typeof ah[al] && (ah[al] = ao)
                },
                this.getOriDK = function() {
                    return ak
                },
                this.initState = aj,
                this.initDWMState = function(an, am) {
                    var al = y.clone(am.day, null);
                    aj(v.URLHASH.KD, am.day),
                    aj(v.URLHASH.KW, am.week),
                    aj(v.URLHASH.KM, am.month),
                    aj(v.URLHASH.KCL, al, !1, !0)
                },
                this.extraDataObj = ai,
                this.initExtraData = function() {
                    var al = "//" + window.location.host + "/api/getamount.php?code=$symbol&cb=$cb&rn=$rn&ma=no&datalen=1023";
                    P.ssl && (al = y.getSUrl(al));
                    var am = "KKE_ShareAmount_" + aw.symbol;
                    y.load(al.replace("$symbol", aw.symbol).replace("$rn", String((new Date).getDate())).replace("$cb", "var%20" + am + "="),
                    function() {
                        var ap = window[am];
                        if (ap) {
                            for (var aq, an = [], ao = ap.length; ao--;) {
                                aq = ap[ao],
                                an.push({
                                    amount: Number(aq.amount),
                                    date: t.sd(aq.date)
                                })
                            }
                            an.length && (ai.rsAmount = an)
                        }
                    })
                },
                this.gc = function() {
                    ah = null,
                    ai = null
                }
            },
            aH = new
            function() {
                var ag = function() {
                    ay.minPrice = Number.MAX_VALUE,
                    ay.maxPrice = 0,
                    ay.minPercent = Number.MAX_VALUE,
                    ay.maxPercent = -Number.MAX_VALUE,
                    ay.maxVolume = 0,
                    ay.rangeMax = 0,
                    ay.rangeMin = Number.MAX_VALUE
                },
                ah = function() {
                    for (var aj, ak = 0,
                    ai = ay.dataLen; ai > ak; ak++) {
                        aj = ay.datas[ak],
                        aj.close <= 0 || (aj.high > ay.maxPrice && (ay.maxPrice = ay.rangeMax = aj.high), aj.low < ay.minPrice && (ay.minPrice = ay.rangeMin = aj.low), ay.maxVolume = Math.max(ay.maxVolume, aj.volume))
                    }
                    var al = n(ay.maxVolume, 0, 0, !0);
                    ay.labelMaxVol = al[0],
                    ay.maxPercent = Math.max((ay.maxPrice - ay.prevclose) / ay.prevclose, 0),
                    ay.minPercent = Math.min((ay.minPrice - ay.prevclose) / ay.prevclose, 0)
                };
                this.createPlayingData = function() {
                    var ap, al, au = C.DIMENSION.h_k,
                    an = au * C.DIMENSION.P_HV,
                    aq = au * (1 - C.DIMENSION.P_HV);
                    ap = ay.labelMinP,
                    al = ay.labelMaxP;
                    for (var ai, aj = ay.labelMaxVol,
                    ak = ay.prevclose,
                    ar = ay.isTotalRedraw ? 0 : ay.dataLen - ay.dataLenOffset, ao = C.custom.show_underlay_vol, am = ay.isCompare ? "ppp": "pp", at = ay.dataLen; at > ar; ar++) {
                        ai = ay.datas[ar],
                        ai.cy = e[am](ai.close, ap, al, au, ak),
                        ai.oy = e[am](ai.open, ap, al, au, ak),
                        ai.hy = e[am](ai.high, ap, al, au, ak),
                        ai.ly = e[am](ai.low, ap, al, au, ak),
                        ao && (ai.vy = e.vp(ai.volume, aj, an) + aq)
                    }
                },
                this.setDataRange = function(al) {
                    var am = Z.get();
                    if (am) {
                        E.dataLength = am.length;
                        var ai = E.start,
                        aj = E.end;
                        if (isNaN(ai) || isNaN(aj)) {
                            aj = Z.get("b"),
                            ai = Z.get("v"),
                            E.start = ai,
                            E.end = aj
                        } else {
                            if (al && aj + 1 >= am.length) {
                                var ak = am.length - aj;
                                E.end = aj = am.length,
                                (1 == P.pcm || E.viewId == v.URLHASH.K1) && (0 == ai && aj > 1 && aj < C.PARAM.minCandleNum && (ai = aj - 1, E.start = ai), aj - ai >= C.PARAM.defaultCandleNum && (ai += ak, E.start = ai))
                            }
                            Z.set("v", ai),
                            Z.set("b", aj)
                        }
                        switch (E.currentLength = aj - ai, E.startDate = am[ai].date, E.endDate = am[aj - 1].date, P.pcm) {
                        case 1:
                            ay.prevclose = am[0].prevclose;
                            break;
                        case 2:
                            ay.prevclose = am[ai].close;
                            break;
                        default:
                            ay.prevclose = ai > 1 ? am[ai - 1].close: am[0].prevclose || am[0].close
                        }
                        ay.datas = am.slice(ai, aj),
                        ay.dataLen = ay.datas.length,
                        ag(),
                        ah(al)
                    }
                }
            },
            X = new
            function() {
                var aj, al = function(am) {
                    return aj ? (am.volume = am.totalVolume - (aj.totalVolume || 0), am.amount = am.volume * am.price) : (aj = {},
                    am.volume = 0),
                    aj.totalVolume = am.totalVolume,
                    am.avg_price = am.totalAmount / am.totalVolume || am.price,
                    !0
                },
                ag = !1,
                ah = function(aq, au, an) {
                    if (aq.isUpdateTime) {
                        var ar = Z.get(au);
                        if (ar && !(ar.length < 1)) {
                            var av = au == v.URLHASH.KD || au == v.URLHASH.KDF || au == v.URLHASH.KCL || au == v.URLHASH.KCLF,
                            aK = ar[ar.length - 1];
                            if (1 == an) {
                                if (aK.time && !y.kUtil.spk(aK.time, aq.time, ae, au, ay.market)) {
                                    if (y.kUtil.nc(ar, aq, au, {
                                        price: aq.price,
                                        volume: aq.volume
                                    }), /^forex|^BTC/.test(ay.market)) {
                                        au == v.URLHASH.K1 && (aK = ar[ar.length - 1], aK.prevclose = aq.prevclose, aK.change = aq.price - aq.prevclose, aK.percent = aK.change / aq.prevclose)
                                    } else {
                                        if ("NF" == ay.market) {} else {
                                            if (y.kUtil.spk("09:35", aq.time, ae, au)) {
                                                if (au == v.URLHASH.K60) {
                                                    var at = aq.time.split(":"),
                                                    ao = at[0],
                                                    ap = at[1];
                                                    if (ao > 10 || 10 == ao && ap > 30) {
                                                        return
                                                    }
                                                }
                                                aK = ar[ar.length - 1],
                                                aK.open = aq.open,
                                                aK.open > aK.high && (aK.high = aK.open),
                                                aK.open < aK.low && (aK.low = aK.open)
                                            }
                                        }
                                    }
                                    return
                                }
                            } else {
                                if (2 == an) {
                                    if (!aq.trstr) {
                                        return
                                    }
                                    y.kUtil.nc(ar, aq, au, {
                                        price: aq.price,
                                        volume: 0
                                    })
                                } else {
                                    if (g(aq.date, aK.date)) {
                                        ay.nco && ("NF" == ay.market ? t.dst(aK.date) < ay.nco.open && aq.time >= ay.nco.open && aq.time > ay.nco.close && y.kUtil.nc(ar, aq, au, null) : ag && aq.time >= ay.nco.open && (ag = !1, y.kUtil.nc(ar, aq, au, null)))
                                    } else {
                                        if (! (aq.date > aK.date)) {
                                            return
                                        }
                                        ay.nco ? "NF" == ay.market ? aq.time >= ay.nco.open && y.kUtil.nc(ar, aq, au, null) : aq.time <= ay.nco.close && (ag = !0) : y.kUtil.nc(ar, aq, au, null)
                                    }
                                }
                            }
                            aK = ar[ar.length - 1],
                            aK.close = aq.price,
                            aK.date = t.ddt(aq.date),
                            aK.day = t.ds(aK.date, "/"),
                            au == v.URLHASH.KMS ? (aK.volume = aq.trvolume || 0, aK.amount = aq.tramount || 0, aK.trbs = aq.trbs, aK.kke_cs = 0 == aq.trbs ? -1 : 1) : (av ? (aK.open = aq.open, aK.high = aq.high, aK.low = aq.low, aK.volume = aq.totalVolume) : isNaN(aK.volume) ? aK.volume = aq.volume: aK.volume += Number(aq.volume), aK.kke_cs = aK.close > aK.open ? 1 : aK.open > aK.close ? -1 : 0);
                            var am;
                            1 == ar.length ? am = av ? aq.prevclose: aK.open: (am = ar[ar.length - 2].close, aq.settlement && av && (am = aq.settlement)),
                            /^forex|^BTC/.test(ay.market) && (au == v.URLHASH.K1 || au == v.URLHASH.KD) && (am = aq.prevclose),
                            aK.change = aq.price - am,
                            aK.percent = aK.change / am,
                            aq.price > aK.high && (aK.high = aq.price),
                            aq.price < aK.low && (aK.low = aq.price),
                            aK.amplitude = aK.high - aK.low,
                            aK.ampP = aK.amplitude / am,
                            aK.time = aq.time
                        }
                    }
                },
                ai = function(am) {
                    ah(am, v.URLHASH.KD, 0),
                    ah(am, v.URLHASH.KW, 0),
                    ah(am, v.URLHASH.KM, 0),
                    ah(am, v.URLHASH.KDF, 0),
                    ah(am, v.URLHASH.KWF, 0),
                    ah(am, v.URLHASH.KMF, 0),
                    ah(am, v.URLHASH.KCL, 0),
                    ah(am, v.URLHASH.KCLF, 0),
                    ah(am, v.URLHASH.K1, 1),
                    ah(am, v.URLHASH.K5, 1),
                    ah(am, v.URLHASH.K15, 1),
                    ah(am, v.URLHASH.K30, 1),
                    ah(am, v.URLHASH.K60, 1),
                    ah(am, v.URLHASH.K240, 1),
                    ah(am, v.URLHASH.KMS, 2)
                },
                ak = new
                function() {
                    this.check = function(an) {
                        if (aB) {
                            return ! 0
                        }
                        var ap = E.viewId,
                        ao = M.get(ap);
                        if (!ao || ao.length < 1) {
                            return ! 1
                        }
                        var am = ao[ao.length - 1];
                        if (an.date > am.date) {
                            if ("mink" == v.URLHASH.gt(E.viewId).type) {
                                if (!y.kUtil.spk(am.time, an.time, "00:00", ap, ay.market)) {
                                    return ! 1
                                }
                            } else {
                                if (!g(an.date, am.date)) {
                                    return ! 1
                                }
                            }
                        }
                        return ! 0
                    }
                };
                this.uUpdate = function(am, an, ao, aq) {
                    var ap, ar = {
                        symbol: aw.symbol,
                        ssl: P.ssl
                    };
                    ao ? (ap = "datas.hq.parse", ar.hqStr = ao, ar.market = aq) : (ap = "datas.hq.get", ar.delay = !0, ar.cancelEtag = an),
                    KKE.api(ap, ar,
                    function(au) {
                        var at = au.dataObj[aw.symbol];
                        if (at && at.date && al(at)) {
                            if (aC = aC || at.name || "", !ak.check(at)) {
                                return
                            }
                            ay.hq = at,
                            ai(at),
                            az(!0),
                            y.isFunc(am) && am()
                        }
                    })
                }
            },
            aa = new
            function() {
                var ap, ah = function(at, ar) {
                    K.re(v.e.K_DATA_LOADED, ar),
                    y.isFunc(at) && at()
                },
                aj = function(aM) {
                    if (!ay.hq || !ay.hq.date) {
                        return null
                    }
                    for (var aN = t.ddt(ay.hq.date), au = "_" + t.ds(aN, "_"), at = !0; ! Number(aM[au]);) {
                        at = !1;
                        var ar = aN.getDate();
                        aN.setDate(--ar),
                        au = "_" + t.ds(aN, "_")
                    }
                    var av = Number(aM[au]);
                    return {
                        factor: av,
                        isToday: at
                    }
                },
                ai = function(au, bk, a4, a8) {
                    if (au) {
                        var a9, ba, a6, ar, at, bb, a7, av, bc, a3, bl, be, bh = -828 == au,
                        bj = Z.getOriDK();
                        if ("q" == a8) {
                            if (ba = v.URLHASH.KDF, Z.initState(ba, y.clone(bj, null), !1, !1, !0), a9 = Z.get(ba), be = a9.length, !bh) {
                                var a5 = (bk ? ay.hq.price: ay.hq.prevclose) / au;
                                for (a3 = 0; be > a3; a3++) {
                                    a7 = a9[a3],
                                    av = "_" + t.ds(a7.date, "_"),
                                    bc = Number(a4[av]);
                                    var bg = a7.close;
                                    isNaN(bc) ? bc = bg / a5: a7.close = a5 * bc,
                                    bl = a7.close / bg,
                                    a7.high = a7.high * bl,
                                    a7.low = a7.low * bl,
                                    a7.open = a7.open * bl,
                                    0 == a3 && (bb = a7.prevclose, isNaN(bb) || 0 >= bb ? bb = a7.open: (bb = a7.prevclose * bl, a7.prevclose = bb)),
                                    a7.amplitude = a7.high - a7.low,
                                    a7.ampP = a7.amplitude / bb,
                                    a7.change = a7.close - bb,
                                    a7.percent = a7.change / bb,
                                    bb = a7.close
                                }
                            }
                        } else {
                            if (ba = v.URLHASH.KDB, Z.initState(ba, y.clone(bj, null), !1, !1, !0), a9 = Z.get(ba), be = a9.length, !bh) {
                                for (a3 = 0; be > a3; a3++) {
                                    if (a7 = a9[a3], av = "_" + t.ds(a7.date, "_"), bc = Number(a4[av]), isNaN(bc)) {
                                        if (0 >= a3) {
                                            continue
                                        }
                                        var bi = a9[a3 - 1];
                                        bc = a7.percent * bi.close + bi.close
                                    }
                                    bl = bc / a7.close,
                                    a7.close = bc,
                                    a7.high = a7.high * bl,
                                    a7.low = a7.low * bl,
                                    a7.open = a7.open * bl,
                                    0 == a3 && (bb = a7.prevclose, isNaN(bb) || 0 >= bb ? bb = a7.open: (bb = a7.prevclose * bl, a7.prevclose = bb)),
                                    a7.amplitude = a7.high - a7.low,
                                    a7.ampP = a7.amplitude / bb,
                                    a7.change = a7.close - bb,
                                    a7.percent = a7.change / bb,
                                    bb = a7.close
                                }
                            }
                        }
                        var bd;
                        1 == be && (a7 = a9[be - 1], bd = {
                            open: a7.open,
                            high: a7.high,
                            low: a7.low,
                            close: a7.close,
                            price: a7.close,
                            volume: a7.volume,
                            totalVolume: a7.volume,
                            date: t.dd(a7.date)
                        }),
                        a6 = y.kUtil.mw(a9, bd, null, null, 0 / 0),
                        at = a6[0],
                        ar = a6[1],
                        y.kUtil.pd(at, null),
                        y.kUtil.pd(ar, null),
                        Z.initState(v.URLHASH["q" == a8 ? "KWF": "KWB"], at),
                        Z.initState(v.URLHASH["q" == a8 ? "KMF": "KMB"], ar);
                        var bf = y.clone(a9, null);
                        Z.initState(v.URLHASH["q" == a8 ? "KCLF": "KCLB"], bf, !1, !0),
                        aB || Z.initState(ba, a9)
                    }
                },
                aq = function(av) {
                    var au = v.URLHASH.gt(E.viewId),
                    ar = au.dir,
                    at = {
                        symbol: aw.symbol,
                        dir: ar,
                        ssl: P.ssl
                    };
                    z.show(),
                    KKE.api("datas.k.loadReData", at,
                    function(aO) {
                        z.hide();
                        var aN = !0,
                        aP = aO.data;
                        if (aP) {
                            var aJ = aj(aP);
                            aJ && (aN = !1, ai(aJ.factor, aJ.isToday, aP, ar))
                        }
                        aN && ai( - 828, !1, null, ar),
                        ah(av, {
                            viewId: E.viewId
                        })
                    })
                },
                am = function(av, at) {
                    var au = v.URLHASH.gt(ap),
                    ar = "mink" == au.type ? Z.initState: Z.initDWMState;
                    z.show(),
                    KKE.api("datas.k.get", av,
                    function(aN) {
                        z.hide();
                        var aO = ap;
                        if (ap = 0 / 0, "error" == aN.msg) {
                            if (ay.isErr = !0, aB) {
                                if (aN.data && aN.data.hq) {
                                    var aM;
                                    if (aN.data.hq.status) {
                                        switch (aN.data.hq.status) {
                                        case 2:
                                            aM = v.notlisted;
                                            break;
                                        case 3:
                                            aM = v.delisted
                                        }
                                    } else {
                                        aM = v.norecord
                                    }
                                    aM && ab.showTip({
                                        txt: aM,
                                        parent: B,
                                        noBtn: !0
                                    })
                                } else {
                                    ab.showTip({
                                        txt: v.nodata,
                                        parent: B
                                    })
                                }
                            }
                        } else {
                            aN.data.hq && (ay.hq = aN.data.hq),
                            ar(au.baseid, aN.data, av.ismink)
                        }
                        ah(at, {
                            viewId: aO
                        })
                    })
                },
                an = function(ar) {
                    KKE.api("datas.hq.get", {
                        symbol: aw.symbol,
                        cancelEtag: !0,
                        ssl: P.ssl
                    },
                    function(av) {
                        var au = av.dataObj[aw.symbol],
                        at = [{
                            close: au.price,
                            open: au.open,
                            high: au.high,
                            low: au.low,
                            volume: 0,
                            prevclose: au.prevclose,
                            amplitude: au.high - au.low,
                            ampP: (au.high - au.low) / au.prevclose,
                            change: au.price - au.prevclose,
                            date: au.date,
                            day: t.ds(au.date, "/"),
                            time: au.time,
                            percent: au.price - au.prevclose / au.prevclose,
                            kke_cs: 0
                        }];
                        Z.initState(E.viewId, at, !0),
                        ah(ar, {
                            viewId: E.viewId
                        })
                    })
                },
                ak = function(aR) {
                    var au, ar, av = E.viewId,
                    aP = v.URLHASH.gt(av);
                    if (ay.nco && ay.nco.open) {
                        ar = ay.nco.open,
                        ae = ar
                    } else {
                        var aQ = new Date,
                        at = ae.split(":");
                        aQ.setHours(at[0], at[1], 0),
                        aQ.setMinutes(aQ.getMinutes() - 30),
                        ar = t.dst(aQ)
                    }
                    var aO = {
                        symbol: aw.symbol,
                        newthour: ar,
                        ssl: P.ssl
                    };
                    if ("mink" == aP.type) {
                        if (au = aw.datas.min, aO.ismink = !0, aO.scale = av, /^forex|^BTC/.test(ay.market)) {
                            switch (aO.withsymbol = "sys_time", av) {
                            case v.URLHASH.K1:
                                aO.datalen = 1440;
                                break;
                            case v.URLHASH.K240:
                                aO.datalen = parseInt(60 / av * 24 * 10);
                                break;
                            default:
                                aO.datalen = parseInt(60 / av * 24 * 5)
                            }
                        }
                    } else {
                        au = aw.datas.day
                    }
                    aO.dataurl = au.url,
                    aO.dataformatter = au.dataformatter,
                    aO.wfn = au.wfn,
                    aO.staticdata = au.staticdata,
                    am(aO, aR)
                },
                ag = function(ar) {
                    var au = {
                        symbol: aw.symbol,
                        ssl: P.ssl
                    },
                    at = "datas.k.";
                    at += "loadGBInit",
                    ay.nco = {
                        open: "15:00",
                        close: "23:30"
                    },
                    KKE.api(at, au,
                    function(aM) {
                        var aL = aM.data;
                        if (aL) {
                            var av = aL.time;
                            av && av.length > 0 && (ay.nco.open = av[0][0] || ay.nco.open, ay.nco.close = av[av.length - 1][1] || ay.nco.close)
                        }
                        ak(ar)
                    })
                },
                ao = function(ar, au) {
                    var at = {
                        symbol: aw.symbol,
                        ssl: P.ssl
                    },
                    av = "datas.k.";
                    au ? (av += "loadNFInit", ay.nco = {
                        open: "09:00",
                        close: "15:00"
                    }) : (av += "loadHFInit", ay.nco = {
                        open: "06:00",
                        close: "05:59"
                    }),
                    KKE.api(av, at,
                    function(aN) {
                        var aM = aN.data;
                        if (aM) {
                            var aJ = aM.time;
                            aJ && aJ.length > 0 && (ay.nco.open = aJ[0][0] || ay.nco.open, ay.nco.close = aJ[aJ.length - 1][1] || ay.nco.close)
                        }
                        ak(ar)
                    })
                },
                al = function(av, aL) {
                    var au = new Date,
                    at = ae.split(":");
                    au.setHours(at[0], at[1], 0),
                    au.setMinutes(au.getMinutes() - 1);
                    var ar = t.dst(au);
                    ay.nco = {
                        open: ae,
                        close: ar
                    },
                    "rek" == aL.type && Z.get(v.URLHASH.KD) ? aq(av) : ak(av)
                };
                this.iInit = function(at) {
                    var au = E.viewId;
                    if (ap != au) {
                        ap = au;
                        var ar = v.URLHASH.gt(au);
                        switch (ay.market) {
                        case "HF":
                            ao(at);
                            break;
                        case "NF":
                            ao(at, !0);
                            break;
                        case "global_index":
                            ag(at);
                            break;
                        case "forex":
                        case "forex_yt":
                        case "BTC":
                            al(at, ar);
                            break;
                        default:
                            "msk" == ar.type ? an(at) : "rek" == ar.type && Z.get(v.URLHASH.KD) ? aq(at) : ak(at)
                        }
                    }
                }
            };
            this.kDb = Z,
            this.extraDataObj = Z.extraDataObj,
            this.getYtdIndex = function(ai) {
                var aj = Z.get(v.URLHASH.KD);
                if (!aj) {
                    return null
                }
                var ah = aj[aj.length - 1],
                ag = ah.date.getFullYear(),
                ak = 0;
                return ai && (ag--, ak = ah.date.getMonth()),
                aA(new Date(ag, ak, 1))
            },
            this.initData = aa.iInit,
            this.doUpdate = X.uUpdate,
            this.onViewChange = az,
            this.setPricePos = function(ag, ah) {
                ay.labelMaxP = ag[0],
                ay.labelMinP = ag[1],
                ay.labelPriceCount = ag[2],
                ay.isCompare = ah,
                aH.createPlayingData(),
                aG && aG.setPricePos(ag)
            },
            this.setRange = function(ag) {
                aH.setDataRange(),
                aE && aE.setDataRange(),
                aG && aG.setDataRange(),
                ad && ad.setDataRange(ag)
            },
            this.draw = function() {
                aF.draw(),
                aE && aE.allDraw(Q.x),
                aG && aG.allDraw(Q.x)
            },
            this.resize = function(ag) {
                aH.createPlayingData(),
                aF.resize(),
                aE && aE.onResize(ag),
                aG && aG.onResize(),
                ad && ad.onResize()
            },
            this.clear = function(ag) {
                aF.clear(ag),
                aE && (aE.clear(), aE = null),
                aG && (aG.clear(), aG = null),
                ad && (ad.clear(), ad = null),
                aB && (O = null)
            },
            this.getPriceTech = function() {
                return aG || null
            };
            var ac = function(ag, ai, ah) {
                ag && V.resizeAll(!0),
                F.onChangeView(),
                ai && y.isFunc(ai.callback) && ai.callback(),
                ah && U.onTechChanged(ah[0])
            },
            aI = void 0;
            this.initPt = function(ai, ag) {
                if (ai) { ! y.isArr(ai) && (ai = [ai]);
                    for (var ah = ai.length; ah--;) {
                        if (ai[ah].name && "VOLUME" === ai[ah].name.toUpperCase()) {
                            ai.splice(ah, 1),
                            C.custom.show_underlay_vol = !0;
                            break
                        }
                    }
                    aG || (aG = new u({
                        iMgr: j,
                        stockData: ay,
                        chartArea: q,
                        titleArea: k,
                        cb: ac,
                        cfg: C,
                        type: "k",
                        usrObj: P
                    }), aB && (D = aG), aI && (ax = aG.showHide(aI), aI = void 0)),
                    aG.createChart(ai, ag)
                }
            },
            this.removePt = function(ah) {
                if (ah) { ! y.isArr(ah) && (ah = [ah]);
                    for (var ag = ah.length; ag--;) {
                        if (ah[ag].name && "VOLUME" === ah[ag].name.toUpperCase()) {
                            ah.splice(ag, 1),
                            C.custom.show_underlay_vol = !1;
                            break
                        }
                    }
                } else {
                    C.custom.show_underlay_vol = !1
                }
                aG && aG.removeChart(ah)
            },
            this.togglePt = function(ag, ah) {
                aG ? ax = aG.showHide(ag) : !ah && (aI = ag)
            },
            this.initTc = function(ag, ah) {
                aE || (aE = new w({
                    stockData: ay,
                    iMgr: j,
                    cb: ac,
                    subArea: A,
                    cfg: C,
                    type: "k",
                    usrObj: P,
                    initMgr: V
                }), aB && (x = aE)),
                aE.createChart(ag, ah)
            },
            this.removeTc = function(ag) {
                aE && aE.removeChart(ag)
            },
            this.initRs = function() {
                ad = new s({
                    stockData: ay,
                    setting: C,
                    rc: F.moving
                }),
                ad.linkData(),
                O = ad
            },
            this.setLineStyle = aF.setLineStyle,
            this.getLineStyle = aF.getLineStyle,
            af()
        }
        function W(aD, af) {
            function aG() {
                if (X) {
                    aN = C.COLOR.K_N,
                    aM = C.COLOR.K_FALL,
                    aI = C.COLOR.K_RISE,
                    aB = C.COLOR.K_CL
                } else {
                    var ah = aJ.linecolor,
                    ag = ah.K_N || "#" + y.randomColor();
                    aN = ag,
                    aM = ah.K_FALL || ag,
                    aI = ah.K_RISE || ag,
                    aB = ah.K_CL || ag
                }
                aK.K_N = aN,
                aK.K_FALL = aM,
                aK.K_RISE = aI,
                aK.K_CL = aB,
                aC = new r.xh5_ibPainter({
                    setting: C,
                    sd: aD,
                    ctn: J,
                    withHBg: X,
                    fixScale: !1,
                    reO: {
                        mh: C.DIMENSION.H_MA4K
                    },
                    iMgr: j,
                    iTo: function(ak, ai, am, al) {
                        if (aD && aD.datas) { ! l(ak, j.iHLineO.body) && ak.appendChild(j.iHLineO.body);
                            var aj = aD.labelMaxP - am / C.DIMENSION.h_k * (aD.labelMaxP - aD.labelMinP);
                            j.iToD({
                                mark: aj,
                                x: ai,
                                y: am,
                                oy: C.DIMENSION.H_MA4K,
                                ox: C.DIMENSION.posX,
                                e: al
                            },
                            !0, !1)
                        }
                    }
                }),
                aO = aC.getG()
            }
            var aJ, aM, aN, aI, aB, aC, aO, aK = {},
            aE = 1.3,
            aP = 1.3,
            aF = "solid",
            aA = isNaN(af.nfloat) ? 2 : af.nfloat,
            X = aD.isMain,
            ac = function(ah) {
                if (aJ = p({
                    linetype: "solid",
                    linecolor: aK
                },
                ah || {}), aK = aJ.linecolor, aN = aK.K_N, aM = aK.K_FALL, aI = aK.K_RISE, aB = aK.K_CL, !aJ.linetype && (aJ.linetype = aF), C.datas.candle = aJ.linetype, 0 == aJ.linetype.indexOf("line") || 0 == aJ.linetype.indexOf("mountain")) {
                    var ag = Number(aJ.linetype.split("_")[1]); (isNaN(ag) || 0 >= ag) && (ag = aP),
                    aE = ag
                }
            },
            aQ = function(ag, an) {
                aO.fillStyle = C.COLOR.K_EXT;
                for (var ah, al, ao, ap = !1,
                aq = !1,
                am = aD.datas,
                ai = am.length; ai--;) {
                    if (ao = am[ai], ah = an, !ap && ao.high == aD.rangeMax) {
                        ap = !0;
                        var ak = ao.high.toFixed(aA);
                        99 > ah ? aO.textAlign = "left": ah > C.DIMENSION.w_k - 99 ? (aO.textAlign = "right", ah -= 5) : aO.textAlign = "center",
                        al = ao.hy,
                        al < C.STYLE.FONT_SIZE && (al = C.STYLE.FONT_SIZE + 2),
                        aO.fillText(ak, ah, al)
                    }
                    if (ah = an, !aq && ao.low == aD.rangeMin) {
                        aq = !0;
                        var aj = ao.low.toFixed(aA);
                        99 > ah ? aO.textAlign = "left": ah > C.DIMENSION.w_k - 99 ? (aO.textAlign = "right", ah -= 5) : aO.textAlign = "center",
                        al = Math.floor(ao.ly + C.STYLE.FONT_SIZE + 2),
                        al > C.DIMENSION.h_k + 0.5 * C.STYLE.FONT_SIZE - 3 && (al = C.DIMENSION.h_k),
                        aO.fillText(aj, ah, al)
                    }
                    if (aq && ap) {
                        break
                    }
                    an -= ag,
                    0 > an && (an = 0)
                }
            },
            ae = function() {
                var ak = aD.datas,
                ag = ak.length,
                am = C.DIMENSION.w_k / Math.max(ag, C.PARAM.minCandleNum),
                al = 0.5 * am,
                ah = Q.x - am;
                aC.beginPath();
                for (var ai, aj, an = 0; ag > an; an++) {
                    ai = ak[an],
                    aj = ai.vy,
                    aC.drawVStickC(ah, aj, al, C.DIMENSION.h_k, C.COLOR.V_SD),
                    ah += am
                }
                aC.stroke()
            },
            aH = function() {
                for (var aj, ag, al = aD.datas,
                ak = al.length,
                ah = C.DIMENSION.w_k / Math.max(ak, C.PARAM.minCandleNum), ai = Q.x - 0.4 * ah, am = 0; ak > am; am++) {
                    ag = al[am],
                    aj = ag.cy,
                    0 == am ? (aC.newStyle(aB, !0, aE), aC.moveTo(ai, aj)) : aC.lineTo(ai, aj),
                    ag.ix = ai,
                    ai += ah
                }
                aC.stroke(),
                0 == aJ.linetype.indexOf("mountain") && (ai -= ah, aC.lineTo(ai, C.DIMENSION.h_k), aC.lineTo(Q.x - 0.4 * ah, C.DIMENSION.h_k), aC.newFillStyle_rgba(C.COLOR.M_ARR, C.DIMENSION.h_k, C.COLOR.M_ARR_A), aC.fill()),
                X && C.custom.show_ext_marks && aQ(ah, ai)
            },
            aa = function() {
                for (var aq, an, ah, al, ao = aD.datas,
                ai = ao.length,
                ak = C.DIMENSION.w_k / Math.max(ai, C.PARAM.minCandleNum), ag = 0.6 * ak, am = -1, ap = 1, aj = 0; 3 > aj; aj++) {
                    switch (am) {
                    case - 1 : al = aM;
                        break;
                    case 0:
                        al = aN;
                        break;
                    case 1:
                        al = aI
                    }
                    for (aq = Q.x - ak, aC.beginPath(), ah = 0; ai > ah; ah++) {
                        an = ao[ah],
                        an.isFake || (an.kke_cs == am && aC.drawCandleRect(aq, an.oy, an.cy, ag, al, an.kke_cs == ap), 0 == aj && (an.ix = aq + ag)),
                        aq += ak
                    }
                    for (aC.stroke(), aq = Q.x - ak, aC.beginPath(), ah = 0; ai > ah; ah++) {
                        an = ao[ah],
                        an.isFake || an.kke_cs == am && aC.drawCandleLineRect(aq, an.hy, an.oy, an.cy, an.ly, ag, al, an.kke_cs == ap),
                        aq += ak
                    }
                    aC.stroke(),
                    am++
                }
                X && C.custom.show_ext_marks && aQ(ak, aq)
            },
            ad = function() {
                for (var ag, an, ai, al, ao = aD.datas,
                aj = ao.length,
                ak = C.DIMENSION.w_k / Math.max(aj, C.PARAM.minCandleNum), ah = 0.6 * ak, am = -1, ap = 0; 3 > ap; ap++) {
                    switch (am) {
                    case - 1 : al = aM;
                        break;
                    case 0:
                        al = aN;
                        break;
                    case 1:
                        al = aI
                    }
                    for (ag = Q.x - ak, aC.beginPath(), ai = 0; aj > ai; ai++) {
                        an = ao[ai],
                        an.isFake || (an.kke_cs == am && aC.drawCandleRect_solid(ag, an.oy, an.cy, ah, al), 0 == ap && (an.ix = ag + ah)),
                        ag += ak
                    }
                    for (aC.stroke(), ag = Q.x - ak, aC.beginPath(), ai = 0; aj > ai; ai++) {
                        an = ao[ai],
                        an.isFake || an.kke_cs == am && aC.drawCandleLineRect(ag, an.hy, an.oy, an.cy, an.ly, ah, al, !1),
                        ag += ak
                    }
                    aC.stroke(),
                    am++
                }
                X && C.custom.show_ext_marks && aQ(ak, ag)
            },
            Z = function() {
                for (var ag, an, ai, al, ao = aD.datas,
                aj = ao.length,
                ak = C.DIMENSION.w_k / Math.max(aj, C.PARAM.minCandleNum), ah = 0.6 * ak, am = -1, ap = 0; 3 > ap; ap++) {
                    switch (am) {
                    case - 1 : al = aM;
                        break;
                    case 0:
                        al = aN;
                        break;
                    case 1:
                        al = aI
                    }
                    for (ag = Q.x - ak, aC.beginPath(), ai = 0; aj > ai; ai++) {
                        an = ao[ai],
                        an.isFake || (0 == ap && (an.ix = ag + ah), an.kke_cs == am && aC.drawOhlc(ag, an.oy, an.hy, an.ly, an.cy, ah, al)),
                        ag += ak
                    }
                    aC.stroke(),
                    am++
                }
                X && C.custom.show_ext_marks && aQ(ak, ag)
            },
            aL = function() {
                X && aC.drawBg(Q.x);
                var ah = aD.datas;
                if (ah) {
                    var ag = 0 == aJ.linetype.indexOf("line") || 0 == aJ.linetype.indexOf("mountain"),
                    aj = 0 == aJ.linetype.indexOf("hollow"),
                    ai = 0 == aJ.linetype.indexOf("ohlc");
                    aC.clear(ag, C.PARAM.getHd()),
                    aC.newGStyle({
                        textBaseline: "bottom",
                        font: C.STYLE.FONT_SIZE + "px " + C.STYLE.FONT_FAMILY
                    }),
                    X && C.custom.show_underlay_vol && ae(),
                    ag ? aH() : aj ? aa() : ai ? Z() : ad()
                }
            };
            this.draw = aL,
            this.clear = function(ag) {
                ag ? aC.clear(!1, C.PARAM.getHd()) : (aC.remove(), aC = null)
            },
            this.resize = function() {
                aC.resize({
                    mh: C.DIMENSION.H_MA4K
                }),
                aL()
            },
            this.setLineStyle = ac,
            this.getLineStyle = function() {
                return aJ
            },
            ac(af),
            aG()
        }
        function G() {
            var a3, a9, a8, a6, a2 = this,
            a4 = [],
            a5 = 0.05,
            ba = function() {
                var an, aj, at = Number.MAX_VALUE,
                ap = -Number.MAX_VALUE,
                au = a4.length,
                ah = au > 1 || "percent" == C.datas.scaleType;
                C.custom.k_overlay && (ah = !1);
                for (var ai, aq, al, ao, am = ah ? "Percent": "Price", ak = au; ak--;) {
                    an = a4[ak],
                    P.scalerange ? al = P.scalerange: (ao = an.getPriceTech(), ah || !ao ? al = [ap, at] : (aj = ao && ao.getMaxMin(), al = aj || [ap, at])),
                    ai = an["min" + am],
                    aq = an["max" + am],
                    isFinite(ai) && isFinite(aq) && (at = Math.min(at, ai, al[1]), ap = Math.max(ap, aq, al[0]))
                }
                var ar;
                ar = P.scalerange ? P.scalerange.concat(4) : 1 == P.pcm ? 0.0199 > ap - at ? [ap, at, 1] : n(ap, at, 2, !1, !0) : n(ap, at, P.nfloat, !1, !0, a5);
                for (var ag = au; ag--;) {
                    an = a4[ag],
                    an.setPricePos(ar, ah)
                }
            },
            aV = function() { (E.start < 1 || !C.custom.smooth) && Q.resetX();
                for (var ag = a4.length; ag--;) {
                    a4[ag].draw()
                }
            },
            a0 = function() {
                E.start = E.end = 0 / 0,
                E.currentLength = 0 / 0,
                a9 = void 0
            },
            a7 = function(aj) {
                a0();
                for (var ai, ah = a4.length,
                ag = 0; ah > ag; ag++) {
                    ai = a4[ag],
                    ai.onViewChange()
                }
                ba(),
                aV(),
                aj || U.onRange(a3, ah > 1)
            },
            aU = [],
            aY = !1,
            aT = function(ag) {
                return ag.isErr ? (ag !== a3 && a2.removeCompare([ag.symbol]), !0) : ag.kDb.get() ? !0 : (ag.initData(af), !1)
            },
            ac = function(ag) {
                if (ag && y.isFunc(ag.callback)) {
                    for (var ai = !1,
                    ah = aU.length; ah--;) {
                        if (ag.callback === aU[ah]) {
                            ai = !0;
                            break
                        }
                    } ! ai && aU.push(ag.callback)
                }
            },
            aX = function() {
                for (var ag, ai = !0,
                ah = a4.length; ah--;) {
                    ag = a4[ah],
                    ag == a3 || aT(ag) || (ai = !1, aY = !0)
                }
                return ai
            },
            af = function(ag, ai) {
                if (ac(ai), aT(a3)) {
                    if (a3.isErr) {
                        return void(a3.isErr = !1)
                    }
                    if (j.patcher.switchFloater(), Q.resetX(0), aX()) {
                        for (aY = !1, a7(ag); aU.length;) {
                            var ah = aU.shift();
                            ah()
                        }
                    }
                    if (U.onViewChanged(), ag) {
                        return
                    }
                    U.onDataUpdate(),
                    U.onViewPrice()
                }
            },
            ad = function(ag) { (ag || a9 && E.dataLength != a9) && U.onRange(a3, a4.length > 1),
                a9 = E.dataLength
            },
            aQ = function(ag) { (ag || E.end == E.dataLength) && (j.update(), ba(), aV(), ad(!0)),
                U.onDataUpdate(),
                !j.isIng() && U.onViewPrice()
            },
            aZ = function(ag) {
                clearTimeout(a6),
                !I && B.parentNode && "none" != B.style.display && (a6 = setTimeout(aQ, ag || 200))
            },
            aN = function() {
                if (!aY) {
                    for (var ag, ah = a4.length; ah--;) {
                        ag = a4[ah],
                        ag.doUpdate(aZ)
                    }
                }
            },
            aS = function() {
                if (clearInterval(a8), !isNaN(P.rate)) {
                    var ag = 1000 * P.rate;
                    ag > 0 && (a8 = setTimeout(aS, ag))
                }
                aN()
            };
            this.mM = new
            function() {
                var ai = function(an, am, aj) {
                    var ao, ap;
                    switch (am) {
                    case "price":
                        if (ao = u, ap = "initPt", y.isObj(an)) {
                            an.name && "TZY" === String(an.name).toUpperCase() && (a5 = 0.2)
                        } else {
                            if (y.isArr(an)) {
                                for (var al, ak = an.length; ak--;) {
                                    if (al = an[ak], al && al.name && "TZY" === String(al.name).toUpperCase()) {
                                        a5 = 0.2;
                                        break
                                    }
                                }
                            }
                        }
                        break;
                    case "tech":
                        ao = w,
                        ap = "initTc"
                    }
                    ap && (ao ? a3[ap](an, aj) : KKE.api("plugins.techcharts.get", {
                        type: am
                    },
                    function(aq) {
                        w = aq.tChart,
                        u = aq.pChart,
                        ai(an, am, aj)
                    }))
                },
                ah = function(ak, aj) {
                    var al;
                    switch (aj) {
                    case "price":
                        al = "removePt",
                        a5 = 0.05;
                        break;
                    case "tech":
                        al = "removeTc";
                        break;
                    default:
                        return
                    }
                    a3 && a3[al](ak)
                },
                ag = function(aj) {
                    return s ? (O ? (O.sh(aj), (aj.from || aj.to) && O.dateFromTo(aj.from, aj.to)) : (a3.initRs(), ag(aj), H.appendChild(O.getBody())), void V.resizeAll(!0)) : void KKE.api("plugins.rangeselector.get", null,
                    function(ak) {
                        s = ak,
                        ag(aj)
                    })
                };
                this.showRs = ag,
                this.newAC = ai,
                this.removeAC = ah,
                this.togglePt = function(ak, aj) {
                    a3 && (a3.togglePt(ak, aj), af())
                }
            };
            var aO = new
            function() {
                var ar, ao, ag, ah, ai = !1,
                ap = !1,
                an = function() {
                    ao || (ao = d("div"), ao.style.margin = "0 auto"),
                    ao.style.width = 0.8 * C.DIMENSION.getStageW() + "px",
                    ao.style.height = 0.83 * C.DIMENSION.h_k + "px"
                },
                al = function(at) {
                    ar.dateTo(at.date,
                    function(au) {
                        1 != au && ab.showTip({
                            txt: v.nohistoryt,
                            parent: B
                        })
                    })
                },
                aj = function(at) {
                    if (ag && ar) {
                        ap = !0;
                        var au = ar.getSymbols()[0];
                        au != a3.symbol && ar.newSymbol({
                            symbol: a3.symbol
                        }),
                        ar.resize(),
                        al(at),
                        ar.show(ao)
                    }
                },
                aq = function() {
                    ap = !1
                },
                am = function(at) {
                    var au = {
                        txt: a3.getName() + "(" + a3.symbol + ") " + t.ds(at.date),
                        content: ao,
                        parent: B,
                        fontColor: "#000",
                        closeCb: aq,
                        btnLb: "\u5173\u95ed",
                        bgStyle: {
                            backgroundColor: "#fff",
                            width: "80%",
                            top: "2%"
                        }
                    };
                    return ag || (ag = new y.TipM(C.COLOR)),
                    au.content = ao,
                    au
                },
                ak = function(au) {
                    var at = am(au);
                    if (ag.genTip(at), ar) {
                        aj(au)
                    } else {
                        if (ai) {
                            return
                        }
                        ai = !0,
                        KKE.api("chart.h5t.get", {
                            symbol: a3.symbol,
                            dom: ao,
                            nfloat: P.nfloat
                        },
                        function(av) {
                            ar = av,
                            ai = !1,
                            aj(au)
                        })
                    }
                };
                this.resetHisT = function() {
                    ag && ag.hide()
                },
                this.isShowing = function() {
                    return ap
                },
                this.historyT = function() {
                    if ("CN" === y.market(a3.symbol)) {
                        ah = j.getInteractiveIdx();
                        var at = a3.datas[ah];
                        if (at) {
                            if (at.date.getFullYear() < 2008) {
                                return void ab.showTip({
                                    txt: v.historyt08,
                                    parent: B
                                })
                            }
                            switch (C.custom.history_t) {
                            case "layer":
                                an(),
                                ak(at);
                                break;
                            case "window":
                                var av = "//" + window.location.host;
                                av = av.replace("$symbol", a3.symbol).replace("$date", t.ds(at.date));
                                var au = "width=600,height=375,location=0,menubar=0,titlebar=0,toolbar=0,alwaysRaised=1";
                                window.open(av, "_blank", au);
                                break;
                            default:
                                return
                            }
                        }
                    }
                }
            };
            this.h5tM = aO,
            this.getAllStock = function() {
                return a4
            },
            this.getMainStock = function() {
                return a3
            },
            this.getAllSymbols = function() {
                for (var ag = [], ah = 0, ai = a4.length; ai > ah; ah++) {
                    ag.push(a4[ah].symbol)
                }
                return ag
            };
            var aa = function() {
                a2.mM.togglePt(a4.length > 1 ? {
                    v: !1
                }: E.viewId == v.URLHASH.KCL || E.viewId == v.URLHASH.KCLF || E.viewId == v.URLHASH.KCLB ? {
                    v: !1
                }: {
                    v: !0
                })
            },
            Z = function(am, ah, ag, an, ai) {
                if (!ag && Q.resetX(), !(ah - am < C.PARAM.minCandleNum || ah > E.dataLength || 0 > am || ah - am > C.PARAM.maxCandleNum)) {
                    E.start = am,
                    E.end = ah,
                    E.currentLength = ah - am;
                    for (var ak, al = a4.length,
                    aj = 0; al > aj; aj++) {
                        ak = a4[aj],
                        ak.setRange(an)
                    }
                    ba(),
                    aV(),
                    ai || U.onRange(a3, al > 1)
                }
            };
            this.onChangeView = af,
            this.showYTD = function(ag, ai) {
                E.viewId = v.URLHASH.KD + ag,
                af(!0);
                var ah = a3.getYtdIndex(ai);
                ah && Z(ah[0], ah[1] + 1)
            },
            this.moving = Z,
            this.callSdDraw = aV;
            var az = function(ag, ai) {
                var ah = ag instanceof R ? ag: new R(ag, ai);
                ai && (a3 = ah),
                a4.push(ah),
                aa(),
                af()
            },
            aP = function(ai) {
                if ("mink" == v.URLHASH.gt(E.viewId).type) {
                    var ah = y.market(ai.symbol),
                    ag = y.market(a3.symbol);
                    if (ah != ag && ("US" == ah || "US" == ag)) {
                        return ! 1
                    }
                }
                return ! 0
            };
            this.compare = function(ag) {
                for (var ai = ag.callback,
                ah = a4.length; ah--;) {
                    if (a4[ah].symbol == ag.symbol) {
                        return void(y.isFunc(ai) && ai({
                            code: 1,
                            msg: "comparing same symbol"
                        }))
                    }
                }
                aP(ag) ? az(ag, !1) : y.isFunc(ai) && ai({
                    code: 2,
                    msg: "invalid comparing market or period"
                })
            },
            this.removeCompare = function(ak, am) {
                for (var ah, aj, ag = !1,
                ai = ak.length; ai--;) {
                    aj = ak[ai];
                    for (var al = a4.length; al--;) {
                        if (aj == a4[al].symbol) {
                            ag = !0,
                            ah = a4.splice(al, 1)[0],
                            ah.clear(am),
                            ah = null;
                            break
                        }
                    }
                }
                ag && !am && (aa(), ba(), aV())
            };
            var bc, aR = function(ag) {
                ag ? aQ() : E.end == E.dataLength && j.update()
            },
            aW = !1,
            a1 = 0,
            ae = function() {
                clearTimeout(bc),
                aW = !1,
                a1 = 0
            },
            bd = function() {
                bc = setTimeout(function() {
                    a1 > 0 && aZ(1),
                    ae()
                },
                500)
            };
            this.pushData = function(aj, ak) {
                var ai = !1;
                switch (Number(ak)) {
                case 0:
                    ae();
                    break;
                case 1:
                    ae(),
                    ai = !0;
                    break;
                case 2:
                    aW || (aW = !0, bd())
                }
                for (var ah = aj.length; ah--;) {
                    for (var ag = a4.length; ag--;) {
                        if (a4[ag].symbol === aj[ah].symbol && aj[ah].data) {
                            a1++,
                            a4[ag].doUpdate(c(aR, null, ai), !1, aj[ah].data, aj[ah].market);
                            break
                        }
                    }
                }
            },
            this.setScale = function(ag) {
                C.datas.scaleType = ag,
                ba(),
                aV()
            },
            this.setLineStyle = function(ai) {
                if (ai) { ! y.isArr(ai) && (ai = [ai]);
                    for (var ah = ai.length; ah--;) {
                        var ag = ai[ah];
                        if (ag.hasOwnProperty("symbol")) {
                            for (var aj = ag.symbol,
                            ak = a4.length; ak--;) {
                                if (a4[ak].symbol == aj) {
                                    a4[ak].setLineStyle(ag),
                                    a4[ak].draw();
                                    break
                                }
                            }
                        } else {
                            a3.setLineStyle(ag),
                            a3.draw()
                        }
                    }
                } else {
                    a3.setLineStyle(),
                    a3.draw()
                }
            },
            this.onResize = function(ag) {
                for (var ah = a4.length; ah--;) {
                    a4[ah].resize(ag)
                }
            };
            var aM = -1,
            X = -1,
            bb = function(ak, am) {
                var ah = E.start,
                aj = E.end,
                ag = ak / Math.abs(ak),
                ai = ag * Math.ceil((aj - ah) / C.PARAM.zoomUnit);
                if (Math.abs(ai) > C.PARAM.zoomLimit && (ai = ag * C.PARAM.zoomLimit), C.custom.centerZoom) {
                    var al = am ? am.layerX / C.DIMENSION.w_k: 0.5;
                    al < C.PARAM.zoomArea ? aj = Math.min(aj - ai * Math.abs(ai), E.dataLength) : al > 1 - C.PARAM.zoomArea ? ah = Math.max(ah + ai * Math.abs(ai), 0) : (ah = Math.max(ah + ai * Math.abs(ai), 0), aj = Math.min(aj - ai * Math.abs(ai), E.dataLength))
                } else {
                    ah = Math.max(ah + ai * Math.abs(ai), 0)
                }
                return ah == aM && aj == X ? [ - 1] : (aM = ah, X = aj, [ah, aj])
            };
            this.onWheel = function(ag) {
                if (!aO.isShowing()) {
                    var ah = ag.detail || -1 * ag.wheelDelta;
                    if (0 != ah) {
                        var ai = bb(ah, ag);
                        Z(ai[0], ai[1])
                    }
                }
            },
            this.onKb = function(aj) {
                if ("keyup" == aj.type) {
                    return void j.iToKb(null, !0)
                }
                var ag = aj.keyCode;
                if (aO.isShowing()) {
                    return void(27 == ag && aO.resetHisT())
                }
                switch (ag) {
                case 38:
                case 40:
                    var ai = bb(38 == ag ? 1 : -1);
                    Z(ai[0], ai[1]);
                    break;
                case 37:
                case 39:
                    var ah = j.iToKb(37 == ag ? -1 : 1);
                    ah && (Z(E.start + ah, E.end + ah), j.iToKb(0));
                    break;
                case 13:
                    aO.historyT();
                    break;
                default:
                    return
                }
                i.preventDefault(aj)
            },
            this.zoomApi = function(ag) {
                var ah = bb(ag ? 1 : -1);
                Z(ah[0], ah[1])
            },
            this.moveApi = function(ag) {
                var ah = E.start,
                ai = E.end;
                ah += ag,
                ai += ag,
                ai > E.dataLength && (ai = E.dataLength, ah = E.start + ai - E.end),
                0 > ah && (ah = 0, ai = E.end - E.start),
                Z(ah, ai)
            },
            this.shareTo = function(ah) {
                ah = p({
                    type: "weibo",
                    url: window.location.href,
                    wbtext: "",
                    qrwidth: 100,
                    qrheight: 100,
                    extra: void 0
                },
                ah || {});
                var ag = String(ah.type).toLowerCase();
                switch (ag) {
                case "qrcode":
                    KKE.api("utils.qrcode.createcanvas", {
                        text: ah.url,
                        width: ah.qrwidth,
                        height: ah.qrheight
                    },
                    function(ai) {
                        ab.showTip({
                            content: ai,
                            txt: '<p style="margin:0 0 9px 0;">\u626b\u63cf\u4e8c\u7ef4\u7801</p>',
                            parent: B,
                            btnLb: "\u5173\u95ed"
                        })
                    });
                    break;
                default:
                    y.grabM.shareTo({
                        ctn:
                        B,
                        w: C.DIMENSION.getStageW(),
                        h: C.DIMENSION.getStageH() - (H.clientHeight || 0),
                        ignoreZIdxArr: [C.PARAM.I_Z_INDEX],
                        ignoreIdArr: [C.PARAM.LOGO_ID],
                        priorZIdx: C.PARAM.G_Z_INDEX,
                        nologo: !1,
                        top: C.DIMENSION.posY + C.DIMENSION.H_MA4K + 17,
                        right: C.DIMENSION.RIGHT_W + C.DIMENSION.K_RIGHT_W,
                        LOGO_W: C.DIMENSION.LOGO_W,
                        LOGO_H: C.DIMENSION.LOGO_H,
                        color: C.COLOR.LOGO,
                        bgColor: C.COLOR.BG,
                        txt: ah.wbtext,
                        url: ah.url,
                        extra: ah.extra
                    })
                }
            },
            this.getExtraData = function(ai) {
                if (ai = p({
                    symbol: a3.symbol,
                    name: null,
                    clone: !0
                },
                ai || {}), !ai.name) {
                    return null
                }
                for (var ah, ag, aj = a4.length; aj--;) {
                    if (a4[aj].symbol === ai.symbol) {
                        ah = a4[aj];
                        break
                    }
                }
                if (ah) {
                    var ak;
                    "currentK" == ai.name ? (ak = ah.kDb.get(), ag = ai.clone ? y.clone(ak, null) : ak) : (ak = ah.extraDataObj[ai.name], ag = ai.clone ? y.clone(ak, null) : ak)
                }
                return ag
            },
            this.updateDataAll = aS,
            this.outputNewRange = ad,
            this.dcReset = function() {
                clearInterval(a8),
                clearTimeout(a6);
                for (var ag, ah = a4.length; ah--;) {
                    ag = a4.splice(ah, 1)[0],
                    ag.clear(),
                    ag = null
                }
            },
            this.dcInit = function(ag) {
                az(ag, !0),
                aS()
            }
        }
        y.xh5_EvtDispatcher.call(this);
        var K = this;
        P = p({
            candlenum: 0 / 0,
            datas: {
                day: {
                    wfn: void 0,
                    url: void 0,
                    dataformatter: void 0,
                    staticdata: void 0
                },
                min: {
                    wfn: void 0,
                    url: void 0,
                    dataformatter: void 0,
                    staticdata: void 0
                }
            },
            dim: null,
            dom: void 0,
            domid: void 0,
            fh5: !1,
            maxcandlenum: 0 / 0,
            mincandlenum: 0 / 0,
            mh: 0,
            name: void 0,
            nfloat: 2,
            noh5: void 0,
            nohtml5info: void 0,
            ondataupdate: void 0,
            onrange: void 0,
            onviewchanged: void 0,
            onviewprice: void 0,
            ontechchanged: void 0,
            onshortclickmain: void 0,
            pcm: 0,
            rate: 0 / 0,
            reorder: !0,
            reheight: !0,
            scalerange: void 0,
            ssl: !0,
            symbol: "sh000001",
            tchartobject: {
                t: void 0,
                k: void 0
            },
            theme: null,
            trace: void 0,
            view: "kd",
            w: 0 / 0,
            h: 0 / 0,
            zoomlimit: 0 / 0,
            zoomunit: 0 / 0
        },
        P || {
            WANGXuan: "wangxuan2@staff.api.com.cn",
            VER: "2.9.12"
        });
        var C; !
        function() {
            if (!P.symbol && (P.symbol = "sh000001"), P.symbol = String(P.symbol), P.symbol = P.symbol.replace(".", "$"), C = f.getSetting(["_", P.symbol, "_", Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1)].join("")), 0 == location.protocol.indexOf("http:") && (P.ssl = !0), isNaN(P.rate) && (P.rate = C.PARAM.updateRate), !isNaN(P.mincandlenum) && P.mincandlenum > 0 && (C.PARAM.minCandleNum = P.mincandlenum), !isNaN(P.candlenum) && P.candlenum >= C.PARAM.minCandleNum && (C.PARAM.defaultCandleNum = P.candlenum), isNaN(P.maxcandlenum) || (C.PARAM.maxCandleNum = P.maxcandlenum), !isNaN(P.zoomunit) && P.zoomunit > C.PARAM.minCandleNum && (C.PARAM.zoomUnit = P.zoomunit), !isNaN(P.zoomlimit) && P.zoomlimit > 0 && (C.PARAM.zoomLimit = Math.round(P.zoomlimit)), h.noH5) {
                if ("undefined" == typeof FlashCanvas || P.fh5) {
                    return void(y.isFunc(P.noh5) && P.noh5(P))
                }
                C.PARAM.isFlash = !0
            }
            if (C.PARAM.isFlash && (C.COLOR.F_BG = "#fff"), P.reorder || (C.custom.indicator_reorder = !1), P.reheight || (C.custom.indicator_reheight = !1), P.dim) {
                for (var X in P.dim) {
                    P.dim.hasOwnProperty(X) && y.isNum(C.DIMENSION[X]) && (C.DIMENSION[X] = P.dim[X])
                }
            }
        } ();
        var F, Y, B, J, q, k, A, H, M, x, D, O, z, I = !1,
        L = 0,
        E = {
            viewId: v.URLHASH.vi(P.view || "kd"),
            dataLength: 0 / 0,
            start: 0 / 0,
            end: 0 / 0,
            currentLength: 0 / 0,
            startDate: void 0,
            endDate: void 0,
            movY: 0
        },
        Q = {
            x: 0,
            resetX: function(X) {
                this.x = isNaN(X) ? C.DIMENSION.w_k / Math.max(E.currentLength, C.PARAM.minCandleNum) : X
            }
        },
        ab = new
        function() {
            var X;
            this.showTip = function(Z) {
                X || (X = new y.TipM(C.COLOR)),
                X.genTip(Z)
            },
            this.hideTip = function() {
                X && X.hide()
            }
        },
        U = new
        function() {
            var X = function() {
                var aa = M.get(E.viewId);
                return aa ? aa[aa.length - 1] : null
            };
            this.onRange = function(ac, aa) { ! I && y.isFunc(P.onrange) && P.onrange({
                    isCompare: aa,
                    data: ac.datas,
                    viewRangeState: y.clone(E, null),
                    width: C.DIMENSION.w_k,
                    height: C.DIMENSION.h_k,
                    left: C.DIMENSION.posX,
                    top: C.DIMENSION.H_MA4K,
                    range: [ac.labelMaxP, ac.labelMinP, ac.labelMaxVol],
                    minCandleNum: C.PARAM.minCandleNum
                })
            };
            var Z = [];
            this.onViewPrice = function(aw, ad, af, ao, aa, ar) {
                if (!I && y.isFunc(P.onviewprice)) {
                    if (!aw) {
                        if (aw = X(), !aw) {
                            return
                        }
                        ad = E.currentLength - 1
                    }
                    if (!af) {
                        for (; Z.length;) {
                            Z.length--
                        }
                        for (var av, at, ap, ac, ae = F.getAllStock(), au = 0, aq = ae.length; aq > au; au++) {
                            ac = ae[au],
                            av = ac.datas,
                            !av || av.length <= ad || (at = ac.getName(), ap = av[ad], !ao && ae[au].isMain && (ao = av), Z.push({
                                name: at,
                                data: ap,
                                rangedata: av,
                                symbol: ac.symbol,
                                color: ac.getLineStyle().linecolor
                            }))
                        }
                        af = Z
                    }
                    aa || (aa = F.getMainStock().getName()),
                    P.onviewprice({
                        data: y.clone(aw, null),
                        rangedata: ao,
                        idx: ad,
                        left: C.DIMENSION.posX,
                        top: C.DIMENSION.H_MA4K,
                        data_array: af,
                        curname: aa,
                        interacting: !!ar
                    })
                }
            },
            this.onDataUpdate = function() {
                if (y.isFunc(P.ondataupdate)) {
                    var aa = X();
                    aa && P.ondataupdate({
                        data: y.clone(aa, null),
                        idx: E.currentLength - 1,
                        left: C.DIMENSION.posX,
                        top: C.DIMENSION.H_MA4K
                    })
                }
            },
            this.onViewChanged = function() {
                y.isFunc(P.onviewchanged) && P.onviewchanged({
                    viewRangeState: y.clone(E, null)
                })
            },
            this.onInnerResize = function(aa) {
                y.isFunc(P.oninnerresize) && P.oninnerresize(aa)
            },
            this.onTechChanged = function(aa) {
                y.isFunc(P.ontechchanged) && P.ontechchanged({
                    Indicator: aa
                })
            },
            this.shortClickHandler = function() {
                y.isFunc(P.onshortclickmain) && P.onshortclickmain()
            }
        },
        V = new
        function() {
            var aw, aa, az, ac, aB, ae = 37,
            ay = function(aF, am, aj) {
                var ag = !1;
                isNaN(aF) && (aF = P.w || Y.offsetWidth),
                isNaN(am) && (am = P.h || Y.offsetHeight - P.mh);
                for (var ak, an = H.clientHeight || 0,
                al = A.clientHeight || 0,
                ah = C.DIMENSION.getOneWholeTH(), ap = 0, aG = A.childNodes, aq = aG.length, ao = 0, ai = aG.length; ai--;) {
                    ak = aG[ai],
                    ak.id.indexOf("blankctn") >= 0 ? (ap = ak.offsetHeight, aq--, ao += ap) : ao += ah
                }
                return ! isNaN(aj) && (al -= aj),
                al / (am - an) > 1 && (al = ao, ag = !0),
                C.DIMENSION.setStageW(aF),
                1 == L ? aq > 0 && (C.DIMENSION.setStageH(am, aq * ah + ap + an), ag = !0, L = 0) : C.DIMENSION.setStageH(am, al + an),
                ag
            },
            au = function() {
                aB && (aB.style.display = C.custom.show_logo ? "": "none")
            },
            Z = function() {
                z = new y.LoadingSign,
                z.appendto(J)
            },
            ad = function() {
                z.setPosition()
            },
            ax = function(ah, aj, ai) {
                var ag = ay(aj, ai, 0 / 0);
                if (ah || aj && ai) {
                    if (!F) {
                        return
                    }
                    F.onResize(ag),
                    j.onResize()
                }
                az.style.left = "1px",
                az.style.top = C.DIMENSION.h_k + C.DIMENSION.H_MA4K + "px",
                au(),
                ad(),
                y.stc("k_wh", [C.DIMENSION.getStageW(), C.DIMENSION.getStageH()])
            },
            af = function() {
                Y = o(P.domid) || P.dom,
                Y || (Y = d("div"), document.body.appendChild(Y)),
                B = d("div"),
                B.style.position = "relative",
                B.style.outlineStyle = "none",
                B.style.webkitUserSelect = B.style.userSelect = B.style.MozUserSelect = "none",
                J = d("div", "mainarea_" + C.uid),
                q = d("div"),
                J.appendChild(q),
                k = d("div"),
                k.style.position = "absolute",
                k.style.fontSize = k.style.lineHeight = C.STYLE.FONT_SIZE + "px",
                k.style.width = "100%",
                J.appendChild(k),
                B.appendChild(J),
                A = d("div"),
                B.appendChild(A),
                H = d("div"),
                B.appendChild(H),
                aw = new T({
                    width: ae,
                    height: C.DIMENSION.H_TIME_PART
                }),
                aa = aw.g,
                az = aw.canvas,
                az.style.position = "absolute",
                B.appendChild(az),
                Y.appendChild(B)
            },
            ar = function(ah) {
                var ag = !1;
                if (ah) {
                    O && (ag = O.setTheme(ah));
                    for (var ai in ah) {
                        ah.hasOwnProperty(ai) && C.COLOR.hasOwnProperty(ai) && C.COLOR[ai] !== ah[ai] && (C.COLOR[ai] = ah[ai], ag = !0)
                    }
                    y.stc("k_thm", ah)
                }
                return ag && a.styleLogo({
                    logo: aB,
                    color: C.COLOR.LOGO
                }),
                ag
            },
            at = function(ag) { ! C.custom.mousewheel_zoom || document.activeElement !== B && document.activeElement.parentNode !== B || (F && F.onWheel(ag), i.preventDefault(ag), i.stopPropagation(ag))
            },
            X = function(ag) {
                C.custom.keyboard && F && F.onKb(ag)
            },
            av = function() {
                y.xh5_deviceUtil.istd || (h.info.name.match(/firefox/i) ? i.addHandler(B, "DOMMouseScroll", at) : i.addHandler(B, "mousewheel", at), B.tabIndex = 0, i.addHandler(B, "keyup", X), i.addHandler(B, "keydown", X))
            },
            aA = function(ag) {
                aB = ag,
                B.appendChild(ag)
            };
            af(),
            Z(),
            ar(P.theme),
            ax(),
            av(),
            a.getLogo({
                cb: aA,
                id: C.PARAM.LOGO_ID,
                isShare: !1,
                top: C.DIMENSION.posY + C.DIMENSION.H_MA4K + 17,
                right: C.DIMENSION.RIGHT_W + C.DIMENSION.K_RIGHT_W,
                LOGO_W: C.DIMENSION.LOGO_W,
                LOGO_H: C.DIMENSION.LOGO_H,
                color: C.COLOR.LOGO
            }),
            h.noH5 && (ab.showTip({
                txt: P.nohtml5info || v.nohtml5info,
                parent: B
            }), y.stc("k_nh5")),
            this.resizeAll = ax,
            this.innerResize = function(ag) {
                F && (ay(0 / 0, 0 / 0, ag), F.onResize(), j.onResize(), ad(), U.onInnerResize({
                    height: C.DIMENSION.h_k
                }))
            },
            this.initTheme = ar,
            this.drawReMark = function(ag) {
                if (ag) {
                    if (az.style.display = "", ac == ag) {
                        return
                    }
                    var ah = C.DIMENSION.H_TIME_PART;
                    ac = ag,
                    aw.resize({
                        width: ae,
                        height: ah,
                        hd: C.PARAM.getHd()
                    }),
                    aa.font = "12px " + C.STYLE.FONT_FAMILY,
                    aa.textBaseline = "top",
                    aa.fillStyle = C.COLOR.REMARK_BG,
                    aa.fillRect(0, 0, ae, ah),
                    aa.fillStyle = C.COLOR.REMARK_T,
                    aa.fillText(ag, 0, 0)
                } else {
                    az.style.display = "none"
                }
            }
        },
        j = new
        function() {
            var ae, aH, aC, aI, aK = y.market(P.symbol),
            aM = /^forex|^HF/.test(aK),
            aE = isNaN(P.nfloat) ? 2 : P.nfloat,
            ad = 150,
            aO = new
            function() {
                var ag = function(ai) {
                    var ah = ae.body.style;
                    ai && C.custom.show_floater ? (ah.backgroundColor = C.COLOR.F_BG, ah.color = C.COLOR.F_T, ah.border = "1px solid " + C.COLOR.F_BR, ah.display = "") : ah.display = "none"
                };
                this.pv = function(aj) {
                    var ai = ae.body.style,
                    ah = Math.max(C.DIMENSION.posX, 55) + 9;
                    ai.left = (aj.x > C.DIMENSION.getStageW() >> 1 ? ah: C.DIMENSION.getStageW() - ad - 9) + "px",
                    ai.top = (aj.y || 0) + "px",
                    ag(!0)
                },
                this.showFloater = ag
            },
            aF = function() {
                function ag() {
                    var ah, aw, ap = "border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0;border-collapse:collapse;border-spacing:0;text-align:center;",
                    bb = "font-weight:normal;border:0;height:16px;text-align:center",
                    am = "text-align:left;font-weight:normal;border:0;height:16px;",
                    aq = "text-align:right;border:0;height:16px;",
                    at = d("div"),
                    ak = at.style;
                    ak.position = "absolute",
                    ak.zIndex = C.PARAM.I_Z_INDEX + 2,
                    ak.padding = "2px",
                    ak.width = ad + "px",
                    ak.lineHeight = "16px",
                    ak.display = "none",
                    ak.fontSize = "12px";
                    var ax, ao, ai, ay, aj = d("table"),
                    bc = d("thead"),
                    a6 = d("tbody");
                    aj.style.cssText = ap,
                    ax = d("tr"),
                    ao = d("th"),
                    ao.setAttribute("colspan", "2"),
                    ao.style.cssText = bb;
                    var az = d("span");
                    ao.appendChild(az),
                    ax.appendChild(ao),
                    bc.appendChild(ax),
                    ax = d("tr"),
                    ao = d("th"),
                    ao.setAttribute("colspan", "2"),
                    ao.style.cssText = bb;
                    var ba = d("span");
                    ao.appendChild(ba),
                    ax.appendChild(ao),
                    a6.appendChild(ax),
                    ax = d("tr"),
                    ao = d("th"),
                    ao.style.cssText = am,
                    ai = d("td"),
                    ay = d("span"),
                    ay.innerHTML = "\u5f00\u76d8";
                    var an = d("span");
                    ai.style.cssText = aq,
                    ao.appendChild(ay),
                    ai.appendChild(an),
                    ax.appendChild(ao),
                    ax.appendChild(ai),
                    a6.appendChild(ax),
                    ax = d("tr"),
                    ao = d("th"),
                    ao.style.cssText = am,
                    ai = d("td"),
                    ay = d("span"),
                    ay.innerHTML = "\u6700\u9ad8";
                    var a5 = d("span");
                    ai.style.cssText = aq,
                    ao.appendChild(ay),
                    ai.appendChild(a5),
                    ax.appendChild(ao),
                    ax.appendChild(ai),
                    a6.appendChild(ax),
                    ax = d("tr"),
                    ao = d("th"),
                    ao.style.cssText = am,
                    ai = d("td"),
                    ay = d("span"),
                    ay.innerHTML = "\u6700\u4f4e";
                    var a9 = d("span");
                    ai.style.cssText = aq,
                    ao.appendChild(ay),
                    ai.appendChild(a9),
                    ax.appendChild(ao),
                    ax.appendChild(ai),
                    a6.appendChild(ax),
                    ax = d("tr"),
                    ao = d("th"),
                    ao.style.cssText = am,
                    ai = d("td"),
                    ay = d("span"),
                    ay.innerHTML = "\u6536\u76d8";
                    var a4 = d("span");
                    ai.style.cssText = aq,
                    ao.appendChild(ay),
                    ai.appendChild(a4),
                    ax.appendChild(ao),
                    ax.appendChild(ai),
                    a6.appendChild(ax),
                    ax = d("tr"),
                    ao = d("th"),
                    ao.style.cssText = am,
                    ai = d("td"),
                    ay = d("span"),
                    ay.innerHTML = "\u6da8\u8dcc";
                    var ar = d("span");
                    if (ai.style.cssText = aq, ao.appendChild(ay), ai.appendChild(ar), ax.appendChild(ao), ax.appendChild(ai), a6.appendChild(ax), !aM) {
                        ax = d("tr"),
                        ao = d("th"),
                        ao.style.cssText = am,
                        ai = d("td"),
                        ay = d("span"),
                        ay.innerHTML = "\u6210\u4ea4";
                        var a3 = d("span");
                        ai.style.cssText = aq,
                        ao.appendChild(ay),
                        ai.appendChild(a3),
                        ax.appendChild(ao),
                        ax.appendChild(ai),
                        a6.appendChild(ax),
                        ax = d("tr"),
                        ao = d("th"),
                        ao.style.cssText = am,
                        ai = d("td"),
                        ay = d("span"),
                        ay.innerHTML = "\u6362\u624b";
                        var a8 = d("span");
                        ai.style.cssText = aq,
                        ao.appendChild(ay),
                        ai.appendChild(a8),
                        ax.appendChild(ao),
                        ax.appendChild(ai),
                        a6.appendChild(ax),
                        a8.innerHTML = "--"
                    }
                    ax = d("tr"),
                    ao = d("th"),
                    ao.style.cssText = am,
                    ai = d("td"),
                    ay = d("span"),
                    ay.innerHTML = "\u632f\u5e45";
                    var av = d("span");
                    ai.style.cssText = aq,
                    ao.appendChild(ay),
                    ai.appendChild(av),
                    ax.appendChild(ao),
                    ax.appendChild(ai),
                    a6.appendChild(ax),
                    aj.appendChild(bc),
                    aj.appendChild(a6),
                    aj.style.width = "100%",
                    at.appendChild(aj);
                    var au, aA, a7 = function(aU, aS) {
                        var aT = C.COLOR.F_N;
                        return aU > aS ? aT = C.COLOR.F_RISE: aS > aU && (aT = C.COLOR.F_FALL),
                        aT
                    },
                    al = function(aT, aS) {
                        return aS ? "(" + ((aT - aS) / aS * 100).toFixed(2) + "%)": "(--%)"
                    };
                    this.setFloaterData = function(bk) {
                        if (ah = bk.name || bk.symbol || ah || "", az.innerHTML = ah, au = bk.data || aw) {
                            aw = au,
                            aA = bk.stock || aA;
                            var aW = aA.market,
                            bi = "";
                            switch (aW) {
                            case "CN":
                            case "OTC":
                                bi = "\u624b";
                                break;
                            case "US":
                            case "HK":
                                bi = "\u80a1";
                                break;
                            default:
                                bi = ""
                            }
                            var aS = au.percent,
                            aT = au.open,
                            aY = au.close,
                            bh = au.high,
                            aZ = au.low,
                            aU = aY / (1 + aS) || au.prevclose;
                            ba.innerHTML = t.ds(au.date, "/") + "/" + t.nw(au.date.getDay()) + (au.time || "");
                            var bj = 1 > aU || 1 > bh || 1 > aZ ? 4 : aE;
                            an.innerHTML = aT.toFixed(bj) + al(aT, aU, bj),
                            a5.innerHTML = bh.toFixed(bj) + al(bh, aU, bj),
                            a9.innerHTML = aZ.toFixed(bj) + al(aZ, aU, bj),
                            a4.innerHTML = aY.toFixed(bj) + al(aY, aU, bj),
                            aS = isNaN(aS) || !isFinite(aS) ? "--": (100 * aS).toFixed(2),
                            ar.innerHTML = au.change.toFixed(bj) + "(" + aS + "%)";
                            var a1 = isNaN(au.ampP) ? "--": (100 * au.ampP).toFixed(2);
                            if (av.innerHTML = au.amplitude.toFixed(bj) + "(" + a1 + "%)", ar.style.color = a7(aS, 0), an.style.color = a7(aT, aU), a5.style.color = a7(bh, aU), a9.style.color = a7(aZ, aU), a4.style.color = a7(aY, aU), aM || (a3.innerHTML = N(au.volume, 2) + bi), a8 && aA) {
                                var aV = aA.extraDataObj.rsAmount;
                                if (aV) {
                                    for (var a2, aX = 0,
                                    a0 = aV.length; a0 > aX; aX++) {
                                        if (au.date >= aV[aX].date) {
                                            a2 = aV[aX].amount;
                                            break
                                        }
                                    }
                                    a2 && (a8.innerHTML = (au.volume / a2).toFixed(2) + "%")
                                } else {
                                    a8.innerHTML = "--"
                                }
                            }
                        }
                    },
                    this.body = at,
                    this.reset = function() {
                        ah = null,
                        aw = null
                    }
                }
                aH = new ag,
                ae = aH
            },
            af = function() {
                function ag(al) {
                    var ao = d("div"),
                    ah = d("div"),
                    ak = d("span"),
                    aj = 12,
                    ai = al.isH,
                    am = function() {
                        if (ah.style.borderStyle = "dashed", ah.style.borderColor = C.COLOR.IVH_LINE, ak.style.backgroundColor = C.COLOR[al.txtBgCN], ak.style.color = C.COLOR[al.txtCN], ai) {
                            ah.style.borderWidth = "1px 0 0 0",
                            ao.style.width = ah.style.width = C.DIMENSION.getStageW() + "px",
                            ak.style.top = -(0.6 * C.STYLE.FONT_SIZE) + "px",
                            ak.style.width = C.DIMENSION.extend_draw ? "": C.DIMENSION.posX + "px",
                            ak.style.left = 0,
                            ak.style.padding = "1px 0"
                        } else {
                            ah.style.borderWidth = "0 1px 0 0";
                            var ap, aq, ar = C.DIMENSION.H_MA4K + C.DIMENSION.H_T_B;
                            C.DIMENSION.getStageH() < 0 ? (ap = A.clientHeight, aq = ap - ar) : (ap = C.DIMENSION.getStageH() - H.clientHeight || 0, aq = C.DIMENSION.h_k),
                            ap -= ar,
                            ap += C.DIMENSION.I_V_O,
                            ao.style.height = ah.style.height = ap + "px",
                            ak.style.top = aq + "px",
                            ak.style.padding = "2px 2px 1px"
                        }
                    };
                    ao.style.position = "absolute",
                    ao.style.zIndex = C.PARAM.I_Z_INDEX - 2,
                    ak.style.position = ah.style.position = "absolute",
                    ah.style.zIndex = 0,
                    ak.style.zIndex = 1,
                    ak.style.font = C.STYLE.FONT_SIZE + "px " + C.STYLE.FONT_FAMILY,
                    ak.style.whiteSpace = "nowrap",
                    ak.style.lineHeight = aj + "px",
                    al.txtA && (ak.style.textAlign = al.txtA),
                    am(),
                    ao.appendChild(ak),
                    ao.appendChild(ah);
                    var an = function(ap) {
                        ap ? "" != ao.style.display && (ao.style.display = "") : "none" != ao.style.display && (ao.style.display = "none")
                    };
                    this.pv = function(at) {
                        if (!isNaN(at.y) && (ao.style.top = at.y + (at.oy || 0) + "px"), ak.innerHTML = at.v || "", !isNaN(at.x)) {
                            at.x < 0 && (at.x = 0);
                            var aq = at.x + (at.ox || 0),
                            ap = C.DIMENSION.getStageW();
                            aq = ~~ (aq + 0.5),
                            aq -= 1,
                            ao.style.left = aq + "px";
                            var ar = ak.offsetWidth || 66,
                            au = ar >> 1;
                            at.x < au ? au = at.x: aq + au > ap && (au = aq + ar - ap),
                            ak.style.left = -au + "px"
                        }
                        an(!0)
                    },
                    this.display = an,
                    this.body = ao,
                    this.resize = am,
                    an(!1)
                }
                aC = new ag({
                    isH: !0,
                    txtCN: "P_TC",
                    txtBgCN: "P_BG",
                    txtA: "right"
                }),
                aI = new ag({
                    isH: !1,
                    txtCN: "T_TC",
                    txtBgCN: "T_BG",
                    txtA: "center"
                }),
                B.appendChild(aI.body)
            },
            aQ = function() {
                aC.display(!1),
                aI.display(!1),
                aO.showFloater(!1)
            },
            aB = function(ag) {
                x && x.indirectI(ag),
                D && D.indirectI(ag)
            },
            ac = !1,
            Z = !1,
            aG = 0 / 0,
            aD = !1;
            this.getInteractiveIdx = function() {
                return aG
            },
            this.isIng = function() {
                return ac
            },
            this.isMoving = function() {
                return aD
            };
            var X = 0 / 0,
            aJ = 0 / 0,
            aN = [];
            this.iToD = function(ao, ah, bc) {
                if (!ao.e || !Z) {
                    var al = ao.x,
                    an = ao.ox || 0,
                    bd = ao.y,
                    bg = ao.oy || 0,
                    be = ao.e ? ao.e.target: null;
                    if (!bc) {
                        if (X == al && aJ == bd) {
                            return
                        }
                        X = al,
                        aJ = bd
                    }
                    if (be) {
                        var ag = be.style.height.split("px")[0]; (0 > bd || bd > ag) && (al = 0 / 0, bd = 0 / 0)
                    }
                    var ai = E.currentLength,
                    bf = Math.max(ai, C.PARAM.minCandleNum);
                    al += C.DIMENSION.w_k / bf - Q.x;
                    var av = Math.floor(al * bf / C.DIMENSION.w_k);
                    if (0 > av ? av = 0 : av >= ai && (av = ai - 1), !isNaN(av) && (aG = av), isNaN(al) && isNaN(bd)) {
                        return ac = !1,
                        aQ(),
                        aB(Number.MAX_VALUE),
                        void U.onViewPrice()
                    }
                    ac = E.end != E.dataLength ? !0 : ai - 1 > av;
                    for (var bh, au, az, am, at, ax, a6, ap = Number(ao.mark); aN.length;) {
                        aN.length--
                    }
                    if (ah) {
                        var aw = F.getAllStock(),
                        a7 = aw.length,
                        aq = a7 > 1 || "percent" == C.datas.scaleType;
                        C.custom.k_overlay && (aq = !1);
                        for (var ay, aA, aj, ba, ak = Number.MAX_VALUE,
                        a8 = 0; a7 > a8; a8++) {
                            aj = aw[a8],
                            at = aj.datas,
                            !at || at.length <= av || (ay = aj.getName(), aA = at[av], aN.push({
                                name: ay,
                                data: aA,
                                rangedata: at,
                                symbol: aj.symbol,
                                color: aj.getLineStyle().linecolor
                            }), aA.isFake || (ba = Math.abs(aA.cy - bd), ak > ba && (ak = ba, am = aj, az = aA, a6 = at, au = ay, bh = am.symbol)))
                        }
                        if (aq) {
                            ax = 100 * ap,
                            ax = Math.abs(ax) > 999 ? Math.floor(ax) : ax.toFixed(2),
                            ax += "%"
                        } else {
                            if (ax = ap > 99999 ? Math.floor(ap) : ap.toFixed(ap > 9999 ? 1 : aE), C.custom.show_k_rangepercent && am) {
                                var a9 = (ap - am.prevclose) / am.prevclose * 100;
                                a9 = isNaN(a9) || !isFinite(a9) ? "--": a9.toFixed(aE),
                                ax += "<br/>" + a9 + "%"
                            }
                        }
                    } else {
                        if (am = F.getMainStock(), at = am.datas, !at || at.length <= av) {
                            return
                        }
                        az = at[av],
                        a6 = at,
                        au = am.getName(),
                        bh = am.symbol;
                        var ar = Math.abs(ap);
                        ax = ar > 99999 ? Math.floor(ap) : ap.toFixed(ar > 9999 ? 1 : aE),
                        aN.push({
                            name: au,
                            data: az,
                            rangedata: a6,
                            symbol: bh,
                            color: am.getLineStyle().linecolor
                        })
                    }
                    if (az) {
                        var bb = al;
                        C.custom.stick && (al = az.ix || al),
                        ae && (ae.setFloaterData({
                            symbol: bh,
                            name: au,
                            data: az,
                            stock: am,
                            arr: aN
                        }), aO.pv({
                            x: bb,
                            y: C.DIMENSION.K_F_T
                        })),
                        aC.pv({
                            y: bd,
                            v: ax,
                            oy: bg
                        }),
                        aI.pv({
                            x: al,
                            ox: an,
                            y: C.DIMENSION.H_MA4K,
                            v: az.day + " " + (az.time || "")
                        }),
                        aB(av),
                        !au && (au = bh || "--"),
                        U.onViewPrice(az, av, aN, a6, au, !0),
                        K.re(v.e.I_EVT, ao.e)
                    }
                }
            };
            var aL, aa, aR;
            this.iToKb = function(ag, ah) {
                if (ah) {
                    return void(Z = !1)
                }
                if (Z = !0, aG += ag, !l(J, j.iHLineO.body) && J.appendChild(j.iHLineO.body), aL = F.getMainStock(), aR = aL.getName(), aa = aL.datas, !aa) {
                    return void 0
                }
                if (0 > aG) {
                    return aG = 0,
                    -1
                }
                if (aG >= aa.length) {
                    return aG = aa.length - 1,
                    1
                }
                var aj = aa[aG];
                if (!aj) {
                    return void 0
                }
                var ai = {
                    mark: aL.labelMaxP - aj.cy / C.DIMENSION.h_k * (aL.labelMaxP - aL.labelMinP),
                    x: aj.ix,
                    y: aj.cy,
                    oy: C.DIMENSION.H_MA4K,
                    ox: C.DIMENSION.posX
                };
                return void this.iToD(ai, !0, !0)
            };
            var aP;
            this.globalDragHandler = function(ak, ag, aq, ah, am) {
                if (isNaN(ak) && isNaN(ag)) {
                    return aP = 0 / 0,
                    aD = !1,
                    void K.re(v.e.I_EVT, am)
                }
                aQ();
                var an = E.start,
                ap = E.end,
                ar = ap - an;
                isNaN(aP) && (aP = ak);
                var ao = ag - aP,
                ai = E.dataLength,
                al = C.DIMENSION.w_k / ar;
                if (Math.abs(ao) < al) {
                    if (C.custom.smooth && al > 4) {
                        if (ap >= ai && 0 > ao) {
                            return
                        }
                        if (1 > an && ao > 0) {
                            return
                        }
                        Q.x = ao,
                        F.callSdDraw()
                    }
                } else {
                    aP = ag;
                    var aj = Math.round(ao * ar / C.DIMENSION.w_k);
                    an -= aj,
                    ap -= aj,
                    ap >= ai && (ap = ai, an = ap - ar),
                    0 > an && (an = 0, ap = ar),
                    (E.start != an || E.end != ap) && (Q.resetX(0), E.movY = ah - aq, F.moving(an, ap, !0), aD = !0)
                }
            },
            this.shortClickHandler = function() {
                U.shortClickHandler()
            },
            this.zoomView = function(ak, ah) {
                var ap = -Number(ak);
                0 == ap && (ap = 1);
                var ai = E.start,
                al = E.end,
                am = ap * Math.ceil((al - ai) / C.PARAM.zoomUnit);
                if (Math.abs(am) > C.PARAM.zoomLimit && (am = ap * C.PARAM.zoomLimit), C.custom.centerZoom) {
                    var ao = Math.min.apply(Math, ah),
                    ag = ao / C.DIMENSION.w_k,
                    an = Math.max.apply(Math, ah),
                    aj = an / C.DIMENSION.w_k;
                    ag < C.PARAM.zoomArea ? al = Math.min(al - am * Math.abs(am), E.dataLength) : aj > 1 - C.PARAM.zoomArea ? ai = Math.max(ai + am * Math.abs(am), 0) : (ai = Math.max(ai + am * Math.abs(am), 0), al = Math.min(al - am * Math.abs(am), E.dataLength))
                } else {
                    ai = Math.max(ai + am * Math.abs(am), 0)
                }
                F.moving(ai, al)
            },
            aF(),
            af(),
            this.onResize = function() {
                aC.resize(),
                aI.resize()
            },
            this.iHLineO = aC,
            this.hideIUis = aQ,
            this.update = function() {
                ac || (aB(Number.MAX_VALUE), ae && ae.setFloaterData({}))
            },
            this.iReset = function() {
                ae.reset && ae.reset()
            },
            this.patcher = new
            function() {
                var ah, ag = {},
                ai = function() {
                    if (ah) {
                        ae.body.parentNode && ae.body.parentNode.removeChild(ae.body);
                        var aj = "vid_" + E.viewId;
                        if (ah[aj]) {
                            var ak;
                            ak = ag[aj] ? ag[aj] : ag[aj] = new ah[aj],
                            ae = ak
                        } else {
                            ae = aH
                        }
                    } else {
                        ae = aH
                    } ! l(B, ae.body) && B.appendChild(ae.body)
                };
                this.customFloater = function(aj) {
                    ah = aj,
                    ai(),
                    y.stc("k_fl", aj)
                },
                this.switchFloater = ai
            }
        };
        F = new G;
        var S = new
        function() {
            var ae = this;
            this.resize = function(ah, ag) {
                V.resizeAll(!0, ah, ag)
            };
            var aI, aJ = function(ah, ag) {
                if (C.hasOwnProperty(ah)) {
                    for (var ai in ag) {
                        if (ag.hasOwnProperty(ai) && y.isFunc(ag[ai])) {
                            return
                        }
                    }
                    "DIMENSION" == ah && (L = 1),
                    p(C[ah], ag),
                    y.stc(ah, ag),
                    ae.resize()
                }
            },
            aF = function(aj, ah) {
                var ag;
                if (C.hasOwnProperty(aj)) {
                    ag = y.clone(C[aj], null);
                    for (var ak in ag) {
                        if (ag.hasOwnProperty(ak)) {
                            if (y.isFunc(ag[ak])) {
                                ag[ak] = null,
                                delete ag[ak]
                            } else {
                                if (ah) {
                                    for (var ai = ah.length; ai--;) {
                                        typeof ag[ak] === ah[ai] && (ag[ak] = null, delete ag[ak])
                                    }
                                }
                            }
                        }
                    }
                }
                return ag
            },
            aK = function(ai, ah, ag) {
                ag = p({
                    toremove: !1,
                    isexclusive: !1,
                    callback: void 0,
                    addon: !1
                },
                ag || {}),
                ag.toremove ? F.mM.removeAC(ah, ai) : ag.isexclusive ? (F.mM.removeAC(null, ai), F.mM.newAC(ah, ai, ag)) : F.mM.newAC(ah, ai, ag)
            };
            this.setLineStyle = function(ag, ah) {
                ah || (aI = ag),
                F.setLineStyle(ag),
                y.stc("k_style", ag)
            },
            this.showScale = function(ag) {
                F.setScale(ag),
                y.stc("k_scale", ag)
            },
            this.pushData = function(ag, ah) { ! y.isArr(ag) && (ag = [ag]),
                F.pushData(ag, ah)
            };
            var aN, aP, aL = [],
            aE = function() {
                if (aL.length) {
                    var ag = aL.shift();
                    F.pushData([ag], 1)
                } else {
                    clearInterval(aP)
                }
            },
            ad = function() {
                aP = setInterval(aE, 1)
            };
            this.pushTr = function(ai) {
                if (ai && ai.data) {
                    for (var ak, am = ai.data.split(","), ah = ai.symbol, al = ai.market, ag = 0, aj = am.length; aj > ag; ag++) {
                        ak = {
                            symbol: ah,
                            data: am[ag],
                            market: al
                        },
                        aL.push(ak)
                    }
                    clearTimeout(aN),
                    aN = setTimeout(ad, 20)
                }
            },
            this.hide = function(ag) {
                I = !0,
                j.hideIUis(),
                y.$CONTAINS(Y, B) && Y.removeChild(B),
                ag && F.dcReset()
            },
            this.show = function(ag) {
                I = !1,
                ag && (y.isStr(ag) && (ag = o(ag)), Y = ag),
                y.$CONTAINS(Y, B) || (Y.appendChild(B), V.resizeAll(!0)),
                F.outputNewRange(!0),
                U.onViewPrice()
            };
            var aR = 0,
            aM = !1,
            af = function(ah) {
                var ag;
                switch (ah) {
                case 1:
                    ag = "\u540e\u590d\u6743";
                    break;
                case - 1 : ag = "\u524d\u590d\u6743"
                }
                V.drawReMark(ag)
            },
            aS = [],
            aD = [],
            aU = function() {
                for (; aS.length;) {
                    var ag = aS.pop();
                    aD.length--,
                    F.compare(ag)
                }
            },
            X = function() {
                for (var ai, ak = F.getMainStock().symbol, am = F.getMainStock().market, ah = F.getAllStock(), al = ah.length; al--;) {
                    ai = ah[al];
                    var ag = ai.symbol;
                    if (ag != ak) {
                        var aj = ai.market;
                        aj != am && ("US" == aj || "US" == am || "HK" == aj || "HK" == am || "OTC" == aj || "OTC" == am || "option_cn" == aj || "option_cn" == am) && (aS.push(ai), aD.push(ag))
                    }
                }
                aD.length && F.removeCompare(aD, !0)
            },
            aH = function() {
                aM = !1,
                ae.setLineStyle(void 0, !0),
                ae.showScale(void 0),
                F.mM.togglePt({
                    v: !0,
                    ytd: !0
                })
            },
            aG = function(ag) {
                "mink" == v.URLHASH.gt(ag).type ? (E.viewId = ag, af(), X()) : (ag += aR, E.viewId = ag, af(aR), aU())
            },
            aV = new
            function() {
                this.isClMode = !1,
                this.exitClMode = function() {
                    this.isClMode = !1,
                    ae.setLineStyle(aI, !0),
                    F.mM.togglePt({
                        v: !0,
                        ytd: !0
                    })
                },
                this.enterClMode = function() {
                    this.isClMode = !0;
                    var ag = aI && "mountain" == aI.linetype ? "mountain": "line";
                    ae.setLineStyle({
                        linetype: ag,
                        linecolor: {
                            K_CL: C.COLOR.T_P
                        }
                    },
                    !0),
                    F.mM.togglePt({
                        v: !1,
                        ytd: !0
                    })
                }
            },
            aa = !0;
            this.showView = function(aj, ag, ai) {
                j.hideIUis(),
                aa ? setTimeout(function() {
                    aa = !1
                },
                99) : z.hide();
                var al = y.isNum(aj) ? v.URLHASH.vn(aj) : v.URLHASH.vi(aj);
                if (al) {
                    if (aM && aH(), al == v.URLHASH.KCL) {
                        aV.enterClMode()
                    } else {
                        aV.isClMode && aV.exitClMode();
                        var ah = F.getAllStock(),
                        ak = ah && ah.length > 1;
                        ak && F.mM.togglePt({
                            v: !1
                        })
                    }
                    aG(al),
                    F.onChangeView(!1, ag),
                    y.stc("k_v", aj),
                    !ai && y.suda("vw", aj)
                }
            };
            var aQ = !1;
            this.showYTD = function(ag, ah) {
                aQ = !!ag,
                j.hideIUis(),
                aM || (aM = !0, this.setLineStyle({
                    linetype: "line",
                    linecolor: {
                        K_CL: C.COLOR.T_P
                    }
                },
                !0), !aQ && this.showScale("percent"), F.mM.togglePt({
                    v: !1,
                    ytd: !0
                })),
                af(aR),
                F.showYTD(aR, aQ),
                y.stc("k_v", v.URLHASH.NYTD),
                !ah && y.suda("vw", v.URLHASH.NYTD)
            },
            this.showYear = function() {
                this.showYTD(!0)
            },
            this.setReK = function(ag) {
                if (ag = parseInt(ag), !(isNaN(ag) || Math.abs(ag) > 1)) {
                    aR = ag;
                    var ai = v.URLHASH.gt(E.viewId);
                    y.stc("k_re", ag);
                    var ah = ag;
                    "-1" == ah && (ah = "_1"),
                    y.suda("k_re", "k_re" + ah),
                    "mink" != ai.type && (aM ? this.showYTD(aQ, !0) : this.showView(ai.baseid, void 0, !0))
                }
            };
            var aO = function(ag) {
                var ah;
                return ah = y.isStr(ag) ? ag.split(",") : [ag.symbol]
            };
            this.compare = function(aj, ah) {
                if (ah) {
                    for (var ag = aO(aj), ak = ag.length; ak--;) {
                        for (var ai = aD.length; ai--;) {
                            if (ag[ak] == aD[ai]) {
                                aD.splice(ai, 1),
                                aS.splice(ai, 1);
                                break
                            }
                        }
                    }
                    F.removeCompare(aO(aj))
                } else {
                    F.compare(aj),
                    y.suda("k_comp")
                }
                y.stc("k_comp", {
                    rm: ah,
                    o: aj
                })
            };
            var aT = 0;
            this.tCharts = function(ag, ah) {
                aK("tech", ag, ah),
                ah && !ah.noLog && (0 == aT ? aT = 1 : y.sudaLog())
            };
            var Z = 0;
            this.pCharts = function(ag, ah) {
                aK("price", ag, ah),
                ah && !ah.noLog && (0 == Z ? Z = 1 : y.sudaLog())
            },
            this.showPCharts = function(ag) {
                ag && (F.mM.togglePt(ag), y.stc("k_sp", ag))
            },
            this.getIndicators = function() {
                var ah = x ? x.getLog() : null,
                ag = D ? D.getLog() : null;
                return {
                    tCharts: ah,
                    pCharts: ag
                }
            },
            this.getIndicatorData = function() {
                var ah = x ? x.getExistingCharts() : null,
                ag = D ? D.getExistingCharts() : null;
                return {
                    tCharts: ah,
                    pCharts: ag
                }
            };
            var ac;
            this.showRangeSelector = function(ag) {
                ac = p({
                    display: !0,
                    from: void 0,
                    to: void 0
                },
                ag || {}),
                F.mM.showRs(ac),
                y.stc("k_rs", ag)
            },
            this.dateFromTo = function(ag, ai, ah) {
                O && (O.dateFromTo(ag, ai, ah), y.stc("k_ft", [ag, ai, ah]))
            },
            this.setCustom = c(aJ, this, "custom"),
            this.setTheme = function(ah) {
                var ag = V.initTheme(ah);
                ag && (this.setLineStyle({
                    linecolor: ah
                }), this.resize())
            },
            this.setDimension = c(aJ, this, "DIMENSION"),
            this.getDimension = c(aF, null, "DIMENSION", ["boolean"]),
            this.newSymbol = function(ag) {
                if (j.hideIUis(), j.iReset(), F.dcReset(), F.dcInit(ag), ab.hideTip(), x) {
                    var ai = x.getLog();
                    x = null,
                    ai && this.tCharts(ai)
                }
                if (D) {
                    var ah = D.getLog();
                    D = null,
                    ah && this.pCharts(ah)
                }
                ac && (ac.from = void 0, ac.to = void 0, F.mM.showRs(ac)),
                F.h5tM.resetHisT(),
                y.stc("k_ns", ag)
            },
            this.toggleExtend = function() {
                var ah = C.DIMENSION.extend_draw,
                ag = C.DIMENSION.posX;
                aJ.call(this, "DIMENSION", {
                    extend_draw: !ah,
                    posX: ag > 9 ? 7 : 55
                }),
                this.resize()
            },
            this.shareTo = function(ag) {
                F.shareTo(ag),
                y.stc("k_share", ag);
                var ah = ag && ag.type ? ag.type: "weibo";
                y.suda("share", ah)
            },
            this.getChartId = function() {
                return C.uid
            },
            this.getSymbols = function() {
                return F.getAllSymbols()
            },
            this.patcher = {
                iMgr: j.patcher
            },
            this.getExtraData = function(ag) {
                return F.getExtraData(ag)
            },
            this.getCurrentData = function() {
                var ag = M.get(E.viewId);
                return ag && (ag = ag[ag.length - 1]),
                y.clone(ag, null)
            },
            this.getCurrentRange = function() {
                for (var ai, ak, am, ah = [], al = F.getAllStock(), ag = 0, aj = al.length; aj > ag; ag++) {
                    am = al[ag],
                    ak = am.getName(),
                    ai = am.datas,
                    ah.push({
                        name: ak,
                        rangedata: ai,
                        symbol: am.symbol
                    })
                }
                return ah
            },
            this.zoom = function(ag) {
                F.zoomApi(ag),
                y.stc("k_zoom", ag, 9000)
            },
            this.rangeMove = function(ah, ag) {
                F.moving(ah, ag)
            },
            this.move = function(ag) {
                ag = parseInt(ag),
                isNaN(ag) || (F.moveApi(ag), y.stc("k_move", ag, 9000))
            },
            this.update = function() {
                F.updateDataAll(),
                y.stc("k_up", 9000)
            },
            this.type = "h5k",
            this.me = K
        };
        return F.dcInit(P),
        S
    }
    function m() {
        this.get = function(j, q) {
            y.stc("h5k_get");
            var k = new b(j);
            y.isFunc(q) && q(k),
            y.suda("h5k_" + y.market(j.symbol))
        },
        this.dual = function(j, q) {
            y.stc("h5k_dual"),
            j.linetype = "line";
            var k = new b(j);
            k.setCustom({
                k_overlay: !0
            });
            var x = function(A) {
                k.me.rl(A, x);
                var z = j.dual;
                k.compare({
                    symbol: z.symbol,
                    name: z.name,
                    datas: z.datas,
                    linetype: "line",
                    linecolor: z.theme
                })
            };
            k.me.al(v.e.K_DATA_LOADED, x, !1),
            y.isFunc(q) && q(k),
            y.suda("dual_" + y.market(j.symbol))
        },
        this.tick = function(j, q) {
            y.stc("h5k_tick"),
            j.pcm = 1,
            j.view = v.URLHASH.NKMS,
            j.rate = 600,
            j.linetype = "line";
            var k = new b(j, !0);
            y.isFunc(q) && q(k),
            KKE.api("patch.atick.customfloater", {
                chart: k
            },
            function(x) {
                k.patcher.iMgr.customFloater(x)
            }),
            k.setCustom({
                smooth: !1
            }),
            y.suda("tick_" + y.market(j.symbol))
        }
    }
    var s, u, w, o = y.$DOM,
    d = y.$C,
    l = y.$CONTAINS,
    e = y.xh5_PosUtil,
    i = y.xh5_EvtUtil,
    p = y.oc,
    t = y.dateUtil,
    g = t.stbd,
    n = y.xh5_ADJUST_HIGH_LOW.c,
    h = y.xh5_BrowserUtil,
    c = y.fBind,
    N = y.strUtil.ps,
    T = r.xh5_Canvas,
    v = f.globalCfg,
    a = y.logoM;
    return y.fInherit(b, y.xh5_EvtDispatcher),
    m
});