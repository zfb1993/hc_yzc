<?php
 use think\Db;
 // 应用公共文件
 define('ALI_SMS_APPCODE','76926a3c90c3421da7066eed62ec6d5e');
 define('ALI_SMS_SKIN','18');
 define('API_URL','http://106.14.81.139:800');
 define('AUTO_OPEN_USER',1);
 define('CHARGE_RATE',4);


/**
 * 查询.
 * @function: getcofig
 * $data为字符串
 */
function getcofig($value){
    $config = \think\Cache::get('api_config_'.$value);
    if(empty($config)){
        if($value == 'WINDOWS_URL'){
            $v = 1;
        }
        $config = \think\Db::name('config')->where('uid',$v)->value('config');
        \think\Cache::set('api_config_'.$value,$config,3600);
    }
    return $config;
}
 //const API_URL='http://106.14.81.139:800';
    /**
     * 测试地址:
    http://106.14.81.139:800/testbase.html
    账户用: 1101
    交易相关: http://106.14.81.139:800/testbase.html
    管理相关: http://106.14.81.139:800/managertestbase.html
    行情相关: http://106.14.81.139:800/markettestbase.html
    账户 adminwebtest
    密码 888888
     */

 /**
 * 查询资金.
 * @function: queryFundDetail
  * $data为数组，account：账号，pwd 密码，$data['account']=$account;
  * code为1，表示正确。非1，表示错误。
  * {"code":1,"msg":"\u8bf7\u6c42\u6210\u529f","data":{"account":"1101","lz_money":1024843.39,"rj_money":0,"cj_money":0,"dj_money":20,"dj_sxf":44.28,"sxf":132.71,"pc_yk":-100,"cc_yk":-700,"money":1001726.4,"jt_qy":1024843.39,"dt_qy":1023910.68}}
  * data: 1: Account;2: 上次结算准备金;3: 入金金额 4: 出金金额,5: 冻结保证金,6: 冻结手续费,7: 手续费,8: 平仓盈亏,9: 持仓盈亏,10: 可用资金,11: 静态权益,12: 动态权益
  */

 function queryFundDetail($data)
{
    $url=API_URL.'/futuresapi/queryFundDetail';
    $res=http($url,$data,'POST');
    $resArr=json_decode($res,true);
    if(!empty($resArr) && isset($resArr['0'])){
        $returnArr['code']=1;
        $returnArr['msg']='请求成功';
        $returnDataArr['account']=$resArr['1'];
        $returnDataArr['lz_money']=$resArr['2'];
        $returnDataArr['rj_money']=$resArr['3'];
        $returnDataArr['cj_money']=$resArr['4'];
        $returnDataArr['dj_money']=$resArr['5'];
        $returnDataArr['dj_sxf']=$resArr['6'];
        $returnDataArr['sxf']=$resArr['7'];
        $returnDataArr['pc_yk']=$resArr['8'];
        $returnDataArr['cc_yk']=$resArr['9'];
        $returnDataArr['money']=$resArr['10'];
        $returnDataArr['jt_qy']=$resArr['11'];
        $returnDataArr['dt_qy']=$resArr['12'];
        $returnArr['data']=$returnDataArr;
    }else{
        $returnArr['code']=-1;
        $returnArr['msg']='请求错误';
        $returnArr['data']=array();
    }
    return $returnArr;
}

 /**
 * 2. 出入金
 * @url:/api/api/actFundTransfer
 * @API_URL:/futuresapi/actFundTransfer
 * params:	account,direction (0: 入金，1：出金),amount,transfertype(0:劣后，1：优先)
 * 第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。
 */
 function actFundTransfer($data)
{
    $url=API_URL.'/futuresapi/actFundTransfer';
    $res=http($url,$data,'POST');
    $resArr=json_decode($res,true);
    if(!empty($resArr) && isset($resArr['0'])){
        $returnArr['code']=1;
        $returnArr['msg']='请求成功';
        $returnArr['data']=$resArr;
    }else{
        $returnArr['code']=-1;
        $returnArr['msg']='请求错误';
        $returnArr['data']=array();
    }
    return $returnArr;
}

 /**
 * 3. 自适应开平市价单
 * @url:/api/api/actMarketOrderNoOffset
 * @API_URL:/futuresapi/actMarketOrderNoOffset
 * params:	account,instrument, (合约)direction (0: 买，1：卖),volume
    返回：   第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。
 */
 function actMarketOrderNoOffset($data){
     $url=API_URL.'/futuresapi/actMarketOrderNoOffset';
     $res=http($url,$data,'POST');
     $resArr=json_decode($res,true);
     if(!empty($resArr) && isset($resArr['0'])){
         $returnArr['code']=1;
         $returnArr['msg']='请求成功';
         $returnArr['data']=$resArr;
     }else{
         $returnArr['code']=-1;
         $returnArr['msg']='请求错误';
         $returnArr['data']=array();
     }
     return $returnArr;
}

     /**
     * 4. 市价单
     * @url:/api/api/actMarketOrder
     * @API_URL:/futuresapi/actMarketOrder
     * params:account,instrument, (合约)direction (0: 买，1：卖),offset (0: 开仓，1：平仓, 3: 平今),volume
          返回：   第一项	为0，表示正确。值无意义。非0，表示错误。错误时后边的值为错误信息。
     */
     function actMarketOrder($data){
         $url=API_URL.'/futuresapi/actMarketOrder';
         $res=http($url,$data,'POST');
         $resArr=json_decode($res,true);
         if(!empty($resArr) && isset($resArr['0'])){
             $returnArr['code']=1;
             $returnArr['msg']='请求成功';
             $returnArr['data']=$resArr;
         }else{
             $returnArr['code']=-1;
             $returnArr['msg']='请求错误';
             $returnArr['data']=array();
         }
         return $returnArr;
     }
    /**
     * 5. 持仓查询
     * @url:/qihuo/api/queryPositionDetail
     * @API_URL:/futuresapi/queryPositionDetail
     * params:	account,
                back:{"data":[{"1":"aa","2":"bb"......},{......}]}
     *  第一项	为0，表示正确。值为持仓信息数组。非0，表示错误。错误时后边的值为错误信息。持仓信息数组中每项值的顺序不固定。按Key值决定意义;
        1: Account;2: 合约,3: 方向;4: 开仓日期5: 手数,6: 开仓价格,7: 占用保证金
     */
   function queryPositionDetail($data){
       $url=API_URL.'/futuresapi/queryPositionDetail';
       $res=http($url,$data,'POST');
       $resArr=json_decode($res,true);
       if(!empty($resArr) && isset($resArr['0'])){
           $returnArr['code']=1;
           $returnArr['msg']='请求成功';
           $returnArr['data']=$resArr;
       }else{
           $returnArr['code']=-1;
           $returnArr['msg']='请求错误';
           $returnArr['data']=array();
       }
       return $returnArr;
   }

 /**
 * 账户密码重置
 * @url:/api/api/queryFundDetail
 * @API_URL: /managerapi/reqAccountResetPassword
 * back:{"id":"message"}id = 0： 正确。其它： 错误;
 */
 function reqAccountResetPassword()
 {
    $url=API_URL.'/managerapi/reqAccountResetPassword';
    $account=input('account');
    $password=input('password');
    $data['account']=$account;
    $data['password']=$password;
    $res=http($url,$data,'POST');
    echo $res;
 }

