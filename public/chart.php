<?php
 error_reporting(0);
if($_GET['auth']==1){
echo 'var datelist="LC/AAA/fCXCw6mHbaPgkryxXv10eAJP1LW0SD39aT7+NV44Xba3PxCgTdrp5BkYVAc11hWvg0c/19UAc7jNtHQyWBAu2xmGuZI1NVAc3FepphjnTBw1X4hmGu+ypVAcvFenpBXPqCc6F4ZmGueLFwbIN8QTDXPsCc1FepphjvOoCc8FepphjvcgFO3CP00wxXXWhrkUdZrIJpw9X3ThrlEp6hlGc88Kcem0VeFpZM46VV4MrTC2KScKc811U4aLXUdlzINc9lTrwFW3T52KPj0mDueVFuUR1RtiEoCXfdgFOOSGRXnUhrXWhb0kt6Rk2pU44JV4SrTyU9wSDHPwCnXdP1FuiUM46/";var KLC_TD_SH=datelist;';
}else{
	?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta name="msapplication-tap-highlight" content="no" />
	<meta name="format-detection" content="telephone=no" />
 
	<meta name="screen-orientation" content="portrait" />
 <link rel="stylesheet" type="text/css" href="style/css/style_chart.css?hs=6.71">
 
 

	<script type="text/javascript">
	     var watermarke_data='data:image/png;base64,<?=base64_encode(file_get_contents("style/images/watermark.png"))?>';
		 (function(doc, win) {
			var MAX_WIDTH = 400.0125;
			var resizing = null;
			var dpr, rem, scale;
			var metaEl = doc.querySelector('meta[name="viewport"]');
			win.onresize = function() {
				if (resizing) {
					clearTimeout(resizing);
				}
				resizing = setTimeout(adjustBase, 100);
			};

			function adjustBase() {
				var clientWidth = doc.body.clientWidth || doc.documentElement.clientWidth;
				if (clientWidth > MAX_WIDTH) {
					clientWidth = MAX_WIDTH;
				}
				doc.querySelector('html').style['font-size'] = (clientWidth / 750) * 10000 / 16 + '%';
				resizing = null;
			}
			if (!doc.documentElement.addEventListener) return;
			doc.addEventListener('DOMContentLoaded', adjustBase, false);
		})(document, window);
	 
		var relateSymbol = '';//,b_SX5E';//相关代码
		var paperCode='<?php
			if($_GET['code']==''||$_GET['code']==null){
					echo 'sh000001';
				}else{
				$id = $_GET['code'];
					$abc=substr($id,-4);
					if(!is_numeric($abc)){
						$thr = substr($id,-3);
						$a = substr($id,0,-3);
						$a = strtoupper($a);
						$id = $a.'1'.$thr;
					}else{
						$a = substr($id,0,-4);
						$a = strtoupper($a);
						$id = $a.$abc;
					}
					echo $id;
				} ?>';
        var isIndex = '1';
			</script>

</head>


<body>
 
	<div id='hqMain'>
	
	
		 


		<!-- 行情图组件 start -->
		<section class="cn-chart">
			<div class="cn-chart-box" id="h5Chart"></div>
		</section>
		<!-- 行情图组件 end -->

 
	</div>

<!-- 
<div>
<button id="button1">不复权</button>
<button id="button2">前复权</button>
<button id="button3">后复权</button>
</div>

实时行情套件 <script type="text/javascript" charset="utf-8" src="style/js/all.js"></script>-->
	<script type="text/javascript" charset="utf-8" src="style/js/1.js"></script>
    <script type="text/javascript" src="style/js/2.js"></script>
	<script type="text/javascript" src="style/js/3.js"></script>
	<script type="text/javascript" src="style/js/4.js"></script>
	<script type="text/javascript" src="style/js/5.js"></script>
	<script type="text/javascript" src="style/js/6.js"></script>
	<script type="text/javascript" src="style/js/7.js?hs=6.67"></script>

  
	<script type="text/javascript" src="style/js/2018.js"></script>

    
	<script charset="gbk" src="style/js/2019.js?rn=1.0"></script>

 
</body>
<script>
 
          
          // window.localStorage["hqchart_type"]="0";//0不复权1后复权-1前复权
		   $("#button1").click(function(){
				window.localStorage["hqchart_type"]="0";//0不复权1后复权-1前复权
				location.reload();
			})
			$("#button2").click(function(){
				window.localStorage["hqchart_type"]="-1";//0不复权1后复权-1前复权
				location.reload();
			})
			$("#button3").click(function(){
				window.localStorage["hqchart_type"]="1";//0不复权1后复权-1前复权
				location.reload();
			});
</script>
</html>
<?php }?>