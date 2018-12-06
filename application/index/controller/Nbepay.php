<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 16:12
 */

namespace app\index\controller;

use think\Controller;
use think\Cache;
use think\Db;
use think\Log;
use think\Request;
use think\Session;

class Nbepay extends Controller
{
    const DOMAIN = 'http://www.1qile.cn';
    const NOTIFYURL = self::DOMAIN . '/index/nbepay/notify';
    //$sdk = '1f6b681b66b2edc65d5e5a747f';
    //$key ='17ef8a2e059b9c2cf5  95fca7042eda5254256f82ff53 c651eebaa364978c1fd674f815 ';
    const ALI_SDK = '300306410a0e3d8dee7bafe22a';
    const WX_SDK = '3bae3f6883c7d4d125c3ed48da';
    const KEY ='6278062777b28d0232';//17ef8a2e059b9c2cf5

    //支付成功自动跳转地址
    const REFER_URL = self::DOMAIN.'/index/index/mine.html';

    //pc 回掉地址
    const PC_REFER_URL = self::DOMAIN.'/www/member/rizhi.html';

    //请求url
    const PAY_URL  ='http://wg.xiongdd.com'; //'https://payment.channel.ib.mk';



    /** 以下为官网演示地址参数配置 -开始  */

    const DEMO_DOMAIN = 'http://www.1qile.cn';
    const DEMO_NOTIFYURL = self::DEMO_DOMAIN . '/index/nbepay/notify';
    const DEMO_ALI_SDK = '300306410a0e3d8dee7bafe22a';
    const DEMO_WX_SDK = '3bae3f6883c7d4d125c3ed48da';
    const DEMO_KEY ='6278062777b28d0232';

    //支付成功自动跳转地址
    const DEMO_REFER_URL = 'http://www.weipay.xin';

    //请求url
    const DEMO_PAY_URL  ='http://wg.xiongdd.com'; 
  
    /** 以下为官网演示地址参数配置  -结束  */

    public function pay()
    {  
        return view();
    }