/**
 * 获取网站配置信息
 */
function getconf($type='0')
{
    
    $conf_value='';
    $conf_cache = \think\Cache::get('api_conf_'.$type);
    if(true){
        $conf = \think\Db::name('api_config')->where('api_type','=',$type)->where('status',1)->find();
        if(!empty($conf['api_para'])){
            $conf['api_para']=str_replace("|" , '"' ,$conf['api_para']);
        
            $conf_cache_arr=json_decode($conf['api_para'],true);

            \think\Cache::set('api_conf_'.$type,json_encode($conf_value),3600);
            return $conf_cache_arr;
        }
    }
    $conf_cache = \think\Cache::get('conf');
    $conf_cache_arr=json_decode($conf_cache,true);
    if(!empty($conf_cache_arr)){
        return $conf_cache_arr;
    }else{
        return array();
    }
}

 function aliSms($phone,$content,$code='',$skin=''){
    /**
    短信验证码
    商品购买地址： https://market.aliyun.com/products/57126001/cmapi024822.html
    String host = "https://fesms.market.alicloudapi.com"; //服务器
    String path = "/sms/"; //接口地址
     */
    //从配置表中找到对应的信息
    $config=getconf(1);
    if(empty($config) || empty($config['appcode'])) {
     return array('code'=>-2, 'msg'=>'短信配置错误！');
    }
    if(!empty($config['skin']))  $skin=$config['skin'];//模板
    $host = "https://fesms.market.alicloudapi.com";//api访问链接
    $path = "/sms/";//API访问后缀
    $method = "GET";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $config['appcode']);
    $querys = "code=".$code."&phone=".$phone."&skin=".$skin;  //参数写在这里
    $bodys = $content;
    $url = $host . $path . "?" . $querys;//url拼接
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $res=curl_exec($curl);
    $resArr=json_decode($res,true);
    if(!empty($resArr) && $resArr['Code']=="OK"){
        $result=0;
        $msg=$resArr['Message'];
    }else{
        $result=-1;
        $msg=empty($resArr['Message'])?$resArr['Message']:'短信发送失败！';
    }
    \think\log::log($res);
    return array('code'=>$result, 'msg'=>$msg);
 }

 function send_sms_new($mobile,$msg){
	//发送短信
    $post_data = array();
    $post_data['account']  = 'N665323_N4557733';
    $post_data['password'] ='oWJ5pUqLK171f7';
    $post_data['phone'] =$mobile;
	if($_SERVER['HTTP_HOST']=='www.jinqicelue.cn'){
		$sms_sign='【盈众策略】';
	}else{
		$sms_sign='【天裕财富】';
	}
    $post_data['msg']=$sms_sign.$msg;
    $url='http://smssh1.253.com/msg/send/json';
	$postFields = json_encode($post_data);
		$ch = curl_init ();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8'
			)
		);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt( $ch, CURLOPT_TIMEOUT,1);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
		$ret = curl_exec ( $ch );
        if (false == $ret) {
            $result = curl_error(  $ch);
        } else {
            $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "请求状态 ". $rsp . " " . curl_error($ch);
            } else {
                $result = json_decode($ret,true);
            }
        }
		curl_close ( $ch );
    if(isset($result['code'])&&!$result['code']){
		$array=array(
			'code'=>0,
			'msg'=>'OK'
		);
    }else{
		$array=array(
			'code'=>1,
			'msg'=>$result['errorMsg']
		);
    }
	return $array;

}


