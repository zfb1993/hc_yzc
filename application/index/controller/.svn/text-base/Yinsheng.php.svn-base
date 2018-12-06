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
class Yinsheng extends Controller
{
    const DOMAIN='https://www.xhyj18.com';
    const NOTIFYURL=self::DOMAIN.'/index/Yinsheng/pay?payment_notice_id=';
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

    public function payguofoo()
	{
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

    public function pay()
	{
		$code = !isset($_REQUEST['bank_id']) ? '' : trim($_REQUEST['bank_id']);
	
		$pc = !isset($_REQUEST['pc']) ? '' : trim($_REQUEST['pc']);
		$money = !isset($_REQUEST['money']) ? '' : trim($_REQUEST['money']);
		$userid = !isset($_REQUEST['userid']) ? '' : trim($_REQUEST['userid']);
		date_default_timezone_set("PRC");
		$key = 'ding123456';
		$data = array();
		$data['merchantId'] = '2120180522173340001';
		$data['merchantUrl'] = self::DOMAIN.'/index/Yinsheng/notify';
	
		$data['responseMode'] = '3';
		$data['orderId'] = 'P100'.date('YmdHis').rand(100,999);
		$data['currencyType'] = 'CNY';
		$data['amount'] = sprintf( "%.2f", $money );
		$data['assuredPay'] = 'false';
		$data['time'] = date("YmdHis");
		$data['remark'] = $data['orderId'];
		$data['merchantKey'] =  'ding123456';
		$data['mac'] =  $this->get_sign( $data, $key );
		$data['version'] = '3.0.0';
		$data['frontURL'] = 'http://'.$_SERVER['HTTP_HOST'].'/www/member/acccen';
		
		$url = 'https://www.unspay.com/unspay/page/linkbank/payRequest.do?'.http_build_query( $data );
		#$url = 'http://180.166.114.155/unspay/page/linkbank/payRequest.do?'.http_build_query( $data );
		$data2 = array();
		$data2['userid']=input('userid');//用户ID
        $data2['order_number']=$data['orderId'];//订单号
        $data2['platform_order_number']='';//平台订单号
        $data2['money']=$data["amount"];//金额
        $data2['create_time']=time();
        $data2['update_time']=time();
        $data2['create_ip']=$this->get_client_ip();
        $data2['status']=0;//0: 订单创建成功, 1:充值成功,
        $data2['remark']= '充值订单';//备注
        if(Db::table('pay_order')->insert($data2,true))
	    {
			header("Location: $url");
	    }
		exit;
		 

    }
	private function get_sign( $data , $key )
	{
		 
		$str = '';
		foreach( $data as $key => $val )
		{
			$str .= $key.'='.$val.'&';
		}
		$str = substr( $str, 0, strlen( $str )-1 );
		#echo $str;exit;
		return strtoupper( md5( $str ) );
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
	public function notify() 
	{	
		error_reporting(0);
		file_put_contents( dirname( __FILE__ ).'/ysb_post.txt', var_export($_POST, true), FILE_APPEND );
		file_put_contents( dirname( __FILE__ ).'/ysb_get.txt', var_export($_GET, true), FILE_APPEND );
		file_put_contents( dirname( __FILE__ ).'/ysb_input.txt', file_get_contents("php://input"), FILE_APPEND );
	 
		$key = 'ding123456';
		$str  = "merchantId=".$_POST['merchantId']."&responseMode=".$_POST['responseMode']."&orderId=".$_POST['orderId']."&currencyType=".$_POST['currencyType']."&amount=".$_POST['amount']."&returnCode=".$_POST['returnCode']."&returnMessage=".$_POST['returnMessage']."&merchantKey=".$key;
		$sign =  strtoupper(  md5( $str  ) );
		if( $sign == $_POST['mac'] )
		{
			  $orderNo = $_POST['orderId'];
              $whereArr['order_number']=$orderNo;
              $payment_notice = Db::table('pay_order')->where($whereArr)->limit(0,1)->find();
             
              if($payment_notice['status']!=0)
			  {
                  echo "SUCCESS";
                  exit;
              }

 

					 

					$IpsTradeNo = $_POST['unsTransId'];

					$amount = $_POST['amount'] ;

                  //给后台对应的账号加入可用资金和权益金
                  //修改订单状态
        		   $tranAmt = floatval($amount);
                   //Db::table('pay_order')->where($whereArr)->update(array('status'=>1,'platform_order_number'=>$IpsTradeNo,'remark'=>json_encode($params)));

                    Db::table('pay_order')->where($whereArr)->update(array('status' => 1, 'platform_order_number' => $IpsTradeNo, 'remark' => '充值成功'.json_encode($_POST)));

                    //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及同步资管账号
                    $userInfo=Db('customer')->where('id',$payment_notice['userid'])->find();
                    $tranAmt = $tranAmt - $tranAmt * CHARGE_RATE * 0.001;
                    $tranAmt = round($tranAmt, 2);
                     
                    //事物日志控制
                    $total_money=$tranAmt+$userInfo['total_money'];
                    $result=Db('flow_log')->insert( array(
                        'uid'=>$payment_notice['userid'],
                        'money'=>$tranAmt,
                        'total_money'=>$total_money,
                        'type'=>1,
                        'add_time'=>time(),
                        'memo'=>'银生宝支付线上入金'.$IpsTradeNo
                    ));

                    if($result)
					{
                        $zg=Db('zg_sys')->where('id',$userInfo['zg_id'])->find();
                        $data['UserID']=$zg['account'];
                        $data['Action']='ReqTransfer';
                        $data['ChdAccountID']=$userInfo['zid'];//用户zid
                        $data['BadAmount']=$tranAmt*100;
                        $url=$zg['server_ip'];
                        $rec= ReqTransfer($data,$url);
                        if($rec['code']==1)
						{
                            Db('customer')->where('id',$userInfo['id'])->setInc('available_money',$tranAmt);
                            Db('customer')->where('id',$userInfo['id'])->setInc('local_money',$tranAmt);
                            Db('customer')->where('id',$userInfo['id'])->setInc('total_money',$tranAmt);
                            Db::table('pay_order')->where($whereArr)->update(array('sync_status' => 1, 'remark' => '充值成功，同步资管成功'));
                        } 
                       
                    }

              
			  
		}
		exit('SUCCESS');
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
