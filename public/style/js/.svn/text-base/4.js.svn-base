function _classCallCheck(c, d) {
    if (! (c instanceof d)) {
        throw new TypeError("Cannot call a class as a function")
    }
}
function killErrors() {
    return true
}
window.onerror = killErrors;
function jsonp(l) {
    var o = "hqccall" +
    function() {
        return Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1)
    } (),
    a = document.getElementsByTagName("head")[0],
    e = document.createElement("script"),
    n = function(b) {
        if (b) {
            var c = [];
            for (var d in b) {
                b.hasOwnProperty(d) && c.push(d + "=" + b[d])
            }
            return encodeURI("?" + c.join("&"))
        }
    } (l.data) || "",
    i = l.success,
    p = l.jsoncallback ? "&callback=" + o: "",
    m = l.url;
    e.src = m + n + p,
    e.type = "text/javascript",
    e.onload = e.onreadystatechange = function() {
        this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (p || i(), e.onload = e.onreadystatechange = null, a.removeChild(e))
    },
    a.appendChild(e),
    p && (window[o] = function(b) {
        i && i(b.result),
        delete window[o]
    })
}
function random() {
    return Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1)
} !
function(S) {
    function p(A, E) {
        for (var j = E || 40,
        q = Math.ceil(A.length / j), D = [], z = 0; z < q; z++) {
            D.push(A.slice(z * j, (z + 1) * j))
        }
        return D
    }
    function C(E) {
        var G = "hqccall" + g(),
        D = document.getElementsByTagName("head")[0],
        z = document.createElement("script"),
        F = function(I) {
            var J = [];
            for (var K in I) {
                I.hasOwnProperty(K) && J.push(K + "=" + I[K])
            }
            return encodeURI(J.join("&"))
        } (E.data) || "",
        A = E.success,
        q = E.jsoncallback ? "&callback=" + G: "",
        j = E.url;
        z.src = j + F + q,
        z.type = "text/javascript",
        z.onload = z.onreadystatechange = function() {
            this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (q || A(), z.onload = z.onreadystatechange = null, D.removeChild(z))
        },
        D.appendChild(z),
        q && (S[G] = function(I) {
            A && A(I.result),
            delete S[G]
        })
    }
    function g() {
        return Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1)
    }
    function o(z) {
        var D = encodeURIComponent(z) + "",
        j = document.cookie.indexOf(D),
        q = null;
        if (j > -1) {
            var A = document.cookie.indexOf(";", j); - 1 == A && (A = document.cookie.length),
            q = decodeURIComponent(document.cookie.substring(j + D.length + 1, A))
        }
        return q
    }
    function h(q, z) {
        var j = z || 2;
        return parseFloat(q) ? parseFloat(q).toFixed(j) : 0
    }
    function c(A, E, j) {
        var q, D, z = j || 2;
        return parseFloat(A) && parseFloat(E) ? (q = parseFloat(A) - parseFloat(E), D = (100 * q / parseFloat(E)).toFixed(z) + "%", q = q.toFixed(z), parseFloat(A) > parseFloat(E) && (q = "+" + q, D = "+" + D)) : (q = "0.00", D = "0.00%"),
        [q, D]
    }
    function l(A, D, j) {
        var q, z, E;
        return z = !j || "A" !== j && "NF" !== j && "GZ" !== j && "SB" !== j ? "global": "china",
        parseFloat(A) && parseFloat(D) ? (E = o("hq_userColor") || localStorage.getItem("hq_riseColor") || "riseRed", q = parseFloat(A) > parseFloat(D) ? "riseRed" === E ? "red": "green": parseFloat(A) < parseFloat(D) ? "riseRed" === E ? "green": "red": "equal", [q, z]) : ["equal", z]
    }
    function e(z, D, j, q) {
        var A = q || 2;
        return parseFloat(z) && parseFloat(D) && parseFloat(j) ? (100 * (parseFloat(z) - parseFloat(D)) / parseFloat(j)).toFixed(A) + "%": "--"
    }
    function N(z, D, j, q) {
        var A;
        if (!parseFloat(z) || !parseFloat(D)) {
            return "--"
        }
        switch (j) {
        case "turnover":
            return A = parseFloat(z) / (10000 * parseFloat(D)),
            (100 * A).toFixed(2) + "%";
        case "pb":
            return A = (parseFloat(z) / parseFloat(D)).toFixed(2);
        case "pe":
            return A = parseFloat(D) > 0 ? (parseFloat(z) * parseFloat(q) * 10000 / parseFloat(D) / 100000000).toFixed(2) : "--";
        case "total":
            return A = parseFloat(z) * parseFloat(D) * 10000,
            [A, ab(A)];
        case "ps":
            return A = (parseFloat(z) * parseFloat(q) / (10000 * parseFloat(D))).toFixed(2)
        }
    }
    function r(q, z) {
        var j = 0;
        return parseFloat(z) ? (j = parseFloat(q) / parseFloat(z), (100 * j).toFixed(2) + "%") : "--"
    }
    function O(A, E, j) {
        if (!parseFloat(E)) {
            return "--"
        }
        var q, D = j.split(":"),
        z = 60 * parseFloat(D[0]) + parseFloat(D[1]);
        return z > 690 && (z < 780 ? z = 689 : (z > 900 && (z = 899), z -= 90)),
        z += 1,
        q = z - 570,
        (parseFloat(A) / 100 / parseFloat(E) / q).toFixed(2)
    }
    function i(j) {
        return j ? j.split(" ")[2].indexOf("PM") > -1 ? "\u76d8\u540e": "\u76d8\u524d": "--"
    }
    function b(q) {
        if (!q) {
            return "--"
        }
        var z = parseFloat(q),
        j = localStorage.getItem("hq_riseColor") || "riseRed";
        return z > 0 ? "riseRed" === j ? "red": "green": z < 0 ? "riseRed" === j ? "green": "red": "equal"
    }
    function B(z) {
        var A, j, q = z ? z.substring(7, 14) : "";
        return q.indexOf("AM") > 0 ? (A = q.split(":"), j = 60 * parseFloat(A[0]) + parseFloat(A[1]), j < 570 ? "\u672a\u5f00\u76d8": "") : q.indexOf("PM") > 0 ? parseFloat(q) < 4 ? "": "\u672a\u5f00\u76d8": ""
    }
    function f(q, z) {
        var j = z || 0.1;
        return [(parseFloat(q) * (1 + j)).toFixed(2), (parseFloat(q) * (1 - j)).toFixed(2)]
    }
    function ab(A, F, j, q, E) {
        var z = j || 1,
        G = F || 0 === F ? F: 2,
        D = q || "";
        return 0 === parseFloat(A) ? parseFloat(A).toFixed(G) : parseFloat(A) ? Math.abs(parseFloat(A) / z) > 100000000 ? (parseFloat(A) / z / 100000000).toFixed(G) + "\u4ebf" + D: Math.abs(parseFloat(A) / z) > 10000 && !E ? (parseFloat(A) / z / 10000).toFixed(G) + "\u4e07" + D: (parseFloat(A) / z).toFixed(G) + D: "--"
    }
    function s(A, F, j, q, E) {
        var z = F || 2,
        G = j ? 1 : 100,
        D = E ? "": "%";
        return 0 === parseFloat(A) ? (parseFloat(A) * G).toFixed(z) + D: A ? parseFloat(A) > 0 && q ? "+" + (parseFloat(A) * G).toFixed(z) + D: (parseFloat(A) * G).toFixed(z) + D: "--"
    }
    function x(z, A, j) {
        var q = parseFloat(z) - parseFloat(A);
        return [ab(q, 2, 1), j ? (100 * q / parseFloat(j)).toFixed(2) + "%": "--"]
    }
    function H(j) {
        var q = j;
        return {
            "\u6fb3\u5927\u5229\u4e9a\u5143": "\u6fb3\u5143",
            "\u52a0\u62ff\u5927\u5143": "\u52a0\u5143",
            "\u745e\u5178\u514b\u6717": "\u745e\u5178\u6717",
            "\u65b0\u52a0\u5761\u5143": "\u65b0\u5143",
            "\u745e\u58eb\u6cd5\u90ce": "\u745e\u90ce",
            "\u632a\u5a01\u514b\u6717": "\u632a\u6717",
            "\u4fc4\u7f57\u65af\u5362\u5e03": "\u5362\u5e03",
            "\u83f2\u5f8b\u5bbe\u6bd4\u7d22": "\u6bd4\u7d22",
            "\u65b0\u897f\u5170\u5143": "\u7ebd\u5e01",
            "\u5357\u975e\u5170\u7279": "\u5170\u7279",
            "\u9a6c\u6765\u897f\u4e9a\u5143": "\u6797\u5409\u7279"
        } [q] || q
    }
    function a(j) {
        var q = j;
        return {
            "\u5bcc\u65f6100\u6307\u6570": "\u82f1\u56fd\u5bcc\u65f6100",
            "\u9053\u743c\u65af\u6b27\u5143\u533a\u65af\u6258\u514b50\u6307\u6570": "\u6b27Stoxx50",
            "\u6fb3\u5927\u5229\u4e9a\u6807\u51c6\u666e\u5c14200\u6307\u6570": "\u6fb3ASX200",
            "FTSE/JSE \u5357\u975e40\u6307\u6570": "\u5357\u975eJSE40"
        } [q] || q
    }
    function v(j) {
        var q = j;
        return {
            "\u6052\u751f\u4e2d\u56fd\u4f01\u4e1a\u6307\u6570": "\u56fd\u4f01\u6307\u6570",
            "\u6052\u751f\u9999\u6e2f\u4e2d\u8d44\u4f01\u4e1a\u6307\u6570": "\u7ea2\u7b79\u6307\u6570"
        } [q] || q
    }
    function y(z, A) {
        var j = z.substr(3).replace(/[0-9]/gi, ""),
        q = {
            IF: "sh000300",
            IH: "sh000016",
            IC: "sh000905"
        };
        return ["IF", "IH", "IC"].indexOf(j) > -1 ? A[q[j]].split(",") : ""
    }
    function d(q) {
        var z = q,
        j = {
            O: "NASDAQ",
            N: "NYSE",
            A: "AMEX"
        };
        return j.hasOwnProperty(z) ? j[z] : "--"
    }
    function t(q, z) {
        var j;
        switch (z) {
        case 1:
            0 !== parseInt(q) && (j = "\u505c\u724c");
            break;
        case 2:
            j = "\u672a\u4e0a\u5e02";
            break;
        case 3:
            j = "\u9000\u5e02";
            break;
        default:
            j = ""
        }
        return j
    }
    function m(D, q, z, G, j, E) {
        if (void 0 === E) {
            return [j[D + "_tradeItem"], j[D + "_tradeVols"]]
        }
        var I = 0,
        F = "EQUAL",
        A = [];
        return parseFloat(E.totalVolume_i) < parseFloat(q) ? (I = q - E.totalVolume_i, E.buyPriceArr[0] || E.sellPriceArr[0] ? (z >= E.sellPriceArr[0] && E.sellPriceArr[0] && (F = "UP"), z <= E.buyPriceArr[0] && E.buyPriceArr[0] && (F = "DOWN")) : (z > E.price && (F = "UP"), z < E.price && (F = "DOWN")), A[0] = G, A[1] = I.toString(), A[2] = h(z), A[3] = F, j[D + "_tradeItem"].unshift(A), j[D + "_tradeItem"].pop(), j[D + "_tradeVols"][0] += "UP" == F ? I: " " == F ? I / 2 : 0, j[D + "_tradeVols"][1] += "DOWN" == F ? I: " " == F ? I / 2 : 0, [j[D + "_tradeItem"], j[D + "_tradeVols"]]) : [j[D + "_tradeItem"], j[D + "_tradeVols"]]
    }
    function k(q, z, j) {
        return "ped" === j ? h(q / 100000000 / z / 4) : "pej" === j ? h(q / z) : void 0
    }
    function w(z) {
        var A = z,
        j = 0,
        q = 0;
        return j = parseFloat(A[20]) + parseFloat(A[22]) + parseFloat(A[24]) + parseFloat(A[26]) + parseFloat(A[28]),
        q = parseFloat(A[10]) + parseFloat(A[12]) + parseFloat(A[14]) + parseFloat(A[16]) + parseFloat(A[18]),
        j && q ? s((q - j) / (j + q) + "", 2) : "--"
    }
    function u(j, q) {
        return "string" != typeof j ? "--": (j = parseFloat(j), Number.isNaN(j) ? "--": j.toFixed(q))
    }
    if (!S.HQ || !S.HQ.VERSION) {
        var n = {
            VERSION: "3.0"
        };
        n.DataCenter = function(q, z) {
            this._config = {
                host: window.location.host,
                symbols: "",
                loadType: "",
                allowrepeat: !0,
                ssl: !0,
                ishttp: !1,
                interval: 3000,
                nxkeyvalue: "notexist",
                getObj: null,
                getStr: null,
                isHKNeed_i: !0,
                isHKClickFresh: !0,
                isANeedCWZJ: !0,
                isANeedQZ: !1,
                isANeedPHP: !0,
                QZindex: "",
                eachOrder: !1
            },
            this._AppCallback = z;
            for (var j in q) {
                q.hasOwnProperty(j) && (this._config[j] = q[j])
            }
            this._SymList = [],
            this._RestNum = 0,
            this._RestHknum = 0,
            this._DataObj = new n.DataHandle,
            this._Socket = null,
            this._SocketOther = null,
            this._ResObj = {},
            this._ConStr = {},
            this._SocketKey = !0,
            this._Catch = [],
            this._Sym_OtherNum = 0,
            this._Sym_AllAList = [],
            this._Sym_StockAList = [],
            this._Sym_IndexAList = [],
            this._Sym_BondAList = [],
            this._Sym_AllHKList = [],
            this._Sym_ALLRTHKList = [],
            this._Sym_GzNfList = [],
            this._Sym_GziNfList = [],
            this._Sym_StockUsList = [],
            this._Sym_FUNDList = [],
            this._Sym_ZNBList = [],
            this._init()
        },
        n.DataCenter.prototype._init = function() {
            var j = this;
            if (j._SymList = j._config.symbols.split(","), 0 === j._SymList.length) {
                return console.log("symbols\u5b57\u6bb5\u4e3a\u7a7a\uff0c\u65e0\u6cd5\u542f\u52a8\u7ec4\u4ef6")
            }
            j._splitSymbol(j._SymList)
        },
        n.DataCenter.prototype._splitSymbol = function(z) {
            var A = this,
            j = /^sh(20|1|009|010|020|019)/,
            q = /^sz(100|101|108|109|111|112|115|12|13|106|107)/;
            z.forEach(function(F, G, E) {
                "A" === A.getMarket(F) && (A._Sym_AllAList.push(F), /^(sh00)\d+/.test(F) || /^(sz399)\d+/.test(F) ? A._Sym_IndexAList.push(F) : j.test(F) || q.test(F) ? A._Sym_BondAList.push(F) : A._Sym_StockAList.push(F)),
                "HK" === A.getMarket(F) && A._Sym_AllHKList.push(F),
                "RTHK" === A.getMarket(F) && A._Sym_ALLRTHKList.push(F);
                var D = F.substr(3).replace(/[0-9]/gi, "");
                "NF" === A.getMarket(F) && ["IF", "TF", "T", "IH", "IC"].indexOf(D) > -1 && (A._Sym_GzNfList.push(F), "T" !== D && "TF" !== D && A._Sym_GziNfList.push(F)),
                "US" === A.getMarket(F) && (E[G] = F.replace(/\./g, "$"), A._Sym_StockUsList.push(E[G])),
                "FUND" === A.getMarket(F) && A._Sym_FUNDList.push(F),
                "ZNB" === A.getMarket(F) && A._Sym_ZNBList.push(F)
            }),
            A._Sym_AllAList.length && ++A._Sym_OtherNum,
            A._Sym_IndexAList.length && (A._config.isANeedPHP ? A._Sym_OtherNum += 2 : A._Sym_OtherNum += 1),
            A._Sym_StockAList.length && A._config.isANeedCWZJ && (A._config.isANeedPHP ? A._Sym_OtherNum += 2 : A._Sym_OtherNum += 1),
            A._Sym_StockAList.length && A._config.eachOrder && (A._Sym_OtherNum += 1),
            A._Sym_BondAList.length && A._config.eachOrder && (A._Sym_OtherNum += 1),
            A._Sym_GziNfList.length && ++A._Sym_OtherNum,
            A._Sym_StockUsList.length && (A._Sym_OtherNum += 2),
            A._Sym_AllHKList.length && A._config.isHKClickFresh && (A._Sym_AllHKList.forEach(function(D) {
                var E = A._SymList.indexOf(D);
                A._SymList.splice(E, 1)
            }), A._RestNum = A._SymList.length, A._config.isHKNeed_i ? (A._Sym_AllHKList.length && (A._Sym_OtherNum += 1), A._loadOthers(function() {
                A.hkRefresh()
            },
            "hk")) : A.hkRefresh()),
            A._Sym_FUNDList.length && (A._Sym_OtherNum += 1),
            A._Sym_AllAList.length || A._Sym_GziNfList.length || A._Sym_StockUsList.length || A._Sym_FUNDList.length ? A._loadOthers(function() {
                A._webmainPush()
            }) : A._SymList.length && A._webmainPush()
        },
        n.DataCenter.prototype._loadOthers = function(F, z) {
            function E(P, I, L, K) {
                for (var G = K || "back",
                M = [], J = 0; J < P.length; J++) {
                    M[J] = "back" === G ? P[J] + I: I + P[J]
                }
                D._loadScript({
                    symbol: M.join(",")
                },
                function(R) {
                    for (var Q in R) {
                        R.hasOwnProperty(Q) && (D._ConStr[Q] = R[Q])
                    }--D._Sym_OtherNum,
                    L()
                })
            }
            function A(I, J) {
                var K = I.join(","),
                G = "";
                D._config.QZindex && D._config.isANeedQZ && (G = D._config.QZindex),
                D._loadPhp({
                    symbol: K,
                    isymbol: G,
                    dpc: 1
                },
                function(L) {
                    I.forEach(function(M) {
                        D._ConStr[M + "_php"] = L.data[M]
                    }),
                    --D._Sym_OtherNum,
                    J()
                })
            }
            function j(J, G) {
                var I = J.length;
                J.forEach(function(K) {
                    C({
                        url: "" + K,
                        success: function() {
                            D._ConStr[K + "_tradeItem"] = S.trade_item_list,
                            D._ConStr[K + "_tradeVols"] = S.trade_INVOL_OUTVOL,
                            --I || (--D._Sym_OtherNum, G())
                        }
                    })
                })
            }
            var D = this,
            q = F;
            if (z && "hk" === z && D._Sym_AllHKList.length) {
                return E(D._Sym_AllHKList, "_i", q, "back")
            }
            D._Sym_AllAList.length && E(D._Sym_AllAList, "_i", q, "back"),
            D._Sym_StockAList.length && D._config.isANeedCWZJ && D._webotherPush(D._Sym_AllAList, "zjlxn_", q, "front"),
            D._Sym_StockAList.length && D._config.isANeedPHP && D._config.isANeedCWZJ && A(D._Sym_AllAList, q),
            D._Sym_BondAList.length && D._config.eachOrder && j(D._Sym_BondAList, q),
            D._Sym_StockAList.length && D._config.eachOrder && j(D._Sym_StockAList, q),
            D._Sym_IndexAList.length && E(D._Sym_IndexAList, "_zdp", q, "back"),
            D._Sym_IndexAList.length && D._config.isANeedPHP && A(D._Sym_IndexAList, q),
            D._Sym_GziNfList.length && E(["sh000300", "sh000016", "sh000905"], "", q, "back"),
            D._Sym_StockUsList.length && (E(D._Sym_StockUsList, "_i", q, "back"), D._loadScript({
                symbol: "gb_ixic"
            },
            function(G) {
                D._ConStr._ixicStr = G.gb_ixic,
                --D._Sym_OtherNum,
                q()
            })),
            D._Sym_FUNDList.length && E(D._Sym_FUNDList, "fu_rate_", q, "front")
        },
        n.DataCenter.prototype._initData = function(q) {
            var z, j = this;
            j._SocketKey = !1,
            z = Object.keys(q),
            j._RestNum = z.length,
            z.forEach(function(A) {
                j._handle(A, q[A],
                function() {--j._RestNum,
                    j._success(q)
                })
            })
        },
        n.DataCenter.prototype._success = function(q) {
            var z, j = this;
            j._RestHknum || j._RestNum || (this._callbacks(q), j._Catch.length ? (z = j._Catch.shift(), j._initData(z)) : j._SocketKey = !0)
        },
        n.DataCenter.prototype._callbacks = function(j) {
            var q = this;
            "function" == typeof q._AppCallback && q._AppCallback(q._ResObj),
            "function" == typeof q._config.getObj && q._config.getObj(q._ResObj),
            "function" == typeof q._config.getStr && q._config.getStr(j)
        },
        n.DataCenter.prototype._handle = function(z, J, j, E) {
            var I, F = this;
            switch (E || F.getMarket(z)) {
            case "A":
                I = F._ConStr[z + "_i"] || "--";
                var A = F._ConStr[z + "_zdp"] || "--",
                G = (F._ConStr["zjlxn_" + z], F._ConStr[z + "_php"] || "--");
                F._Sym_IndexAList.indexOf(z) > -1 ? F._ResObj[z] = F._DataObj.StockIndexObj(J, z, I, A, G) : F._Sym_BondAList.indexOf(z) > -1 ? F._ResObj[z] = F._DataObj.BondObj(J, z, F._ConStr, F._ResObj[z], F._config) : F._ResObj[z] = F._DataObj.StockObj(J, z, F._ConStr, F._ResObj[z], F._config),
                j();
                break;
            case "US":
                I = F._ConStr[z + "_i"] || "--";
                var D = F._ConStr._ixicStr;
                F._ResObj[z] = F._DataObj.USStockObj(J, z, I, D),
                j();
                break;
            case "HF":
                F._ResObj[z] = F._DataObj.FuturesObj(J, z),
                j();
                break;
            case "NF":
                F._Sym_GzNfList.indexOf(z) > -1 ? F._ResObj[z] = F._DataObj.GZfuturesObj(J, z, F._ConStr) : F._ResObj[z] = F._DataObj.NffuturesObj(J, z),
                j();
                break;
            case "DINIW":
                F._ResObj[z] = F._DataObj.DINIWObj(J, z),
                j();
                break;
            case "FX":
                F._ResObj[z] = F._DataObj.ForexObj(J, z),
                j();
                break;
            case "B":
                F._ResObj[z] = F._DataObj.GlobalObj(J, z),
                j();
                break;
            case "SB":
                F._ResObj[z] = F._DataObj.SBstockObj(J, z),
                j();
                break;
            case "HK":
            case "RTHK":
                I = F._ConStr[z + "_i"] || "--",
                F._ResObj[z] = F._DataObj.HkstockObj(J, z, I),
                j();
                break;
            case "BT":
                F._ResObj[z] = F._DataObj.BitcoinObj(J, z),
                j();
                break;
            case "FUND":
                var q = z.substr(z.indexOf("_") + 1),
                K = "fu_rate_" + q;
                F._ResObj[z] = F._DataObj.FUNDObj(J, z, q, F._ConStr[K]),
                j();
                break;
            case "ZNB":
                F._ResObj[z] = F._DataObj.ZNBGBObj(J, z),
                j()
            }
        },
        n.DataCenter.prototype._webmainPush = function() {
            if (!this._Sym_OtherNum) {
                var j = this;
                j._Socket = new IO.WebPush4(j._config.host, j._SymList.join(","),
                function(q) {
                    j._SocketKey ? j._initData(q) : j._Catch.push(q)
                },
                {
                    allowrepeat: j._config.allowrepeat,
                    ssl: j._config.ssl,
                    nxkeyvalue: j._config.nxkeyvalue
                })
            }
        },
        n.DataCenter.prototype._webotherPush = function(z, J, j, E) {
            function I(L) {
                for (var K in L) {
                    L.hasOwnProperty(K) && (A._ConStr[K] = L[K])
                }
            }
            for (var F = !0,
            A = this,
            G = E || "back",
            D = [], q = 0; q < z.length; q++) {
                D[q] = "back" === G ? z[q] + J: J + z[q]
            }
            A._SocketOther = new IO.WebPush4(A._config.host, D.join(","),
            function(K) {
                I(K),
                F && (F = !1, --A._Sym_OtherNum, j())
            },
            {
                allowrepeat: A._config.allowrepeat,
                ssl: A._config.ssl,
                nxkeyvalue: A._config.nxkeyvalue
            })
        },
        n.DataCenter.prototype._loadScript = function(j, F) {
            function D() {
                for (var J = 0; J < z.length; J++) {
                    G[z[J]] = S["hq_str_" + z[J]]
                }
                if (!--A) {
                    return E(G)
                }
            }
            var I = this,
            E = F,
            z = j.symbol.split(","),
            q = p(z),
            A = q.lenght,
            G = {};
            q.forEach(function(J) {
                C({
                    url: "//" + window.location.host + "/api/real.php?rn=" + g() + "&list=" + J.join(","),
                    success: function() {
                        "function" == typeof F && D()
                    }
                })
            })
        },
        n.DataCenter.prototype._loadPhp = function(j, q) {
            var z = q;
            C({
                url: "//apo51.cn/hq/api/openapi.php/StockV2Service.getStockDetail?",
                data: j,
                jsoncallback: !0,
                success: function(A) {
                    A.data && "function" == typeof q && z(A.data)
                }
            })
        },
        n.DataCenter.prototype.getMarket = function(j) {
            return 0 === j.indexOf("sh") || 0 == j.indexOf("sz") ? "A": 0 === j.indexOf("gb_") || 0 === j.indexOf("usr_") ? "US": 0 === j.indexOf("hf_") ? "HF": 0 === j.indexOf("nf_") ? "NF": j.indexOf("DINIW") > -1 || j.indexOf("XAGUSD") > -1 || j.indexOf("XAUUSD") > -1 || j.indexOf("EURI") > -1 ? "DINIW": 0 === j.indexOf("fx_s") ? "FX": 0 === j.indexOf("b_") ? "B": 0 === j.indexOf("znb_") ? "ZNB": 0 === j.indexOf("hk") ? "HK": 0 === j.indexOf("sb") ? "SB": 0 === j.indexOf("btc_") ? "BT": 0 === j.indexOf("f_") ? "FUND": 0 === j.indexOf("rt_") ? "RTHK": "NODATA"
        },
        n.DataCenter.prototype.hkRefresh = function() {
            var q = this,
            z = "",
            j = [];
            q._Sym_AllHKList.forEach(function(D) {
                var A = "rt_" + D;
                j.push(A)
            }),
            q._RestHknum = q._Sym_AllHKList.length,
            z = j.join(","),
            q._loadScript({
                symbol: z
            },
            function(A) {
                j.forEach(function(E, D) {
                    q._handle(q._Sym_AllHKList[D], A[E],
                    function() {--q._RestHknum,
                        q._success(A)
                    },
                    "HK")
                })
            })
        },
        n.DataCenter.prototype.closeSocket = function() {
            this._Socket && this._Socket.close(),
            this._SocketOther && this._SocketOther.close()
        },
        n.DataHref = {
            nfutures: "//apo51.cn/ft/hq/nf.php?symbol=",
            hfutures: "//apo51.cn/ft/hq/hf.php?symbol=",
            usstock: "//apo51.cn/us/hq/quotes.php?code=",
            forex: "//apo51.cn/fx/hq/quotes.php?code=",
            stock: "//quotes.api.cn/hs/company/quotes/view/",
            bond: "//apo51.cn/bd/hq/quotes.php?symbol=",
            sanban: "//apo51.cn/tm/hq/quotes.php?code=",
            hkstock: "",
            bitcoin: "//apo51.cn/fx/hq/quotes.php?code=",
            znb: "",
            fund: ""
        },
        n.DataHandle = function() {
            this.hqHref = n.DataHref,
            this._globalType = o("hq_userColor") || "riseRed",
            this._localType = localStorage.getItem("hq_riseColor") || "riseRed"
        },
        n.DataHandle.prototype.StockObj = function(ag, ac, aa, ba, V) {
            "notexist" === ag && (ag = new Array(33).join(",")),
            "notexist" === af && (ag = new Array(17).join(","));
            var ae, bb, ax, Z, ad, av, q, by, az, bt, be, bj, bn, bc, bq, ay, bh, bi, bB, bA, bs, bx, bw, z, bv, bC, bp, Y, bH, U, bk, W, bo, X, K, bg, bd, bm, bI, aw, a0, Q, R, T = aa[ac + "_i"] || "--",
            af = (aa[ac + "_zdp"], aa["zjlxn_" + ac] || "--"),
            E = aa[ac + "_php"] || "--",
            D = ag.split(","),
            bu = T.split(","),
            L = af.split(","),
            bK = E,
            bE = D && D[4],
            A = D && D[5];
            a0 = bu.splice(19),
            bm = D.concat(bu, L),
            Q = Math.max(bE, a0[0]) + "",
            R = Math.min(A, a0[1]) ? Math.min(A, a0[1]) + "": A + "",
            ae = 0 === parseFloat(bm[3]) ? parseFloat(bm[2]) : parseFloat(bm[3]);
            var bF = null;
            bF = D[1] || D[11] || D[21] || D[2],
            bI = bm[0].indexOf("ST") > -1 || bm[0].indexOf("st") > -1 ? f(bm[2], 0.05) : bm[0].indexOf("N") > -1 ? f(bm[2], 0.44) : f(bm[2]),
            Z = bI[0],
            ad = bI[1],
            av = bm[41] ? N(bm[8], bm[41], "turnover") : "--",
            q = bm[38] ? N(ae, bm[38], "pb") : "--",
            by = bm[46] ? N(ae, bm[46], "pe", bm[40]) : "--",
            bc = N(ae, bm[40], "total")[0],
            bn = bm[40] ? N(ae, bm[40], "total")[1] : "--",
            az = bm[46] ? N(ae, bm[46], "pe", bm[40]) : "--",
            bt = bm[35] ? k(ae, bm[35], "pej") : "--",
            bq = bm[41] ? N(ae, bm[41], "total")[1] : "--",
            bj = bm[50] ? N(ae, bm[50], "ps", bm[40]) : "--",
            ay = 2,
            aw = 100,
            bh = this.hqHref.stock + ac,
            bi = ab(bm[8], 2, aw, "\u624b"),
            bA = L && ab(L[7], 2, 1),
            bB = ab(bm[9], 2, 1),
            bx = t(bm[32], bm[48]),
            bs = "\u9000\u5e02" != bx ? O(bm[8], bm[39], bm[31]) : "--";
            var bz = c(ae, bm[2], ay);
            ax = bz[0],
            bb = bz[1];
            var j = c(ae, bm[2], 3),
            P = j[0],
            M = l(ae, bm[2], "A");
            bg = M[0],
            bd = M[1];
            var J = V.eachOrder ? m(ac, bm[8], ae, bm[31], aa, ba) : [[], ["--", "--"]];
            bw = J[0],
            z = J[1],
            be = V.eachOrder && "\u9000\u5e02" != bx ? w(bm) : "--";
            var bJ = parseFloat(bm[61]) + parseFloat(bm[63]),
            br = parseFloat(bm[60]) + parseFloat(bm[62]);
            bC = ab(br, 2, 1),
            bv = ab(bJ, 2, 1);
            var bL = x(br, bJ, bm[59]);
            bp = bL[0],
            Y = bL[1];
            var bf = x(bm[60], bm[61], bm[59]);
            bH = bf[0],
            U = bf[1];
            var F = x(bm[62], bm[63], bm[59]);
            bk = F[0],
            W = F[1];
            var bG = x(bm[64], bm[65], bm[59]);
            bo = bG[0],
            X = bG[1];
            var bD = x(bm[66], bm[67], bm[59]);
            _rs_net = bD[0],
            K = bD[1];
            var I = /(^sz15|^sz16|^sz18)\d+/,
            bl = /(^sh50|^sh51|^sh52)\d+/,
            G = bl.test(ac) || I.test(ac);
            return {
                name: bm[0] || "--",
                open: G && h(bm[1], 3) || h(bm[1], ay) || "--",
                prevclose: G && h(bm[2], 3) || h(bm[2], ay) || "--",
                price: G && h(ae, 3) || h(ae, ay) || "--",
                high: G && h(bm[4], 3) || h(bm[4], ay) || "--",
                low: G && h(bm[5], 3) || h(bm[5], ay) || "--",
                buy: G && h(bm[6], 3) || h(bm[6], ay) || "--",
                sell: G && h(bm[7], 3) || h(bm[7], ay) || "--",
                totalVolume: bi,
                totalVolume_i: bm[8],
                totalAmount: bB,
                totalAmountMF: bA,
                totalAmount_i: bm[9],
                buyNumArr: [bm[10], bm[12], bm[14], bm[16], bm[18]],
                buyPriceArr: [h(bm[11], ay), h(bm[13], ay), h(bm[15], ay), h(bm[17], ay), h(bm[19], ay)],
                sellNumArr: [bm[20], bm[22], bm[24], bm[26], bm[28]],
                sellPriceArr: [h(bm[21], ay), h(bm[23], ay), h(bm[25], ay), h(bm[27], ay), h(bm[29], ay)],
                date: bm[30] || "--",
                time: bm[31] || "--",
                status: bm[32],
                change: G && P || ax,
                percent: bb,
                type: bg,
                code: ac,
                upLimit: h(Z, ay) || "--",
                downLimit: h(ad, ay) || "--",
                amplitude: e(bm[4], bm[5], bm[2]),
                totalCapital: ab(10000 * bm[40], 2) || "--",
                cirCapital: ab(10000 * bm[41], 2) || "--",
                turnOver: av || "--",
                pb: q || "--",
                pe: by || "--",
                pej: bt || "--",
                ped: az || "--",
                fiveRate: be || "--",
                totalShare: bn || "--",
                totalShare_i: bc || "--",
                cirValue: bq || "--",
                lastFour: h(bm[36]) || "--",
                volumeRatio: bs,
                area: bd || "--",
                url: bh || "--",
                sname: bm[0] || "--",
                halt: bx,
                rp_in: bC,
                rp_out: bv,
                rp_net: bp,
                rp_net_rate: Y,
                rxl_in: ab(bm[60], 2, 1),
                rxl_in_raw: bm[60],
                rxl_out: ab(bm[61], 2, 1),
                rxl_out_raw: bm[61],
                rxl_net: bH,
                rxl_net_rate: U,
                rl_in: ab(bm[62], 2, 1),
                rl_in_raw: bm[62],
                rl_out: ab(bm[63], 2, 1),
                rl_out_raw: bm[63],
                rl_net: bk,
                rl_net_rate: W,
                rm_in: ab(bm[64], 2, 1),
                rm_in_raw: bm[64],
                rm_out: ab(bm[65], 2, 1),
                rm_out_raw: bm[65],
                rm_net: bo,
                rm_net_rate: X,
                rs_in: ab(bm[66], 2, 1),
                rs_in_raw: bm[66],
                rs_out: ab(bm[67], 2, 1),
                rs_out_raw: bm[67],
                rs_net: _rs_net,
                rs_net_rate: K,
                weighing: s(bK.weighing, 2, !0) || "--",
                changes_5m: s(bK.changes_5m, 2, !1, !0) || "--",
                aov_5m: s(bK.aov_5m) || "--",
                turnover_5m: s(bK.turnover_5m) || "--",
                changes_5d: s(bK.changes_5d, 2, !1, !0) || "--",
                aov_5d: s(bK.aov_5d) || "--",
                turnover_5d: s(bK.turnover_5d) || "--",
                changes_20d: s(bK.changes_20d, 2, !1, !0) || "--",
                aov_20d: s(bK.aov_20d) || "--",
                turnover_20d: s(bK.turnover_20d) || "--",
                mgsy: h(bK.mgsy, 4) || "--",
                perAssets: h(bm[38], 4) || "--",
                mgzbgjj: h(bK.mgzbgjj, 4) || "--",
                mgwfplr: h(bK.mgwfplr, 4) || "--",
                mgxjhl: h(bK.mgxjhl, 4) || "--",
                jzcsyl: s(bK.jzcsyl, 2, !0) || "--",
                zzcsyl: s(bK.zzcsyl, 2, !0) || "--",
                ps: bj || "--",
                report_date: bK.report_date || "--",
                zyywsr: ab(bK.zyywsr, 2, 1),
                zyywsrzzl: s(bK.zyywsrzzl, 2, !0),
                yylr: ab(bK.yylr, 2, 1),
                yylrzzl: s(bK.yylrzzl, 2, !0),
                zyywlr: ab(bK.zyywlr, 2, 1),
                zyywlrl: s(bK.zyywlrl, 2, !0),
                netProfit: ab(bm[51], 2, 1, "\u4ebf") || "--",
                jlrzzl: s(bK.jlrzzl, 2, !0),
                zyywlrzzl: s(bK.zyywlrzzl, 2, !0),
                mll: s(bK.mll, 2, !0),
                zczj: ab(bK.zczj, 2, 1),
                fzhj: ab(bK.fzhj, 2, 1),
                syzqyhj: ab(bK.syzqyhj, 2, 1),
                jzzzzl: s(bK.jzzzzl, 2, !0) || "--",
                zcfzl: s(bK.zcfzl, 2, !0) || "--",
                jyxjlje: ab(bK.jyxjlje, 2, 1),
                tzxjlje: ab(bK.tzxjlje, 2, 1),
                czxjlje: ab(bK.czxjlje, 2, 1),
                xjllbl: s(bK.xjllbl, 2, !0),
                hqMarket: "A",
                tradeItems: bw,
                tradeVolsBuy: "\u9000\u5e02" !== bx ? ab(z[0], 0, 100, "\u624b", !0) : "--",
                tradeVolsSell: "\u9000\u5e02" !== bx ? ab(z[1], 0, 100, "\u624b", !0) : "--",
                max52: Q,
                min52: R,
                newprice: u(bF, 2)
            }
        },
        n.DataHandle.prototype.StockIndexObj = function(E, X, q, M, W) {
            "notexist" === E && (E = new Array(33).join(","));
            var Y, D, P, I, j, K, R, A, F, L, aa, J, z, U = E.split(","),
            T = q.split(","),
            Z = M.split(","),
            G = W || {};
            T.splice(19),
            J = U.concat(T, Z),
            P = J[38] ? N(J[3], J[38], "pb") : "--",
            I = J[40] ? N(J[3], J[40], "total") : "--",
            j = J[41] ? N(J[3], J[41], "total") : "--",
            z = X.indexOf("sh") > -1 ? 1 : 100,
            K = 2,
            R = this.hqHref.stock + X,
            A = ab(J[8], 2, z, "\u624b"),
            F = ab(J[9], 2, 1);
            var V = c(J[3], J[2], K);
            D = V[0],
            Y = V[1];
            var Q = l(J[3], J[2], "A");
            return L = Q[0],
            aa = Q[1],
            {
                name: J[0] || "--",
                open: h(J[1], K) || "--",
                prevclose: h(J[2], K) || "--",
                price: h(J[3], K) || "--",
                high: h(J[4], K) || "--",
                low: h(J[5], K) || "--",
                buy: h(J[6], K) || "--",
                sell: h(J[7], K) || "--",
                totalVolume: A,
                totalAmount: F,
                buyNumArr: [J[10], J[12], J[14], J[16], J[18]],
                buyPriceArr: [h(J[11], K), h(J[13], K), h(J[15], K), h(J[17], K), h(J[19], K)],
                sellNumArr: [J[20], J[22], J[24], J[26], J[28]],
                sellPriceArr: [h(J[21], K), h(J[23], K), h(J[25], K), h(J[27], K), h(J[29], K)],
                date: J[30],
                time: J[31],
                status: J[32],
                change: D,
                percent: Y,
                type: L,
                code: X,
                upLimit: "--",
                downLimit: "--",
                amplitude: e(J[4], J[5], J[2]),
                perAssets: h(J[38], K) || "--",
                totalCapital: h(J[40], K) || "--",
                cirCapital: h(J[41], K) || "--",
                pb: P,
                totalShare: I,
                cirValue: j,
                lastFour: h(J[36], K),
                area: aa,
                url: R,
                sname: J[0] || "--",
                riseStockNum: J[52] || "--",
                fallStockNum: J[53] || "--",
                equalStockNum: J[54] || "--",
                changes_5m: s(G.changes_5m, 2, !1, !0) || "--",
                aov_5m: s(G.aov_5m) || "--",
                turnover_5m: s(G.turnover_5m) || "--",
                changes_5d: s(G.changes_5d, 2, !1, !0) || "--",
                aov_5d: s(G.aov_5d) || "--",
                turnover_5d: s(G.turnover_5d) || "--",
                changes_20d: s(G.changes_20d, 2, !1, !0) || "--",
                aov_20d: s(G.aov_20d) || "--",
                turnover_20d: s(G.turnover_20d) || "--",
                hqMarket: "A"
            }
        },
        n.DataHandle.prototype.BondObj = function(P, E, I, j, A) {
            "notexist" === P && (P = new Array(33).join(","));
            var K, z, L, q, R, F, V, D, T, J, Q, M = P.split(",");
            L = /^(sh204)\d+/.test(E) || /^(sz1318)\d+/.test(E) ? 3 : 2,
            q = 10,
            F = ab(M[8], 2, q, "\u624b"),
            V = ab(M[9], 2, 1),
            R = this.hqHref.bond + E;
            var W = c(M[3], M[2], L);
            z = W[0],
            K = W[1];
            var U = l(M[3], M[2], "A");
            D = U[0],
            T = U[1];
            var G = A.eachOrder ? m(E, M[8], M[3], M[31], I, j) : [[], ["--", "--"]];
            return J = G[0],
            Q = G[1],
            {
                name: M[0] || "--",
                open: h(M[1], L) || "--",
                prevclose: h(M[2], L) || "--",
                price: h(M[3], L) || "--",
                high: h(M[4], L) || "--",
                low: h(M[5], L) || "--",
                buy: h(M[6], L) || "--",
                sell: h(M[7], L) || "--",
                totalVolume: F,
                totalVolume_i: M[8],
                totalAmount: V,
                totalAmount_i: M[9],
                buyNumArr: [M[10], M[12], M[14], M[16], M[18]],
                buyPriceArr: [h(M[11], L), h(M[13], L), h(M[15], L), h(M[17], L), h(M[19], L)],
                sellNumArr: [M[20], M[22], M[24], M[26], M[28]],
                sellPriceArr: [h(M[21], L), h(M[23], L), h(M[25], L), h(M[27], L), h(M[29], L)],
                date: M[30],
                time: M[31],
                status: M[32],
                change: z,
                percent: K,
                type: D,
                code: E,
                amplitude: e(M[4], M[5], M[2]),
                area: T,
                url: R,
                sname: M[0] || "--",
                tradeItems: J,
                tradeVolsBuy: ab(Q[0], 0, 100, "\u624b", !0),
                tradeVolsSell: ab(Q[1], 0, 100, "\u624b", !0),
                hqMarket: "BD"
            }
        },
        n.DataHandle.prototype.USStockObj = function(K, q, A, R) {
            "notexist" === K && (K = new Array(28).join(","));
            var j, M, F, J, P, Q, E, L, G = K.split(","),
            Y = A.split(","),
            D = R && R.split(","),
            X = c(G[1], G[26]);
            F = X[0],
            M = X[1],
            J = parseFloat(G[12]) ? ab(G[12], 0) : "--",
            P = ab(G[10], 0);
            var W = l(G[1], G[26]),
            V = W[0];
            W[1];
            E = r(G[10], G[19]) || "--",
            L = parseFloat(G[19]) ? ab(G[19]) : "--",
            Q = i(G[24]),
            j = q.indexOf("gb_") > -1 ? q.substr(3).replace(/\$/g, ".") : q.substr(4).replace(/\$/g, ".");
            var U, T = G[24],
            z = G[25],
            I = (new Date).getFullYear();
            return /pm/i.test(T) ? (T = T.replace(/[AP]M\s\w{3,}/, ""), T = new Date(I + T), T.setHours(T.getHours() + 12)) : (T = T.replace(/[AP]M\s\w{3,}/, ""), T = new Date(I + T)),
            /pm/i.test(z) ? (z = z.replace(/[AP]M\s\w{3,}/, ""), z = new Date(I + z), z.setHours(z.getHours() + 12)) : (z = z.replace(/[AP]M\s\w{3,}/, ""), z = new Date(I + z)),
            U = T > z ? G[21] : G[1],
            {
                name: G[0] || "--",
                price: h(G[1]) || "--",
                newprice: u(U, 2),
                percent: M,
                time: G[3].substr(11),
                change: F,
                open: h(G[5]) || "--",
                high: h(G[6]) || "--",
                low: h(G[7]) || "--",
                high52: h(G[8]) || "--",
                low52: h(G[9]) || "--",
                totalVolume: P,
                balanceVolume: G[12],
                totalShare: J,
                perProfit: h(G[13]) || "--",
                pe: h(G[14]) || "--",
                fpe: G[15],
                beta: h(G[16]) || "--",
                dividend: h(G[17]) || "--",
                returnRate: G[18],
                totalCapital: L,
                turnOver: E,
                instown: G[20],
                extPrice: h(G[21]) || "--",
                extPercent: s(G[22], 2, !0, !0) || "--",
                extChange: h(G[23]) || "--",
                extTime: G[24],
                regTime: G[25],
                prevclose: h(G[26]) || "--",
                extVolume: G[27],
                code: j,
                type: V,
                date: G[3].substr(5, 5),
                url: this.hqHref.usstock + j,
                sname: G[0] || "--",
                extType: Q,
                extColor: b(G[23]),
                regType: D && B(D[25]),
                hqMarket: "US",
                usMarket: d(Y[0]),
                totalAmount: "--"
            }
        },
        n.DataHandle.prototype.FuturesObj = function(F, q) {
            "notexist" === F && (F = new Array(14).join(","));
            var A, G, j, D, z, E, I = F.split(",");
            return D = q.indexOf("EC") > -1 || q.indexOf("BP") > -1 || q.indexOf("JY") > -1 || q.indexOf("CD") > -1 || q.indexOf("SF") > -1 || q.indexOf("DXF") > -1 ? 4 : Number(I[0]) < 100 ? 3 : 2,
            G = c(I[0], I[7], D)[0],
            A = c(I[0], I[7])[1],
            z = l(I[0], I[7], "HF")[0],
            E = l(I[0], I[7], "HF")[1],
            j = I[12].substr(5),
            {
                price: h(I[0], D) || "--",
                change: G,
                percent: A,
                buy: h(I[2], D) || "--",
                sell: h(I[3], D) || "--",
                high: h(I[4], D) || "--",
                low: h(I[5], D) || "--",
                time: I[6] || "--",
                prevclose: h(I[7], D) || "--",
                open: h(I[8], D) || "--",
                capital: parseInt(I[9]) || "--",
                buyVolume: parseInt(I[10]) || "--",
                sellVolume: parseInt(I[11]) || "--",
                date: j || "--",
                name: I[13] || "--",
                type: z,
                amplitude: e(I[4], I[5], I[7]),
                settlement: "--",
                totalVolume: "--",
                code: q.substr(3),
                area: E,
                url: this.hqHref.hfutures + q.substr(3),
                hqMarket: "FUTURES"
            }
        },
        n.DataHandle.prototype.NffuturesObj = function(D, F) {
            "notexist" === D && (D = new Array(28).join(","));
            var q, j, E, z, G, A = D.split(",");
            return j = c(A[8], A[10])[0],
            q = c(A[8], A[10])[1],
            z = l(A[8], A[10], "NF")[0],
            G = l(A[8], A[10], "NF")[1],
            E = A[1].substr(0, 2) + ":" + A[1].substr(2, 2) + ":" + A[1].substr(4, 2),
            {
                name: A[0] || "--",
                time: E.toLocaleString() || "--",
                open: h(A[2]) || "--",
                high: h(A[3]) || "--",
                low: h(A[4]) || "--",
                buy: h(A[6]) || "--",
                sell: h(A[7]) || "--",
                price: h(A[8]) || "--",
                dsettlement: h(A[9]) || "--",
                prevclose: h(A[10]) || "--",
                buyVolume: parseInt(A[11]) || "--",
                sellVolume: parseInt(A[12]) || "--",
                capital: parseInt(A[13]) || "--",
                totalVolume: parseInt(A[14]) || "--",
                exchange: A[15] || "--",
                amplitude: e(A[3], A[4], A[10]),
                variety: A[16] || "--",
                date: A[17].substr(5) || "--",
                isHot: A[18],
                high5: h(A[19]) || "--",
                low5: h(A[20]) || "--",
                high10: h(A[21]) || "--",
                low10: h(A[22]) || "--",
                high20: h(A[23]) || "--",
                low20: h(A[24]) || "--",
                high55: h(A[25]) || "--",
                low55: h(A[26]) || "--",
                weightedAverage: h(A[27]) || "--",
                change: j,
                percent: q,
                type: z,
                code: F.substr(3),
                area: G,
                url: this.hqHref.nfutures + F.substr(3),
                hqMarket: "FUTURES",
                turnOver: "--"
            }
        },
        n.DataHandle.prototype.GZfuturesObj = function(j, M, R) {
            "notexist" === j && (j = new Array(28).join(","));
            var G, L, P, F, Q, J, D, I, E, K = j.split(","),
            q = y(M, R);
            L = c(K[3], K[14])[0],
            G = c(K[3], K[14])[1];
            var z = q ? c(q[3], q[2]) : "";
            z && z[0],
            P = z ? z[1] : "--",
            D = l(K[3], K[14], "GZ")[0],
            I = l(K[3], K[14], "GZ")[1];
            var A = q ? l(q[3], q[2], "A") : "";
            return _typeCon = A ? A[0] : "--",
            _areaCon = A ? A[1] : "--",
            F = q ? (parseFloat(K[3]) - parseFloat(q[3])).toFixed(2) : "--",
            Q = q ? (100 * (parseFloat(K[3]) - parseFloat(q[3])) / parseFloat(q[3])).toFixed(2) + "%": "--",
            J = q ? F > 0 ? "riseRed" === this._localType ? "red": "green": F < 0 ? "riseRed" === this._localType ? "green": "red": "equal": "equal",
            E = K[49],
            {
                name: E,
                open: h(K[0]) || "--",
                high: h(K[1]) || "--",
                low: h(K[2]) || "--",
                price: h(K[3]) || "--",
                totalVolume: ab(K[4]) || "--",
                totalAmount: ab(K[5]) || "--",
                capital: parseInt(K[6]) || "--",
                close: h(K[7]) || "--",
                settlement: h(K[8]) || "--",
                upLimit: h(K[9]) || "--",
                downLimit: h(K[10]) || "--",
                yvirtual: K[11],
                virtual: K[12],
                prevclose: h(K[14]) || "--",
                prevcapital: parseInt(K[15]) || "--",
                declarebuy: [h(K[16]), h(K[17]), h(K[18]), h(K[19]), h(K[20]), h(K[21]), h(K[22]), h(K[23]), h(K[24]), h(K[25])],
                declaresell: [h(K[26]), h(K[27]), h(K[28]), h(K[29]), h(K[30]), h(K[31]), h(K[32]), h(K[33]), h(K[34]), h(K[35])],
                date: K[36].substr(5) || "--",
                time: K[37] || "--",
                timems: parseInt(K[38]) || "--",
                type: D,
                change: L,
                percent: G,
                amplitude: e(K[1], K[2], K[14]),
                code: M.substr(3),
                buyVolume: "--",
                sellVolume: "--",
                dsettlement: "--",
                area: I,
                priceIndex: q ? h(q[3]) : "--",
                percentIndex: P,
                typeIndex: _typeCon,
                delta: F,
                deltaRatio: Q,
                deltaType: J,
                url: this.hqHref.nfutures + M.substr(3),
                hqMarket: "FUTURES",
                turnOver: "--"
            }
        },
        n.DataHandle.prototype.DINIWObj = function(F, q) {
            "notexist" === F && (F = new Array(11).join(","));
            var A, G, j, D, z = F.split(","),
            E = c(z[8], z[3]);
            G = E[0],
            A = E[1];
            var I = l(z[8], z[3]);
            return j = I[0],
            D = I[1],
            {
                time: z[0] || "--",
                buy: h(z[1]) || "--",
                sell: h(z[2]) || "--",
                prevclose: h(z[3]) || "--",
                spread: z[4] || "--",
                open: h(z[5]) || "--",
                high: h(z[6]) || "--",
                low: h(z[7]) || "--",
                price: h(z[8]) || "--",
                name: z[9] || "--",
                date: z[10] || "--",
                change: G,
                percent: A,
                type: j,
                amplitude: e(z[6], z[7], z[3]),
                area: D,
                code: q,
                url: this.hqHref.forex + q,
                myName: z[9] || "--"
            }
        },
        n.DataHandle.prototype.ForexObj = function(A, z) {
            "notexist" === A && (A = new Array(18).join(","));
            var L, G, q, M, J, j, I = 4,
            E = A.split(",");
            I = Number(E[8]) < 10 ? 4 : Number(E[8]) < 100 ? 3 : 2;
            var K = c(E[8], E[3], 4);
            G = K[0],
            L = K[1];
            var F = l(E[8], E[3], "FX");
            q = F[0],
            M = F[1];
            var D = E[9].indexOf("\u5151") > -1 ? E[9].replace("\u5373\u671f\u6c47\u7387", "").split("\u5151") : ["--", "--"];
            return J = D[1],
            _subCode = z.substr(7).toUpperCase(),
            j = H(D[0]) + "-" + H(D[1]),
            {
                time: E[0] || "--",
                buy: h(E[1], I) || "--",
                sell: h(E[2], I) || "--",
                prevclose: h(E[3], I) || "--",
                spread: E[4] || "--",
                open: h(E[5], I) || "--",
                high: h(E[6], I) || "--",
                low: h(E[7], I) || "--",
                price: h(E[8], I) || "--",
                name: E[9] || "--",
                percent: L,
                change: G,
                amplitude: e(E[6], E[7], E[3], I),
                bank: E[13] || "--",
                high52: h(E[14], I) || "--",
                low52: h(E[15], I) || "--",
                trend: h(E[16], I) || "--",
                date: E[17] || "--",
                type: q,
                area: M,
                url: this.hqHref.forex + z.substr(4).toUpperCase(),
                code: z.substr(4).toUpperCase(),
                subName: J,
                subCode: _subCode,
                myName: j,
                hqMarket: "FOREX",
                turnOver: "--",
                totalVolume: "--",
                totalAmount: "--"
            }
        },
        n.DataHandle.prototype.GlobalObj = function(z, D) {
            "notexist" === z && (z = new Array(13).join(","));
            var j, q, A = z.split(",");
            return _precent = parseFloat(A[3]) > 0 ? "+" + A[3] + "%": A[3] + "%",
            j = parseFloat(A[2]) > 0 ? "+" + A[2] : A[2],
            q = parseFloat(A[3]) > 0 ? "riseRed" === this._localType ? "red": "green": parseFloat(A[3]) < 0 ? "riseRed" === this._localType ? "green": "red": "equal",
            {
                name: a(A[0]) || "--",
                price: h(A[1]) || "--",
                percent: _precent,
                change: j,
                date: A[4],
                time: A[5],
                type: q,
                url: "",
                sname: a(A[0]),
                code: D.substr(2)
            }
        },
        n.DataHandle.prototype.ZNBGBObj = function(z, E) {
            var j, q, D, F, A = z.split(",");
            return j = parseFloat(A[3]) > 0 ? "+" + A[3] + "%": A[3] + "%",
            q = parseFloat(A[2]) > 0 ? "+" + A[2] : A[2],
            D = parseFloat(A[3]) > 0 ? "riseRed" === this._globalType ? "red": "green": parseFloat(A[3]) < 0 ? "riseRed" === this._globalType ? "green": "red": "equal",
            F = E.substr(4),
            {
                name: a(A[0]) || "--",
                price: h(A[1]) || "--",
                open: h(A[8]) || "--",
                prevclose: h(A[9]) || "--",
                high: h(A[10]) || "--",
                low: h(A[11]) || "--",
                symbol: E,
                code: F,
                url: this.hqHref.znb + F,
                percent: j,
                change: q,
                type: D,
                date: A[6],
                time: A[7],
                hqMarket: "ZNB"
            }
        },
        n.DataHandle.prototype.HkstockObj = function(Q, L, I) {
            "notexist" === Q && (Q = new Array(19).join(",")),
            I || (I = new Array(1).join(","));
            var F, K, A, q, M, z = Q.split(","),
            G = I.split(","),
            j = null;
            j = z[2] || z[9] || z[10] || z[3];
            var P = G && G[9],
            D = P * z[6],
            E = G && G[7],
            J = E * z[6],
            T = c(z[6], z[3], 3);
            K = T[0],
            F = T[1],
            M = l(z[6], z[3])[0],
            A = ab(z[11], 3),
            q = ab(z[12], 3);
            var R = this.hqHref.hkstock + L.slice(2);
            return {
                ename: z[0] || "--",
                name: v(G[19]) || v(z[1]) || v(G[15]) || "--",
                open: h(z[2], 3) || "--",
                prevclose: h(z[3], 3) || "--",
                high: h(z[4], 3) || "--",
                low: h(z[5], 3) || "--",
                price: h(z[6], 3) || "--",
                change: K,
                percent: F,
                sell: h(z[9], 3) || "--",
                buy: h(z[10], 3) || "--",
                totalAmount: A,
                totalVolume: q,
                pe: h(z[13], 3) || "--",
                returnRate: h(z[14], 3) + "%" || "--",
                high52: h(z[15], 3) || "--",
                low52: h(z[16], 3) || "--",
                high52AndLow52: (h(z[16], 3) || "--") + "~" + (h(z[15], 3) || "--"),
                date: z[17] || "--",
                time: z[18] || "--",
                url: R,
                type: M,
                code: 0 === L.indexOf("rt_") ? L.slice(5) : L.slice(2),
                sname: v(z[1]) || "--",
                hqMarket: "HK",
                turnOver: "--",
                totalCapital: J || null,
                totalCapitalAH: D || null,
                totalCapital_show: J && (1e-8 * J).toFixed(3) + "\u4ebf" || "--",
                totalCapitalAH_show: D && (1e-8 * D).toFixed(3) + "\u4ebf" || "--",
                equity_hk: E && (1e-8 * E).toFixed(3) + "\u4ebf" || "--",
                equity_all: P && (1e-8 * P).toFixed(3) + "\u4ebf" || "--",
                newprice: u(j, 2)
            }
        },
        n.DataHandle.prototype.SBstockObj = function(E, j) {
            "notexist" === E && (E = new Array(39).join(","));
            var z, G, J, A, q, D = E.split(","),
            I = c(D[3], D[2]);
            G = I[0],
            z = I[1];
            var F = l(D[3], D[2], "SB");
            return J = F[0],
            _area = F[1],
            A = ab(D[8], 0),
            q = ab(D[9], 0),
            {
                name: D[0] || "--",
                open: h(D[1]) || "--",
                prevclose: h(D[2]) || "--",
                price: h(D[3]) || "--",
                high: h(D[4]) || "--",
                low: h(D[5]) || "--",
                buy: h(D[6]) || "--",
                sell: h(D[7]) || "--",
                totalVolume: A,
                totalAmount: q,
                buyNumArr: [D[10], D[12], D[14], D[16], D[18]],
                buyPriceArr: [h(D[11]), h(D[13]), h(D[15]), h(D[17]), h(D[19])],
                sellNumArr: [D[20], D[22], D[24], D[26], D[28]],
                sellPriceArr: [h(D[21]), h(D[23]), h(D[25]), h(D[27]), h(D[29])],
                date: D[30],
                time: D[31],
                status: D[32],
                change: G,
                percent: z,
                type: J,
                url: this.hqHref.sanban + j,
                code: j,
                amplitude: e(D[4], D[5], D[2]),
                hqMarket: "SB"
            }
        },
        n.DataHandle.prototype.BitcoinObj = function(F, q) {
            var A, G, j, D, z, E = F.split(",");
            D = function(J) {
                return J.substr(4)
            } (q);
            var I = c(E[8], E[3]);
            return G = I[0],
            A = I[1],
            j = l(E[8], E[3], "BT")[0],
            z = ab(E[10], 0),
            {
                date: E[11] || "--",
                time: E[0] || "--",
                buy: h(E[1]) || "--",
                sell: h(E[2]) || "--",
                prevclose: h(E[3]) || "--",
                spread: E[4] || "--",
                open: h(E[5]) || "--",
                openisprevclose: h(E[3]) || "--",
                high: h(E[6]) || "--",
                low: h(E[7]) || "--",
                price: h(E[8]) || "--",
                name: E[9] || "--",
                totalVolume: z,
                change: G,
                percent: A,
                type: j,
                symbol: q,
                code: D,
                url: this.hqHref.bitcoin + D,
                amplitude: e(E[6], E[7], E[3])
            }
        },
        n.DataHandle.prototype.FUNDObj = function(z, G, K, E) {
            var j = z.split(","),
            A = [],
            I = function(P, M) {
                return P === M ? "": P - M > 0 ? "+": ""
            },
            D = function(P, M) {
                return isNaN( + P) ? "--": (M = M || 2, ( + P).toFixed(M) + "%")
            },
            L = j[4],
            J = j[1] && parseFloat(j[1]) || "--",
            q = j[3] && parseFloat(j[3]) || "--";
            if ("--" !== J && "--" !== q) {
                var F = parseFloat(J - q).toFixed(3)
            } else {
                var F = "--"
            }
            return A = E && E.split(",") || null,
            {
                name: j[0],
                code: K,
                date: L,
                url: this.hqHref.fund + K,
                price: h(J, 4),
                prevclose: q,
                percent: function(M, P) {
                    var Q = I(M, P);
                    if (!isNaN(parseFloat(M)) && !isNaN(parseFloat(P))) {
                        return Q + (100 * (M / P - 1)).toFixed(2) + "%"
                    }
                } (j[1], j[3]),
                change: F,
                turnOver: "--",
                totalVolume: "--",
                totalAmount: "--",
                accumulate: A && A[2] || "--",
                trimester: A && D(A[5]) || "--",
                fullYear: A && D(A[7]) || "--",
                triennium: A && D(A[8]) || "--",
                establishment: A && D(A[10]) || "--",
                hqMarket: "FUND"
            }
        },
        S.HQ = n
    }
} (window),
function() {
    var b = window.HQ;
    b.DataBoxCfg = {
        VERSION: "2.0"
    },
    b.DataBoxCfg.A = [{
        name: "\u6210\u4ea4\u91cf",
        value: "totalVolume"
    },
    {
        name: "\u5e02\u76c8\u7387TTM",
        value: "pe"
    },
    {
        name: "\u6d41\u901a\u5e02\u503c",
        value: "cirValue"
    },
    {
        name: "\u603b\u5e02\u503c",
        value: "totalShare"
    },
    {
        name: "\u6628\u6536\u4ef7",
        value: "prevclose"
    },
    {
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    },
    {
        name: "\u6da8\u505c\u4ef7",
        value: "upLimit"
    },
    {
        name: "\u8dcc\u505c\u4ef7",
        value: "downLimit"
    },
    {
        name: "\u59d4\u6bd4",
        value: "fiveRate"
    },
    {
        name: "\u91cf\u6bd4",
        value: "volumeRatio"
    },
    {
        name: "\u4e70\u76d8",
        value: "tradeVolsBuy"
    },
    {
        name: "\u5356\u76d8",
        value: "tradeVolsSell"
    },
    {
        name: "\u6362\u624b\u7387",
        value: "turnOver"
    },
    {
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: "\u6210\u4ea4\u989d",
        value: "totalAmount"
    },
    {
        name: "\u5e02\u51c0\u7387",
        value: "pb"
    },
    {
        name: "\u5e02\u76c8\u7387(\u9759)",
        value: "pej"
    },
    {
        name: "\u5e02\u76c8\u7387TTM",
        value: "ped"
    },
    {
        name: "\u6d41\u901a\u80a1\u672c",
        value: "cirCapital"
    },
    {
        name: "\u603b\u80a1\u672c",
        value: "totalCapital"
    },
    {
        name: "52\u5468\u6700\u9ad8",
        value: "max52"
    },
    {
        name: "52\u5468\u6700\u4f4e",
        value: "min52"
    }],
    b.DataBoxCfg.AI = [{
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: "\u6da8\u8dcc\u5bb6",
        value: "zdj"
    },
    {
        name: "\u6210\u4ea4\u91cf",
        value: "totalVolume"
    },
    {
        name: "\u6210\u4ea4\u989d",
        value: "totalAmount"
    },
    {
        name: "\u6628\u6536\u4ef7",
        value: "prevclose"
    },
    {
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    }],
    b.DataBoxCfg.US = [{
        name: "\u6210\u4ea4\u91cf",
        value: "totalVolume"
    },
    {
        name: "\u5e02\u503c",
        value: "totalShare"
    },
    {
        name: "\u5e02\u76c8\u7387",
        value: "pe"
    },
    {
        name: "\u6362\u624b\u7387",
        value: "turnOver"
    },
    {
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6628\u6536\u4ef7",
        value: "prevclose"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    },
    {
        name: "\u603b\u80a1\u672c",
        value: "totalCapital"
    },
    {
        name: "\u6bcf\u80a1\u6536\u76ca",
        value: "perProfit"
    },
    {
        name: "\u8d1d\u5854\u7cfb\u6570",
        value: "beta"
    },
    {
        name: "\u80a1\u606f",
        value: "dividend"
    },
    {
        name: "52\u5468\u6700\u9ad8",
        value: "high52"
    },
    {
        name: "52\u5468\u6700\u4f4e",
        value: "low52"
    }],
    b.DataBoxCfg.WH = [{
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: " \u6301\u4ed3\u91cf(\u624b)",
        value: "capital"
    },
    {
        name: "\u6628\u7ed3\u7b97",
        value: "prevclose"
    },
    {
        name: "\u5f00\u76d8\u4ef7",
        value: "open"
    },
    {
        name: "\u6700\u9ad8\u4ef7",
        value: "high"
    },
    {
        name: "\u6700\u4f4e\u4ef7",
        value: "low"
    },
    {
        name: "\u4e70\u4e00\u4ef7",
        value: "buy"
    },
    {
        name: "\u5356\u4e00\u4ef7",
        value: "sell"
    }],
    b.DataBoxCfg.HF = [{
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: " \u6301\u4ed3\u91cf(\u624b)",
        value: "capital"
    },
    {
        name: "\u6628\u7ed3\u7b97",
        value: "prevclose"
    },
    {
        name: "\u5f00\u76d8\u4ef7",
        value: "open"
    },
    {
        name: "\u6700\u9ad8\u4ef7",
        value: "high"
    },
    {
        name: "\u6700\u4f4e\u4ef7",
        value: "low"
    },
    {
        name: "\u4e70\u4e00\u4ef7",
        value: "buy"
    },
    {
        name: "\u5356\u4e00\u4ef7",
        value: "sell"
    }],
    b.DataBoxCfg.NF = [{
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: "\u52a8\u7ed3\u7b97",
        value: "dsettlement"
    },
    {
        name: "\u6210\u4ea4\u91cf(\u624b)",
        value: "totalVolume"
    },
    {
        name: "\u6301\u4ed3\u91cf(\u624b)",
        value: "capital"
    },
    {
        name: "\u6628\u7ed3\u7b97",
        value: "prevclose"
    },
    {
        name: "\u5f00\u76d8\u4ef7",
        value: "open"
    },
    {
        name: "\u6700\u9ad8\u4ef7",
        value: "high"
    },
    {
        name: "\u6700\u4f4e\u4ef7",
        value: "low"
    },
    {
        name: "\u4e70\u4e00\u4ef7",
        value: "buy"
    },
    {
        name: "\u5356\u4e00\u4ef7",
        value: "sell"
    },
    {
        name: "\u4e70\u91cf",
        value: "buyVolume"
    },
    {
        name: "\u5356\u91cf",
        value: "sellVolume"
    }],
    b.DataBoxCfg.GZ = [{
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: "\u6210\u4ea4\u91cf(\u624b)",
        value: "totalVolume"
    },
    {
        name: "\u6301\u4ed3\u91cf(\u624b)",
        value: "capital"
    },
    {
        name: "\u6628\u4ed3\u91cf(\u624b)",
        value: "prevcapital"
    },
    {
        name: "\u6628\u7ed3\u7b97",
        value: "prevclose"
    },
    {
        name: "\u5f00\u76d8\u4ef7",
        value: "open"
    },
    {
        name: "\u6700\u9ad8\u4ef7",
        value: "high"
    },
    {
        name: "\u6700\u4f4e\u4ef7",
        value: "low"
    },
    {
        name: "\u6da8\u505c\u4ef7",
        value: "upLimit"
    },
    {
        name: "\u8dcc\u505c\u4ef7",
        value: "downLimit"
    }],
    b.DataBoxCfg.FX = [{
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6628\u6536",
        value: "prevclose"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    },
    {
        name: "\u4e70\u5165\u4ef7",
        value: "buy"
    },
    {
        name: "\u5356\u51fa\u4ef7",
        value: "sell"
    },
    {
        name: "\u632f\u5e45",
        value: "amplitude"
    }],
    b.DataBoxCfg.DINIW = [{
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6628\u6536",
        value: "prevclose"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    },
    {
        name: "\u4e70\u5165\u4ef7",
        value: "buy"
    },
    {
        name: "\u5356\u51fa\u4ef7",
        value: "sell"
    },
    {
        name: "\u632f\u5e45",
        value: "amplitude"
    }],
    b.DataBoxCfg.BD = [{
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6628\u6536",
        value: "prevclose"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    },
    {
        name: "\u4e70\u5165",
        value: "buy"
    },
    {
        name: "\u5356\u51fa",
        value: "sell"
    },
    {
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: "\u6210\u4ea4\u91cf",
        value: "totalVolume"
    },
    {
        name: "\u6210\u4ea4\u989d",
        value: "totalAmount"
    }],
    b.DataBoxCfg.BT = [{
        name: "\u4e70\u5165\u4ef7",
        value: "buy"
    },
    {
        name: "\u5356\u51fa\u4ef7",
        value: "sell"
    },
    {
        name: "\u6700\u9ad8\u4ef7",
        value: "high"
    },
    {
        name: "\u6700\u4f4e\u4ef7",
        value: "low"
    },
    {
        name: "\u632f\u5e45",
        value: "amplitude"
    },
    {
        name: "\u6210\u4ea4\u91cf",
        value: "totalVolume"
    },
    {
        name: "\u5f00\u76d8\u4ef7",
        value: "openisprevclose"
    },
    {
        name: "\u6628\u6536\u4ef7",
        value: "prevclose"
    },
    {
        name: "\u70b9\u5dee",
        value: "spread"
    }],
    b.DataBoxCfg.ZNB = [{
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6628\u6536",
        value: "prevclose"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    }],
    b.DataBoxCfg.HK = [{
        name: "\u6628\u6536",
        value: "prevclose"
    },
    {
        name: "\u4eca\u5f00",
        value: "open"
    },
    {
        name: "\u6700\u9ad8",
        value: "high"
    },
    {
        name: "\u6700\u4f4e",
        value: "low"
    },
    {
        name: "\u5e02\u76c8\u7387",
        value: "pe"
    },
    {
        name: "\u6536\u76ca\u7387",
        value: "returnRate"
    },
    {
        name: "\u6e2f\u80a1\u80a1\u672c",
        value: "equity_hk"
    },
    {
        name: "\u603b\u80a1\u672c",
        value: "equity_all"
    },
    {
        name: "\u6e2f\u80a1\u5e02\u503c",
        value: "totalCapital_show"
    },
    {
        name: "\u603b\u5e02\u503c",
        value: "totalCapitalAH_show"
    },
    {
        name: "\u6210\u4ea4\u989d",
        value: "totalAmount"
    },
    {
        name: "\u6210\u4ea4\u91cf",
        value: "totalVolume"
    },
    {
        name: "52\u5468",
        value: "high52AndLow52"
    }]
} ();
var _createClass = function() {
    function b(g, h) {
        for (var a = 0; a < h.length; a++) {
            var e = h[a];
            e.enumerable = e.enumerable || !1,
            e.configurable = !0,
            "value" in e && (e.writable = !0),
            Object.defineProperty(g, e.key, e)
        }
    }
    return function(f, a, e) {
        return a && b(f.prototype, a),
        e && b(f, e),
        f
    }
} (),
docCookies = {
    getItem: function(b) {
        return b ? decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(b).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null: null
    },
    setItem: function(k, m, a, e, l, i) {
        if (!k || /^(?:expires|max\-age|path|domain|secure)$/i.test(k)) {
            return ! 1
        }
        var n = "";
        if (a) {
            switch (a.constructor) {
            case Number:
                n = a === 1 / 0 ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT": "; max-age=" + a;
                break;
            case String:
                n = "; expires=" + a;
                break;
            case Date:
                n = "; expires=" + a.toUTCString()
            }
        }
        return document.cookie = encodeURIComponent(k) + "=" + encodeURIComponent(m) + n + (l ? "; domain=" + l: "") + (e ? "; path=" + e: "") + (i ? "; secure": ""),
        !0
    },
    removeItem: function(e, f, a) {
        return !! this.hasItem(e) && (document.cookie = encodeURIComponent(e) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (a ? "; domain=" + a: "") + (f ? "; path=" + f: ""), !0)
    },
    hasItem: function(b) {
        return ! (!b || /^(?:expires|max\-age|path|domain|secure)$/i.test(b)) && new RegExp("(?:^|;\\s*)" + encodeURIComponent(b).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=").test(document.cookie)
    },
    keys: function() {
        for (var e = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/), f = e.length, a = 0; a < f; a++) {
            e[a] = decodeURIComponent(e[a])
        }
        return e
    }
},
$d = {
    $byId: document.getElementById.bind(document)
},
$s = {
    loadStyle: function(k) {
        var m = k.url,
        a = k.id,
        e = "function" == typeof k.callback ? k.callback: function() {},
        l = document.createElement("link"),
        i = "onload" in l,
        n = function() {
            l && (l.onload = l.onerror = l.onreadystatechange = null, l = null, e())
        };
        l.rel = "stylesheet",
        l.type = "text/css",
        l.href = m,
        void 0 !== a && (l.id = a),
        document.head.appendChild(l),
        i ? (l.onload = n, l.onerror = n) : l.onreadystatechange = function() { / loaded | complete / .test(l.readyState) && n()
        }
    }
},
defaultStyle = {
    width: "111px",
    height: "50px",
    lineHeight: "50px",
    borderRadius: "5px",
    backgroundColor: "#000",
    opacity: 0.75,
    color: "#fff",
    fontSize: "13px",
    textAlign: "center",
    position: "fixed",
    top: "50%",
    left: "50%",
    marginTop: "-55px",
    marginLeft: "-55px",
    zIndex: "10001"
},
Toast = function() {
    function b(d, a) {
        _classCallCheck(this, b),
        this.txt = d || "",
        this.duration = a || 1000
    }
    return _createClass(b, [{
        key: "show",
        value: function() {
            this.toast = document.createElement("div"),
            this.id = b.id(),
            this.toast.setAttribute("id", this.id),
            this.stylize(this.toast),
            this.toast.innerText = this.txt,
            document.body.appendChild(this.toast),
            setTimeout(this.destroy.bind(this), this.duration)
        }
    },
    {
        key: "stylize",
        value: function(d) {
            var a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : defaultStyle;
            Object.keys(a).forEach(function(c) {
                return d.style[c] = a[c]
            })
        }
    },
    {
        key: "destroy",
        value: function() {
            document.body.removeChild(document.getElementById(this.id))
        }
    }], [{
        key: "id",
        value: function() {
            return Date.now() % 10000
        }
    }]),
    b
} (),
conf = {
    api: {
        hot: "//apo51.cn/hq/search/hot_search.js",
        SUGGEST: "//suggest3.api51.cn/suggest/",
        CONCERN: "//watchlist.apo51.cn/portfolio/api/openapi.php/HoldService.hasHold",
        ADDSELF: "//" + window.location.host + "/zixuan/add.php",
        DELSELF: "//watchlist.apo51.cn/portfolio/api/openapi.php/HoldService.delSymbolFace"
    },
    href: {
        nfutures: "//apo51.cn/ft/hq/nf.php?symbol=",
        hfutures: "//apo51.cn/ft/hq/hf.php?symbol=",
        usstock: "//apo51.cn/us/hq/quotes.php?code=",
        forex: "//apo51.cn/fx/hq/quotes.php?code=",
        stock: "//quotes.api.cn/hs/company/quotes/view/",
        bond: "//apo51.cn/bd/hq/quotes.php?symbol=",
        sanban: "//apo51.cn/tm/hq/quotes.php?code=",
        hkstock: "//quotes.api.cn/hk/company/quotes/view/",
        bitcoin: "//stocks.api.cn/bit/detail?wh=",
        center: "//apo51.cn/m/#/stock/blockdetail?id=",
        fund: "//stocks.api.cn/fund/?code=",
        znb: "//quotes.api.cn/global/hq/quotes.php?code="
    }
};
docCookies.removeItem("symbol", "/", "api.cn"),
docCookies.removeItem("nbsearch", "/", "api.cn");
var tpl = {
    container: {
        tail: "</div></div>",
        header: '<div class="hq_search" id="hq_search"><div class="hq_search-form"><i class="hq_search-form-back" id="destroy">\u53d6\u6d88</i><div class="hq_search-isearch"><input class="hq_search-form-input" id="suggestipt" placeholder="\u4ee3\u7801\uff0f\u62fc\u97f3\uff0f\u9996\u5b57\u6bcd\u7b49"></div><div class="hq_search-close" id="searchClose"><i class="iclose"></i></div></div><div class="hq_search-wrap" id="view">'
    },
    hot: {
        tail: "</div></div></div>",
        header: '<div class="hq_search-hot"><div class="hq_search-inner"><h3><i class="ihot"></i><span class="vbottom">\u70ed\u95e8\u641c\u7d22</span></h3><div class="hq_search-hot-list" suda-uatrack="key=fin_search&value=hot_search">'
    },
    history: {
        tail: "</ul></div></div></div>",
        header: '<div id="history"><div class="hq_search-history"><div class="hq_search-inner"> <h3><i class="ihistory"></i><span class="vbottom">\u641c\u7d22\u5386\u53f2</span></h3><ul class="hq_search-history-list"  suda-uatrack="key=fin_search&value=search_history">'
    },
    reslst: {
        tail: "</ul></div></div>",
        header: '<div><ul class="hq_search-list" id="hq_search-list" suda-uatrack="key=fin_search&value=search_result"><div class="hq_search-inner">'
    },
    lst404: {
        tpl: '<div class="hq_search-404"><i></i><h5>\u554a\u54c8\uff0c\u641c\u7d22\u7ed3\u679c\u4e3a\u7a7a~</h5></div>'
    },
    footer: {
        tpl: '<ul class="hq_search-feedback" id="hq_searchFeedback"><li><a href="//finance.api.cn/">\u65b0\u6d6a\u8d22\u7ecf</a></li><li><a href="//apo51.cn/m/">\u8d22\u7ecf\u884c\u60c5</a></li><li><a href="//apo51.cn/m/feedback?from=nbsearchadvice">\u610f\u89c1\u53cd\u9988</a></li></ul>'
    }
},
Search = function() {
    function b() {
        _classCallCheck(this, b),
        this.container = null,
        this.hotView = null,
        this.historyView = null,
        this.view = null,
        this.historyNode = !1,
        this.mask = null,
        this.searchClose = null,
        this.suggestipt = null,
        this.destroybtn = null,
        this.ctrltimer = null,
        this.highlight = "",
        this.end = new Date(2020, 5, 12),
        this.lst404 = tpl.lst404.tpl,
        this.footer = tpl.footer.tpl,
        this.searchType = [11, 12, 21, 22, 23, 24, 25, 26, 27, 72, 31, 32, 33, 41, 71, 73, 77, 78, 79, 81, 86, 87, 100],
        this.specialList = {
            qq50: "//stocks.api.cn/op/?cid=76576"
        },
        this.styleUrl = "//n.apiimg.cn/finance/s_717/main.css?v=5",
        $s.loadStyle({
            url: this.styleUrl,
            id: "HQ_SEARCH_STYLE",
            callback: setTimeout(this.fetch.bind(this), 30)
        }),
        this.searchStyle = $d.$byId("HQ_SEARCH_STYLE")
    }
    return _createClass(b, [{
        key: "fetch",
        value: function() {
            this.fetchHotData()
        }
    },
    {
        key: "fetchHotHandler",
        value: function() {
            var a = tpl.container;
            this.hotView = this.buildHot(hot_stocks),
            this.fetchHistory()
        }
    },
    {
        key: "fetchHotData",
        value: function() {
            jsonp({
                url: conf.api.hot,
                success: this.fetchHotHandler.bind(this)
            })
        }
    },
    {
        key: "fetchHistoryHandler",
        value: function(a) {
            this.historyView = this.buildHistory(a),
            this.historyNode ? this.historyNode.innerHTML = this.historyView: (this.render(this.view.innerHTML += this.historyView), this.historyNode = $d.$byId("history"))
        }
    },
    {
        key: "refine",
        value: function(d) {
            var a = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
            return d.split(",").filter(function(c) {
                return a ? -1 === c.indexOf("|") && "nf_10000001" !== c: -1 !== c.indexOf("|") || "nf_10000001" === c
            }).join(",")
        }
    },
    {
        key: "fetchHistory",
        value: function() {
            var g = this,
            h = "",
            a = void 0,
            e = void 0;
            return docCookies.hasItem("bbsearch") && (h = docCookies.getItem("bbsearch"), a = this.refine(h), e = this.refine(h, !1), a ? new HQ.DataCenter({
                symbols: a,
                getObj: function(c) {
                    return g.fetchHistoryHandler(c)
                }
            }) : e && setTimeout(function() {
                return g.fetchHistoryHandler(e)
            },
            0)),
            this.historyView = ""
        }
    },
    {
        key: "createMask",
        value: function() {
            this.mask = document.createElement("div"),
            this.mask.id = "HQ_SEARCH",
            document.body.appendChild(this.mask),
            this.mask = $d.$byId("HQ_SEARCH")
        }
    },
    {
        key: "initView",
        value: function(a) {
            this.createMask(),
            this.view = $d.$byId("view"),
            this.size(),
            this.bindEvent(),
            "undefined" != typeof SUDA && SUDA.uaTrack("fin_search", "all")
        }
    },
    {
        key: "adjustBottomBar",
        value: function() {
            var g = $d.$byId("hq_searchFeedback");
            if (g) {
                var h = $d.$byId("hq_search"),
                a = h.offsetHeight,
                e = document.documentElement.offsetHeight;
                g.style.position = a > e ? "absolute": "fixed"
            }
        }
    },
    {
        key: "render",
        value: function(a) {
            return this.view ? (this.view.innerHTML = a, this.adjustBottomBar()) : (this.initView(a), this.adjustBottomBar())
        }
    },
    {
        key: "fetchSuggestHandler",
        value: function(d) {
            var a = window[d];
            a ? (this.render(this.buildList(this.str2array(a))), this.searchListClickHandler(), this.addSelectionCtrl()) : this.render(this.lst404)
        }
    },
    {
        key: "bindEvent",
        value: function() {
            var d = this,
            a = this;
            this.searchClose = $d.$byId("searchClose"),
            this.suggestipt = $d.$byId("suggestipt"),
            this.destroybtn = $d.$byId("destroy"),
            this.suggestipt.focus(),
            this.searchClose.addEventListener("click",
            function() {
                return d.suggestipt.value = "",
                d.searchClose.style.display = "none",
                d.render(d.hotView + d.historyView + d.footer)
            },
            !1),
            this.destroybtn.addEventListener("click",
            function() {
                d.destroy(),
                "undefined" != typeof SUDA && SUDA.uaTrack("fin_search", "search_cancel")
            },
            !1),
            this.suggestipt.addEventListener("input",
            function() {
                var c = this.value.toLowerCase(),
                e = "suggest3_" + random();
                if (a.highlight = c, !c) {
                    return a.searchClose.style.display = "none",
                    a.render(a.hotView + a.historyView + a.footer)
                }
                a.searchClose.style.display = "block",
                jsonp({
                    url: conf.api.SUGGEST + "type=" + a.searchType.join(",") + "&key=" + c + "&name=" + e + "&num=15",
                    success: a.fetchSuggestHandler.bind(a, e)
                })
            },
            !1)
        }
    },
    {
        key: "samples",
        value: function(d) {
            var a = d.childNodes;
            return this.node2arr(a).map(function(c) {
                if (c.classList.contains("hq_search-list-item")) {
                    return "" + c.dataset.scode
                }
            }).join(",")
        }
    },
    {
        key: "node2arr",
        value: function(a) {
            return Array.apply(null, a)
        }
    },
    {
        key: "isLogin",
        value: function() {
            return checkLogin()
        }
    },
    {
        key: "addSelectionCtrl",
        value: function() {
            var e = this,
            f = document.querySelector(".hq_search-inner"),
            a = this.samples(f);
            this.isLogin() ? jsonp({
                url: "" + conf.api.CONCERN,
                data: {
                    scode: a
                },
                jsoncallback: !0,
                success: function(c) {
                    0 === c.status.code && e.renderRealCtrlState(c.data),
                    e.addAndDelSelectionHandler()
                }
            }) : this.addAndDelSelectionHandler()
        }
    },
    {
        key: "selectCtrlLoginHandler",
        value: function(j) {
            var l = void 0,
            a = void 0,
            e = void 0,
            k = void 0;
            j.classList.contains("select-ctrl-add") && (l = "ADDSELF", a = "-\u5220\u81ea\u9009", e = "select-ctrl-add", k = "select-ctrl-del"),
            j.classList.contains("select-ctrl-del") && (l = "DELSELF", a = "+\u81ea\u9009", e = "select-ctrl-del", k = "select-ctrl-add");
            var i = j.parentNode.dataset.scode;
            this.ctrltimer && clearTimeout(this.ctrltimer),
            this.ctrltimer = setTimeout(function() {
                jsonp({
                    url: "" + conf.api[l],
                    data: {
                        scode: i
                    },
                    jsoncallback: !0,
                    success: function(c) {
                        0 === c.status.code ? (j.innerText = a, j.classList.remove(e), j.classList.add(k), new Toast(c.status.msg).show()) : new Toast(c.status.msg).show()
                    }
                })
            },
            500)
        }
    },
    {
        key: "addAndDelSelectionHandler",
        value: function() {
            var d = this,
            a = document.querySelectorAll(".hq_search-list-item");
            this.node2arr(a).forEach(function(c) {
                var f = c.lastElementChild;
                "SPAN" === f.tagName && f.addEventListener("click",
                function(e) {
                    e.preventDefault(),
                    e.stopPropagation(),
                    d.isLogin() ? d.selectCtrlLoginHandler(f) : location.replace("//passport.api.cn/signin/signin?entry=wapsso&vt=4&r=" + encodeURIComponent(location.href))
                })
            })
        }
    },
    {
        key: "renderRealCtrlState",
        value: function(d) {
            var a = document.querySelectorAll(".hq_search-list-item");
            this.node2arr(a).forEach(function(c) {
                var f = c.dataset.selection;
                d.forEach(function(h) {
                    if (f === "" + h.market + h.code) {
                        var e = c.lastElementChild;
                        e.innerText = "-\u5220\u81ea\u9009",
                        e.classList.remove("select-ctrl-add"),
                        e.classList.add("select-ctrl-del")
                    }
                })
            })
        }
    },
    {
        key: "reset",
        value: function() {
            var a = document.body.style;
            a.overflow = "auto",
            a.height = "inherit"
        }
    },
    {
        key: "destroy",
        value: function() {
            document.body.removeChild(this.mask),
            document.head.removeChild(this.searchStyle),
            this.reset()
        }
    },
    {
        key: "wrapTag",
        value: function(j, l) {
            var a = this.highlight.length,
            e = l.split(""),
            k = l.indexOf(j.toUpperCase()),
            i = "<span style='color:#2572e8'>" + this.highlight + "</span>";
            return e.splice(k, a, i),
            "<span>" + e.join("") + "</span>"
        }
    },
    {
        key: "buildList",
        value: function(l) {
            var u = this,
            c = "",
            t = null,
            m = "",
            v = "",
            p = "",
            i = ["istock", "istockB", "ifund", "iukstock", "iusstock", "iban", "iforex", "sanban", "ibond", "ifutures", "izhi"],
            r = ["istock", "istockB", "iusstock", "iukstock", "ifund", "ifutures", "iforex"],
            f = "",
            y = "",
            h = "",
            e = "",
            o = "",
            a = "",
            s = tpl.reslst,
            n = l ? l.length: 0,
            N = "",
            O = "",
            d = "";
            return l.forEach(function(j, g) {
                switch (t = j[1], h = j[4].toUpperCase(), g = h.indexOf(u.highlight.toUpperCase()), -1 !== g && (h = u.wrapTag(h[g], h)), t) {
                case "11":
                    f = j[3],
                    e = j[3].toUpperCase(),
                    m = conf.href.stock + f,
                    p = i[0],
                    y = "",
                    o = "",
                    N = f + "@cn",
                    O = "" + f;
                    break;
                case "12":
                    f = j[3],
                    e = j[3].toUpperCase(),
                    m = conf.href.stock + f,
                    p = i[1],
                    y = "",
                    o = "",
                    N = f + "@cn",
                    O = "" + f;
                    break;
                case "21":
                case "22":
                case "23":
                case "24":
                case "25":
                case "26":
                case "27":
                case "72":
                    f = j[2],
                    e = j[3].toUpperCase(),
                    m = conf.href.fund + f,
                    p = i[2],
                    y = "",
                    o = "|" + j[4],
                    N = f + "@fund",
                    O = "of" + f;
                    break;
                case "31":
                case "32":
                    f = j[2].toUpperCase(),
                    e = "HK" + j[3],
                    m = conf.href.hkstock + f,
                    p = i[3],
                    y = "hk",
                    o = "",
                    N = f + "@hk",
                    O = "" + y + f;
                    break;
                case "33":
                    f = j[2].toUpperCase(),
                    e = j[3].toUpperCase(),
                    m = conf.href.hkstock + f,
                    p = i[3],
                    y = "hk",
                    o = "",
                    N = f + "@hk",
                    O = "" + y + f;
                    break;
                case "41":
                    e = j[2].toUpperCase(),
                    f = j[2],
                    -1 !== f.indexOf(".") && (f = f.replace(".", "$")),
                    m = conf.href.usstock + f.replace("$", "."),
                    p = i[4],
                    y = "gb_",
                    o = "",
                    N = f.toUpperCase() + "@us",
                    O = "us" + f.toUpperCase();
                    break;
                case "77":
                case "78":
                case "79":
                    f = j[3],
                    e = f.toUpperCase(),
                    m = conf.href.center + f,
                    p = i[5],
                    o = "|" + j[4],
                    a = "BLOCK";
                    break;
                case "71":
                    f = j[2],
                    e = j[3].toUpperCase(),
                    m = conf.href.forex + f,
                    p = i[6],
                    y = "fx_s",
                    o = "",
                    N = "" + y + f + "@wh",
                    O = "wh" + y + f;
                    break;
                case "73":
                    f = j[2],
                    e = j[3].toUpperCase(),
                    m = conf.href.sanban + f,
                    p = i[7],
                    y = "sb",
                    o = "";
                    break;
                case "81":
                    f = j[3],
                    e = j[3].toUpperCase(),
                    m = conf.href.bond + f,
                    p = i[8],
                    o = "";
                    break;
                case "87":
                    f = j[2].toUpperCase(),
                    e = j[3].toUpperCase(),
                    m = 10000001 != f ? conf.href.nfutures + f: u.specialList.qq50,
                    p = i[9],
                    o = "",
                    y = 10000001 != f ? "nf_": (o = "|50\u671f\u6743", f = ""),
                    N = "" + y + f + "@gn",
                    O = "ft" + y + f.toLowerCase();
                    break;
                case "86":
                    f = j[2].toUpperCase(),
                    e = j[3].toUpperCase(),
                    m = conf.href.hfutures + f,
                    p = i[9],
                    y = "hf_",
                    o = "",
                    N = "" + y + f + "@global",
                    O = "ft" + y + f;
                    break;
                case "100":
                    f = j[2].toUpperCase(),
                    e = j[3].toUpperCase(),
                    m = conf.href.znb + f,
                    p = i[10],
                    y = "znb_",
                    o = ""
                }
                if (e) { - 1 !== e.indexOf(u.highlight.toUpperCase()) && (e = u.wrapTag(u.highlight, e).toUpperCase())
                } - 1 !== r.indexOf(p) && (d = '<span class="select-ctrl-add">+\u81ea\u9009</span>'),
                v = "istock" === p || "istockB" === p || "iukstock" === p ? "?from=nbsearchresult": "&from=nbsearchresult",
                c = c + '<li class="hq_search-list-item" data-symbol="' + y + f + o + '" data-selection="' + O + '" data-scode="' + N + '" data-url="' + m + v + '"><i class="' + p + '"></i><p>' + h.toLowerCase() + "</p><div>" + e + "</div>" + d + "</li>"
            }),
            n > 10 ? s.header + c + '<div class="hq_search-list-desc"><p>\u53ea\u5c55\u793a\u524d<span>15</span>\u6761\u7ed3\u679c</p><p>\u5982\u679c\u6ca1\u6709\u60a8\u60f3\u8981\u7684\uff0c\u8bf7\u8f93\u5165\u66f4\u7cbe\u786e\u7684\u5173\u952e\u8bcd\uff5e</p></div>' + s.tail: s.header + c + s.tail
        }
    },
    {
        key: "searchListClickHandler",
        value: function() {
            var e = this,
            f = "",
            a = document.querySelectorAll(".hq_search-list-item"); [].forEach.call(a,
            function(c) {
                c.addEventListener("click",
                function(d) {
                    d.preventDefault(),
                    e.recordHistory(this),
                    (f = this.getAttribute("data-url")) && (window.location.href = f, e.destroy())
                },
                !1)
            })
        }
    },
    {
        key: "recordHistory",
        value: function(h) {
            var j = this,
            a = void 0,
            e = [],
            i = void 0;
            i = h.getAttribute("data-symbol"),
            a = docCookies.getItem("bbsearch"),
            a ? (e = a.split(","), e.length < 10 ? (j.uniq(e, i, !1), j.recordCookies(e.join(","))) : (j.uniq(e, i, !0), j.recordCookies(e.join(",")))) : j.recordCookies(i)
        }
    },
    {
        key: "uniq",
        value: function(g, h, a) {
            var e = g.indexOf(h);
            return a ? -1 !== e ? (g.splice(e, 1), g.push(h)) : g.shift() && g.push(h) : -1 !== e ? (g.splice(e, 1), g.push(h)) : g.push(h),
            g
        }
    },
    {
        key: "recordCookies",
        value: function(a) {
            docCookies.setItem("bbsearch", a, this.end, "/", "api.cn")
        }
    },
    {
        key: "getCookies",
        value: function() {
            return docCookies.getItem("bbsearch")
        }
    },
    {
        key: "str2array",
        value: function(d) {
            var a = [];
            return d.split(";").forEach(function(c) {
                a.push(c.split(","))
            }),
            a
        }
    },
    {
        key: "buildHot",
        value: function(h) {
            var j = "",
            a = tpl.hot,
            e = "",
            i = a.header;
            return h.forEach(function(c, d) {
                switch (c.type) {
                case 1:
                    j = "istock";
                    break;
                case 2:
                    j = "iukstock";
                    break;
                case 3:
                    j = "iusstock";
                    break;
                case 4:
                    j = "ifund";
                    break;
                case 5:
                    j = "ifutures";
                    break;
                case 6:
                    j = "iforex";
                    break;
                case 7:
                    j = "istock";
                    break;
                case 8:
                    j = "ibond";
                    break;
                case 9:
                    j = "sanban";
                    break;
                case 10:
                    j = "ifutures";
                    break;
                default:
                    j = ""
                }
                e += '<li><a href="' + c.url + '"><i class=' + j + '></i><span class="vmiddle">' + c.name + "</span></a></li>",
                (d + 1) % 3 == 0 && (i = i + "<ul>" + e + "</ul>", e = "")
            }),
            i += a.tail
        }
    },
    {
        key: "getUserCustomRiseColor",
        value: function(g) {
            var h = docCookies.getItem("hq_userColor") || "riseRed",
            a = -1 !== g.indexOf("+"),
            e = -1 !== g.indexOf("-");
            return a ? "riseRed" === h ? "red": "green": e ? "riseRed" === h ? "green": "red": "gray"
        }
    },
    {
        key: "buildHistory",
        value: function(D) {
            if ("string" == typeof D) {
                return this.buildUnSupport(D)
            }
            for (var d = tpl.history,
            r = docCookies.getItem("bbsearch").split(","), l = "", c = "", n = "", h = "", s = void 0, i = void 0, t = void 0, e = void 0, u = void 0, o = void 0, a = void 0, p = void 0; r.length;) {
                if (s = r.pop(), i = Object.keys(D), -1 !== i.indexOf(s)) {
                    switch (t = D[s], e = t.price, u = t.percent, o = t.name, a = t.code, p = t.hqMarket, h = this.getUserCustomRiseColor(u), p) {
                    case "A":
                        n = "istock",
                        c = conf.href.stock + a;
                        break;
                    case "US":
                        n = "iusstock",
                        c = conf.href.usstock + a;
                        break;
                    case "HK":
                        n = "iukstock",
                        c = conf.href.hkstock + a;
                        break;
                    case "BD":
                        n = "ibond",
                        c = conf.href.bond + a;
                        break;
                    case "FUTURES":
                        n = "ifutures",
                        c = conf.href.hfutures + a;
                        break;
                    case "FOREX":
                        n = "iforex",
                        c = conf.href.forex + a;
                        break;
                    case "SB":
                        n = "sanban",
                        c = conf.href.sanban + a;
                        break;
                    case "ZNB":
                        n = "izhi",
                        c = conf.href.znb + a
                    }
                    l += '<li><a href="' + c + '"><span><i class="' + n + '"></i><span class="vbottom">' + o + '</span></span><b class="' + h + '">' + e + '</b><b class="' + h + '">' + u + "</b></a></li>"
                } else {
                    l += this.buildUnSupport(s)
                }
            }
            return d.header + l + d.tail
        }
    },
    {
        key: "buildUnSupport",
        value: function(l) {
            var o = l.split(","),
            a = o.length,
            e = "",
            n = "",
            i = tpl.history,
            p = this.splitUnSupport(l),
            m = this.getCookies().split(",");
            return 1 === a ? (n = '<li><a href="' + p.href + '"><span><i class="' + p.className + '"></i>' + p.name + "</span></li>", 1 === m.length ? i.header + n + i.tail: n) : (o.reverse().forEach(function() {
                e += '<li><a href="' + p.href + '"><span><i class="' + p.className + '"></i>' + p.name + "</span></li>"
            }), i.header + e + i.tail)
        }
    },
    {
        key: "splitUnSupport",
        value: function(h) {
            var j = h.split("|"),
            a = j[0],
            e = j[1],
            i = this.getUnSupportMsgBy(a);
            return {
                symbol: a,
                name: e,
                className: i.className,
                href: i.href
            }
        }
    },
    {
        key: "getUnSupportMsgBy",
        value: function(e) {
            var f = "",
            a = "";
            return - 1 !== e.indexOf("_") ? (f = "iban", a = conf.href.center + e) : -1 === e.indexOf("_") && 6 === e.length ? (f = "ifund", a = conf.href.fund + e) : (f = "ifutures", a = this.specialList.qq50),
            {
                className: f,
                href: a
            }
        }
    },
    {
        key: "size",
        value: function() {
            var a = document.body.style;
            a.height = screen.height + "px",
            a.overflow = "hidden"
        }
    }]),
    b
} (); !
function() {
    var c = window.HQ,
    d = c.DataBoxCfg;
    c.DataBox = function(b) {
        this._config = {
            boxId: "",
            symbol: "",
            isShow: !1,
            addOptional: !0,
            hasAppPopup: !0,
            fxReverse: !1
        },
        this._configData = {
            symbols: "",
            getObj: null,
            getStr: null,
            isHKClickFresh: !0,
            isANeedCWZJ: !1,
            isANeedQZ: !1,
            isANeedPHP: !1,
            QZindex: "",
            eachOrder: !1,
            isHKNeed_i: !0
        };
        for (var f in this._config) {
            b.hasOwnProperty(f) && (this._config[f] = b[f])
        }
        for (var a in this._configData) {
            b.hasOwnProperty(a) ? this._configData[a] = b[a] : "symbols" === a && (this._configData[a] = b.symbol)
        }
        this._Symbol = "",
        this._Parent = "",
        this._BoxMain = "",
        this._Market = "",
        this._DataCfg = null,
        this._DataCenter = null,
        this._OneNodes = {},
        this._ReNodes = {},
        this._ScreenWidth = 0,
        this._Events = {},
        this._Utils = c.DataUtils,
        this._Filled = !1,
        this._Showing = this._config.isShow,
        this._Login = !1,
        this._OptStatus = !0,
        this._OptKey = !0,
        this._OptApi = "//watchlist.api.cn/portfolio/api/openapi.php/",
        this._isOptOld = !1,
        this._noOptArr = ["ZNB"],
        this._init()
    },
    c.DataBox.prototype = {
        constructor: c.DataBox,
        _init: function() {
            this._Market = this._getMarket(this._config.symbol),
            this._DataCfg = d[this._Market],
            this._Symbol = this._config.symbol.replace(/\./g, "$"),
            this._ScreenWidth = this._Utils.viewData().viewWidth,
            this._isOptOld = "US" === this._Market || "A" === this._Market || "AI" === this._Market || "HK" === this._Market,
            this._createBox(this._Market, this._Symbol),
            this._loadData(),
            this._config.hasAppPopup && this.appPopup.create()
        },
        _createBox: function(b, e) {
            var h = this,
            a = document.createElement("div");
            a.id = "HQBox_Main",
            h._Parent = document.getElementById(h._config.boxId),
            h._Parent.appendChild(a),
            h._createNames(),
            h._createPoint(),
            h._createDetail(b),
            h._createSpecial(e, b),
            h._BoxMain = document.getElementById("HQBox_Main")
        },
        _createNames: function() {
            var a = this,
            b = document.getElementById("HQBox_Main"),
            e = document.createElement("div");
            e.id = "HQBox_Names",
            e.className = "hqbox-names",
            b.appendChild(e),
            e.innerHTML = '<h2 id="HQBox_Names_name" class="hqbox-names-name">--</h2><ul class="hqbox-names-subnames" id="HQBox_Names_subnames"><li class="hqbox-names-code" id="HQBox_Names_code">--</li></ul>',
            a._OneNodes.name = document.getElementById("HQBox_Names_name"),
            a._OneNodes.code = document.getElementById("HQBox_Names_code")
        },
        _createPoint: function() {
            var a = this,
            b = document.getElementById("HQBox_Main"),
            e = document.createElement("div");
            e.id = "HQBox_Point",
            e.className = "hqbox-point",
            b.appendChild(e),
            e.innerHTML = '<div class="hqbox-point-main"><div class="hqbox-point-data"><div class="hqbox-point-price" id="HQBox_Point_price">--</div><ul class="hqbox-point-more"><li class="hqbox-point-moreitem" id="HQBox_Point_change">--</li><li class="hqbox-point-moreitem" id="HQBox_Point_percent">--</li></ul></div><div class="hqbox-point-special"><div class="hqbox-point-sbtns" id="HQBox_Point_Sbtns"></div><div class="hqbox-point-stime" id="HQBox_Point_Stime"></div></div></div>',
            a._ReNodes.price = document.getElementById("HQBox_Point_price"),
            a._ReNodes.change = document.getElementById("HQBox_Point_change"),
            a._ReNodes.percent = document.getElementById("HQBox_Point_percent")
        },
        _createDetail: function(a) {
            function r(f) {
                var g = "";
                return g += '<dl class="hqbox-detail-item"><dt class="name">' + f.name + '</dt><dd id="HQBox_Detail_' + f.value + '" class="val">--</dd></dl>'
            }
            var t = this,
            l = t._DataCfg,
            b = t._Events,
            n = t._Utils,
            e = document.getElementById("HQBox_Main"),
            p = document.createElement("div"),
            i = document.createElement("div"),
            u = l.map(function(f) {
                return r(f)
            }),
            s = [];
            p.id = "HQBox_Detail",
            p.className = "hqbox-detail",
            e.appendChild(p),
            i.id = "HQBox_Arrowbox",
            i.className = "hqbox-arrowbox",
            "ZNB" !== a && e.appendChild(i),
            s.length = Math.ceil(u.length / 2);
            for (var B = 0; B < s.length; B++) {
                s[B] = u[2 * B] + (u[2 * B + 1] || ""),
                s[B] = B > 1 ? t._Showing ? '<li class="hqbox-detail-row" style="display: -webkit-box; display: -webkit-flex; display: -ms-flexbox; display: flex;">' + s[B] + "</li>": '<li class="hqbox-detail-row" style="display:none">' + s[B] + "</li>": '<li class="hqbox-detail-row">' + s[B] + "</li>"
            }
            p.innerHTML = "<ul>" + s.join("") + "</ul>",
            t._Showing ? i.innerHTML = '<i class="hqbox-arrow hqbox-arrow-open" id="HQBox_Arrow"></i>': i.innerHTML = '<i class="hqbox-arrow hqbox-arrow-close" id="HQBox_Arrow"></i>';
            var o = document.createElement("div");
            switch (o.id = "HQBox_Detail_More", o.className = "hqbox-detail-more", t._Market) {
            case "FX":
                o.innerHTML = '\u62a5\u4ef7\uff1a<span id="HQBox_Names_bank">--</span>',
                p.appendChild(o),
                t._OneNodes.bank = document.getElementById("HQBox_Names_bank")
            }
            l.forEach(function(f, g) {
                t._ReNodes[f.value] = document.getElementById("HQBox_Detail_" + f.value)
            }),
            b.showDetail = function() {
                "ZNB" !== a && t.toggle()
            },
            n.on(p, "click",
            function() {
                b.showDetail()
            }),
            n.on(i, "click",
            function() {
                b.showDetail()
            })
        },
        _createSpecial: function(a, b) {
            switch (this._config.addOptional && -1 === this._noOptArr.indexOf(this._Market) && this._createAddopt(b), this._Market) {
            case "FX":
                this._createFxSpecial();
                break;
            case "US":
                this._createUSSpecial();
                break;
            case "A":
                this._createASpecial();
                break;
            case "HK":
                this._createHKSpecial(a);
                break;
            default:
                this._createDeSpecial(a, b)
            }
        },
        _createAddopt: function(i) {
            var b = this,
            e = b._Events,
            o = b._Utils,
            a = b.getScode(b._config.symbol, 1)[0],
            q = (b.getScode(b._config.symbol, 1)[1], "api/config.php?scode=" + a + "&source=wap_mzx"),
            l = "",
            r = document.getElementById("HQBox_Names"),
            n = document.createElement("div");
            if (n.id = "HQBox_Names_Add", n.className = "hqbox-names-addbtn", "HK" === i) {}
            "undefined" != typeof checkLogin && (this._Login = checkLogin(), b._Login || (b._OptStatus = !1, l = "+ \u6dfb\u52a0\u81ea\u9009"), o.jsonp({
                url: q,
                jsoncallback: !0,
                success: function(f) {
                    0 === f.status.code ? (b._OptStatus = !0, l = "- \u5220\u9664\u81ea\u9009") : 110 === f.status.code && (b._OptStatus = !1, l = "+ \u6dfb\u52a0\u81ea\u9009"),
                    r.appendChild(n),
                    n.innerHTML = l,
                    e.addOption = function() {
                        b.addOption()
                    },
                    o.on(n, "click",
                    function() {
                        e.addOption()
                    })
                }
            }))
        },
        _createHKSpecial: function(a) {
            var b = this;
            document.getElementById("HQBox_Point_Stime").innerHTML = '<span id="HQBox_Special_status">--</span> <span id="HQBox_Special_datetime">--</span>',
            b._ReNodes.datetime = document.getElementById("HQBox_Special_datetime") || "",
            b._ReNodes.status = document.getElementById("HQBox_Special_status") || "",
            this._Utils.jsonp({
                url: "//" + window.location.host + "/api/config.php?" + random() + a.substr(2),
                jsoncallback: !0,
                success: function(n) {
                    var H = n.data.Asymbol,
                    o = "",
                    F = document.getElementById("HQBox_Names_name");
                    if (n.data.ght && (o = "[\u6caa\u80a1\u901a]"), n.data.hgt && (o = "[\u6e2f\u80a1\u901a]"), n.data.sgt && (o = "[\u6df1\u80a1\u901a]"), setTimeout(function() {
                        var e = document.createElement("span");
                        e.innerHTML = o,
                        e.style.fontSize = "12px",
                        F.appendChild(e)
                    },
                    50), 0 === n.status.code && "string" == typeof H && H.length > 0) {
                        var r = [];
                        r.push(H),
                        r.push(a),
                        r.push("fx_scnyhkd");
                        var G = document.createElement("div");
                        G.id = "HKExtra",
                        G.className = "HQBox_HK_Special",
                        G.innerHTML = '<a suda-uatrack="key=wap_hk&value=astock_related" href="' + c.DataHref.stock + H + '"><span class="HQBox_Special-title">A\u80a1</span><span class="HQBox_Special-price">--</span><span class="HQBox_Special-change">--</span><span class="HQBox_Special-ratio">--</span><span class="HQBox_Special-premium">H/A\u6ea2\u4ef7 --</span><a data-is="daicon" class="HQBox_Special-tui" suda-uatrack="key=wap_hk&value=hk_level2"></a></a>',
                        b._Parent.appendChild(G);
                        var m = {
                            symbols: r.join(","),
                            QZindex: !1,
                            isANeedQZ: !1,
                            isANeedPHP: !1,
                            isANeedCWZJ: !1
                        },
                        f = 0,
                        s = 0,
                        p = 0,
                        v = "red",
                        i = document.querySelector(".HQBox_Special-price"),
                        h = document.querySelector(".HQBox_Special-change"),
                        u = document.querySelector(".HQBox_Special-ratio"),
                        l = document.querySelector(".HQBox_Special-premium");
                        b._DataCenter = new c.DataCenter(m,
                        function(e) {
                            f = e[H].price,
                            s = e[a].price,
                            p = e.fx_scnyhkd.buy,
                            v = e[H].type,
                            b._Utils.setInnerText(i, e[H].price),
                            b._Utils.setInnerText(h, e[H].change),
                            b._Utils.setInnerText(u, e[H].percent),
                            b._Utils.setInnerText(l, "H/A\u6ea2\u4ef7" + ((s - f * p) / (f * p) * 100).toFixed(3) + "%"),
                            i.style.color = h.style.color = u.style.color = "red" === v ? "#de3639": "#1bc07d"
                        })
                    } else {
                        var G = document.createElement("div");
                        G.id = "HKExtra",
                        G.className = "HQBox_HK_Special",
                        G.innerHTML = '<div><a data-is="datxt" suda-uatrack="key=wap_hk&value=hk_level2" style="font-size:13px;color:#000;">APP\u7248\u6e2f\u80a1Level 2\u66f4\u4f18\u60e0\u66f4\u4fbf\u6377</a><a data-is="daicon" class="HQBox_Special-tui" suda-uatrack="key=wap_hk&value=hk_level2"></a></div>',
                        b._Parent.appendChild(G)
                    }
                }
            })
        },
        _getHkStatus: function() {
            var a = this,
            b = document.getElementById("HQBox_Point_Sbtns"),
            e = function(f) {
                var j = "",
                k = f.split(" ");
                return k.forEach(function(i, g) {
                    if (0 === g) {
                        var n = k[g].split("-");
                        j += (n[1] || "--") + "/" + (n[2] || "--")
                    } else {
                        var h = k[g].split(":");
                        j += " " + (h[0] || "--") + ":" + (h[1] || "--")
                    }
                }),
                j
            };
            this._Utils.jsonp({
                url: "//" + window.location.host + "/api/config.php?" + random(),
                jsoncallback: !0,
                success: function(f) {
                    0 === f.status.code ? b.innerHTML = "\u5357\u5411\u4f59\u989d:" + (f.data.ggt_total_remain / 100000000).toFixed(3) + "\u4ebf": b.innerHTML = "--"
                }
            }),
            this._Utils.jsonp({
                url: "//" + window.location.host + "/api/config.php?" + random(),
                jsoncallback: !0,
                success: function(h) {
                    var f = "";
                    if (0 === h.status.code) {
                        switch (h.data.status) {
                        case 1:
                            f = h.data.msg;
                            break;
                        case 2:
                            f = "\u5468\u672b\u4f11\u5e02";
                            break;
                        case 3:
                            f = "\u7279\u6b8a\u8282\u65e5"
                        }
                        a._ReNodes.datetime.innerHTML = e(h.data.hq_time),
                        a._ReNodes.status.innerHTML = f
                    }
                }
            })
        },
        _createDeSpecial: function(e, k) {
            var l = this,
            a = (l._Events, l._Utils, document.getElementById("HQBox_Point_Stime")),
            j = document.getElementById("HQBox_Point_Sbtns"),
            b = '<span id="HQBox_Special_date">--</span> <span id="HQBox_Special_time">--</span>';
            k && "HF" === k.toUpperCase() && window.innerWidth > 320 && (b = '<span>\u5317\u4eac\u65f6\u95f4 </span><span id="HQBox_Special_date">--</span> <span id="HQBox_Special_time">--</span>'),
            a.innerHTML = b,
            "btc_btcokcoin" === e && (j.innerHTML = "\u8ba1\u4ef7\u5355\u4f4d\uff1a\u4eba\u6c11\u5e01"),
            "btc_btcbitstamp" === e && (j.innerHTML = "\u8ba1\u4ef7\u5355\u4f4d\uff1a\u7f8e\u5143"),
            l._ReNodes.time = document.getElementById("HQBox_Special_time") || "",
            l._ReNodes.date = document.getElementById("HQBox_Special_date") || ""
        },
        _createUSSpecial: function() {
            var a = this;
            a._Events,
            a._Utils,
            document.getElementById("HQBox_Point_Sbtns");
            document.getElementById("HQBox_Point_Stime").innerHTML = '<span id="HQBox_Special_regTime">--</span>',
            a._ReNodes.regTime = document.getElementById("HQBox_Special_regTime")
        },
        _createUSExtbox: function(e) {
            function l(f) {
                var g = (localStorage.getItem("hq_riseColor"), [document.getElementById("HQBox_USext_extPrice"), document.getElementById("HQBox_USext_extChange"), document.getElementById("HQBox_USext_extPercent")]),
                h = "";
                switch (f) {
                case "red":
                    h = "#de3639";
                    break;
                case "green":
                    h = "#1bc07d";
                    break;
                case "equal":
                    h = "#999999"
                }
                g.forEach(function(j) {
                    j.style.color = h
                })
            }
            var n = this,
            a = (n._Utils, document.getElementById(this._config.boxId)),
            i = document.getElementById("HQBox_USext"),
            b = document.createElement("div"),
            m = '<aside class="hqbox-usextarea-title"><span class="titlebox">' + e[n._Symbol].extType + '</span><span class="titlebox" id="HQBox_USext_extTime">--</span></aside><ul class="hqbox-usextarea-values"><li id="HQBox_USext_extPrice" class="hqbox-usextarea-value">--</li><li id="HQBox_USext_extChange" class="hqbox-usextarea-value">--</li><li id="HQBox_USext_extPercent" class="hqbox-usextarea-value">--</li></ul>';
            if ("--" === e[n._Symbol].extType) {
                if (!i) {
                    return
                }
                a.removeChild(i),
                delete n._ReNodes.extPrice,
                delete n._ReNodes.extChange,
                delete n._ReNodes.extPercent,
                delete n._ReNodes.extTime
            } else {
                if (i) {
                    return void l(e[n._Symbol].extColor)
                }
                b.id = "HQBox_USext",
                b.className = "hqbox-usextarea",
                a.appendChild(b),
                b.innerHTML = m,
                l(e[n._Symbol].extColor),
                n._ReNodes.extPrice = document.getElementById("HQBox_USext_extPrice"),
                n._ReNodes.extChange = document.getElementById("HQBox_USext_extChange"),
                n._ReNodes.extPercent = document.getElementById("HQBox_USext_extPercent"),
                n._ReNodes.extTime = document.getElementById("HQBox_USext_extTime")
            }
        },
        _createFxSpecial: function() {
            var b = this,
            i = b._Events,
            j = b._Utils;
            if (this._createDeSpecial(), this._config.fxReverse) {
                var a = document.getElementById("HQBox_Point_Sbtns"),
                e = document.createElement("div");
                e.id = "HQBox_Point_Rvs",
                e.className = "hqbox-point-btn",
                a.appendChild(e),
                e.innerHTML = '<i class="hqbox-btns-rvs"></i><span>\u53cd\u5411\u6c47\u7387</span>',
                i.forexReverse = function(g) {
                    var n = g.substr(4).toUpperCase(),
                    o = g.substr(4).toLowerCase(),
                    q = location.href,
                    h = "",
                    f = "";
                    q.indexOf(n) > -1 ? (h = n.slice(3) + n.slice(0, 3), f = q.replace(n, h)) : (h = o.slice(3) + o.slice(0, 3), f = q.replace(o, h)),
                    location.replace(f)
                },
                j.on(e, "click",
                function() {
                    i.forexReverse(b._Symbol)
                })
            }
        },
        _createASpecial: function() {
            var a = this;
            a._Events,
            a._Utils;
            document.getElementById("HQBox_Point_Stime").innerHTML = '<span id="HQBox_Special_halt">--</span> <span id="HQBox_Special_date">--</span> <span id="HQBox_Special_time">--</span>',
            a._ReNodes.halt = document.getElementById("HQBox_Special_halt") || "",
            a._ReNodes.time = document.getElementById("HQBox_Special_time") || "",
            a._ReNodes.date = document.getElementById("HQBox_Special_date") || ""
        },
        _loadData: function() {
            var a = this;
            a._DataCenter = new c.DataCenter(a._configData,
            function(b) {
                a._refresh(b)
            })
        },
        _getMarket: function(b) {
            var e = "",
            h = /^sh(20|1|009|010|020|019)/,
            a = /^sz(100|101|108|109|111|112|115|12|13|106|107)/;
            return 0 === b.indexOf("sh") || 0 == b.indexOf("sz") ? /^(sh00)\d+/.test(b) || /^(sz399)\d+/.test(b) ? "AI": a.test(b) || h.test(b) ? "BD": "A": 0 === b.indexOf("gb_") || 0 === b.indexOf("usr_") ? "US": 0 === b.indexOf("hf_") ? ["BP", "CD", "EC", "JY", "SF", "DXF"].indexOf(b) > -1 ? "WH": "HF": 0 === b.indexOf("nf_") ? (e = b.substr(3).replace(/[0-9]/gi, ""), ["IF", "TF", "T", "IH", "IC"].indexOf(e) > -1 ? "GZ": "NF") : b.indexOf("DINIW") > -1 || b.indexOf("XAGUSD") > -1 || b.indexOf("XAUUSD") > -1 || b.indexOf("EURI") > -1 ? "DINIW": 0 === b.indexOf("fx_s") ? "FX": 0 === b.indexOf("b_") ? "B": 0 === b.indexOf("znb_") ? "ZNB": 0 === b.indexOf("hk") ? "HK": 0 === b.indexOf("sb") ? "SB": 0 === b.indexOf("btc_") ? "BT": void 0
        },
        _refresh: function(a) {
            var b = this,
            e = b._Utils;
            "HK" === b._Market && this._getHkStatus(),
            "US" === b._Market && this._createUSExtbox(a),
            b._Filled || (Object.keys(b._OneNodes).forEach(function(f, k) {
                if ("code" === f && "US" === b._Market && "--" !== a[b._Symbol].usMarket) {
                    e.setInnerText(b._OneNodes[f], a[b._Symbol].usMarket + ":" + a[b._Symbol].code.toUpperCase())
                } else {
                    if ("code" === f && "BT" === b._Market) {
                        var i, l;
                        i = a[b._Symbol].code,
                        0 === i.indexOf("btc"),
                        l = i.substr(3).toUpperCase(),
                        b._OneNodes[f].innerHTML = l
                    } else {
                        e.setInnerText(b._OneNodes[f], a[b._Symbol][f].replace(/^\./, "").toUpperCase())
                    }
                }
            }), b._Filled = !0),
            b._BoxMain.className = "hqbox-bg" + a[b._Symbol].type,
            Object.keys(b._ReNodes).forEach(function(f, j) {
                if (parseFloat(e.getInnerText(b._ReNodes[f])) !== a[b._Symbol][f]) {
                    if ("extTime" === f && "US" === b._Market) {
                        e.setInnerText(b._ReNodes.extTime, a[b._Symbol].extTime.substring(7, 14))
                    } else {
                        if ("zdj" === f && "AI" === b._Market) {
                            e.setInnerText(b._ReNodes[f], a[b._Symbol].riseStockNum + "/" + a[b._Symbol].fallStockNum)
                        } else {
                            if (a[b._Symbol].price.toString().length > 6 && parseFloat(b._ScreenWidth) < 375 ? b._ReNodes.price.style.fontSize = "28px": b._ReNodes.price.style.fontSize = "36px", a[b._Symbol].halt && "\u9000\u5e02" === a[b._Symbol].halt) {
                                return "change" === f || "percent" === f || "time" === f || "halt" === f || "date" === f || "time" === f ? e.setInnerText(b._ReNodes[f], "") : "price" === f ? e.setInnerText(b._ReNodes[f], "\u9000\u5e02") : e.setInnerText(b._ReNodes[f], "--")
                            }
                            if (e.setInnerText(b._ReNodes[f], a[b._Symbol][f] || ""), "HK" === b._getMarket(b._Symbol) && "price" === f) {
                                var i = "\u6e2f\u5143";
                                /[A-Z]/.test(b._Symbol.substr(2, 1)) && (i = ""),
                                document.getElementById("HQBox_Point_price").innerHTML = a[b._Symbol][f] + '<span style="font-size: 12px !important;">' + i + "</span>"
                            }
                        }
                    }
                }
            })
        },
        toggle: function() {
            for (var e = this,
            l = document.getElementById("HQBox_Detail"), n = document.getElementById("HQBox_Arrow"), a = document.getElementById("HQBox_Detail_More"), i = n.className, b = Array.prototype.slice.call(l.getElementsByTagName("li")), m = 0; m < b.length; m++) {
                m > 1 && (e._Showing ? -1 === b[m].getAttribute("class").indexOf("hide") && (b[m].classList.remove("show"), b[m].classList.add("hide")) : -1 === b[m].getAttribute("class").indexOf("show") && (b[m].classList.remove("hide"), b[m].classList.add("show")))
            }
            e._Showing ? (n.className = i.replace("hqbox-arrow-open", "hqbox-arrow-close"), a && (a.style.display = "none")) : (n.className = i.replace("hqbox-arrow-close", "hqbox-arrow-open"), a && (a.style.display = "block")),
            e._Showing = !e._Showing
        },
        getScode: function(a, b) {
            var e = this;
            if ("US" === e._Market) {
                if (a.indexOf("gb_") > -1) {
                    return b ? [a.replace("gb_", "").toLowerCase() + "@us", "us"] : [a.replace("gb_", "").toUpperCase() + "@us", "us"]
                }
                if (a.indexOf("usr_") > -1) {
                    return b ? [a.replace("usr_", "us").toUpperCase(), "us"] : [a.replace("usr_", "").toUpperCase(), "us"]
                }
            } else {
                if ("A" === e._Market || "AI" === e._Market) {
                    return [a + "@cn", "cn"]
                }
                if ("HK" === e._Market) {
                    return [a.substr(2) + "@hk", "hk"]
                }
                if ("FX" === e._Market || "DINIW" === e._Market) {
                    return [a + "@wh", "wh"]
                }
                if ("HF" === e._Market) {
                    return [a + "@global", "global"]
                }
                if ("WH" === e._Market) {
                    return [a + "@fox", "fox"]
                }
                if ("NF" === e._Market) {
                    return [a + "@gn", "gn"]
                }
                if ("GZ" === e._Market) {
                    return [a + "@cff", "cff"]
                }
                if ("SB" === e._Market) {
                    return [a, "sb"]
                }
                if ("B" === e._Market) {
                    return [a, "wd"]
                }
                if ("BD" === e._Market) {
                    return /(^sz131|^sh204)\d{3}$/i.test(a) ? [a + "@rp", "bd"] : [a + "@cb", "bd"]
                }
                if ("BT" === e._Market) {
                    return [a + "@wh", "bt"]
                }
                if ("ZNB" === e._Market) {
                    return [a, "znb"]
                }
            }
        },
        addOption: function() {
            if (this._OptKey) {
                this._OptKey = !1;
                var e = this,
                l = (e._Events, e._Utils),
                n = document.getElementById("HQBox_Names_Add"),
                a = "",
                i = e.getScode(e._config.symbol)[0],
                b = (e.getScode(e._config.symbol)[1], ""),
                m = "";
                a = this._OptStatus ? (this._isOptOld, e._OptApi + "HoldV2Service.delSymbolFace?scode=" + i + "&source=wap_mzx") : (this._isOptOld, "//" + window.location.host + "/zixuan/add.php?scode=" + i + "&source=wap_mzx"),
                l.jsonp({
                    url: a,
                    jsoncallback: !0,
                    success: function(f) {
                        e._isOptOld ? e._OptStatus ? (b = "+ \u6dfb\u52a0\u81ea\u9009", e.appPopup.open("\u81ea\u9009\u80a1\u5220\u9664\u6210\u529f")) : (b = "- \u5220\u9664\u81ea\u9009", e.appPopup.open("\u81ea\u9009\u80a1\u6dfb\u52a0\u6210\u529f")) : 0 === f.status.code && (e._OptStatus ? (b = "+ \u6dfb\u52a0\u81ea\u9009", e.appPopup.open("\u81ea\u9009\u80a1\u5220\u9664\u6210\u529f")) : (b = "- \u5220\u9664\u81ea\u9009", e.appPopup.open("\u81ea\u9009\u80a1\u6dfb\u52a0\u6210\u529f"))),
                        SUDA.uaTrack("hq_center_hs", "add_stock"),
                        e._OptStatus = !e._OptStatus,
                        n.innerHTML = b,
                        e._OptKey = !0
                    }
                })
            }
        },
        appPopup: {
            create: function() {
                var a = document.body,
                b = document.createElement("div");
                b.id = "HQBox_Apppopup",
                b.className = "hqbox-apppopup",
                b.style.display = "none",
                a.appendChild(b),
                this.creatMask(),
                this.creatBox()
            },
            destory: function() {
                var a = document.body,
                b = document.getElementById("HQBox_Apppopup");
                a.removeChild(b)
            },
            open: function(b) {
                var f = document.getElementById("HQBox_Apppopup"),
                a = (document.getElementById("HQBox_Apppopup_Mask"), document.getElementById("HQBox_Apppopup_Text"));
                c.DataUtils.setInnerText(a, b),
                f.style.display = "block"
            },
            close: function() {
                document.getElementById("HQBox_Apppopup").style.display = "none"
            },
            callApp: function() {
                var a = {
                    subname: "zxg",
                    uatrackKey: "wap_hqcenter_callup",
                    needOpenSource: !1,
                    androidInstallUrl: "apo51.cn.apk"
                };
                new apiFinanceCallUp.CallUpapiFinance(a).tryDirectCall({
                    callpagetype: "10",
                    position: "zxg"
                })
            },
            creatBox: function() {
                var i = this,
                j = document.getElementById("HQBox_Apppopup"),
                a = document.createElement("div");
                a.id = "HQBox_Apppopup_Box",
                a.className = "hqbox-apppopup-box",
                j.appendChild(a);
                a.innerHTML = '<div class="hqbox-apppopup-callapp" id="HQBox_Apppopup_Callapp"><p id="HQBox_Apppopup_Text" class="hqbox-apppopup-text"></p></div><i class="hqbox-apppopup-closebtn" id="HQBox_Apppopup_CloseBtn"></i>';
                var h = document.getElementById("HQBox_Apppopup_CloseBtn"),
                b = document.getElementById("HQBox_Apppopup_Callapp");
                c.DataUtils.on(h, "click",
                function() {
                    i.close()
                }),
                c.DataUtils.on(b, "click",
                function() {
                    i.callApp()
                })
            },
            creatMask: function() {
                var a = document.getElementById("HQBox_Apppopup"),
                b = document.createElement("div");
                b.id = "HQBox_Apppopup_Mask",
                b.className = "hqbox-apppopup-mask",
                a.appendChild(b)
            }
        }
    }
} (),
function(l) {
    function o(b) {
        var d = "hqccall" + a(),
        k = document.getElementsByTagName("head")[0],
        g = document.createElement("script"),
        j = function(s) {
            var q = [];
            for (var r in s) {
                q.push(r + "=" + s[r])
            }
            return encodeURI(q.join("&"))
        } (b.data) || "",
        h = b.success,
        c = b.jsoncallback ? "&callback=" + d: "",
        f = b.url;
        g.src = f + j + c,
        g.type = "text/javascript",
        g.onload = g.onreadystatechange = function() {
            this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (c || h(), g.onload = g.onreadystatechange = null, k.removeChild(g))
        },
        k.appendChild(g),
        c && (l[d] = function(q) {
            h && h(q.result),
            delete l[d]
        })
    }
    function a() {
        return Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1)
    }
    function e(g, c, d) {
        var f, b = Array.prototype.slice.call(arguments, 3);
        return d = void 0 !== d ? d: 20,
        function() {
            c = c || this,
            clearTimeout(f),
            f = setTimeout(function() {
                clearTimeout(f),
                g.apply(c, b)
            },
            d)
        }
    }
    function n(b, c, d) {
        b && c && d && b.addEventListener(c, d, !1)
    }
    function i(b, c) {
        var d = b;
        if (d.className = " " + d.className + " ", -1 !== d.className.indexOf(" " + c + " ")) {
            return ! 1
        }
        d.className += c
    }
    function p(b, c) {
        var d = b;
        d.className = d.className.replace(c, "")
    }
    var m = l.HQ;
    m.DataSearch = function() {
        this._SNodes = {},
        this._Events = {},
        this._TypeCode = "11,12,31,32,33,41,71,73,85,86,100",
        this._href = m.DataHref,
        this._init()
    },
    m.DataSearch.prototype = {
        constructor: m.DataSearch,
        _init: function() {
            this._createSearch(),
            this._bindEvents()
        },
        _createSearch: function() {
            var b = this,
            c = document.body,
            d = this._SNodes._SBox = document.createElement("section");
            d.id = "HQ_Search",
            d.className = "hqapps-search",
            c.appendChild(d),
            b._createForm(),
            b._createList()
        },
        _createForm: function() {
            var b = this,
            c = b._SNodes._SBox,
            d = document.createElement("div");
            d.className = "hqapps-search-form",
            c.appendChild(d),
            d.innerHTML = '<div class="btn-cancel" id="HQ_Search_Canclebtn"></div><div class="search-box"><form action="" id="HQ_Search_Form"><input class="ipt-search" type="search" placeholder="\u7b80\u79f0/\u4ee3\u7801/\u62fc\u97f3" id="HQ_Search_Ipt"></form></div><div class="btn-search" id="HQ_Search_Gobtn">\u641c\u7d22</div>',
            b._SNodes._SIpt = document.getElementById("HQ_Search_Ipt"),
            b._SNodes._SForm = document.getElementById("HQ_Search_Form"),
            b._SNodes._SGobtn = document.getElementById("HQ_Search_Gobtn"),
            b._SNodes._SCanclebtn = document.getElementById("HQ_Search_Canclebtn")
        },
        _createList: function() {
            var b = this,
            c = b._SNodes._SBox,
            d = document.createElement("div");
            d.id = "HQ_Search_List",
            d.className = "hqapps-search-list",
            c.appendChild(d),
            b._SNodes._SList = document.getElementById("HQ_Search_List")
        },
        _bindEvents: function() {
            var b = this,
            c = b._SNodes,
            d = b._Events;
            d.triggerSearch = function() {
                c._SIpt.value.trim() && b._triggerSearch()
            },
            n(c._SGobtn, "click",
            function() {
                d.triggerSearch()
            }),
            n(c._SForm, "submit",
            function() {
                d.triggerSearch()
            }),
            n(c._SCanclebtn, "click",
            function() {
                b.close()
            }),
            d.realTimeSearch = function() {
                b._fetchData(this.value)
            },
            n(c._SIpt, "input", e(d.realTimeSearch, null, 100))
        },
        _triggerSearch: function() {
            var c = this,
            d = c._SNodes,
            b = "";
            d._SList.querySelectorAll(".item").length && (b = d._SList.querySelectorAll(".item")[0].getAttribute("href")),
            b && l.open(b)
        },
        _fetchData: function(b) {
            var f = this,
            d = (f._SNodes, "suggest3_" + a()),
            c = "//suggest3.api51.cn/suggest/";
            b = b.trim().toLowerCase(),
            c = c + "type=" + f._TypeCode + "&key=" + b + "&name=" + d,
            b && o({
                url: c,
                success: function() {
                    f._renderResult(l[d])
                }
            })
        },
        _renderResult: function(b) {
            var c = this,
            d = "";
            b && b.split(";").forEach(function(s, f) {
                var h, g, u, k = s.split(","),
                A = k[1],
                r = k[2],
                j = k[4];
                encodeURIComponent(name);
                if (A) {
                    switch (A) {
                    case "11":
                    case "12":
                        h = "\u6caa\u6df1",
                        g = c._href.stock + k[3];
                        break;
                    case "31":
                    case "32":
                    case "33":
                        h = "\u6e2f\u80a1",
                        g = c._href.hkstock + r;
                        break;
                    case "41":
                        h = "\u7f8e\u80a1",
                        g = c._href.usstock + r;
                        break;
                    case "71":
                        h = "\u5916\u6c47",
                        g = c._href.forex + r;
                        break;
                    case "73":
                        h = "\u65b0\u4e09\u677f",
                        g = c._href.sanban + r;
                        break;
                    case "85":
                        h = "\u5185\u76d8",
                        g = c._href.nfutures + r;
                        break;
                    case "86":
                        h = "\u5916\u76d8",
                        g = c._href.hfutures + r;
                        break;
                    case "100":
                        h = "\u5168\u7403\u6307\u6570",
                        g = c._href.znb + r;
                        break;
                    default:
                        h = "\u5176\u4ed6"
                    }
                }
                u = '<div class="stock-type">' + h + '</div><div class="name">' + j + '</div><div class="code">' + r + "</div>",
                g = g || "//stock1.api.cn/prog/wapsite/stock/v2/search.php?type=1&keyword=" + encodeName,
                d += '<a class="item" href="' + g + '">' + u + "</a>"
            }),
            c._SNodes._SList.innerHTML = d
        },
        open: function() {
            var b = this,
            c = b._SNodes;
            c._SBox && (l.scrollTo(0, 0), i(c._SBox, "hqapps-active"), c._SIpt.focus(), document.body.style.height = l.innerHeight + "px", document.body.style.overflow = "hidden")
        },
        close: function() {
            var b = this;
            p(b._SNodes._SBox, "hqapps-active"),
            b.empty(),
            document.body.style.height = "auto",
            document.body.style.overflow = "visible"
        },
        empty: function() {
            var c = this,
            b = c._SNodes;
            b._SIpt.value = "",
            b._SList.innerHTML = ""
        }
    }
} (window),
function(b) {
    b.HQ.DataUtils = {
        jsonp: function(n) {
            var p = "hqccall" + this.random(),
            i = document.getElementsByTagName("head")[0],
            m = document.createElement("script"),
            k = function(c) {
                var d = [];
                for (var e in c) {
                    d.push(e + "=" + c[e])
                }
                return encodeURI(d.join("&"))
            } (n.data) || "",
            o = n.success,
            l = n.jsoncallback ? "&callback=" + p: "",
            a = n.url;
            m.src = a + k + l,
            m.type = "text/javascript",
            m.onload = m.onreadystatechange = function() {
                this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (l || o(), m.onload = m.onreadystatechange = null, i.removeChild(m))
            },
            i.appendChild(m),
            l && (b[p] = function(c) {
                o && o(c.result),
                delete b[p]
            })
        },
        getInnerText: function(a) {
            return "String" == typeof a.textContent ? a.textContent: a.innerText
        },
        setInnerText: function(d, a) {
            "String" == typeof d.textContent ? d.textContent = a: d.innerText = a
        },
        on: function(e, f, a) {
            e && f && a && e.addEventListener(f, a, !1)
        },
        random: function() {
            return Math.floor(1234567890 * Math.random() + 1) + Math.floor(9876543210 * Math.random() + 1)
        },
        viewData: function() {
            var c = 0,
            i = 0,
            p = 0,
            a = 0,
            q = 0,
            n = 0,
            r = b,
            o = document,
            l = o.documentElement;
            return c = r.innerWidth || l.clientWidth || o.body.clientWidth || 0,
            i = r.innerHeight || l.clientHeight || o.body.clientHeight || 0,
            a = o.body.scrollTop || l.scrollTop || r.pageYOffset,
            p = o.body.scrollLeft || l.scrollLeft || r.pageXOffset,
            q = Math.max(o.body.scrollWidth, l.scrollWidth || 0),
            n = Math.max(o.body.scrollHeight, l.scrollHeight || 0, i),
            {
                scrollTop: a,
                scrollLeft: p,
                documentWidth: q,
                documentHeight: n,
                viewWidth: c,
                viewHeight: i
            }
        }
    }
} (window);