    //创建订单，跳转页面
    public function create_order()
    {
        
        $paytype=input('paytype');
        $money=floatval(input('money'));
        $userid=intval(input('userid'));
        $auth=input('auth');
        $userInfo=Db::table('yp_customer')->where('id',$userid)->find();
     
        if (empty($userid) || empty($money) || empty($paytype)) {
            return json(array('code' => 0, 'msg' => '缺少必要参数！'));
        }

        if ($userInfo['auth']!=$auth) {
          return json(array('code' => 0, 'msg' => '签名验证错误！'));
        }

        $pay = array();

        $pay['sdk'] = $paytype==2 ? self::WX_SDK : self::ALI_SDK;
        $pay['record'] = $paytype==2 ? 'W100' . date('YmdHis') . rand(100, 999) : 'A100' . date('YmdHis') . rand(100, 999) ;//订单号;//订单号,自行生成
        $pay['money'] = $money;
        $pay['notify_url'] = self::NOTIFYURL;
        $pay['refer'] = self::REFER_URL;
        $pay['type'] = '';//返回数据格式
        $pay['sign'] = $this->sign( $pay['money'], $pay['record'], $pay['sdk']);
      
        //记录日志
        Log::log('接受创建支付请求：'. json_encode($pay) . ',pay');
    
        $data['userid'] = input('userid');//用户ID
        $data['order_number'] = $pay['record'];//订单号
        $data['platform_order_number'] ='';//平台订单号
        $data['money'] = $pay['money'];//金额
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['create_ip'] = $this->get_client_ip();
        $data['status'] = 0;//0: 订单创建成功, 1:充值成功,
        $data['remark'] = '跳转充值';//备注

        if (Db::table('pay_order')->insert($data, true)) {
            Log::log('创建订单成功：' . json_encode($data));
             $resData['code']=1;
             $resData['wap_url']=self::PAY_URL.'?'.http_build_query($pay);
            return json($resData);
        } else {
             $resData['code']=-1;
             $resData['wap_url']=self::PAY_URL.http_build_query($pay);
             Log::log('创建订单失败：' . json_encode($resData));
             return json($resData);
        }

    }
    //创建订单，跳转页面,PC端
    public function create_order_go()
    {
        
        $paytype=input('paytype');
        $money=floatval(input('money'));
        $userid=intval(input('userid'));
        $auth=input('auth');
        $userInfo=Db::table('yp_customer')->where('id',$userid)->find();
     
        if (empty($userid) || empty($money) || empty($paytype)) {
            return json(array('code' => 0, 'msg' => '缺少必要参数！'));
        }

        if ($userInfo['auth']!=$auth) {
          return json(array('code' => 0, 'msg' => '签名验证错误！'));
        }

        $pay = array();

        $pay['sdk'] = $paytype==2 ? self::WX_SDK : self::ALI_SDK;
        $pay['record'] = $paytype==2 ? 'W100' . date('YmdHis') . rand(100, 999) : 'A100' . date('YmdHis') . rand(100, 999) ;//订单号;//订单号,自行生成
        $pay['money'] = $money;
        $pay['notify_url'] = self::NOTIFYURL;
        $pay['refer'] = self::PC_REFER_URL;
        $pay['type'] = '';//返回数据格式
        $pay['sign'] = $this->sign( $pay['money'], $pay['record'], $pay['sdk']);
      
        //记录日志
        Log::log('接受创建支付请求：'. json_encode($pay) . ',pay');
    
        $data['userid'] = input('userid');//用户ID
        $data['order_number'] = $pay['record'];//订单号
        $data['platform_order_number'] ='';//平台订单号
        $data['money'] = $pay['money'];//金额
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['create_ip'] = $this->get_client_ip();
        $data['status'] = 0;//0: 订单创建成功, 1:充值成功,
        $data['remark'] = '跳转充值';//备注

        if (Db::table('pay_order')->insert($data, true)) {
            Log::log('创建订单成功：' . json_encode($data));
             $resData['code']=1;
             $resData['wap_url']=self::PAY_URL.'?'.http_build_query($pay);
             $this->redirect($resData['wap_url']);
             return json($resData);
        } else {
             $resData['code']=-1;
             $resData['wap_url']=self::PAY_URL.http_build_query($pay);
             Log::log('创建订单失败：' . json_encode($resData));
             return json($resData);
        }

    }

    //创建订单，返回JSON处理
    public function create_order_json()
    {
        
        $paytype=input('paytype');
        $money=floatval(input('money'));
        $userid=intval(input('userid'));
        $auth=input('auth');
        $userInfo=Db::table('yp_customer')->where('id',$userid)->find();
     
        if (empty($userid) || empty($money) || empty($paytype)) {
            return json(array('code' => 0, 'msg' => '缺少必要参数！'));
        }

        if ($userInfo['auth']!=$auth) {
          return json(array('code' => 0, 'msg' => '签名验证错误！'));
        }

        $pay = array();
        $pay['sdk'] = self::SDK;
        $pay['record'] = 'P100' . date('YmdHis') . rand(100, 999);//订单号;//订单号,自行生成
        $pay['money'] = $money;
        $pay['notify_url'] = self::NOTIFYURL;
        $pay['refer'] = self::REFER_URL;
        $pay['type'] = 'json';//返回数据格式
        $pay['sign'] = $this->sign( $pay['money'], $pay['record'], $pay['sdk']);

         //echo  self::PAY_URL.'?'.http_build_query($pay);
      
        $res =  http(self::PAY_URL,$pay);
        //记录日志
        Log::log('接受创建支付请求：'.$res . json_encode($pay) . ',pay');
        $resArr=json_decode($res,true);
   
        if(!empty($resArr)){
            $data['userid'] = input('userid');//用户ID
            $data['order_number'] = $pay['record'];//订单号
            $data['platform_order_number'] =$resArr['data']['order_num'];//平台订单号
            $data['money'] = $resArr['data']["amount"];//金额
            $data['create_time'] = time();
            $data['update_time'] = time();
            $data['create_ip'] = $this->get_client_ip();
            $data['status'] = 0;//0: 订单创建成功, 1:充值成功,
            $data['remark'] = $resArr['data']["image"];//备注

            if (Db::table('pay_order')->insert($data, true)) {
                Log::log('创建订单成功：' . json_encode($data));
                 $data['code']=1;
                return json($data);
            } else {
                 $data['code']=-1;
                Log::log('创建订单失败：' . json_encode($data));
                return json($data);
            }
        }else{
            $pay['code']=-1;
            return json($pay);
        }
    }


