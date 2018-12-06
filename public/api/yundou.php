<?php
date_default_timezone_set("Asia/Shanghai");
//https://data.api51.cn/user/yundou/?token=


 $yundou_file_name = 'yundou.txt';
 $yd_left_time =time() - filemtime($yundou_file_name);
 if($yd_left_time>$yundou_time*60){
 $yundou = file_get_contents('http://data.api51.cn/user/yundou/?token='.$token);

 $yundou_text = date("Y-m-d H:i:s",time()).'~'.$yundou.'';
 file_put_contents($yundou_file_name, $yundou_text.PHP_EOL,FILE_APPEND);//创建文件
 }
 
	