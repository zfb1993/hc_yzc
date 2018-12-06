$(function() {
  console.log(localStorage.id === undefined);
  console.log(window.location.href.indexOf("login") == -1);
  if (
    localStorage.id === undefined &&
    window.location.href.indexOf("login") == -1
  ) {
    console.log("go...");
    window.location.href = "/index/index/login";
    return;
  } else {
    //ajax
    if (window.location.href.indexOf("login") != -1) {
      return;
    }
    $.get(
      "/index/Api/is_relogin",
      { userid: localStorage.id, auth: localStorage.auth },
      function(data) {
        var isrelogin = false;
        if (null == data || "undefined" == typeof data || "" == data) {
          isrelogin = true;
        } else {
          if (data.code == 1) {
            isrelogin = true;
          }
        }
        if (isrelogin) {
          localStorage.clear();
          $.alert("登陆已过期，重新登陆！", function() {
            window.location.href = "/index/index/login";
          });
        }
      },
      "JSON"
    );
  }
  //@zhanglin 高亮当前选中的导航
  let myNav = $(".weui-tabbar a");
  if (myNav.length) {
    myNav.each((index, element) => {
      var locationhref = window.location.href.split("/");
      locationhref = locationhref[locationhref.length - 1];
      if (locationhref.indexOf($(element).data("nav")) != -1) {
        $(element).addClass(" weui-bar__item--on");
      }
      //console.log($(element).data("nav"));
      //console.log(locationhref);
      /*let link = $(element)
        .attr("href")
        .split("/");
      let acurl = link[3].split(".")[0];
      let locationhref = window.location.href;
      console.log(acurl, locationhref, locationhref.indexOf(acurl) != -1);
      if (locationhref.indexOf(acurl) != -1) {
        $(element).addClass(" weui-bar__item--on");
      }*/
    });
  }

  if ($("#menu")) {
    $("#menu")
      .off()
      .on("click", function() {
        fn.onpop();
      });
    //
    $("#avatar").attr("src", localStorage.avatar);
    $("#username").html(localStorage.account);
  }
  var fn = {
    onpop: function() {
      $("#full").popup();
      $("#menu").html('<i class="iconfont icon-cha"></i>');
      $("#menu")
        .off()
        .on("click", function() {
          fn.offpop();
        });
    },
    offpop: function() {
      $.closePopup();
      $("#menu").html('<i class="iconfont icon-ego-caidan"></i>');
      $("#menu")
        .off()
        .on("click", function() {
          fn.onpop();
        });
    }
  };
  $.formatNumber = function(num, precision, separator) {
    var parts;
    // 判断是否为数字
    if (!isNaN(parseFloat(num)) && isFinite(num)) {
      // 把类似 .5, 5. 之类的数据转化成0.5, 5, 为数据精度处理做准, 至于为什么
      // 不在判断中直接写 if (!isNaN(num = parseFloat(num)) && isFinite(num))
      // 是因为parseFloat有一个奇怪的精度问题, 比如 parseFloat(12312312.1234567119)
      // 的值变成了 12312312.123456713
      num = Number(num);
      // 处理小数点位数
      num = (typeof precision !== "undefined"
        ? num.toFixed(precision)
        : num
      ).toString();
      // 分离数字的小数部分和整数部分
      parts = num.split(".");
      // 整数部分加[separator]分隔, 借用一个著名的正则表达式
      parts[0] = parts[0]
        .toString()
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1" + (separator || ","));

      return parts.join(".");
    }
    return NaN;
  };
  $.isDot = function(num) {
    var result = num.toString().indexOf(".");
    if (result != -1) {
      return true;
    }
    return false;
  };

  $.bank = function(_banknumber) {
    var reg = /^(\d{4})\d+(\d{4})$/;
    _banknumber = _banknumber.replace(reg, "$1*******$2");
    return _banknumber;
  };

  $.ajaxSetup({ cache: true });
  $.formatDate = function(d) {
    //author: meizz
    var month = "" + (d.getMonth() + 1),
      day = "" + d.getDate(),
      year = d.getFullYear();
    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;
    return [year, month, day].join("-");
  };
  console.log("app.js");
  console.log(localStorage);

  //初始数据
  $("#use_money").html($.formatNumber(localStorage.money));
});