function aliSmsNotice($phone,$content,$skin=''){
    /**
    短信验证码
    商品购买地址： https://market.aliyun.com/products/57126001/cmapi024822.html
    String host = "https://fesms.market.alicloudapi.com"; //服务器
    String path = "/sms/"; //接口地址
     *   $host = "https://fesms.market.alicloudapi.com";
    $path = "/smsmsg";
    $method = "GET";
    $appcode = "你自己的AppCode";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "param=%E9%83%AD%E9%9D%96%7C12%7C5000&phone=18781183252&sign=1&skin=1002";
    $bodys = "";
    $url = $host . $path . "?" . $querys;
     */
    //从配置表中找到对应的信息
    $config=getconf(1);
    if(empty($config) || empty($config['appcode'])) {
        return array('code'=>-2, 'msg'=>'短信配置错误！');
    }
    if(empty($config['sign'])) $config['sign']= 43001;
    if(!empty($config['openRefuseSkin'])&&$skin==1)  $skin=$config['openRefuseSkin'];//开户拒绝模板
    if(!empty($config['openPassSkin'])&&$skin==2)  $skin=$config['openPassSkin'];//开户通过模板
    if(!empty($config['shiMingRefuseSkin'])&&$skin==3)  $skin=$config['shiMingRefuseSkin'];//开户通过模板
    $host = "https://fesms.market.alicloudapi.com";//api访问链接
    $path = "/smsmsg";//API访问后缀
    $method = "GET";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $config['appcode']);
    $querys = "param=".$content."&phone=".$phone."&sign=".$config['sign']."&skin=".$skin;
    $bodys = $content;
    $url = $host . $path . "?" . $querys;//url拼接
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $res=curl_exec($curl);
    $resArr=json_decode($res,true);
    if(!empty($resArr) && $resArr['Code']=="OK"){
        $result=0;
        $msg=$resArr['Message'];
    }else{
        $result=-1;
        $msg=!empty($resArr['Message'])?$resArr['Message']:'短信发送失败！'.$res;
    }
    \think\log::log($res);
    return array('code'=>$result, 'msg'=>$msg);
}

