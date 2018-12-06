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
class Ipspc extends Controller
{
    const DOMAIN='http://www.fuqiying28.com';
    const NOTIFYURL=self::DOMAIN.'/index/Shande/pay?payment_notice_id=';
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

			return $params["reqsn"];
           // Log::log('创建订单成功：'.json_encode($data));
          //  echo  json_encode($pay,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }else{
			return false;
           // Log::log('创建订单失败：'.json_encode($data));
           // echo  json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    }

    public function pay(){

			$out_trader_no = $this->create_order();
			$bnank_id = input('bank_id');

            $payment_notice_id = $out_trader_no;

            $html = $this->get_payment($payment_notice_id,$bnank_id);
           
            echo $html;
    }

    public function get_payment($payment_notice_id,$bnank_id) {

		require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../../extra/ipspc/IpsPay.Config.php';
		require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../../extra/ipspc/lib/IpsPaySubmit.class.php';

 
        $gopayServerTime='';
        $whereArr['order_number']=$payment_notice_id;
     
        $payment_notice = Db::table('pay_order')->where($whereArr)->find();

        $payment_info['config'] = self::$config;
        $_Merchant_url = self::DOMAIN.'/index/Ipspc/response';
        $_noticeUrl = self::DOMAIN.'/index/Ipspc/notify';

		$post_data = array();


				
		// 商户订单号，商户网站订单系统中唯一订单号，必填
		$inMerBillNo = $payment_notice['order_number'];
		//支付方式 01#借记卡 02#信用卡 03#IPS账户支付
		$selPayType = "01";
		//商戶名
		$inMerName = "";
		//订单日期
		$inDate = date('Ymd');
		//订单金额
		$inAmount = sprintf("%.2f", $payment_notice['money']);;
		//支付结果失败返回的商户URL
		$inFailUrl = $_Merchant_url;
		//商户数据包
		$inAttach = "";
		//交易返回接口加密方式
		$selRetEncodeType = 17;
		//订单有效期
		$inBillEXP = 6;
		//商品名称
		$inGoodsName = $payment_notice['order_number'];
		//银行号
		$inBankCode = $bnank_id;
		//产品类型
		$selProductType = 1;
		//直连选项
		$selIsCredit = 1;

		/************************************************************/

		//构造要请求的参数数组
		$parameter = array(
			"Version"       => $ipspay_config['Version'],
			"MerCode"       => $ipspay_config['MerCode'],
			"Account"       => $ipspay_config['Account'],
			"MerCert"       => $ipspay_config['MerCert'],
			"PostUrl"       => $ipspay_config['PostUrl'],
			"S2Snotify_url"       => $_noticeUrl,//$ipspay_config['S2Snotify_url'],
			"Return_url"  => $_Merchant_url,//$ipspay_config['return_url'],
			"CurrencyType"	=> $ipspay_config['Ccy'],
			"Lang"	=> $ipspay_config['Lang'],
			"Return_url"	=> $ipspay_config['return_url'],
			"OrderEncodeType"=>$ipspay_config['OrderEncodeType'],
			"RetType"=>$ipspay_config['RetType'],
			"MerBillNo"	=> $inMerBillNo,
			"MerName"	=> $inMerName,
			"MsgId"	=> $ipspay_config['MsgId'],
			"PayType"	=> $selPayType,
			"FailUrl"   => $inFailUrl, 
			"Date"	=> $inDate, 
			"ReqDate"	=> date("YmdHis"),
			"Amount"	=> $inAmount,
			"Attach"	=> $inAttach,
			"RetEncodeType"	=> $selRetEncodeType,
			"BillEXP"	=> $inBillEXP,
			"GoodsName"	=> $inGoodsName,
			"BankCode"	=> $inBankCode,
			"IsCredit"	=> $selIsCredit,
			"ProductType"	=> $selProductType  
			
		);
		//建立请求
		$ipspaySubmit = new \IpsPaySubmit($ipspay_config);
		$html_text = $ipspaySubmit->buildRequestForm($parameter);
		echo $html_text;





		$post_data['mchNo'] = $mchNo = 'MER1000106';
		$post_data['mchType'] =$mchType = 1;
		$post_data['payChannel'] =$payChannel ="1_kykd";
		$post_data['payChannelTypeNo'] =$payChannelTypeNo = 6;
		$post_data['bankCode'] =$bankCode =$bnank_id;
		$post_data['frontUrl'] =$frontUrl = $_Merchant_url;

		$post_data['notifyUrl'] =$notifyUrl = $_noticeUrl;
		$post_data['orderNo'] =$orderNo = $payment_notice['order_number'];
		$post_data['amount'] =$amount = sprintf("%.2f", $payment_notice['money']); //round($payment_notice['money'],2);
		$post_data['goodsName'] =$goodsName ='incharge';
		$post_data['goodsDesc'] =$goodsDesc = $payment_notice['order_number'];
		$post_data['timeStamp'] =$timeStamp = time();
		
		ksort($post_data);

		$str ='';

		foreach($post_data as $key=>$v)
		{
			$str .=$key."=".$v."&";
		}

		

		$str = $str."key=846bc6277545c3b381bdfeda872ec4cb";

		//exit(print_r($str));
		$sign =md5($str) ;

		$post_data['sign'] = $sign;

       
		
		$def_url = '<form style="text-align:center;" id="frm" name="frm" action="http://cashier.xingqia.pw/gateWay/service/bankOnline/pay" style="margin:0px;padding:0px" method="POST" >';
		
        foreach ($post_data AS $key => $val) {
            $def_url .= "<input type='hidden' name='$key' value='$val' />";
        }
        //$def_url .= "<input type='submit' class='paybutton' value='前往".$this->payment_lang['baofoo_gateway_'.intval($_PayID)]."' />";
        $def_url .= "</form><script>frm.submit();</script>";

		//

        return $def_url;
    }