     //官网演示地址创建订单，跳转页面
    public function create_order_demo()
    {
        
        $paytype=input('paytype');
        $money=floatval(input('money'));
       /* $userid=intval(input('userid'));
        $auth=input('auth');*/ 
       // $userInfo=Db::table('promotion_user')->where('id',$userid)->find();
     
        if ( empty($money) || empty($paytype)) {
            return json(array('code' => 0, 'msg' => '缺少必要参数！'));
        }

       /* if ($userInfo['auth']!=$auth) {
          return json(array('code' => 0, 'msg' => '签名验证错误！'));
        }*/

        $pay = array();

        $pay['sdk'] = $paytype==2 ? self::DEMO_WX_SDK : self::DEMO_ALI_SDK;
        $pay['record'] = $paytype==2 ? 'W100' . date('YmdHis') . rand(100, 999) : 'A100' . date('YmdHis') . rand(100, 999) ;//订单号;//订单号,自行生成
        $pay['money'] = $money;
        $pay['notify_url'] = self::DEMO_NOTIFYURL;
        $pay['refer'] = self::DEMO_REFER_URL;
        $pay['type'] = '';//返回数据格式
        $pay['sign'] = $this->sign( $pay['money'], $pay['record'], $pay['sdk']);
      
        //记录日志
        Log::log('接受创建支付请求：'. json_encode($pay) . ',pay');
    
        $data['userid'] = '100000';//用户ID
        $data['order_number'] = $pay['record'];//订单号
        $data['platform_order_number'] ='';//平台订单号
        $data['money'] = $pay['money'];//金额
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['create_ip'] = $this->get_client_ip();
        $data['status'] = 0;//0: 订单创建成功, 1:充值成功,
        $data['remark'] = '跳转充值';//备注

        if (Db::table('pay_order')->insert($data, true)) {
            Log::log('创建订单成功：' . json_encode($data));
             $resData['code']=1;
             $resData['wap_url']=self::DEMO_PAY_URL.'?'.http_build_query($pay);
             $this->redirect($resData['wap_url']);
             return json($resData);
        } else {
             $resData['code']=-1;
             $resData['wap_url']=self::DEMO_PAY_URL.http_build_query($pay);
             $this->redirect(self::DEMO_REFER_URL);
             Log::log('创建订单失败：' . json_encode($resData));
             return json($resData);
        }

    }


