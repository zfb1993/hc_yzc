xh5_define("datas.t", ["utils.util"],
function(k) {
    var m = k,
    a = k.HQ_DOMAIN,
    n = m.load,
    e = m.tUtil,
    l = 0 == location.protocol.indexOf("http:"),
    i = {
        isBond: function(b) {
            return /^(sh204\d{3}|sz1318\d{2})$/.test(b) ? "bond": /^sh020\d{3}$/.test(b) ? "bond": /^sz108\d{3}$/.test(b) ? "bond": /^sh(009|010)\d{3}$/.test(b) ? "bond": /^sz10\d{4}$/.test(b) ? "bond": /^sh(100|110|112|113)\d{3}$/.test(b) ? "bond": /^sz12\d{4}$/.test(b) ? "bond": /^sh(105|120|129|139)\d{3}$/.test(b) ? "bond": /^sz11\d{4}$/.test(b) ? "bond": !1
        },
        us: function(g, H, b) {
            for (var o, s = g.split(";"), h = [], t = 0, G = s.length; G > t; t++) {
                var p, d, f, r, j, c = s[t].split(",");
                0 == t ? (b ? (p = c[1].split(":")[0] + ":" + c[1].split(":")[1], d = c[0], f = Number(c[4]), r = Number(c[2]), j = Number(c[5]) || Number(c[4])) : (j = H.prevclose, p = c[0].split(":")[0] + ":" + c[0].split(":")[1], f = Number(c[3]), r = Number(c[1])), o = {
                    prevclose: j,
                    d: d,
                    m: p,
                    p: f,
                    v: r,
                    avp: f
                }) : (p = c[0].split(":")[0] + ":" + c[0].split(":")[1], f = Number(c[3]), r = Number(c[1]), o = {
                    m: p,
                    p: f,
                    v: r,
                    avp: f
                }),
                h.push(o),
                b && t == G - 1 && "16:00" > p && (o = {
                    m: "16:00",
                    p: f,
                    v: 0,
                    avp: f
                },
                h.push(o))
            }
            return h
        },
        optionCn: function(s, f, j) {
            if (typeof s.length < 1) {
                return []
            }
            for (var C, h, g, d, b = e.gata(j), o = [], r = s.length, c = 0, t = 0; r > c; c++) {
                g = s[c],
                b[b.length - 1] < g.m || (0 == t && Number(g.p) <= 0 && (g.p = f.price || f.prevclose), t++, Number(g.p) > 0 && (C = Number(g.p)), Number(g.p) <= 0 && (g.p = C || 0), Number(g.a) > 0 && (h = Number(g.a)), Number(g.a) <= 0 && (g.a = h || C || 0), Number(g.v) < 0 && (g.v = 0), d = {
                    m: g.i,
                    p: Number(g.p),
                    avp: Number(g.a),
                    v: Number(g.v),
                    iy: Number(g.t)
                },
                0 == c && (d.d = g.d), o.push(d))
            }
            return o
        },
        opm: function() {
            return []
        },
        gbIndex: function(v, d, s, o, h) {
            if (typeof v.length < 1) {
                return []
            }
            var u, t, f = e.gata(s, h.time),
            g = [],
            c = v.length,
            r = 0;
            o && (c = f.length);
            for (var j, H, p = 0,
            b = 0; c > p && (t = v[p], j = 0, 0 == p && (j = o ? 1 : 4), 0 == b && Number(t[1 + j]) <= 0 && (t[1 + j] = d.price), !(d.index > 0 && !o && d.index <= k.arrIndexOf(f, t[j]))); p++) {
                b++,
                t && Number(t[1 + j]) > 0 && (u = Number(t[1 + j])),
                t && Number(t[1 + j]) <= 0 && (t[1 + j] = u || 0),
                t ? (r += Number(t[1 + j]), H = {
                    m: t[j],
                    p: Number(t[1 + j]),
                    avp: r / (p + 1),
                    v: 0
                },
                0 == p && (H.d = t[0], H.prevclose = o ? Number(t[j]) || H.p: d.prevclose, o && (t[1 + j].split(":").length > 1 && (H.p = H.avp = Number(t[3])), isNaN(r) && (r = Number(t[3]), H.avp = r)))) : o && (H = {
                    m: f[p],
                    p: g[g.length - 1].p,
                    avp: g[g.length - 1].avp,
                    v: 0
                }),
                g.push(H)
            }
            return g
        },
        hf: function(v, d, s, o, h) {
            if (typeof v.length < 1) {
                return []
            }
            var u, t, f = e.gata(s, h.time),
            g = [],
            c = v.length,
            r = 0;
            o && (c = f.length);
            for (var j, H, p = 0,
            b = 0; c > p && (t = v[p], j = 0, 0 == p && (j = o ? 1 : 4), 0 == b && Number(t[1 + j]) <= 0 && (t[1 + j] = d.price), !(d.index > 0 && !o && d.index <= k.arrIndexOf(f, t[j]))); p++) {
                b++,
                t && Number(t[1 + j]) > 0 && (u = Number(t[1 + j])),
                t && Number(t[1 + j]) <= 0 && (t[1 + j] = u || 0),
                t ? (r += Number(t[1 + j]), H = {
                    m: t[j],
                    p: Number(t[1 + j]),
                    avp: r / (p + 1),
                    v: 0
                },
                0 == p && (H.d = t[0], H.prevclose = o ? Number(t[j]) || H.p: d.prevclose, o && (t[1 + j].split(":").length > 1 && (H.p = H.avp = Number(t[3])), isNaN(r) && (r = Number(t[3]), H.avp = r)))) : o && (H = {
                    m: f[p],
                    p: g[g.length - 1].p,
                    avp: g[g.length - 1].avp,
                    v: 0
                }),
                g.push(H)
            }
            return g
        },
        hk: function(p, c, f) {
            if (typeof p.length < 1) {
                return []
            }
            for (var s, j, d, b = e.gata(f), t = [], g = p.length, o = 0, E = 0, r = 0, h = 0; g > r; r++) {
                j = p[r],
                E += Number(j.a),
                o += Number(j.v),
                j.m && (j.m = j.m.split(":")[0] + ":" + j.m.split(":")[1]),
                b[b.length - 1] < j.m || (0 == h && Number(j.p) <= 0 && (j.p = c.price || c.prevclose), h++, Number(j.p) > 0 && (s = Number(j.p)), Number(j.p) <= 0 && (j.p = s || 0), 0 >= o && (o = 1), d = {
                    m: j.m,
                    p: Number(j.p),
                    avp: E / o,
                    v: Number(j.v)
                },
                t.push(d))
            }
            return t
        },
        otc: function(o, G, c) {
            if (typeof o.length < 1) {
                return []
            }
            for (var r, j, d, u, s = e.gata(c), f = [], g = o.length, t = 0, p = 0; g > t; t++) {
                u = o[t];
                var h = u.m.split(":"),
                b = h[0] + ":" + h[1];
                s[s.length - 1] < b || (0 == p && Number(u.p) <= 0 && (u.p = G.price || G.prevclose), p++, Number(u.p) > 0 && (r = Number(u.p)), Number(u.p) <= 0 && (u.p = r || 0), Number(u.avg) > 0 && (j = Number(u.avg)), Number(u.avg) <= 0 && (u.avg = j || r || 0), d = {
                    p: Number(u.p),
                    m: b,
                    avp: Number(u.avg),
                    v: Number(u.v) / 1000
                },
                f.push(d))
            }
            return f
        },
        futures: function(U, c, r, N, w) {
            if (typeof U.length < 1) {
                return []
            }
            for (var T, u, f, g, v, p, y, o, h, s, j = e.gata(r, w.time), d = 0, V = [], W = 0, b = U.length; b > W; W++) {
                var t = U[W];
                if (N ? (u = t[6], h = Number(t[5]) || Number(t[1])) : (u = t[6] || c.today, h = Number(t[5]) || c.prevclose), c.index > 0 && !N && c.index <= k.arrIndexOf(j, t[0])) {
                    break
                }
                if ( - 1 != k.arrIndexOf(j, t[0]) || 0 == W) {
                    d++,
                    Number(t[1]) > 0 && (p = Number(t[1])),
                    Number(t[1]) <= 0 && (t[1] = p || 0),
                    Number(t[2]) > 0 && (y = Number(t[2])),
                    Number(t[2]) <= 0 && (t[2] = y || 0),
                    Number(t[4]) > 0 && (o = Number(t[4])),
                    Number(t[4]) <= 0 && (t[4] = o || 0),
                    T = t[0],
                    v = Number(t[3]) || 0,
                    s = Number(t[4]) || 0,
                    !N && U.length <= 1 && 0 == W ? (f = Number(t[1]) ? Number(t[1]) : c.price, g = Number(t[2]) ? Number(t[2]) : c.price, h = Number(t[5]) || c.prevclose) : (f = Number(t[1]), g = Number(t[2]));
                    var S = {
                        d: u,
                        m: T,
                        p: f,
                        avp: g,
                        iy: s,
                        prevclose: h,
                        v: v
                    };
                    V.push(S)
                }
            }
            return N && V[V.length - 1].m < "15:00" && (S.m = "15:00", V.push(S)),
            V
        },
        gdf: function(o, g, r) {
            if (!o || o.length < 9 || !g) {
                return null
            }
            var b = r ? o: m.xh5_S_KLC_D(o),
            f = m.dateUtil.dd(g);
            6 == f.getDay() && f.setDate(f.getDate() - 1),
            0 == f.getDay() && f.setDate(f.getDate() - 2);
            for (var c, d = new Date(f.getFullYear() - 3, f.getMonth(), f.getDate()), s = 0, h = 0, j = 0, B = b.length; B > j; j++) {
                c = b[j],
                c.getTime() <= d.getTime() && b[j + 1].getTime() >= d.getTime() && (s = j),
                m.dateUtil.stbd(c, f) && (h = j + 1)
            }
            return b.slice(s, h)
        },
        c2b: function(c) {
            c = c.replace(" ", "+");
            var b = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".indexOf(c);
            return b >= 0 ? b: 0
        },
        db: function(h) {
            if (!h) {
                return []
            }
            for (var b, g, d = [], c = 0, j = 0, f = 0, o = h.length; o > f; f++) {
                b = this.c2b(h.charAt(f)),
                g = 6 & j ? 7 & j ^ 7 : 5,
                c |= b >> 5 - g << (7 ^ j) - g,
                64767 == c && 63 == b && (c = 65535),
                j > 25 && (j -= 32, d[d.length] = c, c = 0),
                c |= (b & (1 << 5 - g) - 1) << (7 | j) + 4 + g,
                j += 6
            }
            return d
        },
        fB: function(j, o, b, g) {
            j.splice(360, 3);
            for (var f, h = [], c = e.gata(b), r = 3 * c.length, s = 0, d = 0, t = 0; r > t; t += 3) {
                d = Math.floor(t / 3),
                o ? h[h.length] = {
                    time: c[d],
                    price: j[t + 1] / 1000
                }: (h[h.length] = {
                    time: c[d],
                    avg_price: j[t] / 1000,
                    price: j[t + 1] / 1000,
                    volume: j[t + 2] / 100
                },
                k.isRepos(g.symbol) && (h[d].avg_price = h[d].price, h[d].volume *= 10), h[d].volume > 0 && (s += h[d].volume), h[d] && 0 == h[d].price && (0 == d ? h[d].price = h[d].avg_price = g.prevclose: (h[d].price = h[d - 1].price, h[d].avg_price = h[d - 1].price)), h[d].avg_price > 0 && (f = h[d].avg_price))
            }
            return h[0].price < 0 && (h[0].price = h[0].avg_price = s = 0),
            o || (h[0].totalVolume = s, h[0].totalAmount = s * f),
            h[0].index = g.index,
            h[0].prevclose = g.prevclose,
            h[0].symbol = g.symbol,
            h[0].name = g.name,
            h[0].today = g.today,
            h[0].date = g.date,
            h[0].lastfive = g.lastfive,
            h
        },
        ctdf: function(b, u, o, h) {
            for (var v, I, f, g, d = [], s = u, j = 0, H = b.length; H > j; j++) {
                d[d.length] = 0 == j && "" == b[0] ? e.gltbt(1, o.prevclose) : m.xh5_S_KLC_D(b[j]);
                var p, J = 0;
                for (d[j].splice(120, 1), I = 0, f = 241; f > I; I++) {
                    d[j][I] && 0 == d[j][I].price && (0 == I ? d[j][I].price = d[j][I].avg_price = d[j][I].prevclose: (d[j][I].price = d[j][I - 1].price, d[j][I].avg_price = d[j][I - 1].avg_price)),
                    k.isRepos(o.symbol) && (d[j][I].avg_price = d[j][I].price, d[j][I].volume *= 10),
                    p = d[j][I].volume *= 0.01,
                    J += p
                }
                d[j][0].totalVolume = J,
                d[j][0].prevclose = d[j][0].prevclose || d[j][0].price
            }
            var r = d.length;
            for (r > 5 && d.splice(0, r - 5), v = [s], r = h.length, j = r - 2; j > r - 6; j--) {
                for (I = 0, g = d.length; g > I; I++) {
                    if (m.dateUtil.stbd(d[I][0].date, h[j])) {
                        v.unshift(e.azft(d[I], "CN"));
                        break
                    }
                    if (I == d.length - 1) {
                        var c = v[0][0].prevclose;
                        v.unshift(e.gltbt(1, c)),
                        v[0][0].date = m.dateUtil.dd(h[j]),
                        v[0][0].prevclose = c
                    }
                }
            }
            return v
        },
        ctdb: function(j, o, b, g, f, h) {
            for (var c = o,
            r = [c], s = g.length, d = s - 2; d > s - 6; d--) {
                r.unshift("HF" == k.market(b.symbol) ? e.gltbt(1, b.prevclose, !1, f, [g[d]], h.time) : "NF" == k.market(b.symbol) ? e.gltbt(1, b.prevclose, !1, f, [g[d]], h.time) : "global_index" == k.market(b.symbol) ? e.gltbt(1, b.prevclose, !1, f, [g[d]], h.time) : e.gltbt(1, b.prevclose, !1, f, [g[d]]))
            }
            return r
        },
        fund: function(h) {
            var b = [];
            if (h) {
                for (var d = h.detail.split(","), c = 0, f = 0, j = d.length; j > f; f += 2) {
                    c += Number(d[f + 1]);
                    var g = {
                        p: Number(d[f + 1]),
                        avp: Number(c / (f / 2 + 1)),
                        m: d[f]
                    };
                    0 == f && (g.prevclose = Number("09:30" == d[f] ? h.yes: d[f + 1])),
                    b.push(g)
                }
            }
            return b
        },
        pkt: function(j, b, v, h, O) {
            if (typeof j.length < 1) {
                return []
            }
            var o, y = !1,
            f = j,
            g = e.s0(b.date.getHours()) + ":" + e.s0(b.date.getMinutes());
            switch (v) {
            case "HF":
                o = e.gata(v, O.time),
                f.length <= 0 && f.push({
                    d: b.today,
                    price: b.price,
                    prevclose: b.prevclose
                }),
                f[0].d < b.today && g > O.time[0][0] && (g = O.time[O.time.length - 1][1]);
                break;
            case "NF":
                o = e.gata(v, O.time);
                break;
            case "global_index":
                o = e.gata(v, O.time);
                break;
            default:
                o = e.gata(v)
            }
            for (var M, s = [], d = 0, u = 0, p = o.length; p > u; u++) {
                if (M = {},
                s[s.length] = M, M.time = o[u], M.volume = M.price = -1, M.avg_price = -1, g) {
                    if (y && !h) {
                        continue
                    }
                    g == M.time && (y = !0)
                }
                for (var N = o[0], r = d, c = f.length; c > r; r++) {
                    var P = f[r],
                    Q = String(P.m).substring(0, 5);
                    if (Q == o[u]) {
                        Q == N && (M.symbol = b.symbol, M.name = b.name, h ? (M.prevclose = Number(j[0].prevclose) || Number(j[0].p), M.date = m.dateUtil.sd(j[0].d), M.today = j[0].d) : (M.prevclose = b.prevclose, "HF" == v || "NF" == v ? (M.date = m.dateUtil.sd(j[0].d) || b.date, M.today = j[0].d || b.today) : (M.date = b.date, M.today = b.today)), "fund" == v && (M.prevclose = j[0].prevclose)),
                        M.volume = P.v || 0,
                        M.avg_price = P.avp,
                        M.price = P.p,
                        P.iy && (M.inventory = P.iy),
                        f.splice(r, 1);
                        break
                    }
                    Q > o[u] || "NF" == v && "21:00" == N && M.time > "21:00" && Q < o[u] ? (0 == u ? h ? (M.price = j[0].p, M.prevclose = j[0].prevclose || M.price, M.avg_price = j[0].avp, M.date = m.dateUtil.sd(j[0].d), M.today = j[0].d) : (M.price = b.open || b.prevclose, M.prevclose = b.prevclose, M.avg_price = M.price, M.symbol = b.symbol, M.name = b.name, "NF" == v ? (M.date = m.dateUtil.sd(j[0].d) || b.date, M.today = j[0].d || b.today) : (M.date = b.date, M.today = b.today)) : (M.price = s[u - 1].price, M.avg_price = s[u - 1].avg_price, ("option_cn" == v || "op_m" == v || "NF" == v) && (M.inventory = s[u - 1].inventory)), M.volume = -0.01) : 0 != u || h || (M.price = j[r].p || b.open || b.prevclose, M.prevclose = b.prevclose, M.avg_price = j[r].avp || M.price, M.symbol = b.symbol, M.name = b.name, M.volume = 0, "HF" == v || "NF" == v ? (M.date = m.dateUtil.sd(j[0].d) || b.date, M.today = j[0].d || b.today) : (M.date = b.date, M.today = b.today))
                }
            }
            return s[0].index = p - 1,
            s
        }
    };
    return new
    function() {
        this.VER = "2.6.1";
        var c = "//" + window.location.host + "/api/datalist.php",
        g = {
            CN: {
                T_Head_STR: "hq_str_ml_",
                T_EMI_URL: "//apo51.cn/finance/eqlweight/$symbol.js",
                T_URL: "//" + window.location.host + "/api/real.php?_=$rn&list=$symbol",
                T5_URL: "//" + window.location.host + "/api/trend.php?code=$symbol&day=$rn",
                TRADING_DATES_URL: c,
                HISTORY_DATA_URL: "//apo51.cn/realstock/company/$symbol/hisdata/$y/$m.js?d=$date",
                LAST5_URL: "//" + window.location.host + "/api/trend5day.php?code=$symbol&_=$rn"
            },
            option_cn: {
                T_Head_STR: "t1",
            T_URL: "//" + window.location.host + "/api/option.php?type=1&symbol=$symbol&random=$rn&callback=$cb=",
                T5_URL: "//" + window.location.host + "/api/option.php?type=2&symbol=$symbol&random=$rn&callback=$cb=",
                TRADING_DATES_URL: c
            },
            op_m: {
                T_Head_STR: "t1",
                T_URL: "//stock.apo51.cn/futures/api/openapi.php/FutureOptionAllService.getOptionMinline?symbol=$symbol&random=$rn&callback=$cb=",
                TRADING_DATES_URL: c
            },
            US: {
                T_Head_STR: "t1",
                T_URL: "//" + window.location.host + "/api/usminline.php?code=$symbol&day=1&random=$rn&callback=$cb=",
                T5_URL: "//" + window.location.host + "/api/usminline.php?code=$symbol&day=5&random=$rn&callback=$cb",
                TRADING_DATES_URL: "//" + window.location.host + "/api/getTrade.php?start=$start&end=$end&callback=$cb="
            },
            HK: {
                T_Head_STR: "t1",
                T_URL: "//" + window.location.host + "/api/minline.php?code=$symbol&random=$rn&callback=$cb=",
                LAST5_URL: "//" + window.location.host + "/api/config.php?" + random(),
                TRADING_DATES_URL: c
            },
            fund: {
                T_Head_STR: "t1",
                T_URL: "//app.xincai.com/fund/api/jsonp.json/$cb=/XinCaiFundService.getFundYuCeNav?symbol=$symbol&___qn=3",
                TRADING_DATES_URL: c
            },
            global_index: {
                T_Head_STR: "t1",
                T_URL: "//"+window.location.host+"/api/gbchart.php?callback=$cb=&type=trend&code=$symbol&category=index",
                TRADING_DATES_URL: c
            },
            CFF: {
                T_Head_STR: "t1",
                T_URL: "//stock2.apo51.cn/futures/api/jsonp.php/$cb=/InnerFuturesNewService.getMinLine?symbol=$symbol",
                T5_URL: "//stock2.apo51.cn/futures/api/jsonp.php/$cb=/InnerFuturesNewService.getFourDaysLine?symbol=$symbol",
                TRADING_DATES_URL: c
            },
            OTC: {
                T_Head_STR: "t1",
                T_URL: "//stock.apo51.cn/thirdmarket/api/openapi.php/NQHQService.minline?symbol=$symbol&callback=$cb=",
                TRADING_DATES_URL: c
            },
            NF: {
                T_Head_STR: "t1",
                T_URL: "//" + window.location.host + "/api/nfchart.php?type=MinLine&code=$symbol&callback=$cb=",
                T5_URL: "//" + window.location.host + "/api/nfchart.php?type=FourDaysLine&code=$symbol&callback=$cb=",
                TRADING_DATES_URL: c
            },
            HF: {
                T_Head_STR: "t1",
                T_URL: "//" + window.location.host + "/api/hfchart.php?type=MinLine&code=$symbol&callback=$cb=",
                T5_URL: "//" + window.location.host + "/api/hfchart.php?type=5MLine&code=$symbol&callback=$cb=",
                TRADING_DATES_URL: c
            }
        },
        f = {},
        h = 0,
        b = function(v, q, o) {
            var t = k.market(q),
            u = g[t][o];
            return (l || v) && (u = k.getSUrl(u)),
            u
        },
        d = 0;
        this.get = function(q, x) {
            var D, I, s, N = q.symbol,
            u = k.market(N),
            r = q.date,
            w = q.withT5,
            V = q.withI,
            o = q.ssl;
            d = q.dist5;
            var v = {
                msg: null,
                data: {
                    td1: null,
                    td5: null,
                    hq: null
                }
            };
            switch (s = D = N, u) {
            case "HK":
                N = "rt" == N.substring(0, 2) ? N.slice(3) : N,
                D = N,
                I = D.replace("hk", "");
                break;
            case "US":
                s += "," + N + ",gb_ixic,sys_time",
                D = I = N.replace("gb_", ""),
                I = I.replace("$", "."),
                D = D.replace(".", "");
                break;
            case "OTC":
                I = N.replace("sb", "");
                break;
            case "fund":
                I = N.replace("fu_", "");
                break;
            case "CFF":
                I = N.replace("CFF_RE_", "");
                break;
            case "CN":
                I = "ml_" + N;
                break;
            case "global_index":
                I = N.replace("znb_", "");
                break;
            case "op_m":
                I = D = N.replace("P_OP_", "");
                break;
            case "HF":
                I = N.replace("hf_", "");
                break;
            case "NF":
                I = N.replace("nf_", "");
                break;
            default:
                I = N
            }
            var S = function(p) {
                var t, A, z;
                return r ? (z = r.split("-")[1] || "01", A = r.split("-")[0], r.split("-")[1] && Number(r.split("-")[1]) < 10 && (z = "0" + Number(r.split("-")[1]), r = A + "-" + z + "-" + r.split("-")[2]), t = "MLC_" + N + "_" + A + "_" + z, {
                    lc: t,
                    year: A,
                    month: z
                }) : (r = p, null)
            },
            T = function(p) {
                n(b(o, N, "HISTORY_DATA_URL").replace("$symbol", N).replace("$y", p.year).replace("$m", p.month).replace("$date", r),
                function() {
                    var C = String(window[p.lc]);
                    if (window[p.lc] = null, v.msg = "history", C) {
                        for (var z, t, G, K, L = String(C).split(","), A = [], J = L.length, F = e.gata(u), H = 0; J > H; H++) {
                            A[H] = m.xh5_S_KLC_D(L[H]),
                            z = A[H].shift(),
                            A[H][0].prevclose = z.prevclose,
                            A[H][0].date = z.date,
                            A[H].splice(120, 1),
                            t = 0;
                            for (var B = 0; 241 > B; B++) {
                                G = A[H][B].volume /= 100,
                                t += G,
                                A[H][B].time = F[B]
                            }
                            var E = m.dateUtil.ds(z.date);
                            E == r && (K = A[H]),
                            A[H][0].totalVolume = t
                        }
                        if (A.length < 5) {
                            return void n(b(o, N, "TRADING_DATES_URL"),
                            function() {
                                for (var P = window.datelist,
                                O = A.length,
                                R = i.gdf(P, m.dateUtil.sd(r)), Q = 5 - O; Q > 0; Q--) {
                                    A.unshift(e.gltbt(1, A[0][0].price, !1, u, [R[R.length - 5 + Q]]))
                                }
                                v.data.td1 = K,
                                v.data.td5 = A,
                                f[N + p.year + p.month] = v,
                                m.isFunc(x) && x(v)
                            },
                            null, {
                                symbol: N,
                                market: u,
                                type: "tradedate"
                            })
                        }
                        v.data.td1 = K,
                        v.data.td5 = A,
                        f[N + p.year + p.month] = v,
                        m.isFunc(x) && x(v)
                    }
                },
                function() {
                    v.msg = "nohistory",
                    m.isFunc(x) && x(v)
                },
                {
                    market: u,
                    symbol: N,
                    type: "historydata"
                })
            },
            y = function(p) {
                return f[N + p.year + p.month] ? void(m.isFunc(x) && x(f[N + p.year + p.month])) : void T(p)
            },
            X = function(t, z, B) {
                var A;
                switch (u) {
                case "OTC":
                    A = i.otc(t.result.data, z, u);
                    break;
                case "US":
                    A = i.us(String(t), z);
                    break;
                case "HK":
                    A = i.hk(t.result.data, z, u);
                    break;
                case "fund":
                    A = i.fund(t);
                    break;
                case "CFF":
                    A = i.futures(t, z);
                    break;
                case "global_index":
                    A = i.gbIndex(t, z, u, !1, B);
                    break;
                case "NF":
                    A = i.futures(t, z, u, !1, B);
                    break;
                case "option_cn":
                    A = i.optionCn(t.result.data, z, "CN");
                    break;
                case "op_m":
                    A = i.opm(t.result.data, z, "CN");
                    break;
                case "CN":
                    A = i.db(t);
                    break;
                case "HF":
                    A = i.hf(t.result.data.minLine_1d, z, u, !1, B)
                }
                if ("CN" == u) {
                    A = i.fB(A, !1, u, z)
                } else {
                    A = i.pkt(A, z, u, !1, B);
                    var p = z.time;
                    "HK" == u && p > "15:59" && (p > "16:09" && (p = "16:09"), A[A.length - 1].price = z.price, A[A.length - 1].avg_price = A[A.length - 2].avg_price, A[A.length - 1].time = p, A[A.length - 1].volume = 0, A[A.length - 1].avg_price < 0 && (A[A.length - 1].avg_price = z.price))
                }
                return A
            },
            U = function(p, B, t) {
                var z, A = 3;
                if (z && z.length > 600) {
                    j(p, N, B, z, x, q.dataformatter, o)
                } else {
                    if (A--, A > 0) {
                        if ("US" == u) {
                            var C = k.dateUtil.ds(new Date(p.date.getFullYear(), p.date.getMonth() - 2, p.date.getDate()), "-");
                            n(b(o, s, "TRADING_DATES_URL").replace("$start", C).replace("$end", p.today).replace("$cb", "var usHistorydate"),
                            function() {
                                for (var F = window.usHistorydate.result.data,
                                E = F.length; E--;) {
                                    F[E] = k.dateUtil.sd(F[E])
                                }
                                F.length > 0 && !m.dateUtil.stbd(F[F.length - 1], p.date) && F.push(p.date),
                                z = i.gdf(F, p.date, !0),
                                j(p, N, B, z, u, x, q.dataformatter, o, D, I)
                            },
                            null, {
                                symbol: p.symbol,
                                market: u,
                                type: "tradedate"
                            })
                        } else {
                            n(b(o, N, "TRADING_DATES_URL"),
                            function() {
                                var E = window.datelist;
                                z = i.gdf(E, p.date),
                                j(p, N, B, z, u, x, q.dataformatter, o, null, null, t)
                            },
                            null, {
                                symbol: p.symbol,
                                market: u,
                                type: "tradedate"
                            })
                        }
                    } else {
                        null()
                    }
                }
            },
            M = function(p, t) {
                n(p,
                function() {
                    var G = window[g[u].T_Head_STR + D];
                    window[g[u].T_Head_STR + D] = null;
                    var B, F = window["kke_future_" + t.symbol] || {
                        time: [["06:00", "23:59"], ["00:00", "05:00"]]
                    },
                    E = window["kke_future_" + t.symbol] || {
                        time: [["09:30", "11:29"], ["13:00", "02:59"]]
                    },
                    C = window["kke_global_index_" + t.symbol] || {
                        time: [["09:30", "11:29"], ["13:00", "02:59"]]
                    };
                    if ("" == G || null == G || G.result && null == G.result.data || G.result && G.result.data && G.result.data.length <= 0 || G.__ERROR) {
                        switch (v.msg = "empty", u) {
                        case "HF":
                            B = e.gltbt(1, t.prevclose, !0, u, [t.date], F.time);
                            break;
                        case "NF":
                            B = e.gltbt(1, t.prevclose, !0, u, [t.date], E.time);
                            break;
                        case "global_index":
                            B = e.gltbt(1, t.prevclose, !0, u, [t.date], C.time);
                            break;
                        default:
                            B = e.gltbt(1, t.prevclose, !0, u)
                        }
                    } else {
                        switch (v.msg = "", u) {
                        case "HF":
                            var A = t.today.split("-"),
                            z = A[0] + "-" + (Number(A[1]) < 10 ? "0" + A[1] : A[1]) + "-" + (Number(A[2]) < 10 ? "0" + A[2] : A[2]);
                            B = z < G.result.data.minLine_1d[0][0] ? e.gltbt(1, t.prevclose, !0, u, null, F.time) : X(G, t, F),
                            "hf_ES" == t.symbol && t.time > F.time[0][0] && !m.dateUtil.stbd(B[0].date, t.date) && (B = e.gltbt(1, t.prevclose, !0, u, [t.date], F.time));
                            break;
                        case "NF":
                            B = X(G, t, E);
                            break;
                        case "global_index":
                            B = X(G, t, C);
                            break;
                        default:
                            B = X(G, t)
                        }
                    }
                    if (B && !B[0].date && (B[0].date = t.date), v.data.td1 = B, !w) {
                        return 0 != h && (B[0].lastfive = h),
                        void(m.isFunc(x) && x(v))
                    }
                    switch (u) {
                    case "HF":
                        U(t, B, F);
                        break;
                    case "NF":
                        U(t, B, E);
                        break;
                    case "global_index":
                        U(t, B, C);
                        break;
                    default:
                        U(t, B)
                    }
                },
                function() {},
                {
                    market: u,
                    symbol: t.symbol,
                    type: "t1"
                })
            },
            W = function() {
                KKE.api("datas.hq.get", {
                    symbol: s,
                    withI: V,
                    cancelEtag: !0,
                    ssl: o
                },
                function(t) {
                    var A = t.data[0];
                    if (v.data.hq = A, A.name || (A.name = s), !A.name && "CFF" != u) {
                        return v.msg = "error",
                        void(m.isFunc(x) && x(v))
                    }
                    var z = b(o, N, "T_URL").replace("$rn", (new Date).getTime()).replace("$symbol", I).replace("$cb", "var t1" + D),
                    p = S(A.today);
                    return "CN" != u || m.dateUtil.stbd(m.dateUtil.sd(A.today), m.dateUtil.sd(r)) ? void M(z, A) : void y(p)
                })
            };
            W()
        };
        var j = function(s, p, N, T, y, r, D, V, u, X, v) {
            var q = {
                msg: null,
                data: {
                    td1: null,
                    td5: null,
                    hq: null
                }
            };
            if (q.data.hq = s, q.data.td1 = N, s.name || (s.name = s.symbol), !s.name && "CFF" != y) {
                return q.msg = "error",
                void(m.isFunc(r) && r(q))
            }
            var x = function() {
                var z = i.ctdb(5, N, s, T, y);
                q.data.td5 = z;
                var t = "lastfive" + p,
                A = p.substring(2);
                n(b(V, p, "LAST5_URL").replace("$rn", (new Date).getHours()).replace("$symbol", A).replace("$cb", "var " + t + "="),
                function() {
                    var B = window[t];
                    return B ? (q.data.td5[4][0].lastfive = h = Number(B.volume), void(m.isFunc(r) && r(q))) : void(m.isFunc(r) && r(q))
                },
                function() {
                    q.data.td5 = z,
                    m.isFunc(r) && r(q)
                },
                {
                    symbol: s.symbol,
                    market: y,
                    type: "lastfive"
                })
            },
            W = function() {
                n(b(V, p, "T5_URL").replace("$rn", (new Date).getTime()).replace("$symbol", X).replace("$cb", "var t5" + u + "="),
                function() {
                    var J = String(window["t5" + u]),
                    F = [],
                    z = J.split(" ");
                    z.shift();
                    for (var I = z.length; I--;) {
                        var G = i.us(z[I], s, !0);
                        z[I] = i.pkt(G, s, y, !0)
                    }
                    if (window["t5" + p] = null, "" == J) {
                        q.msg = "empty"
                    } else {
                        q.msg = "";
                        var A = T.length,
                        B = 0,
                        t = z.length,
                        E = [];
                        for (I = A - 1; I > A - 6; I--) {
                            E.unshift(e.gltbt(1, s.prevclose, !1, "US", [T[I]]))
                        }
                        for (I = A - 1; I > A - 6; I--) {
                            for (var H, C = 0,
                            K = 0; t > K; K++) {
                                m.dateUtil.stbd(T[I], z[K][0].date) && (H = z[K], C = 1, B = K)
                            }
                            0 == C && (H = e.gltbt(1, E[B][0].prevclose, !1, "US", [T[I]])),
                            F.unshift(H)
                        }
                    }
                    F[4] = N,
                    q.data.td5 = F,
                    m.isFunc(r) && r(q)
                },
                null, {
                    market: y,
                    symbol: s.symbol,
                    type: "t5"
                })
            },
            o = function(z) {
                var t = "CFF_RE_" == p.substring(0, 7) ? p.slice(7) : p;
                n(b(V, p, "T5_URL").replace("$rn", (new Date).getTime()).replace("$symbol", t).replace("$cb", "var t5" + p),
                function() {
                    var B = window["t5" + p],
                    H = [];
                    if (window["t5" + p] = null, "" == B) {
                        q.msg = "empty"
                    } else {
                        if (void 0 == B) {
                            return q.msg = "data error.",
                            void w()
                        }
                        q.msg = "";
                        for (var G = [], E = B.length, A = 0; E > A; A++) {
                            var F = i.futures(B[A], s, y, "his", z);
                            if (!m.dateUtil.stbd(m.dateUtil.sd(F[0].d), s.date)) {
                                var C = i.pkt(F, s, y, !0);
                                G.push(C),
                                H.push(C)
                            }
                        }
                    }
                    H[4] = N,
                    q.data.td5 = H,
                    m.isFunc(r) && r(q)
                },
                null, {
                    market: y,
                    symbol: s.symbol,
                    type: "t5"
                })
            },
            w = function(t) {
                q.data.td5 = i.ctdb(5, N, s, T, y, t),
                m.isFunc(r) && r(q)
            },
            Y = function(t) {
                n(b(V, p, "T5_URL").replace("$symbol", p.replace("nf_", "")).replace("$cb", "var t5" + p),
                function() {
                    var A = window["t5" + p],
                    M = [];
                    if (window["t5" + p] = null, "" == A) {
                        q.msg = "empty"
                    } else {
                        if (void 0 == A) {
                            return q.msg = "data error.",
                            void w()
                        }
                        q.msg = "";
                        for (var J = [], B = A.length, K = 0; B > K; K++) {
                            var H = i.futures(A[K], s, y, "his", t);
                            if (!m.dateUtil.stbd(m.dateUtil.sd(H[0].d), s.date) || "21:00" == t.time[0][0] && s.time >= "21:00" || s.time <= "02:30") {
                                var L = i.pkt(H, s, y, !0, t);
                                J.push(L)
                            }
                        }
                        B = 5;
                        var I;
                        I = "21:00" == t.time[0][0] && s.time >= "21:00" || s.time <= "02:30" ? 5 : 6;
                        var F = T.splice(T.length - I, 5),
                        G = 0;
                        for (K = B - 1; K >= 0; K--) {
                            for (var z = G; z < J.length && !(M.length > 3); z++) {
                                if (m.dateUtil.stbd(J[J.length - z - 1][0].date, F[K])) {
                                    M.unshift(J[J.length - z - 1]),
                                    G++;
                                    break
                                }
                                if (z == J.length - 1) {
                                    for (var C = 0,
                                    E = 0; E < J.length; E++) {
                                        m.dateUtil.stbd(J[J.length - E - 1][0].date, F[K]) && (C = 1)
                                    }
                                    0 == C && M.unshift(e.gltbt(1, J[J.length - 1][0].prevclose, !1, y, [F[K]], t.time))
                                }
                            }
                            if (J.length <= 0) {
                                if (M.length > 3) {
                                    break
                                }
                                M.unshift(e.gltbt(1, s.prevclose, !1, y, [F[K]], t.time))
                            } else {
                                G == J.length && M.length < 4 && M.length > 0 && !m.dateUtil.stbd(M[0][0].date, F[K]) && M.unshift(e.gltbt(1, J[J.length - 1][0].prevclose, !1, y, [F[K]], t.time))
                            }
                        }
                    }
                    M[4] = N,
                    q.data.td5 = M,
                    m.isFunc(r) && r(q)
                },
                null, {
                    market: y,
                    symbol: s.symbol,
                    type: "t5"
                })
            },
            Z = function(t) {
                n(b(V, p, "T5_URL").replace("$symbol", p.replace("hf_", "")).replace("$cb", "var t5" + p),
                function() {
                    var F = window["t5" + p],
                    P = [];
                    if (window["t5" + p] = null, "" == F) {
                        q.msg = "empty"
                    } else {
                        if (void 0 == F) {
                            return q.msg = "data error.",
                            void w()
                        }
                        q.msg = "";
                        for (var H = [], E = F.result.data[p.replace("hf_", "")].length, Q = 0; E > Q; Q++) {
                            var I = i.hf(F.result.data[p.replace("hf_", "")][Q], s, y, "his", t);
                            if (!m.dateUtil.stbd(m.dateUtil.sd(I[0].d), s.date)) {
                                var B = i.pkt(I, s, y, !0, t);
                                H.push(B)
                            }
                        }
                        for (var J = [], C = N[0].date || s.date, O = 1; J.length < 6;) {
                            var A = new Date(C);
                            A.setDate(C.getDate() - O),
                            6 != A.getDay() && 0 != A.getDay() && J.push(A),
                            O++
                        }
                        var K, L = J.length,
                        M = 1;
                        for (Q = 0; L > Q; Q++) {
                            for (K = M; K <= H.length && !(P.length > 3); K++) {
                                if (m.dateUtil.stbd(H[H.length - K][0].date, J[Q])) {
                                    P.unshift(H[H.length - K]),
                                    M++;
                                    break
                                }
                                if (K == H.length - 1) {
                                    for (var z = 0,
                                    G = 1; G <= H.length; G++) {
                                        m.dateUtil.stbd(H[H.length - G][0].date, J[Q]) && (z = 1)
                                    }
                                    0 == z && P.unshift(e.gltbt(1, H[H.length - 1][0].prevclose, !1, y, [J[Q]], t.time))
                                }
                            }
                            M >= H.length && P.length <= 3 && !m.dateUtil.stbd(P[0][0].date, J[Q]) && P.unshift(e.gltbt(1, H[H.length - 1][0].prevclose, !1, y, [J[Q]], t.time))
                        }
                    }
                    P[4] = N,
                    q.data.td5 = P,
                    m.isFunc(r) && r(q)
                },
                null, {
                    market: y,
                    symbol: s.symbol,
                    type: "t5"
                })
            },
            U = function() {
                n(b(V, p, "T5_URL").replace("$rn", (new Date).getTime()).replace("$symbol", p).replace("$cb", "var t5" + p),
                function() {
                    var z = window["t5" + p],
                    B = T.length,
                    F = [];
                    if (window["t5" + p] = null, "" == z) {
                        q.msg = "empty"
                    } else {
                        q.msg = "";
                        for (var C = z.result.data.length,
                        t = 0; C > t; t++) {
                            var E = i.optionCn(z.result.data[t], s, "CN"),
                            A = i.pkt(E, s, "CN", !0);
                            F.push(A)
                        }
                        var G = F[0] ? F[0][0].prevclose: s.prevclose;
                        for (t = B - 1 - C; t > B - 6; t--) {
                            F.unshift(e.gltbt(1, G, !1, "CN", [T[t]]))
                        }
                    }
                    F[4] = N,
                    q.data.td5 = F,
                    m.isFunc(r) && r(q)
                },
                null, {
                    market: y,
                    symbol: s.symbol,
                    type: "t5"
                })
            },
            aa = function() {
                n(b(V, p, "T5_URL").replace("$symbol", p).replace("$rn", s.today),
                function() {
                    var z = "lastfive" + p,
                    t = window["KLC_ML_" + p];
                    window["KLC_ML_" + p] = null;
                    var A, B;
                    "" == t ? (q.msg = "empty", A = i.ctdb(5, N, s, T, y)) : (q.msg = "", B = t.split(","), A = i.ctdf(B, N, s, T)),
                    i.isBond(p) ? (q.data.td5 = A, m.isFunc(r) && r(q)) : n(b(V, p, "LAST5_URL").replace("$rn", (new Date).getHours()).replace("$symbol", p),
                    function() {
                        var G = window[z];
                        if (!G || !G.lastfive) {
                            return q.data.td5 = A,
                            void(m.isFunc(r) && r(q))
                        }
                        for (var F = G.lastfive.length; F--;) {
                            for (var E = G.lastfive[F].d, C = A.length - 1; C--;) {
                                if (m.dateUtil.stbds(A[C][0].date, E, null)) {
                                    A[C][0].lastfive = Number(G.lastfive[F].c);
                                    break
                                }
                            }
                        }
                        h = s.lastfive ? s.lastfive: 0,
                        q.data.td5 = A,
                        m.isFunc(r) && r(q)
                    },
                    function() {
                        q.data.td5 = A,
                        m.isFunc(r) && r(q)
                    },
                    {
                        market: y,
                        symbol: s.symbol,
                        type: "lastfive"
                    })
                },
                function() {
                    q.data.td5 = i.ctdb(5, N, s, T, y),
                    q.msg = "error",
                    m.isFunc(r) && r(q)
                },
                {
                    market: y,
                    symbol: s.symbol,
                    type: "t5"
                })
            };
            switch (y) {
            case "HK":
                x();
                break;
            case "US":
                W();
                break;
            case "CFF":
                o(v);
                break;
            case "OTC":
            case "fund":
                w();
                break;
            case "NF":
                0 == d ? w(v) : Y(v);
                break;
            case "option_cn":
                U();
                break;
            case "global_index":
                w(v);
                break;
            case "op_m":
                w();
                break;
            case "CN":
                aa();
                break;
            case "HF":
                0 == d ? w(v) : Z(v);
                break;
            case "":
            }
        }
    }
});
xh5_define("chart.h5t", ["cfgs.settinger", "utils.util", "utils.painter"],
function(f, y, b) {
    function m(k) {
        function z(aW, ar) {
            function a0(av) {
                ao.setDataRange(av),
                at && (at.linkData(av), at.setDataRange()),
                aT && (aT.linkData(av), aT.setDataRange()),
                aV && (aV.linkData(av), aV.setDataRange())
            }
            function aS() {
                ar && (I = am),
                a5.update(null, !0),
                "CN" === a7 && !/^(sh0|sh1|sh5|sz1|sz399)\d+/i.test(aW.symbol)
            }
            aW = t({
                symbol: void 0,
                datas: {
                    t1: {
                        url: void 0,
                        dataformatter: void 0
                    },
                    t5: {
                        url: void 0,
                        dataformatter: void 0
                    }
                },
                linecolor: void 0,
                linetype: void 0
            },
            aW || {});
            var au, aZ = this,
            a7 = y.market(aW.symbol),
            aX = function(av) {
                switch (av) {
                case "CN":
                    return 1;
                case "HK":
                    return 2;
                case "US":
                    return 3
                }
                return 1
            };
            this.business = aW.business;
            var a1 = !0;
            this.dp = aW.dp,
            this.marketNum = aX,
            this.isErr = !1,
            this.witht5 = !0,
            this.symbol = aW.symbol,
            this.isMain = ar,
            this.isCompare = !1,
            this.dAdd = 0,
            this.uid = aW.symbol + Math.random(),
            this.datas = null,
            this.dataLen = 0,
            this.dataLenOffset = 0,
            this.prevclose = void 0,
            this.labelMaxP = 0,
            this.maxPrice = 0,
            this.labelMinP = Number.MAX_VALUE,
            this.minPrice = Number.MAX_VALUE,
            this.labelMaxVol = 0,
            this.maxVolume = 0,
            this.minPercent = Number.MAX_VALUE,
            this.maxPercent = -Number.MAX_VALUE,
            this.labelPriceCount = void 0,
            this.isTotalRedraw = !0,
            this.realLen = 0,
            this.market = a7,
            this.date = null,
            this.hq = null,
            this.futureTime = K || C || w,
            this.gbiTime = w,
            this.preData = {
                data: 0,
                vPos: null
            },
            this.needMarket = a7,
            this.changeMarket = function(aw) {
                var ax, az = [],
                av = aw;
                if (A = H.tcd(W), aX(aZ.needMarket) != aX(W)) {
                    ax = am.get(),
                    au = y.tUtil.gata(W);
                    for (var ay = 0; ay < ax.length; ay++) {
                        aX(aZ.needMarket) < aX(W) ? (az.push(H.aduk(ax[ay], aZ.market, W, al, ax[ay][0].date)), aZ.realLen = y.arrIndexOf(au, al.getHours() + ":" + y.strUtil.zp(al.getMinutes())), aZ.realLen < 0 && (aZ.realLen = A)) : (az.push(H.rmuk(ax[ay], W, av)), aZ.realLen = y.arrIndexOf(au, al.getHours() + ":" + y.strUtil.zp(al.getMinutes())))
                    }
                    aZ.needMarket = W,
                    am.initTState(az),
                    aZ.datas = az[4],
                    ao.setDataRange(),
                    ao.createPlayingData()
                }
            };
            var at, aT, aV, a4, al, a6 = new V(this, aW);
            this.getName = function() {
                return a4 || ""
            },
            this.getStockType = function() {
                var av;
                return aZ.hq && (av = aZ.hq.type),
                av || ""
            },
            this.viewState = Y;
            var am = new
            function() {
                var av = {},
                aw = {
                    rsAmount: void 0
                },
                ax = function(aB) {
                    if (aB) {
                        var aF, aH = aB.length,
                        aG = [];
                        if (y.clone(aB, aG), aG.length > 5) {
                            if (k.date) {
                                for (var ay, aD = Number(k.date.split("-")[2]), aA = 0, az = 0, aC = 0, aE = aG.length; aE > aC; aC++) {
                                    ay = aG[aC][0].date.getDate(),
                                    0 == aC ? aA = Math.abs(ay - aD) : aA > Math.abs(ay - aD) && (aA = Math.abs(ay - aD), az = aC)
                                }
                                az >= 5 ? (aF = aG.splice(az - 4, 5), Y.start = 4, Y.end = 5) : (aF = aG.splice(0, 5), Y.start = az, Y.end = az + 1),
                                av.tv = Y.start,
                                av.tb = Y.end
                            }
                        } else {
                            aF = aG,
                            av.tv = k.date ? 0 : 4,
                            av.tb = aH
                        }
                        av.t = aF
                    }
                };
                this.get = function(ay) {
                    return ay ? av[ay] : av.t
                },
                this.set = function(ay, az) {
                    "undefined" != typeof av[ay] && (av[ay] = az)
                },
                this.initState = ax,
                this.initTState = function(ay) {
                    ax(ay)
                },
                this.extraDataObj = aw,
                this.initExtraData = function() {
                    var aA = "http",
                    az = aA + "://stock.apo51.cn/stock/api/jsonp.php/$cb/StockService.getAmountBySymbol?_=$rn&symbol=$symbol",
                    ay = "KKE_ShareAmount_" + aW.symbol;
                    y.load(az.replace("$symbol", aW.symbol).replace("$rn", String((new Date).getDate())).replace("$cb", "var%20" + ay + "="),
                    function() {
                        var aB = window[ay];
                        if (aB) {
                            for (var aC, aE = [], aD = aB.length; aD--;) {
                                aC = aB[aD],
                                aE.push({
                                    amount: Number(aC.amount),
                                    date: g.sd(aC.date)
                                })
                            }
                            aE.length && (aw.rsAmount = aE)
                        }
                    })
                },
                this.gc = function() {
                    av = null,
                    aw = null
                }
            },
            ao = new
            function() {
                var ax, av, aw;
                ax = function() {
                    aZ.minPrice = Number.MAX_VALUE,
                    aZ.maxPrice = 0,
                    aZ.minPercent = Number.MAX_VALUE,
                    aZ.maxPercent = -Number.MAX_VALUE,
                    aZ.minavgPrice = Number.MAX_VALUE,
                    aZ.maxavgPrice = 0,
                    aZ.maxVolume = 0
                },
                av = function() {
                    function aD(aL) {
                        var aM = Math.max(Math.abs(aL - aZ.maxPrice), Math.abs(aL - aZ.minPrice)),
                        aK = Math.max(Math.abs(aL - aZ.maxavgPrice), Math.abs(aL - aZ.minavgPrice));
                        switch (aM / aL > 0.45 && "US" != W && (B.datas.scaleType = "price"), aM / aL > 0.1 && "newstock" == B.datas.scaleType && (B.datas.scaleType = "price"), B.datas.scaleType) {
                        case "newstock":
                            aZ.minPrice = Number(aL) - 0.45 * aL,
                            aZ.maxPrice = Number(aL) + 0.45 * aL;
                            break;
                        case "tpct":
                            aZ.minPrice = aZ.minPrice < Number(aL) - 0.1 * aL ? aZ.minPrice: Number(aL) - 0.1 * aL,
                            aZ.maxPrice = aZ.maxPrice > Number(aL) + 0.1 * aL ? aZ.maxPrice: Number(aL) + 0.1 * aL;
                            break;
                        case "pct":
                            var aJ = aZ.maxPrice - aZ.minPrice;
                            aZ.minPrice -= 0.05 * aJ,
                            aZ.maxPrice += 0.05 * aJ;
                            break;
                        case "price":
                        default:
                            aZ.minPrice = Number(aL) - Number(aM),
                            aZ.maxPrice = Number(aL) + Number(aM),
                            aZ.minavgPrice = Number(aL) - Number(aK),
                            aZ.maxavgPrice = Number(aL) + Number(aK)
                        }
                        aZ.maxPercent = Math.max((aZ.maxPrice - aL) / aL, 0),
                        aZ.minPercent = Math.min((aZ.minPrice - aL) / aL, 0),
                        aZ.maxavgPercent = Math.max((aZ.maxavgPrice - aL) / aL, 0),
                        aZ.minavgPercent = Math.min((aZ.minavgPrice - aL) / aL, 0)
                    }
                    aZ.isCompare = G.getAllStock().length > 1,
                    aZ.dAdd = G.dAdd;
                    var az;
                    aZ.datas && 0 == aZ.datas[0][0].volume && aZ.hq.time > "09:30" && "CN" == aZ.market && (az = aZ.datas[0][0].price),
                    aZ.preData.data = aZ.hq.preopen ? az ? az: aZ.hq.preopen: aZ.preData.data;
                    for (var aA = 0,
                    aG = aZ.datas.length; aG > aA; aA++) {
                        for (var aI, aH = Number(aZ.datas[0][0].prevclose), ay = 0, aE = aZ.dataLen; aE > ay; ay++) {
                            aI = aZ.datas[aA][ay],
                            aI.price <= 0 || aI.avg_price <= 0 || ("HK" == aZ.market && aZ.hq && "indx" == aZ.hq.type ? (aZ.maxPrice = Math.max(aZ.maxPrice, aI.price, aH), aZ.minPrice = Math.min(aZ.minPrice, aI.price, aH)) : h(aZ.datas[aA][0].date, aZ.hq.date) && "CN" == aZ.market ? (aZ.maxPrice = Math.max(aZ.maxPrice, aI.price, aI.avg_price, aH, aZ.preData.data), aZ.minPrice = Math.min(aZ.minPrice, aI.price, aI.avg_price, aH, aZ.preData.data)) : (aZ.maxPrice = Math.max(aZ.maxPrice, aI.price, aI.avg_price, aH), aZ.minPrice = Math.min(aZ.minPrice, aI.price, aI.avg_price, aH)), h(aZ.datas[aA][0].date, aZ.hq.date) && "CN" == aZ.market ? (aZ.maxavgPrice = Math.max(aZ.maxavgPrice, aI.price, aH, aZ.preData.data), aZ.minavgPrice = Math.min(aZ.minavgPrice, aI.price, aH, aZ.preData.data)) : (aZ.maxavgPrice = Math.max(aZ.maxavgPrice, aI.price, aH), aZ.minavgPrice = Math.min(aZ.minavgPrice, aI.price, aH)), aZ.labelMaxVol = aZ.maxVolume = Math.max(aZ.maxVolume, 0, aI.volume))
                        }
                        aD(aH)
                    } (aZ.minPrice < -100000000 || aZ.maxPrice - aZ.minPrice < 0.000001) && (g.stbd(aZ.datas[0][0].date, aZ.hq.date) && (aZ.datas[0][0].price = aZ.hq.price, aZ.datas[0][0].avg_price = aZ.hq.price, aZ.datas[0][0].prevclose = aZ.hq.prevclose, aZ.datas[0][0].volume = aZ.hq.totalVolume), aZ.minPrice = aH - 0.01 * aH, aZ.maxPrice = aH + 0.01 * aH, aZ.maxPercent = 0.01, aZ.minPercent = -0.01, aZ.hq.totalVolume > 0 && g.stbd(aZ.datas[0][0].date, aZ.hq.date) && !isNaN(aZ.hq.totalAmount) && (aZ.datas[0][0].volume = aZ.hq.totalAmount / aZ.hq.totalVolume));
                    var aC = n(aZ.maxVolume, 0, 0, !0);
                    aZ.labelMaxVol = aC[0];
                    var aB, aF = 0.005;
                    /^s[hz]51\d{4}$/.test(k.symbol) && (aB = "fund"),
                    aB && "fund" === aB && "pct" !== B.datas.scaleType && aF > Math.abs(aZ.minPercent) && (aF = Math.abs(aZ.minPercent), k.nfloat = aZ.nfloat = 3),
                    aZ.maxPercent < aF && "US" !== aZ.market && "pct" !== B.datas.scaleType && (aZ.minPrice = aZ.maxavgPrice = aH - aH * aF, aZ.maxPrice = aZ.minavgPrice = aH + aH * aF, aZ.maxPercent = aZ.maxavgPercent = aF, aZ.minPercent = aZ.minavgPercent = -aF),
                    ("gb_brk$a" === aZ.symbol || "usr_brk$a" === aZ.symbol) && (k.nfloat = aZ.nfloat = 1)
                },
                aw = function() {
                    var aE, az, aB, aG = B.DIMENSION.h_t,
                    aI = aG * B.DIMENSION.P_HV,
                    aL = aG * (1 - B.DIMENSION.P_HV);
                    az = aZ.labelMinP,
                    aB = aZ.labelMaxP;
                    var aJ, ay = aZ.labelMaxVol;
                    if (aZ.datas) {
                        var aH = aZ.datas.length;
                        for (aE = 0; aH > aE; aE++) {
                            aJ = aZ.datas[0][0].prevclose;
                            for (var aD, aC = B.custom.show_underlay_vol,
                            aA = aZ.isCompare ? "ppp": "pp", aK = aZ.dataLen, aF = 0; aK > aF; aF++) {
                                if (aD = aZ.datas[aE][aF], !aD) {
                                    return
                                }
                                aD.price <= 0 && aZ.realLen >= aF && aF > 0 && (aD.price = aZ.hq.price, aD.avg_price = aZ.datas[aE][aF - 1].avg_price, aD.volume = 0),
                                aD.change = aD.price - aJ,
                                aD.percent = aD.change / aJ,
                                aD.py = p[aA](aD.price, az, aB, aG, aJ),
                                aD.ay = p[aA](aD.avg_price, az, aB, aG, aJ),
                                aC && (aD.vy = p.vp(aD.volume, ay, aI) + aL)
                            }
                        }
                        aZ.preData.vPos = "CN" == aZ.market && 1 == aH && h(aZ.hq.date, aZ.datas[0][0].date) ? p[aA](aZ.preData.data, az, aB, aG, aJ) : null
                    }
                },
                this.createPlayingData = aw,
                this.extValues = function() {
                    ax(),
                    av()
                },
                this.setDataRange = function(az) {
                    var ay = am.get();
                    if (ay) {
                        Y.dataLength = ay.length;
                        var aB = Y.start,
                        aD = Y.end;
                        isNaN(aB) || isNaN(aD) ? (aD = am.get("tb") || 5, aB = am.get("tv") || 4, Y.start = aB, Y.end = aD) : (az && aD + 1 > ay.length && (Y.end = aD = ay.length), am.set("tv", aB), am.set("tb", aD));
                        var aC = [],
                        aE = [];
                        if (ay.length < 2) {
                            aE = ay,
                            aC.push(ay)
                        } else {
                            for (var aA = aB; aD > aA; aA++) {
                                aE = aE.concat(ay[aA]),
                                aC.push(ay[aA])
                            }
                        }
                        aZ.datas = aC,
                        aZ.lineDatas = aE,
                        aZ.dataLen = aC[0].length,
                        ax(),
                        av()
                    }
                }
            },
            aY = {},
            a8 = !1,
            ak = !1,
            aU = {},
            a2 = (new Date).getTime(),
            ap = function() {
                var av;
                al = new Date,
                av = 60 * al.getTimezoneOffset() * 1000,
                al.setTime(al.getTime() + av),
                al.setHours(al.getHours() + 8)
            },
            a3 = function(av) {
                if (ap(), !au) {
                    switch (W) {
                    case "HF":
                        au = y.tUtil.gata(W, C.time);
                        break;
                    case "NF":
                        au = y.tUtil.gata(W, K.time);
                        break;
                    case "global_index":
                        au = y.tUtil.gata(W, w.time);
                        break;
                    default:
                        au = y.tUtil.gata(W)
                    }
                }
                av.index = y.arrIndexOf(au, av.time);
                var aw = av.index;
                switch (aZ.market) {
                case "CN":
                case "option_cn":
                case "fund":
                case "OTC":
                case "global_index":
                case "NF":
                    av.index < 0 && (av.time >= "11:30" && av.time < "13:00" && (aw = y.arrIndexOf(au, "11:29")), "NF" == aZ.market && ("21:00" == K.time[0][0] ? av.time < "09:00" && av.time > "02:30" && (aw = y.arrIndexOf(au, "09:00")) : av.time <= K.time[0][0] && (aw = y.arrIndexOf(au, K.time[0][0]))));
                    break;
                case "HK":
                    av.time >= "12:00" && av.time < "13:00" && (aw = 150);
                    break;
                case "HF":
                    "hf_CHA50CFD" == aZ.symbol && av.time > "16:00" && av.time < "17:00" && (aw = 420)
                }
                if (aZ.realLen = aw, aZ.hq.open == aZ.hq.prevclose && aZ.hq.high == aZ.hq.prevclose && aZ.hq.low == aZ.hq.prevclose && 0 > aw || aZ.hq.time < "09:30") {
                    switch (aZ.market) {
                    case "CN":
                        aZ.realLen = aZ.hq.time >= "15:00" ? A - 1 : 0;
                        break;
                    case "NF":
                    case "HF":
                    case "global_index":
                        break;
                    default:
                        aZ.realLen = 0
                    }
                }
            },
            aR = function(aw, ay) {
                var ax = aw.getTime(),
                av = ay.getTime();
                return Math.floor((ax - av) / 86400000) > 5
            },
            a5 = new
            function() {
                var aB, aw = !0,
                av = function(aN) {
                    var aJ;
                    switch (W) {
                    case "HF":
                        aJ = C.time;
                        break;
                    case "NF":
                        aJ = K.time;
                        break;
                    case "global_index":
                        aJ = w.time;
                        break;
                    default:
                        aJ = []
                    }
                    var aI = y.tUtil.gltbt(1, aN.price, !0, aZ.needMarket, [aN.date], aJ);
                    "NF" == W && aN.time >= "21:00" ? (aI[0].date = g.dd(aN.date), aI[0].date.setDate(aN.date.getDate() + 1)) : aI[0].date = g.dd(aN.date),
                    aI[0].prevclose = aN.price,
                    aI[0].price = aN.price,
                    aI[0].volume = 0;
                    for (var aL = 0,
                    aG = 0,
                    aM = am.get(), aH = 0, aK = aM.length; aK > aH; aH++) {
                        aM[aH][0].totalVolume && (aG += Number(aM[aH][0].totalVolume), aL++)
                    }
                    aI[0].lastfive = aG / aL / 390 || 0,
                    h(aM[4][0].date, aN.date) ? "NF" == W && aN.time >= "21:00" ? (aM.shift(), aM.push(aI)) : aM[4] = aI: (aM.shift(), aM.push(aI)),
                    am.initTState(aM),
                    aZ.datas = [aM[4]],
                    aZ.date = g.ds(aN.date),
                    aZ.realLen = 0
                },
                ay = 0,
                aE = function(aG, aI) {
                    function aJ() {
                        switch (av(aZ.hq), a0(), ao.createPlayingData(), aZ.market) {
                        case "US":
                            ao.extValues();
                            break;
                        case "NF":
                            K.inited = 1
                        }
                        y.isFunc(aI) && aI()
                    }
                    function aM() {
                        var aO = (new Date).getTime() - a2;
                        return ! isNaN(j) && j > 0 && aO >= 1000 * Number(j) && 0 != aZ.realLen && aZ.hq.isUpdateTime ? (a2 = (new Date).getTime(), aA(aH, aZ.hq, aI), !0) : !1
                    }
                    function aK() {
                        function aO() {
                            h(aZ.hq.date, aL[4][0].date) && aZ.hq.time > "16:00" && aP.price < 0 && (aP.price = aZ.hq.price, aP.avg_price = aL[4][aL[4].length - 2].avg_price, aP.volume = 0)
                        }
                        function aQ() {
                            h(aZ.hq.date, aL[4][0].date) && aZ.hq.time > "16:00" && (aP.price = aZ.hq.price, aP.avg_price = aL[4][aL[4].length - 2].avg_price, aP.volume = 0, aP.time = aZ.hq.time, aP.avg_price < 0 && (aP.avg_price = aZ.hq.price))
                        }
                        if (!aZ.hq.isUpdateTime) {
                            var aP = aL[4][aL[4].length - 1];
                            switch (aZ.market) {
                            case "US":
                                aO();
                                break;
                            case "HK":
                                aQ()
                            }
                            return a3(aZ.hq),
                            a0(!0),
                            ao.createPlayingData(),
                            y.isFunc(aI) && aI(),
                            !0
                        }
                        return aZ.date = "NF" == aZ.market && aZ.hq.time >= "21:00" ? g.ds(aL[4][0].date) : aZ.hq.today,
                        !1
                    }
                    var aH, aL = am.get();
                    switch (aZ.needMarket) {
                    case "HF":
                        au = y.tUtil.gata(aZ.needMarket, C.time);
                        break;
                    case "NF":
                        au = y.tUtil.gata(aZ.needMarket, K.time);
                        break;
                    case "global_index":
                        au = y.tUtil.gata(aZ.needMarket, w.time);
                        break;
                    default:
                        au = y.tUtil.gata(aZ.needMarket)
                    }
                    if (aG && aG.date && aZ.datas && !k.date) {
                        if (aw = !1, aH = aL[4], aZ.hq.isDateChange) {
                            if ("NF" == aZ.market && K && K.time[0][0] < "21:00" || "NF" != aZ.market) {
                                return void aJ()
                            }
                        } else {
                            if ("CN" == aZ.market && !h(aZ.hq.date, aL[4][0].date) && aZ.hq.time < "09:05" || "NF" == aZ.market && h(aZ.hq.date, aL[4][0].date) && K && "21:00" == K.time[0][0] && aZ.hq.time >= K.time[0][0] || "HF" == aZ.market && !h(aZ.hq.date, aL[4][0].date) && 0 != aZ.hq.date.getDay() && 6 != aZ.hq.date.getDay() && aZ.hq.time >= C.time[0][0]) {
                                return void aJ()
                            }
                        }
                        if (!aM() && !aK()) {
                            if (aZ.datas && (aY = aL[4][0]), aR(aG.date, aL[4][0].date)) {
                                return void(aZ.realLen = A)
                            }
                            a4 = aG.name || "",
                            aZ.hq = aG;
                            var aN = aG.date.getHours() < 10 ? "0" + aG.date.getHours() : aG.date.getHours();
                            if (aZ.time = aN + ":" + y.strUtil.zp(aG.date.getMinutes()), 0 == aG.index && ax(aH, aG), y.arrIndexOf(au, aZ.time) && aG.index > 0 && (y.arrIndexOf(au, aZ.time) - aZ.realLen <= 1 ? ax(aH, aG) : aA(aH, aG, aI), 1 == aG.index && 0 == ay)) {
                                return ay = 1,
                                void aA(aH, aG, aI)
                            }
                            "HF" != aZ.market && "NF" != aZ.market && (aZ.hq.open == aZ.hq.prevclose && aZ.hq.high == aZ.hq.prevclose && aZ.hq.low == aZ.hq.prevclose && aZ.hq.index < 0 || aG.time < "09:30") && ("CN" == aZ.market ? (aH[0].avg_price = aG.price, aH[0].volume = aG.totalVolume) : "option_cn" == aZ.market || "NF" == aZ.market ? aH[0].inventory = aG.position || aG.holdingAmount: "HK" == aZ.market && (aH[0].avg_price = aG.totalAmount / aG.totalVolume || aG.price)),
                            5 == Y.end && (a0(!0), ao.createPlayingData()),
                            y.isFunc(aI) && aI()
                        }
                    }
                },
                aD = -1,
                aF = -1,
                az = -1,
                ax = function(aH, aI) {
                    var aJ = aH;
                    a3(aI);
                    var aG = aJ[aZ.realLen];
                    aG && (aY && !aB ? (a8 ? (aI.volume = aD = aI.totalVolume - (aY.totalVolume || 0), aI.amount = aF = aI.volume * aI.price, aI.totalAmount = aI.amount + aY.totalAmount, aI.avg_price = az = aI.totalAmount / aI.totalVolume || aI.price) : (aI.volume = 0, aI.avg_price = az = aY.totalAmount / aY.totalVolume || aI.price, aI.totalAmount = aI.totalVolume * aI.avg_price, a8 = !0), aY.totalVolume = aI.totalVolume, aY.totalAmount = aI.totalAmount) : (ak ? aI.volume = aI.totalVolume - aU.totalVolume || 0 : (aI.volume = 0, ak = !0), aU.totalVolume = aI.totalVolume), ("option_cn" == aZ.market || "NF" == aZ.market) && (aG.inventory = aI.position || aI.holdingAmount), "CN" == aZ.market ? aG.avg_price = aI.avg_price || aG.price: (aI.index > 1 ? aG.avg_price = (aJ[aI.index - 1].avg_price * aI.index + aI.price) / (aI.index + 1) || aG.price: "fund" == aZ.market || (aG.avg_price = aG.price || aI.price), 0 == aI.index && (aG.avg_price = aI.totalAmount / aI.totalVolume || aI.price), aG.volume = 0), "HK" != aZ.market && "NF" != aZ.market && (aG.volume += aI.volume), aG.price = aI.price, aG.volume <= 0 && (aG.volume = 0))
                },
                aA = function(aJ, aH, aG) {
                    var aI = {
                        symbol: aH.symbol,
                        date: aH.today,
                        withT5: 0,
                        withI: !1,
                        faker: "",
                        dataformatter: aW.datas.t1.dataformatter,
                        ssl: k.ssl
                    };
                    a8 = ak = !1,
                    KKE.api("datas.t.get", aI,
                    function(aL) {
                        aJ = aL.data.td1,
                        a3(aZ.hq);
                        var aK = am.get();
                        "NF" == aZ.market && ("21:00" == K.time[0][0] && aZ.hq.time >= K.time[0][0] && 0 != aZ.hq.date.getDay() && 6 != aZ.hq.date.getDay() && (aJ[0].date = aK[4][0].date), ("09:30" == K.time[0][0] || "09:15" == K.time[0][0]) && h(aK[4][0].date, aZ.hq.date) && aZ.hq.time <= K.time[0][0]) || ("HF" == aZ.market && aZ.hq.time > C.time[0][0] && 0 != aZ.hq.date.getDay() && 6 != aZ.hq.date.getDay() && (aJ[0].date = aZ.hq.date), aK[4] = aJ, am.initTState(aK), "CN" == aZ.market && "HK" == aZ.needMarket && (aZ.needMarket = "CN", G.changeData(aZ)), 5 == Y.end && (a0(!0), ao.createPlayingData()), y.isFunc(aG) && aG())
                    })
                },
                aC = function(aJ, aG, aI) {
                    var aH = {
                        symbol: aG.symbol,
                        date: aG.today,
                        withT5: 1,
                        dist5: 1,
                        withI: !1,
                        faker: "",
                        dataformatter: aW.datas.t1.dataformatter,
                        ssl: k.ssl
                    };
                    a8 = ak = !1,
                    KKE.api("datas.t.get", aH,
                    function(aK) {
                        aJ = aK.data.td1,
                        am.initTState(aK.data.td5),
                        a3(aZ.hq),
                        y.isFunc(aI) && aI(),
                        G.moving(Y.start, Y.end, "T5"),
                        R.hide()
                    })
                };
                this.updateT5Data = aC,
                this.update = function(aJ, aL, aN, aH) {
                    var aG, aM, aI, aK = "";
                    aI = aH ? aH: y.market(aW.symbol),
                    "US" == aI && (aK = ",gb_ixic"),
                    aN ? (aG = "datas.hq.parse", aM = {
                        symbol: aW.symbol + aK,
                        hqStr: aN,
                        market: aI,
                        ssl: k.ssl
                    }) : (aG = "datas.hq.get", aM = {
                        symbol: aW.symbol + aK,
                        delay: !0,
                        cancelEtag: aw,
                        ssl: k.ssl
                    }),
                    KKE.api(aG, aM,
                    function(aO) {
                        aE(aO.dataObj[aW.symbol], aJ)
                    })
                }
            },
            an = new
            function() {
                var av = void 0,
                aw = 1,
                az = function(aA) {
                    aw > 2 || (U.re(a.e.T_DATA_LOADED), y.isFunc(aA) && aA(), aw++)
                },
                ax = function(aA) {
                    var aC = aA,
                    aB = !1;
                    return aB = aC.hq.open == aC.hq.prevclose && aC.hq.high == aC.hq.prevclose && aC.hq.low == aC.hq.prevclose && aC.hq.index < 0 ? !0 : aC.hq.time < "09:30"
                },
                ay = function(aF, aE) {
                    var aA, aC, aB = aF;
                    switch (W) {
                    case "HF":
                        aC = C.time;
                        break;
                    case "NF":
                        aC = K.time;
                        break;
                    case "global_index":
                        aC = w.time;
                        break;
                    default:
                        aC = []
                    }
                    var aD = y.tUtil.gltbt(1, aB.hq.price, !0, aZ.market, [aB.hq.date], aC);
                    return aD[0].name = aB.hq.name,
                    aD[0].symbol = aW.symbol,
                    aD[0].today = y.dateUtil.ds(aB.hq.date, "-"),
                    aA = aE,
                    aA[4] = aD,
                    aZ.realLen = 0,
                    aA
                };
                this.init = function(aA) {
                    var aC = Y.viewId;
                    if (av != aC) {
                        av = aC,
                        null != aZ.datas && am.initTState(aC, aZ.tDb.get());
                        var aB = {
                            ssl: k.ssl,
                            symbol: aW.symbol,
                            date: k.date,
                            withT5: 1,
                            dist5: k.dist5,
                            withI: !0,
                            faker: aZ.needMarket,
                            dataformatter: aW.datas.t1.dataformatter
                        };
                        switch (aZ.needMarket) {
                        case "HF":
                            au = y.tUtil.gata(aZ.needMarket, C.time);
                            break;
                        case "NF":
                            au = y.tUtil.gata(aZ.needMarket, K.time);
                            break;
                        case "global_index":
                            au = y.tUtil.gata(aZ.needMarket, w.time);
                            break;
                        default:
                            au = y.tUtil.gata(aZ.needMarket)
                        }
                        R.show(),
                        KKE.api("datas.t.get", aB,
                        function(aH) {
                            G.hasHistory && "history" == aH.msg && G.hasHistory(aa);
                            var aG = aH.data.hq.status,
                            aK = "",
                            aL = Number(aH.data.hq.state);
                            if ("empty" == aH.msg) {
                                switch (aZ.market) {
                                case "CN":
                                    3 == aG && (aK = a.delisted, O.showTip({
                                        txt: aK,
                                        parent: ad,
                                        noBtn: !0
                                    }))
                                }
                            }
                            if ("error" == aH.msg || "nohistory" == aH.msg) {
                                if (ar && "nohistory" == aH.msg && (aa = 0, G.hasHistory && G.hasHistory(aa), O.showTip({
                                    txt: a.nohistoryt,
                                    parent: ad,
                                    noBtn: !0
                                })), aZ.isErr = !0, ar && aH.data && aH.data.hq) {
                                    if (aG) {
                                        switch (aZ.market) {
                                        case "CN":
                                            switch (aG) {
                                            case 2:
                                                aK = a.notlisted;
                                                break;
                                            case 3:
                                                aK = a.delisted;
                                                break;
                                            case 0:
                                                aK = a.norecord
                                            }
                                            break;
                                        case "HK":
                                            switch (aG) {
                                            case 5:
                                                aK = a.notlisted;
                                                break;
                                            case 0:
                                                aK = a.delisted
                                            }
                                        }
                                    } else {
                                        aK = a.norecord
                                    }
                                    if (aK && 0 != aL) {
                                        var aJ, aD = {
                                            txt: aK,
                                            parent: ad,
                                            noBtn: !0
                                        };
                                        if (! (B.DIMENSION.getStageW() < 200)) {
                                            return O.showTip({
                                                txt: aK,
                                                parent: ad,
                                                noBtn: !0
                                            }),
                                            void R.hide()
                                        }
                                        aD.bgStyle = {
                                            padding: 0,
                                            top: "0px"
                                        },
                                        aJ || (aJ = new y.TipM(B.COLOR), aJ.genTip(aD))
                                    }
                                }
                                if (0 != aL && 7 != aL) {
                                    if (G.onResize(), 1 != aG) {
                                        return void G.removeCompare([aB.symbol])
                                    }
                                    aZ.isErr = !1
                                } else {
                                    aZ.isErr = !1
                                }
                            }
                            aZ.hq = aH.data.hq,
                            av = void 0,
                            aB.td1 = aH.data.td1;
                            var aE;
                            al = new Date;
                            var aI = 60 * al.getTimezoneOffset() * 1000;
                            if (al.setTime(al.getTime() + aI), al.setHours(al.getHours() + 8), a4 = aZ.hq.name || "", a3(aZ.hq), ax(aZ, aH.data.td5) && "HF" != aZ.market && "NF" != aZ.market && "global_index" != aZ.market ? "history" == aH.msg ? (aE = aH.data.td5, aE[4][0].date || (aE[4][0].date = aZ.hq.date)) : aE = ay(aZ, aH.data.td5) : (aE = aH.data.td5, "NF" != aZ.market || !K || "09:30" != K.time[0][0] && "09:15" != K.time[0][0] || h(aE[4][0].date, aZ.hq.date) && aZ.hq.time <= K.time[0][0] && (aE = ay(aZ, aH.data.td5)), aE && !aE[4][0].date && (aE[4][0].date = aZ.hq.date)), G.historyData = aE, aZ.date = aH.data.td1 && aH.data.td1[0].today || aZ.hq.date, am.initTState(aE), az(aA), 1 == ab && (u.dateTo(k.historytime, k.historycb), ab = 0), R.hide(), k.loadedChart) {
                                if (y.isFunc(k.loadedChart)) {
                                    k.loadedChart()
                                } else {
                                    if (window[k.loadedChart]) {
                                        window[k.loadedChart]()
                                    } else {
                                        try {
                                            window.h5chart.loadedChart()
                                        } catch(aF) {}
                                    }
                                }
                            }
                        })
                    }
                }
            };
            this.tDb = am,
            this.initData = an.init,
            this.initT5Data = a5.updateT5Data,
            this.doUpdate = a5.update,
            this.onViewChange = a0,
            this.setPricePos = function(av, aw) {
                aZ.labelMaxP = av[0],
                aZ.labelMinP = av[1],
                aZ.labelPriceCount = av[2],
                aZ.isCompare = aw,
                ao.createPlayingData(),
                aT && aT.setPricePos(av)
            },
            this.setRange = function() {
                ao.setDataRange(),
                at && at.setDataRange(),
                aT && aT.setDataRange(),
                aV && aV.setDataRange()
            },
            this.draw = function() {
                a6.draw(),
                at && at.allDraw(),
                aT && aT.allDraw()
            },
            this.resize = function(av) {
                ao.createPlayingData(),
                a6.resize(),
                at && at.onResize(av),
                aT && aT.onResize(),
                aV && aV.onResize()
            },
            this.clear = function() {
                a6.clear(),
                at && (at.clear(), at = null),
                aT && (aT.clear(), aT = null),
                aV && (aV.clear(), aV = null),
                ar && (ah = null)
            },
            this.getPriceTech = function() {
                return aT || null
            },
            this.removePt = function(av) {
                if (av) { ! y.isArr(av) && (av = [av]);
                    for (var aw = av.length; aw--;) {
                        if (av[aw].name && "VOLUME" === av[aw].name.toUpperCase()) {
                            av.splice(aw, 1),
                            B.custom.show_underlay_vol = !1;
                            break
                        }
                    }
                } else {
                    B.custom.show_underlay_vol = !1
                }
                aT && aT.removeChart(av)
            },
            this.togglePt = function(av) {
                aT && (a1 = aT.showHide(av))
            };
            var aq = function(ax, aw, av) {
                ax && F.resizeAll(!0),
                G.onChangeView(),
                aw && y.isFunc(aw.callback) && aw.callback(),
                av && aj.onTechChanged(av[0])
            };
            this.initPt = function(ax, aw) {
                if (ax) { ! y.isArr(ax) && (ax = [ax]);
                    for (var av = ax.length; av--;) {
                        if (ax[av].name && "VOLUME" === ax[av].name.toUpperCase()) {
                            ax.splice(av, 1),
                            B.custom.show_underlay_vol = !0;
                            break
                        }
                    }
                    aT || (aT = new x({
                        iMgr: D,
                        stockData: aZ,
                        chartArea: S,
                        titleArea: ae,
                        cb: aq,
                        type: "t",
                        cfg: B,
                        usrObj: k
                    }), ar && (q = aT)),
                    aT.createChart(ax, aw)
                }
            },
            this.initTc = function(av, aw) {
                at || (at = new o({
                    stockData: aZ,
                    iMgr: D,
                    subArea: P,
                    cb: aq,
                    cfg: B,
                    type: "option_cn" == W ? "p": "t",
                    usrObj: k,
                    initMgr: F
                }), ar && (ai = at)),
                at.createChart(av, aw)
            },
            this.removeTc = function(av) {
                at && at.removeChart(av)
            },
            this.initRs = function() {
                aV || (aV = new s({
                    stockData: aZ,
                    setting: B,
                    state: Y,
                    rc: G.moving,
                    witht5: 1
                }), ah = aV),
                aV.linkData()
            },
            this.setTLineStyle = a6.setTLineStyle,
            aS()
        }
        function V(ao, at) {
            function ay() {
                var av = ao.isMain;
                if (ao.nfloat = k.nfloat || 2, av) {
                    ar = B.COLOR.T_P,
                    am = B.COLOR.T_AVG
                } else {
                    2 != G.dAdd || au.linecolor || (au.linecolor = k.overlaycolor);
                    var aw = au.linecolor || "#cccccc";
                    ar = aw.K_N || aw.T_N || "#" + y.randomColor()
                }
                ak = new b.xh5_ibPainter({
                    setting: B,
                    sd: ao,
                    withHBg: av,
                    ctn: E,
                    iMgr: D,
                    reO: {
                        mh: B.DIMENSION.H_MA4K
                    },
                    iTo: function(aK, aM, aL, ax) {
                        if (!l(aK, D.iHLineO.body) && aK.appendChild(D.iHLineO.body), ao && ao.datas) {
                            var aI, aH, aJ = ao.datas[0][0].prevclose;
                            2 == ao.dAdd ? aI = ao.labelMaxP * aJ + aJ - aL / B.DIMENSION.h_t * (ao.labelMaxP * aJ + aJ - (ao.labelMinP * aJ + aJ)) : (aI = ao.labelMaxP - aL / B.DIMENSION.h_t * (ao.labelMaxP - ao.labelMinP), aH = Number(100 * (aI - aJ) / aJ).toFixed(2) + "%"),
                            D.iToD({
                                mark: aI,
                                rmark: aH,
                                x: aM,
                                y: aL,
                                oy: B.DIMENSION.H_MA4K,
                                ox: B.DIMENSION.posX,
                                e: ax
                            },
                            !0, !1)
                        }
                    }
                })
            }
            var au, ak, ar, am, az, al = {},
            ap = 1,
            aq = function(av) {
                au = t({
                    linetype: "line_" + ap,
                    linecolor: au ? au.linecolor || {}: {}
                },
                av || {});
                var aw = [];
                av && av.linetype && (aw = av.linetype.split("_"), aw.length > 1 && ("line" == aw[0] || "mountain" == aw[0]) && (ap = Number(aw[1]) || 1)),
                al = au.linecolor || {},
                ar = al.K_N || al.T_N || B.COLOR.T_P,
                am = al.T_AVG || B.COLOR.T_AVG,
                az = al.T_PREV || B.COLOR.T_PREV
            },
            an = function() {
                function a5() {
                    if (ao.isMain && B.custom.show_underlay_vol) {
                        for (var aA, aC = B.COLOR.V_SD,
                        aB = bc; ax > aB; aB++) {
                            a9 = bb[aB],
                            aA = a9.vy,
                            ak.drawVStickC(be, aA, aX, B.DIMENSION.h_t, aC),
                            be += a3
                        }
                        ak.stroke(),
                        ak.getG().lineWidth = 1
                    }
                }
                function aw() {
                    if ((!ao.isCompare || 2 == ao.dAdd && ao.isMain) && !("HK" == ao.market && ao.hq && "indx" == ao.hq.type || "US" == ao.market)) {
                        for (be = a3 * (0.5 + bc), ak.newStyle(am, !0, ap), av = bc; ax > av && (a9 = bb[av], !(a9.price <= 0)); av++) {
                            if (5 == Y.end && "CN" == ao.market && q) {
                                for (var aA = q.getLog(), aB = 0; aB < aA.length; aB++) {
                                    if ("EWI" == aA[aB].name && av > (ax / A - 1) * A) {
                                        return void ak.stroke()
                                    }
                                }
                            }
                            av == bc || av % A == 0 ? ak.moveTo(be, bb[av].ay) : ak.lineTo(be, bb[av].ay),
                            be += a3
                        }
                        ak.stroke()
                    }
                }
                function aY() {
                    ak.newStyle(ar, !0, ap),
                    be = a3 * (0.5 + bc),
                    "CN" == ao.market && ao.preData.vPos && (0 == ao.realLen && ao.hq ? ao.hq.time > "09:29" ? (ak.moveTo(0, ao.preData.vPos), bb[0].py || (bb[0].py = ao.preData.vPos), ak.lineTo(be, bb[0].py)) : ak.drawDot(be, ao.preData.vPos, 1) : (ak.moveTo(0, ao.preData.vPos), bb[0].py || (bb[0].py = ao.preData.vPos), ak.lineTo(be, bb[0].py)), ak.stroke())
                }
                function a0() {
                    var aA;
                    for (av = bc; ax > av && (a9 = bb[av], !(a9.price <= 0)); av++) {
                        aA = a9.py,
                        av == bc || av % A == 0 ? ak.moveTo(be, aA) : ak.lineTo(be, aA),
                        a9.ix = be,
                        be += a3
                    }
                    a2 = be,
                    a4 = aA,
                    ak.stroke(),
                    k.business && aW({
                        xPos: be,
                        yPos: aA
                    })
                }
                function aW(aA) {
                    ak.newStyle(ar, !0, 0.5),
                    ak.drawDot(aA.xPos, aA.yPos, 3, !0),
                    ak.newFillStyle_rgba(B.COLOR.M_ARR, 3, 1),
                    ak.fill(),
                    ak.stroke()
                }
                function a6() {
                    function aA() {
                        ak.lineTo(be, B.DIMENSION.h_t),
                        ak.lineTo(0.5 * a3, B.DIMENSION.h_t),
                        ak.newFillStyle_rgba(B.COLOR.M_ARR, B.DIMENSION.h_t, B.COLOR.M_ARR_A),
                        ak.fill()
                    }
                    if (ba && !ao.isCompare) {
                        if (ao.datas.length < 2) {
                            be -= a3,
                            aA()
                        } else {
                            be = 0.5 * a3;
                            var aB;
                            for (ak.newStyle(ar, !0, ap), av = 0; ax > av && (a9 = bb[av], !(a9.price <= 0)); av++) {
                                aB = a9.py,
                                0 == av ? ak.moveTo(be, aB) : ak.lineTo(be, aB),
                                be += a3
                            }
                            aA()
                        }
                    }
                }
                function aZ() {
                    az = B.COLOR.T_PREV,
                    ak.newStyle(az, !0, 1);
                    var aA, aC = 0,
                    aG = 5;
                    for (aA = ao.isCompare && ao.isMain && "pct" === B.datas.scaleType ? p.pp(0, ao.labelMinP, ao.labelMaxP, B.DIMENSION.h_t) : p.pp(ao.datas[0][0].prevclose, ao.minPrice, ao.maxPrice, B.DIMENSION.h_t), aA = ~~ (aA + 0.5), aA -= 0.5; aC < B.DIMENSION.w_t;) {
                        ak.moveTo(aC, aA),
                        aC += aG,
                        ak.lineTo(aC, aA),
                        aC += aG
                    }
                    if (ao.isMain && ak.stroke(), k.business) {
                        var aI = ao.hq.price.toFixed(2),
                        aH = ak.getG(),
                        aF = aH.measureText(aI).width,
                        aD = B.DIMENSION.w_t - aF,
                        aE = aF + 10;
                        a2 > aD && (a2 = aD),
                        10 > a2 && (a2 = 20),
                        30 > a4 && (a4 = 30),
                        aH.fillStyle = "#EB9A47";
                        var aB = aV(a2 - 10, a4 - 25, aE, 20);
                        a7(aB, 5, aH),
                        aH.beginPath(),
                        aH.fillStyle = "#fff",
                        aH.fillText(aI, a2 - 5, a4 - 10),
                        ak.fill()
                    }
                }
                function aV(aA, aB, aD, aC) {
                    return {
                        x: aA,
                        y: aB,
                        width: aD,
                        height: aC
                    }
                }
                function a7(aC, aF, aH) {
                    var aG = a1(aC.x + aF, aC.y),
                    aA = a1(aC.x + aC.width, aC.y),
                    aD = a1(aC.x + aC.width, aC.y + aC.height),
                    aB = a1(aC.x, aC.y + aC.height),
                    aE = a1(aC.x, aC.y);
                    aH.beginPath(),
                    aH.moveTo(aG.x, aG.y),
                    aH.arcTo(aA.x, aA.y, aD.x, aD.y, aF),
                    aH.arcTo(aD.x, aD.y, aB.x, aB.y, aF),
                    aH.arcTo(aB.x, aB.y, aE.x, aE.y, aF),
                    aH.arcTo(aE.x, aE.y, aG.x, aG.y, aF),
                    aH.stroke(),
                    aH.fill()
                }
                if (! (B.DIMENSION.getStageH() < 0)) {
                    ao.isMain && ak.drawBg("T");
                    var bb = [];
                    if (ao.datas) {
                        for (var bd = 0; bd < ao.datas.length; bd++) {
                            bb = bb.concat(ao.datas[bd])
                        }
                        var ax = bb.length;
                        if (bb) {
                            var av, a9, bc, ba = au.linetype && 0 == au.linetype.indexOf("mountain"),
                            a8 = ao.datas.length * A,
                            a3 = B.DIMENSION.w_t / Math.max(a8, B.PARAM.minCandleNum),
                            aX = 0.5 * a3,
                            be = 0;
                            ao.isTotalRedraw ? (bc = 0, ak.clear(!0, B.PARAM.getHd())) : (bc = a8 - 2, 0 > bc && (bc = 0), be += a3 * bc, ak.clearLimit(be + aX, a3 + aX));
                            var a2 = 0,
                            a4 = 0,
                            a1 = function(aA, aB) {
                                return {
                                    x: aA,
                                    y: aB
                                }
                            };
                            a5(),
                            "sh000012" != ao.symbol && "sh000013" != ao.symbol && (k.business || aw()),
                            aY(),
                            a0(),
                            a6(),
                            aZ()
                        }
                    }
                }
            };
            this.draw = an,
            this.clear = function() {
                ak.remove(),
                ak = null
            },
            this.resize = function() {
                ak.resize({
                    mh: B.DIMENSION.H_MA4K
                }),
                an()
            },
            this.setTLineStyle = aq,
            aq(at),
            ay()
        }
        function Q() {
            var aR, aq = this,
            a4 = [];
            this.getAllStock = function() {
                return a4
            },
            this.getMainStock = function() {
                return aR
            },
            this.getAllSymbols = function() {
                for (var av = [], aw = 0, ax = a4.length; ax > aw; aw++) {
                    av.push(a4[aw].symbol)
                }
                return av
            };
            var au = function() {
                var av, aw = B.DIMENSION.h_t;
                return k.business ? av = 0 : k.appMode ? 2 : av = 100 > aw ? 2 : 180 > aw ? 4 : 300 > aw ? 6 : 8
            },
            at = function() {
                for (var aC, aw, ay, aG = Number.MAX_VALUE,
                aJ = -Number.MAX_VALUE,
                az = a4.length,
                av = az > 1,
                aH = av ? "avgPercent": "Price", aB = az; aB--;) {
                    aC = a4[aB],
                    ay = aC.getPriceTech(),
                    ay && !av && ay.getMaxMin()[0] && (aJ = ay.getMaxMin()[0], aG = ay.getMaxMin()[1]),
                    aw = [aJ, aG],
                    aG = Math.min(aG, aC["min" + aH], aw[1]),
                    aJ = Math.max(aJ, aC["max" + aH], aw[0])
                }
                if (q) {
                    var aF = q.getLog(),
                    aI = aF.length;
                    for (aB = 0; aI > aB; aB++) {
                        if ("EWI" == aF[aB].name || "MA" == aF[aB].name) {
                            var ax = a4[0].datas[0][0].prevclose,
                            aA = Math.max(Math.abs(ax - aJ), Math.abs(ax - aG));
                            aJ = ax + aA,
                            aG = ax - aA
                        }
                    }
                }
                for (var aD = au(), aE = az; aE--;) {
                    aC = a4[aE],
                    aC.setPricePos([aJ, aG, aD], av)
                }
            },
            aW = function(av) {
                if (av) {
                    av.draw()
                } else {
                    for (var aw = a4.length; aw--;) {
                        a4[aw].draw()
                    }
                }
            },
            a0 = function(av) {
                1 == Y.viewId || 0 == Y.viewId ? k.date ? aq.moving(Y.start, Y.end) : aq.moving(4, 5, !1) : aq.moving(Y.start, Y.end, !1),
                av || aj.onRange(aR)
            },
            aS = function(av) {
                return av.isErr ? (y.trace.error("err symbol data"), aq.removeCompare([av.symbol]), !0) : av.tDb.get() ? !0 : (av.initData(a1), !1)
            },
            aV = [],
            aT = function(av) {
                if (av && y.isFunc(av.callback)) {
                    for (var ax = !1,
                    aw = aV.length; aw--;) {
                        if (av.callback === aV[aw]) {
                            ax = !0;
                            break
                        }
                    } ! ax && aV.push(av.callback)
                }
            },
            a1 = function(ax, aw) {
                if (aT(aw), aS(aR)) {
                    if (aR.isErr) {
                        return y.trace.error("err main symbol"),
                        void(aR.isErr = !1)
                    }
                    D.patcher.switchFloater();
                    for (var az, aA = !0,
                    av = a4.length; av--;) {
                        az = a4[av],
                        az == aR || aS(az) || (aA = !1)
                    }
                    if (aA) {
                        for (av = a4.length; av--;) {
                            a4[av].marketNum(a4[av].needMarket) > a4[av].marketNum(W) && (W = a4[av].needMarket)
                        }
                        for (av = a4.length; av--;) {
                            a8(a4[av])
                        }
                        for (a0(ax); aV.length;) {
                            var ay = aV.shift();
                            ay()
                        }
                    }
                    if (aj.onViewChanged(), ax) {
                        return
                    }
                    aj.onViewPrice(),
                    aj.onDataUpdate()
                }
            },
            ar = function() {
                aj.onRange(aR)
            };
            this.getExtraData = function(ay) {
                if (ay = t({
                    symbol: aR.symbol,
                    name: null,
                    clone: !0
                },
                ay || {}), !ay.name) {
                    return null
                }
                for (var ax, az, av = a4.length; av--;) {
                    if (a4[av].symbol === ay.symbol) {
                        ax = a4[av];
                        break
                    }
                }
                if (ax) {
                    var aw;
                    "t1" == ay.name || "t5" == ay.name ? (aw = ax.tDb.get(), az = ay.clone ? y.clone(aw) : aw) : az = null
                }
                return az
            },
            this.shareTo = function(av) {
                av = t({
                    type: "weibo",
                    url: window.location.href,
                    wbtext: "",
                    qrwidth: 100,
                    qrheight: 100,
                    extra: void 0
                },
                av);
                var aw = String(av.type).toLowerCase();
                switch (aw) {
                case "qrcode":
                    KKE.api("utils.qrcode.createcanvas", {
                        text: av.url,
                        width: av.qrwidth,
                        height: av.qrheight
                    },
                    function(ax) {
                        O.showTip({
                            content: ax,
                            txt: '<p style="margin:0 0 9px 0;">\u626b\u63cf\u4e8c\u7ef4\u7801</p>',
                            parent: ad,
                            btnLb: "\u5173\u95ed"
                        })
                    });
                    break;
                default:
                    y.grabM.shareTo({
                        ctn:
                        ad,
                        w: B.DIMENSION.getStageW(),
                        h: B.DIMENSION.getStageH() - (ag.clientHeight || 0),
                        ignoreZIdxArr: [B.PARAM.I_Z_INDEX],
                        ignoreIdArr: [B.PARAM.LOGO_ID],
                        priorZIdx: B.PARAM.G_Z_INDEX,
                        nologo: !1,
                        top: B.DIMENSION.posY + B.DIMENSION.H_MA4K + 17,
                        right: B.DIMENSION.RIGHT_W + B.DIMENSION.K_RIGHT_W,
                        LOGO_W: B.DIMENSION.LOGO_W,
                        LOGO_H: B.DIMENSION.LOGO_H,
                        color: B.COLOR.LOGO,
                        bgColor: B.COLOR.BG,
                        txt: av.wbtext,
                        url: av.url,
                        extra: av.extra
                    })
                }
            };
            var ap, aX, am = function() {
                D.update(),
                at(),
                aW(),
                ar(),
                D.isIng() || aj.onViewPrice()
            },
            aZ = function() {
                clearTimeout(aX),
                !af && ad.parentNode && "none" != ad.style.display && (aX = setTimeout(am, 200))
            },
            aU = function() {
                if (clearInterval(ap), !isNaN(k.rate)) {
                    var av = 1000 * k.rate;
                    av > 0 && (ap = setTimeout(aU, av))
                }
                for (var aw, ax = a4.length; ax--;) {
                    aw = a4[ax],
                    aw.doUpdate(aZ)
                }
            },
            a6 = function() {
                Y.viewId = 2;
                for (var av, aw = a4.length; aw--;) {
                    av = a4[aw],
                    av.initT5Data(av.datas, av.hq, a1)
                }
            };
            this.updateDataAll = aU,
            this.update5Data = a6;
            var aY = function(av, ax) {
                var aw = new z(av, ax);
                ax && (aR = aw),
                a4[a4.length] = aw,
                a5(),
                a1()
            },
            ao = function(av) {
                for (var aw, ay, ax = av,
                az = 0,
                aA = 0; az < a4.length; az++) {
                    ay = a4[az],
                    ay.marketNum(ay.market) == ay.marketNum(ax) ? aA++:aw = aw ? ay.marketNum(ay.market) > ay.marketNum(aw) ? ay.market: aw: ay.market,
                    az == a4.length - 1 && 0 == aA && (W = aw)
                }
                for (az = a4.length; az--;) {
                    a8(a4[az], ax)
                }
            },
            a8 = function(av, aw) {
                av.changeMarket(aw)
            };
            this.changeData = a8;
            var a5 = function() {
                if (a4.length > 1) {
                    aq.mM.togglePt({
                        v: !1
                    })
                } else {
                    if (a4.length <= 0) {
                        return
                    }
                    aq.mM.togglePt({
                        v: !0
                    })
                }
            },
            a2 = function(av) {
                var aw = Y.start,
                ax = Y.end;
                return aw = Math.max(aw + av, 0),
                0 == aw && 5 >= ax && 0 == Y.start && ax++,
                aw >= ax && (aw = ax - 1),
                ax > 5 && (ax = 5),
                [aw, ax]
            };
            this.onWheel = function(av) {
                var aw = -1 * av.detail || av.wheelDelta;
                if (0 != aw) {
                    aw = aw > 0 ? -1 : 1;
                    var ax = a2(aw);
                    aq.moving(ax[0], ax[1], "wheel")
                }
            },
            this.onKb = function(av) {
                var aw = av.keyCode;
                switch (aw) {
                case 38:
                case 40:
                    var ax = a2(38 == aw ? 1 : -1);
                    aq.moving(ax[0], ax[1], "Key");
                    break;
                case 37:
                case 39:
                    D.iToKb(37 == aw ? -1 : 1);
                    break;
                default:
                    return
                }
                i.preventDefault(av)
            },
            this.zoomApi = function(av) {
                var aw = a2(av ? 1 : -1);
                aq.moving(aw[0], aw[1], "zoom")
            },
            this.moveApi = function(av) {
                var aw = Y.start,
                ax = Y.end;
                aw += av,
                ax += av,
                ax > 5 && (aw = 4, ax = 5),
                0 > aw && (aw = 0, ax = 1),
                aq.moving(aw, ax, "move")
            },
            this.setViewData = a0,
            this.onChangeView = a1;
            var al = 1;
            this.moving = function(aw, ay, ax, az) {
                Y.start = aw,
                Y.end = ay,
                (4 != aw && 5 != ay || 0 != aw && 5 != ay) && (Y.viewId = 0),
                az && 4 != aw && 1 == al && (ax = "rs", al = 2, X = 0),
                ("HF" == W || "NF" == W) && 0 == X && ax && (R.show(), a6("t5"), X = 1, al = 2);
                for (var aA, av = a4.length; av--;) {
                    aA = a4[av],
                    aA.setRange(),
                    aA.onViewChange()
                }
                at(),
                aW(),
                aj.onRange(aR)
            },
            this.dAdd = 0,
            this.compare = function(av) {
                for (var aw = a4.length; aw--;) {
                    if (a4[aw].symbol == av.symbol) {
                        return
                    }
                }
                aY(av, !1)
            },
            this.removeCompare = function(av) {
                for (var aw, ay, ax = "CN",
                az = av.length; az--;) {
                    ay = av[az];
                    for (var aA = a4.length; aA--;) {
                        if (ay == a4[aA].symbol) {
                            aw = a4.splice(aA, 1)[0],
                            ax = aw.market,
                            aw.clear(),
                            aw = null;
                            break
                        }
                    }
                }
                ao(ax),
                a5(),
                at(),
                aW(),
                aj.onRange(a4[0])
            },
            this.onResize = function(av) {
                for (var aw = a4.length; aw--;) {
                    a4[aw].resize(av)
                }
            },
            this.dcReset = function() {
                for (var av, aw = a4.length; aw--;) {
                    av = a4.splice(aw, 1)[0],
                    av.clear(),
                    av = null
                }
            },
            this.setScale = function(av) {
                B.datas.scaleType = av
            },
            this.setTLineStyle = function(ay) {
                if (ay) { ! y.isArr(ay) && (ay = [ay]);
                    for (var ax = ay.length; ax--;) {
                        var az = ay[ax];
                        if (az.hasOwnProperty("symbol")) {
                            for (var av = az.symbol,
                            aw = a4.length; aw--;) {
                                if (a4[aw].symbol == av) {
                                    a4[aw].setTLineStyle(az),
                                    a4[aw].draw();
                                    break
                                }
                            }
                        } else {
                            aR.setTLineStyle(az),
                            aR.draw()
                        }
                    }
                } else {
                    aR.setTLineStyle(),
                    aR.draw()
                }
            };
            var a7, a3 = function(av) {
                av ? am() : D.update()
            },
            an = !1,
            a9 = 0,
            ba = function() {
                clearTimeout(a7),
                an = !1,
                a9 = 0
            },
            ak = function() {
                a7 = setTimeout(function() {
                    a9 > 0 && am(),
                    ba()
                },
                500)
            };
            this.pushData = function(av, aw) {
                var ay = !1;
                switch (Number(aw)) {
                case 1:
                    ba(),
                    ay = !0;
                    break;
                case 2:
                    an || (an = !0, ak());
                    break;
                case 0:
                    ba()
                }
                for (var ax = av.length; ax--;) {
                    for (var az = a4.length; az--;) {
                        if (a4[az].symbol == av[ax].symbol && av[ax].data) {
                            a9++,
                            a4[az].doUpdate(T(a3, null, ay), !1, av[ax].data, av[ax].market);
                            break
                        }
                    }
                }
            },
            this.dcInit = function(av) {
                aY(av, !0),
                aU()
            },
            this.mM = new
            function() {
                var av = function(ay, aC, az) {
                    var aB, aA;
                    switch (aC) {
                    case "price":
                        aB = x,
                        aA = "initPt";
                        break;
                    case "tech":
                        aB = o,
                        aA = "initTc"
                    }
                    aA && (aB ? aR[aA](ay, az) : KKE.api("plugins.techcharts.get", {
                        type: aC
                    },
                    function(aD) {
                        o = aD.tChart,
                        x = aD.pChart,
                        av(ay, aC, az)
                    }))
                },
                ax = function(az, ay) {
                    var aA;
                    switch (ay) {
                    case "price":
                        aA = "removePt";
                        break;
                    case "tech":
                        aA = "removeTc"
                    }
                    aA && aR && (aR[aA](az), a1())
                },
                aw = function(ay) {
                    return s ? (ah ? ah.sh(ay) : (aR.initRs(), aw(ay), ag.appendChild(ah.getBody())), void F.resizeAll(!0)) : void KKE.api("plugins.rangeselector.get", null,
                    function(az) {
                        s = az,
                        aw(ay)
                    })
                };
                this.showRs = aw,
                this.newAC = av,
                this.removeAC = ax,
                this.togglePt = function(ay) {
                    aR && (aR.togglePt(ay), a1())
                }
            }
        }
        var C, K, w, W = "CN",
        aa = 1,
        ab = 0,
        J = "\u624b",
        X = 0;
        K = k._nf_window_var,
        C = k._hf_window_var,
        w = k._gbi_window_var;
        var H = {
            tcd: function(al) {
                var ak;
                switch (al) {
                case "HF":
                    ak = y.tUtil.gtAll(C.time).length;
                    break;
                case "CN":
                    ak = 241,
                    y.isRepos(k.symbol) && (J = "");
                    break;
                case "option_cn":
                case "op_m":
                    ak = 241,
                    J = "";
                    break;
                case "HK":
                    ak = 331,
                    J = "";
                    break;
                case "US":
                    ak = 391,
                    J = "";
                    break;
                case "NF":
                    ak = y.tUtil.gtAll(K.time).length,
                    J = "";
                    break;
                case "global_index":
                    ak = y.tUtil.gtAll(w.time).length;
                    break;
                default:
                    ak = 241
                }
                return ak
            },
            rmuk: function(ap, al, an) {
                var am, ao, ak = ap;
                return "HK" == an ? (am = ak.splice(0, 120), ao = am.concat(ak.splice(30, 121))) : "US" == an || (ao = ap),
                ao
            },
            aduk: function(aS, at, aY, a2, aQ) {
                var a3, aT, a0, aR, aO, aW = aS,
                a1 = at,
                aX = aY,
                aP = [],
                aV = [],
                a4 = a2.getHours() + ":" + y.strUtil.zp(a2.getMinutes()),
                an = y.tUtil.gata(aY),
                ap = g.stbd(a2, aQ) ? y.arrIndexOf(an, a4) : 0;
                "HK" == a1 && "US" == aY && (aT = [["12:01", "12:59"]], aP = [1], a0 = aW[150], aR = aW[aW.length - 1]),
                ("CN" == a1 || "option_cn" == a1) && ("HK" == aX ? (aT = [["11:30", "11:59"], ["15:01", "16:00"]], aP = [0, 2], a0 = aW[119], aR = aW[aW.length - 1]) : (aT = [["11:30", "11:59"], ["12:00", "12:59"], ["15:01", "16:00"]], aP = [0, 1, 2], a0 = aW[119], aR = aW[aW.length - 1]));
                for (var au = 0,
                ar = aP.length; ar > au; au++) {
                    for (var al, ao, am, ak = y.tUtil.gtr([aT[au]]), aU = [], aZ = 0, aq = ak.length; aq > aZ; aZ++) {
                        aP[au] < 2 ? (("CN" == a1 || "option_cn" == a1) && (ap > 120 && 150 > ap ? (ao = ap - 120, am = ao > aZ ? a0.price: -0.01) : am = a0.price), "HK" == a1 && ap > 150 && 180 > ap && (ao = ap - 150), al = {
                            time: ak[aZ],
                            price: am,
                            avg_price: am,
                            volume: 0,
                            fake: aP[au]
                        }) : (("CN" == a1 || "option_cn" == a1) && (ap > 272 ? (ao = ap - 272, am = ao > aZ ? aR.price: -0.01) : am = aR.price), al = {
                            time: ak[aZ],
                            price: am,
                            avg_price: am,
                            volume: 0,
                            fake: aP[au]
                        }),
                        aU.push(al)
                    }
                    aV.push(aU)
                }
                return "HK" == at && (aO = aW.splice(0, 151), a3 = aO.concat(aV[0], aW)),
                ("CN" == at || "option_cn" == a1) && ("US" == aX ? (aO = aW.splice(0, 120), a3 = aO.concat(aV[0], aV[1], aW, aV[2])) : "HK" == aX && (aO = aW.splice(0, 120), a3 = aO.concat(aV[0], aW, aV[1]))),
                a3
            }
        };
        y.xh5_EvtDispatcher.call(this);
        var U = this;
        k = t({
            symbol: "sh000001",
            ssl: !0,
            business: !1,
            datas: {
                t1: {
                    url: void 0,
                    dataformatter: void 0
                },
                t5: {
                    url: void 0,
                    dataformatter: void 0
                }
            },
            dim: null,
            theme: null,
            view: "ts",
            rate: 3,
            t_rate: 0 / 0,
            fh5: !1,
            noh5: null,
            reorder: !0,
            reheight: !0,
            dist5: 0,
            w: void 0,
            h: void 0,
            mh: 0,
            date: null,
            dp: !1,
            onrange: void 0,
            onviewprice: void 0,
            ondataupdate: void 0,
            onviewchanged: void 0,
            ontechchanged: void 0,
            onshortclickmain: void 0,
            nfloat: 2,
            trace: void 0,
            overlaycolor: void 0,
            nohtml5info: void 0,
            tchartobject: {
                t: void 0,
                k: void 0
            }
        },
        k || {
            YANGWEN: "yangwen@staff.api.com.cn",
            VER: "2.5.25"
        }),
        !k.symbol && (k.symbol = "sh000001"),
        k.symbol = String(k.symbol),
        k.symbol = k.symbol.replace(".", "$"),
        0 == location.protocol.indexOf("http:") && (k.ssl = !0);
        var M = "_" + k.symbol + "_" + Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1),
        B = f.getSetting(M);
        B.datas.isT = !0,
        k.reorder || (B.custom.indicator_reorder = !1),
        k.reheight || (B.custom.indicator_reheight = !1),
        W = y.market(k.symbol),
        B.datas.tDataLen = H.tcd(W);
        var A = B.datas.tDataLen,
        O = new
        function() {
            var ak;
            this.showTip = function(al) {
                ak || (ak = new y.TipM(B.COLOR)),
                ak.genTip(al)
            },
            this.hideTip = function() {
                ak && ak.hide()
            }
        };
        if (N.noH5) {
            if ("undefined" == typeof FlashCanvas || k.fh5) {
                return void(y.isFunc(k.noh5) && k.noh5(k))
            }
            B.PARAM.isFlash = !0
        }
        if (B.PARAM.isFlash && (B.COLOR.K_EXT_BG = "#fff", B.COLOR.F_BG = "#fff"), k.dim) {
            for (var Z in k.dim) {
                k.dim.hasOwnProperty(Z) && y.isNum(B.DIMENSION[Z]) && (B.DIMENSION[Z] = k.dim[Z])
            }
        }
        var ac, ad, E, S, ae, P, ag, G, I, ai, q, ah, R, Y = {
            viewId: a.URLHASH.vi(k.view || "ts"),
            dataLength: void 0,
            start: void 0,
            end: void 0,
            startDate: void 0,
            endDate: void 0
        },
        j = isNaN(k.t_rate) ? B.PARAM.T_RATE: k.t_rate,
        af = !1,
        L = 0,
        F = new
        function() {
            var an, am = function(aN, av, ax) {
                var aR = !1;
                isNaN(aN) && (aN = k.w || ac.offsetWidth),
                isNaN(av) && (av = k.h || ac.offsetHeight - k.mh);
                for (var aU, aS = ag.clientHeight || 0,
                aT = P.clientHeight || 0,
                aP = B.DIMENSION.getOneWholeTH(), aM = 0, aL = P.childNodes, aO = aL.length, aQ = 0, aw = aL.length; aw--;) {
                    aU = aL[aw],
                    aU.id.indexOf("blankctn") >= 0 ? (aM = aU.offsetHeight, aO--, aQ += aM) : aQ += aP
                }
                return ! isNaN(ax) && (aT -= ax),
                aT / (av - aS) > 1 && (aT = aQ, aR = !0),
                B.DIMENSION.setStageW(aN),
                1 == L ? aO > 0 && (B.DIMENSION.setStageH(av, aO * aP + aM + aS), aR = !0, L = 0) : B.DIMENSION.setStageH(av, aT + aS),
                0 > av && (B.DIMENSION.H_T_G = B.DIMENSION.H_T_G - B.DIMENSION.H_T_T, B.DIMENSION.H_T_B = B.DIMENSION.H_TIME_PART),
                aR
            },
            ar = function() {
                R.setPosition()
            },
            ay = function() {
                an && (an.style.display = B.custom.show_logo ? "": "none")
            },
            at = function(av, aB, ax) {
                var aw = am(aB, ax, 0 / 0);
                if (av || aB && ax) {
                    if (!G) {
                        return
                    }
                    G.onResize(aw),
                    D.onResize()
                }
                ar(),
                ay(),
                y.stc("t_wh", [B.DIMENSION.getStageW(), B.DIMENSION.getStageH()])
            },
            ak = function() {
                ac = e(k.domid) || k.dom,
                ac || (ac = d("div"), document.body.appendChild(ac), y.trace.error("missing of dom id")),
                ad = d("div"),
                ad.style.position = "relative",
                ad.style.outlineStyle = "none",
                ad.style.webkitUserSelect = ad.style.userSelect = ad.style.MozUserSelect = "none",
                E = d("div", "mainarea_" + B.uid),
                S = d("div"),
                E.appendChild(S),
                ae = d("div"),
                ae.style.position = "absolute",
                ae.style.fontSize = B.STYLE.FONT_SIZE + "px",
                E.appendChild(ae),
                ad.appendChild(E),
                P = d("div"),
                ad.appendChild(P),
                ag = d("div"),
                ad.appendChild(ag),
                ac.appendChild(ad),
                R = new y.LoadingSign,
                R.appendto(E, B)
            },
            ap = function(aw) {
                var av = !1;
                if (aw) {
                    ah && (av = ah.setTheme(aw));
                    for (var ax in aw) {
                        aw.hasOwnProperty(ax) && B.COLOR.hasOwnProperty(ax) && B.COLOR[ax] !== aw[ax] && (B.COLOR[ax] = aw[ax], av = !0)
                    }
                    y.stc("t_thm", aw)
                }
                return av && v.styleLogo({
                    logo: an,
                    color: B.COLOR.LOGO
                }),
                av
            },
            ao = function(av) { ! B.custom.mousewheel_zoom || document.activeElement !== ad && document.activeElement.parentNode !== ad || (G && G.onWheel(av), i.preventDefault(av), i.stopPropagation(av))
            },
            aq = function(av) {
                B.custom.keyboard && G && G.onKb(av)
            },
            au = function() {
                y.xh5_deviceUtil.istd || (N.info.name.match(/firefox/i) ? i.addHandler(ad, "DOMMouseScroll", ao) : i.addHandler(ad, "mousewheel", ao), ad.tabIndex = 0, i.addHandler(ad, "keydown", aq))
            },
            az = function(av) {
                an = av,
                ad.appendChild(av)
            },
            al = function() {
                ak(),
                ap(k.theme),
                at(),
                au(),
                B.DIMENSION.h_t < 0 && (E.style.display = "none", B.custom.indicator_reorder = !1, B.custom.indicator_reheight = !1),
                v.getLogo({
                    cb: az,
                    id: B.PARAM.LOGO_ID,
                    isShare: !1,
                    top: B.DIMENSION.posY + B.DIMENSION.H_MA4K + 17,
                    right: B.DIMENSION.RIGHT_W + B.DIMENSION.K_RIGHT_W,
                    LOGO_W: B.DIMENSION.LOGO_W,
                    LOGO_H: B.DIMENSION.LOGO_H,
                    color: B.COLOR.LOGO
                }),
                N.noH5 && (O.showTip({
                    txt: k.nohtml5info || a.nohtml5info,
                    parent: ad
                }), y.stc("t_nh5"))
            };
            al(),
            this.resizeAll = at,
            this.innerResize = function(av) {
                G && (am(0 / 0, 0 / 0, av), G.onResize(), D.onResize(), ar(), aj.onInnerResize({
                    height: B.DIMENSION.h_t
                }))
            },
            this.initTheme = ap
        },
        aj = new
        function() {
            var al = 0,
            ak = function(ap, ao) {
                var aq = A - 1,
                am = G.getAllStock()[0];
                if (am && am.datas && (h(am.datas[am.datas.length - 1][0].date, am.hq.date) ? ao = am.realLen < 0 || am.realLen > aq ? aq: aq = am.realLen: "NF" == W && K && "21:00" == K.time[0][0] ? ao = aq = am.realLen: am.realLen < 0 || am.realLen > aq ? ao = aq: (ao = aq, am.datas[am.datas.length - 1][ao].price < 0 && (ao = am.realLen)), ap = am.datas[am.datas.length - 1][ao], ap && ap.time)) {
                    var ar, an;
                    return "HF" == W ? (ar = C.time[0][0], ar > ap.time ? (ar = am.datas[am.datas.length - 1][0].date, an = new Date(ar), an.setDate(an.getDate() + 1)) : an = am.datas[am.datas.length - 1][0].date) : "NF" == W ? (ar = K.time[0][0], ar < ap.time && "21:00" == ar ? (ar = am.datas[am.datas.length - 1][0].date, an = new Date(ar), an.setDate(an.getDate() - 1)) : an = am.datas[am.datas.length - 1][0].date) : an = am.datas[am.datas.length - 1][0].date,
                    ap.day = y.dateUtil.ds(an, "/", !1) + "/" + y.dateUtil.nw(an.getDay()) + (ap.time || ""),
                    al = ao,
                    y.clone(ap)
                }
            };
            this.currentData = ak,
            this.onDataUpdate = function() {
                if (y.isFunc(k.ondataupdate)) {
                    var am = ak();
                    am && k.ondataupdate({
                        data: y.clone(am),
                        idx: Y.currentLength - 1,
                        left: B.DIMENSION.posX,
                        top: B.DIMENSION.H_MA4K
                    })
                }
            },
            this.onInnerResize = function(am) {
                y.isFunc(k.oninnerresize) && k.oninnerresize(am)
            },
            this.onRange = function(am) { ! af && y.isFunc(k.onrange) && am && k.onrange({
                    isCompare: am.isCompare,
                    data: y.clone(am.datas),
                    width: B.DIMENSION.w_t,
                    height: B.DIMENSION.h_t,
                    viewRangeState: y.clone(Y),
                    range: [am.labelMinP, am.labelMaxP, am.labelMaxVol],
                    left: B.DIMENSION.posX,
                    top: B.DIMENSION.H_MA4K
                })
            },
            this.onViewChanged = function() {
                y.isFunc(k.onviewchanged) && k.onviewchanged({
                    viewRangeState: y.clone(Y)
                })
            },
            this.onViewPrice = function(aq, an, ar, ao) {
                if (!af && y.isFunc(k.onviewprice)) {
                    if (aq || (aq = ak(aq, an)), !aq) {
                        return
                    }
                    ar || (ar = G.getMainStock().getName());
                    var ap = y.clone(aq),
                    am = k.symbol.length;
                    "HK" == W && k.symbol.substring(am - 1, am) >= "A" && (ap.avg_price = 0 / 0),
                    ap.volume && ap.volume < 0 && (ap.volume = 0),
                    k.onviewprice({
                        curname: ar || "",
                        data_array: G.getAllStock().length,
                        data: ap,
                        idx: al,
                        left: B.DIMENSION.posX,
                        top: B.DIMENSION.H_MA4K,
                        interacting: !!ao
                    })
                }
            },
            this.onTechChanged = function(am) {
                y.isFunc(k.ontechchanged) && k.ontechchanged({
                    Indicator: am
                })
            },
            this.shortClickHandler = function() {
                y.isFunc(k.onshortclickmain) && k.onshortclickmain()
            }
        },
        D = new
        function() {
            var aJ, aH, at, aG, au, aN = isNaN(k.nfloat) ? 2 : k.nfloat,
            aL = 137,
            aI = new
            function() {
                var av = function(aw) {
                    var ax = aJ.body.style;
                    aw && B.custom.show_floater ? (ax.backgroundColor = B.COLOR.F_BG, ax.color = B.COLOR.F_T, ax.border = "1px solid " + B.COLOR.F_BR, ax.display = "") : ax.display = "none"
                };
                this.pv = function(ay) {
                    aN = isNaN(k.nfloat) ? 2 : k.nfloat;
                    var az = aJ.body.style,
                    ax = Math.max(B.DIMENSION.posX, 55) + 9,
                    aA = B.DIMENSION.posX < 55 ? 9 : 0,
                    aw = B.DIMENSION.getStageW() - aL - 9 - B.DIMENSION.RIGHT_W - aA;
                    az.left = (ay.x > B.DIMENSION.getStageW() - B.DIMENSION.RIGHT_W >> 1 ? ax: aw) + "px",
                    az.top = (ay.y || 0) + "px",
                    av(!0)
                },
                this.showFloater = av
            },
            ar = function() {
                function av() {
                    var ax = G.getAllStock()[0];
                    return ! ("HK" != ax.market || "indx" != ax.hq.type)
                }
                function aw() {
                    var ay, bf, aC, aE = "border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0;border-collapse:collapse;border-spacing:0;text-align:center;",
                    a4 = "font-weight:normal;border:0;height:16px;text-align:center;",
                    a2 = "text-align:left;font-weight:normal;border:0;height:16px;",
                    ax = "text-align:right;border:0;height:16px;",
                    aB = d("div");
                    aB.style.position = "absolute",
                    aB.style.zIndex = B.PARAM.I_Z_INDEX + 2,
                    aB.style.padding = "2px",
                    aB.style.width = aL + "px",
                    aB.style.lineHeight = "16px",
                    aB.style.display = "none",
                    aB.style.fontSize = "12px";
                    var aD, a6, a3, az, aA = d("table"),
                    a7 = d("thead"),
                    bb = d("tbody");
                    aA.style.cssText = aE,
                    aD = d("tr"),
                    a6 = d("th"),
                    a6.setAttribute("colspan", "2"),
                    a6.style.cssText = a4;
                    var bd = d("span");
                    a6.appendChild(bd),
                    aD.appendChild(a6),
                    a7.appendChild(aD),
                    aD = d("tr"),
                    aD.style.textAlign = "center",
                    a6 = d("th"),
                    a6.setAttribute("colspan", "2"),
                    a6.style.cssText = a4;
                    var be = d("span");
                    a6.appendChild(be),
                    aD.appendChild(a6),
                    bb.appendChild(aD),
                    aD = d("tr"),
                    a6 = d("th"),
                    a6.style.cssText = a2,
                    a3 = d("td"),
                    a6.style.fontWeight = "normal",
                    az = d("span"),
                    az.innerHTML = "\u4ef7\u683c";
                    var a9 = d("span");
                    a3.style.cssText = ax,
                    a6.appendChild(az),
                    a3.appendChild(a9),
                    a6.style.fontWeight = "normal",
                    aD.appendChild(a6),
                    aD.appendChild(a3),
                    bb.appendChild(aD),
                    aD = d("tr"),
                    a6 = d("th"),
                    a6.style.cssText = a2,
                    a6.style.fontWeight = "normal",
                    a3 = d("td"),
                    az = d("span"),
                    az.innerHTML = "\u5747\u4ef7";
                    var bc = d("span");
                    a3.style.cssText = ax,
                    a6.appendChild(az),
                    a6.style.fontWeight = "normal",
                    a3.appendChild(bc),
                    aD.appendChild(a6),
                    aD.appendChild(a3),
                    bb.appendChild(aD),
                    aD = d("tr"),
                    a6 = d("th"),
                    a6.style.cssText = a2,
                    a3 = d("td"),
                    a6.style.fontWeight = "normal",
                    az = d("span"),
                    az.innerHTML = "\u6da8\u8dcc";
                    var ba = d("span");
                    a3.style.cssText = ax,
                    a6.appendChild(az),
                    a3.appendChild(ba),
                    aD.appendChild(a6),
                    aD.appendChild(a3),
                    bb.appendChild(aD),
                    aD = d("tr"),
                    a6 = d("th"),
                    a6.style.cssText = a2,
                    a3 = d("td"),
                    a6.style.fontWeight = "normal",
                    az = d("span"),
                    az.innerHTML = "\u6210\u4ea4";
                    var a8 = d("span");
                    a3.style.cssText = ax,
                    "HF" != W && (a6.appendChild(az), a3.appendChild(a8), aD.appendChild(a6), aD.appendChild(a3), bb.appendChild(aD)),
                    aA.appendChild(a7),
                    aA.appendChild(bb),
                    aA.style.width = "100%",
                    aB.appendChild(aA);
                    var a5 = function(aP, aQ) {
                        var aO = B.COLOR.F_N;
                        return aP > aQ ? aO = B.COLOR.F_RISE: aQ > aP && (aO = B.COLOR.F_FALL),
                        aO
                    };
                    this.setFloaterData = function(aP) {
                        if (ay = aP.name || ay || "", bd.innerHTML = ay, aC = aP.time || aC, bf = aP.data || bf) {
                            be.innerHTML = aC;
                            var aT = bf,
                            aR = Number(aT.percent),
                            aV = Number(aT.price),
                            aS = Number(aT.prevclose),
                            aQ = Number(aT.avg_price),
                            aU = aT.change,
                            aO = 1 > aV || 1 > aQ ? 4 : aN;
                            "HF" == W && (3 > aV || 3 > aQ ? aO = 4 : (99 > aV || 99 > aQ) && (aO = 3)),
                            aR = isNaN(aR) ? "--": (100 * aR).toFixed(2),
                            a9.innerHTML = aV.toFixed(aO),
                            bc.innerHTML = av() ? "--": aQ.toFixed(aO),
                            ba.innerHTML = aU.toFixed(aO) + "(" + aR + "%)",
                            a8.innerHTML = c(aT.volume < 0 ? 0 : aT.volume, 2) + J,
                            ba.style.color = a5(aR, 0),
                            bc.style.color = a5(aQ - aS, 0),
                            a9.style.color = a5(aR, 0)
                        }
                    },
                    this.body = aB
                }
                aH = new aw,
                aJ = aH
            },
            ak = function() {
                function av(aE) {
                    var aC = d("div"),
                    aD = d("div"),
                    aw = d("span"),
                    ay = d("span"),
                    aA = aE.isH,
                    az = 12,
                    aB = function() {
                        if (aD.style.borderStyle = "dashed", aD.style.borderColor = B.COLOR.IVH_LINE, aw.style.backgroundColor = ay.style.backgroundColor = B.COLOR[aE.txtBgCN], aw.style.color = ay.style.color = B.COLOR[aE.txtCN], aA) {
                            aD.style.borderWidth = "1px 0 0 0",
                            aC.style.width = aD.style.width = B.DIMENSION.getStageW() - B.DIMENSION.RIGHT_W + "px",
                            aw.style.top = -(0.6 * B.STYLE.FONT_SIZE) + "px",
                            ay.style.top = -(0.6 * B.STYLE.FONT_SIZE) + "px",
                            aw.style.left = 0,
                            ay.style.left = B.DIMENSION.extend_draw ? B.DIMENSION.getStageW() - 55 + 2 * B.DIMENSION.RIGHT_W + "px": B.DIMENSION.getStageW() - B.DIMENSION.RIGHT_W + "px",
                            aw.style.width = ay.style.width = B.DIMENSION.extend_draw ? "": B.DIMENSION.posX + "px",
                            aw.style.padding = "1px 0",
                            ay.style.padding = "1px 0"
                        } else {
                            aD.style.borderWidth = "0 1px 0 0";
                            var aR, aS, aT = B.DIMENSION.H_MA4K + B.DIMENSION.H_T_B;
                            B.DIMENSION.getStageH() < 0 ? (aR = P.clientHeight, aS = aR - aT) : (aR = B.DIMENSION.getStageH() - ag.clientHeight || 0, aS = B.DIMENSION.h_t),
                            aR -= aT,
                            aR += B.DIMENSION.I_V_O,
                            aC.style.height = aD.style.height = aR + "px",
                            aw.style.top = aS + "px",
                            aw.style.padding = "2px 2px 1px"
                        }
                    };
                    aC.style.position = "absolute",
                    aC.style.zIndex = B.PARAM.I_Z_INDEX - 2,
                    aw.style.position = ay.style.position = aD.style.position = "absolute",
                    aD.style.zIndex = 0,
                    aw.style.zIndex = ay.style.zIndex = 1,
                    aw.style.font = ay.style.font = B.STYLE.FONT_SIZE + "px " + B.STYLE.FONT_FAMILY,
                    aw.style.whiteSpace = ay.style.whiteSpace = "nowrap",
                    aw.style.lineHeight = az + "px",
                    ay.style.lineHeight = az + "px",
                    aE.txtA && (aw.style.textAlign = aE.txtA) && (ay.style.textAlign = "left"),
                    aE.txtBgCN && (aw.style.backgroundColor = B.COLOR[aE.txtBgCN]) && (ay.style.backgroundColor = B.COLOR[aE.txtBgCN]),
                    aB(),
                    aC.appendChild(aw),
                    aA && aC.appendChild(ay),
                    aC.appendChild(aD);
                    var ax = function(aP) {
                        aP ? "" != aC.style.display && (aC.style.display = "") : "none" != aC.style.display && (aC.style.display = "none")
                    };
                    this.pv = function(aU) {
                        if (!isNaN(aU.y) && (aC.style.top = aU.y + (aU.oy || 0) + "px"), aw.innerHTML = aU.v || "", aU.p ? (ay.innerHTML = isNaN(Number(aU.p.replace("%", ""))) ? "0.00%": aU.p, ay.style.display = "") : ay.style.display = "none", !isNaN(aU.x)) {
                            var aX = aU.x + (aU.ox || 0),
                            aV = B.DIMENSION.getStageW();
                            aC.style.left = aX + "px";
                            var aT = aw.offsetWidth;
                            if (0 >= aT && (aT = 112), aT > 0) {
                                var aW = aT >> 1;
                                aU.x < aW ? aW = aU.x: aX + aW > aV - B.DIMENSION.posX && (aW = aX + aT - aV + B.DIMENSION.posX),
                                aw.style.left = -aW + "px"
                            }
                        }
                        ax(!0)
                    },
                    this.display = ax,
                    this.body = aC,
                    this.resize = aB,
                    ax(!1)
                }
                at = new av({
                    isH: !0,
                    txtCN: "P_TC",
                    txtBgCN: "P_BG",
                    txtA: "right"
                }),
                aG = new av({
                    isH: !1,
                    txtCN: "T_TC",
                    txtBgCN: "T_BG",
                    txtA: "center"
                }),
                ad.appendChild(aG.body)
            },
            aF = function() {
                at.display(!1),
                aG.display(!1),
                aI.showFloater(!1)
            },
            al = function() {
                var av = G.getAllStock(),
                aw = av[0].datas.length,
                ax = 0;
                return av[0].realLen >= 0 && (ax = 5 == Y.end ? av[0].realLen + B.datas.tDataLen * (aw - 1) : B.datas.tDataLen * (aw - 1)),
                ax
            },
            ao = function(av) {
                av > 2000 && (av = al()),
                0 > av || (ai && ai.indirectI(av), q && q.indirectI(av))
            },
            aq = function() {
                ao(al()),
                ai && ai.allDraw()
            },
            am = !0,
            ap = 0,
            an = 0,
            aK = 0 / 0,
            aM = 0 / 0;
            this.iToD = function(bF, bJ, bu) {
                var bL = bF.x,
                bH = bF.ox || 0,
                bI = bF.y,
                bt = bF.oy || 0,
                bv = bF.mark,
                bw = bF.rmark,
                bj = bF.e ? bF.e.target: null;
                if (!bu) {
                    if (aK == bL && aM == bI) {
                        return
                    }
                    aK = bL,
                    aM = bI
                }
                if (bj) {
                    var bG = bj.style.height.split("px")[0]; (0 > bI || bI > Number(bG)) && (bL = 0 / 0, bI = 0 / 0)
                }
                var bm, az = G.getAllStock(),
                bk = az.length,
                aw = A,
                aB = bk > 1,
                aC = az[0].datas.length,
                bl = aw * aC,
                bn = Math.floor(bL * bl / B.DIMENSION.w_t);
                if (isNaN(bL) && isNaN(bI)) {
                    if (am = !0, aF(), h(az[0].datas[aC - 1][0].date, az[0].hq.date)) {
                        var bo;
                        bo = az[0].realLen >= 0 ? (aw - 1) * (aC - 1) + az[0].realLen: Number.MAX_VALUE,
                        ao(bo)
                    } else {
                        ao(Number.MAX_VALUE)
                    }
                    return void aj.onViewPrice()
                }
                am = !1,
                an = bn;
                for (var by, bi, bp, aD, br, ax, bD, bK, bs = [], aE = Number.MAX_VALUE, bE = bk; bE--;) {
                    if (ax = az[bE].datas, bs = bs.concat(ax), ax) {
                        var bq = Math.floor(bn / aw),
                        aA = bn % aw;
                        if (!ax[bq]) {
                            return
                        }
                        if (bD = ax[bq][aA], bD.date = ax[bq][0].date, aB && az[bE].dAdd <= 1) {
                            bK = Math.abs(bD.py - bI),
                            aE > bK && (bi = bE, aE = bK, bm = bD, bp = az[bE], aD = az[bE].getName(), br = az[bE].getStockType()),
                            bw = by = bJ ? (100 * bv).toFixed(2) + "%": bv.toFixed(aN)
                        } else {
                            switch (bi = bE, bp = az[bE], aD = az[bE].getName(), br = az[bE].getStockType(), W) {
                            case "HK":
                                by = bv.toFixed(1 > bv && bv > 0 || bv > -1 && 0 > bv ? 3 : aN);
                                break;
                            case "HF":
                                by = bv.toFixed(3 > bv ? 4 : 99 > bv ? 3 : aN);
                                break;
                            default:
                                by = bv.toFixed(1 > bv && bv > 0 || bv > -1 && 0 > bv ? 4 : aN)
                            }
                            by = bv > 99999 ? Math.floor(bv) : bv > 9999 ? bv.toFixed(1) : by,
                            bm = bD
                        }
                    }
                }
                var bB = bD && bD.date;
                ap = 0 == az[0].realLen ? 0 : az[0].realLen - 1;
                var bx = "string" != typeof az[0].date ? g.ds(az[0].date) : az[0].date;
                if (aC > 1) {
                    bp.realLen < 0 && (bp.realLen = A);
                    var bz = bl - aw + bp.realLen;
                    5 == Y.end && bn >= bz && (bn = bz, bm = bs[bq][bn % A])
                } else {
                    if (g.stbd(bB, g.sd(bx))) { - 1 == bp.realLen && (bp.realLen = A),
                        bn >= bp.realLen && (bn = bp.realLen)
                    } else {
                        switch (W) {
                        case "HF":
                        case "NF":
                            bn >= bp.realLen && 4 == Y.start && (bn = bp.realLen);
                            break;
                        default:
                            ap = A - 1
                        }
                    }
                    "HF" != W && "NF" != W && g.stbd(bB, g.sd(bx)) && bp.hq && bp.hq.time >= "09:00" && bp.hq.time < "09:30" ? bm = {
                        price: bp.hq.preopen,
                        avg_price: bp.hq.preopen,
                        prevclose: bp.hq.prevclose,
                        percent: (bp.hq.open - bp.hq.prevclose) / bp.hq.prevclose,
                        change: bp.hq.preopen - bp.hq.price,
                        volume: bp.hq.totalVolume,
                        ix: 0.1,
                        time: bp.hq.time
                    }: (bm = bp.datas[0][bn], bm.prevclose = bp.datas[0][0].prevclose)
                }
                if (bm && (bm.date || (bm.date = bB), !bm || bm.date)) {
                    var av = bL;
                    B.custom.stick && (bL = bm.ix || bL);
                    var bA, ay;
                    "HF" == W ? (bA = C.time[0][0], bA > bm.time ? (bA = bm.date, ay = new Date(bA), ay.setDate(ay.getDate() + 1)) : ay = bm.date) : "NF" == W ? (bA = K.time[0][0], bA <= bm.time && "21:00" == bA ? (bA = bm.date, ay = new Date(bA), ay.setDate(ay.getDate() - 1), 0 == ay.getDay() && ay.setDate(ay.getDate() - 2)) : bm.time < "03:00" && 1 == bm.date.getDay() ? (ay = new Date(bm.date), ay.setDate(ay.getDate() - 2)) : ay = bm.date) : ay = bm.date;
                    var bC = y.dateUtil.ds(ay, "/", !1) + "/" + y.dateUtil.nw(ay.getDay()) + (bm.time || "");
                    bm.day = bC,
                    aJ && (aJ.setFloaterData({
                        stocktype: br,
                        name: aD,
                        time: bC,
                        data: bm
                    }), aI.pv({
                        x: av,
                        y: B.DIMENSION.T_F_T
                    })),
                    at.pv({
                        y: bI,
                        oy: bt,
                        v: by,
                        p: bw
                    }),
                    aG.pv({
                        v: bC,
                        x: bL,
                        ox: bH,
                        y: B.DIMENSION.H_MA4K
                    }),
                    ao(bn),
                    aj.onViewPrice(bm, bn, aD, !am),
                    U.re(a.e.I_EVT, bF.e)
                }
            },
            this.globalDragHandler = function(az, av, ax, aw, ay) {
                isNaN(az) && isNaN(av) && U.re(a.e.I_EVT, ay)
            },
            this.shortClickHandler = function() {
                aj.shortClickHandler()
            },
            this.zoomView = function() {},
            ar(),
            ak(),
            this.onResize = function() {
                at.resize(),
                aG.resize()
            },
            this.iHLineO = at,
            this.hideIUis = aF,
            this.iToKb = function(aT) {
                an += aT,
                ap = an;
                var aB = G.getAllStock(),
                aD = aB[0].datas.length,
                aU = aB[0].datas[0][an],
                ax = aB.length,
                az = aB[0].realLen,
                ay = "string" != typeof aB[0].date ? g.ds(aB[0].date) : aB[0].date;
                1 >= aD ? g.stbd(aB[0].datas[0][0].date, g.sd(ay)) ? 0 > az && (az = A) : az = A: g.stbd(aB[0].datas[aD - 1][0].date, g.sd(ay)) || (az = A);
                var aA = A > az ? az + 1 : az;
                if (0 > an) {
                    var av = A > az ? az: az - 1;
                    ap = an = (aD - 1) * A + av,
                    aU = aB[0].datas[aD - 1][av]
                } else {
                    if (an >= aA + (aD - 1) * A) {
                        if (g.stbd(aB[0].datas[aD - 1][0].date, g.sd(ay)) && 0 > aT) {
                            var aS = 0;
                            aS = aD > 1 ? az - 1 + A * (aD - 1) : az - 1,
                            ap = an = aS,
                            aU = aB[0].datas[0][ap]
                        } else {
                            ap = an = 0,
                            aU = aB[0].datas[0][0]
                        }
                    }
                } ! l(E, D.iHLineO.body) && E.appendChild(D.iHLineO.body);
                var aE = Math.floor(ap / A);
                an >= A && (aU = aB[0].datas[aE][ap - aE * A]),
                aU.date = aB[0].datas[aE][0].date;
                var aw = ax > 1 ? aU.percent: aU.price,
                aC = {
                    idx: an,
                    name: aB[0].getName(),
                    mark: aw,
                    datas: aB[0].datas,
                    data: aU,
                    x: aU.ix,
                    y: aU.py,
                    oy: B.DIMENSION.H_MA4K,
                    ox: B.DIMENSION.posX
                };
                this.iToD(aC, !0, !0)
            },
            this.isIng = function() {
                return ! am
            },
            this.isMoving = function() {
                return ! 1
            },
            this.iReset = function() {},
            this.patcher = new
            function() {
                var ax, av = {},
                aw = function() {
                    if (ax) {
                        aJ.body.parentNode && aJ.body.parentNode.removeChild(aJ.body);
                        var az = "vid_" + Y.viewId;
                        if (ax[az]) {
                            var ay;
                            ay = av[az] ? av[az] : av[az] = new ax[az],
                            aJ = ay
                        } else {
                            aJ = aH
                        }
                    } else {
                        aJ = aH
                    } ! l(ad, aJ.body) && ad.appendChild(aJ.body)
                };
                this.customFloater = function(ay) {
                    ax = ay,
                    aw(),
                    y.stc("t_fl", ay)
                },
                this.switchFloater = aw
            },
            this.update = function() {
                var aw = G.getAllStock();
                if (aw) {
                    var av, ay = aw[0],
                    aA = ay.datas.length,
                    aB = 0;
                    if (ay) {
                        if (an > aA * (A - 1) && (an = 0), av = Math.floor(an / (A - 1)), aA == av && (av -= 1), an > A - 1) {
                            var ax = an - A * av;
                            aB = h(ay.datas[av][0].date, ay.hq.date) && ax > ap ? ay.realLen: ax
                        } else {
                            aB = 1 == aA && 0 == av && an > ap ? ay.realLen: an
                        }
                        if (av = 0 > av ? 0 : av, aB = 0 > aB ? 0 : aB, au = ay.datas[av][aB]) {
                            if (au.day = y.dateUtil.ds(ay.datas[av][0].date, "/", !1) + "/" + y.dateUtil.nw(ay.datas[av][0].date.getDay()) + (au.time || ""), aJ && aJ.setFloaterData({}), am) {
                                if (h(ay.datas[aA - 1][0].date, ay.hq.date)) {
                                    aB = ay.realLen >= 0 ? ay.realLen: A - 1,
                                    aB += (aA - 1) * A,
                                    aB = 0 > aB ? Number.MAX_VALUE: aB,
                                    ao(aB)
                                } else {
                                    if ("NF" == W && ay.hq.time >= "21:00") {
                                        return ay.realLen >= 0 && (aB = ay.realLen),
                                        void(4 == Y.start && 5 == Y.end && aj.onViewPrice(au, aB, void 0, !am))
                                    }
                                    aq()
                                }
                            } else {
                                if ("HF" == W) {
                                    4 == Y.start && 5 == Y.end && aj.onViewPrice(au, aB, void 0, !am)
                                } else {
                                    if ("NF" == W) {
                                        var az = new Date(au.date);
                                        au.date && au.time >= "21:00" && (az.setDate(1 == au.date.getDay() ? az.getDate() - 3 : az.getDate() - 1), au.day = y.dateUtil.ds(az, "/", !1) + "/" + y.dateUtil.nw(az.getDay()) + (au.time || "")),
                                        aj.onViewPrice(au, aB, void 0, !am)
                                    } else {
                                        aj.onViewPrice(au, aB, void 0, !am)
                                    }
                                }
                            }
                        }
                    }
                }
            }
        };
        return u = new
        function() {
            var am = this,
            ao = function(aw, av) {
                if (B.hasOwnProperty(aw)) {
                    for (var ax in av) {
                        if (av.hasOwnProperty(ax) && y.isFunc(av[ax])) {
                            return void y.trace.error("illegal operation:", ax)
                        }
                    }
                    "DIMENSION" == aw && (L = 1),
                    t(B[aw], av),
                    y.stc(aw, av),
                    am.resize()
                } else {
                    y.trace.error("not exist param:", aw)
                }
            },
            at = function(aD, ax) {
                var aw;
                if (B.hasOwnProperty(aD)) {
                    aw = y.clone(B[aD]);
                    for (var av in aw) {
                        if (aw.hasOwnProperty(av) && y.isFunc(aw[av])) {
                            aw[av] = null,
                            delete aw[av]
                        } else {
                            if (ax) {
                                for (var aE = ax.length; aE--;) {
                                    typeof aw[av] === ax[aE] && (aw[av] = null, delete aw[av])
                                }
                            }
                        }
                    }
                }
                return aw
            },
            ay = function(av, aw, ax) {
                ax = t({
                    toremove: !1,
                    isexclusive: !1,
                    callback: void 0
                },
                ax),
                ax.toremove ? G.mM.removeAC(aw, av) : ax.isexclusive ? (G.mM.removeAC(null, av), G.mM.newAC(aw, av, ax)) : G.mM.newAC(aw, av, ax)
            },
            au = function(av) {
                Y.viewId = av,
                Y.start = 1 == av ? 4 : 0,
                Y.end = 5
            };
            this.pushData = function(av, aw) { ! y.isArr(av) && (av = [av]),
                G.pushData(av, aw)
            };
            var ak;
            this.pushTr = function(av) {
                av && av.data && (clearTimeout(ak), ak = setTimeout(function() {
                    var aD = av.data.split(","),
                    aC = av.symbol,
                    aw = av.market,
                    ax = {
                        symbol: aC,
                        data: aD[aD.length - 1],
                        market: aw
                    };
                    G.pushData([ax], 1)
                },
                20))
            },
            this.setScale = function(av) {
                G.setScale(av),
                y.stc("t_scale", av)
            };
            var aq = !0;
            this.showView = function(aC, ax) {
                D.hideIUis(),
                aq ? aq = !1 : R.hide();
                var aw = a.URLHASH.vi(aC);
                if (k.date) {
                    return k.date = "",
                    au(aw),
                    void this.newSymbol(k)
                }
                var av = G.getAllStock()[0];
                if (aj.onRange(av), y.stc("t_v", aC), y.suda("vw", aC), Y.viewId != aw) {
                    if (au(aw), ("HF" == W || "NF" == W) && "t5" == aC && 0 == X) {
                        return R.show(),
                        X = 1,
                        void G.update5Data(aC)
                    }
                    G.onChangeView(!1, ax),
                    aj && aj.onViewPrice()
                }
            };
            var az = function(av) {
                var aw;
                return aw = y.isStr(av.symbol) ? av.symbol.split(",") : [av.symbol]
            },
            ap = [];
            this.overlay = function(av, aw) {
                if (G && 1 != G.dAdd) {
                    if (aw) {
                        G.removeCompare(az(av));
                        for (var ax = 0; ax < ap.length; ax++) {
                            av.symbol == ap[ax] && ap.splice(ax, 1)
                        }
                        G.getAllStock().length <= 1 && (G.dAdd = 0)
                    } else {
                        k.overlaycolor = av.linecolor || {
                            K_N: "#cccccc"
                        },
                        G.dAdd = 2,
                        G.compare(av),
                        ap.push(av.symbol)
                    }
                }
            },
            this.compare = function(aC, ax) {
                if (G) {
                    var av, aw = 0;
                    if (ax) {
                        if (av = y.isStr(aC) ? aC.split(",") : [aC.symbol], 1 == G.dAdd && G.removeCompare(av), G.getAllStock().length <= 1) {
                            for (aw = 0; aw < ap.length; aw++) {
                                G.dAdd = 2,
                                G.compare({
                                    symbol: ap[aw]
                                })
                            }
                            ap.length < 1 && (G.dAdd = 0)
                        }
                    } else {
                        2 == G.dAdd && G.removeCompare(ap),
                        G.dAdd = 1,
                        G.compare(aC),
                        y.suda("t_comp")
                    }
                    y.stc("t_comp", {
                        rm: ax,
                        o: aC
                    })
                }
            };
            var ar = 0;
            this.tCharts = function(av, aw) {
                ay("tech", av, aw),
                aw && !aw.noLog && (0 == ar ? ar = 1 : y.sudaLog())
            };
            var al = 0;
            this.pCharts = function(av, aw) {
                ay("price", av, aw),
                aw && !aw.noLog && (0 == al ? al = 1 : y.sudaLog())
            },
            this.showPCharts = function(av) {
                av && (G.mM.togglePt(av), y.stc("t_sp", av))
            },
            this.getIndicators = function() {
                var av = ai ? ai.getLog() : null,
                aw = q ? q.getLog() : null;
                return {
                    tCharts: av,
                    pCharts: aw
                }
            };
            var an;
            this.showRangeSelector = function(av) {
                an = t({
                    dispaly: !0,
                    from: void 0,
                    to: void 0
                },
                av),
                G.mM.showRs(an),
                y.stc("t_rs", av)
            },
            this.setLineStyle = function(av) {
                G && G.setTLineStyle(av),
                y.stc("t_style", av)
            },
            this.setCustom = T(ao, this, "custom"),
            this.setDimension = T(ao, this, "DIMENSION"),
            this.getDimension = T(at, null, "DIMENSION", ["boolean"]),
            this.setTheme = function(av) {
                var aw = F.initTheme(av);
                aw && (this.setLineStyle({
                    linecolor: av
                }), this.resize())
            },
            this.newSymbol = function(av) {
                if (k.symbol = av.symbol, k.date = av.date, D.hideIUis(), D.iReset(), G.dcReset(), G.dcInit(k), O.hideTip(), ai) {
                    var aw = ai.getLog();
                    ai = null,
                    aw && this.tCharts(aw)
                }
                if (q) {
                    var ax = q.getLog();
                    q = null,
                    ax && this.pCharts(ax)
                }
                an && (an.from = void 0, an.to = void 0, G.mM.showRs(an)),
                y.stc("t_ns", av)
            },
            this.resize = function(av, aw) {
                F.resizeAll(!0, av, aw)
            },
            this.hide = function(av) {
                af = !0,
                D.hideIUis(),
                y.$CONTAINS(ac, ad) && ac.removeChild(ad),
                av && G.dcReset()
            },
            this.show = function(av) {
                af = !1,
                av && (y.isStr(av) && (av = e(av)), ac = av),
                y.$CONTAINS(ac, ad) || (ac.appendChild(ad), F.resizeAll(!0)),
                aj && aj.onViewPrice()
            },
            this.shareTo = function(av) {
                G.shareTo(av),
                y.stc("t_share", av);
                var aw = av && av.type ? av.type: "weibo";
                y.suda("share", aw)
            },
            this.getChartId = function() {
                return B.uid
            },
            this.dateTo = function(aF, aE) {
                k.historytime = aF,
                k.historycb = aE;
                var av = aF;
                "object" == typeof aF ? av = g.ds(aF, "-") : aF = g.sd(aF);
                var aG = I.get();
                if (null == aG) {
                    return void(ab = 1)
                }
                for (var ax = aG.length,
                aw = 0; ax > aw; aw++) {
                    if (g.stbd(aF, aG[aw][0].date)) {
                        return void G.moving(aw, aw + 1, "dateTo")
                    }
                }
                k.date = av,
                G.hasHistory = aE,
                y.stc("t_ft", av),
                this.newSymbol(k)
            },
            this.showScale = function(av) {
                G && G.setScale(av)
            },
            this.resize = function(av, aw) {
                F.resizeAll(!0, av, aw)
            },
            this.showCompatibleTip = function(av) {
                F.showCompatibleTip(av)
            },
            this.toggleExtend = function(av) {
                var aw, ax = B.DIMENSION.posX;
                aw = av ? "on" == !av: B.DIMENSION.extend_draw,
                ao.call(this, "DIMENSION", {
                    extend_draw: !aw,
                    posX: ax > 9 ? 7 : 55,
                    RIGHT_W: ax > 9 ? 7 : 55
                }),
                this.resize()
            },
            this.historyData = function() {
                return G.historyData
            },
            this.getExtraData = function(av) {
                return G.getExtraData(av)
            },
            this.patcher = {
                iMgr: D.patcher
            },
            this.zoom = function(av) {
                G.zoomApi(av),
                y.stc("t_zoom", av, 9000)
            },
            this.move = function(av) {
                av = parseInt(av),
                isNaN(av) || (G.moveApi(av), y.stc("t_move", av, 9000))
            },
            this.getSymbols = function() {
                return G.getAllSymbols()
            },
            this.update = function() {
                G.updateDataAll(),
                y.stc("t_up", "update", 9000)
            },
            this.getCurrentData = function() {
                return aj.currentData()
            },
            this.viewState = Y,
            this.me = U,
            this.type = "h5t"
        },
        G = new Q,
        G.dcInit(k),
        u
    }
    function r() {
        function j(w, k) {
            var q = new m(w),
            z = function(A) {
                q.me.rl(A, z)
            };
            q.me.al(a.e.T_DATA_LOADED, z),
            y.isFunc(k) && k(q)
        }
        this.get = function(D, q) {
            y.stc("h5t_get"),
            y.suda("h5t_" + y.market(D.symbol));
            var z;
            0 == location.protocol.indexOf("http:") && (z = !0);
            var B = y.market(D.symbol),
            A = "//" + window.location.host + "/api/hfline.php?callback=$cb&market=$market&code=$symbol",
            C ="//"+window.location.host+"/api/gbchart.php?callback=$cb&type=time&code=$symbol&category=index";
            switch (z && (A = y.getSUrl(A)), B) {
            case "HF":
                var w = "kke_future_" + D.symbol;
                y.load(A.replace("$symbol", D.symbol.replace("hf_", "")).replace("$market", "hf").replace("$cb", "var " + w),
                function() {
                    w = window[w] || {
                        time: [["06:00", "23:59"], ["00:00", "05:00"]]
                    },
                    D._hf_window_var = w,
                    j(D, q)
                },
                null, {
                    symbol: D.symbol,
                    market: B,
                    type: "init_hf"
                });
                break;
            case "NF":
                var F = "kke_future_" + D.symbol,
                E = D.symbol.replace("nf_", "").replace(/[\d]+$/, "");
                y.load(A.replace("$symbol", E).replace("$market", "nf").replace("$cb", "var " + F),
                function() {
                    F = window[F] || {
                        time: [["09:30", "11:29"], ["13:00", "02:59"]]
                    },
                    F.inited = 0,
                    D._nf_window_var = F,
                    j(D, q)
                },
                null, {
                    symbol: D.symbol,
                    market: B,
                    type: "init_nf"
                });
                break;
            case "global_index":
                var k = "kke_global_index_" + D.symbol;
                y.load(C.replace("$symbol", D.symbol.replace("znb_", "")).replace("$cb", k),
                function() {
                    k = window[k] || {
                        time: [["06:00", "23:59"], ["00:00", "05:00"]]
                    },
                    D._gbi_window_var = k,
                    j(D, q)
                },
                null, {
                    symbol: D.symbol,
                    market: B,
                    type: "init_global"
                });
                break;
            default:
                j(D, q)
            }
        }
    }
    var u, s, x, o, e = y.$DOM,
    d = y.$C,
    l = y.$CONTAINS,
    p = y.xh5_PosUtil,
    i = y.xh5_EvtUtil,
    t = y.oc,
    g = y.dateUtil,
    h = y.dateUtil.stbd,
    n = y.xh5_ADJUST_HIGH_LOW.c,
    N = y.xh5_BrowserUtil,
    T = y.fBind,
    c = y.strUtil.ps,
    a = f.globalCfg,
    v = y.logoM;
    return y.fInherit(m, y.xh5_EvtDispatcher),
    r
});