    //异步
      public function notify() {
          Log::log('收到回调:>');
          $gopayServerTime='';
          $return_res = array(
              'info' => '',
              'status' => false,
          );
		require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../../extra/ipspc/IpsPay.Config.php';
		require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../../extra/ipspc/lib/IpsPayNotify.class.php';

		  $ipspayNotify = new \IpsPayNotify($ipspay_config);
		  $verify_result = $ipspayNotify->verifyReturn();


          $params =  array();
          /* 取返回参数 */

		  $paymentResult = $_REQUEST['paymentResult'];
		$xmlResult = new \SimpleXMLElement($paymentResult);
		$status = $xmlResult->GateWayRsp->body->Status;


         

          $params['Status'] = $Status  = $status;

         

        
          

          Log::log('收到回调参数:'.json_encode($params));
          

         
         if ($verify_result) { // 验证成功
			$params['MerBillNo'] = $orderNo = $xmlResult->GateWayRsp->body->MerBillNo;
              Log::log('签名通过开始执行业务逻辑');
              $whereArr['order_number']=$orderNo;
              $payment_notice = Db::table('pay_order')->where($whereArr)->limit(0,1)->find();
              //判断该订单是否已经通知过，若通知过则忽略
              if($payment_notice['status']!=0){
                  echo "success";
                  Log::log('订单支付多次通知:'.json_encode($payment_notice));
                  exit;
              }

              if ( $params['Status']=='Y' ){

					 

					$params['IpsBillNo'] = $IpsTradeNo = $xmlResult->GateWayRsp->body->IpsBillNo;

					$params['Amount'] = $amount = $xmlResult->GateWayRsp->body->Amount;

                  //给后台对应的账号加入可用资金和权益金
                  //修改订单状态
        				  $orderId = $IpsTradeNo;

        				  $tranAmt = floatval($amount);
                   //Db::table('pay_order')->where($whereArr)->update(array('status'=>1,'platform_order_number'=>$IpsTradeNo,'remark'=>json_encode($params)));

                   Db::table('pay_order')->where($whereArr)->update(array('status' => 1, 'platform_order_number' => $IpsTradeNo, 'remark' => '充值成功，同步资管未知'.json_encode($params)));

                    //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及同步资管账号
                    $userInfo=Db('customer')->where('id',$payment_notice['userid'])->find();
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
                        'memo'=>'第三方支付线上入金'.$IpsTradeNo
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
                            Log::log('支付成功：入金成功' . $tranAmt . '|' . json_encode($params) . '|');
                            Db::table('pay_order')->where($whereArr)->update(array('sync_status' => 1, 'remark' => '充值成功，同步资管成功'));
                        }else{
                            Log::log('支付成功：入金失败，非资管入金时间' . $tranAmt . '|' . json_encode($params) . '|');
                        }
                        echo "RespCode=0000";//支付成功
                    }else{
                        Log::log('订单修改数据库错误：' . $tranAmt . '|' . json_encode($params) . '|');
                        echo "RespCode=9999";
                    }

              }else{
                  Log::log('订单对比不通过：'.$tranAmt.'|'.json_encode($params).'|');
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


		 require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../../extra/ipspc/IpsPay.Config.php';
		require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../../extra/ipspc/lib/IpsPayNotify.class.php';

		  $ipspayNotify = new \IpsPayNotify($ipspay_config);
		  $verify_result = $ipspayNotify->verifyReturn();


          $params =  array();
          /* 取返回参数 */

		  $paymentResult = $_REQUEST['paymentResult'];
		$xmlResult = new \SimpleXMLElement($paymentResult);
		$status = $xmlResult->GateWayRsp->body->Status;


         

          $params['Status'] = $Status  = $status;




         $respCode = $status;

         if($respCode=='Y'){
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