function http($url, $params = array(), $method = 'GET', $header = array(), $multi = false,$timeout=0) {
    //获取当前客户端的IP，填充到伪造到请求的IP
    $ip=get_client_ip();
    $originHeader = array(        //构造头部
        'CLIENT-IP:'.$ip,
        'X-FORWARDED-FOR:'.$ip,
    );
    if(empty($header)){
        $header=$originHeader;
    }else{
        array_merge($header,$originHeader);
    }
    $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";//模拟windows用户正常访问
    $refer='http://www.baidu.com/';//模拟来路
    $opts = array(CURLOPT_RETURNTRANSFER => 1,CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header,CURLOPT_USERAGENT=>$user_agent,CURLOPT_REFERER=>$refer);

    /* 设定超时为毫秒级别的 */
    if($timeout>0){
        /* 异步调用需要在调用的代码中加入,防止终端
           ignore_user_abort(true); // 忽略客户端断开
           set_time_limit(0);// 设置执行不超时
        */
        $opts[CURLOPT_NOSIGNAL]=1;//毫秒级别超时该参数必须
        $opts[CURLOPT_TIMEOUT_MS]=$timeout;
    }else{
        $opts[CURLOPT_TIMEOUT]=30;
    }
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)) {
        case 'GET' :
            if(!empty($params)){
                $url .=  '?' . http_build_query($params);
            }
            $opts[CURLOPT_URL] = $url;
            break;
        case 'POST' :
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_RETURNTRANSFER] = 1;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default :
            throw new \Exception('不支持的请求方式！');
    }

    /* 初始化并执行curl请求 */
    $ch = curl_init();
//	oplog('http传输数据-->'.json_encode($opts));
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    $curl_errno = curl_errno($ch);
    curl_close($ch);
    if($data === false)
    {
        if($curl_errno != 28)
        {
            //超时的处理代码
            throw new \Exception('请求发生错误：' . $error . '|'.$url);
        }
    }
    return $data;
}

// 获取客户端IP地址
function get_client_ip(){
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return trim($ip);
}

/**
 * @name 发送HTTP请求方法，目前只支持CURL发送请求
 * @param  string $url 请求URL
 * @param  array $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @param array $header
 * @param bool $multi
 * @return array $data   响应数据
 * @throws Exception
 */
function upload_file($name,$type='img'){
    $file = think\Request::instance()->file($name);
    if (!$file instanceof think\File) {
        return '';
    }
    if($type=='img' && !$file->validate(['ext'=>'jpg,jpeg,png,gif'])->check()){
        return '';
    }
    if($type=='excel' && !$file->validate(['ext'=>'xls,xlsx'])->check()){
        return '';
    }
    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
    if($info){
        return '/uploads/'.$info->getSaveName();
    }else{
        return '';
    }
}

function gbkToUtf8($origin) {
    return mb_convert_encoding($origin, 'UTF-8', 'gbk');
}

function utf8ToGbk($origin) {
    return mb_convert_encoding($origin, 'gbk','UTF-8' );
}

function json_encode_gbk($data){
    $data1 = json_encode($data);
    return mb_convert_encoding($data1, 'gbk','UTF-8' );
}

function json_decode_gbk($data){
    $data= mb_convert_encoding($data, 'UTF-8', 'gbk');
    return json_decode($data,true);

}


/**
 * PHP计算两个时间段是否有交集（边界重叠不算）
 *
 * @param string $beginTime1 开始时间1
 * @param string $endTime1 结束时间1
 * @param string $beginTime2 开始时间2
 * @param string $endTime2 结束时间2
 * @return bool
 */
