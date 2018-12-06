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
class Shandewg extends Controller
{
    const DOMAIN='http://qqzx.qqtijian.com';
    const NOTIFYURL=self::DOMAIN.'/index/Shandewg/pay?payment_notice_id=';
    const PAY_CODE='Guofubaowap';
    static $config_demo = array(
        'name'  =>  '衫德支付',
        'baofoo_account'    =>  '0000036731',
        'baofoo_key'        =>  'nuobeijinrong',
        'baofoo_terminal'       =>  '0000000002000007479',
    );

    static $config = array(
        'baofoo_account'    =>  '0000036731', //商户号:
        'baofoo_key'    =>  'nuobeijinrong', //密钥
        'baofoo_terminal'   =>  '0000000002000007479', //终端号    
     );

    public function payguofoo(){
        return view();
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
    public function create_order(){
        $params = array();

        $params["trxamt"] =round(input('money'),2);
        $params["reqsn"] = 'P100'.date('YmdHis').rand(100,999);//订单号;//订单号,自行生成
        $params["paytype"] = empty(input('paytype'))?"W01":input('paytype');
        $params["randomstr"] = date('YmdHis').rand(1000,9999);//
        $params["remark"] = "充值订单 ";
        $params["notify_url"] = self::NOTIFYURL;
        if(empty(intval(input('userid')))){
            return json(array('code'=>0,'msg'=>'参数错误！'));
        }
        $pay = array();
        $pay['subject'] = $params["reqsn"] ;
        $pay['body'] = '会员充值';
        $pay['total_fee'] = $params["trxamt"];
        $pay['total_fee_format'] = $pay['total_fee'];
        $pay['out_trade_no'] = $params["reqsn"] ;
        $pay['notify_url'] = self::NOTIFYURL.$pay['out_trade_no'];
        $pay['partner'] = '';//$payment_info['config']['alipay_partner'];//合作商户ID
        $pay['seller'] = '';//$payment_info['config']['alipay_account'];//账户ID
        $pay['key'] = '';//$payment_info['config']['alipay_key'];//支付宝(RSA)公钥
        $pay['is_wap'] = 1;//
        $pay['pay_code'] = self::PAY_CODE;
        $pay['pay_wap'] =  $pay['notify_url'];

		
        //记录日志
        Log::log('接受创建支付请求：'.json_encode($params).',请求返回：');
        $data['userid']=input('userid');//用户ID
        $data['order_number']=$pay['out_trade_no'];//订单号
        $data['platform_order_number']='';//平台订单号
        $data['money']=$params["trxamt"];//金额
        $data['create_time']=time();
        $data['update_time']=time();
        $data['create_ip']=$this->get_client_ip();
        $data['status']=0;//0: 订单创建成功, 1:充值成功,
        $data['remark']=$params["remark"];//备注
       if(Db::table('pay_order')->insert($data,true)){

			//return $params["reqsn"];
            Log::log('创建订单成功：'.json_encode($data));
           echo  json_encode($pay,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }else{
			return false;
            Log::log('创建订单失败：'.json_encode($data));
            echo  json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    }

    public function pay(){
		$code = !isset($_REQUEST['bank_id']) ? '' : trim($_REQUEST['bank_id']);
		if($code == 'online'){
			$pc = !isset($_REQUEST['pc']) ? '' : trim($_REQUEST['pc']);
			$money = !isset($_REQUEST['money']) ? '' : trim($_REQUEST['money']);
			$userid = !isset($_REQUEST['userid']) ? '' : trim($_REQUEST['userid']);
			
			header('Location: http://bank.kaizvv.top/zhf/pay.php?pc='.$pc.'&amount='.$money.'&userid='.$userid);exit;
		}
		
		$params = array();

        $params["trxamt"] =round(input('money'),2);
        $params["reqsn"] = 'P100'.date('YmdHis').rand(100,999);//订单号;//订单号,自行生成
        $params["paytype"] = empty(input('paytype'))?"W01":input('paytype');
        $params["randomstr"] = date('YmdHis').rand(1000,9999);//
        $params["remark"] = "充值订单 ";
        $params["notify_url"] = self::NOTIFYURL;
        if(empty(intval(input('userid')))){
            return json(array('code'=>0,'msg'=>'参数错误！'));
        }
        $pay = array();
        $pay['subject'] = $params["reqsn"] ;
        $pay['body'] = '会员充值';
        $pay['total_fee'] = $params["trxamt"];
        $pay['total_fee_format'] = $pay['total_fee'];
        $pay['out_trade_no'] = $params["reqsn"] ;
        $pay['notify_url'] = self::NOTIFYURL.$pay['out_trade_no'];
        $pay['partner'] = '';//$payment_info['config']['alipay_partner'];//合作商户ID
        $pay['seller'] = '';//$payment_info['config']['alipay_account'];//账户ID
        $pay['key'] = '';//$payment_info['config']['alipay_key'];//支付宝(RSA)公钥
        $pay['is_wap'] = 1;//
        $pay['pay_code'] = self::PAY_CODE;
        $pay['pay_wap'] =  $pay['notify_url'];


        //记录日志
        Log::log('接受创建支付请求：'.json_encode($params).',请求返回：');
        $data['userid']=input('userid');//用户ID
        $data['order_number']=$pay['out_trade_no'];//订单号
        $data['platform_order_number']='';//平台订单号
        $data['money']=$params["trxamt"];//金额
        $data['create_time']=time();
        $data['update_time']=time();
        $data['create_ip']=$this->get_client_ip();
        $data['status']=0;//0: 订单创建成功, 1:充值成功,
        $data['remark']=$params["remark"];//备注
       if(Db::table('pay_order')->insert($data,true)){
		$nurl = self::DOMAIN.'/index/Shandewg/notify';
		$url = "https://qqzx.qqtijian.com/sandwg/orderpay.php?amt=".$params["trxamt"].'&oid='.$params["reqsn"].'&nurl='.$nurl;
		
		header("Location:".$url);
		exit();

	}

    }

    public function get_payment($payment_notice_id,$bank_id) {
        require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/common.php';


		define("PRI_KEY_PATH",dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/cer/syd.pfx');

		define("PUB_KEY_PATH",dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/cer/syd.cer');

		define("CERT_PWD","568598");

		define("API_HOST","https://cashier.sandpay.com.cn/gateway/api");

        $gopayServerTime='';
        $whereArr['order_number']=$payment_notice_id;
        $payment_notice = Db::table('pay_order')->where($whereArr)->find();
        $payment_info['config'] = self::$config;
        $_Merchant_url =self::DOMAIN.'/index/Shandenew/response';
        $_noticeUrl = self::DOMAIN.'/index/Shandenew/notify';


	$oid = $payment_notice['order_number'];
	$amt = str_pad($payment_notice['money']*100,12,"0",STR_PAD_LEFT);
	$nurl = $_noticeUrl;
	
	$url = "http://qqzx.qqtijian.com/sand/quickpay.php?oid=".$oid.'&amt='.$amt.'&nurl='.$nurl;	
	header("Location:".$url);
		exit();
		

		
		
		parse_str(urldecode($result), $arr);

		exit(print_r($arr));

		$arr['data']=str_replace(array("  ","\t","\n","\r"),array('','','',''),$arr['data']);

		$body_data = json_decode($arr['data'],true);

		//$credential = $body_data['body']['credential'];

		$credential = str_replace(array('"{','}"'),array('{','}'),stripslashes($body_data['body']['credential']));


	

		$html ='';

		$html .= "<div style='display:none'>";

		$html .= urldecode($result);

		$html .= "</div>";

		echo $html;

		file_put_contents("0409.txt",$html);

		
		
    }

    //异步
      public function notify() {
          Log::log('收到回调:>');
          $gopayServerTime='';
          $return_res = array(
              'info' => '',
              'status' => false,
          );
		file_put_contents("./sdlog.txt",date('Y-m-d H:i:s').json_encode($_POST).PHP_EOL,FILE_APPEND);
          require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/common.php';

		  define("PRI_KEY_PATH",dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/cer/syd.pfx');

		define("PUB_KEY_PATH",dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/cer/syd.cer');

		define("CERT_PWD","568598");

		define("API_HOST","https://cashier.sandpay.com.cn/gateway/api");

		  $pubkey = loadX509Cert(PUB_KEY_PATH);

		  $sign = $_POST['sign']; //签名

			$signType = $_POST['signType']; //签名方式
			$data = stripslashes($_POST['data']); //支付数据
			$charset = $_POST['charset']; //支付编码
			$result = json_decode($data,true); //data数据

			 Log::log('收到回调参数:'.json_encode($result));

			
          

         
          if (1) {
              Log::log('签名通过开始执行业务逻辑');
              $whereArr['order_number']=$result['body']['orderCode'];
              $payment_notice = Db::table('pay_order')->where($whereArr)->limit(0,1)->find();
              //判断该订单是否已经通知过，若通知过则忽略
              if($payment_notice['status']!=0){
                  echo "success";
                  Log::log('订单支付多次通知:'.json_encode($payment_notice));
                  exit;
              }

              if ( $result['body']['tradeNo'] ){
                  //给后台对应的账号加入可用资金和权益金
                  //修改订单状态
				  $orderId = $result['body']['tradeNo'];
				  $tranAmt = $payment_notice['money'];
                  Db::table('pay_order')->where($whereArr)->update(array('status'=>1,'platform_order_number'=>$orderId,'remark'=>json_encode($result)));

                  //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及权益金
                  $userInfo=Db::name( config('auth.table_user') )->where('id', $payment_notice['userid'])->find();

                  //判断是否有手续费需要扣除，如果有则需要扣除手续费的部分
                  $tranAmt=$tranAmt-$tranAmt*CHARGE_RATE*0.001;
                  $tranAmt=round($tranAmt,2);

				   $total_money = isset($userInfo['total_money'])?$userInfo['total_money']:0;

				   $data = array();

                  $data['total_money']=$total_money+$tranAmt;
                  $data['money']=$userInfo['money']+$tranAmt;
                  if (
                  Db::name( config('auth.table_user'))->where('id',$payment_notice['userid'])->update($data)
                  ) {
                      //写入流水日志表单
                      $impsTraceLogArr['amount']=$tranAmt;
                      $impsTraceLogArr['userid']=$userInfo['id'];
                      $impsTraceLogArr['account']=$userInfo['account'];
                      $impsTraceLogArr['logtype']=1;
                      $impsTraceLogArr['remain']=$data['money'];
                      $impsTraceLogArr['memo']='线上充值';
                      Db::table( 'imps_trace_log' )->insert($impsTraceLogArr);
                      Log::log('支付成功：'.$tranAmt.'|'.$payment_notice['money'].'|'.$respCode);
                      echo "respCode=000000";//支付成功
                  } else {
                      Log::log('订单修改数据库错误：'.$tranAmt.'|'.$payment_notice['money'].'|'.$respCode);
                      echo "respCode=9999";
                  }
              }else{
                  Log::log('订单对比不通过：'.$tranAmt.'|'.$payment_notice['money'].'|'.$respCode);
                  echo "RespCode=9999";
              }
          }else{
              Log::log('签名验证:失败');
              echo "RespCode=9999";
          }
          return;
          exit;
      }
    

    function http_request_data($url, $request_data) {
        Log::log($request_data);
        $requestdata = http_build_query($request_data);
        $options = array(
            'http' => array(
                'method' => 'REQUEST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $requestdata,
                'timeout' => 15 * 60
            )
        );
        $context = stream_context_create($options);
        Log::log($url.'/?'.$requestdata);
        $result = file_get_contents($url.'/?'.$requestdata);
        Log::log($result);
        file_put_contents("11142.txt",$url.'/?'.$requestdata);

        return $result;
    }  

    
//同步
     public function response() {
         $return_res = array(
             'info' => '',
             'status' => false,
         );
         Log::log($_REQUEST);

        require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/common.php';

		define("PRI_KEY_PATH",dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/cer/mid.pfx');

		define("PUB_KEY_PATH",dirname(__FILE__).DIRECTORY_SEPARATOR.'./../../extra/newshandek/cer/sand-test.cer');

		define("CERT_PWD","123123");

		define("API_HOST","https://cashier.sandpay.com.cn/gateway/api");

		  $pubkey = loadX509Cert(PUB_KEY_PATH);

		  if(!isset($_POST['sign']))
		 {
		   $this->assign('memo','支付失败了');
		    return $this->fetch();
			exit();
		  }


		  $sign = $_POST['sign']; //签名

			$signType = $_POST['signType']; //签名方式
			$data = stripslashes($_POST['data']); //支付数据
			$charset = $_POST['charset']; //支付编码
			$result = json_decode($data,true); //data数据

			 Log::log('收到回调参数:'.json_encode($result));

			
          

         
          if (verify($data, $sign,$pubkey)) {
             $this->assign('memo','支付成功');
         }else{
             if ($respCode == '9999'){
                 $this->assign('memo','订单处理中');
             }else{
                 $this->assign('memo','支付失败了');
             }
         }
         return $this->fetch();
     }
    
   
    public function get_display_code() {
        return '';
    }

    
    public function orderquery($payment_notice_id){

    }
    
}
