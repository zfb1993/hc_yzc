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
use app\index\model;
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';   
define('DOMAIN',$http_type.$_SERVER['HTTP_HOST']);
define('NOTIFYURL',DOMAIN.'/index/Ips/tmall_pay?payment_notice_id=');
class Ips extends Controller
{
    const PAY_CODE = 'Guofubaowap';
    static $config_demo = array(
        'name' => 'HXWAP支付',
        'baofoo_account' => '0000036731',
        'baofoo_key' => 'nuobeijinrong',
        'baofoo_terminal' => '0000000002000007479',
    );

    static $config = array(
        'baofoo_account' => '0000036731', //商户号:
        'baofoo_key' => 'nuobeijinrong', //密钥
        'baofoo_terminal' => '0000000002000007479', //终端号
    );

    public function payips()
    {

        return view();
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

    public function create_order()
    {
        $params = array();
        $params["trxamt"] = round(input('money'), 2);
        $params["reqsn"] = 'P100' . date('YmdHis') . rand(100, 999);//订单号;//订单号,自行生成
        $params["paytype"] = empty(input('paytype')) ? "W01" : input('paytype');
        $params["randomstr"] = date('YmdHis') . rand(1000, 9999);//
        $params["remark"] = "充值订单 ";
        $params["notify_url"] = NOTIFYURL;
        if (empty(intval(input('userid')))) {
            return json(array('code' => 0, 'msg' => '参数错误！'));
        }
		if ($params["trxamt"]<100) {
            return json(array('code' => 0, 'msg' => '最低充值100'));
        }
        $pay = array();
        $pay['subject'] = $params["reqsn"];
        $pay['body'] = '会员充值';
        $pay['total_fee'] = $params["trxamt"];
        $pay['total_fee_format'] = $pay['total_fee'];
        $pay['out_trade_no'] = $params["reqsn"];
        $pay['notify_url'] = NOTIFYURL . $pay['out_trade_no'];
        $pay['partner'] = '';//$payment_info['config']['alipay_partner'];//合作商户ID
        $pay['seller'] = '';//$payment_info['config']['alipay_account'];//账户ID
        $pay['key'] = '';//$payment_info['config']['alipay_key'];//支付宝(RSA)公钥
        $pay['is_wap'] = 1;//
        $pay['pay_code'] = self::PAY_CODE;
        $pay['pay_wap'] = $pay['notify_url'];
        //记录日志
        Log::log('接受创建支付请求：' . json_encode($params) . ',请求返回：');
        $data['userid'] = input('userid');//用户ID
        $data['order_number'] = $pay['out_trade_no'];//订单号
        $data['platform_order_number'] = '';//平台订单号
        $data['money'] = $params["trxamt"];//金额
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['create_ip'] = $this->get_client_ip();
        $data['status'] = 0;//0: 订单创建成功, 1:充值成功,
        $data['remark'] = $params["remark"];//备注
        if (Db::table('pay_order')->insert($data, true)) {
            Log::log('创建订单成功：' . json_encode($data));
            echo json_encode($pay, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            Log::log('创建订单失败：' . json_encode($data));
            echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return;
        exit;
    }

    public function pay()
    {

        $payment_notice_id = $_REQUEST['payment_notice_id'];

        $whereArr['order_number'] = $payment_notice_id;

        $payment_notice = Db::table('pay_order')->where($whereArr)->find();

        /* 获得订单的流水号， */

        $out_trader_no = $payment_notice['order_number'];
        $sp_billno = $out_trader_no;

        $billno = $out_trader_no;

        //订单金额(保留2位小数)
        $Amount = number_format($payment_notice['money'], 2, '.', '');

        //支付结果成功返回的商户URL
        $Merchanturl = DOMAIN . '/index/Ips/response';

        //交易返回接口加密方式
        $RetEncodeType = "17";

        //Server to Server 返回页面URL
        $ServerUrl = DOMAIN . '/index/Ips/notify';


        $parameter = array(
            "Version" => "v1.0.0",
            "MerCode" => "205598",
            "Account" => "2055980011",
            "MerCert" => "WMtsSPVZ1TvXAX3r08fDSTv7vtEALqTZVoraUhUXX9MHVTR0YwOorOMrWzVSAN6Xc0vbhC8r38aJEQHGKw6tPLDOO0vmyTBOkfnYT91HnpgLFyLeSJ6mKyRZ0lyvEUqq",
            "PostUrl" => "https://mobilegw.ips.com.cn/psfp-mgw/paymenth5.do",
            "S2Snotify_url" => $ServerUrl,
            "Return_url" => $Merchanturl,

            "CurrencyType" => "156",
            "Lang" => "GB",

            "OrderEncodeType" => "5",
            "RetType" => "1",
            "MerBillNo" => $billno,

            "Merchanturl" => $ServerUrl,

            "ServerUrl" => $ServerUrl,

            "MerName" => "湖南诺贝信息科技有限公司",
            "MsgId" => $billno,
            "PayType" => "01",
            "FailUrl" => $Merchanturl,
            "Date" => date("Ymd"),
            "ReqDate" => date("YmdHis"),
            "Amount" => $Amount,
            "Attach" => "",
            "RetEncodeType" => $RetEncodeType,
            "BillEXP" => "",
            "GoodsName" => "incharge",
            "BankCode" => "",
            "IsCredit" => "",
            "ProductType" => '',
            "UserId" => '',
            "UserRealName" => '',
            "CardInfo" => '',

        );

        //exit(print_r($parameter));


        $sHtml = $this->buildRequestForm($parameter);


        echo $sHtml;
    }

    function buildRequestForm($para_temp)
    {
        //待请求参数xml
        $para = $this->buildRequestPara($para_temp);

        $sHtml = "<form id='ipspaysubmit' name='ipspaysubmit' method='post' action='http://www.nuobei666.com/gopay.php'>";

        $sHtml .= "<input type='hidden' name='pGateWayReq' value='" . $para . "'/>";

        $sHtml = $sHtml . "<input type='submit' style='display:none;'></form>";


        //exit(print_r($sHtml));

        $sHtml = $sHtml . "<script>document.forms['ipspaysubmit'].submit();</script>";

        return $sHtml;
    }

    /**
     * 生成要请求给IPS的参数XMl
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数XMl
     */
    function buildRequestPara($para_temp)
    {
        $sReqXml = "<Ips>";
        $sReqXml .= "<GateWayReq>";
        $sReqXml .= $this->buildHead($para_temp);
        $sReqXml .= $this->buildBody($para_temp);
        $sReqXml .= "</GateWayReq>";
        $sReqXml .= "</Ips>";
        // Log::DEBUG("请求给IPS的参数XMl:" . $sReqXml);
        return $sReqXml;
    }

    /**
     * 请求报文头
     * @param   $para_temp 请求前的参数数组
     * @return 要请求的报文头
     */
    function buildHead($para_temp)
    {
        $sReqXmlHead = "<head>";
        $sReqXmlHead .= "<Version>" . $para_temp["Version"] . "</Version>";
        $sReqXmlHead .= "<MerCode>" . $para_temp["MerCode"] . "</MerCode>";
        $sReqXmlHead .= "<MerName>" . $para_temp["MerName"] . "</MerName>";
        $sReqXmlHead .= "<Account>" . $para_temp["Account"] . "</Account>";
        $sReqXmlHead .= "<MsgId>" . $para_temp["MsgId"] . "</MsgId>";
        $sReqXmlHead .= "<ReqDate>" . $para_temp["ReqDate"] . "</ReqDate>";
        $sReqXmlHead .= "<Signature>" . $this->md5Sign($this->buildBody($para_temp), $para_temp["MerCode"], $para_temp['MerCert']) . "</Signature>";
        $sReqXmlHead .= "</head>";
        return $sReqXmlHead;
    }

    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
    function buildBody($para_temp)
    {
        $sReqXmlBody = "<body>";
        $sReqXmlBody .= "<MerBillNo>" . $para_temp["MerBillNo"] . "</MerBillNo>";
        $sReqXmlBody .= "<GatewayType>" . $para_temp["PayType"] . "</GatewayType>";
        $sReqXmlBody .= "<Date>" . $para_temp["Date"] . "</Date>";
        $sReqXmlBody .= "<CurrencyType>" . $para_temp["CurrencyType"] . "</CurrencyType>";
        $sReqXmlBody .= "<Amount>" . $para_temp["Amount"] . "</Amount>";
        $sReqXmlBody .= "<Lang>" . $para_temp["Lang"] . "</Lang>";
        $sReqXmlBody .= "<Merchanturl><![CDATA[" . $para_temp["Return_url"] . "]]></Merchanturl>";
        $sReqXmlBody .= "<FailUrl><![CDATA[" . $para_temp["FailUrl"] . "]]></FailUrl>";
        $sReqXmlBody .= "<Attach><![CDATA[" . $para_temp["Attach"] . "]]></Attach>";
        $sReqXmlBody .= "<OrderEncodeType>" . $para_temp["OrderEncodeType"] . "</OrderEncodeType>";
        $sReqXmlBody .= "<RetEncodeType>" . $para_temp["RetEncodeType"] . "</RetEncodeType>";
        $sReqXmlBody .= "<RetType>" . $para_temp["RetType"] . "</RetType>";
        $sReqXmlBody .= "<ServerUrl><![CDATA[" . $para_temp["S2Snotify_url"] . "]]></ServerUrl>";
        $sReqXmlBody .= "<BillEXP>" . $para_temp["BillEXP"] . "</BillEXP>";
        $sReqXmlBody .= "<GoodsName>" . $para_temp["GoodsName"] . "</GoodsName>";
        $sReqXmlBody .= "<IsCredit>" . $para_temp["IsCredit"] . "</IsCredit>";
        $sReqXmlBody .= "<BankCode>" . $para_temp["BankCode"] . "</BankCode>";
        $sReqXmlBody .= "<ProductType>" . $para_temp["ProductType"] . "</ProductType>";
        $sReqXmlBody .= "<UserId>" . $para_temp["UserId"] . "</UserId>";
        $sReqXmlBody .= "<UserRealName>" . $para_temp["UserRealName"] . "</UserRealName>";
        $sReqXmlBody .= "<CardInfo>" . $para_temp["CardInfo"] . "</CardInfo>";
        $sReqXmlBody .= "</body>";
        return $sReqXmlBody;
    }

    function md5Sign($prestr, $merCode, $key)
    {
        $prestr = $prestr . $merCode . $key;
        return md5($prestr);
    }

    //异步
    public function notify()
    {
        Log::log('收到回调:>');
        $gopayServerTime = '';
        $return_res = array(
            'info' => '',
            'status' => false,
        );

        $paymentResult = input('paymentResult');


        Log::log('收到回调:>' . $paymentResult);

        $xmlResult = new \SimpleXMLElement($paymentResult);
        $strSignature = $xmlResult->GateWayRsp->head->Signature;

        $retEncodeType = $xmlResult->GateWayRsp->body->RetEncodeType;

        $merOrderNum = $xmlResult->GateWayRsp->body->MerBillNo;

        $strBody = $this->subStrXml("<body>", "</body>", $paymentResult);
        $rspCode = $xmlResult->GateWayRsp->head->RspCode;


        if ($rspCode == "000000") {
            if ($this->md5Verify($strBody, $strSignature, "205598", "WMtsSPVZ1TvXAX3r08fDSTv7vtEALqTZVoraUhUXX9MHVTR0YwOorOMrWzVSAN6Xc0vbhC8r38aJEQHGKw6tPLDOO0vmyTBOkfnYT91HnpgLFyLeSJ6mKyRZ0lyvEUqq")) {
                $whereArr['order_number'] = $merOrderNum;
                $payment_notice = Db::table('pay_order')->where($whereArr)->limit(0, 1)->find();
                if ($payment_notice['status'] != 1) {
                    $orderId = $merOrderNum;
                    Db::table('pay_order')->where($whereArr)->update(array('status' => 1, 'platform_order_number' => $orderId, 'remark' => '充值成功，同步资管未知'));

                    //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及同步资管账号
                    $userInfo=Db('customer')->where('id',$payment_notice['userid'])->find();
                    $tranAmt = $payment_notice['money'];
                    $tranAmt = round($tranAmt, 2);
                    //事物日志控制
                    $total_money=$tranAmt+$userInfo['total_money'];
                    $result=Db('flow_log')->insert([
                        'uid'=>$payment_notice['userid'],
                        'money'=>$tranAmt,
                        'total_money'=>$total_money,
                        'type'=>1,
                        'add_time'=>time(),
                        'memo'=>'第三方支付线上入金'.$merOrderNum
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
                            Log::log('支付成功：入金成功' . $tranAmt . '|' . $payment_notice['money'] . '|');
                            Db::table('pay_order')->where($whereArr)->update(array('sync_status' => 1, 'remark' => '充值成功，同步资管成功'));
                        }else{
                            Log::log('支付成功：入金失败，非资管入金时间' . $tranAmt . '|' . $payment_notice['money'] . '|');
                        }
                        echo "RespCode=0000";//支付成功
                    }else{
                        Log::log('订单修改数据库错误：' . $tranAmt . '|' . $payment_notice['money'] . '|');
                        echo "RespCode=9999";
                    }
                } else {
                    Log::log('订单重复通知：'  .$merOrderNum );
                    return 'success';
                }

            } else {

                Log::log('支付返回报文验签失败:>' . $paymentResult);

                return 'fail';
            }
        } else {
            return 'fail';
        }
    }


    function http_request_data($url, $request_data)
    {
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
        Log::log($url . '/?' . $requestdata);
        $result = file_get_contents($url . '/?' . $requestdata);
        Log::log($result);
        file_put_contents("11142.txt", $url . '/?' . $requestdata);

        return $result;
    }


//同步
    public function response()
    {
        $return_res = array(
            'info' => '',
            'status' => false,
        );
        Log::log($_REQUEST);

        $paymentResult = input('paymentResult');


        Log::log('收到回调:>' . $paymentResult);

        $xmlResult = new \SimpleXMLElement($paymentResult);
        $strSignature = $xmlResult->GateWayRsp->head->Signature;

        $retEncodeType = $xmlResult->GateWayRsp->body->RetEncodeType;

        $merOrderNum = $xmlResult->GateWayRsp->body->MerBillNo;

        $strBody = $this->subStrXml("<body>", "</body>", $paymentResult);
        $respCode = $xmlResult->GateWayRsp->head->RspCode;


        if ($respCode == "000000") {
            $this->assign('memo', '支付成功');
        } else {
            if ($respCode == '9999') {
                $this->assign('memo', '订单处理中');
            } else {
                $this->assign('memo', '支付失败了');
            }
        }
        return $this->fetch();
    }


    public function get_display_code()
    {
        return '';
    }


    public function orderquery($payment_notice_id)
    {

    }

    function subStrXml($begin, $end, $str)
    {
        $b = (strpos($str, $begin));
        $c = (strpos($str, $end));

        return substr($str, $b, $c - $b + 7);
    }

    function md5Verify($prestr, $sign, $merCode, $key)
    {
        $prestr = $prestr . $merCode . $key;
        $mysgin = md5($prestr);

        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
    }
	
	public function tmall_pay(){
        $payment_notice_id = $_REQUEST['payment_notice_id'];
        $whereArr['order_number'] = $payment_notice_id;
        $payment_notice = Db::table('pay_order')->where($whereArr)->find();
        /* 获得订单的流水号， */
        $out_trader_no = $payment_notice['order_number'];
        $sp_billno = $out_trader_no;
        $billno = $out_trader_no;
        //订单金额(保留2位小数)
        $Amount = number_format($payment_notice['money'], 2, '.', '');
        //支付结果成功返回的商户URL
        $Merchanturl = DOMAIN. '/index/Ips/response';
        //交易返回接口加密方式
        $RetEncodeType = "17";
        //Server to Server 返回页面URL
        $ServerUrl = DOMAIN. '/index/Ips/tmall_return';
		$is_wap=1;
		echo '<form  method="post" name="178yr_pay" id="178yr_pay" action="http://tmall.gubao888.com/index.php?m=Home&c=LogMoneys&a=hxpay"><input type="hidden" name="from_orderno"  value="'.$payment_notice_id.'"  placeholder=""/><input type="hidden" name="charge_from"  value="1qile_180803"  placeholder=""/><input type="hidden" name="InAmount"  value="'.$Amount.'"  placeholder=""/><input type="hidden" name="is_wap"  value="'.$is_wap.'"  placeholder=""/></form><script>document.forms["178yr_pay"].submit();</script>';
	}

	public function tmall_return(){
		Log::log('异步收到回调:>');
        $gopayServerTime = '';
        $return_res = array(
            'info' => '',
            'status' => false,
        );

        $paymentResult = input('post.');
		Log::log('异步收到回调:>' . json_encode($paymentResult));
		$sign_str=md5(md5($paymentResult['orderno'].$paymentResult['amount']).'47d17d263b6619862d8b53eb126cf9ce');
		if(empty($paymentResult['sign'])){
			return 'success';
		}else{
			if($paymentResult['sign']==$sign_str){
				$whereArr['order_number'] = $paymentResult['orderno'];
                $payment_notice = Db::table('pay_order')->where($whereArr)->limit(0, 1)->find();
                if ($payment_notice['status'] != 1) {
                    $orderId = $paymentResult['orderno'];
                    Db::table('pay_order')->where($whereArr)->update(array('status' => 1, 'platform_order_number' => $orderId, 'remark' => '充值成功，同步资管未知'));
                    //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及同步资管账号
                    $userInfo=Db('customer')->where('id',$payment_notice['userid'])->find();
                    $tranAmt =floatval($paymentResult["amount"]);;
                    $tranAmt = round($tranAmt, 2);
                    //事物日志控制
                    $total_money=$tranAmt+$userInfo['total_money'];
                    $result=Db('flow_log')->insert([
                        'uid'=>$payment_notice['userid'],
                        'money'=>$tranAmt,
                        'total_money'=>$total_money,
                        'type'=>1,
                        'add_time'=>time(),
                        'memo'=>'第三方支付线上入金'.$paymentResult['orderno']
                    ]);
					if($result){
						$nbeApi=new model\NbeApi();
						$dataInfo['childid']= $userInfo['zid'];
						$dataInfo['cash']= $tranAmt;
						$dataInfo['from']= 'admin input cash';
						$rec= $nbeApi->inOutCash($dataInfo);
						if($rec['code']==1){
							Db('customer')->where('id',$userInfo['id'])->setInc('available_money',$tranAmt);
							Db('customer')->where('id',$userInfo['id'])->setInc('local_money',$tranAmt);
							Db('customer')->where('id',$userInfo['id'])->setInc('total_money',$tranAmt);
							 echo "RespCode=0000";//支付成功
						}else{
							echo "RespCode=9999";
						}
					}else{
						echo "RespCode=9999";
					}
//                    if($result){
//						Db('customer')->where('id',$userInfo['id'])->setInc('available_money',$tranAmt);
//						Db('customer')->where('id',$userInfo['id'])->setInc('local_money',$tranAmt);
//						Db('customer')->where('id',$userInfo['id'])->setInc('total_money',$tranAmt);
//						Log::log('支付成功：入金成功' . $tranAmt . '|' . $tranAmt . '|');
//						Db::table('pay_order')->where($whereArr)->update(array('sync_status' => 1, 'remark' => '充值成功，同步资管成功'));
//                        echo "RespCode=0000";//支付成功
//                    }else{
//                        Log::log('订单修改数据库错误：' . $tranAmt . '|' . $tranAmt . '|');
//                        echo "RespCode=9999";
//                    }
                } else {
                    Log::log('订单重复通知：'  .$paymentResult['orderno'] );
                    return 'success';
                }
			}else{
				Log::log('支付返回报文验签失败:>' . json_encode($paymentResult));
                return 'fail';
			}
		}
	}

	public function tmall_return_sync(){
		oplog('同步回调开始');
		$return_res = array(
            'info' => '',
            'status' => false,
        );
        $paymentResult = input('post.');
		oplog('1111');
        oplog('同步回调收到参数:>' . json_encode($paymentResult));
		
		$sign_str=md5(md5($paymentResult['orderno'].$paymentResult['amount']).'47d17d263b6619862d8b53eb126cf9ce');
		if(empty($paymentResult['sign'])){
			$this->assign('memo', '支付成功');
		}else{
			if($paymentResult['sign']==$sign_str){
				$whereArr['order_number'] = $paymentResult['orderno'];
                $payment_notice = Db::table('pay_order')->where($whereArr)->limit(0, 1)->find();
                if ($payment_notice['status'] != 1) {
					oplog('同步回调:>1');
                    $orderId = $paymentResult['orderno'];
                    Db::table('pay_order')->where($whereArr)->update(array('status' => 1, 'platform_order_number' => $orderId, 'remark' => '充值成功，同步资管未知'));
                    //此处进行业务逻辑处理,给对应的账号加上订单对应可用余额及同步资管账号
                    $userInfo=Db('customer')->where('id',$payment_notice['userid'])->find();
                    $tranAmt =floatval($paymentResult["amount"]);;
                    $tranAmt = round($tranAmt, 2);
                    //事物日志控制
                    $total_money=$tranAmt+$userInfo['total_money'];
                    $result=Db('flow_log')->insert([
                        'uid'=>$payment_notice['userid'],
                        'money'=>$tranAmt,
                        'total_money'=>$total_money,
                        'type'=>1,
                        'add_time'=>time(),
                        'memo'=>'第三方支付线上入金'.$paymentResult['orderno']
                    ]);
					if($result){
						$nbeApi=new model\NbeApi();
						$dataInfo['childid']= $userInfo['zid'];
						$dataInfo['cash']= $tranAmt;
						$dataInfo['from']= 'admin input cash';
						$rec= $nbeApi->inOutCash($dataInfo);
						if($rec['code']==1){
							Db('customer')->where('id',$userInfo['id'])->setInc('available_money',$tranAmt);
							Db('customer')->where('id',$userInfo['id'])->setInc('local_money',$tranAmt);
							Db('customer')->where('id',$userInfo['id'])->setInc('total_money',$tranAmt);
							$this->assign('memo', '支付成功');
						}else{
							$this->assign('memo', '入金失败，非资管入金时间');
						}
					}else{
						$this->assign('memo', '入金失败');
					}
//                    if($result){
//						oplog('同步回调:>2');
//						oplog('同步回调:>3');
//						Db('customer')->where('id',$userInfo['id'])->setInc('available_money',$tranAmt);
//						Db('customer')->where('id',$userInfo['id'])->setInc('local_money',$tranAmt);
//						Db('customer')->where('id',$userInfo['id'])->setInc('total_money',$tranAmt);
//						Log::log('支付成功：入金成功' . $tranAmt . '|' . $tranAmt . '|');
//						Db::table('pay_order')->where($whereArr)->update(array('sync_status' => 1, 'remark' => '充值成功，同步资管成功'));
//                        $this->assign('memo', '支付成功');
//                    }else{
//						oplog('同步回调:>5');
//                        Log::log('订单修改数据库错误：' . $tranAmt . '|' . $tranAmt . '|');
//                        $this->assign('memo', '系统错误，请重试');
//                    }
                } else {
					oplog('同步回调:>6');
                    Log::log('订单重复通知：'  .$paymentResult['orderno'] );
                    $this->assign('memo', '支付成功');
                }
			}else{
				oplog('同步回调:>7');
				Log::log('支付返回报文验签失败:>' . json_encode($paymentResult));
                $this->assign('memo', '支付失败了');
			}
		}
        return $this->fetch('response');
	}

}