    // 获取客户端IP地址
    function get_client_ip()
    {
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
    * 签名算法
    * 
    * @param unknown $money
    *            交易金额
    * @param unknown $record
    *            附加参数
    * @param unknown $sdk
    *            收款账号sdk
    * @return string 返回MD5（小写）
    */
   public  function sign($money, $record, $sdk)
    {
        $sign = md5(floatval($money) . trim($record) . $sdk);
        return $sign;
    }


    //异步
    public function notify()
    {
        Log::log('收到回调:>');
        Log::log(json_encode($_REQUEST));

        //第一层验证，异步通知key
        if (sha1($_REQUEST['key']) !== sha1(self::KEY)) exit('error');

        //第二层验证，签名验证
        if(strpos($_REQUEST['record'], 'W') === 0){
            $sdk=self::WX_SDK;
        }else{
            $sdk=self::ALI_SDK;
        }

        if (sha1($_REQUEST['sign']) !== sha1( $this->sign($_REQUEST['amount'], $_REQUEST['record'], $sdk))) {
            exit('error');
            }
        $whereArr['order_number'] = $_REQUEST['record'];
       /* $whereArr['money'] = $_REQUEST['amount'];*/
        $payment_notice = Db::table('pay_order')->where($whereArr)->order('id','DESC')->limit(0, 1)->find();

        if ($payment_notice['status'] != 1) {
            $orderId = $payment_notice['order_number'];
        
             Db::table('pay_order')->where($whereArr)->update(array('status' => 1, 'platform_order_number' => $_REQUEST['order'], 'remark' => '充值成功，同步资管未知'.json_encode($_REQUEST)));

                    //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及同步资管账号
                    $userInfo=Db('customer')->where('id',$payment_notice['userid'])->find();
                    $tranAmt = $_REQUEST['money'];
                    $tranAmt = $tranAmt - $tranAmt * CHARGE_RATE * 0.001;
                    $tranAmt = round($tranAmt, 2);

                    //事物日志控制
                    $total_money=$tranAmt+$userInfo['total_money'];
                    $result=Db('flow_log')->insert([
                        'uid'=>$payment_notice['userid'],
                        'money'=>$tranAmt,
                        'total_money'=>$total_money,
                        'type'=>1,
                        'add_time'=>time(),
                        'memo'=>'第三方支付线上入金'.$orderId 
                    ]);

                    if($result){
                        $zg=Db('zg_sys')->where('id',$userInfo['zg_id'])->find();
                        $data['UserID']=$zg['account'];
                        $data['Action']='ReqTransfer';
                        $data['ChdAccountID']=$userInfo['zid'];//用户zid
                        $data['BadAmount']=$tranAmt*100;
                        $url=$zg['server_ip'];
                        $rec= ReqTransfer($data,$url);
                        if($rec['code']==1){
                            Db('customer')->where('id',$userInfo['id'])->setInc('available_money',$tranAmt);
                            Db('customer')->where('id',$userInfo['id'])->setInc('local_money',$tranAmt);
                            Db('customer')->where('id',$userInfo['id'])->setInc('total_money',$tranAmt);
                            Log::log('支付成功：入金成功' . $tranAmt . '|' . json_encode($_REQUEST) . '|');
                            Db::table('pay_order')->where($whereArr)->update(array('sync_status' => 1, 'remark' => '充值成功，同步资管成功'));
                        }else{
                            Log::log('支付成功：入金失败，非资管入金时间' . $tranAmt . '|' . json_encode($_REQUEST) . '|');
                        }
                        return 'success';
                    }else{
                        Log::log('订单修改数据库错误：' . $tranAmt . '|' . json_encode($_REQUEST) . '|');
                       return 'fail 订单修改数据库错误：';
                    }
/*
            //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及权益金
            $userInfo = Db::name(config('auth.table_user'))->where('id', $payment_notice['userid'])->find();

            $tranAmt = $_REQUEST['money'];
            $tranAmt = $tranAmt - $tranAmt * CHARGE_RATE * 0.001;
            $tranAmt = round($tranAmt, 2);
            $data['total_money'] = $userInfo['total_money'] + $tranAmt;
            $data['money'] = $userInfo['money'] + $tranAmt;
            if (
            Db::name(config('auth.table_user'))->where('id', $payment_notice['userid'])->update($data)
            ) {
                //写入流水日志表单
                $impsTraceLogArr['amount'] = $tranAmt;
                $impsTraceLogArr['userid'] = $userInfo['id'];
                $impsTraceLogArr['account'] = $userInfo['account'];
                $impsTraceLogArr['logtype'] = 1;
                $impsTraceLogArr['remain'] = $data['money'];
                $impsTraceLogArr['memo'] = '线上充值';
                Db::table('imps_trace_log')->insert($impsTraceLogArr);
                Log::log('支付成功：'.$_REQUEST['record']  . $tranAmt . '|' . $payment_notice['money'] . '|');
                return 'success';
            } else {
                Log::log('订单修改数据库错误：'.$_REQUEST['record']  . $tranAmt . '|' . $payment_notice['money'] . '|');
                return 'fail 订单修改数据库错误：';
            }*/
        } else {
             Log::log('重复收到回掉'.$_REQUEST['record'] .'|' . $payment_notice['money'] . '|');
            return 'fail 重复收到回掉';
        }

    }

}