function is_time_cross($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {
    $status = $beginTime2 - $beginTime1;
    if ($status > 0) {
        $status2 = $beginTime2 - $endTime1;
        if ($status2 >= 0) {
            return false;
        } else {
            return true;
        }
    } else {
        $status2 = $endTime2 - $beginTime1;
        if ($status2 > 0) {
            return true;
        } else {
            return false;
        }
    }
}
/**
 * @Mike
 * 数组排序签名，目前只支持md5和sha1加密
 * @param $params_arr array
 * @param $key_arr array 加密的key 只支持一个元数的数字,有键值的会组装成： &key=value,无键值：value
 * @param array $key_exclude  不参与加密的字段   默认：array()
 * @param string $sort        升序ASC或降序DESC 默认升序
 * @param string $sign_type   加密方式 默认:md5
 * @return string
 */
function array_sort_sign($params_arr, $key_arr = array(),$key_exclude=array(), $sort='ASC', $sign_type='md5'){
    if(empty($params_arr)){
        return false;
    }
    $array = array();
    foreach ($params_arr as $key => $value) {
        if($value !== null && !in_array($key, $key_exclude)){
            $array[$key] = $value;
        }
    }
    if(strtoupper($sort) != 'ASC'){
        krsort($array);
    }else{
        ksort($array);
    }
    $sign_str = '';
    $i = 0;
    foreach ($array as $k => $v) {
        if($i == 0){
            $sign_str .= $k.'='.$v;
        }else{
            $sign_str .= '&'.$k.'='.$v;
        }
        $i++;
    }
    $key = '';
    if(!empty($key_arr)){

        foreach($key_arr as $k1=>$v1){
            if($k1 !== 0){
                $key = '&'.$k1.'='.$v1;
            }else{
                $key = $v1;
            }
        }
    }
    $sign_str .= $key;  //加key 加密前字符串 如：app_id=229700&uid=111222&out_trade_no=2016121414153&key=1002afdsf3421523bb

    if(strtoupper($sign_type) != 'MD5'){
        $sign = Sha1($sign_str);
    }else{
        $sign = md5($sign_str);
    }
    return $sign;
}

//加密解密
/*
* $string： 明文 或 密文
* $operation：DECODE表示解密,其它表示加密
* $key： 密匙
* $expiry：密文有效期
* */
 function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
    if($operation == 'DECODE') {
        $string = str_replace('[a]','+',$string);
        $string = str_replace('[b]','&',$string);
        $string = str_replace('[c]','/',$string);
    }
    $ckey_length = 4;
    $key = md5($key ? $key : 'ypkj_encryption');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        $ustr = $keyc.str_replace('=', '', base64_encode($result));
        $ustr = str_replace('+','[a]',$ustr);
        $ustr = str_replace('&','[b]',$ustr);
        $ustr = str_replace('/','[c]',$ustr);
        return $ustr;
    }
}


//******************************************吉投资管软件**********************************************
//管理员的UserKey为6d070ade208eee3611e61daff27230fd
//测试环境的api地址为http://120.27.112.91:8082/AccMgrt.aspx
//**************************************************************************************************
define('JT_USER_KEY','c4ca4238a0b923820dcc509a6f75849b');//c4ca4238a0b923820dcc509a6f75849b;6d070ade208eee3611e61daff27230fd
define('JT_API_URL','http://39.104.88.33:8082/AccMgrt.aspx');//http://120.27.112.91:8082/AccMgrt.aspx


//根据服务器地址获取吉投密钥
/**
 * 获取网站配置信息
 */
function getJtUserKey($url='0')
{
    $conf_cache_str = \think\Cache::get('JT_USER_KEY_'.base64_encode($url));
    if(empty($conf_cache_str)){
        $conf = \think\Db::name('zg_sys')->where('server_ip','=',$url)->where('status',0)->find();
        if(!empty($conf['password'])){
            $conf_cache=authcode($conf['password'],'DECODE');
            \think\Cache::set('JT_USER_KEY_'.base64_encode($url),$conf['password'],3600);
            return $conf_cache;
        }
    }
    $conf_cache=authcode($conf_cache_str,'DECODE');
    if(!empty($conf_cache)){
        return $conf_cache;
    }else{
        return '';
    }
}
/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件开户
 * @url:/qihuo/Api/ReqCreateAccount?account=RB180
 * @params_remark:
 * @throws \Exception
@returnRes:
 */
function ReqCreateAccount($data,$url){
    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    //echo $data['Sign'];exit;
    if(empty($url)) {
        $returnArr=array('code'=>-1,'msg'=>'资管服务器 API URL 参数未配置！');
        return $returnArr;
    }

    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功返回！','ChdAccountID'=>$resArr['ChdAccountID'],
            'ChdName'=>$resArr['ChdName'],'ChdPassword'=>$resArr['ChdPassword']);
        return $returnArr;
    }else{
        $returnArr=array('code'=>-1,'msg'=>'失败！','data'=>$res);
        return $returnArr;
    }
}

