$(function() {
  if (localStorage.id) {
    /*
        <li>
            <a id="username" href="uc">--</a>
            <a onclick="$.quit();" href="">退出</a>
        </li>
        */
    var html = "<li>";
    html +=
      '<u><a id="username" href="uc">' + localStorage.user_name + "</a></u>";
    html += '<a onclick="$.quit();" href="">退出</a>';
    html += "</li>";
    $(".topNav").html(html);
  } else {
    $(".topNav").html("请登陆");
  }

  $.quit = function() {
    localStorage.clear();
    location.href = "login";
  };
});
