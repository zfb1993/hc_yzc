(function(s, f) {
    function c() {
        return Math.floor(Math.random() * 10)
    }
    var g = /apifinance/i;
    var q = g.test(navigator.userAgent);
    if (q) {
        document.querySelector(".js-app-header").remove();
        var n = document.querySelectorAll("footer");
        var b = n.length > 0;
        if (b) {
            var l = n[n.length - 1];
            if (l.getAttribute("class") !== "hq-footer") {
                l.remove()
            }
        }
        return
    }
    var e = document.querySelector(".app-footer-api");
    if (e) {
        e.src = "//n.apiimg.cn/finance/appcommonimg/V666.jpg"
    }
    var o;
    if (! (o = s.getElementById("tbanner"))) {
        return
    }
    var r = s.createElement("div"),
    h = s.createDocumentFragment();
    var k = r.cloneNode(false),
    m = r.cloneNode(false),
    d = r.cloneNode(false),
    i = r.cloneNode(false);
    var a = [k, m, d, i];
    var j = ["logo", "download", "banner-title", "banner-txt"];
    d.innerHTML = "搜索财经";
    i.innerHTML = '在 "搜索财经" APP 中查看';
    a.forEach(function(u, t) {
        u.classList.add(j[t]);
        h.appendChild(u)
    });
    o.appendChild(h);
    var p = document.getElementById("tbanner").querySelector(".logo");
    if (p) {
        p.style.backgroundImage = "url('//n.apiimg.cn/finance/appcommonimg/cjlg.png?v666')"
    }
})(document, window); (function(f, c, a) {
    return (f.isVipRetain = false);
    var e = 86400000;
    var d = {
        timeMode: true,
        countMode: false,
        maxCount: 100,
        timeRetain: 2,
        toogleMode: function() {
            this.timeMode = !this.timeMode;
            this.countMode = !this.countMode
        }
    };
    var h = "appCallerMode";
    var g = {
        chartId: ["t1", "kcl", "kd", "kw", "km"],
        handleEvent: function(j) {
            j.preventDefault();
            var i = j.target;
            var k = i.dataset.view || null;
            if (k && this.detected(k)) {
                this.recode()
            }
        },
        startup: function() {
            var i = {
                hitNum: 1,
                initTime: Date.now()
            };
            a.setItem(h, JSON.stringify(i))
        },
        isVip: function() {
            if ((this.lsData = a.getItem(h))) {
                this.lsData = JSON.parse(this.lsData);
                if (this.lsData.initTime && d.timeMode) {
                    f.isVipRetain = this.matchTimeRule(Date.now())
                } else {
                    f.isVipRetain = this.matchHitCountRule(this.lsData.hitNum)
                }
            } else {
                f.isVipRetain = true
            }
        },
        recode: function() {
            if ((this.lsData = a.getItem(h))) {
                this.lsData = JSON.parse(this.lsData);
                if (this.lsData.initTime && d.timeMode) {
                    f.isVipRetain = this.matchTimeRule(Date.now())
                } else {
                    if (this.lsData.hitNum && d.countMode) {
                        this.lsData.hitNum++;
                        a.setItem(h, JSON.stringify(this.lsData));
                        f.isVipRetain = this.matchHitCountRule(this.lsData.hitNum)
                    }
                }
            } else {
                this.startup()
            }
        },
        matchTimeRule: function(i) {
            return i - this.lsData.initTime < d.timeRetain * e
        },
        matchHitCountRule: function(i) {
            return i <= d.maxCount
        },
        detected: function(i) {
            return !! ~this.chartId.indexOf(i)
        }
    };
    g.isVip();
    var b = document.getElementById("futures_canvas");
    if (b) {
        b.addEventListener("click", g, false)
    }
})(window, document, window.localStorage);