/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件请求查询账户
 * @url:/qihuo/Api/ReqQryAccountInfo?account=354535295
 * @params_remark:
 * @throws \Exception
@returnRes:
 */

function ReqQryAccountInfo($data,$url){

    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功返回！','AccountID'=>$resArr['AccountID'],
            'AccountName'=>$resArr['AccountName'],'Available'=>$resArr['Available']);
        $returnArr['Balance']=$resArr['Balance'];
        $returnArr['CloseProfit']=$resArr['CloseProfit'];
        $returnArr['CurrMargin']=$resArr['CurrMargin'];
        $returnArr['Deposit']=$resArr['Deposit'];
        $returnArr['FrozenMargin']=$resArr['FrozenMargin'];
        $returnArr['HighBalance']=$resArr['HighBalance'];
        $returnArr['HighDeposit']=$resArr['HighDeposit'];
        $returnArr['HighWithdraw']=$resArr['HighWithdraw'];
        $returnArr['LowAvailable']=$resArr['LowAvailable'];
        $returnArr['LowBalance']=$resArr['LowBalance'];
        $returnArr['LowDeposit']=$resArr['LowDeposit'];
        $returnArr['LowPreBalance']=$resArr['LowPreBalance'];
        $returnArr['LowWithdraw']=$resArr['LowWithdraw'];
        $returnArr['PositionProfit']=$resArr['PositionProfit'];
        $returnArr['PreBalance']=$resArr['PreBalance'];
        $returnArr['Withdraw']=$resArr['Withdraw'];
        return $returnArr;
    }else{
        $returnArr=array('code'=>-1,'msg'=>'失败！'.$res);
        return $returnArr;
    }
}


/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件请求出入金
 * @url:/qihuo/Api/ReqTransfer?account=354535295&PriorityAmount=11&BadAmount=11
 * @params_remark:
 * @throws \Exception
@returnRes:
 */
 function ReqTransfer($data,$url){
    if(empty($data['PriorityAmount'])) $data['PriorityAmount']=0;
    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    //echo $data['Sign'];exit;
    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功！');
        return $returnArr;
    }else{
        $returnArr=array('code'=>-1,'msg'=>'失败！'.$url.$res);
        return $returnArr;
    }
}

/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件请求修改子账户名称和密码
 * @url:/qihuo/Api/ReqModifyChdAccount?account=354535295&ChdPassword=11&ChdName=11
 * @params_remark:
 * @throws \Exception
@returnRes:
 */
function ReqModifyChdAccount($data,$url){
    if(empty($data['ChdPassword'])&&empty($data['ChdName'])){
        $returnArr=array('code'=>-2,'msg'=>'参数错误！');
        return $returnArr;
    }
    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    //echo $data['Sign'];exit;
    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功！');
        return $returnArr;
    }else{
        $returnArr=array('code'=>-1,'msg'=>'失败！');
        return $returnArr;
    }
}

/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件请求设置保证金手续费
 * @url:/qihuo/Api/ReqSetMarginCommission?account=100999679&Source=1122001
 * @params_remark:{"code":1,"msg":"成功！"}
 * @throws \Exception
@returnRes:
 */
function ReqSetMarginCommission($data,$url){
    if(empty($data['Source'])&&empty($data['ChdAccountID'])){
        $returnArr=array('code'=>-2,'msg'=>'参数错误！');
        return $returnArr;
    }
    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功！');
        return $returnArr;
    }else{
        $returnArr=array('code'=>-1,'msg'=>'失败！');
        return $returnArr;
    }
}

/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件请求请求设置风控参数
 * @url:ReqSetRiskControl
 * @params_remark:
 * @throws \Exception
@returnRes:
 */
function ReqSetRiskControl($data,$url){
    if(empty($data['Source']) || empty($data['ChdAccountID'])){
        $returnArr=array('code'=>-2,'msg'=>'参数错误！');
        return $returnArr;
    }
    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功！');
        return $returnArr;
    }else{

        $returnArr=array('code'=>-1,'msg'=>'失败！');
        return $returnArr;
    }
}

/**
 * @date:2017-07-20
 * @auth:willion
 * @brief:吉投资管软件请求查询交易记录
 * @url:ReqQryTradeRecords
 * @params_remark:
 * @throws \Exception
@returnRes:
 */
function ReqQryTradeRecords($data,$url){
    if(empty($data['Source'])&&empty($data['ChdAccountID'])){
        $returnArr=array('code'=>-2,'msg'=>'参数错误！');
        return $returnArr;
    }
    $data['Sign']= array_sort_sign($data,array('UserKey'=>getJtUserKey($url)),array('UserKey'));
    $res=http($url,$data,'GET');
    $resArr=json_decode($res,true);
    if(isset($resArr['ErrorID']) && $resArr['ErrorID']===0){
        $returnArr=array('code'=>1,'msg'=>'成功！','data'=>$resArr['TradeInfos']);
        return $returnArr;
    }else{
        $returnArr=array('code'=>-1,'msg'=>'失败！');
        return $returnArr;
    }
}

function oplog($Astring){
	$path = dirname($_SERVER['DOCUMENT_ROOT']);
	$path = $path."/oplog/";
	$file = $path."log".date('Ymd',time()).".txt";
	if(!is_dir($path)){	mkdir($path); }
	$is_mobile= "[手机]";
	$LogTime =$is_mobile."[".get_client_ip()."][".date('H:i:s',time())."]";
	$Astring=$Astring;
	if(!file_exists($file)){
		$logfile = fopen($file, "w") or die("Unable to open file!");
		fwrite($logfile, "$LogTime:".$Astring."\r\n");
		fclose($logfile);
	}else{
		$logfile = fopen($file, "a") or die("Unable to open file!");
		fwrite($logfile, "$LogTime:".$Astring."\r\n");
		fclose($logfile);
	}
}

function str_hide($data=array()){
	$str = $data['str'];
	$newstr = "";
	if (is_string($str)) {
		$len = strlen($str);
		for ($i = $len - 1; $i >= 0; $i --) {
			if(ord($str{$i})>160){
				$newstr .= $str{$i-1}.$str{$i};
				$i --;
			}
			else{
				$newstr.=$str{$i};
			}
		}
	}
	$str_strrev = $newstr;
	if(function_exists("mb_strlen")){
		$str_len=mb_strlen($str,'UTF-8');
		if($str_len%2==0){
			$half_len=$str_len/2;
			if($half_len%2==0){
				$half_half_len=$half_len/2;
			}else{
				$half_half_len=($half_len+1)/2;
			}
		}else{
			$half_len=($str_len+1)/2;
			if($half_len%2==0){
				$half_half_len=$half_len/2;
			}else{
				$half_half_len=($half_len+1)/2;
			}
		}
			$new_str=mb_substr($str,0,$half_half_len,'UTF-8')."****".mb_substr($str,$str_len-$half_half_len,$half_half_len,'UTF-8');
	}else{
		$new_str=$new_str;
	}
	return $new_str;
}

const API_HOST = 'http://blacklist.sdshopping.cn/user-api/blacklist';//测试地址
const PUB_KEY = '2E89419EF33F9559588A30570977A56E';//测试密钥
/**
 * 获取一个签名
 * @param  array 需要签名的数组
 * @return signature
 */
 function hc_gdy_getSignature($params)
{

    if (is_array($params)) {
        $tmp = $params;
    } else {
        $tmp = func_get_args();
    }

    $tmp["signature"] = PUB_KEY;//申请的密钥

    sort($tmp, SORT_STRING);

    return sha1(implode($tmp));
}
/**
 * PHP发送Json对象数据, 发送HTTP请求
 * @param string $url 请求地址
 * @param array $data 发送数据
 * @return String
 */
 function http_post_json($url, $data, $ispost=1){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $data );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($data){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$data );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}


function get_child_agentinfo_byid($id,$count){
	//根据父级id获得所有下面的代理信息
	if($count==count($id)){
		return $id;
	}else{
		$list=Db('agentor')->field('id')->where(['status'=>0,'pid'=>$id[$count]])->select();
		foreach ($list as  $v){
			array_push($id,$v['id']);
		}
		array_unique($id);
		$counta=$count+1;
		return get_child_agentinfo_byid($id,$counta);
	}
}